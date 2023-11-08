<?php
require_once '../vendor/autoload.php';
require_once "../env.php";
require_once "../mainFunctions.php";
$config = [
    'callback' => 'http://localhost/BackEnd/Practiques/UF2/Pr%C3%A0ctiques/PT05/Controladors/githubLogin.php',
    'providers' => [
        'Github' => [
            'enabled' => true,
            'keys'    => [
                'key'    => '53a1d2d869e7cfa458e0',
                'secret' => '2b6bb2ce983f3ca954ee3f8de6d6aa9d851ed7c3'
            ],
        ],
    ],
];

try {
    $hybridauth = new Hybridauth\Hybridauth($config);
    $adapter = $hybridauth->authenticate('Github');
    $userProfile = $adapter->getUserProfile();
    
    // Ahora puedes acceder a las propiedades del perfil del usuario.

    $email = $userProfile->email;

    $cheekExist = comprovaExistencia($conn, $email);

    if ($cheekExist != "Correcto"){
        insertUserOauth($conn, $email, $name, "Github");
    }

    session_start();
    session_set_cookie_params(25 * 60); // sessio de 25 minuts
    $_SESSION['user'] = $email;

    header("Location: webLogada.php");
    
    $adapter->disconnect();
} catch (\Exception $e) {
    echo 'Oops, we ran into an issue! ' . $e->getMessage();
}
