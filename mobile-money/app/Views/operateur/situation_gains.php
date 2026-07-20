<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4">Situation des gains (frais perçus)</h4>

<div class="card shadow-sm">
    <table class="table mb-0">
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
