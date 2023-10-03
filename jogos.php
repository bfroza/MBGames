<?php
include("conexao.php");


if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

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
                    <li><a href="carrinho-view.php"><i class="fas fa-shopping-cart" style="color: #FFFFFF;"></i></a></li>
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
    
    $sql_select = "SELECT idJogos, nome, desenvolvedor, anoLancamento, Nomecategoria, NomeFornecedor, valor, ImagemDoJogo, quantidade FROM `visu_jogos`";
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
    
            echo '<li>';
            echo '<form method="POST" action="carrinho-view.php">';
            echo '<input type="hidden" name="id_jogo" value="' . $row['idJogos'] . '">'; // Campo oculto com o ID do jogo
    
            echo '<a href="#"><img src="img/' . $row['ImagemDoJogo'] . '" alt="" height="470" width="270" class="img"></a>';
    
            echo '<p>' . $row['nome'] . '</p>';
            echo '<p>Quantidade disponível: ' . $row['quantidade'] . '</p>';
            echo '<p>Preço: R$ ' . $row['valor'] . '</p>';
            echo '<p>' . $row['desenvolvedor'] . '</p>';
            echo '<p>' . $row['anoLancamento'] . '</p>';
            echo '<p>' . $row['Nomecategoria'] . '</p>';
            echo '<p>' . $row['NomeFornecedor'] . '</p>';
    
            echo '<label for="quantidade">Selecione a quantidade:</label>';
            $quantidadeDisabled = ($row['quantidade'] == 0) ? 'disabled' : '';
            if ($row['quantidade'] > 0) {
                echo '<input type="number" id="quantidade" name="quantidade" min="1" max="' . $row['quantidade'] . '" ' . $quantidadeDisabled . ' value="1">';
            } else {
                echo '<input type="number" id="quantidade" name="quantidade" min="1" max="' . $row['quantidade'] . '" ' . $quantidadeDisabled . '>';
            }
    
            $botaoDisabled = ($row['quantidade'] == 0) ? 'jogo-sem-estoque' : '';
            echo '<button type="submit" name="add_to_cart" class="comprar-button ' . $botaoDisabled . '" ' . $quantidadeDisabled . '>Adicionar ao carrinho</button>';
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_jogo"]) && isset($_POST["quantidade"])) {
                // Recupere o ID do jogo e a quantidade do formulário
                $idJogo = $_POST["id_jogo"];
                $quantidade = $_POST["quantidade"];
              
                // Inicialize ou atualize a variável de sessão $_SESSION['carrinho']
                if (!isset($_SESSION['carrinho'])) {
                  $_SESSION['carrinho'] = array();
                }
              
                // Adicione o jogo ao carrinho
                $_SESSION['carrinho'][$idJogo] = $quantidade;
              
                // Redirecione de volta para a página de jogos ou para onde você desejar
                header("Location: jogos.php");
                exit;
              }
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
    var loginResult = "<?php echo $loginResult; ?>";
    console.log(loginResult);
</script>
