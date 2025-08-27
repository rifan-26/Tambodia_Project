<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Media;

$media = Media::all();
foreach ($media as $m) {
    $fileName = basename($m->file_path);
    $fullPath = storage_path('app/public/media/' . $fileName);
    if (file_exists($fullPath)) {
        $m->file_path = 'media/' . $fileName;
        $m->save();
        echo "Fixed: {$m->name} -> {$m->file_path}\n";
    } else {
        echo "Missing: {$m->name} -> {$fileName}\n";
    }
}
