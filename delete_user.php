<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del usuario de la URL
$user_id = $_GET['id'];

$sql = "DELETE FROM users WHERE id=$user_id";

if ($conn->query($sql) === TRUE) {
    echo "Usuario borrado exitosamente. <a href='read_users.php'>Volver a la lista</a>";
} else {
    echo "Error al borrar: " . $conn->error;
}

$conn->close();
?>