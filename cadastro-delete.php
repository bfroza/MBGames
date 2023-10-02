<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Obtenha o ID do jogo enviado via POST
  $jogo_id = $_POST['Jogos_idJogos'];

  // Conecte ao banco de dados
  $conn = new mysqli("localhost", "root", "", "mb_games");
  if ($conn->connect_error) {
      die("Falha na conexão com o banco de dados: " . $conn->connect_error);
  }

  // Chame a procedure de exclusão
  $sql = "CALL ExcluirJogo(?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $jogo_id);

  if ($stmt->execute()) {
    echo  "<script>
    alert('Jogo deletado com sucesso!!.');
    window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
    </script>";
  } else {
    echo  "<script>
    alert('Jogo deletado com sucesso!!.');
    window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
    </script>";
  }

  $stmt->close();
  $conn->close();
}


?>
