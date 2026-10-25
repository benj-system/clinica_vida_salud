<?php
/**
 * dashboard_admin.php - Dashboard del Administrador
 * Gestión de usuarios, médicos, especialidades y horarios
 */

session_start();

// Validar sesión
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
    header('Location: ../controladores/autenticacion.php');
    exit;
}

require_once '../conexion.php';
require_once '../utilidades/funciones.php';

$nombre_usuario = $_SESSION['nombre_usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador - Clínica Vida Salud</title>
    <link rel="stylesheet" href="../estilos/dashboard.css">
</head>
<body>
    <div class="contenedor-principal">
        <!-- Barra Lateral (Menú) -->
        <aside class="barra-lateral">
            <div class="logo-sidebar">
                <h2>🏥 CVS</h2>
                <p>Clínica Vida Salud</p>
            </div>

            <nav class="menu-principal">
                <h3>ADMINISTRACIÓN</h3>
                <ul>
                    <li><a href="#" class="enlace-menu activo" data-seccion="inicio">📊 Inicio</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="usuarios">👥 Usuarios</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="medicos">👨‍⚕️ Médicos</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="especialidades">🏥 Especialidades</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="horarios">⏰ Horarios</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="reportes">📈 Reportes</a></li>
                </ul>
            </nav>

            <div class="usuario-info">
                <p><strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></p>
                <p class="rol-usuario">Administrador</p>
                <a href="../controladores/logout.php" class="boton-logout">Cerrar Sesión</a>
            </div>
        </aside>

        <!-- Contenido Principal -->
        <main class="contenido-principal">
            <header class="encabezado">
                <h1 id="titulo-seccion">Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
                <p id="subtitulo-seccion">Dashboard de Administración</p>
            </header>

            <div id="contenido-dinamico" class="contenido-dinamico">
                <!-- Se carga dinámicamente con JavaScript -->
            </div>
        </main>
    </div>

    <script src="../scripts/dashboard.js"></script>
    <script>
        // Configuración para el dashboard del admin
        const rolActual = 'admin';
        const seccionesDisponibles = [
            'inicio', 'usuarios', 'medicos', 'especialidades', 'horarios', 'reportes'
        ];
    </script>
</body>
</html>
<?php
?>
