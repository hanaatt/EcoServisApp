<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $lozinka = $_POST['lozinka'];

    $stmt = $conn->prepare("SELECT * FROM ht_korisnici WHERE ht_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $rez = $stmt->get_result();

    if ($rez->num_rows === 1) {
        $korisnik = $rez->fetch_assoc();

        if (password_verify($lozinka, $korisnik['ht_lozinka'])) {
            $_SESSION['user'] = [
                'id' => $korisnik['ht_id'],
                'ime' => $korisnik['ht_ime'],
                'email' => $korisnik['ht_email'],
                'tip' => $korisnik['ht_tip'] ?? 'korisnik'
            ];
            $_SESSION['email'] = $korisnik['ht_email'];

            header("Location: index.php?page=moje-prijave");
            exit;
        } else {
            $greska = "Pogrešna lozinka.";
        }
    } else {
        $greska = "Korisnik nije pronađen.";
    }
}
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Prijava</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Prijava korisnika</h3>

        <?php if (isset($greska)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($greska) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email adresa</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="lozinka" class="form-label">Lozinka</label>
                <input type="password" name="lozinka" id="lozinka" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Prijavi se</button>
        </form>

        <div class="mt-3 text-center">
            <small>Nemate nalog? <a href="index.php?page=register">Registrujte se</a></small>
        </div>
    </div>
</div>

</body>
</html>
