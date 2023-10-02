<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/cadastro.css">
    <link rel="shortcut icon" href="img/jogo-arcade.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Jogos</title>
   
</head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#price').inputmask('R$ 999.99'); 
        });
    </script>
<body>
    <div class="cabecalho">
        <nav>
            <div class="lista">
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="jogos.php">JOGOS</a></li>
                    <li><a href="chaves-view.php">COMPRA</a></li>
                    <li><a href="cadastro-view.php">CADASTRO</a></li>
                    <li class="botao"><a href="login.html" target="_blank">ENTRAR</a></li>
                </ul>
            </div>
           
        </nav>   
        <div class="logo">
            <a href="index.php"><img src="img/desenvolvimento-de-jogos.png" alt="Logo">  </a>
            <H1>MB GAMES</H1>
        </div>
    </div>
    <div class="corpo-form">
        <div class="form">
            <div class="cadastro-h1">
                <h1>Cadastro de Fornecedores</h1>
            </div>
            <form action="fornecedor.php" method="post">
                <div class="inputs">
                    <input type="text" id="nome" name="nome" placeholder="Nome do Fornecedor" required>
                    <input type="text" id="linkSite" name="linkSite" placeholder="Link do Site" required>
    
                </div>
                <button class="button" type="submit">Cadastrar Fornecedor</button>
            </form>
            <div class="li-icons">
                <ul>
                    <li><a href="fornecedor-update-view.php"><img src="img/atualizar.png" alt="img pc" width="30px" height="30px"></a></li>
                    <li><a href="fornecedor-delete-view.php"><img src="img/excluir.png" alt="img playstation" width="30px" height="30px"></a></li>
                </ul>
            </div>
    
        </div>
    </div>
    
</body>
</html>



