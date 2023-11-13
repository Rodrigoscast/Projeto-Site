-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/11/2023 às 00:39
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `baldochi_acessorios`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `destaques`
--

CREATE TABLE `destaques` (
  `id_destaque` int(10) NOT NULL,
  `url_img` varchar(100) NOT NULL,
  `principal` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `destaques`
--

INSERT INTO `destaques` (`id_destaque`, `url_img`, `principal`) VALUES
(36, 'IMG_4424.jpg', 1),
(49, 'IMG_4442.jpg', 0),
(50, 'IMG_4446.jpg', 0),
(51, 'IMG_4447.jpg', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `filtros`
--

CREATE TABLE `filtros` (
  `id_filtro` int(10) NOT NULL,
  `nome_filtro` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filtros`
--

INSERT INTO `filtros` (`id_filtro`, `nome_filtro`) VALUES
(6, 'Colares'),
(7, 'Brincos'),
(8, 'Anéis'),
(9, 'teste1'),
(10, 'teste2'),
(11, 'teste3');

-- --------------------------------------------------------

--
-- Estrutura para tabela `login`
--

CREATE TABLE `login` (
  `idlogin` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `login`
--

INSERT INTO `login` (`idlogin`, `email`, `senha`, `usuario`) VALUES
(1, 'usuario', '1234', 'Hash Techie');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `idproduto` int(10) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `etiqueta` int(10) NOT NULL,
  `descricao` varchar(3000) NOT NULL,
  `valor` varchar(50) NOT NULL,
  `url_main` varchar(100) NOT NULL,
  `vendidos` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`idproduto`, `titulo`, `etiqueta`, `descricao`, `valor`, `url_main`, `vendidos`) VALUES
(1, 'Teste de produto', 8, 'Teste de produto', ' 1200.00', 'IMG_4431.jpg', 0),
(2, 'anel teste', 8, 'anel que eu estou criando para fazer um teste', '120.00', 'IMG_4433.jpg', 0),
(3, 'Colar teste', 6, 'Colar criado apenas para testes', '500.00', 'IMG_4533.jpg', 0),
(4, 'Pulseira Muito boa eu gosto dela', 9, 'Essa pulseira é boa\r\neu gosto dela', '600.00', 'IMG_4838.jpg', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `destaques`
--
ALTER TABLE `destaques`
  ADD PRIMARY KEY (`id_destaque`);

--
-- Índices de tabela `filtros`
--
ALTER TABLE `filtros`
  ADD PRIMARY KEY (`id_filtro`);

--
-- Índices de tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`idlogin`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`idproduto`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `destaques`
--
ALTER TABLE `destaques`
  MODIFY `id_destaque` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `filtros`
--
ALTER TABLE `filtros`
  MODIFY `id_filtro` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `idlogin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `idproduto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
