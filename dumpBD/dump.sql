-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.11-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para devsbooks
CREATE DATABASE IF NOT EXISTS `devsbooks` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `devsbooks`;

-- Copiando estrutura para tabela devsbooks.postcomments
CREATE TABLE IF NOT EXISTS `postcomments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela devsbooks.postcomments: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `postcomments` DISABLE KEYS */;
INSERT INTO `postcomments` (`id`, `id_post`, `id_user`, `created_at`, `body`) VALUES
	(3, 18, 2, '2021-04-06 21:00:57', 'kkkkk'),
	(4, 18, 2, '2021-04-06 21:01:18', 'kk['),
	(5, 20, 2, '2021-04-06 23:05:02', 'asdas'),
	(6, 20, 2, '2021-04-06 23:05:03', 'asdasd'),
	(7, 21, 4, '2021-04-20 17:54:48', 'vai'),
	(10, 31, 4, '2021-04-25 17:15:16', 'teste'),
	(11, 33, 4, '2021-05-31 02:06:09', 'ddd');
/*!40000 ALTER TABLE `postcomments` ENABLE KEYS */;

-- Copiando estrutura para tabela devsbooks.postlikes
CREATE TABLE IF NOT EXISTS `postlikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela devsbooks.postlikes: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `postlikes` DISABLE KEYS */;
INSERT INTO `postlikes` (`id`, `id_post`, `id_user`, `created_at`) VALUES
	(3, 18, 2, '2021-04-06 21:00:50'),
	(6, 25, 4, '2021-04-20 10:34:37'),
	(7, 20, 2, '2021-04-20 10:35:14'),
	(8, 12, 2, '2021-04-20 10:35:23'),
	(10, 18, 3, '2021-04-20 10:37:19'),
	(11, 12, 3, '2021-04-20 10:37:26'),
	(12, 20, 3, '2021-04-20 10:37:28');
/*!40000 ALTER TABLE `postlikes` ENABLE KEYS */;

-- Copiando estrutura para tabela devsbooks.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `body` (`body`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela devsbooks.posts: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `id_user`, `type`, `created_at`, `body`) VALUES
	(12, 3, 'text', '2021-04-06 03:33:15', 'teste'),
	(18, 2, 'text', '2021-04-06 21:00:46', 'Murilote&nbsp;<div>é o cara</div><div><br></div>'),
	(20, 2, 'photo', '2021-04-06 21:02:51', 'ac8faf3a7d528133a2dbd9eec338652c.jpg'),
	(21, 4, 'text', '2021-04-18 20:16:28', 'aaaa'),
	(23, 4, 'text', '2021-04-19 15:34:53', 'sssss<div><br></div>'),
	(28, 4, 'text', '2021-04-25 06:07:48', 'renan<div><br></div>'),
	(29, 4, 'text', '2021-04-25 06:08:34', 'vamos ver<div><br></div>'),
	(30, 4, 'text', '2021-04-25 06:08:47', '555'),
	(31, 4, 'text', '2021-04-25 06:08:58', 'outra pag'),
	(32, 4, 'photo', '2021-05-31 01:37:34', '706c25cbab71dbc756e80c4913567c75.jpg'),
	(33, 4, 'photo', '2021-05-31 01:37:43', 'c954d23e6a2b13f8f14744734e30673c.jpg'),
	(34, 4, 'text', '2021-05-31 02:06:19', 'dsdaad<div><br></div>');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Copiando estrutura para tabela devsbooks.userrelations
CREATE TABLE IF NOT EXISTS `userrelations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela devsbooks.userrelations: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `userrelations` DISABLE KEYS */;
INSERT INTO `userrelations` (`id`, `user_from`, `user_to`) VALUES
	(6, 3, 2),
	(7, 2, 3);
/*!40000 ALTER TABLE `userrelations` ENABLE KEYS */;

-- Copiando estrutura para tabela devsbooks.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `work` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `cover` varchar(100) NOT NULL DEFAULT 'cover.jpg',
  `token` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela devsbooks.users: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `password`, `name`, `birthdate`, `city`, `work`, `avatar`, `cover`, `token`) VALUES
	(2, 'pirulito@test.com', '$2y$10$CowVwBoSc7qQ55qmgrZpl./skHfCbjOq1/TUm.oWLQtLFrnx3RVve', 'Jorge Vitor', '1984-01-24', 'pirulitolandia', 'casa de pirulitos', 'd1e92fe28b61a91439d737d53d605484.jpg', 'a5f66651cf9bf2df78eb4511542c4577.jpg', 'c121b89a81ead771919a8d490365d06f'),
	(3, 'sabugosa@test.com', '$2y$10$CLK/JnpVhFMr3LBGUkbthOKmmcSJcbzmojh3yjCxGIQ.tso1YFB8y', 'sabugosa', '1830-01-10', '', '', 'default.jpg', 'cover.jpg', '3f9136a537cab53a06d11f2968b6845f'),
	(4, 'tretinha@teste.com', '$2y$10$eM7lNreKmtBKCRRzR3IOyeQBZA/OaYDdh181xWLtQrCUh0heMEcJm', 'Tretinha Sauro 2', '1980-01-29', 'teste', 'teste', '50ffdc67532b2bd30a2601b52188ad32.jpg', 'f5cf66b514b63ea162e9100684d631da.jpg', '4d1f3c662fa9b52c11ba5147bc8d4e0e');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
