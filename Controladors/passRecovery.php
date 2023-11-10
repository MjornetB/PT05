<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
// Marc Jornet Boeira
require_once "../env.php";
require_once "../mainFunctions.php";
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

if (isset($_SESSION['user'])) {
    header("Location: webLogada.php");
    exit; 
}

$emailToRecovery = "";
$errores = array();

if (isset($_POST['submit'])) {
    $emailToRecovery = $_POST["email"];

//Aquesta funcio retorna un string per realitzar el login, si no retorna un missatge d'error. (en aquest cas comprova si l'usuari existeix)
$checkUserExists = comprovaExistencia($conn, $emailToRecovery);



//Si l'usuari existeix es crea un token i s'envia un email amb el token i l'id de l'usuari per despres veure si el token es correcte.
if ($checkUserExists == "Correcto"){
    $userId = getUserId($conn, $emailToRecovery);
    $token = bin2hex(openssl_random_pseudo_bytes(16)); //Genera un token aleatori de 16 bytes i el converteix a hexadecimal.
    $mail = new PHPMailer(true);

try {
    $emailAEnviar = "";
    //Email settings
    $mail->SMTPDebug = 0;                  
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;                                
    $mail->Username   = 'm.jornetphp@gmail.com';              
    $mail->Password   = 'vjrp cddi ytlq nemw';                             
    $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_STARTTLS';         
    $mail->Port       = 587;                                    

    //Recipients
    $mail->setFrom('m.jornetphp@gmail.com', "At.Cliente web guay");
    $mail->addAddress($emailToRecovery);    
    $mail->isHTML(true);
    $mail->Subject = 'Formulari PHP';
    $mail->Body    = "http://localhost/BackEnd/Practiques/UF2/Pr%c3%a0ctiques/PT05/Controladors/passTokenCheck.php?id=" . $userId . "&token=" . $token ;

    $mail->send();
    $successMessage = "El email se ha enviado correctamente!";
    
} catch (Exception $e) {
    $errores[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
//Si el email s'ha enviat correctament, es crida a la funcio introduirToken per a introduir el token a la base de dades per despres fer la comprovació.
if ($successMessage){
    introduirToken($conn, $userId, $token);
}

}

else {
    $errores[] = $checkUserExists;
    //header("Refresh: 2; URL=index.php");
}
};
include_once "../Vistes/passRecovery.vista.php"
?>
