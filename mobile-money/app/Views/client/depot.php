<?= $this->extend('layout/client') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-3">💰 Dépôt</h4>
                <p class="text-muted">Le dépôt est automatique et sans frais.</p>

                <form method="post" action="<?= site_url('client/depot') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Montant à déposer (Ar)</label>
                        <input type="number" step="1" min="1" name="montant" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Valider le dépôt</button>
                    <a href="<?= site_url('client/dashboard') ?>" class="btn btn-link w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
