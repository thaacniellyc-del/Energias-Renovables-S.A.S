<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: Index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilo.css">
    <title>Página de Inicio</title>
</head>
<body>
    <div class="head">
        <div class="logo">
            <a href="#">LOGO</a>
        </div>

        <nav class="navbar">
            <a href="PaginaInicio.php">Inicio</a>
            <a href="Nosotros.html">Nosotros</a>
            <a href="Contacto.html">Contacto</a>
            <a href="Productos.html">Productos</a>
            <a href="CerrarSesion.php">Cerrar sesión</a>
        </nav>
    </div>

    <header class="content header">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombres']); ?> 👋</h2>
        <p>Has iniciado sesión correctamente en <strong>ER S.A.S</strong>.</p>
    </header>
</body>
</html>

