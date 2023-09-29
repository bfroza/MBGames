CREATE DATABASE MB_Games;

USE MB_Games;

-- -----------------------------------------------------
-- Table Categorias
-- -----------------------------------------------------
CREATE TABLE Categorias (
  idCategorias INT NOT NULL AUTO_INCREMENT,
  categoria VARCHAR(45) NOT NULL,
  PRIMARY KEY (idCategorias)
);

-- Inserir valores base na tabela Categorias
INSERT INTO Categorias (categoria) VALUES
('Ação'),
('Aventura'),
('RPG'),
('Estratégia'),
('Esporte'),
('Simulação'),
('Quebra-cabeças'),
('Terror'),
('Corrida'),
('Indie');


-- -----------------------------------------------------
-- Table Fornecedores
-- -----------------------------------------------------
CREATE TABLE Fornecedores (
  idFornecedores INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(45) NOT NULL,
  linkSite VARCHAR(45) NULL,
  PRIMARY KEY (idFornecedores)
);
  

-- Inserir valores base na tabela Fornecedores
INSERT INTO Fornecedores (nome, linkSite) VALUES
('Steam', 'https://store.steampowered.com/'),
('Epic Games Store', 'https://www.epicgames.com/store/en-US/'),
('Ubisoft Store', 'https://store.ubi.com/us/');


-- -----------------------------------------------------
-- Table Jogos
-- -----------------------------------------------------
CREATE TABLE Jogos (
  idJogos INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  desenvolvedor VARCHAR(45) NULL DEFAULT NULL,
  anoLancamento YEAR(4) NULL DEFAULT NULL,
  Categorias_idCategorias INT NOT NULL,
  Fornecedores_idFornecedores INT NOT NULL,
  valor DECIMAL(10,2) NULL,
  imagem VARCHAR(255) NULL DEFAULT 'imagem.png',
  PRIMARY KEY (idJogos),
  CONSTRAINT fk_Jogos_Categorias1
    FOREIGN KEY (Categorias_idCategorias)
    REFERENCES Categorias (idCategorias)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_Jogos_Fornecedores1
    FOREIGN KEY (Fornecedores_idFornecedores)
    REFERENCES Fornecedores (idFornecedores)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


-- Inserir valores base na tabela Jogos
INSERT INTO Jogos (nome, desenvolvedor, anoLancamento, Categorias_idCategorias, Fornecedores_idFornecedores, valor, imagem) VALUES
('Grand Theft Auto V', 'Rockstar North', 2013, 1, 1, 55, 'gta.jpg'),
('Assassins Creed Rogue', 'Ubisoft', 2017, 2, 3, 90, 'rougue.jfif'),
('The Witcher 3: Wild Hunt', 'CD Projekt', 2015, 3, 2, 99, 'thewitcher.jfif'),
('Civilization VI', 'Firaxis Games', 2016, 4, 1, 76.6, 'civ.jpg'),
('FIFA 22', 'EA Sports', 2021, 5, 1, 55.6, 'fifa.jfif');

-- -----------------------------------------------------
-- Table Usuarios
-- -----------------------------------------------------
CREATE TABLE Usuarios (
  idUsuarios INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  username VARCHAR(45) NULL DEFAULT NULL,
  cpf VARCHAR(14) NULL DEFAULT NULL,
  email VARCHAR(100) NULL DEFAULT NULL,
  dataNascimento DATE NULL DEFAULT NULL,
  idade INT NULL DEFAULT NULL,
  senha VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (idUsuarios)
);





-- Inserir valores base na tabela Usuarios
INSERT INTO Usuarios (nome, username, cpf, email, dataNascimento, idade, senha) VALUES
('João Silva', 'joaosilva', '12345678900', 'joao@email.com', '1990-05-15', 33, 'senha123'),
('Maria Santos', 'mariasantos', '98765432100', 'maria@email.com', '1985-12-10', 37, 'senha456'),
('Pedro Oliveira', 'pedroliveira', '11122233344', 'pedro@email.com', '1995-08-20', 28, 'senha789'),
('Ana Pereira', 'anapereira', '55566677788', 'ana@email.com', '1992-03-25', 31, 'senha101'),
('Carlos Rodrigues', 'carlosrodrigues', '99988877766', 'carlos@email.com', '1988-07-05', 35, 'senha202');


-- -----------------------------------------------------
-- Table Cupons
-- -----------------------------------------------------
CREATE TABLE Cupons (
  idCupons INT NOT NULL AUTO_INCREMENT,
  cupom VARCHAR(45) NULL,
  desconto INT NULL,
  ativo TINYINT NULL DEFAULT 0,
  PRIMARY KEY (idCupons)
);


-- Inserir valores base na tabela Cupons 
INSERT INTO Cupons (cupom, desconto, ativo) VALUES
('CUPOM10OFF', 10, 1),
('ULTRASECRET', 100, 1),
('VERAONOVO', 15, 1);


-- -----------------------------------------------------
-- Table Chaves
-- -----------------------------------------------------
CREATE TABLE Chaves (
  idChaves INT NOT NULL AUTO_INCREMENT,
  chave VARCHAR(45) NULL DEFAULT NULL,
  estoque TINYINT NOT NULL DEFAULT 1,
  Jogos_Fornecedores_idJogos_Fornecedores INT NOT NULL,
  Jogos_idJogos INT NOT NULL,
  PRIMARY KEY (idChaves),
  CONSTRAINT fk_Chaves_Jogos1
    FOREIGN KEY (Jogos_idJogos)
    REFERENCES Jogos (idJogos)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

-- -----------------------------------------------------
-- Table Vendas
-- -----------------------------------------------------
CREATE TABLE Vendas (
  idVendas INT NOT NULL AUTO_INCREMENT,
  data DATE NULL DEFAULT CURRENT_TIMESTAMP(),
  valorTotal DECIMAL(10,2) NULL DEFAULT NULL,
  Cupons_idCupons INT NOT NULL,
  Usuarios_idUsuarios INT NOT NULL,
  Chaves_idChaves INT NOT NULL,
  PRIMARY KEY (idVendas),
  CONSTRAINT fk_Vendas_Cupons1
    FOREIGN KEY (Cupons_idCupons)
    REFERENCES Cupons (idCupons)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_Vendas_Usuarios1
    FOREIGN KEY (Usuarios_idUsuarios)
    REFERENCES Usuarios (idUsuarios)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_Vendas_Chaves1
    FOREIGN KEY (Chaves_idChaves)
    REFERENCES Chaves (idChaves)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);




-- VIEWS


CREATE VIEW Jogos_Categorias_View AS
SELECT
    J.idJogos,
    J.nome AS nome_do_jogo,
    J.desenvolvedor,
    J.anoLancamento,
    C.idCategorias,
    C.categoria AS nome_da_categoria,
    J.valor,
    J.imagem
FROM
    Jogos AS J
INNER JOIN
    Categorias AS C
ON
    J.Categorias_idCategorias = C.idCategorias;
