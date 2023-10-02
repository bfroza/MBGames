<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o ID do fornecedor foi enviado via POST
    if(isset($_POST["Fornecedores_idFornecedores"]) && !empty($_POST["Fornecedores_idFornecedores"])) {
        $idFornecedor = $_POST["Fornecedores_idFornecedores"];
        
        // Conecta ao banco de dados
        $conn = new mysqli("localhost", "root", "", "mb_games");
        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        // Executa a consulta de exclusão
        $sql = "DELETE FROM fornecedores WHERE idFornecedores = ?";

        // Prepara a consulta
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Erro ao preparar a consulta: " . $conn->error);
        }

        // Vincula o parâmetro
        $stmt->bind_param("i", $idFornecedor);

        // Executa a consulta
        if ($stmt->execute() === TRUE) {
            echo "<script>
                    alert('Fornecedor excluido com sucesso!');
                    window.location.href = 'fornecedor-delete-view.php'; // Redireciona para a página de cadastro
                  </script>";
        } else {
            echo "<script>
                    alert('Erro ao excluir fornecedor!');
                    window.location.href = 'fornecedor-delete-view.php'; // Redireciona para a página de cadastro
                  </script>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "ID do fornecedor não foi fornecido.";
    }
}
?>
