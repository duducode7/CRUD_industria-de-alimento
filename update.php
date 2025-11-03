<?php
include 'db.php';

$id = intval($_GET['id']);
$tarefa = $conn->query("SELECT * FROM tarefas WHERE id_tarefa = $id")->fetch_assoc();
$usuarios = $conn->query("SELECT id_usuario, nome_usuario FROM usuarios");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'];
    $setor = $_POST['setor'];
    $prioridade = $_POST['prioridade'];
    $status = $_POST['status'];
    $fk_usuario = $_POST['fk_usuario'];
    $stmt = $conn->prepare("UPDATE tarefas SET descricao=?, setor=?, prioridade=?, status=?, fk_usuario=? WHERE id_tarefa=?");
    $stmt->bind_param("sssssi", $descricao, $setor, $prioridade, $status, $fk_usuario, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: read.php");
    exit;
}
?>

<h2>Editar Medicamento</h2>

<?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

<form method="post">
    Descrição: <input type="text" name="descricao" value="<?= htmlspecialchars($tarefa['descricao']) ?>" required><br>
    Setor: <input type="text" name="setor" value="<?= htmlspecialchars($tarefa['setor']) ?>" required><br>
    Prioridade:
    <select name="prioridade" required>
        <option value="" disabled></option>
        <option value="Baixa" <?= $tarefa['prioridade'] == 'Baixa' ? 'selected' : '' ?>>Baixa</option>
        <option value="media" <?= $tarefa['prioridade'] == 'media' ? 'selected' : '' ?>>Média</option>
        <option value="alta" <?= $tarefa['prioridade'] == 'alta' ? 'selected' : '' ?>>Alta</option>
    </select><br>
    Status:
    <select name="status" required>
        <option value="" disabled></option>
        <option value="fazer" <?= $tarefa['status'] == 'fazer' ? 'selected' : '' ?>>A fazer</option>
        <option value="andamento" <?= $tarefa['status'] == 'andamento' ? 'selected' : '' ?>>Em andamento</option>
        <option value="concluido" <?= $tarefa['status'] == 'concluido' ? 'selected' : '' ?>>Concluído</option>
    </select><br>
    Usuário:
    <select name="fk_usuario" required>
        <?php while($u = $usuarios->fetch_assoc()): ?>
            <option value="<?= $u['id_usuario'] ?>" <?= $tarefa['fk_usuario'] == $u['id_usuario'] ? 'selected' : '' ?>><?= htmlspecialchars($u['nome_usuario']) ?></option>
        <?php endwhile; ?>
    </select><br>
    <button type="submit">Atualizar</button>
</form>

<a href="read.php">Voltar à lista</a>
