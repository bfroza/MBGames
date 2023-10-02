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
    // Função para confirmar a exclusão
    function confirmarDelete() {
        // Exibe uma caixa de diálogo de confirmação
        var confirmacao = confirm("Tem certeza de que deseja deletar o fornecedor?");

        // Se o usuário confirmar, envie o formulário
        if (confirmacao) {
            // Obtém o formulário
            var formulario = document.getElementById("form-delete"); // Substitua "form-delete" pelo ID do seu formulário

            // Envie o formulário
            formulario.submit();
        }
    }
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
                <h1>Deletar Fornecedores</h1>
            </div>
            <form action="fornecedor-delete.php" method="post" id="form-delete">
                <div class="inputs">
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
    
                </div>
                <button class="button" type="button" onclick="confirmarDelete()">Deletar Fornecedor</button>
            </form>
            <div class="li-icons">
                <ul>
                    <li><a href="fornecedor-update-view.php"><img src="img/atualizar.png" alt="img pc" width="30px" height="30px"></a></li>
                    <li><a href="fornecedor-view.php"><img src="img/cadastro.png" alt="img playstation" width="30px" height="30px"></a></li>
                </ul>
            </div>
    
        </div>
    </div>
    
</body>
</html>
