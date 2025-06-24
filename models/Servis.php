<?php

class Servis {

    // NOVA PRIJAVA
    public static function kreirajPrijavu($korisnik_id, $kategorija_id, $naslov, $opis, $slika = null) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO ht_prijave 
            (ht_korisnik_id, ht_kategorija_id, ht_naslov, ht_opis, ht_slika, ht_status_id) 
            VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("iisss", $korisnik_id, $kategorija_id, $naslov, $opis, $slika);
        $stmt->execute();
    }

    public static function dohvatiKategorije() {
        global $conn;
        return $conn->query("SELECT * FROM ht_kategorije ORDER BY ht_naziv ASC");
    }

    public static function dohvatiStatuse() {
        global $conn;
        return $conn->query("SELECT * FROM ht_statusi ORDER BY ht_naziv ASC");
    }

    // LISTA PRIJAVA – ADMIN
    public static function getFiltered($status = '', $kategorija = '') {
        global $conn;

        $sql = "
            SELECT p.*, 
                   k.ht_ime AS korisnik_ime, 
                   kat.ht_naziv AS kategorija_naziv, 
                   s.ht_naziv AS status_naziv
            FROM ht_prijave p
            LEFT JOIN ht_korisnici k ON p.ht_korisnik_id = k.ht_id
            LEFT JOIN ht_kategorije kat ON p.ht_kategorija_id = kat.ht_id
            LEFT JOIN ht_statusi s ON p.ht_status_id = s.ht_id
            WHERE 1=1
        ";

        if (!empty($status)) {
            $sql .= " AND p.ht_status_id = " . intval($status);
        }

        if (!empty($kategorija)) {
            $sql .= " AND p.ht_kategorija_id = " . intval($kategorija);
        }

        $sql .= " ORDER BY p.ht_datum_prijave DESC";
        return $conn->query($sql);
    }

    // AŽURIRANJE STATUSA I KOMENTARA
    public static function updateStatus($id, $status_id, $komentar) {
        global $conn;

        $stmt = $conn->prepare("
            UPDATE ht_prijave 
            SET ht_status_id = ?, ht_komentar_servisera = ?, ht_datum_zavrsetka = NOW() 
            WHERE ht_id = ?");
        $stmt->bind_param("isi", $status_id, $komentar, $id);
        $stmt->execute();

        // Upisujemo u istoriju
        $stmt2 = $conn->prepare("
            INSERT INTO ht_istorija_statusa (ht_prijava_id, ht_status_id, ht_komentar, ht_datum_promene)
            VALUES (?, ?, ?, NOW())");
        $stmt2->bind_param("iis", $id, $status_id, $komentar);
        $stmt2->execute();
    }

    public static function setDateFinished($id) {
        global $conn;
        $stmt = $conn->prepare("UPDATE ht_prijave SET ht_datum_zavrsetka = NOW() WHERE ht_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // STATISTIKA
    public static function countAll() {
        global $conn;
        $result = $conn->query("SELECT COUNT(*) AS ukupno FROM ht_prijave");
        return $result->fetch_assoc()['ukupno'];
    }

    public static function countByStatus() {
        global $conn;
        return $conn->query("
            SELECT s.ht_naziv AS status, COUNT(*) AS broj 
            FROM ht_prijave p
            LEFT JOIN ht_statusi s ON p.ht_status_id = s.ht_id
            GROUP BY p.ht_status_id
        ");
    }

    public static function countByCategory() {
        global $conn;
        return $conn->query("
            SELECT k.ht_naziv AS kategorija, COUNT(*) AS broj
            FROM ht_prijave p
            LEFT JOIN ht_kategorije k ON p.ht_kategorija_id = k.ht_id
            GROUP BY p.ht_kategorija_id
        ");
    }

    // LISTA STATUSA I KATEGORIJA
    public static function getAllStatuses() {
        global $conn;
        return $conn->query("SELECT * FROM ht_statusi ORDER BY ht_naziv ASC");
    }

    public static function getAllCategories() {
        global $conn;
        return $conn->query("SELECT * FROM ht_kategorije ORDER BY ht_naziv ASC");
    }

    // DETALJI PRIJAVE
    public static function getById($id) {
        global $conn;
        $stmt = $conn->prepare("
            SELECT p.*, 
                   k.ht_ime AS korisnik_ime, 
                   kat.ht_naziv AS kategorija_naziv, 
                   s.ht_naziv AS status_naziv
            FROM ht_prijave p
            LEFT JOIN ht_korisnici k ON p.ht_korisnik_id = k.ht_id
            LEFT JOIN ht_kategorije kat ON p.ht_kategorija_id = kat.ht_id
            LEFT JOIN ht_statusi s ON p.ht_status_id = s.ht_id
            WHERE p.ht_id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // NOVO: ISTORIJA STATUSA
    public static function getIstorija($prijava_id) {
        global $conn;
        $stmt = $conn->prepare("
            SELECT i.*, s.ht_naziv AS status_naziv
            FROM ht_istorija_statusa i
            LEFT JOIN ht_statusi s ON i.ht_status_id = s.ht_id
            WHERE i.ht_prijava_id = ?
            ORDER BY i.ht_datum_promene DESC
        ");
        $stmt->bind_param("i", $prijava_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
