<!DOCTYPE html>
<html lang="en">
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
	<!-- Barra login/register per usuaris anonims -->
	<div class="topnav">
		<a class="active" href="../Controladors/index.php">Home</a>
		<a href="../Controladors/register.php">Registro</a>
		<div class="login-container">
			<form action="../Controladors/login.php" method="POST">
				<input type="text" placeholder="Usuario" name="username">
				<input type="password" placeholder="Contraseña" name="psw">
				<button type="submit">Login</button>
			</form>
		</div>
	</div>

	<!-- Contenidor d'articles -->

	<div class="contenidor">
		<h1>Articulos</h1>
		<section class="articles"> <!--aqui guardem els articles-->
			<?php
			//Crida de la funció, per mostrar els articles a la vista
			mostrarArticulosBBDD($conn, $articulosPorPagina, $paginaActual);
			?>
		</section>


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
		<form action="../Controladors/index.php" method="GET">
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