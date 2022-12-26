-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 03, 2022 alle 18:05
-- Versione del server: 10.4.24-MariaDB
-- Versione PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `giardinaggio`
--
--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`idutente`, `codice_fiscale`, `nome`, `cognome`, `citta`, `cap`, `indirizzo`, `numero_civico`, `telefono`, `email`, `pass`, `partita_iva`, `tipo`, `timestamp`) VALUES
(1, 'CODICE___FISCALE', 'Sebastiano', 'Valli', 'Lecce', '73100', 'via Dante Alighieri ', 3, '3926013815', 'sebastiano.valli@gmail.com', 'ciao', 'PARTITA_IVA', 'ins', '2022-07-09 06:09:15'),
(2, 'CODICE___FISCALE', 'Domenico', 'Petraroli', 'Ancona', '74023', 'via Alessandro Manzoni', 25, '3926013815', 'domenico.petraroli@gmail.com', 'ciao', 'PARTITA_IVA', 'ins', '2022-07-09 06:14:25'),
(3, 'CODICE___FISCALE', 'Giandomenico', 'Monopoli', 'Bari', '74023', 'via Edoardo Orabona', 4, '3926013815', 'giando.monopoli@gmail.com', 'ciao', 'PARTITA_IVA', 'ins', '2022-07-09 06:20:20'),
(4, 'CODICE___FISCALE', 'Andrea', 'Pulito', 'Vicenza', '74023', 'via Giuseppe Garibaldi', 44, '3926013815', 'andrea.pulito@gmail.com', 'ciao', 'PARTITA_IVA', 'ins', '2022-07-09 06:21:29'),
(5, 'CODICE___FISCALE', 'Oreste', 'Console', 'Ragusa', '74023', 'via Giovanni Falcone', 19, '3926013815', 'oreste.console@gmail.com', 'ciao', 'PARTITA_IVA', 'ins', '2022-07-09 06:22:21'),
(6, 'CODICE___FISCALE', 'Carlo', 'De Rossi', 'Roma', '74023', 'via Aldo Moro', 128, '3926013815', 'carlo.derossi@gmail.com', 'ciao', 'PARTITA_IVA', 'pro', '2022-07-09 06:26:49'),
(7, 'CODICE___FISCALE', 'Francesco', 'Taddei', 'Milano', '74023', 'Via Sant\'Agostino', 22, '3926013815', 'francesco.taddei@gmail.com', 'ciao', 'PARTITA_IVA', 'pro', '2022-07-09 06:26:49'),
(8, 'CODICE___FISCALE', 'Roberto', 'Mancini', 'Firenze', '74023', 'via duca degli abruzzi', 76, '3926013815', 'roberto.mancini@gmail.com', 'ciao', 'PARTITA_IVA', 'pro', '2022-07-09 06:26:49'),
(9, 'CODICE___FISCALE', 'Paolo', 'Maldini', 'Milano', '74023', 'via Giacomo Leopardi', 2, '3926013815', 'paolo.maldini@gmail.com', 'ciao', 'PARTITA_IVA', 'pro', '2022-07-09 06:26:49'),
(10, 'CODICE___FISCALE', 'Massimo', 'Ranieri', 'Napoli', '74023', 'via Primo Levi', 68, '3926013815', 'massimo.ranieri@gmail.com', 'ciao', 'PARTITA_IVA', 'pro', '2022-07-09 06:26:49'),
(12, 'CODICE___FISCALE', 'Edoardo', 'Cavallo', 'Grottaglie', '74023', 'via Dante Alighieri', 3, '3926013815', 'edoardo.cavallo@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b', 'PARTITA_IVA', 'ins', '2022-07-13 14:08:38');


--
-- Dump dei dati per la tabella `annuncio`
--

