--  MySQL Database Dump 1.1
--  Host: localhost    Database: negozio
--  Server version 5.5.5-10.1.9-MariaDB
--
--  Dump database negozio on 18/12/2018 00:41:38
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ negozio;
USE negozio;

--
--  Table structure for table "articoli"
--
DROP TABLE IF EXISTS `articoli`;

CREATE TABLE `articoli` (
  `id` int(11) NOT NULL,
  `nome` char(50) NOT NULL,
  `foto` char(50) NOT NULL,
  `prezzo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO articoli
  (id, nome, foto, prezzo)
VALUES
  (1, "bici giovanna", "articolo1.jpg", 500);

INSERT INTO articoli
  (id, nome, foto, prezzo)
VALUES
  (2, "bici graziella", "articolo2.jpg", 250);

INSERT INTO articoli
  (id, nome, foto, prezzo)
VALUES
  (3, "bici sport", "articolo3.jpg", 220);

INSERT INTO articoli
  (id, nome, foto, prezzo)
VALUES
  (4, "bici maddalena", "articolo4.jpg", 220);

INSERT INTO articoli
  (id, nome, foto, prezzo)
VALUES
  (5, "bici allegria", "articolo5.jpg", 280);

INSERT INTO articoli
  (id, nome, foto, prezzo)
VALUES
  (6, "bici furia", "articolo6.jpg", 230);

INSERT INTO articoli
  (id, nome, foto, prezzo)
VALUES
  (7, "bici betulla", "articolo7.jpg", 170);

INSERT INTO articoli
  (id, nome, foto, prezzo)
VALUES
  (8, "bici furtiva", "articolo8.jpg", 330);

INSERT INTO articoli
  (id, nome, foto, prezzo)
VALUES
  (9, "bici sorgente", "articolo9.jpg", 550);

--  MySQL Database Dump 1.1
--  Host: localhost    Database: negozio
--  Server version 5.5.5-10.1.9-MariaDB
--
--  Dump database negozio on 18/12/2018 00:41:38
--

--
--  Table structure for table "utenti"
--
DROP TABLE IF EXISTS `utenti`;

CREATE TABLE `utenti` (
  `nome` char(50) COLLATE utf8_bin NOT NULL,
  `password` char(50) COLLATE utf8_bin DEFAULT NULL,
  `ruolo` char(50) CHARACTER SET utf8 DEFAULT NULL,
  `email` char(100) CHARACTER SET utf8 DEFAULT NULL,
  `confermato` char(2) CHARACTER SET utf8 DEFAULT 'no',
  `hash` char(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


INSERT INTO utenti
  (nome, password, ruolo, email, confermato, hash)
VALUES
  ("admin", "admin", "admin", "admin@negozio.it", "si", "21232F297A57A5A743894A0E4A801FC3");

INSERT INTO utenti
  (nome, password, ruolo, email, confermato, hash)
VALUES
  ("alfa", "mu66rkk2", "utente", "alfa@tiscali.it", "si", "7bd5c568f0f11d49a1527478c148cbcd");

INSERT INTO utenti
  (nome, password, ruolo, email, confermato, hash)
VALUES
  ("elena", "elena", "utente", "elena@tiscali.it", "si", "FADF17141F3F9C3389D10D09DB99F757");

INSERT INTO utenti
  (nome, password, ruolo, email, confermato, hash)
VALUES
  ("gianni", "gianni", "utente", "gianni@libero.it", "si", "1BC42179CC24BCC5EEFF1B1B2D03657C");

INSERT INTO utenti
  (nome, password, ruolo, email, confermato, hash)
VALUES
  ("pietro", "pietro", "utente", "pietro@yahoo.it", "no", "7189DFEAC32CEA348F25D63EB1F07276");

INSERT INTO utenti
  (nome, password, ruolo, email, confermato, hash)
VALUES
  ("pippo", "pippo", "utente", "pippo@gmail.com", "si", "0C88028BF3AA6A6A143ED846F2BE1EA4");

INSERT INTO utenti
  (nome, password, ruolo, email, confermato, hash)
VALUES
  ("pollo", "gqjeOvZJ", "utente", "admin@azienda.it", "si", "7bc376ed368078135009b0b02f15e989");

--  MySQL Database Dump 1.1
--  Host: localhost    Database: negozio
--  Server version 5.5.5-10.1.9-MariaDB
--
--  Dump database negozio on 18/12/2018 00:41:38
--

--
--  Table structure for table "ordini"
--
DROP TABLE IF EXISTS `ordini`;

CREATE TABLE `ordini` (
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


INSERT INTO ordini
  (id, nomeCliente, idArticolo, prezzo, dataOra)
VALUES
  (40, "pippo", 1, 500, "2018-05-09 23:31:21");

INSERT INTO ordini
  (id, nomeCliente, idArticolo, prezzo, dataOra)
VALUES
  (41, "pippo", 1, 500, "2018-05-12 23:58:22");

INSERT INTO ordini
  (id, nomeCliente, idArticolo, prezzo, dataOra)
VALUES
  (43, "alfa", 2, 250, "2018-06-01 00:56:27");

