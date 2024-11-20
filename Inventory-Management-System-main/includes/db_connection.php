<?php
$dbPath = 'C:/xampp/htdocs/Inventory-Management-System-main/includes/atlas_db.db';
if (file_exists($dbPath)) {
    $db = new SQLite3($dbPath);  // Open the existing database
} else {
    // Handle the case when the database doesn't exist
    echo "Database not found.";
}
?>
