<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
  <div class="container-fluid container">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Início</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="orcamentos.php">Orçamentos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="consulta_cnpj_visualizacao.php">Consultar CNPJ</a>
          </li>
          <?php 
          // Esta área será exibida somente para os administradores do sistema
          if($_SESSION['login']['loggedUserLevel'] > 1){
          ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Cadastro
              </a>
              <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="produtos.php">Produtos</a></li>
                <li><a class="dropdown-item" href="automatizadores.php">Automatizadores</a>
                <!-- <div class="dropdown-divider"></div>
                <li><a class="dropdown-item" href="categorias.php">Categorias</a></li> -->
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Configurações
              </a>
              <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="listar_usuarios.php">Usuários</a></li>
                <li><a class="dropdown-item" href="editar_credenciais.php">Integração Bling</a>
              </ul>
            </li>
          <?php 
            }
          ?>
        </ul>
        <ul class="navbar-nav mb-2 ms-auto mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= isset($_SESSION['login']['loggedUserName'])?$_SESSION['login']['loggedUserName']:"Usuário"; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="alterar_senha.php">Trocar Senha</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="controller/logout.php">Sair</a>
          </li>
        </ul>



      </div>
    </div>
    <!-- <a class="navbar-brand " href="index.php">Invictos</a> -->
  </div>
</nav>