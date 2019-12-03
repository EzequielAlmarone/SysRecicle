<?php

$dsn = 'mysql:host=' . BD_HOST . ';dbname=' . BD_NOME;

try {
  $conn = new PDO($dsn, BD_USUARIO, BD_SENHA);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
  echo "<pre>$e</pre>";
  exit;
}

