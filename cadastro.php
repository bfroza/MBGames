<?php
// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar os dados do formulário
    $nome = $_POST["nome"];
    $desenvolvedor = $_POST["desenvolvedor"];
    $anoLancamento = $_POST["anoLancamento"];
    $categoria = $_POST["categoria"];
    $valor = $_POST["valor"];
    
    $imagem = $_POST["imagem"];
    
    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
        $target_dir = "img/"; 
        $target_file = $target_dir . basename($_FILES["imagem"]["name"]);

        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
            $imagem = $target_file;
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    }

    // Conecte ao banco de dados
    $conn = new mysqli("localhost", "root", "", "mb_games");
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verifique se o jogo já existe pelo nome
    $sql_verificar = "SELECT idJogos FROM Jogos WHERE nome = ?";
    if ($stmt_verificar = $conn->prepare($sql_verificar)) {
        $stmt_verificar->bind_param("s", $nome);
        $stmt_verificar->execute();
        $stmt_verificar->store_result();

        if ($stmt_verificar->num_rows > 0) {
            // O jogo já existe, exiba uma mensagem de erro
            echo 
            "<script>
                alert('Um jogo com o mesmo nome já está cadastrado.');
                window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
              </script>";
            exit; // Saia do script para evitar a inserção duplicada
        }
        $stmt_verificar->close();
    }

    // Consulte o ID da categoria com base no nome da categoria
    $categoriaId = null;
    $sql_categoria = "SELECT idCategorias FROM Categorias WHERE categoria = ?";
    if ($stmt_categoria = $conn->prepare($sql_categoria)) {
        $stmt_categoria->bind_param("s", $categoria);
        $stmt_categoria->execute();
        $stmt_categoria->bind_result($categoriaId);
        $stmt_categoria->fetch();
        $stmt_categoria->close();
    }

    // Inserir dados na tabela Jogos
    $sql_inserir = "INSERT INTO Jogos (nome, desenvolvedor, anoLancamento, Categorias_idCategorias, valor, imagem) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt_inserir = $conn->prepare($sql_inserir)) {
        $stmt_inserir->bind_param("sssiis", $nome, $desenvolvedor, $anoLancamento, $categoriaId, $valor, $imagem);
        if ($stmt_inserir->execute()) {
            echo 
            "<script>
                alert('Jogo cadastrado com sucesso!!');
                window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
              </script>";
        } else {
            echo 
            "<script>
                alert('Erro ao cadastrar o jogo.');
                window.location.href = 'cadastro-view.php'; // Redireciona para a página de cadastro
              </script>";
        }
        $stmt_inserir->close();
    }

    $conn->close();
}
?>
