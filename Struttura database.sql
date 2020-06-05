SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `Classi` (
  `Classe` varchar(8) NOT NULL,
  PRIMARY KEY (`Classe`),
  FULLTEXT KEY `Classe` (`Classe`),
  FULLTEXT KEY `Classe_2` (`Classe`),
  FULLTEXT KEY `Classe_3` (`Classe`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `Contatti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(20) DEFAULT NULL,
  `Email` varchar(40) DEFAULT NULL,
  `Messaggio` text NOT NULL,
  `Data_inserimento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `Utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(20) NOT NULL,
  `Cognome` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(70) NOT NULL,
  `auth_messaggi` tinyint(1) NOT NULL DEFAULT '0',
  `auth_modifica` tinyint(1) NOT NULL DEFAULT '0',
  `auth_mielezioni` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `Videolezioni` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `Classe` varchar(4) NOT NULL,
  `Data` date NOT NULL,
  `Ora_inizio` time(4) NOT NULL,
  `Ora_fine` time(4) NOT NULL,
  `Materia` varchar(20) NOT NULL,
  `Prof` varchar(30) NOT NULL,
  `Compiti` tinyint(1) NOT NULL,
  `Link` varchar(40) NOT NULL,
  `Codice` varchar(20) NOT NULL,
  `Annotazioni` text NOT NULL,
  `Data_inserimento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=187 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
