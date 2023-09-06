<?php
include("conexao.php");

$nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
$user = mysqli_real_escape_string($conexao, trim($_POST['user']));
$email = mysqli_real_escape_string($conexao, trim($_POST['email']));
$cpf = mysqli_real_escape_string($conexao, trim($_POST['cpf']));
$data = mysqli_real_escape_string($conexao, trim($_POST['data']));  
$senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));


$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, nome_usuario, email, cpf, data_nascimento, senha) 
        VALUES ('$nome', '$user', '$email', '$cpf', '$data', '$senhaHash')";

if (mysqli_query($conexao, $sql)) {
    echo "Registro inserido com sucesso!";
} else {
    echo "Erro: " . mysqli_error($conexao);
}

mysqli_close($conexao);
?>
