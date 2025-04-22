<?php
// config.php
 session_start();
 $host = 'db'; // Use the service name from docker-compose as the host
 $db   = 'mydb';
 $user = 'user';
 $pass = 'userpassword';
 $charset = 'utf8mb4';

 $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
 $options = [
     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
 ];

         // Connect to the database using PDO
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
 } catch (\PDOException $e) {
    die("Failed to connect to the database: " . $e->getMessage());

 }
?>
