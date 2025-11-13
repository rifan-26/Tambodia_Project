<?php
/**
 * Database Export Script
 * 
 * Script ini akan export database ke file SQL
 * Jalankan: php export_database.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get database config
$host = env('DB_HOST');
$port = env('DB_PORT', 3306);
$database = env('DB_DATABASE');
$username = env('DB_USERNAME');
$password = env('DB_PASSWORD');

echo "🔄 Exporting database: {$database}\n";
echo "📍 Host: {$host}:{$port}\n";
echo "👤 User: {$username}\n\n";

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$database}", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $output = "-- Database Export: {$database}\n";
    $output .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
    $output .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
    
    // Get all tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    echo "📊 Found " . count($tables) . " tables\n\n";
    
    foreach ($tables as $table) {
        echo "  ✓ Exporting table: {$table}\n";
        
        // Drop table
        $output .= "DROP TABLE IF EXISTS `{$table}`;\n";
        
        // Create table
        $createTable = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(PDO::FETCH_ASSOC);
        $output .= $createTable['Create Table'] . ";\n\n";
        
        // Insert data
        $rows = $pdo->query("SELECT * FROM `{$table}`")->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $columns = array_keys($row);
                $values = array_map(function($value) use ($pdo) {
                    return $value === null ? 'NULL' : $pdo->quote($value);
                }, array_values($row));
                
                $output .= "INSERT INTO `{$table}` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ");\n";
            }
            $output .= "\n";
        }
    }
    
    $output .= "SET FOREIGN_KEY_CHECKS=1;\n";
    
    // Save to file
    $filename = "tambodia_project_backup_" . date('Y-m-d_His') . ".sql";
    file_put_contents($filename, $output);
    
    echo "\n✅ Export berhasil!\n";
    echo "📁 File: {$filename}\n";
    echo "📦 Size: " . number_format(filesize($filename) / 1024, 2) . " KB\n\n";
    echo "📤 Kirim file ini ke teman Anda!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
