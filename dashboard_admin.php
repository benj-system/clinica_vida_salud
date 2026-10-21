//dashboard_admin.php
<?php
session_start();
if (!isset($_SESSION['id_usuario'])) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Dashboard Administrador</title></head>
<body style="font-family: Arial; text-align: center; padding-top: 50px;">
    <h1>Panel de Administrador</h1>
    <p>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></p>
    <a href="index.php" style="color: red;">Cerrar Sesión</a>
</body>
</html>