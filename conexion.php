<?php
// conexion.php
$host = 'localhost';
$port = '5432';
$dbname = 'clinica_vida_salud';
$user = 'postgres'; // Tu usuario de PostgreSQL (por defecto es postgres)
$password = 'Eliane'; // La contraseña que pusiste al instalar PostgreSQL

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password);
    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Opcional: echo "Conexión exitosa"; (para probar)
} catch (PDOException $e) {
    // Manejo de errores sin mostrar credenciales al usuario (Requerimiento técnico)
    error_log("Error de conexión: " . $e->getMessage());
    die("Error interno del servidor. Por favor, intente más tarde.");
}
?>