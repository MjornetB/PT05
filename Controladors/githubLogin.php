<?php
//MARC JORNET BOEIRA
require_once '../vendor/autoload.php';
require_once "../env.php";
require_once "../mainFunctions.php";

// Config principal per a la connexió amb el servidor de GitHub mitjançant la llibreria Hybridauth
$config = [
    'callback' => 'http://localhost/BackEnd/Practiques/UF2/Pr%C3%A0ctiques/PT05/Controladors/githubLogin.php', //URL de callback, a on fem la crida al servidor.
    'providers' => [
        'Github' => [ //proveidor, canviant aixó es pot fer login amb altres xarxes socials
            'enabled' => true,
            'keys'    => [
                'key'    => '53a1d2d869e7cfa458e0',  // key 
                'secret' => '2b6bb2ce983f3ca954ee3f8de6d6aa9d851ed7c3'
            ],
        ],
    ],
];

try {
    // Creem una nova instància de la classe Hybridauth
    $hybridauth = new Hybridauth\Hybridauth($config);
    // Demanem al proveidor que ens autentiqui
    $adapter = $hybridauth->authenticate('Github');
    // Obtenim el perfil de l'usuari
    $userProfile = $adapter->getUserProfile();
    
    
    // Dades de l'usuari
    $email = $userProfile->email;
    $name = $userProfile->firstName . " " . $userProfile->lastName;

    // Comprovem si l'usuari existeix a la base de dades
    $cheekExist = comprovaExistencia($conn, $email);

    // Si no existeix, l'insertem amb el email
    if ($cheekExist != "Correcto"){
        insertUserOauth($conn, $email, $name, "Github");
    }

    // Iniciem sessió
    session_start();
    session_set_cookie_params(25 * 60); // sessio de 25 minuts
    $_SESSION['user'] = $email; 

    // Redirigim a la pàgina principal logada
    header("Location: webLogada.php");
    // Desconnectem
    $adapter->disconnect();
} catch (\Exception $e) {
    echo 'Oops, we ran into an issue! ' . $e->getMessage();
}
