<?php
include 'db.php';

$usuario = $conn->query("SELECT id_usuario, nome_usuario FROM usuarios");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'];
    $setor = $_POST['setor'];
    $prioridade = $_POST['prioridade'];
    $status = $_POST['status'];
    $fk_usuario = $_POST['nome_usuario'];
    $erro = '';

    $stmt = $conn->prepare("INSERT INTO tarefas (descricao, setor, prioridade, status, fk_usuario) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $descricao, $setor, $prioridade, $status, $fk_usuario);
    $stmt->execute();
    $stmt->close();
    header("Location: read.php");
    exit;
} 
?>

<h2>Cadastrar tarefa</h2>
<form method="post">
    Descrição: <input type="text" name="descricao" required><br>
    Setor: <input type="text" name="setor" required><br>
    Prioridade: <select name="prioridade" required>
        <option value=“” disabled></option>
        <option value="Baixa">Baixa</option>
        <option value="Media">Média</option>
        <option value=“Alta”>Alta</option>
    </select>
    <br>
    Status: <select name="status" required>
        <option value="" disabled></option>
        <option value="A fazer">A fazer</option>
        <option value="Em andamento">Em andamento</option>
        <option value=“Concluido”>Concluído</option>
    </select>
    <br>
    Usuário:
    <select name="nome_usuario">
        <?php while($u = $usuario -> fetch_assoc()): ?>
            <option value="<?= $u['id_usuario'] ?>"><?= htmlspecialchars($u['nome_usuario']) ?></option>
        <?php endwhile ?>;
    </select>
    <br><br>

    <button type="submit">Cadastrar</button>
</form>
<a href="index.php">Voltar à lista</a>