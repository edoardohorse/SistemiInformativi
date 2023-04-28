-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 27, 2023 alle 13:03
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.1.12

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `annuncio`
--

INSERT INTO `annuncio` (`idannuncio`, `idinserzionista`, `titolo`, `descrizione`, `luogo_lavoro`, `dimensione_giardino`, `tempistica`, `tempistica_unita`, `timestamp`, `scadenza`) VALUES
(1, 3, 'Pianta di tulipani', 'Vorrrei avere un giardino costituito da una piantagione di tulipani di vari colori nel retro di casa mia. ', 'Bari, via lazio n2', 5, 4, 'settimana', '2023-03-11 10:30:38', '2023-04-08 10:30:38'),
(2, 3, 'Parco Privato', 'Cerchiamo un giardiniere esperto per la cura di un grande parco privato. Richiesta comprovata esperienza nel settore e conoscenza delle tecniche di potatura, cura del prato e delle piante', 'Bari, via unità d\'italia 45', 45, 2, 'mese', '2023-03-11 10:43:08', '2023-05-06 10:43:08'),
(3, 3, 'Agronomo CERCASI', 'Stiamo cercando un agronomo per la coltivazione di una tenuta di campagna. Il candidato ideale avrà esperienza nella gestione di coltivazioni biologiche e nel monitoraggio delle condizioni atmosferiche.', 'Grottaglie, zona campagna 34', 1200, 3, 'settimana', '2023-03-11 10:45:35', '2023-04-01 10:45:35'),
(4, 3, 'Giardino verticale', 'Cerchiamo un giardiniere specializzato nella cura del verde, per la cura di giardini verticali e tettoie verdi. Richiesta esperienza nella selezione delle piante e nella gestione dell\'irrigazione.', 'Taranto, via cavour 12', 4, 1, 'settimana', '2023-03-11 10:47:20', '2023-03-18 10:47:20'),
(5, 3, 'Orto Bio', 'Stiamo cercando un agricoltore specializzato nella coltivazione di ortaggi biologici. Il candidato ideale dovrà avere conoscenze approfondite sulle tecniche di coltivazione e sulla gestione delle problematiche legate alla produzione biologica.', 'Fasano, paradi 10', 10, 6, 'settimana', '2023-03-11 10:48:33', '2023-04-22 10:48:33'),
(6, 3, 'Palazzina da risistemare', 'Cerchiamo un addetto alla manutenzione del verde per la cura di un grande complesso residenziale. Il candidato dovrà avere esperienza nella cura del prato, potatura degli alberi e coltivazione di piante ornamentali.', 'Taranto via bassi 56', 30, 2, 'mese', '2023-03-11 10:49:33', '2023-05-06 10:49:33'),
(7, 3, 'Paesaggista con esperienza', 'Abbiamo bisogno di un paesaggista per la progettazione di un giardino all\'italiana in un\'area residenziale di pregio. Il candidato ideale dovrà avere una solida esperienza nella progettazione di parchi e giardini di alto livello.', 'Bari Bob Dylan 89', 15, 2, 'settimana', '2023-03-11 10:50:57', '2023-03-25 10:50:57'),
(8, 3, 'Ulivi Pugliesi', 'Stiamo cercando un esperto in campo botanico per la piantagione di ulivi. Il candidato ideale dovrà avere conoscenze sulla selezione della varietà giusta, sulla preparazione del terreno e sulla cura della pianta per garantire una crescita sana e rigogliosa.', 'Lecce paul gasol 67', 34, 5, 'settimana', '2023-03-11 10:54:36', '2023-04-15 10:54:36'),
(9, 3, 'Betulla Innesto URGENTE', 'Cerchiamo un professionista in campo botanico per l\'innesto di una betulla nel nostro giardino. Il candidato ideale dovrà avere esperienza nella selezione delle piante madri, nella tecnica di innesto corretta e nella cura della pianta per garantire una crescita vigorosa.', 'molfetta luigi tenco 3', 12, 1, 'settimana', '2023-03-11 10:55:58', '2023-03-18 10:55:58'),
(10, 3, 'Quercia Malata aiuto', 'Stiamo cercando un esperto in campo botanico per la cura di una quercia malata nel nostro parco. Il candidato ideale dovrà avere conoscenze sulla diagnosi delle malattie delle querce, sulla cura della pianta e sulla prevenzione di futuri problemi per garantire la salute della pianta.', 'Cerignola Renzo Piano 98', 45, 1, 'settimana', '2023-03-11 10:57:28', '2023-03-18 10:57:28'),
(11, 6, 'Pulizia giardino', 'A causa di un temporale, i fiori e le piante che avevo in giardino si sono rovinate. Ho bisogno di una mano per sistemare il tutto.', 'Via G. Leopardi, 4, Lecce', 20, 1, 'settimana', '2023-03-25 09:32:14', '2023-04-01 09:32:14'),
(12, 7, 'Inseminazione di primo livello', 'Ho deciso di piantare nel mimo giardino pomodori e zucchine, avrei bisogno di una mano con l\'inseminazione di primo livello.', 'Piazzale degli scogli, 8, Foggia', 68, 1, 'mese', '2023-03-25 09:36:05', '2023-04-22 09:36:05'),
(13, 8, 'Tagliare legna per camino', 'Ho delle querce nella campagna, ho bisogno di qualcuno che mi tagli della legna per il prossimo inverno', 'Via dei caduti, 37, Bari', 100, 2, 'settimana', '2023-03-25 09:43:10', '2023-04-08 09:43:10'),
(14, 6, 'Installazione prato inglese', 'Necessito dell\'istallazione di un prato inglese nella mia casa in campagna. ', 'Via Giovanni Pascoli 23, Manduria', 400, 2, 'mese', '2023-03-28 10:16:39', '2023-05-23 10:16:39');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `notifica`
--

