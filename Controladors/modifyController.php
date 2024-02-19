<?php
//MARC JORNET BOEIRA
require_once "../env.php";
require_once "../mainFunctions.php";
$id = "";
$article = "";
$erroresModify = array();
//Comprova si l'usuari esta loguejat, si no ho esta, el redirigeix a la pagina de logout.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: logout.php");
    exit; 
}
//Comprova si l'usuari ha enviat el formulari de modificar article
if ((isset($_POST['modificaArticle']))){
  $id = test_input($_POST["id"]);
  $article = test_input($_POST["article"]);

  //Comprova si l'id i l'article son valids
    if ($id == "") {
        $erroresModify[] = "El ID del artículo es requerido";
    } elseif (!preg_match('/^\d+$/', $id)) {
        $erroresModify[] = "El ID del artículo debe ser un número";
    }
    if ($article == "") {
        $erroresModify[] = "No puedes dejar el artículo resultante vacío";
      } 
      elseif (!preg_match('/^[a-zA-Z0-9\s,.-]*$/', $article)) {
        $erroresModify[] = "El artículo contiene caracteres no permitidos";
        };
      

    //Comprova si l'article que l'usuari vol modificar es seu
    $modifyVerificator = verificarSiArticleEsPropi($conn, $id);

    //Si no hi ha errors, es modifica l'article
    if (empty($erroresModify)) {
        if ($modifyVerificator) {
            $modificaArticle = modificaArticle($conn, $id, $article);
            if ($modificaArticle) {
                $successMessageModify = "El artículo se ha modificado correctamente!";
                setcookie("modify", $successMessageModify, time() + 3600);
                header("Location: webLogada.php");
            } else {
                $failModify = "El artículo que desea modificar no existe";
                setcookie("modify", $failModify, time() + 3600);
                header("Location: webLogada.php");
            }
        } else {
            $failModifyUser = "El artículo que intenta modificar o no existe o no es suyo";
            setcookie("modify", $failModifyUser, time() + 3600);
            header("Location: webLogada.php");
        }
    }
    include_once "webLogada.php";
}
?>
