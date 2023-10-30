<?PHP
//MARC JORNET BOEIRA
require_once "../env.php";
require_once "../mainFunctions.php";

$name = "";
$email = "";
$password = "";
$password2 = "";
$errores = array();

//Comprova si l'usuari ha enviat el formulari
if (isset($_POST['submit'])) {
    

$name = $_POST["name"];
$email= $_POST["email"];
$password = $_POST["password"];
$password2 = $_POST["password2"];


//Comprovem les dades introduides
if($name == null){
    $errores[] = "El nombre es requerido";
}
elseif(!preg_match('/^[a-zA-Z0-9]{5,16}$/', $name)){
    $errores[] = "El nombre no tiene el formato válido, utilice letras de la a-z y numeros, evitando carácteres especiales. También tiene que contener entre 5 y 16 carácteres";
}


if($email == ""){
    $errores[] = "El email es requerido";
}
elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errores[] = "El email no tiene el formato válido";
}

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
$errores[] = registerUserBBDD($conn, $name, $email, $password);
}
};
include "../Vistes/register.vista.php";
?>
