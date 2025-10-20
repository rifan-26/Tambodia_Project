<?php
// Create symbolic link from public/storage to storage/app/public
$target = __DIR__ . '/storage/app/public';
$link = __DIR__ . '/public/storage';

if (is_link($link)) {
    echo "Symbolic link already exists.\n";
} elseif (file_exists($link)) {
    echo "File or directory already exists at link path.\n";
} else {
    if (symlink($target, $link)) {
        echo "Symbolic link created successfully.\n";
    } else {
        echo "Failed to create symbolic link.\n";
    }
}
?>