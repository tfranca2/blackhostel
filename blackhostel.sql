--
-- Banco de Dados: `blackhostel`
--

-- --------------------------------------------------------

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `rg` varchar(20) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cliente` (`id_cliente`, `cliente`, `cpf`, `rg`) VALUES
(1, 'Fulano Da Silva', '12345678911', '2000111222333444'),
(2, 'Beltrano Dos Santos', '12345678911', '20085413598');


DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `item` (`id_item`, `descricao`, `preco`) VALUES
(1, 'Ar Condicionado', 5.00),
(2, 'Ventilador', 3.00),
(3, 'Frigobar', 2.00),
(4, 'Tv A Cabo', 2.00);


DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(200) NOT NULL,
  `preco_base` decimal(10,2) NOT NULL,
  `tp_modo_reserva` int(2) NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO `perfil` (`id_perfil`, `descricao`, `preco_base`, `tp_modo_reserva`) VALUES
(1, 'Suite Master', '80.00', 1),
(2, 'Suite Premium', '200.00', 2),
(3, 'Suite Gold', '25.00', 1);


DROP TABLE IF EXISTS `perfil_item`;
CREATE TABLE `perfil_item` (
  `id_perfil` int(11) NOT NULL,
  `id_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `perfil_item` (`id_perfil`, `id_item`) VALUES
(2, 3),
(2, 4),
(2, 2),
(1, 1),
(1, 3),
(1, 4);


DROP TABLE IF EXISTS `produto`;
CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `produto` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `codigodebarras` varchar(255) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `produto` (`id_produto`, `produto`, `preco`, `codigodebarras`) VALUES
(1, 'Coca-cola', 3.00, ''),
(2, 'Sabonete', 1.50, '');


DROP TABLE IF EXISTS `quarto`;
CREATE TABLE `quarto` (
  `id_quarto` int(10) NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `id_perfil` int(10) NOT NULL,
  PRIMARY KEY (`id_quarto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `quarto` (`id_quarto`, `numero`, `descricao`, `id_perfil`) VALUES
(1, 39, 'Inf-hr', 2),
(2, 139, 'Sup-dr', 1);


DROP TABLE IF EXISTS `situacao`;
CREATE TABLE `situacao` (
  `id_situacao` int(11) NOT NULL AUTO_INCREMENT,
  `situacao` varchar(100) NOT NULL,
  PRIMARY KEY (`id_situacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `situacao` (`id_situacao`, `situacao`) VALUES
(1, 'Em Uso'),
(2, 'Reservado'),
(3, 'Livre'),
(4, 'Manuteção');


DROP TABLE IF EXISTS `reserva`;
CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `id_quarto` int(11) NOT NULL,
q  `id_situacao` int(11) NOT NULL,
  `entrada` datetime NOT NULL,
  `saida` datetime DEFAULT NULL,
  `qt_pessoas` int(11) NOT NULL,
  PRIMARY KEY (`id_reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `usuario` (`id_usuario`, `nome`, `login`, `senha`) VALUES
(1, 'Jocélio Lima', 'jocelio@blackhostel.com', '202cb962ac59075b964b07152d234b70'),
(2, 'Tiago França', 'tiago@blackhostel.com', '202cb962ac59075b964b07152d234b70'),
(3, 'Edson Brandão', 'edson@blackhostel.com', '202cb962ac59075b964b07152d234b70');

