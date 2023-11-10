<?php
//MARC JORNET BOEIRA
require '../vendor/autoload.php';

use League\OAuth2\Client\Provider\Google;

$provider = new Google([
    'clientId'     => '1015525338167-71pp6vbvlv93gi3oje7l6ld4h8c78ogq.apps.googleusercontent.com',
    'clientSecret' => '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',
    'redirectUri'  => 'http://localhost/BackEnd/Practiques/UF2/Pr%C3%A0ctiques/PT05/Controladors/googleCallback.php', // La URL debe coincidir con la configuración de Google
    
]);
// Agafem la URL d'autorització per a utilitzarla a la vista
$authUrl = $provider->getAuthorizationUrl();
?>