<?php
//use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

$mail = new PHPMailer(true);

try{
    //Configuración del servidor
    $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;                                   //Habilitar autenticación SMTP
    $mail->Username   = 'depto.ventasmartinez@gmail.com';           //SMTP username
    $mail->Password   = 'aoguyvgrnkteucby';                     //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //ENCRYPTION_STARTTLS; //Habilitar el cifrado TLS implícito
    $mail->Port       = 465; //587;                              //Puerto TCP para conectarse; use 587 si configuró `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Destinatarios
    $mail->setFrom('depto.ventasmartinez@gmail.com', 'Tienda Online');
    $mail->addAddress('compras.mmartinezf56@gmail.com', 'Moises Martinez Flores'); //Agregar un destinatario
    
    //Contenido
    $mail->isHTML(true);                                  //Establecer el formato de correo electrónico en HTML
    $mail->Subject = 'Detalle de su compra';

    $cuerpo = '<h4>Gracias por su compra</h4>';
    $cuerpo .= '<p>El ID de su compra es: <b>' . $id_transaccion . '</b></p>';

    $mail->Body    = $cuerpo;
    $mail->AltBody = 'Le enviamos los detalles de su compra.';

    $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

    $mail->send();

} catch(Exception $e){
    echo "Error al enviar el email de la compra: {$mail->ErrorInfo}";
    //exit;
}

//sb-805c326872893@personal.example.com
//x(9dMcn+