INSERT INTO `annuncio` (`idannuncio`, `idinserzionista`, `titolo`, `descrizione`, `luogo_lavoro`, `dimensione_giardino`, `tempistica`, `tempistica_unita`, `timestamp`) VALUES
(1, 1, 'Sistemare quercia', 'Mi serve una mano per sistemare la quercia', '', 2, 1, 'settimana', '2022-07-09 08:31:24'),
(2, 1, 'Tagliare erba', 'L\'erba è cresciuta troppo', '', 4, 2, 'settimana', '2022-07-09 08:32:08'),
(3, 2, 'Piantare basilico e prezzemolo', 'Vorrei piantare delle piante di basilico e prezzemolo nel mio giardino', '', 8, 1, 'mese', '2022-07-09 08:33:36'),
(4, 2, 'Pulizia giardino', 'Mi serve una pulizia generale del giardino', '', 3, 3, 'settimana', '2022-07-09 08:33:36'),
(5, 3, 'Piantare zucchine', 'Ho bisogno di una mano per piantare', 'Grottaglie, Via Socrate', 5, 1, 'mese', '2022-07-09 08:35:28'),
(6, 3, 'Piantare melanzane', 'Vorrei coltivare delle melanzane nel giardino', '', 5, 2, 'mese', '2022-07-09 08:35:28'),
(7, 4, 'Pulizia giardino posteriore', 'Pulire giardino posteriore', '', 13, 2, 'mese', '2022-07-09 08:36:52'),
(8, 4, 'Togliere erbacce', 'Il giardino si è riempito di erbacce e vorrei toglierle', '', 9, 4, 'mese', '2022-07-09 08:36:52'),
(9, 5, 'Piantare margherite', 'Voglio aggiungere dei fiori nel mio giardino', '', 4, 1, 'settimana', '2022-07-09 08:38:28'),
(10, 5, 'Sradicare ulivo', 'Bisogna sradicare un albero di ulivo morto', '', 4, 2, 'mese', '2022-07-09 08:38:28'),
(11, 3, 'Piantagione Pomodori', 'Ho bisogno di una mano per piantare', 'Grottaglie, Via Tacito', 8, 3, 'settimana', '2022-09-07 06:52:25');

--
-- Dump dei dati per la tabella `preventivo`
--

INSERT INTO `preventivo` (`idpreventivo`, `idprofessionista`, `idannuncio`, `compenso`, `descrizione`, `accettato`, `pagato`, `timestamp`) VALUES
(1, 1, 5, 400, 'Posso dare una mano', 0, 0, '2022-08-15 02:37:00'),
(2, 6, 7, 100, 'Posso dare una mano', 0, 0, '2022-08-20 05:38:15'),
(3, 6, 5, 700, 'Posso dare una mano con i pomodori', 0, 0, '2022-08-20 05:39:11');


-- --------------------------------------------------------

--
-- Struttura per vista `inserzionista`
--
DROP TABLE IF EXISTS `inserzionista`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inserzionista`  AS SELECT `utente`.`idutente` AS `idutente`, `utente`.`codice_fiscale` AS `codice_fiscale`, `utente`.`nome` AS `nome`, `utente`.`cognome` AS `cognome`, `utente`.`citta` AS `citta`, `utente`.`cap` AS `cap`, `utente`.`indirizzo` AS `indirizzo`, `utente`.`numero_civico` AS `numero_civico`, `utente`.`telefono` AS `telefono`, `utente`.`email` AS `email`, `utente`.`pass` AS `pass` FROM `utente` WHERE `utente`.`tipo` = 'ins''ins'  ;

-- --------------------------------------------------------

--
-- Struttura per vista `professionista`
--
DROP TABLE IF EXISTS `professionista`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `professionista`  AS SELECT `utente`.`idutente` AS `idutente`, `utente`.`codice_fiscale` AS `codice_fiscale`, `utente`.`nome` AS `nome`, `utente`.`cognome` AS `cognome`, `utente`.`citta` AS `citta`, `utente`.`cap` AS `cap`, `utente`.`indirizzo` AS `indirizzo`, `utente`.`numero_civico` AS `numero_civico`, `utente`.`telefono` AS `telefono`, `utente`.`email` AS `email`, `utente`.`pass` AS `pass` FROM `utente` WHERE `utente`.`tipo` = 'pro''pro'  ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
