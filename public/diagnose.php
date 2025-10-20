<?php
// COMPREHENSIVE DIAGNOSTIC TOOL
error_reporting(E_ALL);
ini_set('display_errors', 1);

function formatBytes($bytes) {
    if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
    if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
    if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
    return $bytes . ' bytes';
}

function convertToBytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    $val = (int)$val;
    switch($last) {
        case 'g': $val *= 1024;
        case 'm': $val *= 1024;
        case 'k': $val *= 1024;
    }
    return $val;
}

$tests = [];

// TEST 1: PHP Configuration
$tests['PHP Configuration'] = [
    'PHP Version' => PHP_VERSION,
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'max_execution_time' => ini_get('max_execution_time') . ' seconds',
    'memory_limit' => ini_get('memory_limit'),
    'max_input_time' => ini_get('max_input_time') . ' seconds',
    'file_uploads' => ini_get('file_uploads') ? 'Enabled' : 'Disabled'
];

// TEST 2: Temp Directory
$tmpDir = ini_get('upload_tmp_dir') ?: sys_get_temp_dir();
$tests['Temp Directory'] = [
    'Path' => $tmpDir,
    'Exists' => is_dir($tmpDir) ? '✅ YES' : '❌ NO',
    'Writable' => is_writable($tmpDir) ? '✅ YES' : '❌ NO',
    'Free Space' => formatBytes(disk_free_space($tmpDir))
];

// TEST 3: Storage Directory
$storageBase = dirname(__DIR__) . '/storage/app/public';
$storageMedia = $storageBase . '/media';
$tests['Storage Directory'] = [
    'Base Path' => $storageBase,
    'Base Exists' => is_dir($storageBase) ? '✅ YES' : '❌ NO',
    'Base Writable' => is_writable($storageBase) ? '✅ YES' : '❌ NO',
    'Media Path' => $storageMedia,
    'Media Exists' => is_dir($storageMedia) ? '✅ YES' : '❌ NO',
    'Media Writable' => is_writable($storageMedia) ? '✅ YES' : '❌ NO',
];

// Create media directory if not exists
if (!is_dir($storageMedia)) {
    @mkdir($storageMedia, 0777, true);
    @chmod($storageMedia, 0777);
}

// TEST 4: Size Limits Check
$uploadMax = convertToBytes(ini_get('upload_max_filesize'));
$postMax = convertToBytes(ini_get('post_max_size'));
$tests['Size Limits Analysis'] = [
    'upload_max_filesize (bytes)' => formatBytes($uploadMax),
    'post_max_size (bytes)' => formatBytes($postMax),
    'Recommended for 250MB files' => $uploadMax >= 262144000 && $postMax >= 262144000 ? '✅ OK' : '❌ TOO SMALL',
    'Current Capacity' => 'Can handle files up to ' . formatBytes(min($uploadMax, $postMax))
];

// TEST 5: Write Test
$testFile = $storageMedia . '/test_write_' . time() . '.txt';
$writeTest = @file_put_contents($testFile, 'Test write access');
$tests['Write Permission Test'] = [
    'Test File' => $testFile,
    'Write Test' => $writeTest !== false ? '✅ SUCCESS' : '❌ FAILED',
    'File Created' => file_exists($testFile) ? '✅ YES' : '❌ NO'
];
if (file_exists($testFile)) {
    @unlink($testFile);
}

