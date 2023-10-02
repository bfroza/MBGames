<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $jogo_id = $_POST["Jogos_idJogos"]; // Recebe o idJogos selecionado no campo select
    $chaves = $_POST["chaves"];

    // Conecte ao banco de dados
    $conn = new mysqli("localhost", "root", "", "mb_games");
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verifique se o jogo existe
    $verifica_sql = "SELECT idJogos, Fornecedores_idFornecedores FROM jogos WHERE idJogos = ?";
    $verifica_stmt = $conn->prepare($verifica_sql);
    $verifica_stmt->bind_param("i", $jogo_id);
    $verifica_stmt->execute();
    $verifica_stmt->store_result();

    if ($verifica_stmt->num_rows > 0) {
        // O jogo existe, então você pode inserir as chaves
        $verifica_stmt->bind_result($idJogos, $fornecedor_id);
        $verifica_stmt->fetch();
        
        $chavesArray = explode(PHP_EOL, $chaves); // Divide as chaves em um array
        foreach ($chavesArray as $chave) {
            $chave = trim($chave);
            if (!empty($chave)) {
                $insert_sql = "INSERT INTO Chaves (chave, Fornecedores_idFornecedores, Jogos_idJogos) VALUES (?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("sii", $chave, $fornecedor_id, $jogo_id);
                
                if ($insert_stmt->execute()) {
                    // Chave cadastrada com sucesso
                } else {
                    // Erro ao cadastrar a chave
                }
                $insert_stmt->close();
            }
        }
        echo "<script>
            alert('Chaves cadastradas com sucesso!');
            window.location.href = 'chaves-view.php'; // Redireciona para a página de chaves
        </script>";
    } else {
        // O jogo não existe, exiba uma mensagem de erro
        echo "<script>
            alert('Jogo não encontrado!');
            window.location.href = 'chaves-view.php'; // Redireciona para a página de chaves
        </script>";
    }

    $verifica_stmt->close();
    $conn->close();
}
?>
