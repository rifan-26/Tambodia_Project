<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Media;

echo "=== Properly Fixing Media File Paths ===\n\n";

// Manual mapping based on the database records and existing files
$corrections = [
    1 => '1756177756_RobloxScreenShot20250806_084431819.png',
    2 => '1756177795_Screenshot 2025-08-07 144433.png', 
    3 => '1756176570_RobloxScreenShot20250722_103535400.png',
    4 => '1756174676_RobloxScreenShot20250805_135838348.png',
    5 => '1756176447_RobloxScreenShot20250806_084431819.png',
    7 => '1756182309_RobloxScreenShot20250805_140205782.png',
    8 => '1756182468_Screenshot 2025-07-01 033144.png',
    9 => '1756182533_Screenshot 2025-04-18 152036.png',
    10 => '1756182678_Screenshot 2025-04-28 153554.png',
    11 => '1756182780_RobloxScreenShot20250806_131803369.png'
];

foreach ($corrections as $mediaId => $fileName) {
    $media = Media::find($mediaId);
    if ($media) {
        $newPath = "media/$fileName";
        $media->file_path = $newPath;
        $media->save();
        
        // Verify file exists
        $fullPath = storage_path('app/public/' . $fileName);
        $exists = file_exists($fullPath) ? '✓' : '✗';
        echo "$exists Updated Media ID $mediaId: {$media->name} -> $newPath\n";
    }
}

echo "\n=== Final Verification ===\n";
$allMedia = Media::where('type', 'Gambar')->get();
foreach ($allMedia as $media) {
    $fileName = str_replace('media/', '', $media->file_path);
    $fullPath = storage_path('app/public/' . $fileName);
    $exists = file_exists($fullPath) ? '✓' : '✗';
    echo "$exists ID:{$media->id} User:{$media->user_id} {$media->name} -> {$media->file_path}\n";
}
