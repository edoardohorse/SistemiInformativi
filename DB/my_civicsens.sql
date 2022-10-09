-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Set 07, 2022 alle 08:07
-- Versione del server: 8.0.26
-- Versione PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_civicsens`
--

--
-- Dump dei dati per la tabella `annuncio`
--

INSERT INTO `annuncio` (`idannuncio`, `idinserzionista`, `titolo`, `descrizione`, `dimensione_giardino`, `tempistica`, `tempistica_unita`, `timestamp`) VALUES
(1, 1, 'Sistemare quercia', 'Mi serve una mano per sistemare la quercia', 2, 1, 'settimana', '2022-07-09 10:31:24'),
(2, 1, 'Tagliare erba', 'L\'erba è cresciuta troppo', 4, 2, 'settimana', '2022-07-09 10:32:08'),
(3, 2, 'Piantare basilico e prezzemolo', 'Vorrei piantare delle piante di basilico e prezzemolo nel mio giardino', 8, 1, 'mese', '2022-07-09 10:33:36'),
(4, 2, 'Pulizia giardino', 'Mi serve una pulizia generale del giardino', 3, 3, 'settimana', '2022-07-09 10:33:36'),
(5, 3, 'Piantare pomodori', 'Vorrei piantare dei pomodori nel mio giardino', 5, 1, 'mese', '2022-07-09 10:35:28'),
(6, 3, 'Piantare melanzane', 'Vorrei coltivare delle melanzane nel giardino', 5, 2, 'mese', '2022-07-09 10:35:28'),
(7, 4, 'Pulizia giardino posteriore', 'Pulire giardino posteriore', 13, 2, 'mese', '2022-07-09 10:36:52'),
(8, 4, 'Togliere erbacce', 'Il giardino si è riempito di erbacce e vorrei toglierle', 9, 4, 'mese', '2022-07-09 10:36:52'),
(9, 5, 'Piantare margherite', 'Voglio aggiungere dei fiori nel mio giardino', 4, 1, 'settimana', '2022-07-09 10:38:28'),
(10, 5, 'Sradicare ulivo', 'Bisogna sradicare un albero di ulivo morto', 4, 2, 'mese', '2022-07-09 10:38:28');

--
-- Dump dei dati per la tabella `servizio`
--

INSERT INTO `servizio` (`idservizio`, `idprofessionista`, `idannuncio`, `compenso`, `descrizione`, `accettato`, `pagato`, `timestamp`) VALUES
(1, 6, 1, 200, 'Esperto giardiniere, specializzato in querce e trattamento del legno.', 1, 1, '2022-07-10 14:03:18'),
(2, 7, 1, 230, 'mi occupo di alberi secolari, attrezzato per poter fare una sistemazione a querce.', 0, 0, '2022-07-10 14:06:27'),
(3, 10, 1, 250, 'molta esperienza per trattamento di querce, ottima attrezzatura per risoluzione problemi.', 0, 0, '2022-07-10 14:10:53'),
(4, 8, 2, 30, 'possibilità di recupero giardino in breve tempo ', 0, 0, '2022-07-10 14:14:15'),
(5, 7, 2, 10, 'lavorazioni con attrezzatura chimica per sistemazioni rapide', 0, 0, '2022-07-10 14:17:23'),
(6, 6, 2, 15, 'Veloce ed efficace, con tanta esperienza. lavorazione con tosaerba e pesticida ', 1, 1, '2022-07-10 14:19:10'),
(7, 10, 3, 39, 'esperto giardiniere nella semina', 0, 0, '2022-07-10 14:21:45'),
(8, 9, 3, 35, 'semina con prodotti di qualità e trattamento rapido', 0, 0, '2022-07-10 14:22:47'),
(9, 8, 3, 20, 'grande appassionato di basilico, realizzazione semina e regolazione per ciclo di innaffiamento ', 1, 1, '2022-07-10 14:24:26'),
(10, 6, 4, 15, 'esperto pulizia giardini', 0, 0, '2022-07-10 14:30:25'),
(11, 9, 4, 30, 'rimozione rapida e sistemazione elementi di decorazione giardino ', 0, 0, '2022-07-10 14:31:27'),
(12, 10, 4, 15, 'risoluzione problemi per terreno e pulizia eseguita tramite mezzi specializzati', 1, 1, '2022-07-10 14:32:15'),
(13, 8, 5, 15, 'esperto nella coltivazione e trattamento pomodori', 1, 1, '2022-07-10 14:35:48'),
(14, 9, 5, 16, 'esperienza nella botanica dei pomodori pugliesi ', 0, 0, '2022-07-10 14:36:37'),
(15, 10, 5, 18, 'semina efficace con macchinario specializzato', 0, 0, '2022-07-10 14:37:16'),
(16, 7, 6, 13, 'esperto coltivatore di ortaggi, con trattamento naturale ed efficace', 1, 1, '2022-07-10 14:46:07'),
(17, 8, 6, 17, 'semina rapida con metodo meccanico', 0, 0, '2022-07-10 14:47:23'),
(18, 9, 6, 19, 'semina efficace su ortaggi, melanzane in particolare.', 0, 0, '2022-07-10 14:48:48'),
(19, 10, 7, 50, 'risoluzione piante indesiderate e rimozione pietre non consone alla forma del terreno', 0, 0, '2022-07-10 14:50:21'),
(20, 9, 7, 30, 'risoluzione e tosatura del prato posteriore, esperienza in ambito di giardinaggio', 0, 0, '2022-07-10 14:51:09'),
(21, 7, 7, 35, 'esperienza in sistemazione giardini, risoluzione di zolle, pietre pesanti, prato sconnesso.', 1, 1, '2022-07-10 14:52:10'),
(22, 8, 8, 25, 'risoluzione meccanica del problema con prodotti ecosostenibili.', 0, 0, '2022-07-10 14:59:32'),
(23, 9, 8, 30, 'risoluzione rapida con pesticida naturale, sviluppato in maniera biologica.', 1, 1, '2022-07-10 15:00:31'),
(24, 6, 8, 40, 'esperto giardiniere, utilizzo agenti chimici che risolveranno il problema di piante indesiderate.', 0, 0, '2022-07-10 15:01:35'),
(25, 10, 9, 18, 'esperto nella piantagione di margherite per decorazioni ', 0, 0, '2022-07-10 15:05:15'),
(26, 9, 9, 14, 'ho referenze nel campo di seminatura e preparazione delle margherite.', 1, 1, '2022-07-10 15:06:09'),
(27, 6, 9, 24, 'risoluzione e creazione per un campo di margherite, rapido ed efficiente ', 0, 0, '2022-07-10 15:07:08'),
(28, 6, 10, 150, 'esperto risolutore per trattamento di alberi secolari', 0, 0, '2022-07-10 15:07:48'),
(29, 7, 10, 120, 'risoluzione rapida tramite metodi meccanici per movimento terra', 0, 0, '2022-07-10 15:08:46'),
(30, 10, 10, 170, 'ridimensionamento per terreni, smantellamento e recupero per alberi secolari. ', 1, 1, '2022-07-10 15:10:36');

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`idutente`, `codice_fiscale`, `nome`, `cognome`, `citta`, `cap`, `indirizzo`, `numero_civico`, `telefono`, `email`, `pass`, `partita_iva`, `tipo`, `timestamp`) VALUES
(1, 'CODICE___FISCALE', 'Sebastiano', 'Valli', 'Lecce', '73100', 'via Dante Alighieri ', 3, '3926013815', 'sebastiano.valli@gmail.com', 'ciao', 'PARTITA_IVA', 'ins', '2022-07-09 10:09:15'),
(2, 'CODICE___FISCALE', 'Domenico', 'Petraroli', 'Ancona', '74023', 'via Alessandro Manzoni', 25, '3926013815', 'domenico.petraroli@gmail.com', 'ciao', 'PARTITA_IVA', 'ins', '2022-07-09 10:14:25'),
(3, 'CODICE___FISCALE', 'Giandomenico', 'Monopoli', 'Bari', '74023', 'via Edoardo Orabona', 4, '3926013815', 'giando.monopoli@gmail.com', 'ciao', 'PARTITA_IVA', 'ins', '2022-07-09 10:20:20'),
(4, 'CODICE___FISCALE', 'Andrea', 'Pulito', 'Vicenza', '74023', 'via Giuseppe Garibaldi', 44, '3926013815', 'andrea.pulito@gmail.com', 'ciao', 'PARTITA_IVA', 'ins', '2022-07-09 10:21:29'),
(5, 'CODICE___FISCALE', 'Oreste', 'Console', 'Ragusa', '74023', 'via Giovanni Falcone', 19, '3926013815', 'oreste.console@gmail.com', 'ciao', 'PARTITA_IVA', 'ins', '2022-07-09 10:22:21'),
(6, 'CODICE___FISCALE', 'Carlo', 'De Rossi', 'Roma', '74023', 'via Aldo Moro', 128, '3926013815', 'carlo.derossi@gmail.com', 'ciao', 'PARTITA_IVA', 'pro', '2022-07-09 10:26:49'),
(7, 'CODICE___FISCALE', 'Francesco', 'Taddei', 'Milano', '74023', 'Via Sant\'Agostino', 22, '3926013815', 'francesco.taddei@gmail.com', 'ciao', 'PARTITA_IVA', 'pro', '2022-07-09 10:26:49'),
(8, 'CODICE___FISCALE', 'Roberto', 'Mancini', 'Firenze', '74023', 'via duca degli abruzzi', 76, '3926013815', 'roberto.mancini@gmail.com', 'ciao', 'PARTITA_IVA', 'pro', '2022-07-09 10:26:49'),
(9, 'CODICE___FISCALE', 'Paolo', 'Maldini', 'Milano', '74023', 'via Giacomo Leopardi', 2, '3926013815', 'paolo.maldini@gmail.com', 'ciao', 'PARTITA_IVA', 'pro', '2022-07-09 10:26:49'),
(10, 'CODICE___FISCALE', 'Massimo', 'Ranieri', 'Napoli', '74023', 'via Primo Levi', 68, '3926013815', 'massimo.ranieri@gmail.com', 'ciao', 'PARTITA_IVA', 'pro', '2022-07-09 10:26:49');
COMMIT;

INSERT INTO `servizio` (`idservizio`, `idprofessionista`, `idannuncio`, `compenso`, `descrizione`, `accettato`, `pagato`, `timestamp`) VALUES
(1, 1, 5, 400, 'Posso dare una mano', 0, 0, '2022-08-15 04:37:00'),
(2, 6, 7, 100, 'Posso dare una mano', 0, 0, '2022-08-20 07:38:15'),
(3, 6, 5, 700, 'Posso dare una mano con i pomodori', 0, 0, '2022-08-20 07:39:11');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
