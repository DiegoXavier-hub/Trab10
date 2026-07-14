-- Tabela para armazenar os funcionários do sistema de gestão da clínica médica
-- (projeto da disciplina). Execute este script no phpMyAdmin do infinityfree,
-- na mesma base de dados onde já existem as tabelas aluno e cliente.

CREATE TABLE funcionario
(
   codigo int PRIMARY KEY auto_increment,
   nome varchar(80),
   email varchar(80) UNIQUE,
   senhaHash varchar(255),
   estadoCivil varchar(30),
   dataNascimento date,
   funcao varchar(50)
) ENGINE=InnoDB;
