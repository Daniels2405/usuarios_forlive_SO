<?php
session_start();
$mysql = new mysqli("localhost", "adminforliveusers", "Adminforlive1*", "usuarios_forlive");

if ($mysql->connect_error) {
    die("Error de conexion: " . $mysql->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    // Permite login por identificador o email
    $stmt = $mysql->prepare("SELECT nombre, apellidos, email, password FROM usuarios WHERE identificador = ? OR email = ?");
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0) {
        $stmt->bind_result($nombre, $apellidos, $email, $hash_guardado);
        $stmt->fetch();
    
        if (password_verify($password, $hash_guardado)) {
            $_SESSION['usuario_logueado'] = true;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['apellidos'] = $apellidos;
            $_SESSION['email'] = $email;
            header("Location: ../html/Inicio.html");
            exit;
        } else {
            header("Location: ../html/Inicio de Seción.html?error=login");
            exit;
        }
    } else {
        header("Location: ../html/Inicio de Seción.html?error=login");
        exit;
    }

    $stmt->close();
}
$mysql->close();
?>

<h2>Iniciar Sesión</h2>
<form method="POST">
    Nombre de usuario o email: <input type="text" name="usuario" required><br>
    Contraseña: <input type="password" name="password" required><br>
    <input type="submit" value="Ingresar">
</form>
