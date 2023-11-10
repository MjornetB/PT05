<?PHP
//MARC JORNET BOEIRA
require_once "../env.php";
require_once "../mainFunctions.php";

if (isset($_SESSION['user'])) {
    header("Location: webLogada.php");
    exit; 
}

//si el token i l'id existeixen, es creen les cookies amb el token i l'id. 
if (isset($_GET['token']) && isset($_GET['id'])){
    setcookie("token", $_GET['token'], time() + 3600);
    setcookie("id", $_GET['id'], time() + 3600);
} 
else{
    $errores[] = "No se ha encontrado el token";
}
$password = "";
$password2 = "";
$errores = array();

//Comprova si l'usuari ha enviat el formulari
if (isset($_POST['submit'])) {
    

$password = $_POST["password"];
$password2 = $_POST["password2"];

//Comprovem les passwords i les comprovem entre elles.

if($password == ""){
    $errores[] = "La contraseña es requerida";
}
elseif(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,18}$/', $password)){
    $errores[] = "La contraseña no tiene el formato válido, tiene que contener al menos un número, al menos una letra o algun caracter especial de estos: !@#$% y entre 8 y 18 carácteres";
}

if ($password != $password2){
    $errores[] = "Las contraseñas no coinciden";
}

//Encriptem la contrasenya
$password = password_hash($password, PASSWORD_BCRYPT);

//Si no hi ha errors, es crea l'usuari
if (isset($_POST['submit']) && empty($errores)) {
$id = $_COOKIE["id"];
$token = $_COOKIE["token"];
$errores[] = changePass2BBDD($conn, $id, $password, $token); //Aquesta funcio canvia la pass comprovant si el token i l'id coincideixen amb els de la base de dades.
setcookie("token", "", time() - 3600); //Esborrem les cookies.
setcookie("id", "", time() - 3600);
}
};
include "../Vistes/passTokenCheck.vista.php";
?>
