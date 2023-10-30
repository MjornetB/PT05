<!DOCTYPE html>
<html lang="en">
<!--  Marc Jornet Boeira -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recupere su usuario</title>
    <link rel="stylesheet" href="../Estils/estil_register.css">
</head>
<!-- Barra per tornar al home -->
<body>
<div class="topnav">
  <a href="../Controladors/index.php">Home</a>
  <a href="../Controladors/register.php">Registro</a>
</div>
    <div class="container">

        <!-- Formulari de registre -->
        <form action="../Controladors/passRecovery.php" method="post" id="form">
            <div class="mt-5 mb-5 flex-column text-center">
                <div class="mx-auto d-block">
                    <h3>Articulos</h3>
                </div>
                <h4>Recuperación de usuario</h4>
            </div>

            <div class="form-group">
                <label>Introduzca una contraseña segura: </label>
                <input type="password" class="form-control mb-4" placeholder="Pass" name="password">
            </div>
            <div class="form-group">
                <label>Repita su contraseña: </label>
                <input type="password" class="form-control mb-4" placeholder="Pass" name="password2">
            </div>
            <input type="submit" name="submit" value="Recupere su usuario"></input>
            <span>
            <?php if (isset($successMessage)) : ?>
				<div class="success-message"><?php echo $successMessage; ?></div>
			<?php endif; ?>
                <?php
                if (isset($_POST['submit']) && !empty($errores)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errores as $error) {
                        echo "<li>$error</li>";
                    }
                    echo "</div>";
                }
                ?>
            </span>
        </form>
    </div>
</body>

</html>