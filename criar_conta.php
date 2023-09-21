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
    echo "<script>
    var minhaVariavelJS = 'Usuário já foi cadastrado!';
    alert(minhaVariavelJS);
    window.location.href = 'criar_conta.html'; // Redireciona para a página
    </script>";
}

$queryEmail = "SELECT * FROM usuarios WHERE email = '$email'";
$resultEmail = mysqli_query($conexao, $queryEmail);
if (mysqli_num_rows($resultEmail) > 0) {
    $emailExists = true;
    echo "<script>
        var minhaVariavelJS = 'Email já foi cadastrado!!';
        alert(minhaVariavelJS);
        window.location.href = 'criar_conta.html'; // Redireciona para a página
        </script>";
}

$queryCpf = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
$resultCpf = mysqli_query($conexao, $queryCpf);
if (mysqli_num_rows($resultCpf) > 0) {
    $cpfExists = true;
    echo "<script>
        var minhaVariavelJS = 'CPF já foi cadastrado!!';
        alert(minhaVariavelJS);
        window.location.href = 'criar_conta.html'; // Redireciona para a página
        </script>";
}

if (!$userExists && !$emailExists && !$cpfExists) {
    $sql = "INSERT INTO usuarios (nome, user, email, cpf, cep, data_nascimento,idade, senha) 
            VALUES ('$nome', '$user', '$email', '$cpf', '$cep', '$data',calcularIdade('$data'), '$senha')";

    if (mysqli_query($conexao, $sql)) {
        echo "<script>
        var minhaVariavelJS = 'Usuário criado com sucesso!';
        alert(minhaVariavelJS);
        window.location.href = 'index.php'; // Redireciona para a página
        </script>";
        exit;
    } else {
        echo "<script>
        var minhaVariavelJS = 'Não foi possível criar usuário!';
        alert(minhaVariavelJS);
        window.location.href = 'criar_conta.html'; // Redireciona para a página
        </script>";
    }
} else {
    // Mostra um aviso na tela de criar conta
    echo "Houve um erro ou os campos já existem. Por favor, volte e tente novamente.";
}

mysqli_close($conexao);
?>