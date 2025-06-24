<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ime = trim($_POST['ime']);
    $email = trim($_POST['email']);
    $lozinka = $_POST['lozinka'];

    $stmt = $conn->prepare("SELECT * FROM ht_korisnici WHERE ht_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $rez = $stmt->get_result();

    if ($rez->num_rows > 0) {
        $greska = "Korisnik sa tim emailom već postoji.";
    } else {
        $hashLozinka = password_hash($lozinka, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO ht_korisnici (ht_ime, ht_email, ht_lozinka) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $ime, $email, $hashLozinka);
        $stmt->execute();

        $_SESSION['user'] = [
            'id' => $stmt->insert_id,
            'ime' => $ime,
            'email' => $email,
            'tip' => 'korisnik'
        ];

        header("Location: index.php?page=moje-prijave");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 450px;">
        <h3 class="text-center mb-4">Registracija korisnika</h3>

        <?php if (isset($greska)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($greska) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=register">
            <div class="mb-3">
                <label for="ime" class="form-label">Ime i prezime</label>
                <input type="text" id="ime" name="ime" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email adresa</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="lozinka" class="form-label">Lozinka</label>
                <input type="password" id="lozinka" name="lozinka" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Registruj se</button>
        </form>

        <div class="mt-3 text-center">
            <small>Već imate nalog? <a href="index.php?page=login">Prijavite se</a></small>
        </div>
    </div>
</div>

</body>
</html>
