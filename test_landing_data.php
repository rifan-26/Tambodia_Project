<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Landing Page Data ===\n\n";

// Test 1: Check media in database
$mediaCount = DB::table('media')->where('show_on_landing', true)->count();
echo "1. Media with show_on_landing=true: {$mediaCount}\n";

// Test 2: Get media details
$media = DB::table('media')
    ->where('show_on_landing', true)
    ->whereNotNull('layout_order')
    ->orderBy('layout_order')
    ->get(['id', 'name', 'type', 'layout_order', 'file_path']);

echo "\n2. Media Details:\n";
foreach ($media as $m) {
    echo "   - ID: {$m->id}, Name: {$m->name}, Type: {$m->type}, Order: {$m->layout_order}\n";
    echo "     Path: {$m->file_path}\n";
}

// Test 3: Check if files exist
echo "\n3. File Existence Check:\n";
foreach ($media as $m) {
    $fullPath = storage_path('app/public/' . $m->file_path);
    $exists = file_exists($fullPath) ? 'EXISTS' : 'NOT FOUND';
    echo "   - {$m->name}: {$exists}\n";
}

// Test 4: Check staff
$staffCount = DB::table('staff')->where('is_active', true)->count();
echo "\n4. Active Staff: {$staffCount}\n";

echo "\n=== Test Complete ===\n";
