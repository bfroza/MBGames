<?php
    include("conexao.php");

    $nome = trim($_POST['nome']);
    $plataforma = trim($_POST['plataforma']);
    $price = trim($_POST['price']);
    $quantidade = trim($_POST['quantidade']);
    $cep = trim($_POST['img']);
   
    
    $sql = "INSERT INTO usuarios (nome, plataforma, price, quantidade,img) 
            VALUES ('$nome', '$plataforma', '$price', '$quantidade','$img')";

    if (mysqli_query($conexao, $sql)) {
    }
    else {
        echo "Erro: " . mysqli_error($conexao); 
    }
    
    mysqli_close($conexao);
?>
