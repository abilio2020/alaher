<?php
include 'conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  echo "ID do cliente não fornecido.";
  exit;
}

$pasta = "uploads/cliente_" . $id;
if (!is_dir($pasta)) mkdir($pasta, 0777, true);

// Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['arquivo'])) {
  $nome = basename($_FILES['arquivo']['name']);
  $destino = $pasta . '/' . $nome;
  move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino);
  header("Location: documentos.php?id=$id");
  exit;
}

// Exclusão
if (isset($_GET['excluir'])) {
  $arquivo = basename($_GET['excluir']);
  $caminho = $pasta . '/' . $arquivo;
  if (file_exists($caminho)) unlink($caminho);
  header("Location: documentos.php?id=$id");
  exit;
}

// Listagem
$arquivos = array_diff(scandir($pasta), ['.', '..']);
$visualizar = isset($_GET['ver']) ? basename($_GET['ver']) : null;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Documentos - Cliente <?= $id ?></title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f6f8;
      margin: 30px;
      color: #333;
    }
    h2, h3 {
      color: #003366;
    }
    form {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      margin-bottom: 25px;
    }
    input[type="file"] {
      padding: 8px;
    }
    button {
      background-color: #003366;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }
    ul {
      list-style: none;
      padding: 0;
    }
    li {
      background: #fff;
      padding: 12px 16px;
      margin-bottom: 10px;
      border-radius: 8px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.05);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .arquivo-nome {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .arquivo-nome::before {
      content: "📄";
      font-size: 18px;
    }
    a.btn {
      background: #007bff;
      color: white;
      padding: 6px 10px;
      border-radius: 4px;
      text-decoration: none;
      margin-right: 6px;
      font-size: 14px;
    }
    a.excluir {
      background: #dc3545;
    }
    iframe, img {
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-top: 20px;
    }
    .voltar {
      margin-top: 30px;
    }
    .voltar a {
      text-decoration: none;
      color: #003366;
      font-weight: bold;
    }
  </style>
</head>
<body>
<center>
<img src="logo.png" alt="Girl in a jacket" width="100" height="120">
</center>
<h2>📂 Documentos do Cliente #<?= $id ?></h2>

<form method="POST" enctype="multipart/form-data">
  <label>📤 Enviar novo documento:</label><br><br>
  <input type="file" name="arquivo" required>
  <button type="submit">Enviar</button>
</form>

<?php if (empty($arquivos)): ?>
  <p>Nenhum documento disponível.</p>
<?php else: ?>
  <ul>
    <?php foreach ($arquivos as $arq): ?>
      <li>
        <div class="arquivo-nome"><?= htmlspecialchars($arq) ?></div>
        <div>
          <a class="btn" href="?id=<?= $id ?>&ver=<?= urlencode($arq) ?>">Visualizar</a>
          <a class="btn excluir" href="?id=<?= $id ?>&excluir=<?= urlencode($arq) ?>" onclick="return confirm('Excluir este arquivo?')">Excluir</a>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php if ($visualizar): ?>
  <h3>🔍 Visualizando: <?= htmlspecialchars($visualizar) ?></h3>
  <?php
    $ext = strtolower(pathinfo($visualizar, PATHINFO_EXTENSION));
    $caminho = $pasta . '/' . $visualizar;

    if ($ext == 'pdf') {
      echo "<iframe src='$caminho' width='100%' height='600px'></iframe>";
    } elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
      echo "<img src='$caminho' style='max-width:100%; height:auto;'>";
    } else {
      echo "<p>Tipo de arquivo não suportado para visualização direta.</p>";
    }
  ?>
<?php endif; ?>

<div class="voltar">
  <p><a href="index.php">← Voltar ao Dashboard</a></p>
</div>

</body>
</html>
