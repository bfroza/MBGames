<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/cadastro.css">
    <link rel="shortcut icon" href="img/jogo-arcade.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Jogos</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#price').inputmask('R$ 999.99'); 
        });
    </script>
</head>
<body>
    <div class="cabecalho">
        <nav>
            <div class="lista">
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="jogos.php">JOGOS</a></li>
                    <li><a href="chaves-view.php">COMPRA</a></li>
                    <li><a href="cadastro-view.php">CADASTRO</a></li>
                    <li><a href="fornecedor-view.php">CADASTRO FORNECEDOR</a></li>
                    <li class="botao"><a href="login.html" target="_blank">ENTRAR</a></li>
                </ul>
            </div>
        </nav>   
        <div class="logo">
            <a href="index.php"><img src="img/desenvolvimento-de-jogos.png" alt="Logo">  </a>
            <h1>MB GAMES</h1>
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
                    <input type="text" id="desenvolvedor" name="desenvolvedor"  placeholder="Desenvolvedor" required>
                    <input type="text" id="anoLancamento" name="anoLancamento"  placeholder="Ano de lançamento do jogo" required>
                    <select id="categoria_id" name="Categorias_idCategorias" required>
                        <option value="" disabled selected>Selecione a Categoria</option>
                        <?php
                        // Conecte ao banco de dados e consulte as categorias
                        $conn = new mysqli("localhost", "root", "", "mb_games");
                        if ($conn->connect_error) {
                            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                        }

                        $sql = "SELECT idCategorias, categoria FROM categorias ORDER BY categoria ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['idCategorias'] . "'>" . $row['categoria'] . "</option>";
                            }
                        }

                        $conn->close();
                        ?>
                    </select>
                    <select id="fornecedor_id" name="Fornecedores_idFornecedores" required>
                        <option value="" disabled selected>Selecione o Fornecedor</option>
                        <?php
                        // Conecte ao banco de dados e consulte os fornecedores
                        $conn = new mysqli("localhost", "root", "", "mb_games");
                        if ($conn->connect_error) {
                            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                        }

                        $sql = "SELECT idFornecedores, nome FROM fornecedores ORDER BY nome";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['idFornecedores'] . "'>" . $row['nome'] . "</option>";
                            }
                        }

                        $conn->close();
                        ?>
                    </select>
                    <input type="number" id="valor" name="valor" min="1" step="0.01" placeholder="Preço do jogo" required>
                    <input type="file" id="imagem" name="imagem" placeholder="Imagem do jogo">
                </div>
                <button class="button" type="submit">Cadastrar Jogo</button>
            </form>
            <div class="li-icons">
                <ul>
                    <li><a href="cadastro-update-view.php"><img src="img/atualizar.png" alt="img pc" width="30px" height="30px"></a></li>
                    <li><a href="cadastro-delete-view.php"><img src="img/excluir.png" alt="img playstation" width="30px" height="30px"></a></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
