<?= $this->extend('layout/client') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-3 text-center">Connexion Mobile Money</h4>
                <p class="text-muted text-center">Saisissez votre numéro de téléphone. Aucune inscription n'est nécessaire.</p>

                <form method="post" action="<?= site_url('client/login') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Numéro de téléphone</label>
                        <input type="text" name="telephone" class="form-control" placeholder="0331234567" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>

                <hr>
                <p class="text-center mb-0">
                    <a href="<?= site_url('operateur/login') ?>" class="small">Accès opérateur (back-office)</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
