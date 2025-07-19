<?php
$mysql = new mysqli("localhost", "adminforliveusers", "Adminforlive1*", "usuarios_forlive");

if ($mysql->connect_error) {
    die("Error de conexion: " . $mysql->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identificador = $_POST["identificador"];
    $password = $_POST["password"];

    $stmt = $mysql->prepare("SELECT nombre, apellidos, password FROM usuarios WHERE identificador = ?");
    $stmt->bind_param("s", $identificador);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0) {
        $stmt->bind_result($nombre, $apellidos, $hash_guardado);
        $stmt->fetch();
    
        if (password_verify($password, $hash_guardado)) {
            echo "Bienvenido $nombre $apellidos";
        } else {
            echo "Password incorrecto.";
        }
    } else {
        echo "Usuario no encontrado";
    }

    $stmt->close();
}
$mysql->close();
?>

<h2>Iniciar Sesión</h2>
<form method="POST">
    Identificador: <input type="text" name="identificador" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Ingresar">
</form>
