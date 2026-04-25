import re
import os

log_file = r'C:\Users\John Carry\.gemini\antigravity\brain\a7190b18-1ee7-4155-88cf-a896a9d74693\.system_generated\logs\overview.txt'
if not os.path.exists(log_file):
    print("Log file not found at:", log_file)
    exit(1)

with open(log_file, 'r', encoding='utf-8') as f:
    text = f.read()

blocks = re.findall(r'Showing lines (\d+) to (\d+)\n.*?\n((?:\d+: .*?\n)+)', text, re.DOTALL)

lines_dict = {}
for start, end, block in blocks:
    for line in block.strip().split('\n'):
        if ': ' in line:
            num_str, content = line.split(': ', 1)
            num = int(num_str)
            lines_dict[num] = content

if lines_dict:
    max_num = max(lines_dict.keys())
    # Add the missing closing div between 158 and 160
    # Wait, the lines_dict contains the ORIGINAL lines, which were buggy.
    # We will just write them out exactly to restore the 411-line file, then we can patch it using replace_file_content.
    with open('resources/views/dashboard_admin.blade.php', 'w', encoding='utf-8') as f:
        for i in range(1, max_num + 1):
            f.write(lines_dict.get(i, '') + '\n')
    print(f'Recovered {max_num} lines!')
else:
    print('Failed to find blocks in the log.')
