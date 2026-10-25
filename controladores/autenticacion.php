<?php
/**
 * autenticacion.php - Controlador de Autenticación
 * Gestiona el login, logout y validación de sesiones (RF01)
 */

session_start();

// Incluir archivos de configuración
require_once '../conexion.php';
require_once '../utilidades/funciones.php';

// ============================================================================
// MANEJO DE POST: Iniciar Sesión
// ============================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = isset($_POST['nombre_usuario']) ? trim($_POST['nombre_usuario']) : '';
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';
    $mensaje_error = '';

    // Validación básica del lado del servidor
    if (empty($nombre_usuario) || empty($contrasena)) {
        $mensaje_error = 'Por favor ingrese usuario y contraseña.';
    } else {
        try {
            // Consulta parametrizada para obtener el usuario
            $sql = "SELECT u.id_usuario, u.nombre_usuario, u.contrasena_hash, u.id_rol, u.estado_activo,
                           r.nombre_rol
                    FROM usuarios u
                    JOIN roles r ON u.id_rol = r.id_rol
                    WHERE u.nombre_usuario = ? AND u.estado_activo = TRUE";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre_usuario]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar credenciales
            if ($usuario && password_verify($contrasena, $usuario['contrasena_hash'])) {
                // Credenciales correctas: crear sesión
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                $_SESSION['id_rol'] = $usuario['id_rol'];
                $_SESSION['nombre_rol'] = $usuario['nombre_rol'];
                $_SESSION['inicio_sesion'] = time();

                // Redirigir según el rol
                redirigir_por_rol($usuario['id_rol']);
                exit;
            } else {
                // Credenciales inválidas
                $mensaje_error = 'Usuario o contraseña inválidos. Intente nuevamente.  XD';
            }
        } catch (Exception $e) {
            error_log('Error en autenticación: ' . $e->getMessage());
            // Volvemos a poner el mensaje genérico para no mostrar detalles técnicos al usuario
            $mensaje_error = 'Error en el servidor. Intente más tarde.';
        }
    }

    // Si hay error, mostrar formulario nuevamente con mensaje
    mostrar_formulario_login($mensaje_error);
    exit;
}

// ============================================================================
// GET: Mostrar formulario de login (por defecto)
// ============================================================================
mostrar_formulario_login('');

/**
 * Función auxiliar: Mostrar formulario de login
 */
function mostrar_formulario_login($mensaje_error) {
    $html = file_get_contents('../vistas/autenticacion/login.html');
    $html = str_replace('{{MENSAJE_ERROR}}', htmlspecialchars($mensaje_error), $html);
    echo $html;
}

/**
 * Función auxiliar: Redirigir según el rol del usuario (RF01)
 */
function redirigir_por_rol($id_rol) {
    switch ($id_rol) {
        case 1: // Administrador
            header('Location: ../controladores/dashboard_admin.php');
            break;
        case 2: // Recepcionista
            header('Location: ../controladores/dashboard_recepcionista.php');
            break;
        case 3: // Médico
            header('Location: ../controladores/dashboard_medico.php');
            break;
        case 4: // Paciente
            header('Location: ../controladores/dashboard_paciente.php');
            break;
        default:
            header('Location: ./autenticacion.php');
    }
}
?>