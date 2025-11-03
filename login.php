<?php

$mysqli = new mysqli("localhost", "root", "root", "industria_de_alimentos");
if ($mysqli->connect_errno) {
    die("Erro de conexão: " . $mysqli->connect_error);
}

session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Login </title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="card">
    <div class="login"><h3 class="login">Login</h3></div>
    <?php if ($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>
    <form method="post">
      <input type="text" name="nome_usuario" placeholder="Usuário" required>
      <input type="password" name="senha_usuario" placeholder="Senha" required>
      <button type="submit">Entrar</button>
    </form>
    <p><small>Dica: admin / 123</small></p>
  </div>

</body>
</html>