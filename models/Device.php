<?php
require_once 'config/db.php';

class Device {
    public static function getByUser($user_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM nt_uredjaji WHERE korisnik_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function create($naziv, $model, $serijski, $korisnik_id) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO nt_uredjaji (naziv, model, serijski_broj, korisnik_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $naziv, $model, $serijski, $korisnik_id);
        return $stmt->execute();
    }
}
?>
