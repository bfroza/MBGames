<?php
include("conexao.php");

$jogo_id = $_POST['jogo_id'];
$chaves = trim($_POST['chaves']);

// Quebre as chaves em um array separando-as por quebras de linha
$chave_array = preg_split('/\R/', $chaves, -1, PREG_SPLIT_NO_EMPTY);

// Insira cada chave no banco de dados com um ID diferente
foreach ($chave_array as $chave) {
    $inserir_sql = "INSERT INTO chaves (jogo_id, chave) VALUES (?, ?)";
    $inserir_stmt = mysqli_prepare($conexao, $inserir_sql);
    mysqli_stmt_bind_param($inserir_stmt, "is", $jogo_id, $chave);

    if (mysqli_stmt_execute($inserir_stmt)) {
        // Chave cadastrada com sucesso
        echo "<script>
                alert('Chave cadastrada com sucesso!');
                window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
              </script>";
    } else {
        // Erro ao cadastrar a chave
        echo "<script>
                alert('Erro ao cadastrar a chave: " . mysqli_error($conexao) . "');
                window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
              </script>";
    }

    mysqli_stmt_close($inserir_stmt);
}

mysqli_close($conexao);
?>
