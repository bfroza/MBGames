-- CRIAÇÃO DO BANCO

CREATE DATABASE mb;

-- CRIAÇÃO TABELAS
USE mb;

CREATE TABLE categoria (
  id INT NOT NULL AUTO_INCREMENT,
  tipo_de_jogo VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

-- Tabela jogos
CREATE TABLE jogos (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  plataforma VARCHAR(45) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  img VARCHAR(255) NULL,
  PRIMARY KEY (id)
);

-- Tabela categoria_has_jogos
CREATE TABLE categoria_has_jogos (
  categoria_id INT NOT NULL,
  jogos_id INT NOT NULL,
  PRIMARY KEY (categoria_id, jogos_id),
  INDEX fk_categoria_has_jogos_jogos1_idx (jogos_id ASC),
  INDEX fk_categoria_has_jogos_categoria_idx (categoria_id ASC),
  CONSTRAINT fk_categoria_has_jogos_categoria
    FOREIGN KEY (categoria_id) REFERENCES categoria (id),
  CONSTRAINT fk_categoria_has_jogos_jogos1
    FOREIGN KEY (jogos_id) REFERENCES jogos (id)
);

-- Tabela usuarios
CREATE TABLE usuarios (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  user VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  cpf VARCHAR(255) NOT NULL,
  cep VARCHAR(45) NOT NULL,
  data_nascimento DATE NOT NULL,
  idade INT,
  senha VARCHAR(45) NOT NULL,
  PRIMARY KEY (id)
);

-- Tabela vendas
CREATE TABLE vendas (
  id INT NOT NULL AUTO_INCREMENT,
  usuarios_id INT NOT NULL,
  preco_total DECIMAL(10,2) NOT NULL,
  data DATE NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (usuarios_id) REFERENCES usuarios (id)
);

-- Tabela itens_venda
CREATE TABLE itens_venda (
  id INT NOT NULL AUTO_INCREMENT,
  vendas_id INT NOT NULL,
  jogos_id INT NOT NULL,
  quantidade INT NOT NULL,
  preco_unitario DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (vendas_id) REFERENCES vendas (id),
  FOREIGN KEY (jogos_id) REFERENCES jogos (id)
);

-- Tabela cupons
CREATE TABLE cupons (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(255),
  estado TINYINT(1) NOT NULL DEFAULT 0, -- Definido como 1 ou 0 para representar verdadeiro ou falso
  desconto DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id) 
);

-- Tabela chaves
CREATE TABLE chaves (
  id INT NOT NULL AUTO_INCREMENT,
  jogo_id INT NOT NULL,
  chave VARCHAR(255) NOT NULL,
  estoque TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  FOREIGN KEY (jogo_id) REFERENCES jogos (id)
);

-- --Tabela Fornecedor
-- CREATE TABLE fornecedor(
--   id INT NOT NULL AUTO_INCREMENT,
--   INT NOT NULL,

-- )


-- ---------------------------------------------------------------------------------------------------------------------------------------------------------

-- CRIAÇÃO VIEWS

-- View visu_plataforma_jogos
CREATE VIEW plataforma_jogos AS
SELECT jogos.nome AS nome, COUNT(chaves.chave) AS quantidade, 'PC' AS plataforma
FROM jogos
INNER JOIN chaves ON chaves.jogo_id = jogos.id
WHERE jogos.plataforma = 'PC'
GROUP BY jogos.nome, jogos.plataforma

UNION

SELECT jogos.nome AS nome, COUNT(chaves.chave) AS quantidade, 'PlayStation' AS plataforma
FROM jogos
INNER JOIN chaves ON chaves.jogo_id = jogos.id
WHERE jogos.plataforma = 'PlayStation'
GROUP BY jogos.nome, jogos.plataforma

UNION

