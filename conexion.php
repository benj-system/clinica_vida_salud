<?php
// conexion.php
// Detecta si estamos en Railway (usando DATABASE_URL) o en local (usando variables)

$databaseUrl = getenv('DATABASE_URL');

if ($databaseUrl) {
    // Estamos en Railway: usamos la URL completa que nos da la plataforma
    try {
        $pdo = new PDO($databaseUrl);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        error_log("Error de conexión en Railway: " . $e->getMessage());
        die("Error interno del servidor. Por favor, intente más tarde.");
    }
} else {
    // Estamos en Localhost: usamos las credenciales de tu PC
    $host = 'localhost';
    $port = '5432';
    $dbname = 'clinica_vida_salud';
    $user = 'postgres';
    $password = 'Eliane'; // Tu contraseña local

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        error_log("Error de conexión local: " . $e->getMessage());
        die("Error interno del servidor. Por favor, intente más tarde.");
    }
}
?>
