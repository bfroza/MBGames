-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Set-2023 às 13:37
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
-- Banco de dados: `mb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `tipo_de_jogo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria_has_jogos`
--

CREATE TABLE `categoria_has_jogos` (
  `categoria_id` int(11) NOT NULL,
  `jogos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cnpj` varchar(45) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogos`
--

CREATE TABLE `jogos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `plataforma` varchar(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `jogos`
--

INSERT INTO `jogos` (`id`, `nome`, `plataforma`, `price`, `quantidade`, `img`) VALUES
(1, 'Rocket League', 'PC', 210.00, 4, 'transferir (1).jfif'),
(2, 'Rocket League', 'PlayStation', 230.00, 4, 'transferir (1).jfif'),
(3, 'Assassin\'s Creed Rougue', 'PC', 211.00, 17, 'rogue.jfif'),
(4, 'Assassin\'s Creed Valhalla', 'PlayStation', 70.00, 1, 'AC_Valhalla_capa.webp'),
(5, 'Red Dead', 'Xbox', 222.00, 1, 'red.jpg'),
(6, 'Bruno Roberto Bombieri Froza', 'PC', 66.00, 3, 'transferir.jfif');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogos_has_vendas`
--

CREATE TABLE `jogos_has_vendas` (
  `jogos_id` int(11) NOT NULL,
  `vendas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `plataforma_jogos`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `plataforma_jogos` (
`nome` varchar(100)
,`quantidade` int(11)
,`plataforma` varchar(11)
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `data_nascimento` date NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `user`, `email`, `cpf`, `cep`, `data_nascimento`, `senha`) VALUES
(1, 'Bruno Roberto Bombieri Froza', 'bfroza', 'brunorbfroza@gmail.com', '032.755.860-17', '99712200', '2004-01-02', 'bruno'),
(2, 'Emanuel', 'uel', '032758@aluno.uricer.edu.br', '777.232.123-91', '99712200', '2004-02-22', '12345');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `preco_total` decimal(10,2) NOT NULL,
  `data` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `visu_fornecedor`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `visu_fornecedor` (
`id` int(11)
,`name` varchar(255)
,`cnpj` varchar(45)
,`telefone` varchar(45)
,`email` varchar(45)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `visu_jogos`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `visu_jogos` (
`nome` varchar(100)
,`plataforma` varchar(20)
,`price` decimal(10,2)
,`quantidade` int(11)
,`img` varchar(255)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `visu_usuario`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `visu_usuario` (
`nome` varchar(255)
,`user` varchar(255)
,`cpf` varchar(15)
,`cep` varchar(8)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `visu_vendas_totais`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `visu_vendas_totais` (
`jogos_id` int(11)
,`vendas_id` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura para vista `plataforma_jogos`
--
DROP TABLE IF EXISTS `plataforma_jogos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `plataforma_jogos`  AS SELECT `jogos`.`nome` AS `nome`, `jogos`.`quantidade` AS `quantidade`, 'PC' AS `plataforma` FROM `jogos` WHERE `jogos`.`plataforma` = 'PC' AND `jogos`.`quantidade` > 0unionselect `jogos`.`nome` AS `nome`,`jogos`.`quantidade` AS `quantidade`,'PlayStation' AS `plataforma` from `jogos` where `jogos`.`plataforma` = 'PlayStation' and `jogos`.`quantidade` > 0 union select `jogos`.`nome` AS `nome`,`jogos`.`quantidade` AS `quantidade`,'Xbox' AS `plataforma` from `jogos` where `jogos`.`plataforma` = 'Xbox' and `jogos`.`quantidade` > 0 order by case `plataforma` when 'PC' then 1 when 'PlayStation' then 2 when 'Xbox' then 3 end,`quantidade` desc  ;

-- --------------------------------------------------------

--
-- Estrutura para vista `visu_fornecedor`
--
DROP TABLE IF EXISTS `visu_fornecedor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visu_fornecedor`  AS SELECT `fornecedor`.`id` AS `id`, `fornecedor`.`name` AS `name`, `fornecedor`.`cnpj` AS `cnpj`, `fornecedor`.`telefone` AS `telefone`, `fornecedor`.`email` AS `email` FROM `fornecedor` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `visu_jogos`
--
DROP TABLE IF EXISTS `visu_jogos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visu_jogos`  AS SELECT `jogos`.`nome` AS `nome`, `jogos`.`plataforma` AS `plataforma`, `jogos`.`price` AS `price`, `jogos`.`quantidade` AS `quantidade`, `jogos`.`img` AS `img` FROM `jogos` ORDER BY `jogos`.`nome` ASC ;

-- --------------------------------------------------------

--
-- Estrutura para vista `visu_usuario`
--
DROP TABLE IF EXISTS `visu_usuario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visu_usuario`  AS SELECT `usuarios`.`nome` AS `nome`, `usuarios`.`user` AS `user`, `usuarios`.`cpf` AS `cpf`, `usuarios`.`cep` AS `cep` FROM `usuarios` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `visu_vendas_totais`
--
DROP TABLE IF EXISTS `visu_vendas_totais`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visu_vendas_totais`  AS SELECT `jogos_has_vendas`.`jogos_id` AS `jogos_id`, `jogos_has_vendas`.`vendas_id` AS `vendas_id` FROM `jogos_has_vendas` ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `categoria_has_jogos`
--
ALTER TABLE `categoria_has_jogos`
  ADD PRIMARY KEY (`categoria_id`,`jogos_id`),
  ADD KEY `fk_categoria_has_jogos_jogos1` (`jogos_id`);

--
-- Índices para tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `jogos`
--
ALTER TABLE `jogos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `jogos_has_vendas`
--
ALTER TABLE `jogos_has_vendas`
  ADD PRIMARY KEY (`jogos_id`,`vendas_id`),
  ADD KEY `fk_jogos_has_vendas_vendas1` (`vendas_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_usuario` (`user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices para tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `jogos`
--
ALTER TABLE `jogos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
