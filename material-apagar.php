<?php
require './protege.php';
require './config.php';
require './lib/conexao.php';
require './lib/funcoes.php';

$idmaterial = (int) $_GET['idmaterial'];
// Testar se material existe
$sql = "Select nome_material
From material
Where idmaterial = $idmaterial";
$res = $conn->query($sql);

$resMaterial = $res->fetch( PDO::FETCH_ASSOC );
if ($resMaterial === false) {
  javascriptAlertFim('O Material não existe', 'material.php');
  exit;
}

// Testar se material pode ser apagado
$sql = "SELECT COUNT(identrada) contador
FROM item_entrada
WHERE (idmaterial = $idmaterial)";
$res = $conn->query($sql);

$resContador = $res->fetch( PDO::FETCH_ASSOC );
if ( $resContador['contador'] > 0 ) {
  javascriptAlertFim('O material possui Movimentação e não pode ser apagada', 'material.php');
  exit;
}

// Apagar material
$sql = "DELETE FROM material
WHERE idmaterial = $idmaterial";
$conn->query($sql);

// Informar ao usuario que material foi apagada
$nomeMaterial = $resMaterial['nome_material'];
$msg = "O Material $nomeMaterial foi apagado";
javascriptAlertFim($msg, 'material.php');
