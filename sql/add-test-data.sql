insert into kayttaja (nimi, tunnus, salasana)
values('Olli', 'testi', 'salasana');

insert into kayttaja (nimi, tunnus, salasana)
values('Matti', 'masa', 'sala');

insert into kayttaja (nimi, tunnus, salasana)
values('Ville', 'tunnari', 'sana');

insert into luokka(nimi, kayttaja_id)
values('kotityot',1);

insert into luokka(nimi, kayttaja_id)
values('koulutyöt',1);

insert into luokka(nimi, kayttaja_id)
values('kotityot',2);

insert into tarkeysaste(nimi, kayttaja_id)
values('turha',1);

insert into tarkeysaste(nimi, kayttaja_id)
values('tärkeä',1);

insert into tarkeysaste(nimi, kayttaja_id)
values('unohda koko juttu',1);

insert into tarkeysaste(nimi, kayttaja_id)
values('erittäin kiireellinen',1);

insert into tarkeysaste(nimi, kayttaja_id)
values('turha',2);

insert into tarkeysaste(nimi, kayttaja_id)
values('tärkeä',2);

insert into tehtava(kuvaus, kayttaja_id, tarkeysaste_id)
values('tiskaa',1,1);

insert into tehtava(kuvaus, kayttaja_id, tarkeysaste_id)
values('leivo',1,3);

insert into tehtava(kuvaus, kayttaja_id, tarkeysaste_id)
values('siivoa',1,2);

insert into tehtava(kuvaus, kayttaja_id, tarkeysaste_id)
values('nuku',1,1);

insert into tehtava(kuvaus, kayttaja_id, tarkeysaste_id)
values('käy kaupassa',2,2);

insert into tehtavanluokat(tehtava_id, luokka_id)
values(1,1);

insert into tehtavanluokat(tehtava_id, luokka_id)
values(2,1);