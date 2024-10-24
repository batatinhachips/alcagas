<!DOCTYPE html>
<html lang="pt-BR">
<?php
session_start();
?>

<head>
  <title>ADMINISTRAÇÃO</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- LINKS -->
  <link rel="icon" href="../recursos/imagens/icon.png" type="image/png">
  <link href="../recursos/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../recursos/css/styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="../recursos/js/bootstrap.bundle.min.js"></script>
  <script src="../recursos/js/jquery-3.5.1.slim.min.js"></script>
  <script src="../recursos/js/popper.min.js"></script>
  <script src="../recursos/js/script.js"></script>


  <!-- FIM DOS LINKS -->
</head>
<?php
include '../controladora/conexao.php';
include '../modelo/usuario.php';
include '../repositorio/usuarios_repositorio.php';
include "../controladora/autenticacao.php";

$usuariosRepositorio = new usuarioRepositorio($conn);
$usuarios = $usuariosRepositorio->buscarTodosAdmins();

?>

<body class="usuario-admin">

  <nav class="navbar navbar-expand-sm navbar-custom navbar-dark fixed-top">
    <div class="container-fluid">
      <!-- NAVBAR -->
      <a class="navbar-brand" href="/">
        <img src="../recursos/imagens/logo.png" alt="Logo da Empresa" style="height: 40px;">
      </a>
      <!-- Botões de Logar e Cadastrar -->
      <div class="botao-admin">
        <a class="btn btn-light ms-2" href="../visao/cadastrar_admin.php">Novo Admin</a>
        <a class="btn btn-light ms-2" href="../visao/cadastrar_produtos.php">Novo Produto</a>
      </div>
    </div>

    <!-- Ícone do Menu Hambúrguer -->
    <div class="menu-icon" onclick="toggleMenu()">
      <i class="bi bi-list"></i>
    </div>

    <!-- Menu Dropdown -->
    <nav id="menu" class="menu">
      <?php
      if (isset($_SESSION["nome_usuario"])) {
        echo "<div class='user-name'>" . $_SESSION["nome_usuario"] . "</div>";
      }
      ?>
      <li class="dropdown-content">
        <a class="dropdown-item" href="admin.php" style="margin-left: auto;">Voltar</a>
      </li>
      <div class="dropdown-content">
        <?php if (isset($_SESSION["nome_usuario"])) { ?>
          <a class="dropdown-item" href="../controladora/logout.php">Sair</a>
        <?php } else { ?>
          <a class="dropdown-item" href="formLogin.php">Login</a>
        <?php } ?>
      </div>
    </nav>
    </div>
  </nav>

  <section id="services" class="services">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <br>
        <br>
        <br>
      </div>


      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nome</th>
              <th scope="col">Email</th>
              <th scope="col">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($usuarios as $usuario) : ?>
              <tr>
                <th scope="row"><?= $usuario->getIdUsuario() ?></th>
                <td><?= $usuario->getNome() ?></td>
                <td><?= $usuario->getEmail() ?></td>
                <td>
                  <form action="../visao/editar_admin.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $usuario->getIdUsuario(); ?>">
                    <input type="submit" class="btn btn-success" value="Editar">
                  </form>
                  <form action="../controladora/processar_exclusao.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $usuario->getIdUsuario(); ?>">
                    <input type="hidden" name="tipo" value="usuario">
                    <input type="hidden" name="pagina_origem" value="admin_tabela">
                    <input type="submit" class="btn btn-danger" value="Excluir">
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>


    </div>
  </section>

</body>

</html>