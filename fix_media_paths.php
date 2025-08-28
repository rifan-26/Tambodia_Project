<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Media;

echo "=== Fixing Media File Paths ===\n\n";

// Get all media files from storage
$storageDir = storage_path('app/public/media');
$actualFiles = array_diff(scandir($storageDir), array('.', '..'));

echo "Files in storage:\n";
foreach ($actualFiles as $file) {
    echo "- $file\n";
}

echo "\n=== Updating Database Records ===\n";

// Get all media records
$mediaRecords = Media::all();

foreach ($mediaRecords as $media) {
    $currentPath = $media->file_path;
    $fileName = basename($currentPath);
    
    // Check if file exists with current path
    $fullPath = storage_path('app/public/' . str_replace('media/', '', $currentPath));
    
    if (file_exists($fullPath)) {
        echo "✓ File exists: {$media->name} -> $currentPath\n";
        continue;
    }
    
    // Try to find matching file in storage
    $found = false;
    foreach ($actualFiles as $actualFile) {
        if (strpos($actualFile, '.png') !== false || strpos($actualFile, '.jpg') !== false || strpos($actualFile, '.jpeg') !== false) {
            // Update the media record with correct path
            $newPath = "media/$actualFile";
            $media->file_path = $newPath;
            $media->save();
            
            echo "✓ Updated: {$media->name} -> $newPath\n";
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        echo "✗ No matching file found for: {$media->name}\n";
    }
}

echo "\n=== Verification ===\n";
$updatedMedia = Media::all();
foreach ($updatedMedia as $media) {
    $fullPath = storage_path('app/public/' . str_replace('media/', '', $media->file_path));
    $exists = file_exists($fullPath) ? '✓' : '✗';
    echo "$exists {$media->name} -> {$media->file_path}\n";
}
