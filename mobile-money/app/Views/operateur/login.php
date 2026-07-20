<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card-glass p-4">
            <h4 class="text-center mb-3"><i class="fas fa-user-shield me-2"></i>Connexion Opérateur</h4>

            <form method="post" action="<?= site_url('operateur/login') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-user me-1"></i>Identifiant</label>
                    <input type="text" name="username" class="form-control form-control-lg" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold"><i class="fas fa-lock me-1"></i>Mot de passe</label>
                    <input type="password" name="password" class="form-control form-control-lg" required>
                </div>
                <button type="submit" class="btn btn-dark-modern w-100">
                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                </button>
            </form>
            <p class="text-muted small mt-3 mb-0"><i class="fas fa-info-circle me-1"></i>Compte par défaut : admin / admin123</p>
            <p class="text-center mb-0">
                <a href="<?= site_url('client/login') ?>" class="small text-muted">
                    <i class="fas fa-user-shield me-1"></i>Accès Client (Front-office)
                </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>