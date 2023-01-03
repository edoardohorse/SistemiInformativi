USE giardinaggio;

CREATE TABLE utente
(
    idutente       INT            NOT NULL AUTO_INCREMENT,
    codice_fiscale VARCHAR(16)        NOT NULL   DEFAULT 'CODICE___FISCALE',  /*TODO togliere il default e mettere lo unique */
    nome           VARCHAR(30)        NOT NULL,
    cognome        VARCHAR(30)        NOT NULL,
    citta          VARCHAR(50)        NOT NULL,
    cap            VARCHAR(5)         NOT NULL DEFAULT '74023',                     /*TODO togliere il default */
    indirizzo      VARCHAR(50)        NOT NULL,
    numero_civico  INT            NOT NULL,
    telefono       VARCHAR(10)         NOT NULL DEFAULT '3926013815',               /*TODO togliere il default */
    email          VARCHAR(150)        NOT NULL  UNIQUE,
    pass           VARCHAR(30)        NOT NULL  DEFAULT 'ciao',                     /*TODO togliere il default */
    partita_iva    VARCHAR(11)        NULL      DEFAULT 'PARTITA_IVA',       /*TODO togliere il default e mettere lo unique */
    tipo           ENUM ('ins','pro') NOT NULL,
    timestamp      TIMESTAMP          DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (idutente)
);

CREATE TABLE annuncio(
    idannuncio          INT     NOT NULL AUTO_INCREMENT,
    idinserzionista     INT         NOT NULL,
    titolo              VARCHAR(50) NOT NULL,
    descrizione         TEXT        NOT NULL,
    luogo_lavoro        TEXT        NOT NULL,
    dimensione_giardino INT         NOT NULL,
    tempistica          INT         NOT NULL,
    tempistica_unita    ENUM('settimana','mese') DEFAULT 'mese',
    timestamp           TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    scadenza            TIMESTAMP,

    PRIMARY KEY (idannuncio),
    FOREIGN KEY (idinserzionista) REFERENCES utente(idutente),
    CHECK ( dimensione_giardino > 0 ),
    CHECK ( tempistica > 0 )
);

CREATE TABLE preventivo(
    idpreventivo          INT     NOT NULL AUTO_INCREMENT,
    idprofessionista    INT     NOT NULL,
    idannuncio          INT     NOT NULL,
    compenso            FLOAT   NOT NULL,
    descrizione         TEXT    NOT NULL,
    accettato           BOOLEAN NOT NULL DEFAULT FALSE,
    pagato              BOOLEAN NOT NULL DEFAULT FALSE,
    timestamp           TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (idpreventivo),
    FOREIGN KEY (idprofessionista)  REFERENCES utente(idutente),
    FOREIGN KEY (idannuncio)        REFERENCES annuncio(idannuncio),
    CHECK (compenso > 0)
);

CREATE OR REPLACE TABLE recensione(
    idrecensione INT NOT NULL AUTO_INCREMENT,
    idrecensore  INT NOT NULL,
    idrecensito  INT NOT NULL,
    idpreventivo   INT NOT NULL,
    descrizione  VARCHAR(500) NOT NULL,
    voto         INT NOT NULL DEFAULT 1,
    timestamp   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (idrecensione),
    FOREIGN KEY (idrecensore) REFERENCES utente(idutente),
    FOREIGN KEY (idrecensito) REFERENCES utente(idutente),
    FOREIGN KEY (idpreventivo)  REFERENCES preventivo(idpreventivo),
    CHECK (voto >= 1 AND voto <= 5)
);

CREATE OR REPLACE TABLE  notifica(
    idnotifica  INT NOT NULL AUTO_INCREMENT,
    idutente    INT NOT NULL ,
    letta       BOOLEAN NOT NULL DEFAULT FALSE,
    messaggio   VARCHAR(500) NOT NULL,
    redirectUrl VARCHAR(500) NOT NULL,
    timestamp   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (idnotifica),
    FOREIGN KEY (idutente) REFERENCES utente(idutente)
)