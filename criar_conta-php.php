<?php
    include("conexao.php");

    $nome = trim($_POST['nome']);
    $user = trim($_POST['user']);
    $email = trim($_POST['email']);
    $cpf = trim($_POST['cpf']);
    $data = trim($_POST['data']);  
    $senha = trim($_POST['senha']);
    
    $sql = "INSERT INTO usuarios (nome, nome_usuario, email, cpf, data_nascimento, senha) 
            VALUES ('$nome', '$user', '$email', '$cpf', '$data', '$senha')";

    if (mysqli_query($conexao, $sql)) {
    }
    else {
        echo "Erro: " . mysqli_error($conexao); 
    }
    
    mysqli_close($conexao);
?>
