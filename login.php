<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="img/user-interface.png" type="image/x-icon">
  <link rel="stylesheet" href="css/login.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script> 
  <script>
    function verificarDuplicacao(campo, valor) {
      if (valor !== "") {
        clearTimeout(requestTimers[campo]);
        requestTimers[campo] = setTimeout(function() {
          $.ajax({
            type: "POST",
            url: "verificar_duplicacao.php",
            data: { campo: campo, valor: valor },
            success: function(response) {
              $("#" + campo + "Warning").text(""); // Limpa mensagem de aviso do campo
              if (response === "existe") {
                $("#" + campo + "Warning").text(""); // Limpa mensagem de usuário não encontrado
              } else {
                $("#" + campo + "Warning").text("Esse usuário não existe no Sistema");
              }
            }
          });
        }, 500);
      }
    }
  </script>
</head>
<body>
  <div class="container">
    <div class="login">
      <h1>Página login</h1>
      <form action="login.php" method="POST" id="form_login">
        <div class="inputs">
          <input type="text" id="user" name="user" placeholder="Seu usuário" required oninput="verificarDuplicacao('user', this.value)">
          <span id="userWarning" style="color: red;"></span>

          <input type="password" id="senha" name="senha" placeholder="Sua senha" required oninput="verificarDuplicacao('senha', this.value)">
          <span id="senhaWarning" style="color: red;"></span>
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
        <a class="s_center" href="criar_conta.html"><h4>Criar conta</h4></a>
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
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $user = trim($_POST['user']);
      $senha = trim($_POST['senha']);

      $sql = "SELECT * FROM usuarios WHERE user = ? AND senha = ?";
      $stmt = mysqli_prepare($conexao, $sql);

    
      mysqli_stmt_bind_param($stmt, "ss", $user, $senha);


      mysqli_stmt_execute($stmt);


      mysqli_stmt_store_result($stmt);
      if (mysqli_stmt_num_rows($stmt) == 1) {
          $loginResult = "success";
          header("Location: index.php");
          $logado = true;
          exit;
      } else {
          $logado = false;
      }

      // Feche a declaração preparada
      mysqli_stmt_close($stmt);
  }
?>

<script>
    console.log(<?php include('conezao.php'); echo'$loginResult' ?>)
</script>