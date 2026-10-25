<?php
/**
 * dashboard_medico.php - Dashboard del Médico
 * Consulta y gestión de agenda de citas del médico logueado
 * Requiere: vista vista_agenda_medicos en PostgreSQL
 */

session_start();

// Validar sesión y rol de médico (rol = 3)
require_once '../utilidades/funciones.php';
validar_rol(3);

require_once '../conexion.php';

$nombre_usuario = $_SESSION['nombre_usuario'];
$id_usuario = $_SESSION['id_usuario'];
$citas = [];
$mensaje_error = '';

// Obtener citas del médico desde la vista vista_agenda_medicos
try {
    $sql = "SELECT * FROM vista_agenda_medicos WHERE id_medico = :id_medico ORDER BY fecha DESC, hora DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_medico' => $id_usuario]);
    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensaje_error = 'Error al cargar las citas. Por favor, intente nuevamente.';
    error_log('Error en vista_agenda_medicos: ' . $e->getMessage());
}

// Calcular estadísticas rápidas
$total_citas = count($citas);
$citas_programadas = count(array_filter($citas, fn($c) => $c['estado'] == 'Programada'));
$citas_atendidas = count(array_filter($citas, fn($c) => $c['estado'] == 'Atendida'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Médico - Clínica Vida Salud</title>
    <link rel="stylesheet" href="../estilos/dashboard.css">
    <link rel="stylesheet" href="../estilos/dashboard_medico.css">
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
                    <li><a href="#" class="enlace-menu activo" data-seccion="agenda">📅 Mi Agenda</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="pacientes">👥 Mis Pacientes</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="historial">📋 Historial</a></li>
                </ul>
            </nav>

            <div class="usuario-info">
                <p><strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></p>
                <p class="rol-usuario">Médico</p>
                <a href="../controladores/logout.php" class="boton-logout">Cerrar Sesión</a>
            </div>
        </aside>

        <!-- ========== CONTENIDO PRINCIPAL ========== -->
        <main class="contenido-principal">
            <header class="encabezado">
                <h1>Bienvenido, Dr(a). <?php echo htmlspecialchars($nombre_usuario); ?></h1>
                <p>Gestión de tu agenda de citas</p>
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
                        <h3>Total de Citas</h3>
                        <div class="valor"><?php echo $total_citas; ?></div>
                    </div>
                    <div class="estadistica">
                        <h3>Pendientes</h3>
                        <div class="valor"><?php echo $citas_programadas; ?></div>
                    </div>
                    <div class="estadistica">
                        <h3>Atendidas</h3>
                        <div class="valor"><?php echo $citas_atendidas; ?></div>
                    </div>
                </div>

                <!-- ========== TARJETA DE AGENDA ========== -->
                <div class="tarjeta tarjeta-agenda">
                    <h2>📅 Mi Agenda de Citas</h2>

                    <?php if (empty($citas)): ?>
                        <div class="alerta alerta-info">
                            No tienes citas registradas en el sistema.
                        </div>
                    <?php else: ?>
                        <div class="tabla-contenedor">
                            <table class="tabla tabla-citas">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Paciente</th>
                                        <th>Especialidad</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($citas as $cita): ?>
                                        <tr class="fila-cita estado-<?php echo strtolower(str_replace(' ', '-', $cita['estado'])); ?>">
                                            <td class="celda-fecha">
                                                <?php
                                                    $fecha = DateTime::createFromFormat('Y-m-d', $cita['fecha']);
                                                    echo $fecha ? $fecha->format('d/m/Y') : htmlspecialchars($cita['fecha']);
                                                ?>
                                            </td>
                                            <td class="celda-hora"><?php echo htmlspecialchars($cita['hora']); ?></td>
                                            <td class="celda-paciente">
                                                <strong><?php echo htmlspecialchars($cita['nombre_paciente'] ?? 'N/A'); ?></strong>
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
            </div>
        </main>
    </div>

    <script src="../scripts/dashboard_medico.js"></script>
</body>
</html>
