<?php
include("conexao.php");

$nome = trim($_POST['nome']);
$plataforma = $_POST['plataforma'];
$price = trim($_POST['price']);
$quantidade = trim($_POST['quantidade']);
$img = trim($_POST['img']);

// Verificar se o jogo já existe na tabela para a mesma plataforma
$verificar_sql = "SELECT * FROM jogos WHERE nome = ? AND plataforma = ?";
$verificar_stmt = mysqli_prepare($conexao, $verificar_sql);
mysqli_stmt_bind_param($verificar_stmt, "ss", $nome, $plataforma);
mysqli_stmt_execute($verificar_stmt);
$result = mysqli_stmt_get_result($verificar_stmt);

if (mysqli_num_rows($result) > 0) {
    // O jogo já existe para a mesma plataforma, então vamos atualizar a quantidade e/ou preço
    $row = mysqli_fetch_assoc($result);
    $novo_preco = $row['price'] = $price; // Altera o preço
    $nova_quantidade = $row['quantidade'] + $quantidade; // Somar a nova quantidade à quantidade existente

    $atualizar_sql = "UPDATE jogos SET price = ?, quantidade = ? WHERE nome = ? AND plataforma = ?";
    $atualizar_stmt = mysqli_prepare($conexao, $atualizar_sql);
    mysqli_stmt_bind_param($atualizar_stmt, "ddss", $novo_preco, $nova_quantidade, $nome, $plataforma);

    if (mysqli_stmt_execute($atualizar_stmt)) {
        echo "<script>alert('Jogo atualizado com sucesso!');</script>";
        header("Location: cadastro.html");
        //não sei como fazer o alert
        
    } else {
        echo "<script>alert('Erro ao atualizar o jogo: " . mysqli_error($conexao) . "');</script>";
        header("Location: cadastro.html");
        
    }

    mysqli_stmt_close($atualizar_stmt);
} else {
    // O jogo não existe para a mesma plataforma, então vamos inseri-lo
    $inserir_sql = "INSERT INTO jogos (nome, plataforma, price, quantidade, img) VALUES (?, ?, ?, ?, ?)";
    $inserir_stmt = mysqli_prepare($conexao, $inserir_sql);
    mysqli_stmt_bind_param($inserir_stmt, "ssdds", $nome, $plataforma, $price, $quantidade, $img);

    if (mysqli_stmt_execute($inserir_stmt)) {
        
        echo "<script>
        function exibirAlerta() {
          Swal.fire('Jogo cadastrado com sucesso!')
        }
        </script>";

        

        
       
    } else {
        echo "<script>alert('Erro ao cadastrar o jogo: " . mysqli_error($conexao) . "');</script>";
      ;
        
        
    }
    header("Location: cadastro.html");

    mysqli_stmt_close($inserir_stmt);
}

mysqli_close($conexao);
?>
