<?php
include("conexao.php");

$loginResult = ""; 
$logado = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['user']);
    $senha = trim($_POST['senha']);

    $sql = "SELECT * FROM usuarios WHERE user= '$user' AND senha = '$senha'";
    $result = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($result) == 1){
        $loginResult = "success";
        header("Location: index.php");
        $logado = true;
        exit;
    }
    else{
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/jogos-pag.css">
    <link rel="shortcut icon" href="img/controlador.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MB GAMES</title>
</head>
<body>
    <div class="cabecalho">
        <nav>
            <div class="lista">
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="jogos.php">JOGOS</a></li>
                    <li><a href="lista.php">LISTA</a></li>
                    <li><a href="cadastro-view.php">CADASTRO</a></li>
                    <li><a href="carrinho.html"><i class="fas fa-shopping-cart" style="color: #FFFFFF;"></i></a></li>
                </ul>
            </div>
        </nav>   
        <div class="logo">
            <a href="index.php"><img src="img/desenvolvimento-de-jogos.png" alt="Logo" ></a>
            <h1>MB GAMES - JOGOS </h1>
        </div>
    </div>
    
    <?php
    include("conexao.php");

    $sql_select = "SELECT nome, img, plataforma, quantidade, price FROM visu_jogos";
    $result = mysqli_query($conexao, $sql_select);

    if ($result) {
        $counter = 0; 
        echo '<div class="corpo">';
        echo '<ul>';
        
        while ($row = mysqli_fetch_assoc($result)) {
            if ($counter % 6 == 0) {
                echo '</ul>';
                echo '<ul>';
            }
        
            $img = "img/";
        
            // Verifique se a quantidade é igual a 0
            $classeCSS = ($row['quantidade'] == 0) ? 'jogo-sem-estoque' : '';
        
            echo '<li>';
            echo '<form method="POST" action="vendas.php">';
        
            // Aplicar o filtro de saturação à imagem quando a quantidade for 0
            $filtroSaturacao = ($row['quantidade'] == 0) ? 'style="filter: grayscale(100%);" ' : '';
            echo '<a href="#"><img src="' . $img . $row['img'] . '" alt="" height="470" width="270" class="img ' . $classeCSS . '" ' . $filtroSaturacao . '></a>';
        
            echo '<p>' . $row['nome'] . '</p>';
            echo '<p>Quantidade disponível: ' . $row['quantidade'] . '</p>';
            echo '<p>Preço: R$ ' . $row['price'] . '</p>';
            echo '<p>' . $row['plataforma'] . '</p>';
        
            echo '<label for="quantidade">Selecione a quantidade:</label>';
        
            // Adicione a propriedade "disabled" ao campo de quantidade quando a quantidade for 0
            $quantidadeDisabled = ($row['quantidade'] == 0) ? 'disabled' : '';
            if($row['quantidade'] > 0){
            echo '<input type="number" id="quantidade" name="quantidade" min="1" max="' . $row['quantidade'] . '" ' . $quantidadeDisabled . ' value="1">';}
            else{
                echo '<input type="number" id="quantidade" name="quantidade" min="1" max="' . $row['quantidade'] . '" ' . $quantidadeDisabled . '>';
            }

        
            echo '<input type="hidden" name="jogo" value="' . $row['nome'] . '">';
        
            // Adicione a classe CSS "comprar-button" ao botão de compra
            // e desabilite a interação do botão quando a quantidade for 0
            $botaoDisabled = ($row['quantidade'] == 0) ? 'jogo-sem-estoque' : '';
            echo '<button type="submit" class="comprar-button ' . $botaoDisabled . '" ' . $quantidadeDisabled . '>Adicionar ao carrinho</button>';
        
            echo '</form>';
            echo '</li>';
        
            $counter++;
        }
        
        
        
        
        
        
        
        echo '</ul>';
        echo '</div>';
        
        mysqli_free_result($result);
    } else {
        echo "Erro ao recuperar jogos do banco de dados: " . mysqli_error($conexao);
    }

    mysqli_close($conexao);
    ?>
</body>
</html>

<script>
    console.log(<?php echo'$loginResult' ?>)
</script>
