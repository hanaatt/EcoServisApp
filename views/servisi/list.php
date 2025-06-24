<?php require_once 'views/layout.php'; ?>

<a href="index.php" class="btn btn-secondary mb-3">← Povratak na početnu</a>
<h2>Sve prijave (EcoServis)</h2>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Korisnik</th>
            <th>Kategorija</th>
            <th>Naslov</th>
            <th>Opis</th>
            <th>Status</th>
            <th>Slika</th>
            <th>Datum prijave</th>
            <th>Akcija</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($prijave as $prijava): ?>
            <tr>
                <td><?= $prijava['ht_id'] ?></td>
                <td><?= htmlspecialchars($prijava['korisnik_ime']) ?></td>
                <td><?= htmlspecialchars($prijava['kategorija_naziv']) ?></td>
                <td><?= htmlspecialchars($prijava['ht_naslov']) ?></td>
                <td><?= nl2br(htmlspecialchars($prijava['ht_opis'])) ?></td>
                <td><?= htmlspecialchars($prijava['status_naziv']) ?></td>
                <td>
                    <?php if ($prijava['ht_slika']): ?>
                        <a href="uploads/<?= htmlspecialchars($prijava['ht_slika']) ?>" target="_blank">Pogledaj</a>
                    <?php else: ?>
                        Nema slike
                    <?php endif; ?>
                </td>
                <td><?= $prijava['ht_datum_prijave'] ?></td>
                <td>
                    <a href="index.php?page=izmeni-status&id=<?= $prijava['ht_id'] ?>" class="btn btn-sm btn-outline-primary">Izmeni</a>
                    <a href="index.php?page=istorija&id=<?= $prijava['ht_id'] ?>" class="btn btn-sm btn-outline-secondary">Istorija</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
