<?php
// Simple test script to debug layout functionality
require_once 'vendor/autoload.php';

use Illuminate\Http\Request;

// Test if we can access the layout routes
echo "Testing Layout Management Endpoints...\n\n";

// Test 1: Check if routes exist
$routes = [
    '/layout' => 'GET',
    '/layout/settings' => 'GET', 
    '/layout/background' => 'POST',
    '/layout/description' => 'POST'
];

foreach ($routes as $route => $method) {
    echo "Route: {$method} {$route}\n";
}

echo "\n";
echo "Check browser console for JavaScript errors when testing the form.\n";
echo "Check Network tab to see if AJAX requests are being sent.\n";
?>
