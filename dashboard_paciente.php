<?php   //dashboard_paciente.php
session_start();
if (!isset($_SESSION['id_usuario'])) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Portal del Paciente</title></head>
<body style="font-family: Arial; text-align: center; padding-top: 50px;">
    <h1>Bienvenido a tu Portal de Salud</h1>
    <p>Hola, <?php echo $_SESSION['nombre_usuario']; ?>. Aquí podrás ver tus citas.</p>
    <a href="index.php" style="color: red;">Cerrar Sesión</a>
</body>
</html>