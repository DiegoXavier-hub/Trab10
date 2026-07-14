<?php

function mysqlConnect()
{
  // ATENCAO: estes sao valores de exemplo. Antes de subir para o infinityfree,
  // troque pelos dados reais do seu banco (painel MySQL Databases da conta),
  // e NUNCA suba a senha real para um repositorio git publico.
  $db_host = "sql000.infinityfree.com";
  $db_username = "if0_00000000";
  $db_password = "troque-pela-senha-real";
  $db_name = "if0_00000000_trabalho10";

  $options = [
    PDO::ATTR_EMULATE_PREPARES => false, // desativa a execução emulada de prepared statements
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // ativa o lançamento de exceções em casos de erros
  ];

  try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_username, $db_password, $options);
    return $pdo;
  } 
  catch (Exception $e) {
    exit('Ocorreu uma falha na conexão com o MySQL: ' . $e->getMessage());
  }
}

?>
