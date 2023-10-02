<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mb_games";

// Estabelecer a conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar a conexão
if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}
// Função para verificar se um CPF é válido
function validaCPF($cpf) {
    // Remove caracteres não numéricos do CPF
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o CPF tem 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se todos os dígitos são iguais (caso contrário, o CPF é inválido)
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Calcula o primeiro dígito verificador
    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += $cpf[$i] * (10 - $i);
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;

    // Calcula o segundo dígito verificador
    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf[$i] * (11 - $i);
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;

    // Verifica se os dígitos verificadores são iguais aos dígitos do CPF
    if ($cpf[9] != $digito1 || $cpf[10] != $digito2) {
        return false;
    }

    return true;
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $nome = $_POST["nome"];
    $user = $_POST["user"];
    $email = $_POST["email"];
    $cpf = $_POST["cpf"];
    $dataNascimento = $_POST["dataNascimento"];
    $senha = $_POST["senha"];

    // Valida o CPF
    if (!validaCPF($cpf)) {
        echo "CPF inválido. Por favor, insira um CPF válido.";
        exit;
    }
    $userExists = $cpfExists = $emailExists = 0;
    // Verifica se o usuário já existe
    $queryUser = "SELECT * FROM usuarios WHERE user = '$user'";
    $resultUser = mysqli_query($conn, $queryUser);

    if (mysqli_num_rows($resultUser) > 0) {
        $userExists = true;
        echo "<script>
        var minhaVariavelJS = 'Usuário já foi cadastrado!';
        alert(minhaVariavelJS);
        window.location.href = 'criar_conta.html'; // Redireciona para a página
        </script>";
        exit; // Saia do script após exibir a mensagem
    }

    // Verifica se o email já existe
    $queryEmail = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultEmail = mysqli_query($conn, $queryEmail);

    if (mysqli_num_rows($resultEmail) > 0) {
        $emailExists = true;
        echo "<script>
            var minhaVariavelJS = 'Email já foi cadastrado!!';
            alert(minhaVariavelJS);
            window.location.href = 'criar_conta.html'; // Redireciona para a página
            </script>";
        exit; // Saia do script após exibir a mensagem
    }

    // Verifica se o CPF já existe
    $queryCpf = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
    $resultCpf = mysqli_query($conn, $queryCpf);

    if (mysqli_num_rows($resultCpf) > 0) {
        $cpfExists = true;
        echo "<script>
            var minhaVariavelJS = 'CPF já foi cadastrado!!';
            alert(minhaVariavelJS);
            window.location.href = 'criar_conta.html'; // Redireciona para a página
            </script>";
        exit; // Saia do script após exibir a mensagem
    }

    // Se nenhum dos campos já existe, continue com a inserção no banco de dados
    if (!$userExists && !$emailExists && !$cpfExists) {
        // Inserir os dados na tabela do banco de dados
        $sql = "INSERT INTO usuarios (nome, user, email, cpf, dataNascimento, idade, senha) 
                VALUES ('$nome', '$user', '$email', '$cpf', '$dataNascimento', calcularIdade('$dataNascimento'), '$senha')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
            var minhaVariavelJS = 'Usuário criado com sucesso!';
            alert(minhaVariavelJS);
            window.location.href = 'criar_conta.html'; // Redireciona para a página
            </script>";
            // Você pode redirecionar o usuário para uma página de sucesso aqui, se desejar
        } else {
            echo "<script>
            var minhaVariavelJS = 'Não foi possível criar usuário!';
            alert(minhaVariavelJS);
            window.location.href = 'criar_conta.html'; // Redireciona para a página
            </script>";
        }
    } else {
        // Mostra um aviso na tela de criar conta
        
        echo "<script>
        var minhaVariavelJS = 'Houve um erro ou os campos já existem. Por favor, volte e tente novamente.';
        alert(minhaVariavelJS);
        window.location.href = 'criar_conta.html'; // Redireciona para a página
        </script>";
    }

    // ...

} else {
    // Se o formulário não foi enviado, redirecione o usuário de volta para a página do formulário
    header("Location: criar_conta.html");
    exit;
}
?>