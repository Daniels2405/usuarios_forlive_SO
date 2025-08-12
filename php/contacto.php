<?php
// filepath: /home/daniel/Documents/GitHub/usuarios_forlive_SO/php/contacto.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $mensaje = htmlspecialchars($_POST["mensaje"]);
    $servicios = isset($_POST["servicios"]) ? $_POST["servicios"] : [];

    if (!$email) {
        echo "<script>alert('Correo electrónico no válido.');window.history.back();</script>";
        exit;
    }

    $servicios_texto = $servicios ? implode(", ", array_map('htmlspecialchars', $servicios)) : "No especificado";

    $to = "dn.barrientossalas@gmail.com";
    $subject = "Nuevo mensaje de contacto de ForLive";
    $body = "Nombre: $nombre\nCorreo: $email\nServicios de interés: $servicios_texto\nMensaje:\n$mensaje";
    $headers = "From: noreply@localhost\r\nReply-To: $email\r\n";

    if (mail($to, $subject, $body, $headers)) {
        header("Location: ../html/Gracias.html");
        exit;
    } else {
        echo "<script>alert('Error al enviar el mensaje.');window.history.back();</script>";
    }
} else {
    header("Location: ../html/Inicio.html");
    exit;
}
?>