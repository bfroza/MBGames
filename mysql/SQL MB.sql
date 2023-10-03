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
('Grand Theft Auto V', 'Rockstar North', 2013, 1, 1, 55, 'gta.jfif'),
('Assassins Creed Rogue', 'Ubisoft', 2017, 2, 3, 90, 'rogue.jfif'),
('The Witcher 3: Wild Hunt', 'CD Projekt', 2015, 3, 2, 99, 'thewitcher.jfif'),
('Civilization VI', 'Firaxis Games', 2016, 4, 1, 76.6, 'civ.jpg'),
('FIFA 22', 'EA Sports', 2021, 5, 1, 55.6, 'fifa.jfif');

-- -----------------------------------------------------
-- Table Usuarios
-- -----------------------------------------------------
CREATE TABLE Usuarios (
  idUsuarios INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  user VARCHAR(45) NULL DEFAULT NULL,
  cpf VARCHAR(14) NULL DEFAULT NULL,
  email VARCHAR(100) NULL DEFAULT NULL,
  dataNascimento DATE NULL DEFAULT NULL,
  idade INT NULL DEFAULT NULL,
  senha VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (idUsuarios)
);





-- Inserir valores base na tabela Usuarios
INSERT INTO Usuarios (nome, user, cpf, email, dataNascimento, idade, senha) VALUES
('Bruno Froza', 'bfroza', '03275586017', 'brunorbfroza@gmail.com', '2004-01-02', 19, 'bruno12345'),
('João Silva', 'joaosilva', '12345678900', 'joao@email.com', '1990-05-15', 33, 'senha123'),
('Maria Santos', 'mariasantos', '98765432100', 'maria@email.com', '1985-12-10', 37, 'senha456'),
('Pedro Oliveira', 'pedroliveira', '11122233344', 'pedro@email.com', '1995-08-20', 28, 'senha789'),
('Ana Pereira', 'anapereira', '55566677788', 'ana@email.com', '1992-03-25', 31, 'senha101'),
('Carlos Rodrigues', 'carlosrodrigues', '99988877766', 'carlos@email.com', '1988-07-05', 35, 'senha202'),
('Bruno Froza', 'bfroza', '03275586017', 'brunorbfroza@gmail.com', '2004-02-01', 19, 'bruno12345');


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
('CUPOM', 0, 1),
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
  Fornecedores_idFornecedores INT NOT NULL,
  Jogos_idJogos INT NOT NULL,
  PRIMARY KEY (idChaves),
  CONSTRAINT fk_Chaves_Fornecedores
    FOREIGN KEY (Fornecedores_idFornecedores)
    REFERENCES Fornecedores (idFornecedores)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_Chaves_Jogos1
    FOREIGN KEY (Jogos_idJogos)
    REFERENCES Jogos (idJogos)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

INSERT INTO Chaves (chave, estoque, Fornecedores_idFornecedores, Jogos_idJogos)
VALUES
  ('Chave001', 1, 1, 1),
  ('Chave002', 1, 1, 2),
  ('Chave003', 1, 2, 3),
  ('Chave004', 1, 3, 4),
  ('Chave005', 1, 2, 5);



