<?php
//MARC JORNET BOEIRA
require '../vendor/autoload.php';
require_once "../env.php";
require_once "../mainFunctions.php";

// Fem la crida a la llibreria de Google
use League\OAuth2\Client\Provider\Google;

// Config principal per a la connexió amb el servidor de Google mitjançant la llibreria Oauth2
$provider = new Google([ //proveidor, en aquest cas Google
    'clientId'     => '1015525338167-71pp6vbvlv93gi3oje7l6ld4h8c78ogq.apps.googleusercontent.com',
    'clientSecret' => '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',
    'redirectUri'  => 'http://localhost/BackEnd/Practiques/UF2/Pr%C3%A0ctiques/PT05/Controladors/googleCallback.php', // La URL deu coincidir amb la que hem posat a la configuració de la API de Google
]);
// Si no tenim el codi d'autorització, el demanem
if (!empty($_GET['code'])) {
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Obtenim el perfil de l'usuari
    $user = $provider->getResourceOwner($token);

    // Dades de l'usuari
    $email = $user->getEmail();
    $name = $user->getName();

    // Comprovem si l'usuari existeix a la base de dades
    $cheekExist = comprovaExistencia($conn, $email);

    // Si no existeix, l'insertem amb el email
    if ($cheekExist != "Correcto"){
        insertUserOauth($conn, $email, $name, "Google");
    }


    // Iniciem sessió
    session_start();
    session_set_cookie_params(25 * 60); // sessio de 25 minuts
    $_SESSION['user'] = $email;

    // Redirigim a la pàgina principal logada
    header("Location: webLogada.php");
}
