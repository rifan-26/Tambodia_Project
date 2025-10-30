#!/usr/bin/env python3
"""
Script to update landingpage.blade.php with media-renderer component
"""

import re
import shutil

# Backup file
shutil.copy('resources/views/landingpage.blade.php', 'resources/views/landingpage.blade.php.backup2')

# Read file
with open('resources/views/landingpage.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Define replacements for each item
replacements = [
    # Item 1
    (
        r'@php \$item1 = \$media->where\(\'layout_order\', 1\)->first\(\); @endphp\s+@if\(\$item1\)\s+@if\(\$item1->type === \'Gambar\'\).*?@endif\s+@endif',
        '@php $item1 = $media->where(\'layout_order\', 1)->first(); @endphp\n              <x-media-renderer :media="$item1" />'
    ),
    # Item 2
    (
        r'@php \$item2 = \$media->where\(\'layout_order\', 2\)->first\(\); @endphp\s+@if\(\$item2\)\s+@if\(\$item2->type === \'Gambar\'\).*?@endif\s+@endif',
        '@php $item2 = $media->where(\'layout_order\', 2)->first(); @endphp\n                <x-media-renderer :media="$item2" />'
    ),
    # Item 5 (layout_order 3)
    (
        r'@php \$item5 = \$media->where\(\'layout_order\', 3\)->first\(\); @endphp\s+@if\(\$item5\)\s+@if\(\$item5->type === \'Gambar\'\).*?@endif\s+@endif',
        '@php $item5 = $media->where(\'layout_order\', 3)->first(); @endphp\n                <x-media-renderer :media="$item5" />'
    ),
    # Item 6 (layout_order 4)
    (
        r'@php \$item6 = \$media->where\(\'layout_order\', 4\)->first\(\); @endphp\s+@if\(\$item6\)\s+@if\(\$item6->type === \'Gambar\'\).*?@endif\s+@endif',
        '@php $item6 = $media->where(\'layout_order\', 4)->first(); @endphp\n                <x-media-renderer :media="$item6" />'
    ),
    # Item 3 (layout_order 5)
    (
        r'@php \$item3 = \$media->where\(\'layout_order\', 5\)->first\(\); @endphp\s+@if\(\$item3\)\s+@if\(\$item3->type === \'Gambar\'\).*?@endif\s+@endif',
        '@php $item3 = $media->where(\'layout_order\', 5)->first(); @endphp\n                <x-media-renderer :media="$item3" />'
    ),
    # Item 4 (layout_order 6)
    (
        r'@php \$item4 = \$media->where\(\'layout_order\', 6\)->first\(\); @endphp\s+@if\(\$item4\)\s+@if\(\$item4->type === \'Gambar\'\).*?@endif\s+@endif',
        '@php $item4 = $media->where(\'layout_order\', 6)->first(); @endphp\n                <x-media-renderer :media="$item4" />'
    ),
]

# Apply replacements
count = 0
for pattern, replacement in replacements:
    new_content, n = re.subn(pattern, replacement, content, flags=re.DOTALL)
    if n > 0:
        content = new_content
        count += n
        print(f"✅ Replaced {n} occurrence(s)")

# Save file
with open('resources/views/landingpage.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print(f"\n✅ Total replacements: {count}")
print("📁 Backup saved to: landingpage.blade.php.backup2")
