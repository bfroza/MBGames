<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idJogo = $_POST["Jogos_idJogos"];
    $desenvolvedor = $_POST["desenvolvedor"];
    $anoLancamento = $_POST["anoLancamento"];
    $categorias_idCategorias = $_POST["Categorias_idCategorias"];
    $fornecedores_idFornecedores = $_POST["Fornecedores_idFornecedores"];
    $valor = $_POST["valor"];
    $imagem = $_POST["imagem"];
    
    if(empty($imagem)){
      $imagem = "imagem.jpg"; // Define o valor padrão "imagem.jpg"
    }
    
    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "", "mb_games");
    
    // Verifica a conexão com o banco de dados
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }
    
    // Chama a stored procedure para atualizar os dados do jogo
    $sql = "CALL UpdateJogo(?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Vincula os parâmetros
    $stmt->bind_param("issiiis", $idJogo, $desenvolvedor, $anoLancamento, $categorias_idCategorias, $fornecedores_idFornecedores, $valor, $imagem);
    
    // Executa a stored procedure
    if ($stmt->execute()) {
      echo "<script>
      alert('Jogo atualizado com sucesso!');
      window.location.href = 'cadastro-update-view.php'; // Redireciona para a página de cadastro
    </script>";
    } else {
      echo "<script>
      alert('Falha ao atualizar jogo!');
      window.location.href = 'cadastro-update-view.php'; // Redireciona para a página de cadastro
    </script>";
    }
    
    // Fecha a conexão com o banco de dados
    $stmt->close();
    $conn->close();
}
?>
