-- Active: 1668104715953@@127.0.0.1@3306@portal

CREATE TABLE
    users(
        Identifiant INT AUTO_INCREMENT NOT NULL,
        login VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(100) NOT NULL,
        role VARCHAR(50) NOT NULL,
        first_name VARCHAR(50),
        last_name VARCHAR(50),
        nassance DATE,
        proffession VARCHAR(50),
        genre VARCHAR(50),
        pays VARCHAR(50),
        profile TEXT,
        ville VARCHAR(50),
        photo VARCHAR(50),
        level VARCHAR(50),
        tel VARCHAR(50),
        email VARCHAR(50),
        PRIMARY KEY(Identifiant),
        UNIQUE(tel),
        UNIQUE(email),
        created_at DATETIME DEFAULT NOW()
    );

CREATE TABLE
    experience(
        identifiant INT NOT NULL AUTO_INCREMENT,
        title VARCHAR(50) NOT NULL,
        type VARCHAR(50) NOT NULL,
        company VARCHAR(50) NOT NULL,
        location VARCHAR(50) NOT NULL,
        curently BOOLEAN,
        start_date DATE NOT NULL,
        end_date DATE,
        description TEXT(2500),
        identifiant_user INT NOT NULL,
        PRIMARY KEY(identifiant),
        FOREIGN KEY(identifiant_user) REFERENCES users(Identifiant)
    );

CREATE TABLE
    certificate(
        identifiant VARCHAR(50),
        name VARCHAR(50) NOT NULL,
        organization VARCHAR(50) NOT NULL,
        issue_date DATE NOT NULL,
        certificate_id VARCHAR(50),
        certificate_url VARCHAR(50),
        Identifiant_1 INT NOT NULL,
        PRIMARY KEY(identifiant),
        UNIQUE(certificate_id),
        UNIQUE(certificate_url),
        FOREIGN KEY(Identifiant_1) REFERENCES Users(Identifiant)
    );

CREATE TABLE
    contact(
        identifiant INT NOT NULL AUTO_INCREMENT,
        tel VARCHAR(50) NOT NULL,
        email VARCHAR(50),
        adresse VARCHAR(255) NOT NULL,
        fax VARCHAR(50),
        facebook VARCHAR(50),
        watsap VARCHAR(50),
        linkdin VARCHAR(50),
        twiter VARCHAR(50),
        identifiant_user INT NOT NULL,
        PRIMARY KEY(identifiant),
        UNIQUE(identifiant_user),
        UNIQUE(tel),
        UNIQUE(email),
        UNIQUE(facebook),
        UNIQUE(watsap),
        UNIQUE(linkdin),
        UNIQUE(twiter),
        FOREIGN KEY(identifiant_user) REFERENCES users(Identifiant)
    );

CREATE TABLE
    langues(
        identifiant INT,
        langages VARCHAR(50) NOT NULL,
        speak VARCHAR(50) NOT NULL,
        read VARCHAR(50) NOT NULL,
        write VARCHAR(50) NOT NULL,
        PRIMARY KEY(identifiant)
    );

CREATE TABLE
    recommandation(
        identifiant INT,
        text VARCHAR(255) NOT NULL,
        Identifiant_1 INT NOT NULL,
        PRIMARY KEY(identifiant),
        FOREIGN KEY(Identifiant_1) REFERENCES Users(Identifiant)
    );

CREATE TABLE
    formations(
        identifiant INT NOT NULL AUTO_INCREMENT,
        ecole VARCHAR(50) NOT NULL,
        diplome VARCHAR(50) NOT NULL,
        domaine VARCHAR(50) NOT NULL,
        debut DATE NOT NULL,
        curently BOOLEAN,
        fin DATE,
        resultat VARCHAR(50),
        activite TEXT,
        description TEXT,
        certificat VARCHAR(100),
        Identifiant_user INT NOT NULL,
        PRIMARY KEY(identifiant),
        FOREIGN KEY(Identifiant_user) REFERENCES users(Identifiant)
    );

