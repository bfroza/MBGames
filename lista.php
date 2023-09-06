<?php
// Conecte-se ao banco de dados
include("conexao.php");

// Execute uma consulta na view visu_jogos
$sql = "SELECT nome, price, quantidade, img FROM visu_jogos";
$result = mysqli_query($conexao, $sql);

// Verifique se há erros na consulta
if (!$result) {
    die("Erro na consulta: " . mysqli_error($conexao));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/lista.css">
    <link rel="shortcut icon" href="img/jogo-arcade.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Jogos</title>
</head>
<body>
    <div class="cabecalho">
        <nav>
            <div class="lista">
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="jogos.php">JOGOS</a></li>
                    <li><a href="platafoma.html">PLATAFORMAS</a></li>
                    <li><a href="cadastro.html">CADASTRO</a></li>
                </ul>
            </div>
           
        </nav>   
        <div class="logo">
            <a rotating-element href="index.html"><img src="img/desenvolvimento-de-jogos.png" alt="Logo">  </a>
            <H1>MB GAMES</H1>
        </div>
    </div>
    <div class="container"></div>

    <h1>Lista de Jogos Disponíveis</h1>
    <table>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Imagem</th>
        </tr>
        <?php
      
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['nome'] . "</td>";
            echo "<td>R$" . $row['price'] . "</td>"; 
            echo "<td>" . $row['quantidade'] . "</td>";
            $caminhoParaImagens = "img/"; 
            $urlDaImagem = $caminhoParaImagens . $row['img'];
            echo "<td><img src='" . $urlDaImagem . "' alt='Imagem do Jogo' width='100'></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>

<?php

mysqli_close($conexao);
?>