INSERT INTO `notifica` (`idnotifica`, `idutente`, `letta`, `messaggio`, `redirectUrl`, `timestamp`) VALUES
(1, 3, 0, 'Annuncio creato con successo: Pianta di tulipani', './annuncio/view?id=1&idnotifica=1', '2023-03-11 10:30:38'),
(2, 3, 0, 'Annuncio creato con successo: Parco Privato', './annuncio/view?id=2&idnotifica=2', '2023-03-11 10:43:08'),
(3, 3, 0, 'Annuncio creato con successo: Agronomo CERCASI', './annuncio/view?id=3&idnotifica=3', '2023-03-11 10:45:35'),
(4, 3, 0, 'Annuncio creato con successo: Giardino verticale', './annuncio/view?id=4&idnotifica=4', '2023-03-11 10:47:20'),
(5, 3, 0, 'Annuncio creato con successo: Orto Bio', './annuncio/view?id=5&idnotifica=5', '2023-03-11 10:48:33'),
(6, 3, 0, 'Annuncio creato con successo: Palazzina da risistemare', './annuncio/view?id=6&idnotifica=6', '2023-03-11 10:49:33'),
(7, 3, 0, 'Annuncio creato con successo: Paesaggista con esperienza', './annuncio/view?id=7&idnotifica=7', '2023-03-11 10:50:57'),
(8, 3, 0, 'Annuncio creato con successo: Ulivi Pugliesi', './annuncio/view?id=8&idnotifica=8', '2023-03-11 10:54:36'),
(9, 3, 0, 'Annuncio creato con successo: Betulla Innesto URGENTE', './annuncio/view?id=9&idnotifica=9', '2023-03-11 10:55:58'),
(10, 3, 0, 'Annuncio creato con successo: Quercia Malata aiuto', './annuncio/view?id=10&idnotifica=10', '2023-03-11 10:57:28'),
(11, 4, 0, 'Preventivo inviato: Quercia Malata aiuto', './annuncio/view?id=10&idnotifica=11', '2023-03-11 11:21:10'),
(12, 3, 0, 'Hai ricevuto un preventivo da parte di Andrea Pulito: Quercia Malata aiuto', './annuncio/view?id=10&idnotifica=12', '2023-03-11 11:21:10'),
(13, 4, 0, 'Preventivo inviato: Pianta di tulipani', './annuncio/view?id=1&idnotifica=13', '2023-03-11 11:23:41'),
(14, 3, 0, 'Hai ricevuto un preventivo da parte di Andrea Pulito: Pianta di tulipani', './annuncio/view?id=1&idnotifica=14', '2023-03-11 11:23:41'),
(15, 4, 0, 'Preventivo inviato: Giardino verticale', './annuncio/view?id=4&idnotifica=15', '2023-03-11 11:25:47'),
(16, 3, 0, 'Hai ricevuto un preventivo da parte di Andrea Pulito: Giardino verticale', './annuncio/view?id=4&idnotifica=16', '2023-03-11 11:25:47'),
(17, 2, 0, 'Preventivo inviato: Ulivi Pugliesi', './annuncio/view?id=8&idnotifica=17', '2023-03-11 11:26:59'),
(18, 3, 0, 'Hai ricevuto un preventivo da parte di Sebastiano Valli: Ulivi Pugliesi', './annuncio/view?id=8&idnotifica=18', '2023-03-11 11:26:59'),
(19, 2, 0, 'Preventivo inviato: Giardino verticale', './annuncio/view?id=4&idnotifica=19', '2023-03-11 11:30:04'),
(20, 3, 0, 'Hai ricevuto un preventivo da parte di Sebastiano Valli: Giardino verticale', './annuncio/view?id=4&idnotifica=20', '2023-03-11 11:30:04'),
(21, 2, 0, 'Preventivo inviato: Betulla Innesto URGENTE', './annuncio/view?id=9&idnotifica=21', '2023-03-11 11:31:15'),
(22, 3, 1, 'Hai ricevuto un preventivo da parte di Sebastiano Valli: Betulla Innesto URGENTE', './annuncio/view?id=9&idnotifica=22', '2023-03-11 11:31:15'),
(23, 3, 0, 'Preventivo accettato: Quercia Malata aiuto', './annuncio/view?id=10&idnotifica=23', '2023-03-11 11:35:55'),
(24, 4, 0, 'Domenico Petraroli ha accettato il tuo preventivo: Quercia Malata aiuto', './annuncio/view?id=10&idnotifica=24', '2023-03-11 11:35:55'),
(25, 3, 1, 'Preventivo pagato: Quercia Malata aiuto', './annuncio/view?id=10&idnotifica=25', '2023-03-11 11:37:16'),
(26, 4, 0, 'Domenico Petraroli ha pagato il tuo preventivo: Quercia Malata aiuto', './annuncio/view?id=10&idnotifica=26', '2023-03-11 11:37:16'),
(27, 3, 0, 'Recensione aggiunta: Quercia Malata aiuto', '/utente?id=4&idnotifica=27', '2023-03-11 11:38:47'),
(28, 6, 1, 'Annuncio creato con successo: Pulizia giardino', './annuncio/view?id=11&idnotifica=28', '2023-03-25 09:32:14'),
(29, 7, 0, 'Annuncio creato con successo: Inseminazione di primo livello', './annuncio/view?id=12&idnotifica=29', '2023-03-25 09:36:05'),
(30, 7, 0, 'Annuncio aggiornato con successo: Inseminazione di primo livello', './annuncio/view?id=12&idnotifica=30', '2023-03-25 09:37:23'),
(31, 8, 0, 'Annuncio creato con successo: Tagliare legna per camino', './annuncio/view?id=13&idnotifica=31', '2023-03-25 09:43:10'),
(32, 6, 0, 'Annuncio creato con successo: Installazione prato inglese', './annuncio/view?id=14&idnotifica=32', '2023-03-28 10:16:39'),
(33, 4, 1, 'Preventivo inviato: Installazione prato inglese', './annuncio/view?id=14&idnotifica=33', '2023-03-28 10:23:34'),
(34, 6, 1, 'Hai ricevuto un preventivo da parte di Andrea Pulito: Installazione prato inglese', './annuncio/view?id=14&idnotifica=34', '2023-03-28 10:23:34'),
(35, 6, 0, 'Preventivo accettato: Installazione prato inglese', './annuncio/view?id=14&idnotifica=35', '2023-03-28 10:27:17'),
(36, 4, 0, 'Paolo Maniero ha accettato il tuo preventivo: Installazione prato inglese', './annuncio/view?id=14&idnotifica=36', '2023-03-28 10:27:17'),
(37, 6, 0, 'Preventivo rifiutato: Installazione prato inglese', './annuncio/view?id=14&idnotifica=37', '2023-03-28 10:28:27'),
(38, 4, 0, 'Paolo Maniero ha rifiutato il tuo preventivo: Installazione prato inglese', './annuncio/view?id=14&idnotifica=38', '2023-03-28 10:28:27'),
(39, 6, 0, 'Preventivo accettato: Installazione prato inglese', './annuncio/view?id=14&idnotifica=39', '2023-03-28 10:28:58'),
(40, 4, 0, 'Paolo Maniero ha accettato il tuo preventivo: Installazione prato inglese', './annuncio/view?id=14&idnotifica=40', '2023-03-28 10:28:58'),
(41, 6, 0, 'Preventivo pagato: Installazione prato inglese', './annuncio/view?id=14&idnotifica=41', '2023-03-28 10:29:34'),
(42, 4, 1, 'Paolo Maniero ha pagato il tuo preventivo: Installazione prato inglese', './annuncio/view?id=14&idnotifica=42', '2023-03-28 10:29:34'),
(43, 6, 0, 'Recensione aggiunta: Installazione prato inglese', '/utente?id=4&idnotifica=43', '2023-03-28 10:30:13'),
(44, 3, 0, 'Preventivo accettato: Ulivi Pugliesi', './annuncio/view?id=8&idnotifica=44', '2023-04-03 10:41:06'),
(45, 2, 0, 'Domenico Petraroli ha accettato il tuo preventivo: Ulivi Pugliesi', './annuncio/view?id=8&idnotifica=45', '2023-04-03 10:41:06'),
(46, 3, 0, 'Preventivo pagato: Ulivi Pugliesi', './annuncio/view?id=8&idnotifica=46', '2023-04-03 11:23:44'),
(47, 2, 0, 'Domenico Petraroli ha pagato il tuo preventivo: Ulivi Pugliesi', './annuncio/view?id=8&idnotifica=47', '2023-04-03 11:23:44'),
(48, 3, 0, 'Annuncio creato con successo: ciccio', './annuncio/view?id=15&idnotifica=48', '2023-04-27 09:13:55'),
(49, 3, 0, 'Annuncio eliminato con successo: ciccio', '', '2023-04-27 09:14:13'),
(50, 3, 0, 'Preventivo accettato: Betulla Innesto URGENTE', './annuncio/view?id=9&idnotifica=50', '2023-04-27 09:19:30'),
(51, 2, 0, 'Domenico Petraroli ha accettato il tuo preventivo: Betulla Innesto URGENTE', './annuncio/view?id=9&idnotifica=51', '2023-04-27 09:19:30'),
(52, 3, 0, 'Preventivo rifiutato: Betulla Innesto URGENTE', './annuncio/view?id=9&idnotifica=52', '2023-04-27 09:19:33'),
(53, 2, 0, 'Domenico Petraroli ha rifiutato il tuo preventivo: Betulla Innesto URGENTE', './annuncio/view?id=9&idnotifica=53', '2023-04-27 09:19:33'),
(54, 3, 0, 'Preventivo accettato: Betulla Innesto URGENTE', './annuncio/view?id=9&idnotifica=54', '2023-04-27 09:23:28'),
(55, 2, 0, 'Domenico Petraroli ha accettato il tuo preventivo: Betulla Innesto URGENTE', './annuncio/view?id=9&idnotifica=55', '2023-04-27 09:23:28');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `preventivo`
--

