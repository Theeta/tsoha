CREATE TABLE kayttaja
(
id serial primary key,
nimi varchar(50),
tunnus varchar(20),
salasana varchar(20)
);

CREATE TABLE luokka
(
id serial primary key,
nimi varchar(255),
kayttaja_id integer references kayttaja(id) on delete cascade on update cascade
);

CREATE TABLE tarkeysaste
(
id serial primary key,
nimi varchar(255),
kayttaja_id integer references kayttaja(id) on delete cascade on update cascade
);

CREATE TABLE tehtava
(
id serial primary key,
kuvaus varchar(1000),
kayttaja_id integer references kayttaja(id) on delete cascade on update cascade,
tarkeysaste_id integer references tarkeysaste(id) on delete cascade on update cascade
);

CREATE TABLE tehtavanluokat
(
tehtava_id integer references tehtava(id) on delete cascade on update cascade,
luokka_id integer references luokka(id) on delete cascade on update cascade,
primary key(tehtava_id, luokka_id)
);
