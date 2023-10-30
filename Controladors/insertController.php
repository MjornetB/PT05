<?php
//MARC JORNET BOEIRA
require_once "../env.php";
require_once "../mainFunctions.php";
$article = "";
$erroresInsert = array();
//Comprova si l'usuari esta logejat
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
//Si no esta logejat el redirigeix a la pagina de logout, que aixo el porta al index.
if (!isset($_SESSION['user'])) {
  header("Location: logout.php");
  exit;
}
//Comprova si l'usuari ha enviat el formulari
if ((isset($_POST['enviaArticle']))) {
  $article = test_input($_POST["article"]);


  //Comprova si l'article es buit o te caracters no permesos
  if ($article == "") {
    $erroresInsert[] = "El articulo es requerido";
  } elseif (!preg_match('/^[a-zA-Z0-9\s,.-]*$/', $article)) {
    $erroresInsert[] = "El artículo contiene caracteres no permitidos";
  };

  //Si no hi ha errors, crea l'article
  if (empty($erroresInsert)) {
    $crearArticle = crearArticle($conn, $article);
    if ($crearArticle) {
      $successMessageInsert = "El artículo se ha creado correctamente!";
    } else {
      $erroresInsert[] = "Error al crear el artículo";
    }
  }
  include_once "webLogada.php";
}
?>
