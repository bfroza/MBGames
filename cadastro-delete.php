<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Obtenha o ID do jogo enviado via POST
  $jogo_id = $_POST['Jogos_idJogos'];

  // Conecte ao banco de dados
  $conn = new mysqli("localhost", "root", "", "mb_games");
  if ($conn->connect_error) {
      die("Falha na conexão com o banco de dados: " . $conn->connect_error);
  }

  // Primeiro, exclua o registro da tabela "Chaves"
  $sql1 = "DELETE FROM Chaves WHERE Jogos_idJogos = ?";
  $stmt1 = $conn->prepare($sql1);
  $stmt1->bind_param("i", $jogo_id);

  if ($stmt1->execute()) {
    // Em seguida, chame a stored procedure para excluir o jogo
    $sql2 = "CALL ExcluirJogo(?)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $jogo_id);

    if ($stmt2->execute()) {
      echo "<script>
      alert('Jogo e chave deletados com sucesso.');
      window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
      </script>";
    } else {
      echo "<script>
      alert('Erro ao excluir o jogo e a chave.');
      window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
      </script>";
    }

    $stmt2->close();
  } else {
    echo "<script>
    alert('Erro ao excluir a chave.');
    window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
    </script>";
  }

  $stmt1->close();
  $conn->close();
}
?>
