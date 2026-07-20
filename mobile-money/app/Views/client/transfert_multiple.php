<?= $this->extend('layout/client') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card-glass p-4">
            <h4 class="mb-3"><i class="fas fa-share-alt text-info me-2"></i>Envoi multiple</h4>
            <p class="text-muted">
                <i class="fas fa-wallet me-1"></i>Solde disponible : <strong><?= formater_ariary($client['solde']) ?></strong><br>
                Le montant total saisi sera <strong>divisé équitablement</strong> entre tous les numéros indiqués.
                Des frais s'appliquent à chaque envoi selon le barème (et une commission additionnelle pour les autres opérateurs).
            </p>

            <form method="post" action="<?= site_url('client/transfert-multiple') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-list me-1"></i>Numéros des destinataires (un par ligne, ou séparés par une virgule)</label>
                    <textarea name="numeros" class="form-control" rows="5" placeholder="0331234567&#10;0372345678&#10;0329876543" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-coins me-1"></i>Montant total à répartir (Ar)</label>
                    <input type="number" step="1" min="1" name="montant_total" class="form-control form-control-lg" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="inclureFraisRetraitMulti" name="inclure_frais_retrait" value="1">
                    <label class="form-check-label" for="inclureFraisRetraitMulti">
                        <i class="fas fa-hand-holding-usd me-1"></i> Inclure les frais de retrait de chaque destinataire
                    </label>
                </div>
                <button type="submit" class="btn btn-info-modern btn-modern w-100">
                    <i class="fas fa-check me-2"></i>Valider l'envoi multiple
                </button>
                <a href="<?= site_url('client/dashboard') ?>" class="btn btn-link w-100 mt-3 text-muted">
                    <i class="fas fa-times me-1"></i>Annuler
                </a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>