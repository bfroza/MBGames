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
<body>
    <div class="cabecalho">
        <nav>
            <div class="lista">
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="jogos.php">JOGOS</a></li>
                    <li><a href="platafoma.php">PLATAFORMAS</a></li>
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
                <h1>Cadastro de Chaves</h1>
            </div>
            <form action="cadastro-chaves.php" method="post">
                <div class="inputs">
                    <select name="jogo_id" required>
                        <option value="" disabled selected>Selecione o Jogo</option>
                        <?php
                            // Conecte ao banco de dados e consulte os jogos cadastrados
                            $conn = new mysqli("localhost", "root", "", "mb");
                            if ($conn->connect_error) {
                                die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                            }

                            $sql = "SELECT id, nome FROM jogos";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                                }
                            }

                            $conn->close();
                        ?>
                    </select>
                    <textarea name="chaves" cols="49" rows="10" placeholder="Digite as chaves"></textarea>
                </div>
                <button class="button" type="submit">Cadastrar Chaves</button>
            </form>
            
            

    
        </div>
    </div>
    
</body>
</html>