INSERT INTO `preventivo` (`idpreventivo`, `idprofessionista`, `idannuncio`, `compenso`, `descrizione`, `accettato`, `pagato`, `timestamp`) VALUES
(1, 4, 10, 900, 'Visita diagnostica per identificare la malattia: € 150\r\nTrattamento della quercia con prodotto antiparassitario e antifungino: € 300\r\nPotatura selettiva delle parti malate della pianta: € 200\r\nFertilizzazione del terreno circostante per favorire la ripresa della pianta: € 100\r\nMonitoraggio della salute della pianta per 3 mesi: € 150', 1, 1, '2023-03-11 11:21:10'),
(2, 4, 1, 50, 'Pianificazione del giardino, disegno del layout e selezione delle varietà di tulipani: € 10\r\nPreparazione del terreno, rimozione di erbacce e sassi e aggiunta di fertilizzanti e compost: € 5\r\nAcquisto dei bulbi di tulipani: € 20\r\nPiantagione dei bulbi con attrezzature e tecniche speciali per garantire una crescita sana e rigogliosa: € 2\r\nIrrigazione e cura iniziale delle piantine di tulipani: € 12', 0, 0, '2023-03-11 11:23:41'),
(3, 4, 4, 2650, 'Visita preliminare del giardino verticale e della tettoia verde per una valutazione del lavoro necessario: € 100\r\nSelezione delle piante adatte al clima e alle condizioni di crescita del giardino verticale e della tettoia verde: € 500\r\nPreparazione del substrato e della struttura di sostegno per le piante: € 400\r\nPiantagione delle piante e installazione dell\'impianto di irrigazione automatico: € 800', 0, 0, '2023-03-11 11:25:47'),
(4, 2, 8, 1900, 'Visita preliminare del sito per una valutazione del lavoro necessario: € 100\r\nPreparazione del terreno, rimozione di erbacce e sassi e aggiunta di fertilizzanti e compost: € 500\r\nAcquisto degli ulivi, selezione della varietà giusta in base alle condizioni del suolo e del clima: € 300\r\nPiantagione degli ulivi con attrezzature e tecniche speciali per garantire una crescita sana e rigogliosa: € 800\r\nIrrigazione e cura iniziale degli ulivi: € 150', 1, 1, '2023-03-11 11:26:59'),
(5, 2, 4, 150, 'Visita preliminare del sito per una valutazione del lavoro necessario: € 50\r\nPulizia e manutenzione periodica del giardino verticale o della tettoia verde, inclusa la rimozione di foglie secche, la potatura e la pulizia del sistema di irrigazione: € 40', 0, 0, '2023-03-11 11:30:04'),
(6, 2, 9, 400, 'Visita preliminare del sito per una valutazione del lavoro necessario: € 100\r\nAcquisto della pianta di betulla: € 150\r\nPreparazione del terreno per l\'innesto della betulla, compresa la rimozione di eventuali piante o radici: € 200', 1, 0, '2023-03-11 11:31:15'),
(7, 4, 14, 2000, 'Gentile Sig. Maniero,\r\ndata la mia esperienza pluriennale nell\'ambito dell\'istallazione del prato inglese le chiedo cortesemente di visionare il mio preventivo. Attendo un suo gentile riscontro. ', 1, 1, '2023-03-28 10:23:34');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `recensione`
--

