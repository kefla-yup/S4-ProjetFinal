<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4"><i class="fas fa-chart-line me-2"></i>Situation des gains (frais perçus)</h4>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card-glass">
            <div class="card-header"><i class="fas fa-home me-2"></i>Notre opérateur (retraits et transferts internes)</div>
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Type d'opération</th>
                        <th>Nombre</th>
                        <th>Total des frais</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totalInterne = 0; ?>
                    <?php if (empty($gainsInterne)): ?>
                        <tr><td colspan="3" class="text-center text-muted py-3"><i class="fas fa-inbox me-2"></i>Aucune opération.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($gainsInterne as $g): ?>
                        <?php $totalInterne += $g['total_gains']; ?>
                        <tr>
                            <td><?= esc($g['type_libelle']) ?></td>
                            <td><?= $g['nb_operations'] ?></td>
                            <td><?= formater_ariary($g['total_gains']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <th colspan="2">Total</th>
                        <th><?= formater_ariary($totalInterne) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-glass">
            <div class="card-header"><i class="fas fa-globe me-2"></i>Transferts vers les autres opérateurs</div>
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Type d'opération</th>
                        <th>Nombre</th>
                        <th>Frais barème</th>
                        <th>Commission</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totalExterne = 0; ?>
                    <?php if (empty($gainsExterne)): ?>
                        <tr><td colspan="5" class="text-center text-muted py-3"><i class="fas fa-inbox me-2"></i>Aucune opération.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($gainsExterne as $g): ?>
                        <?php $totalExterne += $g['total_gains']; ?>
                        <tr>
                            <td><?= esc($g['type_libelle']) ?></td>
                            <td><?= $g['nb_operations'] ?></td>
                            <td><?= formater_ariary($g['total_frais_base']) ?></td>
                            <td><?= formater_ariary($g['total_commission_externe']) ?></td>
                            <td><?= formater_ariary($g['total_gains']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <th colspan="4">Total</th>
                        <th><?= formater_ariary($totalExterne) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="card-glass mt-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <strong><i class="fas fa-coins me-2"></i>Gain total (interne + externe)</strong>
        <h4 class="mb-0"><?= formater_ariary($totalInterne + $totalExterne) ?></h4>
    </div>
</div>

<?= $this->endSection() ?>