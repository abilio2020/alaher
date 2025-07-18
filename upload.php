<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['arquivo'])) {
    $id_cliente = $_POST['cliente_id'];
    $dir_cliente = "uploads/cliente_$id_cliente";

    if (!is_dir($dir_cliente)) {
        mkdir($dir_cliente, 0777, true);
    }

    $arquivo = $_FILES['arquivo'];
    $destino = $dir_cliente . '/' . basename($arquivo['name']);

    if (move_uploaded_file($arquivo['tmp_name'], $destino)) {
        echo "Arquivo enviado com sucesso!";
    } else {
        echo "Erro ao enviar.";
    }
}
?>

<form method="POST" enctype="multipart/form-data">
  <label>ID do Cliente:</label>
  <input type="number" name="cliente_id" required><br><br>
  
  <label>Escolher arquivo:</label>
  <input type="file" name="arquivo" required><br><br>

  <button type="submit">Enviar</button>
</form>
