<?php
// Marc Jornet Boeira
require_once "../env.php";
require_once "../mainFunctions.php";


//Si l'usuari ja ha fet login, es redirigeix a la pagina webLogada.php i inicia la cookie que contabilitza els intents fallits
if (isset($_SESSION['user'])) {
    header("Location: webLogada.php");
    exit; 
}
//Si l'usuari no ha fet login, es comprova si la cookie d'errors existeix, si no existeix, es crea i es posa a 0.
if (!isset($_COOKIE["error"])) {
    setcookie("error", 0, time() + 3600);
    $cookie = 0;
}
// definicio de variables indispensables.
$emailToLogin = "";
$passwordToLogin = "";
$errores = array();
$captchaRequired = false;  // aquesta variable es per poder treballar amb el tema del reCaptcha de forma més neta.

//Comprova si l'usuari ha fet més de 3 intents fallits, si es aixi, activa la bandera del reCaptcha. 
if (isset($_COOKIE["error"]) && $_COOKIE["error"] >= 2){
    $captchaRequired = true;
}


if (isset($_POST['submit'])) {
$emailToLogin = $_POST["email"];
$passwordToLogin = $_POST["password"];

//Comprova si la bandera del reCaptcha esta activada.
if ($captchaRequired){
    header("Location: login.php"); //Aquest header està aquí perque si no al carregarse primer el controlador no pot agafar el g-recaptcha-response de la vista la primera vegada que salta el recaptcha, al fer un reaload de la pagina ja el pot agafar.
    $captcha = $_POST['g-recaptcha-response'];
    $secret = '6LckjvEoAAAAAPI90SKL3U-Qlg59jbbjKhAQR49V';

//Comprova si el reCaptcha esta buit, si es així, retorna un missatge d'error.
if(!$captcha){

    $errores[] = "Por favor verifica el captcha";
    
    } else {
   
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
    
    $arr = json_decode($response, TRUE);
    
    //Comprova si el reCaptcha es correcte, si es així, desactiva la bandera del reCaptcha per a poder fer el login.
    if($arr['success']){
        $captchaRequired = false;
        } else {
        $errores[] = 'Error al comprobar Captcha';
    }
}
}


//Aquesta funcio retorna un string per realitzar el login, si no retorna un missatge d'error.
$ferLogin = realitzarLogin($conn, $emailToLogin, $passwordToLogin);


//Si el login es correcte i la bandera del reCaptcha està desactivada es crea una sessio i es redirigeix a la pagina webLogada.php
if ($ferLogin == "Correcto" && $captchaRequired === false){
    session_start();
    session_set_cookie_params(25 * 60); // sessio de 25 minuts
    $_SESSION['user'] = $emailToLogin;
    setcookie("error", 0, time() - 3600); // Elimina la cookie d'errors.
    header("Location: webLogada.php");
} else {
    if ($ferLogin != "Correcto"){ 
        $errores[] = $ferLogin; 
    }

    $cookie = isset($_COOKIE["error"]) ? $_COOKIE["error"] + 1 : 1; // aquesta linia es per poder sumar els errors de login per així poder treballar amb la bandera.
    setcookie("error", $cookie, time() + 3600); // em de fer-ho mitjançant una variable i despres sobrescriure la cookie, ja que directament no es poden modificar les cookies.
    
}
};
include_once "../Vistes/login.vista.php"
?>
