-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tempo de Geração: 
-- Versão do Servidor: 5.5.27
-- Versão do PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `blackhostel`
--
CREATE DATABASE `blackhostel` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `blackhostel`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `rg` varchar(25) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `cliente`, `cpf`, `rg`) VALUES
(1, 'Fulano Da Silva', '12345678911', '2000111222333444'),
(2, 'Beltrano Dos Santos', '12345678911', '20085413598');

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`id_item`, `descricao`, `preco`) VALUES
(1, 'Ar Condicionado', 5.00),
(2, 'Ventilador', 3.00),
(3, 'Frigobar', 2.00),
(4, 'Tv A Cabo', 2.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco_base` decimal(10,2) NOT NULL,
  `tp_modo_reserva` int(2) NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `descricao`, `preco_base`, `tp_modo_reserva`) VALUES
(1, 'Master', 10.00, 1),
(2, 'Essencial', 10.00, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil_item`
--

DROP TABLE IF EXISTS `perfil_item`;
CREATE TABLE IF NOT EXISTS `perfil_item` (
  `id_perfil` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  KEY `id_perfil` (`id_perfil`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `perfil_item`
--

INSERT INTO `perfil_item` (`id_perfil`, `id_item`) VALUES
(2, 3),
(2, 4),
(2, 2),
(1, 1),
(1, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `produto` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `codigodebarras` varchar(255) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `produto`, `preco`, `codigodebarras`) VALUES
(1, 'Cocacola', 3.00, ''),
(2, 'Sabonete', 1.50, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `quarto`
--

DROP TABLE IF EXISTS `quarto`;
CREATE TABLE IF NOT EXISTS `quarto` (
  `id_quarto` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(3) NOT NULL DEFAULT '0',
  `descricao` varchar(100) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  PRIMARY KEY (`id_quarto`),
  KEY `id_perfil` (`id_perfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `quarto`
--

INSERT INTO `quarto` (`id_quarto`, `numero`, `descricao`, `id_perfil`) VALUES
(1, 39, 'Inf-hr', 2),
(2, 139, 'Sup-dr', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva`
--

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE IF NOT EXISTS `reserva` (
  `id_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `id_quarto` int(11) NOT NULL,
  `entrada` datetime NOT NULL,
  `saida` datetime DEFAULT NULL,
  `id_situacao` int(11) NOT NULL,
  `qt_pessoas` int(11) NOT NULL,
  PRIMARY KEY (`id_reserva`),
  KEY `id_situacao` (`id_situacao`),
  KEY `id_quarto` (`id_quarto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva_cliente`
--

DROP TABLE IF EXISTS `reserva_cliente`;
CREATE TABLE IF NOT EXISTS `reserva_cliente` (
  `id_reserva` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  KEY `id_reserva` (`id_reserva`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva_produto`
--

DROP TABLE IF EXISTS `reserva_produto`;
CREATE TABLE IF NOT EXISTS `reserva_produto` (
  `id_reserva` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  KEY `id_reserva` (`id_reserva`),
  KEY `id_produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao`
--

DROP TABLE IF EXISTS `situacao`;
CREATE TABLE IF NOT EXISTS `situacao` (
  `id_situacao` int(11) NOT NULL AUTO_INCREMENT,
  `situacao` varchar(100) NOT NULL,
  PRIMARY KEY (`id_situacao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `situacao`
--

INSERT INTO `situacao` (`id_situacao`, `situacao`) VALUES
(1, 'Em Uso'),
(2, 'Reservado'),
(3, 'Livre'),
(4, 'Manuteção');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `login`, `senha`) VALUES
(1, 'Jocélio Lima', 'jocelio@blackhostel.com', '202cb962ac59075b964b07152d234b70'),
(2, 'Tiago França', 'tiago@blackhostel.com', '202cb962ac59075b964b07152d234b70'),
(3, 'Edson Brandão', 'edson@blackhostel.com', '202cb962ac59075b964b07152d234b70');

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `perfil_item`
--
ALTER TABLE `perfil_item`
  ADD CONSTRAINT `perfil_item_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`),
  ADD CONSTRAINT `perfil_item_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`);

--
-- Restrições para a tabela `quarto`
--
ALTER TABLE `quarto`
  ADD CONSTRAINT `quarto_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para a tabela `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`id_quarto`) REFERENCES `quarto` (`id_quarto`),
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id_situacao`);

--
-- Restrições para a tabela `reserva_cliente`
--
ALTER TABLE `reserva_cliente`
  ADD CONSTRAINT `reserva_cliente_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `reserva_cliente_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`);

--
-- Restrições para a tabela `reserva_produto`
--
ALTER TABLE `reserva_produto`
  ADD CONSTRAINT `reserva_produto_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`),
  ADD CONSTRAINT `reserva_produto_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