-- -----------------------------------------------------
-- Table Vendas
-- -----------------------------------------------------
CREATE TABLE Vendas (
  idVendas INT NOT NULL AUTO_INCREMENT,
  data DATE NULL DEFAULT CURRENT_TIMESTAMP,
  valorTotal DECIMAL(10,2) NULL,
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

-- Connta os jogos válidos
CREATE VIEW ContagemChavesValidas AS
SELECT J.idJogos, J.nome AS NomeDoJogo, COUNT(C.idChaves) AS quantidade
FROM Jogos AS J
LEFT JOIN Chaves AS C ON J.idJogos = C.Jogos_idJogos
WHERE C.estoque = 1
GROUP BY J.idJogos, J.nome;


-- View teste 
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

-- View para página index e jogos

CREATE VIEW visu_jogos AS
SELECT
    Jogos.idJogos,
    Jogos.nome,
    Jogos.desenvolvedor,
    Jogos.anoLancamento,
    Categorias.categoria AS NomeCategoria,
    Fornecedores.nome AS NomeFornecedor,
    Jogos.valor,
    Jogos.imagem AS ImagemDoJogo,
    COUNT(Chaves.idChaves) AS Quantidade,
    MAX(Chaves.chave) AS Chave,
    Usuarios.idUsuarios AS IDUsuario,
	Chaves.idChaves AS IDChave

FROM
    Jogos
INNER JOIN
    Categorias ON Jogos.Categorias_idCategorias = Categorias.idCategorias
INNER JOIN
    Fornecedores ON Jogos.Fornecedores_idFornecedores = Fornecedores.idFornecedores
LEFT JOIN
    Chaves ON Jogos.idJogos = Chaves.Jogos_idJogos
LEFT JOIN
    Vendas ON Vendas.Chaves_idChaves = Chaves.idChaves
LEFT JOIN
    Usuarios ON Vendas.Usuarios_idUsuarios = Usuarios.idUsuarios
WHERE
    Chaves.estoque = 1
GROUP BY
    Jogos.nome, Jogos.desenvolvedor, Jogos.anoLancamento, Categorias.categoria, Fornecedores.nome, Jogos.valor, Jogos.imagem, Usuarios.idUsuarios;

CREATE VIEW visu_jogos_atualizavel AS
SELECT * FROM visu_jogos;


-- View para a lista
CREATE VIEW visu_jogos_lista AS
SELECT
    Jogos.idJogos,
    Jogos.nome,
    Jogos.desenvolvedor,
    Jogos.anoLancamento,
    Categorias.categoria AS NomeCategoria,
    Fornecedores.nome AS NomeFornecedor,
    Jogos.valor,
    Jogos.imagem AS ImagemDoJogo,
    COUNT(Chaves.idChaves) AS Quantidade
FROM
    Jogos
INNER JOIN
    Categorias ON Jogos.Categorias_idCategorias = Categorias.idCategorias
INNER JOIN
    Fornecedores ON Jogos.Fornecedores_idFornecedores = Fornecedores.idFornecedores
LEFT JOIN
    Chaves ON Jogos.idJogos = Chaves.Jogos_idJogos
WHERE
    Chaves.estoque = 1
GROUP BY
    Jogos.idJogos, Jogos.nome, Jogos.desenvolvedor, Jogos.anoLancamento, Categorias.categoria, Fornecedores.nome, Jogos.valor, Jogos.imagem
ORDER BY
    Quantidade DESC, Jogos.nome; -- Agora estamos ordenando por Quantidade em ordem decrescente e, em caso de empate, por nome do jogo em ordem alfabética




CREATE VIEW visu_jogos_customizada AS
SELECT
    idJogos,
    nome,
    desenvolvedor,
    anoLancamento,
    NomeCategoria,
    NomeFornecedor,
    valor,
    ImagemDoJogo,
    Quantidade,
    Chave,
    IDUsuario
FROM
    visu_jogos
ORDER BY
    NomeFornecedor ASC,
    Quantidade;


CREATE VIEW ViewChaves AS
SELECT
    c.idChaves,
    c.chave,
    c.estoque,
    c.Fornecedores_idFornecedores,
    c.Jogos_idJogos,
    j.nome AS nomeJogo
FROM
    Chaves AS c
JOIN
    Jogos AS j ON c.Jogos_idJogos = j.idJogos;


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


-- PROCEDUREs
DELIMITER //

CREATE PROCEDURE InserirJogo(
    IN jogo_nome VARCHAR(100),
    IN jogo_desenvolvedor VARCHAR(45),
    IN jogo_anoLancamento YEAR(4),
    IN jogo_categoria_id INT,
    IN jogo_fornecedor_id INT,
    IN jogo_valor DECIMAL(10,2),
    IN jogo_imagem VARCHAR(255)
)
BEGIN
    INSERT INTO Jogos (nome, desenvolvedor, anoLancamento, Categorias_idCategorias, Fornecedores_idFornecedores, valor, imagem)
    VALUES (jogo_nome, jogo_desenvolvedor, jogo_anoLancamento, jogo_categoria_id, jogo_fornecedor_id, jogo_valor, jogo_imagem);
END;
//

DELIMITER ;

DELIMITER //
CREATE PROCEDURE InserirFornecedor(
    IN p_nome VARCHAR(45),
    IN p_linkSite VARCHAR(45)
)
BEGIN
    DECLARE fornecedorExistente INT;
    
    -- Verifica se o fornecedor já existe
    SELECT idFornecedores INTO fornecedorExistente FROM Fornecedores WHERE nome = p_nome LIMIT 1;
    
    IF fornecedorExistente IS NULL THEN
        -- O fornecedor não existe, insere os dados na tabela
        INSERT INTO Fornecedores (nome, linkSite) VALUES (p_nome, p_linkSite);
        SELECT 'Fornecedor cadastrado com sucesso!' AS mensagem;
    ELSE
        -- O fornecedor já existe, retorna uma mensagem de erro
        SELECT 'Este fornecedor já está cadastrado.' AS mensagem;
    END IF;
END //
DELIMITER ;


  DELIMITER //

CREATE PROCEDURE UpdateJogo(
    IN p_idJogo INT,
    IN p_desenvolvedor VARCHAR(45),
    IN p_anoLancamento YEAR(4),
    IN p_categorias_idCategorias INT,
    IN p_fornecedores_idFornecedores INT,
    IN p_valor DECIMAL(10,2),
    IN p_imagem VARCHAR(255)
)
BEGIN
    UPDATE jogos
    SET
        desenvolvedor = p_desenvolvedor,
        anoLancamento = p_anoLancamento,
        Categorias_idCategorias = p_categorias_idCategorias,
        Fornecedores_idFornecedores = p_fornecedores_idFornecedores,
        valor = p_valor,
        imagem = p_imagem
    WHERE idJogos = p_idJogo;
END //

DELIMITER ;




DELIMITER //

CREATE PROCEDURE ExcluirJogo(IN jogoID INT)
BEGIN
    DELETE FROM jogos WHERE idJogos = jogoID;
END //

DELIMITER ;

-- TRIGGER serve para atualizar o num em estoque

DELIMITER //
CREATE TRIGGER AtualizarEstoqueAposVenda
AFTER INSERT ON Vendas
FOR EACH ROW
BEGIN
    DECLARE chave_id INT;
    
    -- Obtenha o ID da chave vendida
    SELECT NEW.Chaves_idChaves INTO chave_id;
    
    -- Atualize o estoque da chave para 0
    UPDATE Chaves
    SET estoque = 0
    WHERE idChaves = chave_id;
END;
//
DELIMITER ;
