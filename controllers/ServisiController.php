<?php
require_once 'models/Servis.php';

class ServisiController {

    public function prijavaProblema() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $korisnik_id = $_SESSION['user']['id'];
            $kategorija_id = $_POST['ht_kategorija_id'];
            $naslov = $_POST['ht_naslov'];
            $opis = $_POST['ht_opis'];
            $slika = null;

            if (isset($_FILES['ht_slika']) && $_FILES['ht_slika']['error'] === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['ht_slika']['tmp_name'];
                $original_name = basename($_FILES['ht_slika']['name']);
                $ext = pathinfo($original_name, PATHINFO_EXTENSION);
                $slika = uniqid('eco_', true) . '.' . $ext;
                move_uploaded_file($tmp_name, 'uploads/' . $slika);
            }

            Servis::kreirajPrijavu($korisnik_id, $kategorija_id, $naslov, $opis, $slika);

            header("Location: index.php?page=moje-prijave");
            exit();
        } else {
            $kategorije = Servis::dohvatiKategorije();
            include 'views/servisi/add.php';
        }
    }

    public function userList() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        global $conn;
        $korisnik_id = $_SESSION['user']['id'];

        $stmt = $conn->prepare("
            SELECT p.*, k.ht_naziv AS kategorija_naziv, s.ht_naziv AS status_naziv
            FROM ht_prijave p
            LEFT JOIN ht_kategorije k ON p.ht_kategorija_id = k.ht_id
            LEFT JOIN ht_statusi s ON p.ht_status_id = s.ht_id
            WHERE p.ht_korisnik_id = ?
            ORDER BY p.ht_datum_prijave DESC
        ");
        $stmt->bind_param("i", $korisnik_id);
        $stmt->execute();
        $rezultat = $stmt->get_result();
        $prijave = $rezultat->fetch_all(MYSQLI_ASSOC);

        include 'views/servisi/moji-servisi.php';
    }

    public function adminList() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['tip'] !== 'admin') {
            header("Location: index.php?page=login");
            exit();
        }

        global $conn;

        $query = "SELECT p.*, k.ht_naziv AS kategorija_naziv, s.ht_naziv AS status_naziv, 
                         u.ht_ime AS korisnik_ime
                  FROM ht_prijave p
                  LEFT JOIN ht_kategorije k ON p.ht_kategorija_id = k.ht_id
                  LEFT JOIN ht_statusi s ON p.ht_status_id = s.ht_id
                  LEFT JOIN ht_korisnici u ON p.ht_korisnik_id = u.ht_id
                  ORDER BY p.ht_datum_prijave DESC";

        $rezultat = $conn->query($query);
        $prijave = $rezultat->fetch_all(MYSQLI_ASSOC);

        include 'views/servisi/list.php';
    }

    public function azurirajStatus() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['tip'] !== 'admin') {
            header("Location: index.php?page=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $status_id = $_POST['ht_status_id'] ?? null;
            $komentar = $_POST['ht_komentar'] ?? null;

            Servis::updateStatus($id, $status_id, $komentar);

            header("Location: index.php?page=admin-servisi");
            exit();
        } else {
            if (!isset($_GET['id'])) {
                echo "Greška: nedostaje ID prijave.";
                return;
            }

            $id = intval($_GET['id']);
            $detalji = Servis::getById($id);
            $statusi = Servis::getAllStatuses();

            include 'views/servisi/edit.php';
        }
    }

    public function statistika() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['tip'] !== 'admin') {
            header("Location: index.php?page=login");
            exit();
        }

        $poStatusima = Servis::countByStatus();
        $poKategorijama = Servis::countByCategory();

        include 'views/servisi/statistika.php';
    }

    public function prikaziIstoriju() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        if (!isset($_GET['id'])) {
            echo "Greška: nedostaje ID prijave.";
            return;
        }

        $id = intval($_GET['id']);
        $detalji = Servis::getById($id);

        if (!$detalji) {
            echo "Greška: Prijava nije pronađena.";
            return;
        }

        $istorija = Servis::getIstorija($id);
        include 'views/servisi/istorija.php';
    }
}