CREATE TABLE
    skills(
        identifiant VARCHAR(50),
        name VARCHAR(50) NOT NULL,
        description TEXT,
        Identifiant_1 INT NOT NULL,
        PRIMARY KEY(identifiant),
        FOREIGN KEY(Identifiant_1) REFERENCES Users(Identifiant)
    );

CREATE TABLE
    project(
        identifiant VARCHAR(50),
        title VARCHAR(50) NOT NULL,
        curently LOGICAL,
        start_date DATE NOT NULL,
        end_date DATE,
        association VARCHAR(50),
        url VARCHAR(50),
        description TEXT,
        PRIMARY KEY(identifiant)
    );

CREATE TABLE
    volunteer(
        identifiant VARCHAR(50),
        Organization VARCHAR(50) NOT NULL,
        role VARCHAR(50) NOT NULL,
        cause VARCHAR(50) NOT NULL,
        start_date DATE NOT NULL,
        curently LOGICAL,
        end_date DATE,
        description TEXT NOT NULL,
        PRIMARY KEY(identifiant)
    );

CREATE TABLE
    publication(
        identifiant VARCHAR(50),
        title VARCHAR(50) NOT NULL,
        date_publication DATE,
        url VARCHAR(50) NOT NULL,
        description TEXT,
        Identifiant_1 INT NOT NULL,
        PRIMARY KEY(identifiant),
        FOREIGN KEY(Identifiant_1) REFERENCES Users(Identifiant)
    );

CREATE TABLE
    organization(
        identifiant VARCHAR(50),
        type VARCHAR(50) NOT NULL,
        name VARCHAR(50) NOT NULL,
        curently LOGICAL,
        start_date DATE,
        end_date DATE,
        description TEXT,
        PRIMARY KEY(identifiant)
    );

CREATE TABLE
    parler(
        Identifiant INT,
        identifiant_1 INT,
        PRIMARY KEY(Identifiant, identifiant_1),
        FOREIGN KEY(Identifiant) REFERENCES Users(Identifiant),
        FOREIGN KEY(identifiant_1) REFERENCES langues(identifiant)
    );

CREATE TABLE
    recommander(
        Identifiant INT,
        identifiant_1 INT,
        PRIMARY KEY(Identifiant, identifiant_1),
        FOREIGN KEY(Identifiant) REFERENCES Users(Identifiant),
        FOREIGN KEY(identifiant_1) REFERENCES recommandation(identifiant)
    );

CREATE TABLE
    travailer(
        Identifiant INT,
        identifiant_1 VARCHAR(50),
        PRIMARY KEY(Identifiant, identifiant_1),
        FOREIGN KEY(Identifiant) REFERENCES Users(Identifiant),
        FOREIGN KEY(identifiant_1) REFERENCES volunteer(identifiant)
    );

CREATE TABLE
    exercer(
        Identifiant INT,
        identifiant_1 VARCHAR(50),
        PRIMARY KEY(Identifiant, identifiant_1),
        FOREIGN KEY(Identifiant) REFERENCES Users(Identifiant),
        FOREIGN KEY(identifiant_1) REFERENCES project(identifiant)
    );

CREATE TABLE
    etre(
        Identifiant INT,
        identifiant_1 VARCHAR(50),
        PRIMARY KEY(Identifiant, identifiant_1),
        FOREIGN KEY(Identifiant) REFERENCES Users(Identifiant),
        FOREIGN KEY(identifiant_1) REFERENCES organization(identifiant)
    );

ALTER TABLE formations
ADD
    COLUMN created_at DATETIME NOT NULL DEFAULT NOW();

ALTER TABLE users CHANGE nassance birthday DATE;

ALTER TABLE users DROP COLUMN email, DROP COLUMN tel;

ALTER TABLE experience DROP COLUMN curently;

ALTER TABLE contact DROP COLUMN fax;

DROP TABLE contact;

ALTER TABLE contact ADD COLUMN instagram VARCHAR(100) AFTER twiter;

ALTER TABLE contact CHANGE twiter twitter VARCHAR(100);

ALTER TABLE experience CHANGE company companie VARCHAR(100);