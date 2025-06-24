<?php require_once 'views/layout.php'; ?>

<a href="index.php" class="btn btn-secondary mb-3">
    &larr; Povratak na početnu
</a>

<h2>Moje prijave</h2>

<?php if (empty($prijave)): ?>
    <p>Još uvek niste prijavili nijedan problem.</p>
<?php else: ?>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Naslov</th>
                <th>Kategorija</th>
                <th>Status</th>
                <th>Datum prijave</th>
                <th>Slika</th>
                <th>Akcija</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prijave as $pr): ?>
                <tr>
                    <td><?= htmlspecialchars($pr['ht_naslov']) ?></td>
                    <td><?= htmlspecialchars($pr['kategorija_naziv']) ?></td>
                    <td><?= htmlspecialchars($pr['status_naziv']) ?></td>
                    <td><?= htmlspecialchars($pr['ht_datum_prijave']) ?></td>
                    <td>
                        <?php if ($pr['ht_slika']): ?>
                            <a href="uploads/<?= htmlspecialchars($pr['ht_slika']) ?>" target="_blank">Pregled</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="index.php?page=istorija&id=<?= $pr['ht_id'] ?>" class="btn btn-sm btn-outline-secondary">Istorija</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
