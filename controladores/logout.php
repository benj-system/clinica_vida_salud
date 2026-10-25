<?php
/**
 * logout.php - Cerrar Sesión
 * Destruye la sesión de forma segura y redirige al login
 */

session_start();

// Destruir la sesión completamente
session_unset();
session_destroy();

// Limpiar cookies de sesión si existen
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Redirigir al login
header('Location: ../controladores/autenticacion.php');
exit;
?>
