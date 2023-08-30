<?php
include("conexao.php");

$nome = trim($_POST['nome']);
$plataforma = $_POST['plataforma']; 
$price = trim($_POST['price']);
$quantidade = trim($_POST['quantidade']);
$img = trim($_POST['img']);
   
$sql = "INSERT INTO jogos (nome, plataforma, price, quantidade,img) 
        VALUES ('$nome', '$plataforma', '$price', '$quantidade','$img')";

if (mysqli_query($conexao, $sql)) {
    echo "Jogo cadastrado com sucesso!";
} else {
    echo "Erro: " . mysqli_error($conexao); 
}

mysqli_close($conexao);
?>