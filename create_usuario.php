<?php
include 'db.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome_usuario']);
    $email = trim($_POST['email_usuario']);
    $senha = trim($_POST['senha_usuario']);

    if (!$nome || !$email || !$senha) {
        $erro = 'Preencha todos os campos!';
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senha);
        if ($stmt->execute()) {
            header("Location: read.php");
            exit;
        } else {
            $erro = 'Erro ao cadastrar usuário.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadastrar Usuário</title>
</head>
<body>
<h2>Cadastrar Usuário</h2>
<?php if ($erro) echo "<p style='color:red;'>$erro</p>"; ?>
<form method="post">
    Nome: <input type="text" name="nome_usuario" required><br>
    Email: <input type="email" name="email_usuario" required><br>
    Senha: <input type="password" name="senha_usuario" required><br>
    <button type="submit">Cadastrar</button>
</form>
<a class=final href="index.php">Voltar à lista</a>
</body>
</html>