<?PHP
//MARC JORNET BOEIRA
require_once "../env.php";
require_once "../mainFunctions.php";

if (isset($_SESSION['user'])) {
    header("Location: webLogada.php");
    exit; 
}

$id = "";
$password = "";
$password2 = "";
$token = "";
$errores = array();

//Comprova si l'usuari ha enviat el formulari
if (isset($_POST['submit'])) {
    

$id = $_POST["id"];
$token = $_POST["token"];
$password = $_POST["password"];
$password2 = $_POST["password2"];


//Comprovem les dades introduides

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
$errores[] = changePassBBDD($conn, $id, $password);
}
};
include "../Vistes/register.vista.php";
?>
