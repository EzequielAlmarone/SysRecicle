<?php

require './protege.php';
require './config.php';
require './lib/conexao.php';
require './lib/funcoes.php';

$idcategoria = (int) $_GET['idcategoria'];

// Testar se categoria existe
$sql = "Select nome_categoria
From categoria
Where idcategoria = $idcategoria";
$res = $conn->query($sql);

$resCategoria = $res->fetch( PDO::FETCH_ASSOC );
if ($resCategoria === false) {
  javascriptAlertFim('A categoria não existe', 'categorias.php');
  exit;
}

// Testar se categoria pode ser apagada
$sql = "SELECT COUNT(idmaterial) contador
FROM material
WHERE (idcategoria = $idcategoria)";
$res = $conn->query($sql);

$resContador = $res->fetch( PDO::FETCH_ASSOC );
if ( $resContador['contador'] > 0 ) {
  javascriptAlertFim('A categoria possui produtos e não pode ser apagada', 'categorias.php');
  exit;
}

// Apagar categoria
$sql = "DELETE FROM categoria
WHERE idcategoria = $idcategoria";
$conn->query($sql);

// Informar usuario que categoria foi apagada
$nomeCategoria = $resCategoria['nome_categoria'];
$msg = "A categoria $nomeCategoria foi apagada";
javascriptAlertFim($msg, 'categorias.php');
