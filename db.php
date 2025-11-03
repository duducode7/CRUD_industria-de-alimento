<?php
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "industria_de_alimentos";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>