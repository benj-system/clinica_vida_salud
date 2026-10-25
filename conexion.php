<?php
// conexion.php - Conexión a PostgreSQL local
$host = 'localhost';
$port = '5432';
$dbname = 'clinica_vida_salud';
$user = 'postgres';
$password = 'Eliane'; // ¡Asegúrate de que esta sea tu contraseña real de PostgreSQL!

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Error de conexión: " . $e->getMessage());
    die("Error interno del servidor. Por favor, intente más tarde.");
}
?>