SELECT jogos.nome AS nome, COUNT(chaves.chave) AS quantidade, 'Xbox' AS plataforma
FROM jogos
INNER JOIN chaves ON chaves.jogo_id = jogos.id
WHERE jogos.plataforma = 'Xbox'
GROUP BY jogos.nome, jogos.plataforma

ORDER BY quantidade DESC,
  CASE plataforma
    WHEN 'PC' THEN 1
    WHEN 'PlayStation' THEN 2
    WHEN 'Xbox' THEN 3
  END;


-- View visu_jogos
CREATE VIEW visu_jogos AS
SELECT
    jogos.nome,
    jogos.img,
    jogos.plataforma,
    SUM(IF(chaves.valido = 1, 1, 0)) AS quantidade, -- Sum pega todos os valores da tabela e soma, mas o campo valido deve estar true
    jogos.price
FROM
    jogos
LEFT JOIN chaves ON chaves.jogo_id = jogos.id
GROUP BY
    jogos.nome,
    jogos.img,
    jogos.plataforma,
    jogos.price;



-- View chaves
CREATE VIEW quant_chaves AS
SELECT jogos.id AS jogo_id, jogos.nome AS nome_do_jogo, COUNT(chaves.chave) AS quantidade_de_chaves
FROM jogos
LEFT JOIN chaves ON jogos.id = chaves.jogo_id
GROUP BY jogos.id, jogos.nome;

-- ---------------------------------------------------------------------------------------------------------------------------------------------------------

-- FUNÇÕES

DELIMITER // -- Como o nome diz, serve para organizar melhor a função, caractere delimitador temporário que substitui o ponto e vírgula

CREATE FUNCTION CalcularIdade(data_nascimento DATE)
RETURNS INT
BEGIN
    DECLARE idade INT;
    SET idade = YEAR(CURDATE()) - YEAR(data_nascimento);
    
    IF MONTH(CURDATE()) < MONTH(data_nascimento) OR (MONTH(CURDATE()) = MONTH(data_nascimento) AND DAY(CURDATE()) < DAY(data_nascimento)) THEN
        SET idade = idade - 1;
    END IF;
    
    RETURN idade;
END;

//

DELIMITER ;

-- Evento para atualiza a idade todo o dia
DELIMITER $$
CREATE EVENT atualizar_idade_event
ON SCHEDULE EVERY 1 DAY
DO
BEGIN
    UPDATE pessoas
    SET idade = YEAR(CURDATE()) - YEAR(data_nascimento);
    
    /* Lógica para subtrair 1 da idade se necessário */
    UPDATE pessoas
    SET idade = idade - 1
    WHERE
        MONTH(CURDATE()) < MONTH(data_nascimento)
        OR (MONTH(CURDATE()) = MONTH(data_nascimento) AND DAY(CURDATE()) < DAY(data_nascimento));
END;
$$
DELIMITER ;


-- INSERTS

-- Registros da tabela de categorias
INSERT INTO categoria (tipo_de_jogo)
VALUES
  ('Ação'),
  ('Aventura'),
  ('RPG'),
  ('Esportes'),
  ('Estratégia'),
  ('Tiro em Primeira Pessoa'),
  ('Corrida'),
  ('Luta'),
  ('Simulação'),
  ('Quebra-Cabeças'),
  ('Retro'),
  ('Mundo Aberto'),
  ('Sobrevivência'),
  ('Musical'),
  ('Horror'),
  ('Educativo'),
  ('Casual'),
  ('Arcade'),
  ('Construção'),
  ('História Interativa');

-- Inserir 10 registros de cupons com nomes seguindo o padrão "XXoff" e valores de desconto inteiros de até 20
INSERT INTO cupons (nome, estado, desconto) VALUES
  ('04off', 1, 4),
  ('06off', 1, 6),
  ('08off', 1, 8),
  ('10off', 0, 10),
  ('12off', 0, 12),
  ('14off', 0, 14),
  ('16off', 0, 16),
  ('18off', 0, 18),
  ('20off', 0, 20),
  ('02off', 1, 2);
