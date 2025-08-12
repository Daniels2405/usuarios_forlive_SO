<?php
// filepath: /home/daniel/Documents/GitHub/usuarios_forlive_SO/php/contacto.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $email = htmlspecialchars($_POST["email"]);
    $mensaje = htmlspecialchars($_POST["mensaje"]);
    $servicios = isset($_POST["servicios"]) ? $_POST["servicios"] : [];

    $servicios_texto = $servicios ? implode(", ", array_map('htmlspecialchars', $servicios)) : "No especificado";

    $to = "dbarrientos00383@ufide.ac.cr";
    $subject = "Nuevo mensaje de contacto de ForLive";
    $body = "Nombre: $nombre\nCorreo: $email\nServicios de interés: $servicios_texto\nMensaje:\n$mensaje";
    $headers = "From: $email\r\nReply-To: $email\r\n";

    if (mail($to, $subject, $body, $headers)) {
        echo "<script>alert('Mensaje enviado correctamente.');window.location.href='../html/Inicio.html';</script>";
    } else {
        echo "<script>alert('Error al enviar el mensaje.');window.history.back();</script>";
    }
} else {
    header("Location: ../html/Inicio.html");
    exit;
}
?>