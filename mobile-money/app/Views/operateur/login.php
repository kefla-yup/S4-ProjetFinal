<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-3 text-center">Connexion Opérateur</h4>

                <form method="post" action="<?= site_url('operateur/login') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Identifiant</label>
                        <input type="text" name="username" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Se connecter</button>
                </form>
                <p class="text-muted small mt-3 mb-0">Compte par défaut : admin / admin123</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
