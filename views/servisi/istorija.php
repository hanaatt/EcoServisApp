<?php require_once 'views/layout.php'; ?>

<h2>Istorija promene statusa</h2>

<?php if (empty($istorija)): ?>
    <p>Za ovu prijavu još uvek nije zabeležena nijedna promena statusa.</p>
<?php else: ?>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Status</th>
                <th>Komentar</th>
                <th>Datum izmene</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($istorija as $red): ?>
                <tr>
                    <td><?= htmlspecialchars($red['status_naziv']) ?></td>
                    <td><?= nl2br(htmlspecialchars($red['ht_komentar'])) ?></td>
                    <td><?= htmlspecialchars($red['ht_datum_promene']) ?: '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
