<?= $this->extend('layout/client') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>📜 Historique de mes opérations</span>
        <a href="<?= site_url('client/dashboard') ?>" class="btn btn-sm btn-outline-secondary">Retour</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Détail</th>
                    <th>Montant</th>
                    <th>Frais</th>
                    <th>Solde après</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transactions)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-3">Aucune opération pour le moment.</td></tr>
                <?php endif; ?>
                <?php foreach ($transactions as $t): ?>
                    <tr>
                        <td><?= esc($t['date_creation']) ?></td>
                        <td><?= esc($t['type_libelle']) ?></td>
                        <td><?= $t['destinataire_telephone'] ? 'Vers ' . esc($t['destinataire_telephone']) : '-' ?></td>
                        <td><?= formater_ariary($t['montant']) ?></td>
                        <td><?= formater_ariary($t['frais']) ?></td>
                        <td><?= formater_ariary($t['solde_apres']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
