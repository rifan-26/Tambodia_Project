<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Media;
use App\Models\LayoutSetting;

echo "=== Layout Images Debug ===\n\n";

// Check layout images (show_on_landing = true)
$layoutImages = Media::where('show_on_landing', true)
    ->orderBy('layout_order', 'asc')
    ->get();

echo "Layout images (show_on_landing = true):\n";
foreach ($layoutImages as $img) {
    echo "- ID: {$img->id}, User: {$img->user_id}, Order: {$img->layout_order}, Name: {$img->name}\n";
}

echo "\nTotal layout images: " . $layoutImages->count() . "\n\n";

// Check layout settings
echo "=== Layout Settings ===\n";
$layoutSettings = LayoutSetting::all();
foreach ($layoutSettings as $setting) {
    echo "User: {$setting->user_id}, Description: " . substr($setting->description, 0, 50) . "...\n";
}

echo "\n=== All Media with Layout Info ===\n";
$allMedia = Media::all();
foreach ($allMedia as $media) {
    $showOnLanding = $media->show_on_landing ? 'YES' : 'NO';
    $layoutOrder = $media->layout_order ?? 'NULL';
    echo "ID: {$media->id}, User: {$media->user_id}, Show: $showOnLanding, Order: $layoutOrder, Name: {$media->name}\n";
}
