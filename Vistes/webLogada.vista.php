<!DOCTYPE html>
<html lang="en">
<!--  Marc Jornet Boeira -->
<?php
require_once "../mainFunctions.php";
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
if (!isset($_SESSION['user'])) {
	header("Location: logout.php");
}
?>
<!--  Marc Jornet Boeira -->

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../Estils/estils_pt03.css"> <!-- feu referència al vostre fitxer d'estils -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<title>Paginación</title>
</head>

<body>
	<!-- Barra per tencar sesió o anar al home si tenim algun problema -->
	<div class="topnav">
		<a class="active" href="../Controladors/webLogada.php">Home</a>
		<a href="../Controladors/logout.php">Cierra sesión</a>
	</div>

	<div class="contenidor">
		<h1>Articulos</h1>
		<section class="articles"> <!--aqui guardem els articles-->
			<?php
			//Crida de la funció, per mostrar els articles a la vista de l'usuari logat
			mostrarArticulosUsersBBDD($conn, $articulosPorPagina, $offset, $_SESSION['user']);
			?>
		</section>





		<!-- Aqui tenim totes les accions que cada usuari pot realitzar amb els seus articles -->
		<div class="AccionsUsuaris">
			<!-- Form de creació d'article -->
			<label>Crea un artículo</label>
			<form action="../Controladors/insertController.php" method="post">
				<input type="text" name="article" placeholder="Artículo" style="width : 400px; heigth : 400px">
				<input type="submit" name="enviaArticle" value="Añadir">
			</form>

			<!-- Missatje d'exit o errors -->
			<?php if (isset($successMessageInsert)) : ?>
				<div class="success-message"><?php echo $successMessageInsert; ?></div>
			<?php endif; ?>

			<?php if (!empty($erroresInsert)) : ?>
				<div class="error-message">
					<?php foreach ($erroresInsert as $error) : ?>
						<p><?php echo $error; ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<!-- Form de borrat d'article -->
			<label>Borra un artículo por su ID</label>
			<form action="../Controladors/deleteController.php" method="post">
				<input type="text" style="width : 40px; heigth : 40px" name="id" placeholder="ID">
				<input type="submit" name="esborraArticle" value="Borrar">
			</form>
			<!-- Missatje d'exit o errors -->
			<?php if (isset($successMessageDelete)) : ?>
				<div class="success-message"><?php echo $successMessageDelete; ?></div>
			<?php endif; ?>

			<?php if (!empty($erroresDelete)) : ?>
				<div class="error-message">
					<?php foreach ($erroresDelete as $error) : ?>
						<p><?php echo $error; ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<!-- Form de modificació d'article -->
			<label>Modifica un artículo mediante el ID</label>
			<form action="../Controladors/modifyController.php" method="post">
				<input type="text" style="width : 40px; heigth : 40px" name="id" placeholder="ID">
				<input type="text" name="article" value="<?php if(isset($_POST['article']) && !empty($erroresModify)){echo ($_POST['article']);} ?>" placeholder="Artículo" style="width : 400px; heigth : 400px">
				<input type="submit" name="modificaArticle" value="Modificar">
			</form>
			<!-- Missatje d'exit o errors -->
			<?php if (isset($successMessageModify)) : ?>
				<div class="success-message"><?php echo $successMessageModify; ?></div>
			<?php endif; ?>

			<?php if (!empty($erroresModify)) : ?>
				<div class="error-message">
					<?php foreach ($erroresModify as $error) : ?>
						<p><?php echo $error; ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>


		<!--  Paginació: comprovem si hi la pagina actual es més gran que la primera, i en cas afirmatiu, mostrem l'enllaç per tornar al principi -->
		<ul class="pagination">
			<?php if ($paginaActual > 1) {
				echo "<li><a href='?pagina=1'>Principio</a></li>";
			} ?>

			<!--  Paginació: comprovem si la pagina actual es la 1 per desabilitar el botó de principi -->
			<li <?php if ($paginaActual <= 1) {
					echo "class='disabled'";
				} ?>>
				<!-- Paginació: lo mateix que el primer cas pero per afegir el botó de tornar 1 pagina enrere -->
				<a <?php if ($paginaActual > 1) {
						echo "href='?pagina=$paginaPrevia'";
					} ?>>Previa</a>
			</li>
			<!-- Paginació: comprovem si la pagina actual es la ultima per desabilitar el botó de final -->
			<li <?php if ($paginaActual >= $numPagines) {
					echo "class='disabled'";
				} ?>>
				<!-- Paginació: si encara no estem a la pagina final, tenim disponible el botó de siguiente pagina -->
				<a <?php if ($paginaActual < $numPagines) {
						echo "href='?pagina=$siguientePagina'";
					} ?>>Siguiente</a>
			</li>

			<!-- Paginació: Comrpova si el num de pagines es inferior a 10 per mostrar tots els botons de totes les pagines
							si es superior a 10 mostra ... per no haver de mostrar totes lés pagines i saturar l'html. -->
			<?php if ($paginaActual < $numPagines) {
				echo "<li><a href='?pagina=$numPagines'>Final &rsaquo;&rsaquo;</a></li>";
			}
			if ($numPagines <= 10) {
				for ($counter = 1; $counter <= $numPagines; $counter++) {
					if ($counter == $paginaActual) {
						echo "<li class='active'><a>$counter</a></li>";
					} else {
						echo "<li><a href='?pagina=$counter'>$counter</a></li>";
					}
				}
			} elseif ($numPagines > 10) {
				if ($paginaActual <= 4) {
					for ($counter = 1; $counter < 8; $counter++) {
						if ($counter == $paginaActual) {
							echo "<li class='active'><a>$counter</a></li>";
						} else {
							echo "<li><a href='?pagina=$counter'>$counter</a></li>";
						}
					}
					echo "<li><a>...</a></li>";
					echo "<li><a href='?pagina=$penultimaPagina'>$penultimaPagina</a></li>";
					echo "<li><a href='?pagina=$numPagines'>$numPagines</a></li>";
				}
			} ?>
		</ul>


	</div>
</body>
<footer>
	<!-- Paginació: mostra el numero de pagina actual i el total de pagines -->
	<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
		<strong>Página <?php echo $paginaActual . " de " . $numPagines; ?></strong>
	</div>
	<div class="form-group">

		<!-- Paginació: mostra el selector de numero d'articles per pagina -->
		<form action="../Controladors/webLogada.php" method="GET">
			<label for="seleccionArticulos">Selecciona cuantos artículos quieres ver por página: </label>
			<select id="seleccionArticulos" name="seleccionArticulos" onchange="this.form.submit()">
				<option value="5" <?php if ($articulosPorPagina == 5) echo 'selected'; ?>>5</option>
				<option value="10" <?php if ($articulosPorPagina == 10) echo 'selected'; ?>>10</option>
				<option value="15" <?php if ($articulosPorPagina == 15) echo 'selected'; ?>>15</option>
			</select>
		</form>
		<br>
	</div>
</footer>

</html>