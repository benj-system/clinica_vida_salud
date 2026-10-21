<?php   //dashboard_medico.php
session_start();
if (!isset($_SESSION['id_usuario'])) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Dashboard Médico</title></head>
<body style="font-family: Arial; text-align: center; padding-top: 50px;">
    <h1>Bienvenido Dr. <?php echo $_SESSION['nombre_usuario']; ?></h1>
    <p>Este es tu panel de control (En construcción).</p>
    <a href="index.php" style="color: red;">Cerrar Sesión</a>
</body>
</html>