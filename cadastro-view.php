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
                <h1>Cadastro de Jogos</h1>
            </div>
            <form action="cadastro.php" method="post">
                <div class="inputs">
                    <input type="text" id="nome" name="nome" placeholder="Nome do jogo" required>
                    <select id="plataforma" name="plataforma" aria-placeholder="Plataforma" required>
                        <option value="" disabled selected>Selecione a Plataforma</option>
                        <option value="PC">PC</option>
                        <option value="PlayStation">PlayStation</option>
                        <option value="Xbox">Xbox</option>
                    </select>
                    <select id="categoria" name="categoria" required>
                        <option value="" disabled selected>Selecione a Categoria</option>
                        <?php
                            // Conecte ao banco de dados e consulte as categorias
                            $conn = new mysqli("localhost", "root", "", "mb");
                            if ($conn->connect_error) {
                            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                            }

                            $sql = "SELECT id, tipo_de_jogo FROM categoria";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['tipo_de_jogo'] . "</option>";
                            }
                            }

                            $conn->close();
                        ?>
                    </select>
                    <input type="number" id="quantidade" name="quantidade" value="1" min="1" placeholder="Quantidade" required>
                    <input type="number" id="price" name="price" min="10.01" step="any" placeholder="Preço do jogo" required>

                    <input type="file" id="img" name="img" placeholder="Imagem do jogo">
                </div>
                <button class="button" type="submit">Cadastrar Jogo</button>
            </form>
            
            <div class="li-icons">
                <ul>
                  <li><a href="#"><img src="img/jogos.png" alt="img pc" width="30px" height="30px"></a></li>
                  <li><a href="#"><img src="img/botoes.png" alt="img playstation" width="30px" height="30px"></a></li>
                  <li><a href="#"><img src="img/xbox.png" alt="img xbox" width="30px" height="30px"></a></li>
                </ul>
              </div>
    
        </div>
    </div>
    
</body>
</html>



