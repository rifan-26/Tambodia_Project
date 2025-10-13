<?php
// TEST UPLOAD CONFIGURATION
echo "<h1>PHP Upload Configuration Test</h1>";
echo "<hr>";

// Check upload_max_filesize
echo "<h2>Upload Settings:</h2>";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "post_max_size: " . ini_get('post_max_size') . "<br>";
echo "max_execution_time: " . ini_get('max_execution_time') . "<br>";
echo "memory_limit: " . ini_get('memory_limit') . "<br>";

// Check upload_tmp_dir
echo "<h2>Temp Directory:</h2>";
$tmp_dir = ini_get('upload_tmp_dir');
echo "upload_tmp_dir: " . ($tmp_dir ?: sys_get_temp_dir()) . "<br>";
echo "Temp dir exists: " . (is_dir($tmp_dir ?: sys_get_temp_dir()) ? 'YES' : 'NO') . "<br>";
echo "Temp dir writable: " . (is_writable($tmp_dir ?: sys_get_temp_dir()) ? 'YES' : 'NO') . "<br>";

// Check storage directory
echo "<h2>Storage Directory:</h2>";
$storage_path = __DIR__ . '/storage/app/public/media';
echo "Storage path: " . $storage_path . "<br>";
echo "Storage exists: " . (is_dir($storage_path) ? 'YES' : 'NO') . "<br>";
echo "Storage writable: " . (is_writable($storage_path) ? 'YES' : 'NO') . "<br>";

// Test file upload form
?>
<hr>
<h2>Test File Upload:</h2>
<form method="POST" enctype="multipart/form-data" action="test_upload_process.php">
    <input type="file" name="test_file" accept="audio/*,.mp3,.wav,.ogg">
    <button type="submit">Test Upload</button>
</form>
