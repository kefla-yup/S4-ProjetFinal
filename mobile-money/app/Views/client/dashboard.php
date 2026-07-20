<?= $this->extend('layout/client') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-bg-primary shadow-sm">
            <div class="card-body">
                <h6 class="card-title">Solde actuel</h6>
                <h2 class="mb-0"><?= formater_ariary($client['solde']) ?></h2>
                <p class="mb-0 small">Numéro : <?= esc($client['telephone']) ?></p>
            </div>
        </div>

        <div class="d-grid gap-2 mt-3">
            <a href="<?= site_url('client/depot') ?>" class="btn btn-success">💰 Faire un dépôt</a>
            <a href="<?= site_url('client/retrait') ?>" class="btn btn-warning">💵 Faire un retrait</a>
            <a href="<?= site_url('client/transfert') ?>" class="btn btn-info text-white">🔁 Faire un transfert</a>
            <a href="<?= site_url('client/historique') ?>" class="btn btn-outline-secondary">📜 Voir tout l'historique</a>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">Dernières opérations</div>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Frais</th>
                            <th>Solde après</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($dernieres)): ?>
                            <tr><td colspan="5" class="text-center text-muted py-3">Aucune opération pour le moment.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($dernieres as $t): ?>
                            <tr>
                                <td><?= esc($t['date_creation']) ?></td>
                                <td><?= esc($t['type_libelle']) ?><?= $t['destinataire_telephone'] ? ' → ' . esc($t['destinataire_telephone']) : '' ?></td>
                                <td><?= formater_ariary($t['montant']) ?></td>
                                <td><?= formater_ariary($t['frais']) ?></td>
                                <td><?= formater_ariary($t['solde_apres']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
