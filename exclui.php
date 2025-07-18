<?php
include 'conexao.php';

if (!isset($_GET['id'])) {
  echo "ID não fornecido.";
  exit;
}

$id = $_GET['id'];

// Verifica se existe
$sql = "SELECT * FROM vistos WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
  echo "Registro não encontrado.";
  exit;
}

// Executa exclusão
$sql = "DELETE FROM vistos WHERE id = $id";
if ($conn->query($sql) === TRUE) {
  header("Location: index.php");
  exit;
} else {
  echo "Erro ao excluir: " . $conn->error;
}
?>
