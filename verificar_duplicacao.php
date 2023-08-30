<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $campo = $_POST['campo'];
    $valor = $_POST['valor'];
    
    $campo = $conexao->real_escape_string($campo); 
    $valor = $conexao->real_escape_string($valor); 

    $query = "SELECT * FROM usuarios WHERE $campo = '$valor'";
    $result = $conexao->query($query);
    
    if ($result->num_rows > 0) {
        echo "existe";
    }
}

$conexao->close();
?>
