-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              10.1.9-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win32
-- HeidiSQL Versione:            9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dump della struttura del database negozio
CREATE DATABASE IF NOT EXISTS `negozio` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `negozio`;

-- Dump della struttura di tabella negozio.articoli
CREATE TABLE IF NOT EXISTS `articoli` (
  `id` int(11) NOT NULL,
  `nome` char(50) NOT NULL,
  `foto` char(50) NOT NULL,
  `prezzo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dump dei dati della tabella negozio.articoli: ~9 rows (circa)
DELETE FROM `articoli`;
/*!40000 ALTER TABLE `articoli` DISABLE KEYS */;
INSERT INTO `articoli` (`id`, `nome`, `foto`, `prezzo`) VALUES
	(1, 'bici giovanna', 'articolo1.jpg', 500),
	(2, 'bici graziella', 'articolo2.jpg', 250),
	(3, 'bici sport', 'articolo3.jpg', 220),
	(4, 'bici maddalena', 'articolo4.jpg', 220),
	(5, 'bici allegria', 'articolo5.jpg', 280),
	(6, 'bici furia', 'articolo6.jpg', 230),
	(7, 'bici betulla', 'articolo7.jpg', 170),
	(8, 'bici furtiva', 'articolo8.jpg', 330),
	(9, 'bici sorgente', 'articolo9.jpg', 550);
/*!40000 ALTER TABLE `articoli` ENABLE KEYS */;

-- Dump della struttura di tabella negozio.ordini
CREATE TABLE IF NOT EXISTS `ordini` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomeCliente` char(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `idArticolo` int(11) DEFAULT NULL,
  `prezzo` int(11) DEFAULT NULL,
  `dataOra` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_ordini_articoli` (`idArticolo`),
  KEY `nomeCliente` (`nomeCliente`),
  CONSTRAINT `FK_ordini_articoli` FOREIGN KEY (`idArticolo`) REFERENCES `articoli` (`id`),
  CONSTRAINT `FK_ordini_utenti` FOREIGN KEY (`nomeCliente`) REFERENCES `utenti` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- Dump dei dati della tabella negozio.ordini: ~10 rows (circa)
DELETE FROM `ordini`;
/*!40000 ALTER TABLE `ordini` DISABLE KEYS */;
INSERT INTO `ordini` (`id`, `nomeCliente`, `idArticolo`, `prezzo`, `dataOra`) VALUES
	(33, 'pippo', 1, 500, '2018-05-08 01:57:58'),
	(34, 'pippo', 1, 500, '2018-05-08 02:00:18'),
	(35, 'pippo', 1, 500, '2018-05-08 02:10:06'),
	(36, 'pippo', 1, 500, '2018-05-08 02:11:50'),
	(37, 'pippo', 1, 500, '2018-05-08 02:15:42'),
	(38, 'pippo', 1, 500, '2018-05-08 02:22:35'),
	(39, 'pippo', 1, 500, '2018-05-08 02:23:37'),
	(40, 'pippo', 1, 500, '2018-05-09 23:31:21'),
	(41, 'pippo', 1, 500, '2018-05-09 23:58:22'),
	(43, 'alfa', 2, 250, '2018-06-11 00:56:27');
/*!40000 ALTER TABLE `ordini` ENABLE KEYS */;

-- Dump della struttura di tabella negozio.utenti
CREATE TABLE IF NOT EXISTS `utenti` (
  `nome` char(50) COLLATE utf8_bin NOT NULL,
  `password` char(50) COLLATE utf8_bin DEFAULT NULL,
  `ruolo` char(50) CHARACTER SET utf8 DEFAULT NULL,
  `email` char(100) CHARACTER SET utf8 DEFAULT NULL,
  `confermato` char(2) CHARACTER SET utf8 DEFAULT 'no',
  `hash` char(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dump dei dati della tabella negozio.utenti: ~8 rows (circa)
DELETE FROM `utenti`;
/*!40000 ALTER TABLE `utenti` DISABLE KEYS */;
INSERT INTO `utenti` (`nome`, `password`, `ruolo`, `email`, `confermato`, `hash`) VALUES
	('aaaaaa', 'aaaaaa', 'utente', 'admin@azienda.it', 'no', NULL),
	('admin', 'admin', 'admin', 'admin@negozio.it', 'si', '21232F297A57A5A743894A0E4A801FC3'),
	('alfa', 'mu66rkk2', 'utente', 'vessillo@tiscali.it', 'si', '7bd5c568f0f11d49a1527478c148cbcd'),
	('elena', 'elena', 'utente', 'elena@tiscali.it', 'si', 'FADF17141F3F9C3389D10D09DB99F757'),
	('gianni', 'gianni', 'utente', 'gianni@libero.it', 'si', '1BC42179CC24BCC5EEFF1B1B2D03657C'),
	('pietro', 'pietro', 'utente', 'pietro@yahoo.it', 'no', '7189DFEAC32CEA348F25D63EB1F07276'),
	('pippo', 'pippo', 'utente', 'pippo@gmail.com', 'si', '0C88028BF3AA6A6A143ED846F2BE1EA4'),
	('pollo', 'gqjeOvZJ', 'utente', 'admin@azienda.it', 'si', '7bc376ed368078135009b0b02f15e989');
/*!40000 ALTER TABLE `utenti` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
