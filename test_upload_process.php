<?php
// TEST UPLOAD PROCESS
echo "<h1>Upload Test Result</h1>";
echo "<hr>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>POST Data Received</h2>";
    
    if (isset($_FILES['test_file'])) {
        $file = $_FILES['test_file'];
        
        echo "<h3>File Info:</h3>";
        echo "Name: " . $file['name'] . "<br>";
        echo "Type: " . $file['type'] . "<br>";
        echo "Size: " . $file['size'] . " bytes<br>";
        echo "Tmp Name: " . $file['tmp_name'] . "<br>";
        echo "Error: " . $file['error'] . "<br>";
        
        echo "<h3>Error Code Meaning:</h3>";
        $errors = [
            UPLOAD_ERR_OK => 'No error',
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'File uploaded partially',
            UPLOAD_ERR_NO_FILE => 'No file uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write to disk',
            UPLOAD_ERR_EXTENSION => 'Upload stopped by extension'
        ];
        echo $errors[$file['error']] ?? 'Unknown error';
        echo "<br>";
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            echo "<h3 style='color: green'>✅ Upload Successful!</h3>";
            echo "Temp file exists: " . (file_exists($file['tmp_name']) ? 'YES' : 'NO') . "<br>";
            
            // Try to move file
            $target = __DIR__ . '/storage/app/public/media/' . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $target)) {
                echo "<h3 style='color: green'>✅ File Moved Successfully to: " . $target . "</h3>";
            } else {
                echo "<h3 style='color: red'>❌ Failed to Move File</h3>";
                echo "Target: " . $target . "<br>";
                echo "Target dir exists: " . (is_dir(dirname($target)) ? 'YES' : 'NO') . "<br>";
                echo "Target dir writable: " . (is_writable(dirname($target)) ? 'YES' : 'NO') . "<br>";
            }
        } else {
            echo "<h3 style='color: red'>❌ Upload Failed!</h3>";
        }
    } else {
        echo "<h3 style='color: red'>❌ No file in \$_FILES</h3>";
        echo "POST max size might be exceeded or no file selected.";
    }
} else {
    echo "<h3>No POST data received</h3>";
}

echo "<hr>";
echo "<a href='test_upload.php'>Back to Test Form</a>";
