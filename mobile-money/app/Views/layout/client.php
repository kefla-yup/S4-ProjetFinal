<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= esc($titre ?? 'Mobile Money - Espace Client') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('client/dashboard') ?>">📱 Mobile Money</a>
        <?php if (session()->get('client_id')): ?>
            <div class="d-flex align-items-center">
                <span class="text-white me-3"><?= esc(session()->get('client_telephone')) ?></span>
                <a href="<?= site_url('client/logout') ?>" class="btn btn-outline-light btn-sm">Déconnexion</a>
            </div>
        <?php endif; ?>
    </div>
</nav>

<div class="container py-4">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
