<?php
$id = $_GET['id'] ?? '';
$arquivo = $_GET['arquivo'] ?? '';

if ($id && $arquivo) {
    $caminho = "uploads/$id/$arquivo";
    if (file_exists($caminho)) {
        unlink($caminho);
    }
}

header("Location: documentos.php?id=$id");
exit;
