<?php 
require "../env.php";
// Marc Jornet Boeira
// condicional que serveix per establir quants articles es mostraran per pagina, si no hi ha cap seleccio es mostraran 5 articles per pagina.
if (isset($_GET['seleccionArticulos'])) {
  $articulosPorPagina = $_GET['seleccionArticulos'];
  setcookie('articulosPorPagina', $articulosPorPagina); 
} elseif (isset($_COOKIE['articulosPorPagina'])) {
  $articulosPorPagina = $_COOKIE['articulosPorPagina']; 
} else {
  $articulosPorPagina = 5; 
}

// condicional que serveix per establir quina pagina es la que es mostrara, si no hi ha cap seleccio es mostrara la pagina 1 evitant que es mostri un error.
if (isset($_GET['pagina']) && $_GET['pagina']!="" && is_numeric($_GET['pagina'])) {
  $paginaActual = $_GET['pagina'];
  } else {
      $paginaActual = 1;
      }

      
      $offset = ($paginaActual - 1) * $articulosPorPagina; // offset es el numero de articles que es saltaran per poder veure els seguents articles tot el rato.
      $paginaPrevia = $paginaActual - 1;
      $siguientePagina = $paginaActual + 1;
      $adyecentes = "2";

try {
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD); // Connexió a la base de dades
    $numPagines = obtenirTotalPagines($conn, $articulosPorPagina); // crida a la funcio que obté el total de pagines que hi ha fent el calcul amb els articles.

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $penultimaPagina = $numPagines - 1;

  // condicional que serveix per evitar que es mostri un error si la pagina actual es mes gran que el numero de pagines o si la pagina actual es menor o igual a 0
  if ($paginaActual > $numPagines || $paginaActual <= 0){
    $paginaActual = 1;
  }
  
  /**
   * mostrarArticulosBBDD es la funcio que mostra els articles de la base de dades fent una coneiexio a la base de dades i fent una consulta a la base de dades
   * per mostrar els articles que hi ha a la base de dades.
   *
   * @param  mixed $conn es la conexxiom a la base de dades
   * @param  mixed $articulosPorPagina es el numero de articles que es mostraran per pagina
   * @param  mixed $offset es el numero de articles que es saltaran per poder veure els seguents articles tot el rato.
   * @return void
   */
  function mostrarArticulosBBDD($conn, $articulosPorPagina, $offset){
    $stmt = $conn->prepare("SELECT * FROM articles LIMIT :offset, :articulosPorPagina");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':articulosPorPagina', $articulosPorPagina, PDO::PARAM_INT);
    $stmt->execute();
    

    echo '<ul>';
    
    while ($resultat = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<li>' . htmlspecialchars($resultat['article']) . '</li>';
    }
    
    echo '</ul>';
}

/**
 * obtenirTotalPagines es la funcio que obté el total de pagines que hi ha a la base de dades fent una consulta a la base de dades
 *  i fent un count per saber el total de articles que te, despres fa una divisió entre el numero de articles que es volen mostrar per pagina
 * per saber el total de pagines que hi ha.
 *
 * @param  mixed $conn es la conexxiom a la base de dades
 * @param  mixed $articulosPorPagina es el numero de articles que es mostraran per pagina
 * @return int $totalPagines es el total de pagines que hi ha a la base de dades
 */
function obtenirTotalPagines($conn, $articulosPorPagina){
  $stmt = $conn->prepare("SELECT COUNT(*) FROM articles");
  $stmt->execute();
  $totalArticles = $stmt->fetchColumn();
  $totalPagines = ceil($totalArticles / $articulosPorPagina);
  return $totalPagines;
}


include "../Vistes/index.vista.php"
?>