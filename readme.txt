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