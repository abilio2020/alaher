<?php
include 'conexao.php';

$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';
$sql = "SELECT * FROM vistos WHERE 
          nome_completo LIKE '%$filtro%' OR 
          nacionalidade LIKE '%$filtro%' OR 
          passaporte LIKE '%$filtro%' 
        ORDER BY data_emissao DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Dashboard de Vistos - ALAHER</title>
  <link rel="stylesheet" href="estilo.css">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #f4f6f8; margin: 20px; }
    h2 { text-align: center; color: #003366; }
    .barra-topo { display: flex; justify-content: space-between; align-items: center; margin: 20px 0; }
    .barra-topo input[type=text] { padding: 8px; width: 250px; border: 1px solid #ccc; border-radius: 6px; }
    .barra-topo button, .exportar button { padding: 8px 16px; margin-left: 8px; border: none; border-radius: 6px; cursor: pointer; background: #003366; color: white; font-weight: bold; }
    table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    th, td { padding: 12px 10px; border-bottom: 1px solid #ddd; text-align: left; }
    th { background: #003366; color: white; }
    tr:hover { background: #f1f1f1; }
    .status { font-weight: bold; padding: 6px 10px; border-radius: 5px; display: inline-block; text-align: center; min-width: 80px; }
    .ativo { background: #d4edda; color: #155724; }
    .expirado { background: #f8d7da; color: #721c24; }
    .pendente { background: #fff3cd; color: #856404; }
    .exportar { text-align: right; margin: 10px 0; }
  </style>
</head>
<body>
<center>
<img src="logo.png" alt="Girl in a jacket" width="100" height="120">
</center>
<div class="barra-topo">
  <form method="GET" action="">
    <input type="text" name="filtro" placeholder="Pesquisar..." value="<?= htmlspecialchars($filtro) ?>">
    <button type="submit">Buscar</button>
  </form>
  <div>
    <a href="adicionar.php"><button>+ Novo Visto</button></a>
  </div>
</div>

<div class="exportar">
  <a href="exportar_excel.php"><button>Exportar Excel</button></a>
  <a href="exportar_pdf.php"><button>Exportar PDF</button></a>
  <a href="exportar_html.php"><button>Exportar HTML</button></a>
</div>

<table>
  <tr>
    <th>Nome Completo</th>
    <th>Passaporte</th>
    <th>Nacionalidade</th>
    <th>Tipo de Visto</th>
    <th>Data de Emissão</th>
    <th>Data de Expiração</th>
    <th>Status</th>
    <th>Observação</th>
    <th>Paradeiro Passaporte</th>
    <th>Comentários</th>
    <th>Ações</th>
  </tr>
  <?php while($row = $result->fetch_assoc()): ?>
    <?php
      $status = strtolower($row['status']);
      $classeStatus = 'pendente'; // padrão

      if ($status == 'ativo') {
        $classeStatus = 'ativo';
      } elseif ($status == 'expirado') {
        $classeStatus = 'expirado';
      }
    ?>
    <tr>
      <td><?= htmlspecialchars($row['nome_completo']) ?></td>
      <td><?= htmlspecialchars($row['passaporte']) ?></td>
      <td><?= htmlspecialchars($row['nacionalidade']) ?></td>
      <td><?= htmlspecialchars($row['tipo_visto']) ?></td>
      <td><?= htmlspecialchars($row['data_emissao']) ?></td>
      <td><?= htmlspecialchars($row['data_expiracao']) ?></td>
      <td><span class="status <?= $classeStatus ?>"><?= ucfirst($row['status']) ?></span></td>
      <td><?= htmlspecialchars($row['observacao']) ?></td>
      <td><?= htmlspecialchars($row['paradeiro_passaporte']) ?></td>
      <td><?= htmlspecialchars($row['comentarios']) ?></td>
      <td>
        <a href="editar.php?id=<?= $row['id'] ?>">Editar</a> |
        <a href="excluir.php?id=<?= $row['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este registro?');" style="color:red;">Excluir</a> |
        <a href="documentos.php?id=<?= $row['id'] ?>">Documentos</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
