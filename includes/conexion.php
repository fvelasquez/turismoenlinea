<?php
//DEFINE('BDD_NAME','richam_turismoenlinea');
DEFINE('BDD_USER','richam_turismo');
DEFINE('BDD_PASSWORD','tur1sm03nl1n3@');
//DEFINE('BDD_HOST','localhost');

DEFINE('BDD_NAME','richam_turismoenlinea');
//DEFINE('BDD_USER','root');
//DEFINE('BDD_PASSWORD','root');
DEFINE('BDD_HOST','localhost');
DEFINE('URL_SITIO','Turismoenlinea.org');

$mysql_db  = new fDatabase('mysql', BDD_NAME, BDD_USER, BDD_PASSWORD, BDD_HOST);

?>