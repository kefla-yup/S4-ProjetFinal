<?= $this->extend('layout/client') ?>
<?= $this->section('content') ?>

<h4 class="mb-4"><i class="fas fa-sliders-h me-2"></i>Epargne</h4>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card-glass p-4">
            <h6><i class="fas fa-percent me-2"></i>Epargne sur les transferts vers tout opérateurs</h6>
         
            <form method="post" action="<?= site_url('client/epargne/updateEpargne') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-percent me-1"></i>epargne (%)</label>
                    <div class="input-group">
                        <input type="number" step="0.1" min="0" name="epargne"
                               class="form-control form-control-lg" value="<?= esc($epargne) ?>" required>
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