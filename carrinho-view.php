<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

$valorDesconto = 0;
$subtotal = 0;
$total = 0;
$desconto = 0;

$idCupom = 2;
$idUsuario = 1;

// Verifique se o formulário foi enviado com um cupom
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cupom"])) {
    $cupom = $_POST["cupom"];

    // Consulte o banco de dados para verificar se o cupom existe e está ativo
    $sql_select_cupom = "SELECT desconto, ativo FROM Cupons WHERE cupom = '$cupom'";
    $result_cupom = mysqli_query($conexao, $sql_select_cupom);

    if ($result_cupom && mysqli_num_rows($result_cupom) > 0) {
        $cupomInfo = mysqli_fetch_assoc($result_cupom);
        $desconto = $cupomInfo['desconto'];

        if ($cupomInfo['ativo'] == 1) {
            // O cupom existe e está ativo, aplique o desconto ao subtotal
            $subtotal = $_SESSION['subtotal'] ?? 0;
            $valorDesconto = $subtotal * ($desconto / 100);

            // Atualize os valores na sessão
            $_SESSION['valorDesconto'] = $valorDesconto;
            $total = $subtotal - $valorDesconto;
            $_SESSION['total'] = $total;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="img/carrinho-de-compras.png" type="image/x-icon">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<header>
    <a href="jogos.php">
        <img src="img/seta-para-a-esquerda.png" alt="" height="50px" width="50px">
    </a>
    <span>Carrinho de compras do <b>MB</b></span>
</header>
<main>
    <div class="page-title">Seu Carrinho</div>
    <div class="content">
        <section>
            <table>
                <thead>
                <tr>
                    <th>Nome do Jogo</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $counter = 0;

                // Verifique se o formulário foi enviado
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_jogo"]) && isset($_POST["quantidade"])) {
                    // Recupere o ID do jogo e a quantidade do formulário
                    $idJogo = $_POST["id_jogo"];
                    $quantidade = $_POST["quantidade"];

                    // Consulte o banco de dados para obter as informações do jogo com base no ID
                    $sql_select = "SELECT idJogos, nome, desenvolvedor, anoLancamento, Nomecategoria, NomeFornecedor, valor, ImagemDoJogo, quantidade FROM `visu_jogos` WHERE idJogos = '$idJogo'";
                    $result = mysqli_query($conexao, $sql_select);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);

                        // Exiba as informações do jogo no carrinho com base nas informações recuperadas
                        echo '<tr data-id="' . $idJogo . '" >';
                        echo '<td>';
                        echo '<div class="product">';
                        echo '<img src="img/' . $row['ImagemDoJogo'] . '" alt="" width="100" height="120" />';
                        echo '<div class="info">';
                        echo '<div class="name">' . $row['nome'] . '</div>';
                        echo '<div class="category">' . $row['Nomecategoria'] . '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</td>';
                        echo '<td>R$ ' . number_format($row['valor'], 2, ',', '.') . '</td>';
                        echo '<td>';
                        echo '<div class="qty">';
                        echo '<span class="quantity">' . $quantidade . '</span>';
                        echo '</div>';
                        echo '</td>';
                        echo '<td>R$ ' . number_format($row['valor'] * $quantidade, 2, ',', '.') . '</td>';
                        echo '<td>';
                        echo '<button class="remove" data-id="' . $idJogo . '"><i class="bx bx-x"></i></button>';
                        echo '</td>';
                        echo '</tr>';

                        $counter++;
                    } else {
                        echo "Erro ao recuperar informações do jogo do banco de dados: " . mysqli_error($conexao);
                    }

                    mysqli_free_result($result);
                }
                ?>
                </tbody>
            </table>
        </section>
        <aside>
            <div id="carrinho-container "  class="box">
                <header>Resumo da compra</header>
                <div class="info">
                    <?php
                    // Calcule o subtotal com base nos valores do jogo antes de verificar o cupom
                    $subtotal = 0;
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_jogo"]) && isset($_POST["quantidade"])) {
                        $idJogo = $_POST["id_jogo"];
                        $quantidade = $_POST["quantidade"];
                        $sql_select = "SELECT valor FROM `visu_jogos` WHERE idJogos = '$idJogo'";
                        $result = mysqli_query($conexao, $sql_select);
                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $subtotal = $row['valor'] * $quantidade;
                            $total = $row['valor'] * $quantidade;
                        }
                        mysqli_free_result($result);
                    }
                    
                    // Verifique se o carrinho está vazio ou se há itens
                    if ($counter > 0) {
                        echo '<div ><span>Sub-total</span><span>R$ ' . number_format($subtotal, 2, ',', '.') . '</span></div>';
                        echo '<div><span>Desconto</span><span>R$ ' . number_format($desconto, 2, ',', '.') . '</span></div>';
                        echo '<footer><span>Total</span><span>R$ ' . number_format($total, 2, ',', '.') . '</span></footer>';
                    } else {
                        echo '<p>Seu carrinho está vazio.</p>';
                    }
                    ?>

                    <!-- <div>
                    <form id="cupom-form">
                      
                    <input type="text" placeholder="Adicionar cupom de desconto" name="cupom" id="cupom">
                    <input type="hidden" name="subtotal" value="">
                    <button type="disable">Aplicar Cupom</button>
                    </form>

                    </div> -->
                </div>
            </div>
            <form action="vendas.php" id="vendas" name="vendas" method="post">
                    <?php
                    // Execute a consulta SQL para recuperar os valores desejados
                    $sql_select_venda = "SELECT * FROM `visu_jogos` WHERE idJogos = '$idJogo'";
                    // Substitua 'sua_conexao' pela sua lógica de conexão com o banco de dados
                    $result = $conexao->query($sql_select_venda);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        // Recupere os valores da consulta
                        $valorTotal = $row['valor'];
                        $Chaves_idChaves = $row['IDChave'];
                    }

                    // Obtenha a data atual no formato desejado (por exemplo, Y-m-d)
                    $dataAtual = date("Y-m-d");

                    // Crie campos hidden para os valores recuperados e a data atual
                    echo '<input type="hidden" name="valorTotal" value="' . $valorTotal . '">';
                    echo '<input type="hidden" name="Cupons_idCupons" value="' . $idCupom . '">';
                    echo '<input type="hidden" name="Usuarios_idUsuarios" value="' . $idUsuario . '">';
                    echo '<input type="hidden" name="Chaves_idChaves" value="' . $Chaves_idChaves . '">';
                    echo '<input type="hidden" name="dataAtual" value="' . $dataAtual . '">';
                    ?>
            <button style="background-color: #0e542a; color: white; padding: 15px 0; border: none; width: 100%; text-transform: uppercase; letter-spacing: 1px; font-size: 16px; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#0b451f';" onmouseout="this.style.backgroundColor='#0e542a';">
            Finalizar Compra
            </button>



          
            
            </form>
        </aside>
    </div>

