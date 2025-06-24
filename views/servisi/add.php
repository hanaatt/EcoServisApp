<?php require_once 'views/layout.php'; ?>

<a href="index.php" class="btn btn-secondary mb-3">
    &larr; Povratak na početnu
</a>

<h2>Prijavi novi komunalni problem</h2>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="ht_naslov" class="form-label">Naslov:</label>
        <input type="text" name="ht_naslov" id="ht_naslov" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="ht_opis" class="form-label">Opis problema:</label>
        <textarea name="ht_opis" id="ht_opis" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
        <label for="ht_kategorija_id" class="form-label">Kategorija:</label>
        <select name="ht_kategorija_id" id="ht_kategorija_id" class="form-select" required>
            <?php while ($k = $kategorije->fetch_assoc()): ?>
                <option value="<?= $k['ht_id'] ?>"><?= htmlspecialchars($k['ht_naziv']) ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="ht_slika" class="form-label">Slika (opcionalno):</label>
        <input type="file" name="ht_slika" id="ht_slika" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Pošalji prijavu</button>
</form>
