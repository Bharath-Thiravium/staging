<?php
// Export Database Script - Run once: yoursite.com/db-export.php
set_time_limit(0);

$host = '127.0.0.1';
$user = 'u494785662_oTUVt';
$pass = '6f4YPUq1T1';
$db = 'u494785662_aqKgi';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$tables = [];
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_row()) $tables[] = $row[0];

$sql = "-- Database Export\n\n";

foreach ($tables as $table) {
    $result = $conn->query("SHOW CREATE TABLE `$table`");
    $row = $result->fetch_row();
    $sql .= "\n\nDROP TABLE IF EXISTS `$table`;\n" . $row[1] . ";\n\n";
    
    $result = $conn->query("SELECT * FROM `$table`");
    while ($row = $result->fetch_assoc()) {
        $sql .= "INSERT INTO `$table` VALUES(";
        $vals = [];
        foreach ($row as $val) {
            $vals[] = is_null($val) ? 'NULL' : "'" . $conn->real_escape_string($val) . "'";
        }
        $sql .= implode(',', $vals) . ");\n";
    }
}

header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="database.sql"');
echo $sql;
