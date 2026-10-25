<?php
/**
 * dashboard_paciente.php - Dashboard del Paciente
 * Consulta de historial de citas y edición de perfil
 */

session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 4) {
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
    <title>Dashboard Paciente - Clínica Vida Salud</title>
    <link rel="stylesheet" href="../estilos/dashboard.css">
</head>
<body>
    <div class="contenedor-principal">
        <aside class="barra-lateral">
            <div class="logo-sidebar">
                <h2>🏥 CVS</h2>
                <p>Clínica Vida Salud</p>
            </div>

            <nav class="menu-principal">
                <h3>MIS DATOS</h3>
                <ul>
                    <li><a href="#" class="enlace-menu activo" data-seccion="inicio">📊 Inicio</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="historial">📋 Mi Historial</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="perfil">👤 Mi Perfil</a></li>
                    <li><a href="#" class="enlace-menu" data-seccion="contacto">📞 Emergencia</a></li>
                </ul>
            </nav>

            <div class="usuario-info">
                <p><strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></p>
                <p class="rol-usuario">Paciente</p>
                <a href="../controladores/logout.php" class="boton-logout">Cerrar Sesión</a>
            </div>
        </aside>

        <main class="contenido-principal">
            <header class="encabezado">
                <h1 id="titulo-seccion">Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
                <p id="subtitulo-seccion">Portal del Paciente</p>
            </header>

            <div id="contenido-dinamico" class="contenido-dinamico">
                <!-- Se carga dinámicamente -->
            </div>
        </main>
    </div>

    <script src="../scripts/dashboard.js"></script>
    <script>
        const rolActual = 'paciente';
        const seccionesDisponibles = [
            'inicio', 'historial', 'perfil', 'contacto'
        ];
    </script>
</body>
</html>
<?php
?>
