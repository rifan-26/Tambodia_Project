<?php
// UPLOAD TEST PROCESSOR
error_reporting(E_ALL);
ini_set('display_errors', 1);

function formatBytes($bytes) {
    if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
    if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
    return $bytes . ' bytes';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Test Result</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .result { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .success { color: green; font-size: 20px; font-weight: bold; }
        .error { color: red; font-size: 20px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        td, th { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        td:first-child { font-weight: bold; width: 40%; }
        .back-btn { background: #3498db; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .back-btn:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div class="result">
        <h1>🧪 Upload Test Result</h1>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_file'])) {
            $file = $_FILES['test_file'];
            
            echo '<h2>File Information:</h2>';
            echo '<table>';
            echo '<tr><td>File Name</td><td>' . htmlspecialchars($file['name']) . '</td></tr>';
            echo '<tr><td>File Type</td><td>' . htmlspecialchars($file['type']) . '</td></tr>';
            echo '<tr><td>File Size</td><td>' . formatBytes($file['size']) . '</td></tr>';
            echo '<tr><td>Temp File</td><td>' . htmlspecialchars($file['tmp_name']) . '</td></tr>';
            echo '<tr><td>Error Code</td><td>' . $file['error'] . '</td></tr>';
            echo '</table>';
            
            $errorMessages = [
                UPLOAD_ERR_OK => 'No error - Upload successful',
                UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize in php.ini',
                UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE in HTML form',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'Upload stopped by PHP extension'
            ];
            
            echo '<h2>Error Analysis:</h2>';
            echo '<p><strong>Error Code ' . $file['error'] . ':</strong> ' . ($errorMessages[$file['error']] ?? 'Unknown error') . '</p>';
            
            if ($file['error'] === UPLOAD_ERR_OK) {
                echo '<p class="success">✅ PHP UPLOAD SUCCESSFUL!</p>';
                
                // Try to move file
                $targetDir = dirname(__DIR__) . '/storage/app/public/media/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                
                $targetFile = $targetDir . 'test_' . time() . '_' . basename($file['name']);
                
                echo '<h2>File Move Test:</h2>';
                echo '<table>';
                echo '<tr><td>Target Directory</td><td>' . $targetDir . '</td></tr>';
                echo '<tr><td>Dir Exists</td><td>' . (is_dir($targetDir) ? '✅ YES' : '❌ NO') . '</td></tr>';
                echo '<tr><td>Dir Writable</td><td>' . (is_writable($targetDir) ? '✅ YES' : '❌ NO') . '</td></tr>';
                echo '<tr><td>Target File</td><td>' . $targetFile . '</td></tr>';
                echo '</table>';
                
                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    echo '<p class="success">✅ FILE MOVED SUCCESSFULLY!</p>';
                    echo '<p><strong>File saved to:</strong> ' . $targetFile . '</p>';
                    echo '<p><strong>File size on disk:</strong> ' . formatBytes(filesize($targetFile)) . '</p>';
                    
                    echo '<div style="background: #d4edda; padding: 15px; border-radius: 5px; margin: 20px 0;">';
                    echo '<h3 style="color: #155724;">🎉 SUCCESS! Upload system is working!</h3>';
                    echo '<p>Your server can successfully upload and save files.</p>';
                    echo '<p><strong>Next step:</strong> Try uploading through Laravel application.</p>';
                    echo '</div>';
                    
                    // Clean up test file
                    @unlink($targetFile);
                } else {
                    echo '<p class="error">❌ FAILED TO MOVE FILE!</p>';
                    echo '<div style="background: #f8d7da; padding: 15px; border-radius: 5px; margin: 20px 0;">';
                    echo '<h3 style="color: #721c24;">Permission Issue Detected</h3>';
                    echo '<p>The file uploaded successfully but couldn\'t be saved to storage.</p>';
                    echo '<p><strong>Fix:</strong> Run this command as Administrator:</p>';
                    echo '<pre>cd C:\\laragon\\www\\laraveladmin<br>icacls storage /grant Everyone:(OI)(CI)F /T</pre>';
                    echo '</div>';
                }
            } else {
                echo '<p class="error">❌ UPLOAD FAILED!</p>';
                
                echo '<div style="background: #f8d7da; padding: 15px; border-radius: 5px; margin: 20px 0;">';
                echo '<h3 style="color: #721c24;">Fix Required:</h3>';
                
                switch ($file['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                        echo '<p><strong>Problem:</strong> File is larger than upload_max_filesize setting.</p>';
                        echo '<p><strong>Current limit:</strong> ' . ini_get('upload_max_filesize') . '</p>';
                        echo '<p><strong>Fix:</strong> Edit php.ini and set: <code>upload_max_filesize = 256M</code></p>';
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        echo '<p><strong>Problem:</strong> Temporary upload directory is missing.</p>';
                        echo '<p><strong>Fix:</strong> Create directory: C:\\laragon\\tmp\\uploads</p>';
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        echo '<p><strong>Problem:</strong> No write permission to temp directory.</p>';
                        echo '<p><strong>Fix:</strong> Set permissions on temp directory</p>';
                        break;
                }
                echo '</div>';
            }
        } else {
            echo '<p class="error">No file uploaded or wrong request method.</p>';
        }
        ?>
        
        <br>
        <a href="diagnose.php" class="back-btn">← Back to Diagnostic</a>
        <a href="/input" class="back-btn">Try Laravel Upload</a>
    </div>
</body>
</html>
