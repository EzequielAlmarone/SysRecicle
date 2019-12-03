<?php

/**
* Lista de CSS das paginas
* Encontre mais templates de Bootstrap em
* http://www.bootstrapcdn.com/#bootswatch_tab
*/
function headCss() {
  ?>
  <link href="./lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <?php headCssTema(TWITTER_BOOTSTRAP_TEMA); ?>

  <link href="./lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="./lib/estilos.css" rel="stylesheet"><?php
}

function headCssTema($tema=null) {
  $href = '';
  switch($tema) {
    case 'bootstrap';
    $href = './lib/bootstrap/css/bootstrap-theme.min.css';
    break;

    case 'cosmo':
    case 'cyborg':
    case 'darkly':
    case 'journal':
    case 'readable':
    case 'sandstone':
    case 'simplex':
    case 'slate':
    case 'superhero':
    case 'yeti':
    $href = "./lib/bootswatch/$tema/bootstrap.min.css";
    break;
  }

  if ($href) {
    ?><link href="<?php echo $href; ?>" rel="stylesheet"><?php
  }
}

/**
* Cria um window.alert com a $msg
* Se receber $url, executa um window.location = $url
* Se receber $fim = true, executa a instrucao exit
*
* @param string $msg Mensagem para o usuario
* @param string $url Url para redirecionar o usuario
* @param boolean $fim Se true, a funcao executa um exit
*/
function javascriptAlert($msg, $url = null, $fim = false) {
  ?><script>
  window.alert('<?php echo $msg; ?>');
  <?php if (null !== $url) { ?>
    window.location = '<?php echo $url; ?>';
    <?php } ?>
    </script><?php

    if ($fim) {
      exit;
    }
  }

  /**
  * Cria um window.alert com a $msg
  * Se receber $url, executa um window.location = $url
  * Esta funcao executa a instrucao exit
  *
  * @param string $msg Mensagem para o usuario
  * @param string $url Url para redirecionar o usuario
  */
  function javascriptAlertFim($msg, $url = null) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
      <title>Mensagem</title>
      <meta charset="utf-8">
    </head>
    <body>
      <?php javascriptAlert($msg, $url, false); ?>
    </body>
    </html>
    <?php
    exit;
  }

  /**
  * Converte um array de mensagens em HTML
  *
  * @param array $msg Lista das mensagens
  * @param string $boxType Tipo da mensagem
  *	Pode ser success, info, warning ou danger
  */
  function msgHtml($msg, $boxType = 'danger') {
    ?>
    <div class="alert alert-<?php echo $boxType; ?> alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <ul>
        <?php foreach($msg as $m) { ?>
          <li><?php echo $m; ?>;</li>
        <?php } ?>
      </ul>
    </div>
    <?php
  }

  /**
  * @param $cpf
  * @return bool
  * @link https://gist.github.com/guisehn/3276015
  */
  function validarCpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
    // Valida tamanho
    if (strlen($cpf) != 11)
    return false;
    // Calcula e confere primeiro dígito verificador
    for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
    $soma += $cpf{$i} * $j;
    $resto = $soma % 11;
    if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
    return false;
    // Calcula e confere segundo dígito verificador
    for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
    $soma += $cpf{$i} * $j;
    $resto = $soma % 11;
    return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
  }

  function hashSenha($senha) {
    return md5("abc-$senha");
  }

  function mask($val, $mask) {
    $maskared = '';
    $k = 0;
    for($i = 0; $i<=strlen($mask)-1; $i++) {
      if($mask[$i] == '#') {
        if(isset($val[$k]))
        $maskared .= $val[$k++];
      } else {
        if(isset($mask[$i]))
        $maskared .= $mask[$i];
      }
    }
    return $maskared;
  }

  /**
  * Recebe um CPF com somente numeros e retorna CPF mascarado
  * @param $cpf CPF somente numeros
  * @return string CPF mascarado
  */
  function maskCpf($cpf) {
    return mask($cpf,'###.###.###-##');
  }



  /**
  * recebe a conexão do banco de dados e id categoria
  **/
  function categoriaOptions($conn, $idcategoria){
    $sql = "SELECT idcategoria, nome_categoria From categoria ORDER BY nome_categoria"; // order by ordena as categorias em ordem alfabetica
    $res = $conn->query($sql);
    while($linha = $res->fetch(PDO::FETCH_ASSOC)){
      ?>
      <option
      value = "<?=$linha['idcategoria']?>"
      <?php if($linha['idcategoria'] == $idcategoria) { ?> selected <?php } ?>
      ><?=$linha['nome_categoria']?></option>


    <?php }
  }

  function existeCategoria($conn, $categoria, $idcategoria=0){
    $categoria = strtolower($categoria);
    $sql = "SELECT COUNT(idcategoria) contador From categoria Where (LOWER(nome_categoria) = '$categoria') And (idcategoria != '$idcategoria')";

    $res = $conn->query($sql);
    $linha = $res->fetch(PDO::FETCH_ASSOC);
    return($linha['contador'] > 0);
  }

  function existeMaterial($conn, $material, $idmaterial=0){
    $material = strtolower($material);
    $sql = "SELECT COUNT(idmaterial) contador From material Where (LOWER(nome_material) = '$material') And (idmaterial != '$idmaterial')";

    $res = $conn->query($sql);
    $linha = $res->fetch(PDO::FETCH_ASSOC);
    return($linha['contador'] > 0);
  }
