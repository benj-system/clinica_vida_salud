<?php
/**
 * funciones.php - Funciones Utilitarias Compartidas
 * Contiene funciones reutilizables en toda la aplicación
 */

/**
 * Validar si el usuario tiene sesión activa
 */
function validar_sesion() {
    if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['id_rol'])) {
        header('Location: ../controladores/autenticacion.php');
        exit;
    }
}

/**
 * Validar si el usuario tiene un rol específico
 */
function validar_rol($rol_requerido) {
    validar_sesion();
    if ($_SESSION['id_rol'] != $rol_requerido) {
        header('Location: ../controladores/autenticacion.php');
        exit;
    }
}

/**
 * Escapar y sanitizar entrada de usuario
 */
function sanitizar($valor) {
    return htmlspecialchars(trim($valor), ENT_QUOTES, 'UTF-8');
}

/**
 * Validar formato de email
 */
function validar_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validar formato de teléfono
 */
function validar_telefono($telefono) {
    return preg_match('/^\d{8}$/', $telefono) || preg_match('/^\d{10}$/', $telefono);
}

/**
 * Validar formato de CI (Cédula de Identidad)
 */
function validar_ci($ci) {
    return preg_match('/^\d{6,10}$/', $ci);
}

/**
 * Generar código único (para pacientes, médicos, citas)
 */
function generar_codigo($prefijo, $numero) {
    return $prefijo . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
}

/**
 * Convertir fecha de formato local a ISO (Y-m-d)
 */
function convertir_fecha_a_iso($fecha) {
    // Asumir formato d/m/Y o similar según locale
    $partes = explode('/', $fecha);
    if (count($partes) == 3) {
        return $partes[2] . '-' . $partes[1] . '-' . $partes[0];
    }
    return $fecha;
}

/**
 * Convertir fecha de ISO (Y-m-d) a formato local
 */
function convertir_fecha_a_local($fecha) {
    $dt = DateTime::createFromFormat('Y-m-d', $fecha);
    if ($dt !== false) {
        return $dt->format('d/m/Y');
    }
    return $fecha;
}

/**
 * Obtener nombre del rol
 */
function obtener_nombre_rol($id_rol) {
    $roles = [
        1 => 'Administrador',
        2 => 'Recepcionista',
        3 => 'Médico',
        4 => 'Paciente'
    ];
    return $roles[$id_rol] ?? 'Desconocido';
}

/**
 * Obtener nombre del estado de cita
 */
function obtener_estado_cita($estado) {
    $estados = [
        'Programada' => '📅 Programada',
        'Atendida' => '✅ Atendida',
        'Cancelada' => '❌ Cancelada',
        'Inasistencia' => '⚠️ Inasistencia'
    ];
    return $estados[$estado] ?? $estado;
}

/**
 * Obtener día de la semana en español
 */
function obtener_dia_semana($numero) {
    $dias = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo'
    ];
    return $dias[$numero] ?? 'Desconocido';
}

/**
 * Calcular edad a partir de fecha de nacimiento
 */
function calcular_edad($fecha_nacimiento) {
    $hoy = new DateTime();
    $nacimiento = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
    if ($nacimiento === false) {
        return null;
    }
    $diferencia = $hoy->diff($nacimiento);
    return $diferencia->y;
}

/**
 * Registrar acciones en log (auditoría)
 */
function registrar_log($accion, $id_usuario, $descripcion = '') {
    $log_file = '../logs/acciones.log';

    // Crear directorio si no existe
    if (!is_dir('../logs')) {
        mkdir('../logs', 0755, true);
    }

    $timestamp = date('Y-m-d H:i:s');
    $mensaje = "[$timestamp] Usuario ID: $id_usuario | Acción: $accion | $descripcion\n";

    file_put_contents($log_file, $mensaje, FILE_APPEND);
}

/**
 * Manejar errores y excepciones de BD
 */
function manejar_error_bd($exception, $mensaje_usuario = 'Error en la operación') {
    // Registrar error detallado
    error_log('Error BD: ' . $exception->getMessage());

    // Mostrar mensaje genérico al usuario
    return [
        'exito' => false,
        'mensaje' => $mensaje_usuario,
        'detalle' => '' // No revelar detalles al usuario
    ];
}

/**
 * Respuesta JSON estándar
 */
function respuesta_json($exito, $mensaje, $datos = []) {
    header('Content-Type: application/json');
    echo json_encode([
        'exito' => $exito,
        'mensaje' => $mensaje,
        'datos' => $datos
    ]);
    exit;
}

?>
