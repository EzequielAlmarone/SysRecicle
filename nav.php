<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./">SysRecycling</a>
    </div>

    <div class="collapse navbar-collapse" id="nav1">
      <ul class="nav navbar-nav">
        <li><a href="./">Home</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pessoas <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="clientes-cadastrar.php">Cadastrar Clientes</a></li>
            <li><a href="clientes.php">Pesquisar Clientes</a></li>
            <li class="divider"></li>
            <li><a href="usuarios-cadastrar.php">Cadastrar Usuários</a></li>
            <li><a href="usuarios.php">Pesquisar Usuários</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Material <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="material-cadastrar.php">Cadastrar Material</a></li>
            <li><a href="material.php">Pesquisar Material</a></li>
            <li class="divider"></li>
            <li><a href="categorias-cadastrar.php">Cadastrar categorias</a></li>
            <li><a href="categorias.php">Pesquisar categorias</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Movimentações<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="movimentacao-entrada.php">Entrada Material</a></li>
            <li><a href="movimentacao-saida.php">Saída Material</a></li>
            <li><a href="movimetacao.php">Pesquisar</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Relatórios <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="rel1.php">Movimentações por Consumidor</a></li>
            <li><a href="rel2.php">Movimentações por Fornecedor</a></li>
          </ul>
        </li>
        <li><a href="logout.php">Sair</a></li>
      </ul>
  </div>
</nav>
