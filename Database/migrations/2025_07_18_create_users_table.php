<?php
use Teflo\Core\Database\Connection;

$db = Connection::getInstance();
$db->exec("
  CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    created_at DATETIME,
    updated_at DATETIME
  )
");


?>