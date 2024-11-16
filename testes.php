<?php
    include('partials/head.php');
?>


<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
  <div class="container">
    <!-- <a class="navbar-brand" href="#">Logo</a> -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pedidos.php">Pedidos</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="orcamentos.php">Orçamentos</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="consulta_cnpj_visualizacao.php">Consultar CNPJ</a>
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Pedidos
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="new_order.php">Novo</a></li>
            <li><a class="dropdown-item" href="orders.php">Histórico</a></li>
          </ul>
        </li> -->

        <?php 
          // Esta área será exibida somente para os administradores do sistema
          if($_SESSION['loggedUserLevel'] > 1){
        ?>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Admin
            </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="listar_usuarios.php">Usuários</a></li>
            <li><a class="dropdown-item" href="editar_credenciais.php">Credenciais do sistema</a></li>
          </ul>

        <?php 
          }
        ?>

      </ul>
      <ul class="navbar-nav mb-2 ms-auto mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= isset($_SESSION['loggedUserName'])?$_SESSION['loggedUserName']:"Usuário"; ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="alterar_senha.php">Trocar Senha</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="controller/logout.php">Sair</a>
        </li>
      </ul>
    </div>
  </div>
</nav>