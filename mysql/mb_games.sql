-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Set-2023 às 21:00
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
  `Vendas_idVendas` int(11) NOT NULL,
  `Jogos_idJogos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'Ubisoft Store', 'https://store.ubi.com/us/'),
(4, 'GOG', 'https://www.gog.com/'),
(5, 'Teste', 'som.com'),
(6, 'Rocket League', 'gggggjh');

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
  `imagem` varchar(255) DEFAULT 'img/imagem.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `jogos`
--

INSERT INTO `jogos` (`idJogos`, `nome`, `desenvolvedor`, `anoLancamento`, `Categorias_idCategorias`, `Fornecedores_idFornecedores`, `valor`, `imagem`) VALUES
(1, 'Grand Theft Auto V', 'Rockstar North', '2013', 1, 1, 55.00, 'gta.jpg'),
(2, 'Assassins Creed Rogue', 'Ubisoft', '2017', 2, 3, 90.00, 'rougue.jfif'),
(3, 'The Witcher 3: Wild Hunt', 'CD Projekt', '2015', 3, 2, 99.00, 'thewitcher.jfif'),
(4, 'Civilization VI', 'Firaxis Games', '2016', 4, 1, 76.60, 'civ.jpg'),
(5, 'FIFA 22', 'EA Sports', '2021', 5, 1, 55.60, 'fifa.jfif'),
(13, 'FAR CRY 3', 'Ubisoft', '2013', 1, 3, 55.00, 'farcry.jffif'),
(14, 'e', 'Psyonix', '2015', 1, 2, 434.00, 'img/'),
(15, 'e', 'Psyonix', '2015', 1, 2, 434.00, 'img/'),
(16, 'Assassin\'s Creed Valhalla', 'Psyonix', '2015', 3, 1, 333.00, 'img/'),
(20, 'Bruno Roberto Bombieri Froza', 'Psyonix', '2015', 1, 1, 99.00, NULL),
(21, 'Assassin\'s Crertge', 'Psyonix', '2015', 3, 1, 3444.00, 'botoes.png'),
(22, 'ee', 'ee', '0000', 3, 2, 33.00, ''),
(23, 'Bruno Roberto Bombieri Froza44', '444', '0000', 1, 1, 44.00, 'imagem.jpg');

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
  `username` varchar(45) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dataNascimento` date DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`idUsuarios`, `nome`, `username`, `cpf`, `email`, `dataNascimento`, `idade`, `senha`) VALUES
(1, 'João Silva', 'joaosilva', '12345678900', 'joao@email.com', '1990-05-15', 33, 'senha123'),
(2, 'Maria Santos', 'mariasantos', '98765432100', 'maria@email.com', '1985-12-10', 37, 'senha456'),
(3, 'Pedro Oliveira', 'pedroliveira', '11122233344', 'pedro@email.com', '1995-08-20', 28, 'senha789'),
(4, 'Ana Pereira', 'anapereira', '55566677788', 'ana@email.com', '1992-03-25', 31, 'senha101'),
(5, 'Carlos Rodrigues', 'carlosrodrigues', '99988877766', 'carlos@email.com', '1988-07-05', 35, 'senha202');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `idVendas` int(11) NOT NULL,
  `data` date DEFAULT current_timestamp(),
  `valorTotal` decimal(10,2) DEFAULT NULL,
  `Cupons_idCupons` int(11) DEFAULT NULL,
  `Usuarios_idUsuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para vista `jogos_categorias_view`
--
DROP TABLE IF EXISTS `jogos_categorias_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jogos_categorias_view`  AS SELECT `j`.`idJogos` AS `idJogos`, `j`.`nome` AS `nome_do_jogo`, `j`.`desenvolvedor` AS `desenvolvedor`, `j`.`anoLancamento` AS `anoLancamento`, `c`.`idCategorias` AS `idCategorias`, `c`.`categoria` AS `nome_da_categoria`, `j`.`valor` AS `valor`, `j`.`imagem` AS `imagem` FROM (`jogos` `j` join `categorias` `c` on(`j`.`Categorias_idCategorias` = `c`.`idCategorias`)) ;

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
  ADD KEY `fk_Chaves_Vendas` (`Vendas_idVendas`),
  ADD KEY `fk_Chaves_Jogos` (`Jogos_idJogos`);

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
  ADD KEY `fk_Vendas_Usuarios1` (`Usuarios_idUsuarios`);

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
  MODIFY `idChaves` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cupons`
--
ALTER TABLE `cupons`
  MODIFY `idCupons` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `idFornecedores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `jogos`
--
ALTER TABLE `jogos`
  MODIFY `idJogos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `fk_Chaves_Jogos` FOREIGN KEY (`Jogos_idJogos`) REFERENCES `jogos` (`idJogos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Chaves_Vendas` FOREIGN KEY (`Vendas_idVendas`) REFERENCES `vendas` (`idVendas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_Vendas_Cupons1` FOREIGN KEY (`Cupons_idCupons`) REFERENCES `cupons` (`idCupons`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Vendas_Usuarios1` FOREIGN KEY (`Usuarios_idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
