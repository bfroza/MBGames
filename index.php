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
                <li><a href="index.php">INÍCIO</a></li>
                <li><a href="jogos.php">JOGOS</a></li>
                <li><a href="cadastro-view.php">CADASTRO</a></li>
                <li><a href="lista-fornecedor.php">LISTA FORNECEDORES</a></li>
                <li><a href="estoque.php">ESTOQUE</a></li>
                <li><a href="lista-vendas.php">LISTA VENDAS</a></li>
                <?php 
                     include("conexao.php");
                    if ($loginResult != 'success' || $logado != true) {
                        echo '<li class="botao"><a href="login.php" target="_blank">ENTRAR</a></li>';
                    } else {
                        echo '<li><a href="carrinho.html"><i class="fas fa-shopping-cart" style="color: #FFFFFF;"></i></a></li>';
                    }
                    ?>
                
            </ul>

            </div>
        </nav>   
        <div class="logo">
            <a href="index.php"><img src="img/desenvolvimento-de-jogos.png" alt="Logo"></a>
            <h1>MB GAMES</h1>
        </div>
    </div>
    
    <?php
    include("conexao.php");

    $sql_select = "SELECT nome, ImagemDoJogo, SUM(quantidade) as quantidade, desenvolvedor, anoLancamento, valor 
    FROM `visu_jogos` 
    GROUP BY nome, ImagemDoJogo, desenvolvedor, anoLancamento, valor";
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
            
            $filtroSaturacao = ($row['quantidade'] == 0) ? 'style="filter: grayscale(100%);" ' : '';
            echo '<a href="jogos.php"><img src="' .$img. $row['ImagemDoJogo'] . '" alt="" height="470" width="270" class="img" ' . $filtroSaturacao . '></a>';
            echo '<p>' . $row['nome'] . '</p>';
            echo '<p>' . $row['desenvolvedor'] . '</p>';
            echo '<p>' . $row['anoLancamento'] . '</p>';
           

          
            
         
            
           
           
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

