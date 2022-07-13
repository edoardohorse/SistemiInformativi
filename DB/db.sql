CREATE TABLE utente
(
    idutente       INTEGER            NOT NULL AUTO_INCREMENT,
    codice_fiscale VARCHAR(16)        NOT NULL   DEFAULT 'CODICE___FISCALE',  /*TODO togliere il default e mettere lo unique */
    nome           VARCHAR(30)        NOT NULL,
    cognome        VARCHAR(30)        NOT NULL,
    citta          VARCHAR(50)        NOT NULL,
    cap            VARCHAR(5)         NOT NULL DEFAULT '74023',                     /*TODO togliere il default */
    indirizzo      VARCHAR(50)        NOT NULL,
    numero_civico  INTEGER            NOT NULL,
    telefono       VARCHAR(10)         NOT NULL DEFAULT '3926013815',               /*TODO togliere il default */
    email          VARCHAR(150)        NOT NULL  UNIQUE,
    pass           VARCHAR(30)        NOT NULL  DEFAULT 'ciao',                     /*TODO togliere il default */
    partita_iva    VARCHAR(11)        NULL      DEFAULT 'PARTITA_IVA',       /*TODO togliere il default e mettere lo unique */
    tipo           ENUM ('ins','pro') NOT NULL,
    timestamp      TIMESTAMP          DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (idutente)
);

CREATE TABLE annuncio(
    idannuncio          INTEGER     NOT NULL AUTO_INCREMENT,
    idinserzionista     INT         NOT NULL,
    titolo              VARCHAR(50) NOT NULL,
    descrizione         TEXT        NOT NULL,
    dimensione_giardino INT         NOT NULL,
    tempistica          INT         NOT NULL,
    tempistica_unita    ENUM('settimana','mese') DEFAULT 'mese',
    timestamp       TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (idannuncio),
    FOREIGN KEY (idinserzionista) REFERENCES utente(idutente),
    CHECK ( dimensione_giardino > 0 ),
    CHECK ( tempistica > 0 )
);

CREATE TABLE servizio(
    idservizio          INT     NOT NULL,
    idprofessionista    INT     NOT NULL,
    idannuncio          INT     NOT NULL,
    compenso            FLOAT   NOT NULL,
    descrizione         TEXT    NOT NULL,
    accettato           BOOLEAN NOT NULL DEFAULT FALSE,
    pagato              BOOLEAN NOT NULL DEFAULT FALSE,
    timestamp           TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (idservizio),
    FOREIGN KEY (idprofessionista) REFERENCES utente(idutente),
    FOREIGN KEY (idannuncio) REFERENCES annuncio(idannuncio),
    CHECK (compenso > 0)
);

CREATE TABLE recensione(
    idrecensore     INT     NOT NULL,
    idrecensito     INT     NOT NULL,
    idservizio      INT     NOT NULL,
    testo           TEXT    NOT NULL,

    PRIMARY KEY (idrecensore, idrecensito, idservizio),
    FOREIGN KEY (idrecensore) REFERENCES utente(idutente),
    FOREIGN KEY (idrecensito) REFERENCES utente(idutente),
    FOREIGN KEY (idservizio) REFERENCES servizio(idservizio)
);


CREATE VIEW inserzionista AS
SELECT idutente, codice_fiscale, nome, cognome, citta, cap, indirizzo, numero_civico, telefono, email, pass
FROM utente
WHERE tipo = 'ins';

CREATE VIEW professionista AS
SELECT idutente, codice_fiscale, nome, cognome, citta, cap, indirizzo, numero_civico, telefono, email, pass
FROM utente
WHERE tipo = 'pro';
