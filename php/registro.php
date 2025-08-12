<?php
$mysql = new mysqli("localhost", "adminforliveusers", "Adminforlive1*", "usuarios_forlive");

if ($mysql->connect_error) {
    die("Error de conexion: " . $mysql->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identificador = $_POST["identificador"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $password = $_POST["password"];

    if (!$email) {
        echo "Correo electrónico no válido.";
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysql->prepare("INSERT INTO usuarios (identificador, nombre, apellidos, email, password) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $identificador, $nombre, $apellidos, $email, $hash);

    if ($stmt->execute()) {
        header("Location: ../html/Inicio de Seción.html");
        exit;
    } else {
        echo "Error al registrarse: " .$stmt->error;
    }

    $stmt->close();
}
$mysql->close();
?>

<h2>Registro de Usuarios de ForLive</h2>
<form method="POST">
    Identificador: <input type="text" name="identificador" required><br>
    Nombre: <input type="text" name="nombre" required><br>
    Apellidos: <input type="text" name="apellidos" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Registrar">
</form>
