<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "sesion");
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    // Capturar los valores del formulario
    $documento = trim($_POST['Documento']);
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $edad = trim($_POST['edad']);
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);
    $confirmarContrasena = trim($_POST['confirmarContrasena']);

    // Validar que las contraseñas coincidan
    if ($contrasena !== $confirmarContrasena) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
        exit();
    }

    // Insertar en la tabla "sesion"
    $sql = "INSERT INTO sesion (Documento, Edad, Nombres, Apellidos, Usuario, Contrasena, ConfirmarContrasena)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iisssss", $documento, $edad, $nombres, $apellidos, $usuario, $contrasena, $confirmarContrasena);

    // Ejecutar el guardado
    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso'); window.location.href='Index.html';</script>";
    } else {
        echo "<script>alert('Error al registrar: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conexion->close();
}
?>








