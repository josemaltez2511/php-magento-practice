<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    die("NO HAY CONEXION BRO: " . $conn->connect_error);
}

$user_id = $_GET['id'];

// Si el formulario fue enviado (petición POST), actualiza el usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del formulario
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    // Prepara la consulta SQL de manera segura
    $sql_update = "UPDATE users SET firstname=?, lastname=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql_update);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Vincula los parámetros (s = string, i = integer)
    $stmt->bind_param("sssi", $firstname, $lastname, $email, $user_id);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo "<h1>Usuario actualizado exitosamente.</h1>";
        echo "<a href='read_users.php'>Volver a la lista</a>";
    } else {
        echo "Error al actualizar: " . $stmt->error;
    }

    // Cierra la consulta preparada
    $stmt->close();
} else {
    // Si no es una petición POST, significa que se carga la página por primera vez
    // Obtiene los datos actuales del usuario para rellenar el formulario
    $sql_select = "SELECT firstname, lastname, email FROM users WHERE id=?";
    $stmt_select = $conn->prepare($sql_select);
    if ($stmt_select === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }
    $stmt_select->bind_param("i", $user_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $user = $result->fetch_assoc();
    $stmt_select->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>
    <form action="edit_user.php?id=<?php echo $user_id; ?>" method="post">
        <label for="firstname">Nombre:</label><br>
        <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>"><br>
        <label for="lastname">Apellido:</label><br>
        <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>"><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br><br>
        <input type="submit" value="Actualizar">
    </form>
</body>
</html>
<?php
}

$conn->close();
?>