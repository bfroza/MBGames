<?php
// Conecte-se ao banco de dados
include("conexao.php");

// Execute uma consulta na tabela visu_jogos
$sql = "SELECT nome, plataforma, price, quantidade, img FROM visu_jogos";
$result = mysqli_query($conexao, $sql);

// Verifique se há erros na consulta
if (!$result) {
    die("Erro na consulta: " . mysqli_error($conexao));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Jogos Disponíveis</title>
    <link rel="stylesheet" href="css/css1/bootstrap.min.css">
    <link rel="stylesheet" href="css/css1/bs-admin.css">
    <link rel="stylesheet" href="css/css1/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/css1/select2.min.css">
    <link rel="stylesheet" href="css/css1/select2-bootstrap-5-theme.min.css">
    <link rel="stylesheet" href="css/css1/font-awesome-all.min.css">
    <link rel="stylesheet" href="css/listas.css">
</head>
<body>
    <h1>Lista de Jogos Disponíveis</h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-bordered table-hover" id="dados">
                                <thead>
                                    <tr>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Plataforma</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">Preço</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $caminhoParaImagens = "img/";
                                        $urlDaImagem = $caminhoParaImagens . $row['img'];
                                        ?>
                                        <tr>
                                            <td><?php echo $row['nome']; ?></td>
                                            <td><?php echo $row['plataforma']; ?></td> <!-- Adiciona a coluna Plataforma -->
                                            <td><?php echo $row['quantidade']; ?></td>
                                            <td><?php echo 'R$' . $row['price']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    mysqli_close($conexao);
    ?>

    <!-- Inclua aqui os scripts JavaScript necessários -->
    <script src="includes/jquery/dist/jquery.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="includes/sb-admin/js/sb-admin-2.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/font-awesome-all.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap5.min.js"></script>
    <script src="js/jquery.mask.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="js/pt-BR.js"></script>
    <script src="js/jquery.maskMoney.min.js"></script>
    <script src="js/chart.js/chart.umd.js"></script>
    <script src="js/date-eu.js"></script>
</body>
</html>