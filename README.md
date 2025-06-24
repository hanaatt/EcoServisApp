EcoServis – Web aplikacija za prijavu i praćenje komunalnih problema

Opis projekta

**EcoServis** je web aplikacija razvijena kao deo projektnog zadatka. Omogućava građanima da prijave komunalne probleme (npr. javna rasveta, kontejneri, ulice) uz opis, sliku i lokaciju.

Nadležne službe imaju administratorski pregled i mogu pratiti status svake prijave, menjati status, dodavati komentare i upravljati svim unosima.

Funkcionalnosti

Korisnik
- Registracija i prijava korisnika (hashovana lozinka, SQL zaštita)
- Prijava problema sa:
  - Opisom
  - Lokacijom
  - Slikom
- Pregled svojih prijava
- Statusno praćenje (novo, u obradi, rešeno)

Administrator
- Pregled svih prijava
- Promena statusa problema
- Dodavanje komentara i ažuriranje unosa
- Statistika i pregled po kategorijama i lokacijama

Tehničke specifikacije

- **Baza podataka**: MySQL (tabele `ht_servisi`, `ht_korisnici`, `ht_kategorije`, `ht_tipovi`, itd.)
- **Arhitektura**: Model-View-Controller (MVC)
- **Backend**: PHP
- **Frontend**: HTML, CSS, JavaScript

Struktura direktorijuma



├── config/
│   └── db.php
├── controllers/
│   ├── AuthController.php
│   ├── HomeController.php
│   ├── DeviceController.php
│   └── ServisiController.php
├── models/
│   ├── User.php
│   ├── Servis.php
│   └── Device.php
├── public/
│   ├── css/
│   └── js/
├── uploads/
│   └── (slike problema)
├── views/
│   └── login.php
│   └── register.php
│   └── layout.php
│   └── home.php
│   ├── servisi/
│   │   ├── add.php
│   │   ├── list.php
│   │   ├── moji-servisi.php
│   │   └── statistika.php
│   │   ├── istorija.php
│   │   ├── edit.php
│   
├── index.php
├── routes.php


Pristupni podaci

Korisnik:
- Email: hana@gmail.com
- Lozinka: hana123

Admin:
- Email: admin@gmail.com
- Lozinka: admin

Link aplikacije:
https://usp2022.epizy.com/sup25/ht/
