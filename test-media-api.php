<?php
// Test media API endpoint directly
echo "=== Testing Media API Endpoint ===\n\n";

// Simulate authenticated request to test the endpoint
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/api/media/user';

// Bootstrap Laravel
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

try {
    // Test the MediaController getUserMedia method directly
    $controller = new App\Http\Controllers\MediaController();
    
    // Mock authentication - set a user ID
    $user = App\Models\User::first();
    if ($user) {
        Auth::login($user);
        echo "Authenticated as user: {$user->name} (ID: {$user->id})\n\n";
        
        // Call the getUserMedia method
        $response = $controller->getUserMedia();
        $data = json_decode($response->getContent(), true);
        
        echo "API Response:\n";
        echo "Success: " . ($data['success'] ? 'true' : 'false') . "\n";
        echo "Media count: " . (isset($data['media']) ? count($data['media']) : 0) . "\n";
        
        if (isset($data['media']) && count($data['media']) > 0) {
            echo "\nFirst few media items:\n";
            foreach (array_slice($data['media'], 0, 3) as $media) {
                echo "- ID: {$media['id']}, Name: {$media['name']}, Type: {$media['type']}\n";
            }
        } else {
            echo "\nNo media found or error occurred\n";
            if (isset($data['message'])) {
                echo "Error message: {$data['message']}\n";
            }
        }
    } else {
        echo "No users found in database\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
