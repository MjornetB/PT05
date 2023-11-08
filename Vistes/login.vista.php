<!DOCTYPE html>
<html lang="en">
<!--  Marc Jornet Boeira -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identifícate</title>
    <link rel="stylesheet" href="../Estils/estil_register.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
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
                <input type="text" class="form-control mb-4" placeholder="email" name="email" value="<?php if (isset($_POST['email']) && !empty($errores)) {
                                                                                                            echo ($_POST['email']);
                                                                                                        } ?>">
            </div>
            <div class="form-group">
                <label>Introduzca su contraseña: </label>
                <input type="password" class="form-control mb-4" placeholder="Pass" name="password">
            </div>
            <?php
            if (isset($_COOKIE["error"]) && $_COOKIE["error"] >= 2) { // aixo permet que el recaptcha nomes surti quan hi ha 3 o mes errors(el 0 també compta com a error)
                echo "<label>Complete el captcha: </label>";
                echo '<div class="g-recaptcha" data-sitekey="6LckjvEoAAAAAPUlYVJeGZ_1pc17hag3GoDfgDnQ"></div>';
            }
            ?>
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
                <br><a href="../Controladors/passRecovery.php">Recupere su contraseña</a>
            </span>
        </form>
    </div>
    <div class="container">
        <img src="../Imatges/Google.svg">
        <?php require_once "../Controladors/googleLogin.php"; ?>
        <a href="<?php echo $authUrl ?>">Inicie sesión con Google</a>
    </div>
    <div class="container">
        <img src="../Imatges/twitter.svg">
        <a href="../Controladors/githubLogin.php">Inicie sesión con Github</a>
    </div>
</body>

</html>