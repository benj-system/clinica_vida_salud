<?php
// index.php
session_start(); // Iniciar sesión para controlar el acceso

// Si el usuario ya está logueado, redirigirlo a su dashboard
if (isset($_SESSION['id_usuario'])) {
    if ($_SESSION['id_rol'] == 1) { header("Location: dashboard_admin.php"); exit(); }
    if ($_SESSION['id_rol'] == 2) { header("Location: dashboard_recepcion.php"); exit(); }
    if ($_SESSION['id_rol'] == 3) { header("Location: dashboard_medico.php"); exit(); }
    if ($_SESSION['id_rol'] == 4) { header("Location: dashboard_paciente.php"); exit(); } // <-- NUEVO
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'conexion.php';
    
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    if (empty($usuario) || empty($password)) {
        $error = "Por favor, complete todos los campos.";
    } else {
        // Consulta preparada para evitar inyección SQL
        $stmt = $pdo->prepare("SELECT id_usuario, nombre_usuario, contrasena_hash, id_rol FROM usuarios WHERE nombre_usuario = :usuario AND estado_activo = TRUE");
        $stmt->execute(['usuario' => $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar contraseña con password_verify (Requerimiento RF01)
        if ($user && password_verify($password, $user['contrasena_hash'])) {
            // Login exitoso
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre_usuario'] = $user['nombre_usuario'];
            $_SESSION['id_rol'] = $user['id_rol'];

            // Redirigir según el rol
            if ($user['id_rol'] == 1) { header("Location: dashboard_admin.php"); exit(); }
            if ($user['id_rol'] == 2) { header("Location: dashboard_recepcion.php"); exit(); }
            if ($user['id_rol'] == 3) { header("Location: dashboard_medico.php"); exit(); }
            if ($user['id_rol'] == 4) { header("Location: dashboard_paciente.php"); exit(); } // <-- NUEVO
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    }
}

// ==========================================================
// LÓGICA PARA MOSTRAR LA VISTA (Separación de la interfaz)
// ==========================================================

// Leemos el archivo HTML
$html = file_get_contents('login.html');

// Preparamos el mensaje de error (si existe)
$mensaje_error_html = '';
if (!empty($error)) {
    // htmlspecialchars evita ataques XSS
    $mensaje_error_html = '<div class="error">' . htmlspecialchars($error) . '</div>';
}

// Reemplazamos el marcador en el HTML por el mensaje real
$html = str_replace('{{MENSAJE_ERROR}}', $mensaje_error_html, $html);

// Finalmente, imprimimos el HTML en el navegador
echo $html;
?>