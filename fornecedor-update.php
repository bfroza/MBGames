<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idFornecedor = $_POST["Fornecedores_idFornecedores"]; // ID do fornecedor a ser atualizado
    $linkSite = $_POST["linkSite"];

    // Conecte ao banco de dados
    $conn = new mysqli("localhost", "root", "", "mb_games");
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Execute a consulta de atualização
    $sql = "UPDATE Fornecedores SET linkSite = ? WHERE idFornecedores = ?";
    
    // Preparar a consulta
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    
    // Vincular parâmetros
    $stmt->bind_param("si", $linkSite, $idFornecedor);

    // Executar a consulta
    if ($stmt->execute() === TRUE) {
        echo  "<script>
        alert('Fornecedor atualizado com sucesso!');
        window.location.href = 'fornecedor-update-view.php'; // Redireciona para a página de cadastro
      </script>";
        
    } else {
        echo  "<script>
        alert('Erro ao atualizar fornecedor!');
        window.location.href = 'fornecedor-update-view.php'; // Redireciona para a página de cadastro
      </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
