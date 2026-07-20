<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4"><i class="fas fa-paper-plane me-2"></i>Situation des montants à envoyer à chaque opérateur</h4>
<p class="text-muted">
    Montants à régler (interconnexion) suite aux transferts effectués par nos clients
    vers les numéros des autres opérateurs.
</p>

<div class="card-glass">
    <table class="table table-modern">
        <thead>
            <tr>
                <th>Opérateur</th>
                <th>Nombre de transferts</th>
                <th>Montant total à envoyer</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            <?php if (empty($montants)): ?>
                <tr><td colspan="3" class="text-center text-muted py-4"><i class="fas fa-inbox me-2"></i>Aucun transfert vers un autre opérateur pour le moment.</td></tr>
            <?php endif; ?>
            <?php foreach ($montants as $m): ?>
                <?php $total += $m['total_montant']; ?>
                <tr>
                    <td><?= esc($m['operateur_nom']) ?></td>
                    <td><?= $m['nb_transferts'] ?></td>
                    <td><?= formater_ariary($m['total_montant']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="table-dark">
                <th colspan="2">Total général</th>
                <th><?= formater_ariary($total) ?></th>
            </tr>
        </tfoot>
    </table>
</div>

<?= $this->endSection() ?>