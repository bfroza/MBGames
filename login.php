<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="img/user-interface.png" type="image/x-icon">
  <link rel="stylesheet" href="css/login.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>
<body>
  <div class="container">
    <div class="login">
        <h1>Página login</h1>
        <form action="login.php" method="POST" id="#form_login">
          <div class="inputs">
            <input type="text" id="usuario" name="usuario" placeholder="Seu usuário">
            <span id="userWarning" style="color: red;" ></span>
            <input type="password" id="senha" name="senha" placeholder="Sua senha" required>
            <div class="check">
              <input type="checkbox" name="salvar" id="salvar">
              <h4>Lembrar de mim</h4>
              <div class="esquecer">
                <a href="esquecer.html"><h4>Esqueceu a senha?</h4></a>
              </div>
            </div>
          </div>
          <button class="button" type="submit">Sign In</button>
        </form>
        
        

       
        <div class="center">
            <h4 class="n_center">Não tem uma conta?</h4>
            <a  class="s_center" href="criar_conta.html"> <h4>Criar conta</h4> </a>
        </div>
        <div class="li-icons">
          <ul>
            <li><a href="#"><img src="img/google.png" alt="img google" width="30px" height="30px"></a></li>
            <li><a href="#"><img src="img/facebook.png" alt="img facebook" width="30px" height="30px"></a></li>
            <li><a href="#"><img src="img/instagram.png" alt="img instagram" width="30px" height="30px"></a></li>
            <li><a href="#"><img src="img/logo-steam.png" alt="img logo steam" width="30px" height="30px"></a></li>
          </ul>
        </div>
        
    </div>
  </div>
</body>
</html>


<?php
    include("conexao.php");

    $loginResult = ""; 
    $logado = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = trim($_POST['usuario']);
        $senha = trim($_POST['senha']);

        $sql = "SELECT * FROM usuarios WHERE nome_usuario = '$user' AND senha = '$senha'";
        $result = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($result) == 1){
            $loginResult = "success";
            header("Location: index.php");
            $logado = true;
            exit;
            
        }
        else{
            header("Location: login.php");
            echo ' erro';
            $logado = false;
            exit;



        }
    }
?>




