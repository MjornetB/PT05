<?php
// Marc Jornet Boeira
require "env.php";
try {
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD); // Connexió a la base de dades
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }


/**
 * registerUserBBDD - Funció que registra un usuari a la base de dades comprovant que no existeixi ja.
 * @param  mixed $conn Connexió a la base de dades
 * @param  mixed $name Nom de l'usuari
 * @param  mixed $email Correu electrònic de l'usuari
 * @param  mixed $password Contrasenya de l'usuari
 * @retorna string Retorna un string amb el resultat del registre
 */
function registerUserBBDD($conn, $name, $email, $password){
    try {
      $stmt = $conn->prepare("INSERT INTO usuaris (nom, contrasenya, email) VALUES (:nom, :contrasenya, :email)");
      $stmt->bindParam(':nom', $name);
      $stmt->bindParam(':contrasenya', $password);
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      return "Usuario creado correctamente";
  } catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        // Codi d'error 1062: 'Duplicate entry' (entrada duplicada) per a la clau primària
        return "El usuario $name ya existe.";
    } else {
        return "Error al insertar el usuario: " . $e->getMessage();
    }
  }
}

/**
 * realitzarLogin - Funció que realitza el login d'un usuari a la base de dades comprovant que existeixi i que la contrasenya sigui correcta.
 *
 * @param  mixed $conn Connexió a la base de dades
 * @param  mixed $nameToLogin Nom de l'usuari que vol fer login
 * @param  mixed $passwordToLogin Contrasenya de l'usuari que vol fer login
 * @retorna string Retorna un string amb el resultat del login
 */
function realitzarLogin($conn, $emailToLogin, $passwordToLogin){
  try {
      $stmt = $conn->prepare("SELECT contrasenya FROM usuaris WHERE email = :email");
      $stmt->bindParam(':email', $emailToLogin);
      $stmt->execute();
      $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if ($resultat !== false) { // Si hi han resultats
          if (password_verify($passwordToLogin, $resultat['contrasenya'])) {
              return "Correcto";
          } else {
              return "Contraseña erronea";
          }
      } else {
          return "Introduzca un usuario valido";
      }
  } catch (PDOException $e) {
      return "Error al realizar el login: " . $e->getMessage();
  }
}

/**
 * comprovaExistencia
 *
 * @param  mixed $conn conexxio
 * @param  mixed $emailToRecovery email per comprovar si exsiteix a la base de dades
 * @retorna un string per a poder fer el tractament depenent de si l'usuari existeix o no. 
 */
function comprovaExistencia($conn, $emailToRecovery){
  try {
      $stmt = $conn->prepare("SELECT * FROM usuaris WHERE email = :email");
      $stmt->bindParam(':email', $emailToRecovery);
      $stmt->execute();
      $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if ($resultat !== false) { // Si hi han resultats  
            return "Correcto";
      } else {
          return "Usuario no encontrado";
      }
  } catch (PDOException $e) {
      return "Error al realizar el login: " . $e->getMessage();
  }
}

/**
 * mostrarArticulosUsersBBDD - Funció que mostra els articles de l'usuari que esta logejat a la web
 *
 * @param  mixed $conn Connexió a la base de dades
 * @param  mixed $articulosPorPagina Numero d'articles que es mostraran per pagina
 * @param  mixed $offset Numero d'articles que es saltaran per poder veure els seguents articles tot el rato
 * @param  mixed $usuariLogat Nom de l'usuari que esta logejat
 */
function mostrarArticulosUsersBBDD($conn, $articulosPorPagina, $offset, $usuariLogat){
 // $stmtTemp = $conn->prepare("SELECT id FROM usuaris WHERE email = :email");
 // $stmtTemp->bindParam(':email', $usuariLogat);
 // $stmtTemp->execute();
  //$resultatTemp = $stmtTemp->fetch(PDO::FETCH_ASSOC);
  $_SESSION['idUser'] = getUserId($conn, $usuariLogat);//$resultatTemp["id"];
  $idUser = $_SESSION['idUser'];

  $stmt = $conn->prepare("SELECT * FROM articles WHERE id_usuaris = :idUser LIMIT :offset, :articulosPorPagina");
  $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
  $stmt->bindParam(':articulosPorPagina', $articulosPorPagina, PDO::PARAM_INT);
  $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
  $stmt->execute();
  

  echo '<ul>';
  echo '<li>' . "ID" . ': ' . "ARTICLE" . '</li>';
  while ($resultat = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo '<li>' . $resultat['id'] . ': ' . htmlspecialchars($resultat['article']) . '</li>';
  }
  
  echo '</ul>';
}

/**
 * getUserId - Funció que retorna l'id de l'usuari que esta logejat
 *
 * @param  mixed $conn
 * @param  mixed $email per rebre el id de l'usuari que esta logejat
 * @retorna el id de l'usuari que esta logejat
 */
function getUserId($conn, $email){
  $stmtTemp = $conn->prepare("SELECT id FROM usuaris WHERE email = :email");
  $stmtTemp->bindParam(':email', $email);
  $stmtTemp->execute();
  $resultat = $stmtTemp->fetch(PDO::FETCH_ASSOC);


  return $resultat["id"];
}

/**
 * introduirToken - Funció que introdueix el token a la base de dades
 *
 * @param  mixed $conn
 * @param  mixed $userId Id de l'usuari per el update
 * @param  mixed $token token que es genera per a guardar a la base de dades
 */
function introduirToken($conn, $userId, $token){
  $stmt = $conn->prepare("UPDATE usuaris SET reset_token = ?, time_token = NOW() WHERE id = ?");
  $stmt->bindParam(1, $token);
  $stmt->bindParam(2, $userId);
  $stmt->execute();
}


