-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--

-- Host: 127.0.0.1
-- Generation Time: 07-Out-2015 às 18:04
-- Versão do servidor: 5.6.25
-- PHP Version: 5.5.27

-- Servidor: localhost
-- Tempo de Geração: Out 07, 2015 as 10:17 AM
-- Versão do Servidor: 5.5.8
-- Versão do PHP: 5.3.5


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
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `rg` varchar(20) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `cliente`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`id_item`, `descricao`, `preco`) VALUES
(1, 'Ar-Condicionado', '20.00'),
(2, 'Frigobar', '15.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco_base` decimal(10,2) NOT NULL,
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil_item`
--

CREATE TABLE IF NOT EXISTS `perfil_item` (
  `id_perfil` int(11) NOT NULL,
  `id_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `perfil_item`
--

INSERT INTO `perfil_item` (`id_perfil`, `id_item`) VALUES
(3, 1),
(3, 2),
(2, 1),
(2, 2),
(1, 1);

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

--
-- Extraindo dados da tabela `quarto`
--

INSERT INTO `quarto` (`id_quarto`, `numero`, `descricao`, `id_perfil`) VALUES
(1, '2', 'Quarto Tal', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `login`, `senha`) VALUES
(1, 'Jocélio', 'jocelio', '200820e3227815ed1756a6b531e7e0d2');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `perfil_item`
--
ALTER TABLE `perfil_item`
  ADD KEY `id_perfil` (`id_perfil`),
  ADD KEY `id_item` (`id_item`);

--
-- Indexes for table `quarto`
--
ALTER TABLE `quarto`
  ADD PRIMARY KEY (`id_quarto`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `quarto`
--
ALTER TABLE `quarto`
  MODIFY `id_quarto` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--
=======

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

