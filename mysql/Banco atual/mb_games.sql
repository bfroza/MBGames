-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Out-2023 às 21:17
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mb_games`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ExcluirJogo` (IN `jogoID` INT)   BEGIN
    DELETE FROM jogos WHERE idJogos = jogoID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InserirFornecedor` (IN `p_nome` VARCHAR(45), IN `p_linkSite` VARCHAR(45))   BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InserirJogo` (IN `jogo_nome` VARCHAR(100), IN `jogo_desenvolvedor` VARCHAR(45), IN `jogo_anoLancamento` YEAR(4), IN `jogo_categoria_id` INT, IN `jogo_fornecedor_id` INT, IN `jogo_valor` DECIMAL(10,2), IN `jogo_imagem` VARCHAR(255))   BEGIN
    INSERT INTO Jogos (nome, desenvolvedor, anoLancamento, Categorias_idCategorias, Fornecedores_idFornecedores, valor, imagem)
    VALUES (jogo_nome, jogo_desenvolvedor, jogo_anoLancamento, jogo_categoria_id, jogo_fornecedor_id, jogo_valor, jogo_imagem);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateJogo` (IN `p_idJogo` INT, IN `p_desenvolvedor` VARCHAR(45), IN `p_anoLancamento` YEAR(4), IN `p_categorias_idCategorias` INT, IN `p_fornecedores_idFornecedores` INT, IN `p_valor` DECIMAL(10,2), IN `p_imagem` VARCHAR(255))   BEGIN
    UPDATE jogos
    SET
        desenvolvedor = p_desenvolvedor,
        anoLancamento = p_anoLancamento,
        Categorias_idCategorias = p_categorias_idCategorias,
        Fornecedores_idFornecedores = p_fornecedores_idFornecedores,
        valor = p_valor,
        imagem = p_imagem
    WHERE idJogos = p_idJogo;
END$$

--
-- Funções
--
CREATE DEFINER=`root`@`localhost` FUNCTION `CalcularIdade` (`data_nascimento` DATE) RETURNS INT(11)  BEGIN
    DECLARE idade INT;
    SET idade = YEAR(CURDATE()) - YEAR(data_nascimento);
    
    IF MONTH(CURDATE()) < MONTH(data_nascimento) OR (MONTH(CURDATE()) = MONTH(data_nascimento) AND DAY(CURDATE()) < DAY(data_nascimento)) THEN
        SET idade = idade - 1;
    END IF;
    
    RETURN idade;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `idCategorias` int(11) NOT NULL,
  `categoria` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`idCategorias`, `categoria`) VALUES
(1, 'Ação'),
(2, 'Aventura'),
(3, 'RPG'),
(4, 'Estratégia'),
(5, 'Esporte'),
(6, 'Simulação'),
(7, 'Quebra-cabeças'),
(8, 'Terror'),
(9, 'Corrida'),
(10, 'Indie');

-- --------------------------------------------------------

--
-- Estrutura da tabela `chaves`
--

CREATE TABLE `chaves` (
  `idChaves` int(11) NOT NULL,
  `chave` varchar(45) DEFAULT NULL,
  `estoque` tinyint(4) NOT NULL DEFAULT 1,
  `Fornecedores_idFornecedores` int(11) NOT NULL,
  `Jogos_idJogos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `chaves`
--