/**
 * changePass2BBDD - Funció que canvia la contrasenya a la base de dades comprovant que el token sigui correcte i que no hagi caducat en 1 hora.
 *
 * @param  mixed $conn
 * @param  mixed $id id de l'usuari per a poder fer el update
 * @param  mixed $password contrasenya que es vol canviar
 * @param  mixed $token token per a poder fer l'update si coincideix amb el de la base de dades
 * @retorna string per a poder saber si s'ha canviat la contrasenya o no
 */
function changePass2BBDD($conn, $id, $password, $token){
  try {
    $stmtemp = $conn->prepare("SELECT * FROM usuaris WHERE id = :id");
    $stmtemp->bindParam(':id', $id);
    $stmtemp->execute();
    $resultat = $stmtemp->fetch(PDO::FETCH_ASSOC);
    

        if ($resultat['reset_token'] == $token  && strtotime($resultat['time_token']) > strtotime('-1 hour')) {
          $stmt = $conn->prepare("UPDATE usuaris SET contrasenya = ? WHERE id = ?");
          $stmt->bindParam(1, $password);
          $stmt->bindParam(2, $id);
          $stmt->execute();
          return "Contraseña cambiada correctamente";
        } else {
            return "Token incorrecto o caducado, vuelva a solicitar el cambio de contraseña";
        }
} catch (PDOException $e) {
    return "Error al realizar el login: " . $e->getMessage();
}
}

/**
 * crearArticle - Funció que crea un article a la base de dades
 *
 * @param  mixed $conn Connexió a la base de dades
 * @param  mixed $article Article que es vol crear
 * @retorna boolean Retorna true si s'ha creat l'article i false si no s'ha creat
 */
function crearArticle($conn, $article){
    $idUser = $_SESSION['idUser'];
    $stmt = $conn->prepare("INSERT INTO articles (article, id_usuaris) VALUES (?, ?)");
      $stmt->bindParam(1, $article);
      $stmt->bindParam(2, $idUser);
      $stmt->execute();
        return true;
}

/**
 * verificarSiArticleEsPropi - Funció que verifica si l'article que es vol borrar o modificar es propi de l'usuari que esta logejat
 *
 * @param  mixed $conn Connexió a la base de dades
 * @param  mixed $id ID de l'article que es vol borrar o modificar
 * @retorna boolean Retorna true si l'article es propi de l'usuari i false si no ho es
 */
function verificarSiArticleEsPropi($conn, $id){
  $idUser = $_SESSION['idUser'];
  $stmtTemp = $conn->prepare("SELECT * FROM articles WHERE id = ?");
  $stmtTemp->bindParam(1, $id);
  $stmtTemp->execute();
  $resultat = $stmtTemp->fetch(PDO::FETCH_ASSOC);

    if ($resultat && isset($resultat['id_usuaris']) && $resultat['id_usuaris'] == $idUser){
      return true;
    }
    else return false;
}

/**
 * borrarArticle - Funció que borra un article de la base de dades
 *
 * @param  mixed $conn Connexió a la base de dades
 * @param  mixed $id ID de l'article que es vol borrar
 * @retorna boolean Retorna true si s'ha borrat l'article i false si no s'ha borrat
 */
function borrarArticle($conn, $id){
  if (existeixArticle($conn, $id)){
  $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
  $stmt->bindParam(1, $id);
  $stmt->execute();
    return true;
  } else {
    return false;
  }
}

/**
 * modificaArticle - Funció que modifica un article de la base de dades
 *
 * @param  mixed $conn Connexió a la base de dades
 * @param  mixed $id ID de l'article que es vol modificar
 * @param  mixed $article Article que es vol modificar
 * @retorna boolean Retorna true si s'ha modificat l'article i false si no s'ha modificat
 */
function modificaArticle($conn, $id, $article){
  if (existeixArticle($conn, $id)){
    $stmt = $conn->prepare("UPDATE articles SET article = ? WHERE id = ?");
    $stmt->bindParam(1, $article);
    $stmt->bindParam(2, $id);
    $stmt->execute();
    return true;
  } else {
    return false;
  }
}


/**
 * test_input - Funció que comprova que les dades que es passen per paràmetre estiguin ben formatejades
 *
 * @param  mixed $data Dades que es volen comprovar
 * @retorna Retorna les dades ja comprovades
 */
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  //Funció que inserta un usuari autentificat amb Oauth a la base de dades  
  /**
   * insertUserOauth - Funció que inserta un usuari autentificat amb autentificacio social a la base de dades
   *
   * @param  mixed $conn
   * @param  mixed $email de l'usuari a inserir
   * @param  mixed $name de l'usuari a inserir
   * @param  mixed $socialMedia de l'usuari a inserir
   * @return void
   */
  function insertUserOauth($conn, $email, $name, $socialMedia){
      $stmt = $conn->prepare("INSERT INTO usuaris (nom_provisional_oauth, email, social_provider) VALUES (:nom, :email, :socialMedia)");
      $stmt->bindParam(':nom', $name);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':socialMedia', $socialMedia);
      $stmt->execute();
  }
  /**
   * existeixArticle - Funció que comprova si un article existeix a la base de dades
   *
   * @param  mixed $conn Connexió a la base de dades
   * @param  mixed $id ID de l'article que es vol comprovar
   * @retorna boolean Retorna true si l'article existeix i false si no existeix
   */
  function existeixArticle($conn, $id) {
    $stmtTemp = $conn->prepare("SELECT id FROM articles WHERE id = ?");
    $stmtTemp->bindParam(1, $id);
    $stmtTemp->execute();
    $resultat = $stmtTemp->fetch(PDO::FETCH_ASSOC);

    return !empty($resultat);
}

?>