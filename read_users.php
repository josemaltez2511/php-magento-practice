<?php
// CONTROLADOR
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Revisa si la conexión falló
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crea la consulta SQL para obtener los datos
$sql = "SELECT id, firstname, lastname, email FROM users";
$result = $conn->query($sql);

// Cierra la conexión
$conn->close();

// Incluye la VISTA
// Si la consulta fue exitosa, pasamos el resultado a la vista
if ($result->num_rows > 0) {
    include 'users_view.php';
} else {
    echo "0 resultados";
}
?>