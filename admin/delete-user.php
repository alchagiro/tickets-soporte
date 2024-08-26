<?php
session_start();
include("dbconnection.php"); // Asegúrate de incluir la conexión a la base de datos

// Verifica si se ha enviado un ID en la solicitud POST
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $user_id = intval($_POST['id']);
    
    // Prepara la declaración SQL para evitar inyecciones SQL
    $stmt = $con->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        // Redirige a la página de gestión de usuarios con un mensaje de éxito
        $_SESSION['message'] = "Usuario eliminado correctamente.";
        header("Location: manage-users.php");
    } else {
        // En caso de error, redirige a la página de gestión de usuarios con un mensaje de error
        $_SESSION['message'] = "Error al eliminar el usuario. Inténtalo de nuevo.";
        header("Location: manage-users.php");
    }
    
    $stmt->close();
} else {
    // Si el ID no está presente o no es válido, redirige con un mensaje de error
    $_SESSION['message'] = "ID de usuario no válido.";
    header("Location: manage-users.php");
}

$con->close(); // Cierra la conexión a la base de datos
?>
