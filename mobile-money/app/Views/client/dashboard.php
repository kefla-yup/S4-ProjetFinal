<?= $this->extend('layout/client') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <!-- Carte solde -->
    <div class="col-md-4">
        <div class="card-solde">
            <h6><i class="fas fa-wallet me-2"></i>Solde actuel</h6>
            <h2><?= formater_ariary($client['solde']) ?></h2>
            <p class="small mb-0"><i class="fas fa-phone me-1"></i>Numéro : <?= esc($client['telephone']) ?></p>
        </div>

        <!-- Actions -->
        <div class="d-grid gap-3 mt-4">
            <a href="<?= site_url('client/depot') ?>" class="btn btn-success-modern btn-modern">
                <i class="fas fa-plus-circle"></i> Faire un dépôt
            </a>
            <a href="<?= site_url('client/retrait') ?>" class="btn btn-warning-modern btn-modern">
                <i class="fas fa-hand-holding-usd"></i> Faire un retrait
            </a>
            <a href="<?= site_url('client/transfert') ?>" class="btn btn-info-modern btn-modern">
                <i class="fas fa-exchange-alt"></i> Faire un transfert
            </a>
            <a href="<?= site_url('client/transfert-multiple') ?>" class="btn btn-outline-modern btn-modern">
                <i class="fas fa-share-alt"></i> Envoi multiple
            </a>
            <a href="<?= site_url('client/historique') ?>" class="btn btn-outline-modern btn-modern">
                <i class="fas fa-history"></i> Voir tout l'historique
            </a>
        </div>
    </div>

    <!-- Dernières opérations -->
    <div class="col-md-8">
        <div class="card-glass">
            <div class="card-header">
                <i class="fas fa-clock me-2"></i> Dernières opérations
            </div>
            <div class="table-responsive">
                <table class="table table-modern">
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
                            <tr><td colspan="5" class="text-center text-muted py-4"><i class="fas fa-inbox me-2"></i>Aucune opération pour le moment.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($dernieres as $t): ?>
                            <tr>
                                <td><?= esc($t['date_creation']) ?></td>
                                <td>
                                    <?= esc($t['type_libelle']) ?>
                                    <?= $t['destinataire_telephone'] ? ' <i class="fas fa-arrow-right mx-1"></i> ' . esc($t['destinataire_telephone']) : '' ?>
                                </td>
                                <td><?= formater_ariary($t['montant']) ?></td>
                                <td><?= formater_ariary($t['frais'] + ($t['commission_externe'] ?? 0)) ?></td>
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