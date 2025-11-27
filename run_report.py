#!/usr/bin/env python3

import argparse
import csv
import json
import os
import re
import subprocess
import sys
from concurrent.futures import ThreadPoolExecutor
from typing import Dict, List, Tuple
from rich.console import Console
from rich.table import Table
import locale
import pandas as pd
from datetime import datetime

locale.setlocale(locale.LC_ALL, 'ru_RU.UTF-8')

TS_PATTERN = r'ts[:}\s]*([\d,\.]+(?:E[+-]\d+)?)'
MEMORY_PATTERN = r'memory[:}\s]*([\d,\.]+(?:E[+-]\d+)?)'

class TestRunner:
    def __init__(self, target_path: str, output_csv: str = None, output_excel: str = None, output_json: str = None):
        self.target_path = target_path
        self.output_csv = output_csv
        self.output_excel = output_excel
        self.output_json = output_json
        self.console = Console()
        self.php_versions = [
            ('7.4', 'my-php7_4-container'),
            ('8.0', 'my-php8_0-container'),
            ('8.1.25', 'my-php8_1-container'),
            ('8.2.12', 'my-php8_2-container'),
            ('8.3', 'my-php8_3-container'),
            ('8.4', 'my-php8_4-container'),
            ('8.5', 'my-php8_5-container')
        ]
        self.check_containers()

    def check_containers(self):
        try:
            result = subprocess.run(['docker', 'ps', '--format', '{{.Names}}'],
                                  check=True, capture_output=True, text=True)
            running_containers = result.stdout.strip().split('\n')
            
            for _, container in self.php_versions:
                if container not in running_containers:
                    self.console.print(f"[red]Error: Container {container} is not running. Please start it first.[/red]")
                    sys.exit(1)
                    
        except subprocess.CalledProcessError as e:
            self.console.print(f"[red]Error checking Docker containers: {e}[/red]")
            sys.exit(1)

    def get_test_files(self) -> Dict[str, List[str]]:
        if os.path.isfile(self.target_path):
            return {os.path.dirname(self.target_path): [self.target_path]}
        
        grouped_files = {}
        for root, _, files in os.walk(self.target_path):
            php_files = [os.path.join(root, file) for file in files if file.endswith('.php')]
            if php_files:
                grouped_files[root] = php_files
        return grouped_files

    def run_test(self, php_version: str, container: str, test_file: str) -> Tuple[str, str]:
        try:
            rel_path = os.path.relpath(test_file, 'tests')
            container_path = f"/var/www/html/tests/{rel_path}"
            
            result = subprocess.run(['docker', 'exec', container, 'php', container_path],
                                  check=True, capture_output=True, text=True)
            
            ts_match = re.search(TS_PATTERN, result.stdout)
            memory_match = re.search(MEMORY_PATTERN, result.stdout)
            
            ts = ts_match.group(1) if ts_match else None
            memory = memory_match.group(1) if memory_match else None
            
            if ts is None and memory is None:
                self.console.print(f"[yellow]Raw output from test {test_file} (PHP {php_version}):[/yellow]\n{result.stdout}")
            
            return ts, memory
            
        except subprocess.CalledProcessError as e:
            self.console.print(f"[red]Error running test {test_file} in PHP {php_version}:[/red]")
            self.console.print(f"[red]Command: {' '.join(e.cmd)}[/red]")
            if e.stdout:
                self.console.print(f"[yellow]Output:[/yellow]\n{e.stdout}")
            if e.stderr:
                self.console.print(f"[red]Error:[/red]\n{e.stderr}")
            return None, None
        except Exception as e:
            self.console.print(f"[red]Unexpected error running test {test_file} in PHP {php_version}:[/red]")
            self.console.print(f"[red]Error details: {str(e)}[/red]")
            return None, None

    def run_all_tests(self) -> Dict[str, Dict[str, Dict[str, Dict[str, str]]]]:
        grouped_files = self.get_test_files()
        results = {}
        
        for directory, test_files in grouped_files.items():
            directory_results = {}
            has_memory_data = False
            
            for test_file in test_files:
                test_name = os.path.basename(test_file)
                directory_results[test_name] = {'ts': {}, 'memory': {}}
                
                for php_version, container in self.php_versions:
                    ts, memory = self.run_test(php_version, container, test_file)
                    if ts is not None:
                        directory_results[test_name]['ts'][php_version] = ts
                    if memory is not None:
                        directory_results[test_name]['memory'][php_version] = memory
                        has_memory_data = True
            
            if not has_memory_data:
                for test_data in directory_results.values():
                    test_data.pop('memory', None)
            
            results[directory] = directory_results
            
            self.display_directory_results(directory, directory_results)
        
        return results

    def display_directory_results(self, directory: str, directory_results: Dict[str, Dict[str, Dict[str, str]]]):
        self.console.print(f"\n[bold cyan]Directory: {directory}[/bold cyan]")
        
        if any('ts' in test_data for test_data in directory_results.values()):
            ts_table = Table(title="Execution Time")
            ts_table.add_column("ts, sec", style="cyan")
            for php_version, _ in self.php_versions:
                ts_table.add_column(f"PHP {php_version}", justify="right")
            
            for test_name, test_data in directory_results.items():
                if 'ts' in test_data:
                    row = [test_name]
                    for php_version, _ in self.php_versions:
                        value = test_data['ts'].get(php_version, 'N/A')
                        row.append(value)
                    ts_table.add_row(*row)
            
            self.console.print(ts_table)
            self.console.print()

        if any('memory' in test_data and test_data['memory'] for test_data in directory_results.values()):
            memory_table = Table(title="Memory Usage")
            memory_table.add_column("memory, GB", style="cyan")
            for php_version, _ in self.php_versions:
                memory_table.add_column(f"PHP {php_version}", justify="right")
            
            for test_name, test_data in directory_results.items():
                if 'memory' in test_data and test_data['memory']:
                    row = [test_name]
                    for php_version, _ in self.php_versions:
                        value = test_data['memory'].get(php_version, 'N/A')
                        row.append(value)
                    memory_table.add_row(*row)
            
            self.console.print(memory_table)

    def format_number(self, value: str, precision: int = 6) -> str:
        return str(value)

    def save_results(self, results: Dict[str, Dict[str, Dict[str, Dict[str, str]]]]):
        if self.output_csv:
            self.save_to_csv(results)
        if self.output_excel:
            self.save_to_excel(results)
        if self.output_json:
            self.save_to_json(results)

    def save_to_csv(self, results: Dict[str, Dict[str, Dict[str, Dict[str, str]]]]):
        with open(self.output_csv, 'w', newline='') as f:
            writer = csv.writer(f)
            
            for directory, directory_results in results.items():
                writer.writerow([f'Directory: {directory}'])
                
                if any('ts' in test_data for test_data in directory_results.values()):
                    writer.writerow(['Test', 'Metric'] + [f"PHP {v}" for v, _ in self.php_versions])
                    for test_name, test_data in directory_results.items():
                        if 'ts' in test_data:
                            row = [test_name, 'Time (s)']
                            for php_version, _ in self.php_versions:
                                value = test_data['ts'].get(php_version, 'N/A')
                                row.append(value)
                            writer.writerow(row)
                
                if any('memory' in test_data and test_data['memory'] for test_data in directory_results.values()):
                    for test_name, test_data in directory_results.items():
                        if 'memory' in test_data and test_data['memory']:
                            row = [test_name, 'Memory (GB)']
                            for php_version, _ in self.php_versions:
                                value = test_data['memory'].get(php_version, 'N/A')
                                row.append(value)
                            writer.writerow(row)
                
                writer.writerow([])

    def save_to_excel(self, results: Dict[str, Dict[str, Dict[str, Dict[str, str]]]]):
        with pd.ExcelWriter(self.output_excel, engine='openpyxl') as writer:
            metadata = pd.DataFrame({
                'Parameter': ['Date', 'PHP Versions', 'Tests Count'],
                'Value': [
                    datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
                    ', '.join(v for v, _ in self.php_versions),
                    sum(len(directory_results) for directory_results in results.values())
                ]
            })
            metadata.to_excel(writer, sheet_name='Metadata', index=False)

            for directory, directory_results in results.items():
                sheet_name = os.path.basename(directory) or 'root'
                if len(sheet_name) > 31:
                    sheet_name = sheet_name[:31]
                
                ts_data = []
                for test_name, test_data in directory_results.items():
                    if 'ts' in test_data:
                        row = {'Test': test_name, 'Metric': 'Time (s)'}
                        for php_version, _ in self.php_versions:
                            value = test_data['ts'].get(php_version, 'N/A')
                            row[f'PHP {php_version}'] = value
                        ts_data.append(row)

                memory_data = []
                if any('memory' in test_data and test_data['memory'] for test_data in directory_results.values()):
                    for test_name, test_data in directory_results.items():
                        if 'memory' in test_data and test_data['memory']:
                            row = {'Test': test_name, 'Metric': 'Memory (GB)'}
                            for php_version, _ in self.php_versions:
                                value = test_data['memory'].get(php_version, 'N/A')
                                row[f'PHP {php_version}'] = value
                            memory_data.append(row)

                all_data = ts_data + memory_data
                
                df = pd.DataFrame(all_data)
                df.to_excel(writer, sheet_name=sheet_name, index=False)

    def save_to_json(self, results: Dict[str, Dict[str, Dict[str, Dict[str, str]]]]):
        output_data = {
            'metadata': {
                'date': datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
                'php_versions': [v for v, _ in self.php_versions],
                'tests_count': sum(len(directory_results) for directory_results in results.values())
            },
            'results': results
        }
        
        try:
            with open(self.output_json, 'w', encoding='utf-8') as f:
                json.dump(output_data, f, indent=2, ensure_ascii=False)
        except Exception as e:
            print(f"[DEBUG] Error saving to JSON: {str(e)}")
            raise

def main():
    parser = argparse.ArgumentParser(description='Run PHP performance tests across different versions')
    parser.add_argument('target_path', help='Path to PHP file or directory containing test files')
    parser.add_argument('--csv', help='Output CSV file path')
    parser.add_argument('--excel', help='Output Excel file path')
    parser.add_argument('--json', help='Output JSON file path')
    args = parser.parse_args()

    runner = TestRunner(
        target_path=args.target_path,
        output_csv=args.csv,
        output_excel=args.excel,
        output_json=args.json
    )
    results = runner.run_all_tests()
    runner.save_results(results)

if __name__ == '__main__':
    main() 