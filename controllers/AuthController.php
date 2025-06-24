<?php
require_once 'config/db.php';

class AuthController {

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ime = trim($_POST['ime']);
            $email = trim($_POST['email']);
            $lozinka = $_POST['lozinka'];

            global $conn;

            // Provera da li već postoji korisnik sa datim emailom
            $check = $conn->prepare("SELECT * FROM ht_korisnici WHERE ht_email = ?");
            $check->bind_param("s", $email);
            $check->execute();
            $result = $check->get_result();

            if ($result->num_rows > 0) {
                $error = "Korisnik sa tim emailom već postoji.";
                include 'views/register.php';
                return;
            }

            $hash = password_hash($lozinka, PASSWORD_DEFAULT);

            // Podrazumevano upisujemo kao korisnik (tip = 'korisnik')
            $stmt = $conn->prepare("INSERT INTO ht_korisnici (ht_ime, ht_email, ht_lozinka, ht_tip) VALUES (?, ?, ?, 'korisnik')");
            $stmt->bind_param("sss", $ime, $email, $hash);
            $stmt->execute();

            header("Location: https://usp2022.epizy.com/sup25/ht/");
            exit();
        }

        include 'views/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $lozinka = $_POST['lozinka'];

            global $conn;
            $stmt = $conn->prepare("SELECT * FROM ht_korisnici WHERE ht_email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if (password_verify($lozinka, $user['ht_lozinka'])) {
                    session_start();
                    $_SESSION['user'] = [
                        'id' => $user['ht_id'],
                        'ime' => $user['ht_ime'],
                        'email' => $user['ht_email'],
                        'tip' => $user['ht_tip'] ?? 'korisnik'
                    ];

                    header("Location: https://usp2022.epizy.com/sup25/ht/");
                    exit();
                } else {
                    $error = "Pogrešna lozinka.";
                }
            } else {
                $error = "Korisnik ne postoji.";
            }
        }

        include 'views/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: https://usp2022.epizy.com/sup25/ht/");
        exit();
    }
}
