<?php

$db = new PDO("mysql:host={$_ENV['DB_PORT_3306_TCP_ADDR']};port={$_ENV['DB_PORT_3306_TCP_PORT']};dbname={$_ENV['DB_ENV_MYSQL_DATABASE']};charset=utf8", $_ENV['DB_ENV_MYSQL_USER'], '');

foreach($db->query('SELECT * FROM world') as $row) {
  echo "Hello ".$row['name']."<br>"; //etc...
}


?>