INSERT INTO `recensione` (`idrecensione`, `idrecensore`, `idrecensito`, `idpreventivo`, `descrizione`, `voto`, `timestamp`) VALUES
(1, 3, 4, 1, 'Ottimo lavoro, consiglio', 4, '2023-03-11 11:38:47'),
(2, 6, 4, 7, 'Lavoro ben eseguito, in tempi record. Consigliato a chiunque richiedesse alta qualità.', 5, '2023-03-28 10:30:13');

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
  `pass` varchar(32) NOT NULL DEFAULT 'ciao',
  `partita_iva` varchar(11) DEFAULT 'PARTITA_IVA',
  `tipo` enum('ins','pro') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`idutente`, `codice_fiscale`, `nome`, `cognome`, `citta`, `cap`, `indirizzo`, `numero_civico`, `telefono`, `email`, `pass`, `partita_iva`, `tipo`, `timestamp`) VALUES
(1, 'AB1234567890CD', 'Mario', 'Rossi', 'Roma', '99665', 'via marconi ', 15, '123456789', 'mariorossi@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', '', 'ins', '2023-01-14 10:03:03'),
(2, 'VLLSST97D14E506V', 'Sebastiano', 'Valli', 'Lecce', '73100', 'Via Nicola Valletta', 3, '3839474748', 'sebastiano.valli@hotmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'ABCDE1234', 'pro', '2023-03-11 09:39:16'),
(3, 'PTRDNC9797S09E20', 'Domenico', 'Petraroli', 'Grottaglie', '74023', 'via molise ', 1, '3209999999', 'domenicopetraroli@gmail.it', '6e6bc4e49dd477ebc98ef4046c067b5f', '', 'ins', '2023-03-11 10:27:15'),
(4, 'PLTANDRXXXXXXXXX', 'Andrea', 'Pulito', 'Talsano', '74XXX', 'Via SanSiro', 19, '3209999999', 'apsette@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', '89987923878', 'pro', '2023-03-11 11:14:14'),
(5, 'GDNMNP97E24V506V', 'Giandomenico', 'Monopoli', 'Grottaglie', '74023', 'Via delle Stelle', 24, '3206563345', 'giando.monopoli@libero.it', '6e6bc4e49dd477ebc98ef4046c067b5f', 'ASC435', 'pro', '2023-03-25 09:18:18'),
(6, 'PLSKMNA93DUR7506', 'Paolo', 'Maniero', 'Lecce', '73100', 'Via 25 Luglio', 2, '3470087345', 'paolo.maniero@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', '', 'ins', '2023-03-25 09:20:28'),
(7, 'FRCCLL85ER84E506', 'Francesco', 'Collo', 'Foggia', '71100', 'via G. Oberdan', 121, '3272947937', 'fran.collo@libero.it', '6e6bc4e49dd477ebc98ef4046c067b5f', '', 'ins', '2023-03-25 09:23:16'),
(8, 'MTTCER78U65ER543', 'Mattia', 'Cotone', 'Bari', '70100', 'Via Ernesto Moletto', 6, '3803634457', 'mattia78c@hotmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', '', 'ins', '2023-03-25 09:25:26'),
(9, 'LGIRCC86UE7736T', 'Luigi', 'Roccia', 'Brindisi', '72100', 'Viale Marche', 50, '3409872365', 'lroccia@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'AFGR6574', 'pro', '2023-03-25 09:27:42');

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
  ADD PRIMARY KEY (`idrecensione`),
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
  MODIFY `idannuncio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `notifica`
--
ALTER TABLE `notifica`
  MODIFY `idnotifica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT per la tabella `preventivo`
--
ALTER TABLE `preventivo`
  MODIFY `idpreventivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `recensione`
--
ALTER TABLE `recensione`
  MODIFY `idrecensione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `idutente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
