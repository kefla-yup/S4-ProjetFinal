<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4"><i class="fas fa-chart-line me-2"></i>Situation des gains (frais perçus)</h4>

<div class="card-glass">
    <table class="table table-modern">
        <thead>
            <tr>
                <th>Type d'opération</th>
                <th>Nombre d'opérations</th>
                <th>Total des frais perçus</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalGeneral = 0; ?>
            <?php foreach ($gains as $g): ?>
                <?php $totalGeneral += $g['total_frais']; ?>
                <tr>
                    <td><?= esc($g['type_libelle']) ?></td>
                    <td><?= $g['nb_operations'] ?></td>
                    <td><?= formater_ariary($g['total_frais']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="table-dark">
                <th colspan="2">Total général</th>
                <th><?= formater_ariary($totalGeneral) ?></th>
            </tr>
        </tfoot>
    </table>
</div>

<?= $this->endSection() ?>