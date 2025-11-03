<?php
include 'db.php';

$nome = $_GET['nome'] ?? '';

// Buscar tarefas junto com o nome do usuário
$sql = "SELECT t.*, u.nome_usuario FROM tarefas t LEFT JOIN usuarios u ON t.fk_usuario = u.id_usuario WHERE 1=1";
if ($nome) $sql .= " AND t.descricao LIKE '%".$conn->real_escape_string($nome)."%'";

$result = $conn->query($sql);
?>

<h2>Lista de Tarefas</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Descrição</th>
        <th>Setor</th>
        <th>Prioridade</th>
        <th>Status</th>
        <th>Usuário</th>
        <th>Ações</th>
    </tr>
    <?php while($m = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $m['id_tarefa'] ?></td>
        <td><?= $m['descricao'] ?></td>
        <td><?= $m['setor'] ?></td>
        <td><?= $m['prioridade'] ?></td>
        <td><?= $m['status'] ?></td>
        <td><?= htmlspecialchars($m['nome_usuario']) ?></td>
        <td>
            <a href="update.php?id=<?= $m['id_tarefa'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $m['id_tarefa'] ?>" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<br>
<a href="create.php">Cadastrar novo medicamento</a>
<br><br>
<a href="index.php">Voltar ao menu principal</a>
