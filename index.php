<?php
/**
 * index.php - Punto de Entrada Principal de Clínica Vida Salud
 *
 * Este archivo es el punto de entrada de toda la aplicación.
 * Verifica si el usuario tiene sesión activa y lo redirige al controlador
 * correspondiente según su rol, o lo lleva al formulario de login.
 *
 * Se ha refactorizado para usar la nueva estructura de carpetas por capas.
 */

session_start();

// Si el usuario ya está autenticado, redirigir al dashboard correspondiente
if (isset($_SESSION['id_usuario']) && isset($_SESSION['id_rol'])) {
    $rol = $_SESSION['id_rol'];

    switch ($rol) {
        case 1: // Administrador
            header('Location: controladores/dashboard_admin.php');
            exit;
        case 2: // Recepcionista
            header('Location: controladores/dashboard_recepcionista.php');
            exit;
        case 3: // Médico
            header('Location: controladores/dashboard_medico.php');
            exit;
        case 4: // Paciente
            header('Location: controladores/dashboard_paciente.php');
            exit;
        default:
            session_destroy();
            header('Location: controladores/autenticacion.php');
            exit;
    }
}

// Si no hay sesión activa, redirigir al formulario de login
header('Location: controladores/autenticacion.php');
exit;
?>