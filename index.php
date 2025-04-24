<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "trabalho");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$msg = "";

if (isset($_POST['registro'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $sit = 1;

    if (strlen($senha) < 8) {
        $msg = "A senha deve conter pelo menos 8 caracteres.";
    } else {
        // Verificar se o e-mail já está cadastrado
        $sql = "SELECT * FROM usuarios WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $msg = "Este e-mail já está registrado.";
        } else {
            // Caso contrário, faz o registro
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (Nome, Email, Senha, Sit) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $nome, $email, $senhaHash, $sit);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $msg = "Erro ao cadastrar usuário.";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans&display=swap">
    <style>
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        body {
          background: linear-gradient(to bottom right, #fce4ec, #e91e63);
          font-family: 'Open Sans', sans-serif;
          min-height: 100vh;
          display: flex;
          justify-content: center;
          align-items: center;
          padding: 20px;
        }

        .card {
          background: linear-gradient(to bottom right, #ec407a, #d81b60);
          border-radius: 20px;
          box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
          width: 100%;
          max-width: 420px;
          padding: 40px 30px;
          color: #fff;
        }

        .card-body {
          display: flex;
          flex-direction: column;
          align-items: center;
        }

        .card-body h1 {
          font-size: 24px;
          margin-bottom: 10px;
        }

        .form-label-group {
          width: 100%;
          margin-bottom: 20px;
        }

        .form-control {
          width: 100%;
          padding: 14px 20px;
          border: none;
          border-radius: 25px;
          font-size: 16px;
          color: #333;
          background: #fff;
          outline: none;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
          display: none;
        }

        .btn1 {
          width: 100%;
        }

        .btn1 button {
          background-color: #c2185b;
          border: none;
          border-radius: 25px;
          padding: 14px;
          width: 100%;
          color: white;
          font-size: 16px;
          font-weight: bold;
          cursor: pointer;
          transition: 0.3s;
        }

        .btn1 button:hover {
          background-color: #ad1457;
        }

        .brand-title {
          font-family: 'Playfair Display', serif;
          font-size: 24px;
          font-weight: 700;
          color: #fff;
          margin-bottom: 20px;
        }

        .login-link {
          margin-top: 15px;
          color: #ffe;
          font-weight: bold;
          text-decoration: none;
        }

        .login-link:hover {
          text-decoration: underline;
        }

        .msg {
          margin-top: 10px;
          font-size: 14px;
          color: #ffebee;
          text-align: center;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-body">
        <div class="brand-title">Cadastro de Usuário</div>
        <form method="POST" action="">
            <div class="form-label-group">
                <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome completo" required>
            </div>
            <div class="form-label-group">
                <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
            </div>
            <div class="form-label-group">
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha (mínimo 8 caracteres)" required minlength="8">
            </div>
            <div class="btn1">
                <button type="submit" name="registro">Cadastrar</button>
            </div>
        </form>
        <a class="login-link" href="login.php">Já tem uma conta? Faça seu login</a>
        <p class="msg"><?php echo $msg; ?></p>
    </div>
</div>

</body>
</html>
