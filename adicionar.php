<?php include 'conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Adicionar Visto - ALAHER</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 40px;
      background-color: #f4f6f8;
      color: #333;
    }

    h2 {
      text-align: center;
      color: #003366;
      margin-bottom: 30px;
    }

    form {
      background: #fff;
      max-width: 700px;
      margin: auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: 600;
      color: #003366;
    }

    input, textarea, select {
      width: 100%;
      padding: 10px 12px;
      margin-top: 6px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      background-color: #f9f9f9;
    }

    textarea {
      resize: vertical;
      min-height: 80px;
    }

    button {
      margin-top: 25px;
      padding: 12px 20px;
      background-color: #003366;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 15px;
      font-weight: bold;
    }

    button:hover {
      background-color: #002244;
    }

    .link-voltar {
      margin-top: 30px;
      display: block;
      text-align: center;
      color: #003366;
      text-decoration: none;
      font-weight: bold;
    }

    .link-voltar:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
<center>
<img src="logo.png" alt="Girl in a jacket" width="100" height="120">
</center>
<h2>Adicionar Novo Visto</h2>
<form action="adicionar.php" method="POST">
  <label>Nome Completo</label><input type="text" name="nome_completo" required>
  <label>Nº Passaporte</label><input type="text" name="passaporte" required>
  <label>Nacionalidade</label><input type="text" name="nacionalidade" required>
  <label>Tipo de Visto</label><input type="text" name="tipo_visto" required>
  <label>Data de Emissão</label><input type="date" name="data_emissao" required>
  <label>Data de Expiração</label><input type="date" name="data_expiracao" required>

  <label>Status</label>
  <select name="status" required>
    <option value="">-- Selecionar Status --</option>
    <option value="Activo">Activo</option>
    <option value="Expirado">Expirado</option>
    <option value="Pendente">Pendente</option>
  </select>

  <label>Observação</label><textarea name="observacao"></textarea>
  <label>Paradeiro do Passaporte</label><input type="text" name="paradeiro_passaporte">
  <label>Comentários</label><textarea name="comentarios"></textarea>
  <button type="submit">Salvar Visto</button>
</form>

<a class="link-voltar" href="index.php">← Voltar à Dashboard</a>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST['nome_completo'];
  $passaporte = $_POST['passaporte'];
  $nacionalidade = $_POST['nacionalidade'];
  $tipo = $_POST['tipo_visto'];
  $emissao = $_POST['data_emissao'];
  $expiracao = $_POST['data_expiracao'];
  $status = $_POST['status'];
  $observacao = $_POST['observacao'];
  $paradeiro = $_POST['paradeiro_passaporte'];
  $comentarios = $_POST['comentarios'];

  $sql = "INSERT INTO vistos (nome_completo, passaporte, nacionalidade, tipo_visto, data_emissao, data_expiracao, status, observacao, paradeiro_passaporte, comentarios) 
          VALUES ('$nome', '$passaporte', '$nacionalidade', '$tipo', '$emissao', '$expiracao', '$status', '$observacao', '$paradeiro', '$comentarios')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Visto adicionado com sucesso!'); window.location.href='index.php';</script>";
  } else {
    echo "Erro: " . $conn->error;
  }
}
?>
</body>
</html>
