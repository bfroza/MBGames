<?php
include("conexao.php");

$nome = trim($_POST['nome']);
$plataforma = $_POST['plataforma'];
$price = trim($_POST['price']);
$quantidade = trim($_POST['quantidade']);
$img = trim($_POST['img']);

// Verificar se o jogo já existe na tabela
$verificar_sql = "SELECT * FROM jogos WHERE nome = ?";
$verificar_stmt = mysqli_prepare($conexao, $verificar_sql);
mysqli_stmt_bind_param($verificar_stmt, "s", $nome);
mysqli_stmt_execute($verificar_stmt);
$result = mysqli_stmt_get_result($verificar_stmt);

if (mysqli_num_rows($result) > 0) {
    // O jogo já existe, então vamos atualizar a quantidade e/ou preço
    $row = mysqli_fetch_assoc($result);
    $novo_preco = $row['price'] + $price; // Somar o novo preço ao preço existente
    $nova_quantidade = $row['quantidade'] + $quantidade; // Somar a nova quantidade à quantidade existente

    $atualizar_sql = "UPDATE jogos SET price = ?, quantidade = ? WHERE nome = ?";
    $atualizar_stmt = mysqli_prepare($conexao, $atualizar_sql);
    mysqli_stmt_bind_param($atualizar_stmt, "dds", $novo_preco, $nova_quantidade, $nome);

    if (mysqli_stmt_execute($atualizar_stmt)) {
        echo "Jogo atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o jogo: " . mysqli_error($conexao);
    }

    mysqli_stmt_close($atualizar_stmt);
} else {
    // O jogo não existe, então vamos inseri-lo
    $inserir_sql = "INSERT INTO jogos (nome, plataforma, price, quantidade, img) VALUES (?, ?, ?, ?, ?)";
    $inserir_stmt = mysqli_prepare($conexao, $inserir_sql);
    mysqli_stmt_bind_param($inserir_stmt, "ssdds", $nome, $plataforma, $price, $quantidade, $img);

    if (mysqli_stmt_execute($inserir_stmt)) {
        echo "Jogo cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o jogo: " . mysqli_error($conexao);
    }

    mysqli_stmt_close($inserir_stmt);
}

mysqli_close($conexao);
?>
