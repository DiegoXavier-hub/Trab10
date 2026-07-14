<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$nome = $_POST["nome"] ?? "";
$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";
$estadoCivil = $_POST["estadoCivil"] ?? "";
$dataNascimento = $_POST["dataNascimento"] ?? "";
$funcao = $_POST["funcao"] ?? "";

// A senha em texto puro nunca é gravada no banco: calculamos um hash
// (com salt embutido) usando o algoritmo padrão do PHP e guardamos só o hash
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {

  // O código do funcionário não é solicitado ao usuário: a coluna
  // "codigo" é auto_increment e o próprio banco gera o valor
  $sql = <<<SQL
  INSERT INTO funcionario (nome, email, senhaHash, estadoCivil, dataNascimento, funcao)
  VALUES (?, ?, ?, ?, ?, ?)
  SQL;

  // Prepared statements: os valores digitados pelo usuário são enviados
  // separados do comando SQL, prevenindo que sejam interpretados como
  // parte da instrução
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$nome, $email, $senhaHash, $estadoCivil, $dataNascimento, $funcao]);

  // Após o cadastro, o usuário é direcionado automaticamente para a
  // página de listagem de dados
  header("location: mostra-funcionarios.php");
  exit();
}
catch (Exception $e) {
  exit('Falha ao cadastrar funcionário: ' . $e->getMessage());
}
