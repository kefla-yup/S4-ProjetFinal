<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4"><i class="fas fa-tachometer-alt me-2"></i>Tableau de bord</h4>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card-glass p-3 text-center" style="background:linear-gradient(135deg,#0f172a,#1e293b);color:#fff;">
            <h6><i class="fas fa-users me-2"></i>Comptes clients</h6>
            <h2 class="mb-0"><?= $nbClients ?></h2>
        </div>
    </div>
    <?php foreach ($gains as $g): ?>
        <div class="col-md-3">
            <div class="card-glass p-3 text-center">
                <h6><?= esc($g['type_libelle']) ?></h6>
                <p class="mb-1 text-muted"><i class="fas fa-exchange-alt me-1"></i><?= $g['nb_operations'] ?> opération(s)</p>
                <h4><?= formater_ariary($g['total_frais']) ?></h4>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row g-3 mt-3">
    <div class="col-md-3"><a class="btn btn-outline-dark-modern w-100" href="<?= site_url('operateur/prefixes') ?>"><i class="fas fa-tags me-2"></i>Gérer les préfixes</a></div>
    <div class="col-md-3"><a class="btn btn-outline-dark-modern w-100" href="<?= site_url('operateur/operations') ?>"><i class="fas fa-list-ul me-2"></i>Types & barèmes</a></div>
    <div class="col-md-3"><a class="btn btn-outline-dark-modern w-100" href="<?= site_url('operateur/situation/gains') ?>"><i class="fas fa-chart-line me-2"></i>Situation des gains</a></div>
    <div class="col-md-3"><a class="btn btn-outline-dark-modern w-100" href="<?= site_url('operateur/situation/clients') ?>"><i class="fas fa-users me-2"></i>Situation des clients</a></div>
</div>

<?= $this->endSection() ?>