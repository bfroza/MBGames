<?php
// Conecte-se ao banco de dados
include("conexao.php");

// Execute uma consulta na tabela visu_jogos
$sql = "SELECT nome,Quantidade,NomeFornecedor FROM visu_jogos_customizada";
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
    <link rel="stylesheet" href="css/plataforma-list.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/css1/bootstrap.min.css">
    <link rel="stylesheet" href="css/css1/bs-admin.css">
    <link rel="stylesheet" href="css/css1/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/css1/select2.min.css">
    <link rel="stylesheet" href="css/css1/select2-bootstrap-5-theme.min.css">
    <link rel="stylesheet" href="css/css1/font-awesome-all.min.css">
    <link rel="stylesheet" href="css/listas.css">
    <link rel="shortcut icon" href="img/plataforma.png" type="image/x-icon">
</head>
<body>

    <h1>Lista de jogos por fornecedor</h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <table class="table table-bordered table-hover tabela-relatorio" id="dados">
                                <thead>
                                    <tr>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">Fornecedor</th>
                            
                                
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                      
                                        ?>
                                        <tr>
                                            <td><?php echo $row['nome']; ?></td>
                                            <td><?php echo $row['Quantidade']; ?></td> 
                                            <td><?php echo $row['NomeFornecedor']; ?></td>
                                            
                                            
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
        <button class="button"  id="btnRelatorio">Relatório de Plataforma</button>
    
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

    <script>
document.getElementById("btnRelatorio").addEventListener("click", function() {
    // Clone a tabela com os dados
    var table = document.getElementById("dados").cloneNode(true);

    // Adicione a classe CSS à tabela clonada
    table.classList.add("tabela-relatorio");

    // Crie uma nova janela para o relatório
    var printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.open();

    // Crie o conteúdo HTML da janela de impressão
    printWindow.document.write('<html><head><title>Relatório de Jogos</title>');
    printWindow.document.write('<link rel="stylesheet" type="text/css" href="css/css1/bootstrap.min.css">');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h1>Relatório de Jogos</h1>');
    printWindow.document.write('<style>.tabela-relatorio { width: 100%; } .tabela-relatorio th, .tabela-relatorio td { text-align: left; padding: 5px; }</style>');
    printWindow.document.write('<table>' + table.outerHTML + '</table>');
    printWindow.document.write('</body></html>');

    // Feche o documento da nova janela
    printWindow.document.close();

    // Chame a função de impressão
    printWindow.print();
});
</script>

