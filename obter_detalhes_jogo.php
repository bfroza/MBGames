<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtenha o ID do jogo enviado via POST
    $jogo_id = $_POST["jogo_id"];

    // Conecte ao banco de dados e consulte os detalhes do jogo
    $conn = new mysqli("localhost", "root", "", "mb_games");
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM jogos WHERE idJogos = $jogo_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $jogo = $result->fetch_assoc();
        // Adicione a chave 'id' ao array
        $jogo["id"] = $jogo["idJogos"];
        echo json_encode($jogo); // Envie os detalhes do jogo como JSON
    } else {
        echo json_encode([]); // Se o jogo não for encontrado, envie um array vazio
    }

    $conn->close();
}
?>
