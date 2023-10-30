<?php
// Marc Jornet Boeira
require_once "../env.php";
require_once "../mainFunctions.php";

$nameToLogin = $_POST["username"];
$passwordToLogin = $_POST["psw"];

//Aquesta funcio retorna un string per realitzar el login, si no retorna un missatge d'error.
$ferLogin = realitzarLogin($conn, $nameToLogin, $passwordToLogin);

//Si el login es correcte, es crea una sessio i es redirigeix a la pagina webLogada.php
if ($ferLogin == "Correcto"){
    session_start();
    $_SESSION['user'] = $nameToLogin;
    header("Location: webLogada.php");
}
//Si el login no es correcte, es mostra un missatge d'error i es redirigeix a la pagina index.php als 2 segons
else {
    echo $ferLogin;
    header("Refresh: 2; URL=index.php");
}
?>