INSERT INTO `chaves` (`idChaves`, `chave`, `estoque`, `Fornecedores_idFornecedores`, `Jogos_idJogos`) VALUES
(12, 'kkkkkkkkkkkkkk', 1, 1, 9),
(13, 'jjjjjjjj', 1, 1, 9),
(14, 'kk', 1, 1, 9),
(15, 'kkkkkkkkk', 1, 2, 3);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `contagemchavesvalidas`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `contagemchavesvalidas` (
`idJogos` int(11)
,`NomeDoJogo` varchar(100)
,`quantidade` bigint(21)
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cupons`
--

CREATE TABLE `cupons` (
  `idCupons` int(11) NOT NULL,
  `cupom` varchar(45) DEFAULT NULL,
  `desconto` int(11) DEFAULT NULL,
  `ativo` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cupons`
--

INSERT INTO `cupons` (`idCupons`, `cupom`, `desconto`, `ativo`) VALUES
(1, 'CUPOM10OFF', 10, 1),
(2, 'ULTRASECRET', 100, 1),
(3, 'VERAONOVO', 15, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `idFornecedores` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `linkSite` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `fornecedores`
--

INSERT INTO `fornecedores` (`idFornecedores`, `nome`, `linkSite`) VALUES
(1, 'Steam', 'https://store.steampowered.com/'),
(2, 'Epic Games Store', 'https://www.epicgames.com/store/en-US/'),
(3, 'Ubisoft Store', 'https://store.ubi.com/us/');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogos`
--

CREATE TABLE `jogos` (
  `idJogos` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `desenvolvedor` varchar(45) DEFAULT NULL,
  `anoLancamento` year(4) DEFAULT NULL,
  `Categorias_idCategorias` int(11) NOT NULL,
  `Fornecedores_idFornecedores` int(11) NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT 'imagem.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `jogos`
--

INSERT INTO `jogos` (`idJogos`, `nome`, `desenvolvedor`, `anoLancamento`, `Categorias_idCategorias`, `Fornecedores_idFornecedores`, `valor`, `imagem`) VALUES
(3, 'The Witcher 3: Wild Hunt', 'CD Projekt', '2015', 3, 2, 99.00, 'thewitcher.jfif'),
(6, 'Rocket League', 'Psyonix', '2015', 9, 1, 95.00, 'fifa.jfif'),
(9, 'Assassin\'s Creed Valhalla', 'Ubisoft Montreal', '2019', 1, 1, 204.00, 'AC_Valhalla_capa.webp');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `jogos_categorias_view`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `jogos_categorias_view` (
`idJogos` int(11)
,`nome_do_jogo` varchar(100)
,`desenvolvedor` varchar(45)
,`anoLancamento` year(4)
,`idCategorias` int(11)
,`nome_da_categoria` varchar(45)
,`valor` decimal(10,2)
,`imagem` varchar(255)
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuarios` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `user` varchar(45) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dataNascimento` date DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`idUsuarios`, `nome`, `user`, `cpf`, `email`, `dataNascimento`, `idade`, `senha`) VALUES
(1, 'João Silva', 'joaosilva', '12345678900', 'joao@email.com', '1990-05-15', 33, 'senha123'),
(2, 'Maria Santos', 'mariasantos', '98765432100', 'maria@email.com', '1985-12-10', 37, 'senha456'),
(3, 'Pedro Oliveira', 'pedroliveira', '11122233344', 'pedro@email.com', '1995-08-20', 28, 'senha789'),
(4, 'Ana Pereira', 'anapereira', '55566677788', 'ana@email.com', '1992-03-25', 31, 'senha101'),
(5, 'Carlos Rodrigues', 'carlosrodrigues', '99988877766', 'carlos@email.com', '1988-07-05', 35, 'senha202'),
(6, 'Bruno Roberto Bombieri Froza', 'bfroza', '032.755.860-17', 'brunorbfroza@gmail.com', '2004-02-02', 19, 'bruno12345');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `idVendas` int(11) NOT NULL,
  `data` date DEFAULT current_timestamp(),
  `valorTotal` decimal(10,2) DEFAULT NULL,
  `Cupons_idCupons` int(11) NOT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Chaves_idChaves` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Acionadores `vendas`
--
DELIMITER $$
CREATE TRIGGER `AtualizarEstoqueAposVenda` AFTER INSERT ON `vendas` FOR EACH ROW BEGIN
    DECLARE chave_id INT;
    
    -- Obtenha o ID da chave vendida
    SELECT NEW.Chaves_idChaves INTO chave_id;
    
    -- Atualize o estoque da chave para 0
    UPDATE Chaves
    SET estoque = 0
    WHERE idChaves = chave_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `visu_jogos`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `visu_jogos` (
`idJogos` int(11)
,`nome` varchar(100)
,`desenvolvedor` varchar(45)
,`anoLancamento` year(4)
,`NomeCategoria` varchar(45)
,`NomeFornecedor` varchar(45)
,`valor` decimal(10,2)
,`ImagemDoJogo` varchar(255)
,`Quantidade` bigint(21)
,`Chave` varchar(45)
,`IDUsuario` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `visu_jogos_customizada`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `visu_jogos_customizada` (
`idJogos` int(11)
,`nome` varchar(100)
,`desenvolvedor` varchar(45)
,`anoLancamento` year(4)
,`NomeCategoria` varchar(45)
,`NomeFornecedor` varchar(45)
,`valor` decimal(10,2)
,`ImagemDoJogo` varchar(255)
,`Quantidade` bigint(21)
,`Chave` varchar(45)
,`IDUsuario` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `visu_jogos_lista`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `visu_jogos_lista` (
`idJogos` int(11)
,`nome` varchar(100)
,`desenvolvedor` varchar(45)
,`anoLancamento` year(4)
,`NomeCategoria` varchar(45)
,`NomeFornecedor` varchar(45)
,`valor` decimal(10,2)
,`ImagemDoJogo` varchar(255)
,`Quantidade` bigint(21)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `visu_jogos_separados`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `visu_jogos_separados` (
`idJogos` int(11)
,`nome` varchar(100)
,`desenvolvedor` varchar(45)
,`anoLancamento` year(4)
,`NomeCategoria` varchar(45)
,`NomeFornecedor` varchar(45)
,`valor` decimal(10,2)
,`ImagemDoJogo` varchar(255)
,`quantidade` bigint(21)
,`Chave` varchar(45)
,`IDUsuario` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura para vista `contagemchavesvalidas`
--
DROP TABLE IF EXISTS `contagemchavesvalidas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `contagemchavesvalidas`  AS SELECT `j`.`idJogos` AS `idJogos`, `j`.`nome` AS `NomeDoJogo`, count(`c`.`idChaves`) AS `quantidade` FROM (`jogos` `j` left join `chaves` `c` on(`j`.`idJogos` = `c`.`Jogos_idJogos`)) WHERE `c`.`estoque` = 1 GROUP BY `j`.`idJogos`, `j`.`nome` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `jogos_categorias_view`
--
DROP TABLE IF EXISTS `jogos_categorias_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jogos_categorias_view`  AS SELECT `j`.`idJogos` AS `idJogos`, `j`.`nome` AS `nome_do_jogo`, `j`.`desenvolvedor` AS `desenvolvedor`, `j`.`anoLancamento` AS `anoLancamento`, `c`.`idCategorias` AS `idCategorias`, `c`.`categoria` AS `nome_da_categoria`, `j`.`valor` AS `valor`, `j`.`imagem` AS `imagem` FROM (`jogos` `j` join `categorias` `c` on(`j`.`Categorias_idCategorias` = `c`.`idCategorias`)) ;

-- --------------------------------------------------------

--
-- Estrutura para vista `visu_jogos`
--
DROP TABLE IF EXISTS `visu_jogos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visu_jogos`  AS SELECT `jogos`.`idJogos` AS `idJogos`, `jogos`.`nome` AS `nome`, `jogos`.`desenvolvedor` AS `desenvolvedor`, `jogos`.`anoLancamento` AS `anoLancamento`, `categorias`.`categoria` AS `NomeCategoria`, `fornecedores`.`nome` AS `NomeFornecedor`, `jogos`.`valor` AS `valor`, `jogos`.`imagem` AS `ImagemDoJogo`, count(`chaves`.`idChaves`) AS `Quantidade`, max(`chaves`.`chave`) AS `Chave`, max(`usuarios`.`idUsuarios`) AS `IDUsuario` FROM (((((`jogos` join `categorias` on(`jogos`.`Categorias_idCategorias` = `categorias`.`idCategorias`)) join `fornecedores` on(`jogos`.`Fornecedores_idFornecedores` = `fornecedores`.`idFornecedores`)) left join `chaves` on(`jogos`.`idJogos` = `chaves`.`Jogos_idJogos`)) left join `vendas` on(`vendas`.`Chaves_idChaves` = `chaves`.`idChaves`)) left join `usuarios` on(`vendas`.`Usuarios_idUsuarios` = `usuarios`.`idUsuarios`)) WHERE `chaves`.`estoque` = 1 GROUP BY `jogos`.`idJogos`, `jogos`.`nome`, `jogos`.`desenvolvedor`, `jogos`.`anoLancamento`, `categorias`.`categoria`, `fornecedores`.`nome`, `jogos`.`valor`, `jogos`.`imagem` ORDER BY `jogos`.`nome` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `visu_jogos_customizada`
--
DROP TABLE IF EXISTS `visu_jogos_customizada`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visu_jogos_customizada`  AS SELECT `visu_jogos`.`idJogos` AS `idJogos`, `visu_jogos`.`nome` AS `nome`, `visu_jogos`.`desenvolvedor` AS `desenvolvedor`, `visu_jogos`.`anoLancamento` AS `anoLancamento`, `visu_jogos`.`NomeCategoria` AS `NomeCategoria`, `visu_jogos`.`NomeFornecedor` AS `NomeFornecedor`, `visu_jogos`.`valor` AS `valor`, `visu_jogos`.`ImagemDoJogo` AS `ImagemDoJogo`, `visu_jogos`.`Quantidade` AS `Quantidade`, `visu_jogos`.`Chave` AS `Chave`, `visu_jogos`.`IDUsuario` AS `IDUsuario` FROM `visu_jogos` ORDER BY `visu_jogos`.`NomeFornecedor` ASC, `visu_jogos`.`Quantidade` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `visu_jogos_lista`
--
DROP TABLE IF EXISTS `visu_jogos_lista`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visu_jogos_lista`  AS SELECT `jogos`.`idJogos` AS `idJogos`, `jogos`.`nome` AS `nome`, `jogos`.`desenvolvedor` AS `desenvolvedor`, `jogos`.`anoLancamento` AS `anoLancamento`, `categorias`.`categoria` AS `NomeCategoria`, `fornecedores`.`nome` AS `NomeFornecedor`, `jogos`.`valor` AS `valor`, `jogos`.`imagem` AS `ImagemDoJogo`, count(`chaves`.`idChaves`) AS `Quantidade` FROM (((`jogos` join `categorias` on(`jogos`.`Categorias_idCategorias` = `categorias`.`idCategorias`)) join `fornecedores` on(`jogos`.`Fornecedores_idFornecedores` = `fornecedores`.`idFornecedores`)) left join `chaves` on(`jogos`.`idJogos` = `chaves`.`Jogos_idJogos`)) WHERE `chaves`.`estoque` = 1 GROUP BY `jogos`.`idJogos`, `jogos`.`nome`, `jogos`.`desenvolvedor`, `jogos`.`anoLancamento`, `categorias`.`categoria`, `fornecedores`.`nome`, `jogos`.`valor`, `jogos`.`imagem` ORDER BY count(`chaves`.`idChaves`) DESC, `jogos`.`nome` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `visu_jogos_separados`
--
DROP TABLE IF EXISTS `visu_jogos_separados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visu_jogos_separados`  AS SELECT `visu_jogos`.`idJogos` AS `idJogos`, `visu_jogos`.`nome` AS `nome`, `visu_jogos`.`desenvolvedor` AS `desenvolvedor`, `visu_jogos`.`anoLancamento` AS `anoLancamento`, `visu_jogos`.`NomeCategoria` AS `NomeCategoria`, `visu_jogos`.`NomeFornecedor` AS `NomeFornecedor`, `visu_jogos`.`valor` AS `valor`, `visu_jogos`.`ImagemDoJogo` AS `ImagemDoJogo`, `visu_jogos`.`Quantidade` AS `quantidade`, `visu_jogos`.`Chave` AS `Chave`, `visu_jogos`.`IDUsuario` AS `IDUsuario` FROM `visu_jogos` ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategorias`);

--
-- Índices para tabela `chaves`
--
ALTER TABLE `chaves`
  ADD PRIMARY KEY (`idChaves`),
  ADD KEY `fk_Chaves_Fornecedores` (`Fornecedores_idFornecedores`),
  ADD KEY `fk_Chaves_Jogos1` (`Jogos_idJogos`);

--
-- Índices para tabela `cupons`
--
ALTER TABLE `cupons`
  ADD PRIMARY KEY (`idCupons`);

--
-- Índices para tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`idFornecedores`);

--
-- Índices para tabela `jogos`
--
ALTER TABLE `jogos`
  ADD PRIMARY KEY (`idJogos`),
  ADD KEY `fk_Jogos_Categorias1` (`Categorias_idCategorias`),
  ADD KEY `fk_Jogos_Fornecedores1` (`Fornecedores_idFornecedores`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuarios`);

--
-- Índices para tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`idVendas`),
  ADD KEY `fk_Vendas_Cupons1` (`Cupons_idCupons`),
  ADD KEY `fk_Vendas_Usuarios1` (`Usuarios_idUsuarios`),
  ADD KEY `fk_Vendas_Chaves1` (`Chaves_idChaves`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategorias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `chaves`
--
ALTER TABLE `chaves`
  MODIFY `idChaves` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `cupons`
--
ALTER TABLE `cupons`
  MODIFY `idCupons` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `idFornecedores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `jogos`
--
ALTER TABLE `jogos`
  MODIFY `idJogos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `idVendas` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `chaves`
--
ALTER TABLE `chaves`
  ADD CONSTRAINT `fk_Chaves_Fornecedores` FOREIGN KEY (`Fornecedores_idFornecedores`) REFERENCES `fornecedores` (`idFornecedores`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Chaves_Jogos1` FOREIGN KEY (`Jogos_idJogos`) REFERENCES `jogos` (`idJogos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `jogos`
--
ALTER TABLE `jogos`
  ADD CONSTRAINT `fk_Jogos_Categorias1` FOREIGN KEY (`Categorias_idCategorias`) REFERENCES `categorias` (`idCategorias`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Jogos_Fornecedores1` FOREIGN KEY (`Fornecedores_idFornecedores`) REFERENCES `fornecedores` (`idFornecedores`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `fk_Vendas_Chaves1` FOREIGN KEY (`Chaves_idChaves`) REFERENCES `chaves` (`idChaves`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Vendas_Cupons1` FOREIGN KEY (`Cupons_idCupons`) REFERENCES `cupons` (`idCupons`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Vendas_Usuarios1` FOREIGN KEY (`Usuarios_idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `atualizar_idade_event` ON SCHEDULE EVERY 1 DAY STARTS '2023-10-02 09:34:27' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    UPDATE pessoas
    SET idade = YEAR(CURDATE()) - YEAR(data_nascimento);
    
    /* Lógica para subtrair 1 da idade se necessário */
    UPDATE pessoas
    SET idade = idade - 1
    WHERE
        MONTH(CURDATE()) < MONTH(data_nascimento)
        OR (MONTH(CURDATE()) = MONTH(data_nascimento) AND DAY(CURDATE()) < DAY(data_nascimento));
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
