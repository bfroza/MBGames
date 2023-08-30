<?php
include("conexao.php");

$nome = trim($_POST['nome']);
$user = trim($_POST['user']);
$email = trim($_POST['email']);
$cpf = trim($_POST['cpf']);
$cep = trim($_POST['cep']);
$data = trim($_POST['data']);  
$senha = trim($_POST['senha']);

$userExists = false;
$emailExists = false;
$cpfExists = false;

$queryUser = "SELECT * FROM usuarios WHERE user = '$user'";
$resultUser = mysqli_query($conexao, $queryUser);
if (mysqli_num_rows($resultUser) > 0) {
    $userExists = true;
    echo 'Esse usuário já existe.<br>';
}

$queryEmail = "SELECT * FROM usuarios WHERE email = '$email'";
$resultEmail = mysqli_query($conexao, $queryEmail);
if (mysqli_num_rows($resultEmail) > 0) {
    $emailExists = true;
    echo 'Esse email já foi cadastrado.<br>';
}

$queryCpf = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
$resultCpf = mysqli_query($conexao, $queryCpf);
if (mysqli_num_rows($resultCpf) > 0) {
    $cpfExists = true;
    echo 'Esse CPF já foi cadastrado.<br>';
}

if (!$userExists && !$emailExists && !$cpfExists) {
    $sql = "INSERT INTO usuarios (nome, user, email, cpf, cep, data_nascimento, senha) 
            VALUES ('$nome', '$user', '$email', '$cpf', '$cep', '$data', '$senha')";

    if (mysqli_query($conexao, $sql)) {
        echo "Novo registro criado com sucesso!";
        header("Location: index.php"); // Redireciona para a página de sucesso
        exit;
    } else {
        echo "Erro ao criar registro: " . mysqli_error($conexao);
        header("Location: criar_conta.php"); 

    }
} else {
    // Mostra um aviso na tela de criar conta
    echo "Houve um erro ou os campos já existem. Por favor, volte e tente novamente.";
}

mysqli_close($conexao);
?>
