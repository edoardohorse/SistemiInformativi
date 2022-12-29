-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 29, 2022 alle 17:23
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

-- --------------------------------------------------------

--
-- Struttura della tabella `annuncio`
--

CREATE TABLE `annuncio` (
  `idannuncio` int(11) NOT NULL,
  `idinserzionista` int(11) NOT NULL,
  `titolo` varchar(50) NOT NULL,
  `descrizione` text NOT NULL,
  `luogo_lavoro` text NOT NULL,
  `dimensione_giardino` int(11) NOT NULL,
  `tempistica` int(11) NOT NULL,
  `tempistica_unita` enum('settimana','mese') DEFAULT 'mese',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `scadenza` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ;

--
-- Dump dei dati per la tabella `annuncio`
--

INSERT INTO `annuncio` (`idannuncio`, `idinserzionista`, `titolo`, `descrizione`, `luogo_lavoro`, `dimensione_giardino`, `tempistica`, `tempistica_unita`, `timestamp`, `scadenza`) VALUES
(1, 1, 'Sistemare quercia', 'Mi serve una mano per sistemare la quercia', '', 2, 1, 'settimana', '2022-07-09 08:31:24', '0000-00-00 00:00:00'),
(2, 1, 'Tagliare erba', 'L\'erba è cresciuta troppo', '', 4, 2, 'settimana', '2022-07-09 08:32:08', '0000-00-00 00:00:00'),
(3, 2, 'Piantare basilico e prezzemolo', 'Vorrei piantare delle piante di basilico e prezzemolo nel mio giardino', '', 8, 1, 'mese', '2022-07-09 08:33:36', '0000-00-00 00:00:00'),
(4, 2, 'Pulizia giardino', 'Mi serve una pulizia generale del giardino', '', 3, 3, 'settimana', '2022-07-09 08:33:36', '0000-00-00 00:00:00'),
(5, 3, 'Piantare zucchine', 'Ho bisogno di una mano per piantare', 'Grottaglie, Via Socrate', 5, 1, 'mese', '2022-07-09 08:35:28', '0000-00-00 00:00:00'),
(6, 3, 'Piantare melanzane', 'Vorrei coltivare delle melanzane nel giardino', '', 5, 2, 'mese', '2022-07-09 08:35:28', '0000-00-00 00:00:00'),
(7, 4, 'Pulizia giardino posteriore', 'Pulire giardino posteriore', '', 13, 2, 'mese', '2022-07-09 08:36:52', '0000-00-00 00:00:00'),
(8, 4, 'Togliere erbacce', 'Il giardino si è riempito di erbacce e vorrei toglierle', '', 9, 4, 'mese', '2022-07-09 08:36:52', '0000-00-00 00:00:00'),
(9, 5, 'Piantare margherite', 'Voglio aggiungere dei fiori nel mio giardino', '', 4, 1, 'settimana', '2022-07-09 08:38:28', '0000-00-00 00:00:00'),
(10, 5, 'Sradicare ulivo', 'Bisogna sradicare un albero di ulivo morto', '', 4, 2, 'mese', '2022-07-09 08:38:28', '0000-00-00 00:00:00'),
(12, 3, 'Pianta di tulipani', 'Ho bisogno di una mano per piantare', 'Bari, via lazio n2', 3, 1, 'settimana', '2022-12-27 09:26:05', '2023-01-03 09:26:05'),
(13, 2, 'Piantare rose', 'Ho bisogno di una mano per piantare rose', 'Grottaglie, via Tito n56', 1, 1, 'settimana', '2022-12-27 10:55:48', '2023-01-03 10:55:48'),
(14, 3, 'Potatura alberi di ulivo ', 'Necessito la potatura di 10 Alberi d\'ulivo nel mio giardino', 'Grottaglie, contrada Mannara', 4, 1, 'mese', '2022-12-27 10:56:43', '2023-01-24 10:56:43'),
(15, 2, 'tosatura erba', 'necessito della tosatura di erba perimetrale nel giardino di casa mia', 'Taranto, via Italia n24', 10, 2, 'settimana', '2022-12-27 11:16:08', '2023-01-10 11:16:08'),
(16, 3, 'tosatura prato inglese ', 'Buonasera, necessito della tosatura del prato inglese nel mio giardino di casa', 'Grottaglie, Via Brobbeis 33', 100, 1, 'settimana', '2022-12-27 14:27:14', '2023-01-03 14:27:14'),
(17, 3, 'piantumazione di piante esotiche', 'Ho bisogno di una mano per piantare', 'via sisto 7, Francavilla Fontana, BR', 300, 2, 'settimana', '2022-12-28 09:48:52', '2023-01-18 09:48:52'),
(18, 2, 'pianta malata', 'serve una aiuto per potatura ceppo di pino malato', 'Bari, via unità d\'italia 45', 1, 1, 'settimana', '2022-12-28 11:35:36', '2023-01-04 11:35:36'),
(19, 2, 'piantumazione peonie', 'Ho bisogno di una mano per piantare peonie nel mio giardino di casa e consigli per la cura', 'molfetta, Via taranto 12', 2, 4, 'settimana', '2022-12-28 11:37:11', '2023-01-25 11:37:11'),
(20, 2, 'Fertilizzante per betulla', 'cerco lavoratore disposto a fertilizzare degli alberi di betulla presenti nel mio terreno in prossimità di Lecce', 'Lecce, Via Risola 12 contrada pollino', 50, 4, 'settimana', '2022-12-28 11:40:59', '2023-01-25 11:40:59');

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `inserzionista`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `inserzionista` (
`idutente` int(11)
,`codice_fiscale` varchar(16)
,`nome` varchar(30)
,`cognome` varchar(30)
,`citta` varchar(50)
,`cap` varchar(5)
,`indirizzo` varchar(50)
,`numero_civico` int(11)
,`telefono` varchar(10)
,`email` varchar(150)
,`pass` varchar(30)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `notifica`
--

CREATE TABLE `notifica` (
  `idnotifica` int(11) NOT NULL,
  `idutente` int(11) NOT NULL,
  `letta` tinyint(1) NOT NULL DEFAULT 0,
  `messaggio` varchar(500) NOT NULL,
  `redirectUrl` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `notifica`
--

INSERT INTO `notifica` (`idnotifica`, `idutente`, `letta`, `messaggio`, `redirectUrl`, `timestamp`) VALUES
(38, 10, 1, 'Preventivo inviato: piantumazione di piante esotiche', '/SistemiInformativi/annuncio/view?id=17&idnotifica=38', '2022-12-28 11:29:59'),
(39, 3, 0, 'Hai ricevuto un preventivo da parte di Massimo Ranieri: piantumazione di piante esotiche', '/SistemiInformativi/annuncio/view?id=17&idnotifica=39', '2022-12-28 11:29:59'),
(40, 2, 0, 'Annuncio creato con successo: pianta malata', '/SistemiInformativi/annuncio/view?id=18&idnotifica=40', '2022-12-28 11:35:36'),
(41, 2, 0, 'Annuncio creato con successo: piantumazione peonie', '/SistemiInformativi/annuncio/view?id=19&idnotifica=41', '2022-12-28 11:37:11'),
(42, 2, 0, 'Annuncio creato con successo: Fertilizzante per betulla', '/SistemiInformativi/annuncio/view?id=20&idnotifica=42', '2022-12-28 11:40:59'),
(43, 3, 0, 'Preventivo accettato: piantumazione di piante esotiche', '/SistemiInformativi/annuncio/view?id=17&idnotifica=43', '2022-12-29 15:36:45'),
(44, 10, 1, 'Giandomenico Monopoli ha accettato il tuo preventivo: piantumazione di piante esotiche', '/SistemiInformativi/annuncio/view?id=17&idnotifica=44', '2022-12-29 15:36:45'),
(45, 3, 0, 'Preventivo accettato: piantumazione di piante esotiche', '/SistemiInformativi/annuncio/view?id=17&idnotifica=45', '2022-12-29 15:38:30'),
(46, 10, 1, 'Giandomenico Monopoli ha accettato il tuo preventivo: piantumazione di piante esotiche', '/SistemiInformativi/annuncio/view?id=17&idnotifica=46', '2022-12-29 15:38:30'),
(47, 3, 0, 'Preventivo rifiutato: piantumazione di piante esotiche', '/SistemiInformativi/annuncio/view?id=17&idnotifica=47', '2022-12-29 15:39:31'),
(48, 10, 1, 'Giandomenico Monopoli ha rifiutato il tuo preventivo: piantumazione di piante esotiche', '/SistemiInformativi/annuncio/view?id=17&idnotifica=48', '2022-12-29 15:39:31'),
(49, 3, 0, 'Preventivo accettato: piantumazione di piante esotiche', '/SistemiInformativi/annuncio/view?id=17&idnotifica=49', '2022-12-29 15:39:36'),
(50, 10, 1, 'Giandomenico Monopoli ha accettato il tuo preventivo: piantumazione di piante esotiche', '/SistemiInformativi/annuncio/view?id=17&idnotifica=50', '2022-12-29 15:39:36'),
(51, 3, 0, 'Preventivo pagato: piantumazione di piante esotiche', '/SistemiInformativi/annuncio/view?id=17&idnotifica=51', '2022-12-29 15:39:40'),
(52, 10, 1, 'Giandomenico Monopoli ha pagato il tuo preventivo: piantumazione di piante esotiche', '/SistemiInformativi/annuncio/view?id=17&idnotifica=52', '2022-12-29 15:39:40');

-- --------------------------------------------------------

--
-- Struttura della tabella `preventivo`
--

CREATE TABLE `preventivo` (
  `idpreventivo` int(11) NOT NULL,
  `idprofessionista` int(11) NOT NULL,
  `idannuncio` int(11) NOT NULL,
  `compenso` float NOT NULL,
  `descrizione` text NOT NULL,
  `accettato` tinyint(1) NOT NULL DEFAULT 0,
  `pagato` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Dump dei dati per la tabella `preventivo`
--

INSERT INTO `preventivo` (`idpreventivo`, `idprofessionista`, `idannuncio`, `compenso`, `descrizione`, `accettato`, `pagato`, `timestamp`) VALUES
(13, 10, 17, 350, 'ciao giandomenico, sono disponibile il mese prossimo', 1, 1, '2022-12-28 11:29:59');

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `professionista`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `professionista` (
`idutente` int(11)
,`codice_fiscale` varchar(16)
,`nome` varchar(30)
,`cognome` varchar(30)
,`citta` varchar(50)
,`cap` varchar(5)
,`indirizzo` varchar(50)
,`numero_civico` int(11)
,`telefono` varchar(10)
,`email` varchar(150)
,`pass` varchar(30)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `recensione`
--

CREATE TABLE `recensione` (
  `idrecensione` int(11) NOT NULL,
  `idrecensore` int(11) NOT NULL,
  `idrecensito` int(11) NOT NULL,
  `idpreventivo` int(11) NOT NULL,
  `descrizione` varchar(500) NOT NULL,
  `voto` int(11) NOT NULL DEFAULT 1,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `idutente` int(11) NOT NULL,
  `codice_fiscale` varchar(16) NOT NULL DEFAULT 'CODICE___FISCALE',
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `citta` varchar(50) NOT NULL,
  `cap` varchar(5) NOT NULL DEFAULT '74023',
  `indirizzo` varchar(50) NOT NULL,
  `numero_civico` int(11) NOT NULL,
  `telefono` varchar(10) NOT NULL DEFAULT '3926013815',
  `email` varchar(150) NOT NULL,
  `pass` varchar(30) NOT NULL DEFAULT 'ciao',
  `partita_iva` varchar(11) DEFAULT 'PARTITA_IVA',
  `tipo` enum('ins','pro') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Struttura per vista `inserzionista`
--
DROP TABLE IF EXISTS `inserzionista`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inserzionista`  AS SELECT `utente`.`idutente` AS `idutente`, `utente`.`codice_fiscale` AS `codice_fiscale`, `utente`.`nome` AS `nome`, `utente`.`cognome` AS `cognome`, `utente`.`citta` AS `citta`, `utente`.`cap` AS `cap`, `utente`.`indirizzo` AS `indirizzo`, `utente`.`numero_civico` AS `numero_civico`, `utente`.`telefono` AS `telefono`, `utente`.`email` AS `email`, `utente`.`pass` AS `pass` FROM `utente` WHERE `utente`.`tipo` = 'ins\'ins''ins\'ins'  ;

-- --------------------------------------------------------

--
-- Struttura per vista `professionista`
--
DROP TABLE IF EXISTS `professionista`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `professionista`  AS SELECT `utente`.`idutente` AS `idutente`, `utente`.`codice_fiscale` AS `codice_fiscale`, `utente`.`nome` AS `nome`, `utente`.`cognome` AS `cognome`, `utente`.`citta` AS `citta`, `utente`.`cap` AS `cap`, `utente`.`indirizzo` AS `indirizzo`, `utente`.`numero_civico` AS `numero_civico`, `utente`.`telefono` AS `telefono`, `utente`.`email` AS `email`, `utente`.`pass` AS `pass` FROM `utente` WHERE `utente`.`tipo` = 'pro\'pro''pro\'pro'  ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `annuncio`
--
ALTER TABLE `annuncio`
  ADD PRIMARY KEY (`idannuncio`),
  ADD KEY `idinserzionista` (`idinserzionista`);

--
-- Indici per le tabelle `notifica`
--
ALTER TABLE `notifica`
  ADD PRIMARY KEY (`idnotifica`),
  ADD KEY `idutente` (`idutente`);

--
-- Indici per le tabelle `preventivo`
--
ALTER TABLE `preventivo`
  ADD PRIMARY KEY (`idpreventivo`),
  ADD KEY `idprofessionista` (`idprofessionista`),
  ADD KEY `idannuncio` (`idannuncio`);

--
-- Indici per le tabelle `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`idrecensione`,`idrecensore`,`idrecensito`,`idpreventivo`),
  ADD KEY `idrecensore` (`idrecensore`),
  ADD KEY `idrecensito` (`idrecensito`),
  ADD KEY `idpreventivo` (`idpreventivo`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`idutente`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `annuncio`
--
ALTER TABLE `annuncio`
  MODIFY `idannuncio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `notifica`
--
ALTER TABLE `notifica`
  MODIFY `idnotifica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT per la tabella `preventivo`
--
ALTER TABLE `preventivo`
  MODIFY `idpreventivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `recensione`
--
ALTER TABLE `recensione`
  MODIFY `idrecensione` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `idutente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `annuncio`
--
ALTER TABLE `annuncio`
  ADD CONSTRAINT `annuncio_ibfk_1` FOREIGN KEY (`idinserzionista`) REFERENCES `utente` (`idutente`);

--
-- Limiti per la tabella `notifica`
--
ALTER TABLE `notifica`
  ADD CONSTRAINT `notifica_ibfk_1` FOREIGN KEY (`idutente`) REFERENCES `utente` (`idutente`);

--
-- Limiti per la tabella `preventivo`
--
ALTER TABLE `preventivo`
  ADD CONSTRAINT `preventivo_ibfk_1` FOREIGN KEY (`idprofessionista`) REFERENCES `utente` (`idutente`),
  ADD CONSTRAINT `preventivo_ibfk_2` FOREIGN KEY (`idannuncio`) REFERENCES `annuncio` (`idannuncio`);

--
-- Limiti per la tabella `recensione`
--
ALTER TABLE `recensione`
  ADD CONSTRAINT `recensione_ibfk_1` FOREIGN KEY (`idrecensore`) REFERENCES `utente` (`idutente`),
  ADD CONSTRAINT `recensione_ibfk_2` FOREIGN KEY (`idrecensito`) REFERENCES `utente` (`idutente`),
  ADD CONSTRAINT `recensione_ibfk_3` FOREIGN KEY (`idpreventivo`) REFERENCES `preventivo` (`idpreventivo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
