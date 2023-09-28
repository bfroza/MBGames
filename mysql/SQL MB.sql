CREATE DATABASE MB_Games;

USE MB_Games;

-- -----------------------------------------------------
-- Table Categorias
-- -----------------------------------------------------
CREATE TABLE Categorias (
  idCategorias INT NOT NULL AUTO_INCREMENT,
  categoria VARCHAR(45) NOT NULL,
  PRIMARY KEY (idCategorias));


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
-- Table Jogos
-- -----------------------------------------------------
CREATE TABLE Jogos (
  idJogos INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  desenvolvedor VARCHAR(45) NULL,
  anoLancamento YEAR(4) NULL,
  Categorias_idCategorias INT NOT NULL,
  imagem VARCHAR(255) NULL,
  PRIMARY KEY (idJogos),
  CONSTRAINT fk_Jogos_Categorias1
    FOREIGN KEY (Categorias_idCategorias)
    REFERENCES Categorias (idCategorias)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


INSERT INTO Jogos (nome, desenvolvedor, anoLancamento, Categorias_idCategorias,imagem) VALUES
('Grand Theft Auto V', 'Rockstar North', 2013, 1,"gta.jpg"),
('Assassins Creed Rogue', 'Ubisoft', 2017, 2,"rougue.jfif"),
('The Witcher 3: Wild Hunt', 'CD Projekt', 2015, 3,"thewitcher.jpg"),
('Civilization VI', 'Firaxis Games', 2016, 4,"fifa.jpg"),
('FIFA 22', 'EA Sports', 2021, 5,"fifa22.jpg");


-- -----------------------------------------------------
-- Table Fornecedores
-- -----------------------------------------------------
CREATE TABLE Fornecedores (
  idFornecedores INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(45) NOT NULL,
  linkSite VARCHAR(45) NULL,
  PRIMARY KEY (idFornecedores)
);
  

INSERT INTO Fornecedores (nome, linkSite) VALUES
('Steam', 'https://store.steampowered.com/'),
('Epic Games Store', 'https://www.epicgames.com/store/en-US/'),
('Ubisoft Store', 'https://store.ubi.com/us/');


-- -----------------------------------------------------
-- Table Jogos_Fornecedores
-- -----------------------------------------------------



-- -----------------------------------------------------
-- Table Usuarios
-- -----------------------------------------------------
CREATE TABLE Usuarios (
  idUsuarios INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  username VARCHAR(45) NULL,
  cpf VARCHAR(14) NULL,
  email VARCHAR(100) NULL,
  dataNascimento DATE NULL,
  idade INT NULL,
  senha VARCHAR(45) NULL,
  PRIMARY KEY (idUsuarios)
);


INSERT INTO Usuarios (nome, username, cpf, email, dataNascimento, idade, senha) VALUES
('João Silva', 'joaosilva', '123.456.789-00', 'joao@email.com', '1990-05-15', 33, 'senha123'),
('Maria Santos', 'mariasantos', '987.654.321-00', 'maria@email.com', '1985-12-10', 37, 'senha456'),
('Pedro Oliveira', 'pedroliveira', '111.222.333-44', 'pedro@email.com', '1995-08-20', 28, 'senha789'),
('Ana Pereira', 'anapereira', '555.666.777-88', 'ana@email.com', '1992-03-25', 31, 'senha101'),
('Carlos Rodrigues', 'carlosrodrigues', '999.888.777-66', 'carlos@email.com', '1988-07-05', 35, 'senha202');


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


INSERT INTO Cupons (cupom, desconto, ativo) VALUES
('CUPOM10OFF', 10, 1),
('ULTRASECRET', 100, 1),
('VERAONOVO', 15, 1);


-- -----------------------------------------------------
-- Table Vendas
-- -----------------------------------------------------
CREATE TABLE Vendas (
  idVendas INT NOT NULL AUTO_INCREMENT,
  data DATE NULL DEFAULT NOW(),
  valorTotal DECIMAL(10,2) NULL,
  Cupons_idCupons INT NOT NULL,
  Usuarios_idUsuarios INT NOT NULL,
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
    ON UPDATE NO ACTION
);


-- -----------------------------------------------------
-- Table Chaves
-- -----------------------------------------------------
CREATE TABLE Chaves (
  idChaves INT NOT NULL AUTO_INCREMENT,
  chave VARCHAR(45) NULL,
  estoque TINYINT NOT NULL DEFAULT 1,
  Jogos_Fornecedores_idJogos_Fornecedores INT NOT NULL,
  Vendas_idVendas INT NOT NULL,
  PRIMARY KEY (idChaves),
  CONSTRAINT fk_Chaves_Jogos_Fornecedores1
    FOREIGN KEY (Jogos_Fornecedores_idJogos_Fornecedores)
    REFERENCES Jogos_Fornecedores (idJogos_Fornecedores)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_Chaves_Vendas1
    FOREIGN KEY (Vendas_idVendas)
    REFERENCES Vendas (idVendas)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);




-- VIEWS


CREATE VIEW ViewJogosDetalhados
SELECT
    Jogos.idJogos,
    Jogos.nome,
    Jogos.desenvolvedor,
    Jogos.anoLancamento,
    Categorias.categoria,
    Fornecedores.nome,
    Jogos_Fornecedores.valor,
    Jogos_Fornecedores.imagem,
    Categorias.idCategorias,
    Fornecedores.idFornecedores,
    Categorias.idCategorias,
    Jogos_Fornecedores.idJogos_Fornecedores,
    Categorias.idCategorias,
    Categorias.idCategorias
FROM
    Jogos
JOIN
    Categorias ON Jogos.Categorias_idCategorias = Categorias.idCategorias
JOIN
    Jogos_Fornecedores ON Jogos.idJogos = Jogos_Fornecedores.Jogos_idJogos
JOIN
    Fornecedores ON Jogos_Fornecedores.Fornecedores_idFornecedores = Fornecedores.idFornecedores
JOIN
    Chaves ON Jogos_Fornecedores.idJogos_Fornecedores = Chaves.Jogos_Fornecedores_idJogos_Fornecedores;
