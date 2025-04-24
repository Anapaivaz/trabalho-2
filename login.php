<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap">
  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
  <form class="form-signin" action="logar.php" method="POST">
    <div class="card">
      <div class="card-body">
        <div class="text-center mb-4">
          <div class="brand-wrapper">
            <img class="mb-4" src="user.jpg" alt="" width="72" height="72">
            <div class="brand-title">LuA Empresarial</div>
          </div>
          <h1 class="h3 mb-3 font-weight-normal">Acesso ao Sistema</h1>
          <p>Seja bem-vindo!</p>
        </div>

        <div class="form-label-group">
          <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
          <label for="inputEmail">Email</label>
        </div>

        <div class="form-label-group">
          <input type="password" name="senha" id="inputPassword" class="form-control" placeholder="Senha" required>
          <label for="inputPassword">Senha</label>
        </div>

        <div class="btn1">
          <button class="btn btn-lg btn-primary btn-block" type="submit">Acessar</button>
        </div>

        
        </div>
      </div>
    </div>
  </form>
</body>
</html>
