<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

try {
  $sql = <<<SQL
  SELECT codigo, nome, email, estadoCivil, dataNascimento, funcao
  FROM funcionario
  SQL;

  // Não há parâmetro vindo do usuário nesta consulta, então query() basta
  $stmt = $pdo->query($sql);
}
catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Funcionários Cadastrados</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/portal.css">
</head>

<body>

  <main class="container py-4">
    <h1>Funcionários Cadastrados</h1>
    <table class="table table-striped table-hover">
      <tr>
        <th>Código</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Estado Civil</th>
        <th>Nascimento</th>
        <th>Função</th>
      </tr>
      <?php
      while ($row = $stmt->fetch()) {
        // htmlspecialchars protege a página caso algum dado cadastrado
        // contenha caracteres especiais de HTML
        $codigo = htmlspecialchars($row['codigo']);
        $nome = htmlspecialchars($row['nome']);
        $email = htmlspecialchars($row['email']);
        $estadoCivil = htmlspecialchars($row['estadoCivil']);
        $funcao = htmlspecialchars($row['funcao']);

        $data = new DateTime($row['dataNascimento']);
        $dataFormatoDiaMesAno = $data->format('d-m-Y');

        echo <<<HTML
        <tr>
          <td>$codigo</td>
          <td>$nome</td>
          <td>$email</td>
          <td>$estadoCivil</td>
          <td>$dataFormatoDiaMesAno</td>
          <td>$funcao</td>
        </tr>
        HTML;
      }
      ?>
    </table>
    <a class="btn btn-outline-secondary" href="index.html">Novo cadastro</a>
    <a class="btn btn-outline-secondary" href="../index.html">Menu de opções</a>
  </main>

</body>

</html>
