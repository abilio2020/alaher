<?php
include 'conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  echo "ID não fornecido!";
  exit;
}

$sql = "SELECT * FROM vistos WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
  echo "Visto não encontrado!";
  exit;
}

$dados = $result->fetch_assoc();

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

  $sqlUpdate = "UPDATE vistos SET 
    nome_completo='$nome',
    passaporte='$passaporte',
    nacionalidade='$nacionalidade',
    tipo_visto='$tipo',
    data_emissao='$emissao',
    data_expiracao='$expiracao',
    status='$status',
    observacao='$observacao',
    paradeiro_passaporte='$paradeiro',
    comentarios='$comentarios'
    WHERE id=$id";

  if ($conn->query($sqlUpdate) === TRUE) {
    echo "<script>alert('Visto atualizado com sucesso!'); window.location.href='index.php';</script>";
  } else {
    echo "Erro ao atualizar: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Editar Visto - ALAHER</title>
  <style>
    /* Mesmo estilo do adicionar.php */
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
<h2>Editar Visto</h2>
<form method="POST">
  <label>Nome Completo</label>
  <input type="text" name="nome_completo" value="<?= htmlspecialchars($dados['nome_completo']) ?>" required>

  <label>Nº Passaporte</label>
  <input type="text" name="passaporte" value="<?= htmlspecialchars($dados['passaporte']) ?>" required>

  <label>Nacionalidade</label>
  <input type="text" name="nacionalidade" value="<?= htmlspecialchars($dados['nacionalidade']) ?>" required>

  <label>Tipo de Visto</label>
  <input type="text" name="tipo_visto" value="<?= htmlspecialchars($dados['tipo_visto']) ?>" required>

  <label>Data de Emissão</label>
  <input type="date" name="data_emissao" value="<?= $dados['data_emissao'] ?>" required>

  <label>Data de Expiração</label>
  <input type="date" name="data_expiracao" value="<?= $dados['data_expiracao'] ?>" required>

  <label>Status</label>
  <select name="status" required>
    <option value="Ativo" <?= $dados['status'] == 'Ativo' ? 'selected' : '' ?>>Ativo</option>
    <option value="expirado" <?= $dados['status'] == 'Inativo' ? 'selected' : '' ?>>Expirado</option>
    <option value="Pendente" <?= $dados['status'] == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
  </select>

  <label>Observação</label>
  <textarea name="observacao"><?= htmlspecialchars($dados['observacao']) ?></textarea>

  <label>Paradeiro do Passaporte</label>
  <input type="text" name="paradeiro_passaporte" value="<?= htmlspecialchars($dados['paradeiro_passaporte']) ?>">

  <label>Comentários</label>
  <textarea name="comentarios"><?= htmlspecialchars($dados['comentarios']) ?></textarea>

  <button type="submit">Atualizar Visto</button>
</form>

<a class="link-voltar" href="index.php">← Voltar à Dashboard</a>
</body>
</html>
