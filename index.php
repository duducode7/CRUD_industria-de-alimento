<?php
session_start();

if (!isset($_SESSION["id_usuario"])): ?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="card">
    <div class="login"><h3 class="login">Login</h3></div>
    <?php
    $msg = "";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $mysqli = new mysqli("localhost", "root", "root", "industria_de_alimentos");
        if ($mysqli->connect_errno) {
            die("Erro de conexão: " . $mysqli->connect_error);
        }
        $user = $_POST["nome_usuario"] ?? "";
        $pass = $_POST["senha_usuario"] ?? "";
        $stmt = $mysqli->prepare("SELECT id_usuario, nome_usuario, senha_usuario FROM usuarios WHERE nome_usuario=? AND senha_usuario=?");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();
        $dados = $result->fetch_assoc();
        $stmt->close();
        if ($dados) {
            $_SESSION["id_usuario"] = $dados["id_usuario"];
            $_SESSION["username"] = $dados["nome_usuario"];
            header("Location: index.php");
            exit;
        } else {
            $msg = "Usuário ou senha incorretos!";
        }
    }
    ?>
    <?php if ($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>
    <form method="post">
      <input type="text" name="nome_usuario" placeholder="Usuário" required>
      <input type="password" name="senha_usuario" placeholder="Senha" required>
      <button type="submit">Entrar</button>
    </form>
  </div>
</body>
</html>
<?php exit; endif; ?>

<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Menu Principal</title>
</head>
<body>
    <div class="card">
        <h2>Bem-vindo!</h2>
        <form method="get">
            <a href="create_usuario.php">Adicionar Usuário</a>
            <br><br>
            <a href="create.php">Cadastrar nova Tarefa</a>
            <br><br>
            <a href="read.php">Ver Tarefas</a>
            <br><br>
            <a href="index.php?logout=1">Sair</a>
            <br><br>
        </form>
    </div>
</body>
</html>