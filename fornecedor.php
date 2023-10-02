<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $nome = $_POST["nome"];
    $linkSite = $_POST["linkSite"];
    $conn = new mysqli("localhost", "root", "", "mb_games");
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Chama a stored procedure para inserir o fornecedor
    $sql = "CALL InserirFornecedor(?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nome, $linkSite);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $mensagem = $row["mensagem"];

        echo "<script>
            alert('$mensagem');
            window.location.href = 'fornecedor-view.php'; // Redireciona para a página de cadastro
          </script>";
    } else {
        echo "<script>
            alert('Erro ao cadastrar o fornecedor.');
            window.location.href = 'fornecedor-view.php'; // Redireciona para a página de cadastro
          </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
