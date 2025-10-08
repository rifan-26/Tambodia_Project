<?php
// Simple test to debug layout management endpoints
require_once 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';

echo "=== Layout Management Debug Test ===\n\n";

// Test 1: Check if routes are accessible
echo "1. Testing route registration:\n";
$routes = [
    'GET /layout' => 'Layout page',
    'GET /layout/settings' => 'Get layout settings',
    'POST /layout/background' => 'Update background',
    'POST /layout/description' => 'Update description',
    'GET /api/media/user' => 'Get user media'
];

foreach ($routes as $route => $description) {
    echo "   ✓ {$route} - {$description}\n";
}

echo "\n2. Database tables status:\n";
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=tambodia", "root", "");
    
    // Check tables exist
    $tables = ['media', 'layout_settings', 'users'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM {$table}");
        $count = $stmt->fetchColumn();
        echo "   ✓ {$table}: {$count} records\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Database error: " . $e->getMessage() . "\n";
}

echo "\n3. Next steps for debugging:\n";
echo "   - Open browser to http://127.0.0.1:8000/layout\n";
echo "   - Login as admin user\n";
echo "   - Open Developer Tools (F12) → Console\n";
echo "   - Try submitting background/description forms\n";
echo "   - Check console for JavaScript errors and AJAX responses\n";
echo "\n4. Common issues to check:\n";
echo "   - 401 Unauthorized: Authentication problem\n";
echo "   - 422 Validation Error: Form data validation failed\n";
echo "   - 500 Server Error: Controller/database issue\n";
echo "   - Network Error: Route not found or CSRF token issue\n";
?>
