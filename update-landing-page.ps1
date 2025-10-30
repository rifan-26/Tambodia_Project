# Script to update landingpage.blade.php with media-renderer component

$filePath = "resources/views/landingpage.blade.php"
$content = Get-Content $filePath -Raw

# Backup original file
Copy-Item $filePath "$filePath.backup"

# Pattern untuk setiap item (item1 sampai item6)
for ($i = 1; $i -le 6; $i++) {
    # Pattern lama yang akan diganti
    $oldPattern = "@php \`$item$i = \`$media->where\('layout_order', $i\)->first\(\); @endphp\s+@if\(\`$item$i\)\s+@if\(\`$item$i->type === 'Gambar'\)\s+<img[^>]+>\s+@elseif\(\`$item$i->type === 'Video'\)\s+<video[^>]*>.*?</video>\s+@endif\s+@endif"
    
    # Pattern baru menggunakan component
    $newPattern = "@php \`$item$i = \`$media->where('layout_order', $i)->first(); @endphp`n              <x-media-renderer :media=""`$item$i"" />"
    
    # Replace
    $content = $content -replace $oldPattern, $newPattern
}

# Save updated content
Set-Content $filePath $content -NoNewline

Write-Host "✅ Landing page updated successfully!"
Write-Host "📁 Backup saved to: $filePath.backup"
