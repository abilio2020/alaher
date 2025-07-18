<?php
include 'conexao.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=vistos_formatado.xls");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM vistos ORDER BY data_emissao DESC";
$result = $conn->query($sql);
?>

<html>
<head>
  <meta charset="UTF-8">
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid #000;
      padding: 6px;
      text-align: left;
    }
    th {
      background-color: #003366;
      color: #fff;
    }
    .status-ativo {
      background-color: #d4edda;
      color: #155724;
      font-weight: bold;
    }
    .status-pendente {
      background-color: #fff3cd;
      color: #856404;
      font-weight: bold;
    }
    .status-inativo {
      background-color: #f8d7da;
      color: #721c24;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <h3>Relatório de Vistos - ALAHER</h3>
  <table>
    <tr>
      <th>Nome Completo</th>
      <th>Passaporte</th>
      <th>Nacionalidade</th>
      <th>Tipo Visto</th>
      <th>Data Emissão</th>
      <th>Data Expiração</th>
      <th>Status</th>
      <th>Observação</th>
      <th>Paradeiro do Passaporte</th>
      <th>Comentários</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <?php
      $status = strtolower($row['status']);
      $classeStatus = 'status-pendente'; // padrão
      if ($status === 'ativo') $classeStatus = 'status-ativo';
      elseif ($status === 'expirado') $classeStatus = 'status-expirado';
    ?>
    <tr>
      <td><?= $row['nome_completo'] ?></td>
      <td><?= $row['passaporte'] ?></td>
      <td><?= $row['nacionalidade'] ?></td>
      <td><?= $row['tipo_visto'] ?></td>
      <td><?= $row['data_emissao'] ?></td>
      <td><?= $row['data_expiracao'] ?></td>
      <td class="<?= $classeStatus ?>"><?= ucfirst($row['status']) ?></td>
      <td><?= $row['observacao'] ?></td>
      <td><?= $row['paradeiro_passaporte'] ?></td>
      <td><?= $row['comentarios'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
