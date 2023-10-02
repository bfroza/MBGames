<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Dados do formulário
  $nome = $_POST["nome"];
  $desenvolvedor = $_POST["desenvolvedor"];
  $anoLancamento = $_POST["anoLancamento"];
  $categoria_id = $_POST["Categorias_idCategorias"];
  $fornecedor_id = $_POST["Fornecedores_idFornecedores"];
  $valor = $_POST["valor"];
  
  if (empty($_POST['imagem'])) {
      $imagem = "imagem.jpg"; 
  } else {
      $imagem = trim($_POST["imagem"]);
  }

  // Conecte ao banco de dados
  $conn = new mysqli("localhost", "root", "", "mb_games");
  if ($conn->connect_error) {
      die("Falha na conexão com o banco de dados: " . $conn->connect_error);
  }

  // Verifique se o jogo já existe pelo nome
  $verificaJogoExistente = "SELECT idJogos FROM Jogos WHERE nome = ?";
  $stmtVerifica = $conn->prepare($verificaJogoExistente);
  $stmtVerifica->bind_param("s", $nome);
  $stmtVerifica->execute();
  $stmtVerifica->store_result();

  if ($stmtVerifica->num_rows > 0 ) {
      // Jogo já existe, exiba uma mensagem de erro
      echo  "<script>
      alert('Este jogo já está cadastrado.');
      window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
      </script>";
  } else {
      // Jogo não existe, insira os dados na tabela de jogos
      $stmtVerifica->close();

      // Chame a stored procedure para inserir os dados
      $sql = "CALL InserirJogo(?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sssiids", $nome, $desenvolvedor, $anoLancamento, $categoria_id, $fornecedor_id, $valor, $imagem);
  
      if ($stmt->execute()) {
          echo  "<script>
          alert('Jogo cadastrado com sucesso!!.');
          window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
          </script>";
      } else {
          echo  "<script>
          alert('Erro ao cadastrar o jogo.');
          window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
          </script>";
      }
  
      $stmt->close();
  }

  $conn->close();
}

?>
