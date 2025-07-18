<?php
require_once 'dompdf/autoload.inc.php';
include 'conexao.php';

use Dompdf\Dompdf;

$sql = "SELECT * FROM vistos ORDER BY data_emissao DESC";
$result = $conn->query($sql);

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
    .logo { text-align: center; }
    .logo img { height: 80px; margin-bottom: 10px; }
    h2 { text-align: center; color: #003366; margin-top: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    th { background-color: #eee; }
  </style>
</head>
<body>

  <div class="logo">
    <img src="logo.png" alt="Logotipo ALAHER">
  </div>
  <h2>Relatório de Vistos - ALAHER</h2>

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
      <th>Paradeiro</th>
      <th>Comentários</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['nome_completo'] ?></td>
      <td><?= $row['passaporte'] ?></td>
      <td><?= $row['nacionalidade'] ?></td>
      <td><?= $row['tipo_visto'] ?></td>
      <td><?= $row['data_emissao'] ?></td>
      <td><?= $row['data_expiracao'] ?></td>
      <td><?= ucfirst($row['status']) ?></td>
      <td><?= $row['observacao'] ?></td>
      <td><?= $row['paradeiro_passaporte'] ?></td>
      <td><?= $row['comentarios'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>

</body>
</html>
<?php
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape'); // orientação horizontal
$dompdf->render();
$dompdf->stream("relatorio_vistos.pdf", ["Attachment" => false]);
exit;
?>
