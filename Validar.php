<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "sesion");
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    // Capturar los valores del formulario
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);

    // Buscar el usuario en la tabla
    $sql = "SELECT * FROM sesion WHERE Usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Si el usuario existe
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();

        // Comparar directamente (sin encriptar)
        if ($contrasena === $fila['Contrasena']) {
            $_SESSION['usuario'] = $fila['Usuario'];
            $_SESSION['nombres'] = $fila['Nombres'];

            // Redirigir correctamente
            header("Location: Pagina Inicio.html");
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location.href='Index.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Usuario no encontrado'); window.location.href='Index.html';</script>";
        exit();
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: Index.html");
    exit();
}
?>
