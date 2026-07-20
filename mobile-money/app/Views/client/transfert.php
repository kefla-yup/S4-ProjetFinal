<?= $this->extend('layout/client') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card-glass p-4">
            <h4 class="mb-3"><i class="fas fa-exchange-alt text-info me-2"></i>Transfert</h4>
            <p class="text-muted">
                <i class="fas fa-wallet me-1"></i>Solde disponible : <strong><?= formater_ariary($client['solde']) ?></strong><br>
                <i class="fas fa-info-circle me-1"></i>Des frais s'appliquent selon le barème de l'opérateur.
            </p>

            <form method="post" action="<?= site_url('client/transfert') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-user me-1"></i>Numéro du destinataire</label>
                    <input type="text" name="telephone_destinataire" class="form-control form-control-lg" placeholder="0371234567" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-coins me-1"></i>Montant à transférer (Ar)</label>
                    <input type="number" step="1" min="1" name="montant" class="form-control form-control-lg" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="inclureFraisRetrait" name="inclure_frais_retrait" value="1">
                    <label class="form-check-label" for="inclureFraisRetrait">
                        <i class="fas fa-hand-holding-usd me-1"></i> Inclure les frais de retrait du destinataire
                    </label>
                    <div class="form-text">Vous payez en plus le frais que le destinataire aurait à payer pour retirer ce montant.</div>
                </div>
                <button type="submit" class="btn btn-info-modern btn-modern w-100">
                    <i class="fas fa-check me-2"></i>Valider le transfert
                </button>
                <a href="<?= site_url('client/dashboard') ?>" class="btn btn-link w-100 mt-3 text-muted">
                    <i class="fas fa-times me-1"></i>Annuler
                </a>
            </form>
        </div>
        <p class="text-center text-muted small mt-2">
            <i class="fas fa-info-circle me-1"></i> Une commission additionnelle s'applique pour les transferts vers un numéro d'un autre opérateur.
        </p>
    </div>
</div>

<?= $this->endSection() ?>