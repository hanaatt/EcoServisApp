<h2>Izmena statusa servisa</h2>

<form method="POST" action="index.php?page=izmeni-status">
    <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">

    <label>Novi status:</label>
    <select name="ht_status_id" required>
        <?php foreach ($statusi as $s): ?>
            <option value="<?= $s['ht_id'] ?>" <?= ($detalji['ht_status_id'] == $s['ht_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($s['ht_naziv']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Komentar servisera:</label><br>
    <textarea name="ht_komentar" rows="4" cols="50"><?= htmlspecialchars($detalji['ht_komentar_servisera'] ?? '') ?></textarea><br><br>

    <input type="submit" value="Sačuvaj promene">
</form>

<a href="index.php?page=istorija&id=<?= $detalji['ht_id'] ?>">Prikaži istoriju izmene</a>
