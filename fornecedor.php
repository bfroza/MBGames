<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $nome = $_POST["nome"];
    $linkSite = $_POST["linkSite"];
    $conn = new mysqli("localhost", "root", "", "mb_games");
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }
    $verificaFornecedorExistente = "SELECT idFornecedores FROM fornecedores WHERE nome = ?";
    $stmtVerifica = $conn->prepare($verificaFornecedorExistente);
    $stmtVerifica->bind_param("s", $nome);
    $stmtVerifica->execute();
    $stmtVerifica->store_result();

    if ($stmtVerifica->num_rows > 0) {
        // Jogo já existe, exiba uma mensagem de erro
        echo  "<script>
        alert('Este fornecedor já está cadastrado.');
        window.location.href = 'fornecedores-view.php'; // Redireciona para a página de cadastro
      </script>";
    } else {
        // Jogo não existe, insira os dados na tabela de fornecedores
        $stmtVerifica->close();

        $sql = "INSERT INTO Fornecedores (nome, linkSite) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nome, $linkSite);
    
        if ($stmt->execute()) {
            echo  "<script>
            alert('Fornecedor cadastrado com sucesso!');
            window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
          </script>";
        } else {
            echo  "<script>
            alert('Erro ao cadastrar o fornecedores.');
            window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
          </script>";
        }
    
        $stmt->close();
    }

    $conn->close();
}

?>