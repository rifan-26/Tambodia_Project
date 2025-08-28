<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Media;
use App\Models\LayoutSetting;

echo "=== Landing Page Data Test ===\n\n";

// Simulate what LandingController does
$media = Media::where('show_on_landing', true)
    ->where('type', 'Gambar')
    ->orderBy('layout_order', 'asc')
    ->orderBy('created_at', 'desc')
    ->get();

$layoutImages = Media::where('show_on_landing', true)
    ->where('type', 'Gambar')
    ->whereNotNull('layout_order')
    ->orderBy('layout_order', 'asc')
    ->get();

$layoutSetting = LayoutSetting::first();
$description = $layoutSetting && $layoutSetting->description ? $layoutSetting->description : 'Default description';

echo "Media for landing page:\n";
foreach ($media as $img) {
    echo "- Order: {$img->layout_order}, Name: {$img->name}, Path: {$img->file_path}\n";
}

echo "\nLayout Images (filtered):\n";
foreach ($layoutImages as $img) {
    echo "- Order: {$img->layout_order}, Name: {$img->name}, Path: {$img->file_path}\n";
}

echo "\nDescription: " . substr($description, 0, 100) . "...\n";
echo "\nTotal layout images that should appear: " . $layoutImages->count() . "\n";
