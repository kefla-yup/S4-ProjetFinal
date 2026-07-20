<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= esc($titre ?? 'Mobile Money - Back-office Opérateur') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">

</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="<?= site_url('operateur/dashboard') ?>">⚙️ Back-office Opérateur</a>
        <?php if (session()->get('operateur_id')): ?>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('operateur/prefixes') ?>">Préfixes</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('operateur/operations') ?>">Types & barèmes</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('operateur/situation/gains') ?>">Gains</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('operateur/situation/clients') ?>">Comptes clients</a></li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <span class="text-white me-3"><?= esc(session()->get('operateur_nom')) ?></span>
                <a href="<?= site_url('operateur/logout') ?>" class="btn btn-outline-light btn-sm">Déconnexion</a>
            </div>
        <?php endif; ?>
    </div>
</nav>

<div class="container-fluid px-4 py-4">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<script src="<?= base_url("bootstrap/js/bootstrap.bundle.min.js") ?>"></script>

</body>
</html>
