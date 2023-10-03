<?php
include("conexao.php");

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
            // Obtenha o subtotal da sessão ou defina um valor padrão
            $subtotal = isset($_SESSION['subtotal']) ? $_SESSION['subtotal'] : 0;
            $total = $subtotal - ($subtotal * ($desconto / 100));

            // Atualize os valores na sessão
            $_SESSION['valorDesconto'] = $subtotal - $total;
            $_SESSION['total'] = $total;

            // Redirecione de volta para o carrinho
            header("Location: carrinho-view.php");
            exit(); // Certifique-se de sair para evitar a execução adicional do código
        }
    } else {
        echo "Cupom não encontrado.";
    }

    mysqli_free_result($result_cupom);
}
?>
