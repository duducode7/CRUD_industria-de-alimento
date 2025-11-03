<?php
include 'db.php';

$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM tarefas WHERE id_tarefa = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: read.php");
exit;
?>
