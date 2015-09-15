-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 15-Set-2015 às 18:51
-- Versão do servidor: 5.6.25
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blackhostel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id_item` int(11) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`id_item`, `descricao`, `preco`) VALUES
(1, 'BLABLALBA', '250.00'),
(2, 'BLABLALBA', '12.00'),
(3, 'BLABLALBA', '250.00'),
(4, 'BLABLALBA', '250.00'),
(5, 'BLABLALBA', '250.00'),
(6, 'Coca Cola', '250.00'),
(7, 'CocaCola Zero', '10.00'),
(8, 'Coca-Cola Zero', '2.00'),
(9, 'Coca-Cola Zero', '2.00'),
(10, 'BLABLALBA', '250.00'),
(11, 'BLABLALBA', '2.00'),
(12, 'BLABLALBA', '250.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
