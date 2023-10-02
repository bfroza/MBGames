<?php
include("conexao.php"); // Certifique-se de incluir o arquivo de conexão com o banco de dados

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os IDs do usuário e do jogo do formulário
    $userId = $_POST['userId'];
    $gameId = $_POST['gameId'];

    // Consulta SQL para obter o valor do jogo com base no ID do jogo selecionado
    $sqlValorJogo = "SELECT valor FROM Jogos WHERE idJogos = :gameId";

    $stmtValorJogo = $conexao->prepare($sqlValorJogo);
    $stmtValorJogo->bindParam(':gameId', $gameId);
    $stmtValorJogo->execute();

    $valorTotal = $stmtValorJogo->fetchColumn(); // Obtém o valor do jogo

    // Insira os dados da venda na tabela de vendas
    $sqlInserirVenda = "INSERT INTO Vendas (data, valorTotal, Cupons_idCupons, Usuarios_idUsuarios, Chaves_idChaves)
            VALUES (NOW(), :valorTotal, NULL, :userId, :gameId)";

    $stmtInserirVenda = $conexao->prepare($sqlInserirVenda);
    $stmtInserirVenda->bindParam(':valorTotal', $valorTotal);
    $stmtInserirVenda->bindParam(':userId', $userId);
    $stmtInserirVenda->bindParam(':gameId', $gameId);

    if ($stmtInserirVenda->execute()) {
        // Venda cadastrada com sucesso
        // Você pode redirecionar o usuário para a página de sucesso ou fazer outras ações aqui
        header("Location: sucesso.php"); // Redirecionar para uma página de sucesso
        exit;
    } else {
        // Ocorreu um erro ao cadastrar a venda
        echo "Erro ao cadastrar a venda: " . $stmtInserirVenda->errorInfo()[2];
    }
}

// Feche a conexão com o banco de dados após o uso
$conexao = null;
?>
