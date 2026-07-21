<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4"><i class="fas fa-sliders-h me-2"></i>Promotion</h4>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card-glass p-4">
            <h6><i class="fas fa-percent me-2"></i>Promotion sur les transferts vers tout opérateurs</h6>
            <p class="text-muted small">
                Ce pourcentage est prélevé <strong>en plus</strong> du barème de frais normal,
                uniquement lorsqu'un client transfère de l'argent vers un numéro d'un autre opérateur.
            </p>
            <form method="post" action="<?= site_url('operateur/promotion/updatePromotion') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-percent me-1"></i>Promotion (%)</label>
                    <div class="input-group">
                        <input type="number" step="0.1" min="0" name="promotion_pourcentage"
                               class="form-control form-control-lg" value="<?= esc($promotion) ?>" required>
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark-modern w-100">
                    <i class="fas fa-save me-2"></i>Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>