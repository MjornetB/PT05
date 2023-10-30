<?php
// Marc Jornet Boeira
// cada cop que es crida aquesta pagina, es destrueix la sessio i es redirigeix a la pagina index.php (sessio anonima)
session_unset();
session_destroy();

header("Location: ../Controladors/index.php");
?>