</main>

<script>
    // Pega todos os botões de remoção
const removeButtons = document.querySelectorAll('.remove');

// Adiciona um evento de clique aos botões de remoção
removeButtons.forEach((button) => {
    button.addEventListener('click', () => {
        // Obtém o ID do jogo a ser removido a partir do atributo data-id
        const gameId = button.getAttribute('data-id');

        // Remove a linha da tabela com base no ID do jogo
        const rowToRemove = document.querySelector('tr[data-id="' + gameId + '"]');
        if (rowToRemove) {
            rowToRemove.remove();

            // Calcula o novo subtotal e atualiza a exibição
            const subtotalElements = document.querySelectorAll('td:nth-child(4)');
            let newSubtotal = 0;
            subtotalElements.forEach((element) => {
                newSubtotal += parseFloat(element.textContent.replace('R$ ', '').replace(',', '.'));
            });
            
            // Atualiza o subtotal na página
            const subtotalSpan = document.querySelector('footer span:nth-child(2)');
            subtotalSpan.textContent = 'R$ ' + newSubtotal.toFixed(2).replace('.', ',');

            // Atualiza o total (considerando desconto) na página
            const desconto = parseFloat('<?php echo $valorDesconto; ?>');
            const total = newSubtotal - desconto;
            const totalSpan = document.querySelector('footer span:nth-child(4)');
            totalSpan.textContent = 'R$ ' + total.toFixed(2).replace('.', ',');

            // Atualiza o valor do subtotal na sessão
            <?php if(isset($_SESSION['subtotal'])) { ?>
                <?php if(isset($_SESSION['valorDesconto'])) { ?>
                    <?php if(isset($_SESSION['total'])) { ?>
                        <?php
                            echo 'const newSubtotalValue = ' . $subtotal . ';';
                            echo 'const newTotalValue = ' . $total . ';';
                        ?>
                        <?php echo '$_SESSION["subtotal"] = newSubtotalValue;' ?>
                        <?php echo '$_SESSION["total"] = newTotalValue;' ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        }
    });
});


    // // Adiciona um evento de submit ao formulário do cupom
    // cupomForm.addEventListener("submit", function (e) {
    //     e.preventDefault();

    //     // Obtém os dados do formulário
    //     const formData = new FormData(cupomForm);

    //     // Envia os dados do formulário via AJAX para desconto.php
    //     fetch("desconto.php", {
    //         method: "POST",
    //         body: formData,
    //     })
    //     .then(response => response.text())
    //     .then(data => {
    //         // Atualiza o conteúdo do carrinho com a resposta do servidor
    //         carrinhoContainer.innerHTML = data;
    //     })
    //     .catch(error => console.error("Erro ao aplicar cupom:", error));
    // });
</script>


</body>
</html>
