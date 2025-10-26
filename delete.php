<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "sesion");

    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    $id = intval($_POST['id']);

    // Verificar si el registro existe antes de eliminarlo
    $check = $conexion->prepare("SELECT * FROM sesion WHERE Identificador = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $resultado = $check->get_result();

    if ($resultado->num_rows > 0) {
        // Eliminar el registro
        $sql = "DELETE FROM sesion WHERE Identificador = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Usuario eliminado correctamente'); window.location.href='delete.html';</script>";
        } else {
            echo "<script>alert('❌ Error al eliminar el usuario'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('⚠️ No existe un usuario con ese ID'); window.history.back();</script>";
    }

    $check->close();
    $conexion->close();
}
?>
