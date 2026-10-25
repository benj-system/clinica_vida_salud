<?php
/**
 * FILE1.php - Dashboard del Recepcionista
 * Gestión de pacientes, citas y disponibilidad de médicos
 * Requiere: vistas vista_citas_hoy, vista_pacientes en PostgreSQL
 */

session_start();

// Validar sesión y rol de recepcionista (rol = 2)
require_once '../utilidades/funciones.php';
validar_rol(2);

require_once '../conexion.php';

$nombre_usuario = $_SESSION['nombre_usuario'];
$id_usuario = $_SESSION['id_usuario'];
$citas_hoy = [];
$pacientes_totales = 0;
$medicos_disponibles = 0;
$mensaje_error = '';

// Obtener citas de hoy
try {
    $fecha_hoy = date('Y-m-d');
    $sql = "SELECT * FROM vista_citas_hoy WHERE fecha = :fecha ORDER BY hora ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':fecha' => $fecha_hoy]);
    $citas_hoy = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log('Error en vista_citas_hoy: ' . $e->getMessage());
}

// Obtener total de pacientes registrados
try {
    $sql = "SELECT COUNT(*) as total FROM usuarios WHERE id_rol = 4";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $pacientes_totales = $resultado['total'] ?? 0;
} catch (PDOException $e) {
    error_log('Error contando pacientes: ' . $e->getMessage());
}

// Obtener cantidad de médicos disponibles
try {
    $sql = "SELECT COUNT(*) as total FROM usuarios WHERE id_rol = 3 AND estado_activo = true";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $medicos_disponibles = $resultado['total'] ?? 0;
} catch (PDOException $e) {
    error_log('Error contando médicos: ' . $e->getMessage());
}

// Calcular estadísticas de citas de hoy
$citas_programadas_hoy = count(array_filter($citas_hoy, fn($c) => $c['estado'] == 'Programada'));
$citas_atendidas_hoy = count(array_filter($citas_hoy, fn($c) => $c['estado'] == 'Atendida'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Recepcionista - Clínica Vida Salud</title>
    <link rel="stylesheet" href="../estilos/dashboard.css">
    <link rel="stylesheet" href="../estilos/file1.css">
</head>
<body>
    <div class="contenedor-principal">
        <!-- ========== BARRA LATERAL ========== -->
        <aside class="barra-lateral">
            <div class="logo-sidebar">
                <h2>🏥 CVS</h2>
                <p>Clínica Vida Salud</p>
            </div>

            <nav class="menu-principal">
                <h3>MENÚ</h3>
                <ul>
                    <li><a href="#" class="enlace-menu activo" data-seccion="citas">📅 Citas Hoy</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="pacientes">👤 Pacientes</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="crear-cita">➕ Nueva Cita</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="medicos">👨‍⚕️ Médicos</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="reportes">📊 Reportes</a></li>
                </ul>
            </nav>

            <div class="usuario-info">
                <p><strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></p>
                <p class="rol-usuario">Recepcionista</p>
                <a href="../controladores/logout.php" class="boton-logout">Cerrar Sesión</a>
            </div>
        </aside>

        <!-- ========== CONTENIDO PRINCIPAL ========== -->
        <main class="contenido-principal">
            <header class="encabezado">
                <h1>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
                <p>Centro de operaciones - Clínica Vida Salud</p>
            </header>

            <div class="contenido-dinamico">
                <!-- Mostrar mensaje de error si existe -->
                <?php if ($mensaje_error): ?>
                    <div class="alerta alerta-error">
                        <strong>⚠️ Error:</strong> <?php echo htmlspecialchars($mensaje_error); ?>
                    </div>
                <?php endif; ?>

                <!-- ========== TARJETA DE ESTADÍSTICAS ========== -->
                <div class="grid-estadisticas">
                    <div class="estadistica">
                        <h3>Citas Hoy</h3>
                        <div class="valor"><?php echo count($citas_hoy); ?></div>
                        <p class="subtexto"><?php echo $citas_programadas_hoy; ?> pendientes</p>
                    </div>
                    <div class="estadistica">
                        <h3>Pacientes</h3>
                        <div class="valor"><?php echo $pacientes_totales; ?></div>
                        <p class="subtexto">Registrados</p>
                    </div>
                    <div class="estadistica">
                        <h3>Médicos</h3>
                        <div class="valor"><?php echo $medicos_disponibles; ?></div>
                        <p class="subtexto">Disponibles</p>
                    </div>
                    <div class="estadistica">
                        <h3>Atendidas</h3>
                        <div class="valor"><?php echo $citas_atendidas_hoy; ?></div>
                        <p class="subtexto">Hoy</p>
                    </div>
                </div>

                <!-- ========== TARJETA DE CITAS HOY ========== -->
                <div class="tarjeta tarjeta-citas-hoy">
                    <div class="encabezado-tarjeta">
                        <h2>📅 Citas de Hoy</h2>
                        <button class="boton boton-primario btn-nueva-cita">➕ Nueva Cita</button>
                    </div>

                    <?php if (empty($citas_hoy)): ?>
                        <div class="alerta alerta-info">
                            No hay citas programadas para hoy.
                        </div>
                    <?php else: ?>
                        <div class="tabla-contenedor">
                            <table class="tabla tabla-citas-recepcion">
                                <thead>
                                    <tr>
                                        <th>Hora</th>
                                        <th>Paciente</th>
                                        <th>Médico</th>
                                        <th>Especialidad</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($citas_hoy as $cita): ?>
                                        <tr class="fila-cita-recepcion estado-<?php echo strtolower(str_replace(' ', '-', $cita['estado'])); ?>">
                                            <td class="celda-hora">
                                                <strong><?php echo htmlspecialchars($cita['hora']); ?></strong>
                                            </td>
                                            <td class="celda-paciente">
                                                <?php echo htmlspecialchars($cita['nombre_paciente'] ?? 'N/A'); ?>
                                            </td>
                                            <td class="celda-medico">
                                                <?php echo htmlspecialchars($cita['nombre_medico'] ?? 'Sin asignar'); ?>
                                            </td>
                                            <td class="celda-especialidad">
                                                <?php echo htmlspecialchars($cita['especialidad'] ?? 'General'); ?>
                                            </td>
                                            <td class="celda-estado">
                                                <span class="badge-estado badge-<?php echo strtolower(str_replace(' ', '-', $cita['estado'])); ?>">
                                                    <?php echo obtener_estado_cita($cita['estado']); ?>
                                                </span>
                                            </td>
                                            <td class="celda-acciones">
                                                <button class="boton-mini boton-ver" title="Ver detalles">👁️</button>
                                                <button class="boton-mini boton-editar" title="Editar">✏️</button>
                                                <button class="boton-mini boton-cancelar" title="Cancelar">❌</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- ========== SECCIONES ADICIONALES ========== -->
                <div class="grid-adicional">
                    <!-- Tarjeta de Pacientes Recientes -->
                    <div class="tarjeta tarjeta-compacta">
                        <h2>👥 Pacientes Recientes</h2>
                        <div class="alerta alerta-info">
                            Sección en desarrollo...
                        </div>
                    </div>

                    <!-- Tarjeta de Disponibilidad -->
                    <div class="tarjeta tarjeta-compacta">
                        <h2>⏰ Disponibilidad de Médicos</h2>
                        <div class="alerta alerta-info">
                            Sección en desarrollo...
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="../scripts/file1.js"></script>
</body>
</html>
