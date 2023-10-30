<!DOCTYPE html>
<html lang="en">
<!--  Marc Jornet Boeira -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identifícate</title>
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
        <form action="../Controladors/login.php" method="post" id="form">
            <div class="mt-5 mb-5 flex-column text-center">
                <div class="mx-auto d-block">
                    <h3>Articulos</h3>
                </div>
                <h4>Identificación</h4>
            </div>

            <div class="form-group">
                <label>Introduzca su email: </label>
                <input type="text" class="form-control mb-4" placeholder="email" name="email" value="<?php if(isset($_POST['email']) && !empty($errores)){echo ($_POST['email']);} ?>">
            </div>
            <div class="form-group">
                <label>Introduzca su contraseña: </label>
                <input type="password" class="form-control mb-4" placeholder="Pass" name="password">
            </div>
            <input type="submit" name="submit" value="Login"></input>
            <span>
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