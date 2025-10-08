<?php
// Direct test of layout management endpoints
echo "=== Testing Layout Management Endpoints ===\n\n";

// Test the actual endpoints that the JavaScript is calling
$baseUrl = 'http://127.0.0.1:8000';

// Test 1: Check if /api/media/user returns data
echo "1. Testing /api/media/user endpoint:\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/media/user');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "   HTTP Status: {$httpCode}\n";
if ($httpCode == 401) {
    echo "   ✗ Authentication required - this is the likely issue\n";
} elseif ($httpCode == 200) {
    echo "   ✓ Endpoint accessible\n";
} else {
    echo "   ✗ Unexpected status code\n";
}

// Test 2: Check if /layout/settings returns data
echo "\n2. Testing /layout/settings endpoint:\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/layout/settings');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, false);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "   HTTP Status: {$httpCode}\n";
if ($httpCode == 401) {
    echo "   ✗ Authentication required\n";
} elseif ($httpCode == 200) {
    echo "   ✓ Endpoint accessible\n";
} else {
    echo "   ✗ Unexpected status code\n";
}

echo "\n3. Analysis:\n";
if ($httpCode == 401) {
    echo "   The issue is authentication - the AJAX requests are not authenticated.\n";
    echo "   This means the user session is not being passed properly.\n";
    echo "   Solution: Check if user is logged in and session is valid.\n";
} else {
    echo "   The endpoints are accessible, issue might be in JavaScript or form data.\n";
}

echo "\n4. Next steps:\n";
echo "   - Make sure you're logged in to the admin panel\n";
echo "   - Check browser console for specific error messages\n";
echo "   - Verify CSRF token is being sent correctly\n";
?>
