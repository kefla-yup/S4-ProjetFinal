<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4">Situation des comptes clients</h4>

<div class="card shadow-sm">
    <table class="table table-striped mb-0">
        <thead>
            <tr>
                <th>Téléphone</th>
                <th>Solde</th>
                <th>Nombre de transactions</th>
                <th>Client depuis</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($clients)): ?>
                <tr><td colspan="4" class="text-center text-muted py-3">Aucun client pour le moment.</td></tr>
            <?php endif; ?>
            <?php foreach ($clients as $c): ?>
                <tr>
                    <td><?= esc($c['telephone']) ?></td>
                    <td><?= formater_ariary($c['solde']) ?></td>
                    <td><?= $c['nb_transactions'] ?></td>
                    <td><?= esc($c['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
