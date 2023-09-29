<script src="includes/jquery/dist/jquery.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bs-admin.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" href="css/select2.min.css">
<link rel="stylesheet" href="css/select2-bootstrap-5-theme.min.css">
<link rel="stylesheet" href="css/font-awesome-all.min.css">

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
<link rel="icon" type="image/x-icon" href="images/logo_melb.png">
<meta charset="iso-8859-1">


<?php
date_default_timezone_set('America/Sao_Paulo');
ini_set('date.timezone', 'America/Sao_Paulo');

error_reporting(0);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
include "includes/conect.php";
$id_func = $_SESSION['usuario_id'];

$query = "SELECT * FROM niveis_acesso WHERE id_func = $id_func";

$sql_query_acesso = mysqli_query($conect, $query);
$dados = mysqli_fetch_array($sql_query_acesso)
?>

<style>
  #sidebar a {
    color: #ffffff !important;
  }

  #sidebar .nav-item a:hover {
    color: #ec6ad1 !important;
    text-decoration: none;
  }

  .nav-link {
    font-size: 20px;
  }

  hr {
    margin: 0px 15px 0px 15px;
    color: white;
    font-weight: 200;
    border-top: 1px solid rgba(255, 255, 255, 0.15);

  }

  .nav-title {
    margin: 5px 5px 5px 20px;
    padding: 0px !important;
    color: #E3F4F4 !important;
  }
</style>

<body class="sb-nav-fixed">


  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sidenav-azul" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <a class="navbar-brand d-flex justify-content-center" href="projeto_inicio.php"><img src="images/logo_melb.png" class="login-logo"></a>
            <hr>
            <div class="sb-sidenav-menu-heading nav-title" style="font-size:15px;">Modulos</div>
            <hr>
            
            <hr>
          </div>
        </div>
      </nav>
    </div>






    <div id="layoutSidenav_content">
      <nav class="sb-topnav navbar navbar-expand navbar-azul">


        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 ms-5" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i> </button>
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i><?php print ucfirst($_SESSION['usuario_nome']) ?></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="includes/encerrar_sessao.php">Finalizar</a></li>
            </ul>
          </li>
        </ul>
      </nav>

      <script>
        $(document).ready(function() {
          $('#dados').DataTable({
            "language": {
              "sProcessing": "Processando...",
              "sLengthMenu": "Mostrar _MENU_ registros",
              "sZeroRecords": "Não foram encontrados resultados",
              "sEmptyTable": "Sem dados disponíveis nesta tabela",
              "sInfo": "Mostrando registros de _START_ a _END_ em um total de _TOTAL_ registros",
              "sInfoEmpty": "Mostrando registros de 0 a 0 de um total de 0 registros",
              "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
              "sInfoPostFix": "",
              "sSearch": "Buscar:",
              "sUrl": "",
              "sInfoThousands": ",",
              "sLoadingRecords": "Carregando...",
              "oPaginate": {
                "sFirst": "Primeiro",
                "sLast": "Último",
                "sNext": "Seguinte",
                "sPrevious": "Anterior"
              },
              "oAria": {
                "sSortAscending": ": Ordenar de forma crescente",
                "sSortDescending": ": Ordenar de forma decrescente"
              }
            }
          });




          $('select').select2({
            theme: 'bootstrap-5',
            language: "pt-BR"


          });

          $('#salario_func').maskMoney({
            prefix: 'R$ ',
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            affixesStay: false
          });

          $('#preco_produto').maskMoney({
            prefix: 'R$ ',
            allowNegative: false,
            thousands: '.',
            decimal: ',',
            affixesStay: false
          });
          
        });
      </script>