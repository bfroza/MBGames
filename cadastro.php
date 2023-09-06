<?php
include("conexao.php");

$nome = trim($_POST['nome']);
$plataforma = $_POST['plataforma'];
$price = trim($_POST['price']);
$quantidade = trim($_POST['quantidade']);
$img = trim($_POST['img']);

$sql = "INSERT INTO jogos (nome, plataforma, price, quantidade, img) VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexao, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssdds", $nome, $plataforma, $price, $quantidade, $img);


    if (mysqli_stmt_execute($stmt)) {
        echo "Jogo cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o jogo: " . mysqli_error($conexao);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Erro na preparação da declaração: " . mysqli_error($conexao);
}

mysqli_close($conexao);
?>
