<?php
include "conexao2.php";

// Inserção de produto
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) && $_POST["acao"] === "adicionar") {
  $nome = $_POST["nome"];
  $preco = $_POST["preco"];
  $sql = "INSERT INTO produto (Produto, Preco, Sit) VALUES (?, ?, 1)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sd", $nome, $preco);
  $stmt->execute();
  header("Location: estoque.php");
  exit;
}

// Exclusão de produto
if (isset($_GET["excluir"])) {
  $id = $_GET["excluir"];
  $conn->query("UPDATE produtos SET Sit = 0 WHERE IdProduto = $id");
  header("Location: estoque.php");
  exit;
}

// Consulta produtos
$produtos = $conn->query("SELECT * FROM produtos WHERE Sit = 1 ORDER BY IdProduto DESC");

// Soma total
$total = 0;
$lista_produtos = [];
if ($produtos && $produtos->num_rows > 0) {
  while ($row = $produtos->fetch_assoc()) {
    $lista_produtos[] = $row;
    $total += $row["Preco"];
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>LuA Empresarial - Estoque</title>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background: linear-gradient(to bottom right, #fff, #f8bbd0);
      padding: 40px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .card {
      background: #ffffffcc;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      max-width: 600px;
      width: 100%;
      margin-bottom: 30px;
      padding: 30px;
    }

    h1 {
      font-size: 22px;
      text-align: center;
      margin-bottom: 20px;
      color: #d81b60;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    input[type="text"], input[type="number"] {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }

    button {
      padding: 12px;
      background-color: #d81b60;
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #ad1457;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    li {
      background-color: #fce4ec;
      padding: 12px;
      margin-bottom: 10px;
      border-radius: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .actions a {
      margin-left: 10px;
      text-decoration: none;
      color: #d81b60;
      font-weight: bold;
    }

    .total {
      font-size: 18px;
      font-weight: bold;
      color: #333;
      text-align: center;
      margin-top: 20px;
    }

    .vazio {
      text-align: center;
      color: #666;
      font-style: italic;
    }
  </style>
</head>
<body>

  <div class="card">
    <h1>Cadastro de Produto</h1>
    <form method="post">
      <input type="hidden" name="acao" value="adicionar">
      <input type="text" name="nome" placeholder="Nome do Produto" required>
      <input type="number" name="preco" step="0.01" placeholder="Preço (ex: 19.99)" required>
      <button type="submit">Salvar Produto</button>
    </form>
  </div>

  <div class="card">
    <h1>Produtos Cadastrados</h1>
    <?php if (count($lista_produtos) > 0): ?>
      <ul>
        <?php foreach ($lista_produtos as $produto): ?>
          <li>
            <?= htmlspecialchars($produto["Produto"]) ?> — R$ <?= number_format($produto["Preco"], 2, ',', '.') ?>
            <span class="actions">
              <a href="editar.php?id=<?= $produto["IdProduto"] ?>">Editar</a>
              <a href="?excluir=<?= $produto["IdProduto"] ?>" onclick="return confirm('Excluir este item?')">Excluir</a>
            </span>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="total">Valor total: R$ <?= number_format($total, 2, ',', '.') ?></div>
    <?php else: ?>
      <p class="vazio">Nenhum produto cadastrado ainda.</p>
    <?php endif; ?>
  </div>

</body>
</html>



