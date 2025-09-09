<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer-master/src/Exception.php';
require __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer-master/src/SMTP.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre  = htmlspecialchars($_POST['nombre']);
    $correo  = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    if (empty($nombre) || empty($correo) || empty($mensaje)) {
        echo "<script>alert('Todos los campos son obligatorios'); window.history.back();</script>";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP (ejemplo Gmail)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'juandiguti@gmail.com';
        $mail->Password   = 'xevu gale rcss fhrl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Remitente y destinatario
        $mail->setFrom('juandiguti@gmail.com', 'Admin');
        $mail->addAddress('juandiguti@gmail.com', 'Soporte');

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = "Nuevo mensaje desde CMS N.O.A.H";
        $mail->Body    = "
            <h3>Nuevo mensaje de contacto</h3>
            <p><b>Nombre:</b> $nombre</p>
            <p><b>Correo:</b> $correo</p>
            <p><b>Mensaje:</b><br>$mensaje</p>
        ";

        $mail->send();
        echo "<script>alert('Mensaje enviado con éxito'); window.history.back();</script>";
    } catch (Exception $e) {
        echo "Error al enviar: {$mail->ErrorInfo}";
    }
}