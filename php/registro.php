<?php
$mysql = new mysqli("localhost", "adminforliveusers", "Adminforlive1*", "usuarios_forlive");

if ($mysql->connect_error) {
    die("Error de conexion: " . $mysql->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identificador = $_POST["identificador"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $password = $_POST["password"];

    //Se encripta el password 
    $hash = password_hash($password, PASSWORD_DEFAULT);

    //Se inserta el usuario
    $stmt = $mysql->prepare("INSERT INTO usuarios (identificador, nombre, apellidos, password) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $identificador, $nombre, $apellidos, $hash);

    if ($stmt->execute()) {
        // Redirige solo si el registro fue exitoso
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
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Registrar">
</form>
