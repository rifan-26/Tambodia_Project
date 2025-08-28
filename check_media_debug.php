<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Media;
use App\Models\User;

echo "=== Media Debug Check ===\n\n";

// Check total media count
$totalMedia = Media::count();
echo "Total media in database: $totalMedia\n\n";

// Check users
$users = User::all();
echo "Users in database:\n";
foreach ($users as $user) {
    $mediaCount = Media::where('user_id', $user->id)->count();
    $imageCount = Media::where('user_id', $user->id)->where('type', 'Gambar')->count();
    echo "- User ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Media: $mediaCount, Images: $imageCount\n";
}

echo "\n=== All Media Details ===\n";
$allMedia = Media::all();
foreach ($allMedia as $media) {
    echo "ID: {$media->id}, User: {$media->user_id}, Type: {$media->type}, Name: {$media->name}, Path: {$media->file_path}\n";
}

echo "\n=== File Existence Check ===\n";
foreach ($allMedia as $media) {
    $fullPath = storage_path('app/public/' . $media->file_path);
    $exists = file_exists($fullPath) ? 'EXISTS' : 'MISSING';
    echo "File: {$media->file_path} -> $exists\n";
}