// TEST 6: Laravel Check
$envFile = dirname(__DIR__) . '/.env';
$tests['Laravel Environment'] = [
    '.env exists' => file_exists($envFile) ? '✅ YES' : '❌ NO',
    'storage/ writable' => is_writable(dirname(__DIR__) . '/storage') ? '✅ YES' : '❌ NO',
    'bootstrap/cache/ writable' => is_writable(dirname(__DIR__) . '/bootstrap/cache') ? '✅ YES' : '❌ NO',
];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Diagnostic Tool</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        h1 { color: #333; }
        .test-section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .test-section h2 { margin-top: 0; color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        td:first-child { font-weight: bold; width: 40%; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        .action-btn { background: #3498db; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin: 10px 5px; }
        .action-btn:hover { background: #2980b9; }
        .test-form { background: #ecf0f1; padding: 20px; border-radius: 8px; margin-top: 20px; }
        .alert { padding: 15px; margin: 20px 0; border-radius: 5px; }
        .alert-success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .alert-danger { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .alert-warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; }
    </style>
</head>
<body>
    <h1>🔍 Upload Diagnostic Tool</h1>
    <p><strong>Time:</strong> <?= date('Y-m-d H:i:s') ?></p>

    <?php
    // Overall Status
    $hasErrors = false;
    $uploadOk = $uploadMax >= 262144000 && $postMax >= 262144000;
    $tmpOk = is_dir($tmpDir) && is_writable($tmpDir);
    $storageOk = is_dir($storageMedia) && is_writable($storageMedia);
    
    if (!$uploadOk || !$tmpOk || !$storageOk) {
        $hasErrors = true;
        echo '<div class="alert alert-danger">';
        echo '<strong>❌ CRITICAL ISSUES DETECTED!</strong><br>';
        if (!$uploadOk) echo '• Upload size limits too small<br>';
        if (!$tmpOk) echo '• Temp directory not accessible<br>';
        if (!$storageOk) echo '• Storage directory not writable<br>';
        echo '</div>';
    } else {
        echo '<div class="alert alert-success">';
        echo '<strong>✅ ALL SYSTEMS READY!</strong> Your server is configured correctly for uploads.';
        echo '</div>';
    }
    ?>

    <?php foreach ($tests as $section => $data): ?>
    <div class="test-section">
        <h2><?= $section ?></h2>
        <table>
            <?php foreach ($data as $key => $value): ?>
            <tr>
                <td><?= htmlspecialchars($key) ?></td>
                <td><?= htmlspecialchars($value) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endforeach; ?>

    <div class="test-section">
        <h2>🧪 Quick Upload Test</h2>
        <div class="test-form">
            <form method="POST" enctype="multipart/form-data" action="diagnose_test.php">
                <p>Select a small audio file to test upload functionality:</p>
                <input type="file" name="test_file" accept="audio/*,.mp3,.wav,.ogg" required>
                <br><br>
                <button type="submit" class="action-btn">Test Upload</button>
            </form>
        </div>
    </div>

    <?php if ($hasErrors): ?>
    <div class="test-section">
        <h2>🔧 Recommended Fixes</h2>
        <div class="alert alert-warning">
            <h3>Step 1: Edit php.ini</h3>
            <p><strong>Location:</strong> C:\laragon\bin\php\php8.x.x\php.ini</p>
            <p>Find and change these values:</p>
            <pre>upload_max_filesize = 256M
post_max_size = 256M
max_execution_time = 300
memory_limit = 512M</pre>
            
            <h3>Step 2: Restart Apache</h3>
            <p>Stop and start Apache in Laragon control panel</p>
            
            <h3>Step 3: Fix Permissions (Run as Administrator)</h3>
            <pre>cd C:\laragon\www\laraveladmin
icacls storage /grant Everyone:(OI)(CI)F /T
icacls bootstrap\cache /grant Everyone:(OI)(CI)F /T</pre>
            
            <h3>Step 4: Clear Laravel Cache</h3>
            <pre>cd C:\laragon\www\laraveladmin
php artisan config:clear
php artisan cache:clear
php artisan view:clear</pre>
            
            <h3>Step 5: Refresh This Page</h3>
            <p>After completing steps 1-4, refresh this page to verify fixes.</p>
        </div>
    </div>
    <?php endif; ?>

    <div class="test-section">
        <h2>📋 Action Buttons</h2>
        <button onclick="location.reload()" class="action-btn">🔄 Refresh Diagnostic</button>
        <button onclick="window.open('/input', '_blank')" class="action-btn">📤 Open Upload Page</button>
        <button onclick="window.open('/test_upload.php', '_blank')" class="action-btn">🧪 Simple Upload Test</button>
    </div>

</body>
</html>
