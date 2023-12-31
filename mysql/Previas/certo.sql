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
  quantidade INT NOT NULL,
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
  id INT NOT NULL,
  preco_total DECIMAL(10,2) NOT NULL,
  data DATE NOT NULL,
  PRIMARY KEY (id)
);

-- Tabela usuarios_has_vendas
CREATE TABLE usuarios_has_vendas (
  usuarios_id INT NOT NULL,
  vendas_id INT NOT NULL,
  PRIMARY KEY (usuarios_id, vendas_id),
  INDEX fk_usuarios_has_vendas_vendas1_idx (vendas_id ASC),
  INDEX fk_usuarios_has_vendas_usuarios1_idx (usuarios_id ASC),
  CONSTRAINT fk_usuarios_has_vendas_usuarios1
    FOREIGN KEY (usuarios_id) REFERENCES usuarios (id),
  CONSTRAINT fk_usuarios_has_vendas_vendas1
    FOREIGN KEY (vendas_id) REFERENCES vendas (id)
);


-- Tabela cupons 
CREATE TABLE cupons (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(255),
  estado TINYINT(1) NOT NULL DEFAULT 0, -- Definido como 1 ou 0 para representar verdadeiro ou falso
  desconto DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id) 
);





-- ---------------------------------------------------------------------------------------------------------------------------------------------------------

-- CRIAÇÃO VIEWS

-- View visu_plataforma_jogos
CREATE VIEW plataforma_jogos AS
SELECT jogos.nome AS nome, jogos.quantidade AS quantidade, 'PC' AS plataforma
FROM jogos
WHERE jogos.plataforma = 'PC' AND jogos.quantidade > 0
UNION
SELECT jogos.nome AS nome, jogos.quantidade AS quantidade, 'PlayStation' AS plataforma
FROM jogos
WHERE jogos.plataforma = 'PlayStation' AND jogos.quantidade > 0
UNION
SELECT jogos.nome AS nome, jogos.quantidade AS quantidade, 'Xbox' AS plataforma
FROM jogos
WHERE jogos.plataforma = 'Xbox' AND jogos.quantidade > 0
ORDER BY
quantidade DESC,
  CASE plataforma
    WHEN 'PC' THEN 1
    WHEN 'PlayStation' THEN 2
    WHEN 'Xbox' THEN 3
  END;
  



-- View visu_jogos
CREATE VIEW visu_jogos AS
SELECT jogos.nome AS nome, jogos.plataforma AS plataforma, jogos.price AS price, jogos.quantidade AS quantidade, jogos.img AS img 
FROM jogos
ORDER BY jogos.nome ASC;


-- View visu_usuario
CREATE VIEW visu_usuario AS
SELECT usuarios.nome AS nome, usuarios.user AS user, usuarios.cpf AS cpf, usuarios.cep AS cep
FROM usuarios;

-- View visu_vendas_totais

-- View visu_desconto





-- ---------------------------------------------------------------------------------------------------------------------------------------------------------

-- FUNÇÕES

DELIMITER // -- Como  nome diz, serve para organizar melhor a função, caractere delimitador temporário que substitui o ponto e vírgula

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



-- TRIGGER
-- DELIMITER //
-- CREATE TRIGGER valida_quantidade
-- BEFORE INSERT ON jogos
-- FOR EACH ROW
-- BEGIN
--     IF NEW.quantidade <= 0 THEN
--         SIGNAL SQLSTATE '45000'
--         SET MESSAGE_TEXT = 'A quantidade deve ser maior que zero';
--     END IF;
-- END;
-- //
-- DELIMITER ;




-- ---------------------------------------------------------------------------------------------------------------------------------------------------------

-- INSERTS


-- Regitros da tabela de categorias
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
