<?= $this->extend('layout/client') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card-glass p-4">
            <h4 class="mb-3"><i class="fas fa-hand-holding-usd text-warning me-2"></i>Retrait</h4>
            <p class="text-muted">
                <i class="fas fa-wallet me-1"></i>Solde disponible : <strong><?= formater_ariary($client['solde']) ?></strong><br>
                <i class="fas fa-info-circle me-1"></i>Des frais s'appliquent selon le barème de l'opérateur.
            </p>

            <form method="post" action="<?= site_url('client/retrait') ?>">
                <?= csrf_field() ?>
                <div class="mb-4">
                    <label class="form-label fw-semibold"><i class="fas fa-coins me-1"></i>Montant à retirer (Ar)</label>
                    <input type="number" step="1" min="1" name="montant" class="form-control form-control-lg" required>
                </div>
                <button type="submit" class="btn btn-warning-modern btn-modern w-100">
                    <i class="fas fa-check me-2"></i>Valider le retrait
                </button>
                <a href="<?= site_url('client/dashboard') ?>" class="btn btn-link w-100 mt-3 text-muted">
                    <i class="fas fa-times me-1"></i>Annuler
                </a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>