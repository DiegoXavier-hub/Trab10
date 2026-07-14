<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$nome = $_POST["nome"] ?? "";
$telefone = $_POST["telefone"] ?? "";

/*
// NÃO FAÇA ISSO! Versão original, mantida aqui apenas como registro do problema.
//
// O texto digitado pelo usuário ($telefone) é colado diretamente dentro do
// texto do comando SQL, entre aspas simples. O banco de dados não sabe
// distinguir "isto é só um valor de texto" de "isto faz parte do comando":
// ele apenas lê a string final e a interpreta inteira como instrução SQL.
//
// Isso significa que, se o valor digitado contiver uma aspa simples seguida
// de outro comando (por exemplo terminando o INSERT e começando um DELETE),
// o banco executa exatamente o que foi montado, incluindo a parte extra que
// o usuário acrescentou. Ou seja, quem preenche o formulário passa a
// controlar, em parte, o que o servidor manda o banco fazer — não apenas
// qual valor gravar, mas qual comando rodar.
try {

  $sql = <<<SQL
  INSERT INTO aluno (nome, telefone)
  VALUES ('$nome', '$telefone');
  SQL;

  // Experimente fazer o cadastro de um novo aluno preenchendo
  // o campo telefone utilizando o texto disponibilizado pelo professor
  // nos slides de aula
  $pdo->exec($sql);
  header("location: mostra-alunos.php");
  exit();
}
catch (Exception $e) {
  exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}
*/

try {

  // Versão corrigida: em vez de colar o valor recebido dentro do texto do
  // comando, usamos "?" como marcador de posição. O comando SQL é enviado
  // ao banco separado dos valores (prepare), e só depois os valores são
  // enviados e associados aos marcadores (execute). Dessa forma, o banco
  // sempre trata $nome e $telefone como dado puro, nunca como parte do
  // comando, não importa o que o usuário tenha digitado.
  $sql = <<<SQL
  INSERT INTO aluno (nome, telefone)
  VALUES (?, ?)
  SQL;

  $stmt = $pdo->prepare($sql);
  $stmt->execute([$nome, $telefone]);

  header("location: mostra-alunos.php");
  exit();
}
catch (Exception $e) {
  exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}
