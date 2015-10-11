-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
<<<<<<< HEAD
-- Servidor: localhost
-- Tempo de Geração: Out 07, 2015 as 10:17 AM
-- Versão do Servidor: 5.5.8
-- Versão do PHP: 5.3.5
=======
-- Host: 127.0.0.1
-- Generation Time: 10-Out-2015 às 17:49
-- Versão do servidor: 5.6.25
-- PHP Version: 5.5.27
>>>>>>> 05ab5762c4c56c164dcfb0d8a517082c1c7a86fb

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `blackhostel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
<<<<<<< HEAD
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `rg` varchar(20) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `cliente`
--

=======
  `id_cliente` int(11) NOT NULL,
  `cliente` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `rg` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
>>>>>>> 05ab5762c4c56c164dcfb0d8a517082c1c7a86fb

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
<<<<<<< HEAD
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`id_item`, `descricao`, `preco`) VALUES
(1, 'Ar-Condicionado', '20.00'),
(2, 'Frigobar', '15.00');
=======
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
>>>>>>> 05ab5762c4c56c164dcfb0d8a517082c1c7a86fb

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco_base` decimal(10,2) NOT NULL,
<<<<<<< HEAD
  `tp_modo_reserva` int(2) NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `descricao`, `preco_base`, `tp_modo_reserva`) VALUES
(1, 'Suite Master', '80.00', 1),
(2, 'Suite Premium', '200.00', 2),
(3, 'Suite Gold', '25.00', 1);
=======
  `tp_modo_reserva` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
>>>>>>> 05ab5762c4c56c164dcfb0d8a517082c1c7a86fb

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil_item`
--

CREATE TABLE IF NOT EXISTS `perfil_item` (
  `id_perfil` int(11) NOT NULL,
  `id_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE IF NOT EXISTS `produto` (
  `id_produto` int(11) NOT NULL,
  `produto` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE IF NOT EXISTS `produto` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `produto` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `produto`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `quarto`
--

CREATE TABLE IF NOT EXISTS `quarto` (
  `id_quarto` int(10) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `id_perfil` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
<<<<<<< HEAD
=======

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao`
--

CREATE TABLE IF NOT EXISTS `situacao` (
  `id_situacao` int(11) NOT NULL,
  `situacao` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
>>>>>>> 05ab5762c4c56c164dcfb0d8a517082c1c7a86fb

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

<<<<<<< HEAD
-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao`
--

CREATE TABLE IF NOT EXISTS `situacao` (
  `id_situacao` int(11) NOT NULL AUTO_INCREMENT,
  `situacao` varchar(100) NOT NULL,
  PRIMARY KEY (`id_situacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `situacao`
--

=======
--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`);

--
-- Indexes for table `quarto`
--
ALTER TABLE `quarto`
  ADD PRIMARY KEY (`id_quarto`);

--
-- Indexes for table `situacao`
--
ALTER TABLE `situacao`
  ADD PRIMARY KEY (`id_situacao`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `quarto`
--
ALTER TABLE `quarto`
  MODIFY `id_quarto` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `situacao`
--
ALTER TABLE `situacao`
  MODIFY `id_situacao` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
>>>>>>> 05ab5762c4c56c164dcfb0d8a517082c1c7a86fb
