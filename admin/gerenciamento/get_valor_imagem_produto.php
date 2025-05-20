<?php
include '../../includes/conexao.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitiza o ID
    $query = "SELECT valor, id FROM tb_produtos WHERE id = $id";
    $resultado = mysqli_query($conexao, $query);

    if ($row = mysqli_fetch_assoc($resultado)) {
        $base_path = $_SERVER['DOCUMENT_ROOT'] . '/etec_tcc/assets/fotos/' . $row['id'];
        $extensions = ['png', 'jpg', 'jpeg'];
        $img = '/etec_tcc/assets/fotos/semfoto.png'; // Imagem padrão
        foreach ($extensions as $ext) {
            $file_path = $base_path . '.' . $ext;
            if (file_exists($file_path)) {
                $img = '/etec_tcc/assets/fotos/' . $row['id'] . '.' . $ext;
                break;
            }
        }
        echo json_encode([
            'valor' => $row['valor'],
            'imagem' => $img
        ]);
    } else {
        echo json_encode(['error' => 'Produto não encontrado']);
    }
} else {
    echo json_encode(['error' => 'ID não fornecido']);
}
?>