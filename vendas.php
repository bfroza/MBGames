<?php
// Inclua a conexão com o banco de dados
include("conexao.php");

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $valorTotal = $_POST["valorTotal"];
    $cupons_idCupons = $_POST["Cupons_idCupons"];
    $usuarios_idUsuarios = $_POST["Usuarios_idUsuarios"];
    $chaves_idChaves = $_POST["Chaves_idChaves"];
    $dataAtual = $_POST["dataAtual"];

    // Crie uma instrução SQL para inserir na tabela Vendas
    $sql_insert_venda = "INSERT INTO Vendas (data, valorTotal, Cupons_idCupons, Usuarios_idUsuarios, Chaves_idChaves)
                         VALUES ('$dataAtual', '$valorTotal', '$cupons_idCupons', '$usuarios_idUsuarios', '$chaves_idChaves')";

    // Execute a consulta de inserção
    if (mysqli_query($conexao, $sql_insert_venda)) {
        echo  "<script>
        alert('Venda realizada com sucesso!');
        window.location.href = 'jogos.php'; // Redireciona para a página de cadastro
      </script>";
        // Limpe a sessão de carrinho após a venda ser bem-sucedida, se necessário.
        // unset($_SESSION['carrinho']);
    } else {
        echo "Erro ao realizar a venda: " . mysqli_error($conexao);
    }
}

// Feche a conexão com o banco de dados
mysqli_close($conexao);
?>
