insert into kayttaja (nimi, tunnus, salasana)
values('Olli', 'testi', 'salasana');

insert into kayttaja (nimi, tunnus, salasana)
values('Matti', 'masa', 'sala');

insert into kayttaja (nimi, tunnus, salasana)
values('Ville', 'tunnari', 'sana');

insert into luokka(nimi, kayttaja_id)
values('kotityot',1);

insert into tarkeysaste(nimi, kayttaja_id)
values('turha',1);

insert into tehtava(kuvaus, kayttaja_id, tarkeysaste_id)
values('tiskaa',1,1);

insert into tehtavanluokat(tehtava_id, luokka_id)
values(1,1);