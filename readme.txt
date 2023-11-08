Marc Jornet Boeira:

Usuaris login: MarcGuapo, Rodrigo
password login: @marcguap0

Problemes trobats: Al fer algun tipus de interacció amb la BBDD un cop logat, si hi han més de 5 articles, que son els minims necessaris per que es crei la segona
pàgina, i s'estan mostrant 5 (poden mostrar-se 5,10 o 15). i es canvia de pàgina salta un error, ja que l'url s'estableix com el controlador de la operació realitzada
i intenta accedir a la pagina 2 d'aquest controlador en comptes de la pagina de l'usuari logat, per lo tant peta. (exemple: url base webLogada.php -> borro un article, canvio de pagina i passa a ser -> deleteController.php?page=2 -> peta)

La unica solució que he pensat es un cop realitzada l'accio CRUD seroa redirigir a la pagina de l'usuari logat amb un header, pero si fes això no podria mostrar els missatges
d'operació realitzada o d'error en cas d'error. Per lo tant he decidit no fer aquesta solució i deixar-ho com està, amb menys de 5 articles.


I amb el login, si falla vaig al login.php que no existeix com a vista, per aixo he posat un temporitzador, que en cas de fallar, mostri el perque del fallo i als 2 segons torni al index(pagina principal modo anonimo)

*/

350990552000-70q1d43lfs7r14gpv64sn7367qugpt01.apps.googleusercontent.com id cliente
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 secreto cliente

<?php
require_once 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('350990552000-70q1d43lfs7r14gpv64sn7367qugpt01.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://your-redirect-uri');
$client->addScope(Google_Service_Drive::DRIVE);

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
} 

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
    // Ahora puedes hacer solicitudes a la API de Google en nombre del usuario
} else {
    // Redirige al usuario a la página de autenticación de Google
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
}
?>





1015525338167-71pp6vbvlv93gi3oje7l6ld4h8c78ogq.apps.googleusercontent.com

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



804247737721420   identificador facebook

f4d0d44fb4009d35005fc2a4bb7dc0ac clave secreta facebook 


Q7slkYOU6jfd3om5SVIE9vPIX

vQJo1DjzmP5NdDFaXaxyLSihVYC2uZkmSwUYjgu3iBOCAITLZS