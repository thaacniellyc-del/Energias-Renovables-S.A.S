<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "sesion");

    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    // Capturar datos del formulario
    $id = intval($_POST['Identificador']);
    $documento = trim($_POST['Documento']);
    $edad = trim($_POST['Edad']);
    $nombres = trim($_POST['Nombres']);
    $apellidos = trim($_POST['Apellidos']);
    $usuario = trim($_POST['Usuario']);
    $contrasena = trim($_POST['Contrasena']);
    $confirmar = trim($_POST['ConfirmarContrasena']);

    // Validar que las contraseñas coincidan
    if ($contrasena !== $confirmar) {
        echo "<script>alert('❌ Las contraseñas no coinciden'); window.history.back();</script>";
        exit();
    }

    // Verificar si el usuario existe
    $check = $conexion->prepare("SELECT * FROM sesion WHERE Identificador = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $resultado = $check->get_result();

    if ($resultado->num_rows > 0) {
        // Actualizar los datos
        $sql = "UPDATE sesion 
                SET Documento = ?, Edad = ?, Nombres = ?, Apellidos = ?, Usuario = ?, Contrasena = ?, ConfirmarContrasena = ?
                WHERE Identificador = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iisssssi", $documento, $edad, $nombres, $apellidos, $usuario, $contrasena, $confirmar, $id);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Datos actualizados correctamente'); window.location.href='update.html';</script>";
        } else {
            echo "<script>alert('❌ Error al actualizar el usuario'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('⚠️ No existe un usuario con ese ID'); window.history.back();</script>";
    }

    $check->close();
    $conexion->close();
}
?>

