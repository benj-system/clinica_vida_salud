<?php
// Archivo: conexion.php
// Descripción: Conexión a PostgreSQL compatible con Localhost y Railway

$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME') ?: 'clinica_vida_salud';
$user = getenv('DB_USER') ?: 'postgres';
$password = getenv('DB_PASSWORD') ?: 'Eliane'; // En local usará Eliane, en la nube las variables

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Error de conexión: " . $e->getMessage());
    die("Error interno del servidor. Por favor, intente más tarde.");
}
?>
