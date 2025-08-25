<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Revisa la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Revisa si la petición es un POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del formulario de manera segura
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    // Prepara la consulta SQL con placeholders (?)
    $sql = "INSERT INTO users (firstname, lastname, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Revisa si la preparación de la consulta falló
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Vincula los parámetros (ss = string, string, string)
    // El orden de las 's' debe coincidir con el orden de las variables
    $stmt->bind_param("sss", $firstname, $lastname, $email);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo "<h1>Usuario añadido exitosamente.</h1>";
        echo "<a href='read_users.php'>Volver a la lista de usuarios</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cierra la consulta preparada
    $stmt->close();
} else {
    echo "Método de solicitud no válido.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>