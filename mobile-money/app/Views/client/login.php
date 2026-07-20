<?= $this->extend('layout/client') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card-glass p-4">
            <h4 class="text-center mb-3"><i class="fas fa-sign-in-alt text-primary me-2"></i>Connexion Mobile Money</h4>
            <p class="text-muted text-center">Saisissez votre numéro de téléphone. Aucune inscription n'est nécessaire.</p>

            <form method="post" action="<?= site_url('client/login') ?>">
                <?= csrf_field() ?>
                <div class="mb-4">
                    <label class="form-label fw-semibold"><i class="fas fa-phone me-1"></i>Numéro de téléphone</label>
                    <input type="text" name="telephone" class="form-control form-control-lg" placeholder="0331234567" required>
                </div>
                <button type="submit" class="btn btn-primary btn-modern w-100" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);border:none;">
                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                </button>
            </form>

            <hr class="my-4">
            <p class="text-center mb-0">
                <a href="<?= site_url('operateur/login') ?>" class="small text-muted">
                    <i class="fas fa-user-shield me-1"></i>Accès opérateur (back-office)
                </a>
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>