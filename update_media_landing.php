<?php
// Simple script to update media for landing page
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Update first 6 media to show on landing page
DB::table('media')
    ->where('id', '<=', 6)
    ->update([
        'show_on_landing' => true,
        'layout_order' => DB::raw('id')
    ]);

echo "Updated " . DB::table('media')->where('show_on_landing', true)->count() . " media items\n";

// Show the updated media
$media = DB::table('media')
    ->where('show_on_landing', true)
    ->orderBy('layout_order')
    ->get(['id', 'name', 'layout_order']);

foreach ($media as $m) {
    echo "ID: {$m->id}, Name: {$m->name}, Order: {$m->layout_order}\n";
}
