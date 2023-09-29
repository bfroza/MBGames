<?php
// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se os campos obrigatórios estão definidos e não vazios
        $conn = new mysqli("localhost", "root", "", "mb_games");
        
        // Verifique a conexão com o banco de dados
        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }
        
        // Prepare os dados para inserção
        $Jogos_idJogos  = $_POST["Jogos_idJogos"];
        $chaves = trim($_POST["chaves"]);
        $Jogos_Fornecedores_idJogos_Fornecedores = trim($_POST["Jogos_Fornecedores_idJogos_Fornecedores"]);
        $chave_array = preg_split('/\R/', $chaves, -1, PREG_SPLIT_NO_EMPTY);
        
        // Insira cada chave no banco de dados com o jogo selecionado
        foreach ($chave_array as $chave) {
            $estoque = 1;
            $sql = "INSERT INTO Chaves (Jogos_idJogos, chave, estoque,Jogos_Fornecedores_idJogos_Fornecedores) VALUES (?, ?, ?,?)";
            $stmt = $conn->prepare($sql);
            
            // Suponha que o estoque seja definido como 1 por padrão, você pode ajustar conforme necessário
            $estoque = 1;
            
            $stmt->bind_param("isii", $Jogos_idJogos , $chave, $estoque,$Jogos_Fornecedores_idJogos_Fornecedores);
            
            if ($stmt->execute()) {
                // Chave cadastrada com sucesso
                echo "Chave cadastrada com sucesso.";
            } else {
                // Erro ao cadastrar a chave
                echo "Erro ao cadastrar a chave: " . $stmt->error;
            }
            
            $stmt->close();
        }
        
        // Feche a conexão com o banco de dados
        $conn->close();
    } else {
        // Campos obrigatórios não foram preenchidos
        echo "Por favor, preencha todos os campos obrigatórios.";
    }

?>
