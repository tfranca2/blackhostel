# Host: localhost  (Version: 5.6.25)
# Date: 2015-11-02 14:24:40
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES latin1 */;

#
# Structure for table "caixa"
#

CREATE TABLE `caixa` (
  `id_caixa` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `operacao` int(2) NOT NULL,
  `observacao` varchar(200) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "caixa"
#

INSERT INTO `caixa` VALUES (1,5.15,1,'dsjlfkasjdkf',1,'2015-10-27 09:14:56'),(2,5.10,1,'asdasd',1,'2015-10-28 09:16:52'),(3,1561.11,1,'asdasd',1,'2015-10-28 09:19:56'),(4,5500000.00,2,'asdasdasd',1,'2015-10-28 09:23:48'),(0,2423.42,1,'',1,'2015-10-30 22:23:06'),(0,6666666.66,2,'',1,'2015-10-30 23:46:51');

#
# Structure for table "cliente"
#

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `rg` varchar(20) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "cliente"
#

INSERT INTO `cliente` VALUES (1,'Neto Fontenele','11122233375','12343456785');

#
# Structure for table "item"
#

CREATE TABLE `item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

#
# Data for table "item"
#

INSERT INTO `item` VALUES (1,'Ar-Condicionado',20.00),(2,'Frigobar',15.00),(17,'Cama Redonda',25.00),(18,'Espelho De Teto',23.00);

#
# Structure for table "perfil"
#

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco_base` decimal(10,2) NOT NULL,
  `tp_modo_reserva` int(2) NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

#
# Data for table "perfil"
#

INSERT INTO `perfil` VALUES (1,'Suite Master',80.01,1),(2,'Suite Premium',200.00,2),(3,'Suite Gold',0.00,1);

#
# Structure for table "perfil_item"
#

CREATE TABLE `perfil_item` (
  `id_perfil` int(11) NOT NULL,
  `id_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "perfil_item"
#

INSERT INTO `perfil_item` VALUES (2,1),(2,17),(2,18),(2,2),(1,1),(1,18),(3,17),(3,18),(3,2);

#
# Structure for table "perfil_preco"
#

CREATE TABLE `perfil_preco` (
  `id_perfil_perco` int(11) NOT NULL AUTO_INCREMENT,
  `id_perfil` int(11) DEFAULT NULL,
  `qt_pessoas` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_perfil_perco`),
  UNIQUE KEY `unique` (`id_perfil`,`qt_pessoas`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

#
# Data for table "perfil_preco"
#

INSERT INTO `perfil_preco` VALUES (57,1,2,80.00),(58,1,1,50.00),(59,1,3,100.00),(61,3,1,70.00),(62,3,2,110.00);

#
# Structure for table "produto"
#

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `produto` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# Data for table "produto"
#

INSERT INTO `produto` VALUES (1,'Coca Cola - Latinha 200ml',1.85),(2,'Faria D\'água',30.00);

#
# Structure for table "quarto"
#

CREATE TABLE `quarto` (
  `id_quarto` int(10) NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `id_perfil` int(10) NOT NULL,
  PRIMARY KEY (`id_quarto`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

#
# Data for table "quarto"
#

INSERT INTO `quarto` VALUES (2,'2','Quarto Tal',1),(3,'3','Quarto Branco',2),(5,'69','Quarto Preto',2),(6,'12','Quarto Azul',3);

#
# Structure for table "reserva"
#

CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `id_quarto` int(11) NOT NULL,
  `id_situacao` int(11) NOT NULL,
  `id_cliente` int(99) NOT NULL,
  `entrada` datetime NOT NULL,
  `saida` datetime DEFAULT NULL,
  `qt_pessoas` int(11) NOT NULL,
  PRIMARY KEY (`id_reserva`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

#
# Data for table "reserva"
#

INSERT INTO `reserva` VALUES (1,2,1,1,'2015-10-31 14:27:00','2015-11-01 14:27:00',2),(2,6,2,1,'2015-10-31 15:29:00','2015-11-01 00:00:00',2),(9,2,2,0,'2015-11-01 00:00:00','2015-11-07 00:00:00',0),(10,2,2,0,'2015-10-29 00:00:00','2015-11-04 00:00:00',0),(11,2,2,2,'2015-10-28 12:36:00','2015-10-29 12:36:00',0),(12,1,2,1,'2015-01-01 00:00:00','2015-01-14 00:00:00',0),(13,2,2,0,'2015-01-02 00:00:00','2015-01-07 00:00:00',0),(14,2,2,0,'2015-02-02 00:00:00','2015-02-07 00:00:00',0),(15,2,2,0,'2015-03-02 00:00:00','2015-03-07 00:00:00',0),(16,2,2,0,'2015-04-02 00:00:00','2015-04-07 00:00:00',0),(17,2,2,0,'2015-05-02 00:00:00','2015-05-07 00:00:00',0),(19,2,2,0,'2015-07-02 00:00:00','2015-07-07 00:00:00',0),(20,2,2,0,'2015-08-02 00:00:00','2015-08-07 00:00:00',0),(21,2,2,0,'2015-09-02 00:00:00','2015-09-07 00:00:00',0),(22,2,2,0,'2015-10-02 00:00:00','2015-10-07 00:00:00',0),(23,2,2,0,'2015-11-02 00:00:00','2015-11-07 00:00:00',0),(24,2,2,0,'2015-12-02 00:00:00','2015-12-07 00:00:00',0),(25,2,2,0,'2015-01-02 00:00:00','2015-01-07 00:00:00',0),(26,3,2,0,'2015-01-02 00:00:00','2015-01-07 00:00:00',0),(27,3,2,0,'2015-02-02 00:00:00','2015-02-07 00:00:00',0),(28,3,2,0,'2015-03-02 00:00:00','2015-03-07 00:00:00',0),(29,3,2,0,'2015-04-02 00:00:00','2015-04-07 00:00:00',0),(30,3,2,0,'2015-05-02 00:00:00','2015-05-07 00:00:00',0),(32,3,2,0,'2015-07-02 00:00:00','2015-07-07 00:00:00',0),(33,3,2,0,'2015-08-02 00:00:00','2015-08-07 00:00:00',0),(34,3,2,0,'2015-09-02 00:00:00','2015-09-07 00:00:00',0),(35,3,2,0,'2015-10-02 00:00:00','2015-10-07 00:00:00',0),(36,3,2,0,'2015-11-02 00:00:00','2015-11-07 00:00:00',0),(37,3,2,0,'2015-12-02 00:00:00','2015-12-07 00:00:00',0),(38,3,2,0,'2015-01-02 00:00:00','2015-01-07 00:00:00',0),(39,3,2,0,'2015-02-02 00:00:00','2015-02-07 00:00:00',0),(40,3,2,0,'2015-03-02 00:00:00','2015-03-07 00:00:00',0),(41,3,2,0,'2015-04-02 00:00:00','2015-04-07 00:00:00',0),(42,3,2,0,'2015-05-02 00:00:00','2015-05-07 00:00:00',0),(44,3,2,0,'2015-07-02 00:00:00','2015-07-07 00:00:00',0),(45,3,2,0,'2015-08-02 00:00:00','2015-08-07 00:00:00',0),(46,3,2,0,'2015-09-02 00:00:00','2015-09-07 00:00:00',0),(47,3,2,0,'2015-10-02 00:00:00','2015-10-07 00:00:00',0),(48,3,2,0,'2015-11-02 00:00:00','2015-11-07 00:00:00',0),(49,3,2,0,'2015-12-02 00:00:00','2015-12-07 00:00:00',0),(52,3,2,0,'2015-04-02 00:00:00','2015-04-07 00:00:00',0),(53,3,2,0,'2015-04-02 00:00:00','2015-04-07 00:00:00',0),(54,3,2,0,'2015-02-02 00:00:00','2015-02-07 00:00:00',0),(55,3,2,0,'2015-09-02 00:00:00','2015-09-07 00:00:00',0),(56,3,2,0,'2015-09-02 00:00:00','2015-09-07 00:00:00',0),(57,3,2,0,'2015-09-02 00:00:00','2015-09-07 00:00:00',0),(58,3,2,0,'2015-09-02 00:00:00','2015-09-07 00:00:00',0),(59,3,2,0,'2015-09-02 00:00:00','2015-09-07 00:00:00',0),(60,3,2,0,'2015-11-02 00:00:00','2015-11-07 00:00:00',0),(61,3,2,0,'2015-11-02 00:00:00','2015-11-07 00:00:00',0),(62,3,2,0,'2015-11-02 00:00:00','2015-11-07 00:00:00',0),(63,3,2,0,'2015-11-02 00:00:00','2015-11-07 00:00:00',0),(64,3,2,0,'2015-11-02 00:00:00','2015-11-07 00:00:00',0),(65,3,2,0,'2015-11-02 00:00:00','2015-11-07 00:00:00',0),(66,2,2,0,'2015-02-02 00:00:00','2015-02-07 00:00:00',0),(67,2,2,0,'2015-02-02 00:00:00','2015-02-07 00:00:00',0),(68,2,2,0,'2015-02-02 00:00:00','2015-02-07 00:00:00',0),(69,2,2,0,'2015-02-02 00:00:00','2015-02-07 00:00:00',0),(70,2,2,0,'2015-05-02 00:00:00','2015-05-07 00:00:00',0),(71,2,2,0,'2015-05-02 00:00:00','2015-05-07 00:00:00',0),(72,2,2,0,'2015-05-02 00:00:00','2015-05-07 00:00:00',0),(73,3,2,0,'2015-07-02 00:00:00','2015-07-07 00:00:00',0),(74,3,2,0,'2015-07-02 00:00:00','2015-07-07 00:00:00',0),(75,3,2,0,'2015-07-02 00:00:00','2015-07-07 00:00:00',0),(76,3,2,0,'2015-07-02 00:00:00','2015-07-07 00:00:00',0),(77,2,2,0,'2015-08-02 00:00:00','2015-08-07 00:00:00',0),(78,2,2,0,'2015-08-02 00:00:00','2015-08-07 00:00:00',0),(79,2,2,0,'2015-08-02 00:00:00','2015-08-07 00:00:00',0),(80,2,2,0,'2015-08-02 00:00:00','2015-08-07 00:00:00',0),(81,2,2,0,'2015-08-02 00:00:00','2015-08-07 00:00:00',0),(82,2,1,1,'2015-08-02 00:00:00','2015-08-07 00:00:00',6),(83,6,6,1,'2015-10-30 13:18:00','2015-11-04 00:00:00',6);

#
# Structure for table "reserva_produto"
#

CREATE TABLE `reserva_produto` (
  `id_reserva_produto` int(11) NOT NULL AUTO_INCREMENT,
  `id_reserva` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `ativo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_reserva_produto`),
  KEY `id_reserva` (`id_reserva`),
  KEY `id_produto` (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

#
# Data for table "reserva_produto"
#

INSERT INTO `reserva_produto` VALUES (1,1,1,0),(2,1,0,1),(3,1,1,0),(4,1,1,0),(5,1,1,0),(6,1,1,0),(7,1,1,0),(8,1,1,0),(9,1,2,0),(10,1,1,0),(11,1,2,0),(12,1,2,0),(13,1,1,0),(14,1,2,0),(15,1,2,1),(16,82,2,1);

#
# Structure for table "situacao"
#

CREATE TABLE `situacao` (
  `id_situacao` int(11) NOT NULL AUTO_INCREMENT,
  `situacao` varchar(100) NOT NULL,
  PRIMARY KEY (`id_situacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "situacao"
#


#
# Structure for table "usuario"
#

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "usuario"
#

INSERT INTO `usuario` VALUES (1,'Jocélio','jocelio','200820e3227815ed1756a6b531e7e0d2');
