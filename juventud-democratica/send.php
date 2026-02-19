<?php
// send.php - Procesa el formulario de Juventud Democrática

// Solo aceptamos peticiones POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(403);
    echo "Acceso no permitido.";
    exit;
}

// Recoger y limpiar los datos del formulario
$nombre   = isset($_POST["nombre"]) ? strip_tags(trim($_POST["nombre"])) : "";
$email    = isset($_POST["email"])  ? trim($_POST["email"]) : "";
$mensaje  = isset($_POST["mensaje"])? strip_tags(trim($_POST["mensaje"])) : "";

// Validar que no estén vacíos y que el email sea válido
if (empty($nombre) || empty($mensaje) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Por favor, completa todos los campos correctamente (especialmente el email).";
    exit;
}

// --- CONFIGURACIÓN ---

$destinatario = "juventuddemocratica@atomicmail.io";   

// Asunto del correo
$asunto = "Nuevo mensaje de Juventud Democrática - $nombre";

// Construir el cuerpo del mensaje (texto plano)
$cuerpo = "Has recibido un nuevo mensaje desde la web:\n\n";
$cuerpo .= "Nombre: $nombre\n";
$cuerpo .= "Email: $email\n";
$cuerpo .= "Mensaje:\n$mensaje\n";

// Cabeceras para evitar que el correo se marque como spam
$headers = "From: Juventud Democrática <no-reply@{$_SERVER['HTTP_HOST']}>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Enviar el correo
if (mail($destinatario, $asunto, $cuerpo, $headers)) {
    // Éxito
    http_response_code(200);
    echo "¡Gracias por contactarnos! Te responderemos a la brevedad.";
} else {
    // Error al enviar
    http_response_code(500);
    echo "Hubo un error al enviar el mensaje. Por favor, inténtalo más tarde o escríbenos directamente a $destinatario.";
}
?>