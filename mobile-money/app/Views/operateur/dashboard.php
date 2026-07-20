<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4">Tableau de bord</h4>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-bg-secondary shadow-sm">
            <div class="card-body">
                <h6>Comptes clients</h6>
                <h2><?= $nbClients ?></h2>
            </div>
        </div>
    </div>
    <?php foreach ($gains as $g): ?>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6><?= esc($g['type_libelle']) ?></h6>
                    <p class="mb-1 text-muted"><?= $g['nb_operations'] ?> opération(s)</p>
                    <h4><?= formater_ariary($g['total_frais']) ?></h4>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row mt-3">
    <div class="col-md-3 mb-2"><a class="btn btn-outline-dark w-100" href="<?= site_url('operateur/prefixes') ?>">Gérer les préfixes</a></div>
    <div class="col-md-3 mb-2"><a class="btn btn-outline-dark w-100" href="<?= site_url('operateur/operations') ?>">Types & barèmes</a></div>
    <div class="col-md-3 mb-2"><a class="btn btn-outline-dark w-100" href="<?= site_url('operateur/situation/gains') ?>">Situation des gains</a></div>
    <div class="col-md-3 mb-2"><a class="btn btn-outline-dark w-100" href="<?= site_url('operateur/situation/clients') ?>">Situation des clients</a></div>
</div>

<?= $this->endSection() ?>
