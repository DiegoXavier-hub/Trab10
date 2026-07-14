<?php

// Carrega a função mysqlConnect() e abre a conexão PDO com o banco MySQL
// configurado em conexaoMysql.php
require "../conexaoMysql.php";
$pdo = mysqlConnect();

try {
  // Monta a instrução SQL que busca nome e telefone de todos os registros
  // da tabela aluno. Como não há nenhum dado vindo do usuário aqui, não é
  // necessário usar prepared statements: query() executa a consulta direto.
  $sql = <<<SQL
    SELECT nome, telefone
    FROM aluno
  SQL;

  // $stmt guarda o resultado da consulta; suas linhas são percorridas
  // mais abaixo, dentro do HTML, com fetch()
  $stmt = $pdo->query($sql);
}
catch (Exception $e) {
  // Interrompe a execução e mostra a mensagem de erro caso a consulta falhe
  // (ex.: tabela inexistente ou falha de conexão)
  exit('Ocorreu uma falha: ' . $e->getMessage());
}

?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <!-- 1: Tag de responsividade -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hello World - Listagem de Dados em Tabela do MySQL</title>

  <!-- 2: Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <h1>Dados na tabela <b>aluno</b></h1>
    <table class="table table-striped table-hover">
      <tr>
        <th>Nome</th>
        <th>Telefone</th>
      </tr>
      <?php
      // fetch() devolve uma linha por vez (como array associativo) até
      // acabarem os registros, quando passa a retornar false e o laço para
      while ($row = $stmt->fetch())
      {
        // htmlspecialchars evita que dados vindos do banco sejam
        // interpretados como HTML/JavaScript ao serem inseridos na página
        $nome = htmlspecialchars($row['nome']);
        $telefone = htmlspecialchars($row['telefone']);

        echo <<<HTML
        <tr>
          <td>$nome</td> 
          <td>$telefone</td>
        </tr>      
        HTML;
      }
      ?>
    </table>
    <a href="../index.html">Menu de opções</a>
  </div>

</body>

</html>