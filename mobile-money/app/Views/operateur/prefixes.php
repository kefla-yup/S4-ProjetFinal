<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4"><i class="fas fa-tags me-2"></i>Configuration des préfixes valables</h4>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card-glass p-4">
            <h6><i class="fas fa-plus-circle me-2"></i>Ajouter un préfixe</h6>
            <form method="post" action="<?= site_url('operateur/prefixes/add') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-code me-1"></i>Préfixe (ex: 033)</label>
                    <input type="text" name="prefixe" class="form-control form-control-lg" maxlength="5" required>
                </div>
                <button type="submit" class="btn btn-dark-modern w-100">
                    <i class="fas fa-plus me-2"></i>Ajouter
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card-glass">
            <div class="card-header"><i class="fas fa-list me-2"></i>Préfixes configurés</div>
            <table class="table table-modern">
                <thead><tr><th>Préfixe</th><th>Statut</th><th class="text-end">Action</th></tr></thead>
                <tbody>
                    <?php foreach ($prefixes as $p): ?>
                        <tr>
                            <td><?= esc($p['prefixe']) ?></td>
                            <td><?= $p['actif'] ? '<span class="badge bg-success badge-modern"><i class="fas fa-check-circle me-1"></i>Actif</span>' : '<span class="badge bg-secondary badge-modern"><i class="fas fa-minus-circle me-1"></i>Inactif</span>' ?></td>
                            <td class="text-end">
                                <a href="<?= site_url('operateur/prefixes/delete/' . $p['id']) ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Supprimer ce préfixe ?');">
                                    <i class="fas fa-trash-alt me-1"></i>Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>