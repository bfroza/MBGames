<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/index.css">
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
                <li><a href="cadastro.html">CADASTRO</a></li>
                <li><a href="platafoma.html">PLATAFORMAS</a></li>
                <?php 
                     include("conexao.php");
                        if ($loginResult != 'success' or $logado != true) {
                            echo ' <li class="botao"><a href="login.php" target="_blank">ENTRAR</a></li>';
                        } 
                        else{
                           
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
    
    <div class="corpo">
        <ul>
            <li><a href="#"><img src="img/AC_Valhalla_capa.webp" alt="" height="470" width="270" class="img"></a> Assassin's Creed Valhalla</li>
            <li><a href="#"><img src="img/rogue.jfif" alt=""  height="470" width="270" class="img"></a> Assassin's Creed Rogue</li>
            <li><a href="#"><img src="img/transferir.jfif" alt="" height="470" width="270" class="img"></a> The Witcher</li>
            <li><a href="#"><img src="img/gta.jfif" alt=""  height="470" width="270" class="img"></a> GTA V</li>
            <li><a href="#"><img src="img/red.jpg" alt=""  height="470" width="270" class="img"></a> Red Dead Redemption</li>
            <li><a href="#"><img src="img/red.jpg" alt=""  height="470" width="270" class="img"></a> Red Dead Redemption</li>
        </ul>
    </div>
</body>
</html>


