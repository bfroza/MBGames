<?php
include("conexao.php");

$nome = trim($_POST['nome']);
$categoria = $_POST['categoria'];
$fornecedor = $_POST['fornecedor'];
$anoLancamento = trim($_POST['anoLancamento']);
$valor = trim($_POST['valor']);

$imagem = trim($_POST['imagem']);

// Verificar se o jogo já existe na tabela para a mesma plataforma
$verificar_sql = "SELECT * FROM jogos WHERE nome = ? AND plataforma = ?";
$verificar_stmt = mysqli_prepare($conexao, $verificar_sql);
mysqli_stmt_bind_param($verificar_stmt, "ss", $nome, $plataforma);
mysqli_stmt_execute($verificar_stmt);
$result = mysqli_stmt_get_result($verificar_stmt);

if (mysqli_num_rows($result) > 0) {
    // O jogo já existe para a mesma plataforma, então vamos atualizar a quantidade e/ou preço
    $row = mysqli_fetch_assoc($result);
    $novo_preco = $price; // Correção: não é necessário usar $row['price']

    $atualizar_sql = "UPDATE jogos SET price = ?, WHERE nome = ? AND plataforma = ?";
    $atualizar_stmt = mysqli_prepare($conexao, $atualizar_sql);
    mysqli_stmt_bind_param($atualizar_stmt, "diss", $novo_preco, $nome, $plataforma);

    if (mysqli_stmt_execute($atualizar_stmt)) {
        // Jogo atualizado com sucesso
        echo "<script>
                alert('Jogo atualizado com sucesso!');
                window.location.href = 'cadastro-view.php'; // Redireciona para a página
              </script>";
    } else {
        // Erro ao atualizar o jogo
        echo "<script>
                alert('Erro ao atualizar o jogo: " . mysqli_error($conexao) . "');
                window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
              </script>";
    }

    mysqli_stmt_close($atualizar_stmt);
} else {
    // O jogo não existe para a mesma plataforma, então vamos inseri-lo
    $inserir_sql = "INSERT INTO jogos (nome, plataforma, price,img) VALUES (?, ?, ?, ?)";
    $inserir_stmt = mysqli_prepare($conexao, $inserir_sql);
    mysqli_stmt_bind_param($inserir_stmt, "ssds", $nome, $plataforma, $price, $img);

    if (mysqli_stmt_execute($inserir_stmt) ) {
        // Jogo cadastrado com sucesso! -> (&& $quantidade > 0) Expressão para por no if caso utilizamos 2 tabelas: compras e produtos
        echo "<script>
                alert('Jogo cadastrado com sucesso!');
                window.location.href = 'cadastro-view.php'; // Redireciona para a página 
              </script>";
    } else {
        // Erro ao cadastrar o jogo
        echo "<script>
                alert('Erro ao cadastrar o jogo: " . mysqli_error($conexao) . "');
                window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
              </script>";
    }

    mysqli_stmt_close($inserir_stmt);
}

mysqli_close($conexao);
?>
