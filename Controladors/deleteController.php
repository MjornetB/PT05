<?php
//MARC JORNET BOEIRA
require_once "../env.php";
require_once "../mainFunctions.php";
$id = "";
$erroresDelete = array();

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
if ((isset($_POST['esborraArticle']))){
  $id = test_input($_POST["id"]);


    //Comprova si l'ID es buit o no es un numero
    if ($id == "") {
        $erroresDelete[] = "El ID del artículo es requerido";
    } elseif (!preg_match('/^\d+$/', $id)) {
        $erroresDelete[] = "El ID del artículo debe ser un número";
    }

    //Comprova si l'article que l'usuari vol esborrar es seu
    $deleteVerificator = verificarSiArticleEsPropi($conn, $id);

    //Si no hi ha errors, esborra l'article
    if (empty($erroresDelete)) {
        if ($deleteVerificator) {
            $borrarArticle = borrarArticle($conn, $id);
            if ($borrarArticle) {
                $successMessageDelete = "El artículo se ha borrado correctamente!";
                header("Location: webLogada.php");
            } else {
                $erroresDelete[] = "El artículo que desea borrar no existe";
            }
        } else {
            $erroresDelete[] = "El artículo que intenta borrar o no existe o no es suyo";
        }
    }
    include_once "webLogada.php";
    //header("Location: webLogada.php");
}
?>
