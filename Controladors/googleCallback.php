<?php
require '../vendor/autoload.php';
require_once "../env.php";
require_once "../mainFunctions.php";

use League\OAuth2\Client\Provider\Google;

$provider = new Google([
    'clientId'     => '1015525338167-71pp6vbvlv93gi3oje7l6ld4h8c78ogq.apps.googleusercontent.com',
    'clientSecret' => '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',
    'redirectUri'  => 'http://localhost/BackEnd/Practiques/UF2/Pr%C3%A0ctiques/PT05/Controladors/googleCallback.php', // La URL debe coincidir con la configuración de Google
]);

if (!empty($_GET['code'])) {
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);


    $user = $provider->getResourceOwner($token);

    $email = $user->getEmail();
    $name = $user->getName();

    $cheekExist = comprovaExistencia($conn, $email);

    if ($cheekExist != "Correcto"){
        insertUserOauth($conn, $email, $name, "Google");
    }


    session_start();
    session_set_cookie_params(25 * 60); // sessio de 25 minuts
    $_SESSION['user'] = $email;

    header("Location: webLogada.php");
}
?>