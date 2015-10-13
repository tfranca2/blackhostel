# Host: localhost  (Version: 5.6.25)
# Date: 2015-10-12 21:11:55
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES latin1 */;

#
# Structure for table "cliente"
#

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `rg` varchar(20) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "item"
#

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

#
# Structure for table "perfil"
#

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco_base` decimal(10,2) NOT NULL,
  `tp_modo_reserva` int(2) NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

#
# Structure for table "perfil_item"
#

DROP TABLE IF EXISTS `perfil_item`;
CREATE TABLE `perfil_item` (
  `id_perfil` int(11) NOT NULL,
  `id_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "produto"
#

DROP TABLE IF EXISTS `produto`;
CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `produto` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Structure for table "quarto"
#

DROP TABLE IF EXISTS `quarto`;
CREATE TABLE `quarto` (
  `id_quarto` int(10) NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `id_perfil` int(10) NOT NULL,
  PRIMARY KEY (`id_quarto`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

#
# Structure for table "reserva"
#

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `id_quarto` int(11) NOT NULL,
  `entrada` datetime NOT NULL,
  `saida` datetime DEFAULT NULL,
  `situacao` int(11) NOT NULL,
  `qt_pessoas` int(11) NOT NULL,
  PRIMARY KEY (`id_reserva`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

#
# Structure for table "situacao"
#

DROP TABLE IF EXISTS `situacao`;
CREATE TABLE `situacao` (
  `id_situacao` int(11) NOT NULL AUTO_INCREMENT,
  `situacao` varchar(100) NOT NULL,
  PRIMARY KEY (`id_situacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for table "usuario"
#

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
