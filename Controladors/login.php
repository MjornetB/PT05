<?php
// Marc Jornet Boeira
require_once "../env.php";
require_once "../mainFunctions.php";

$emailToLogin = "";
$passwordToLogin = "";
$errores = array();

if (isset($_POST['submit'])) {
$emailToLogin = $_POST["email"];
$passwordToLogin = $_POST["password"];

//Aquesta funcio retorna un string per realitzar el login, si no retorna un missatge d'error.
$ferLogin = realitzarLogin($conn, $emailToLogin, $passwordToLogin);

//Si el login es correcte, es crea una sessio i es redirigeix a la pagina webLogada.php
if ($ferLogin == "Correcto"){
    session_start();
    $_SESSION['user'] = $emailToLogin;
    header("Location: webLogada.php");
}
//Si el login no es correcte, es mostra un missatge d'error i es redirigeix a la pagina index.php als 2 segons
else {
    $errores[] = $ferLogin;
    //header("Refresh: 2; URL=index.php");
}
};
include_once "../Vistes/login.vista.php"
?>
