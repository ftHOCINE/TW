SET client_encoding = 'UTF8';
CREATE TABLE categorie(
    nom_categorie character varying(40) NOT NULL
);
CREATE TABLE events(
    auteur character varying(40) NOT NULL,
    id  integer CONSTRAINT id_positif CHECK (id >0)  PRIMARY KEY UNIQUE, 
    titre character varying(50) NOT NULL,
    descr text,
    ou 	character varying(50) NOT NULL,
    categorie character varying(40) NOT NULL,
    quand date ,
    datecreation date,
    CONSTRAINT auteur_non_vide CHECK (((auteur)::text <> ''::text))
   
);		
CREATE TABLE users(
    pseudo character varying(40) NOT NULL PRIMARY KEY UNIQUE,
    password character varying(200) NOT NULL,
    secrete character varying(200) NOT NULL,
    reponce character varying(200) NOT NULL,
    CONSTRAINT login_non_vide CHECK (((pseudo)::text <> ''::text)),	
    CONSTRAINT password_non_vide CHECK (((password)::text <> ''::text))
    
);	
CREATE TABLE profils (
    
    pseudo character varying(40) NOT NULL  PRIMARY KEY UNIQUE,
    description text DEFAULT 'Aucune description ...',
    image text ,
    nbparticipations integer DEFAULT 0,
    nbparticipants integer DEFAULT 0,
    nbevenement integer DEFAULT 0,		
    CONSTRAINT login_non_vide CHECK (((pseudo)::text <> ''::text))
    
);
CREATE TABLE abonnement(
    auteur character varying(40) NOT NULL,
    id  integer CONSTRAINT id_positif CHECK (id >0)  PRIMARY KEY UNIQUE, 
    mot_cle character varying(50) NOT NULL,
    categorie character varying(40) NOT NULL,
    CONSTRAINT auteur_non_vide CHECK (((auteur)::text <> ''::text))
    
);
COMMENT ON TABLE categorie IS 'table des abonnements';
COMMENT ON TABLE categorie IS 'table des categories';
COMMENT ON TABLE events IS 'table des evenements';
COMMENT ON TABLE profils IS 'table des profils';
COMMENT ON TABLE users IS 'table des utilisateurs';

