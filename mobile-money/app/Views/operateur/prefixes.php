<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4"><i class="fas fa-tags me-2"></i>Configuration des préfixes</h4>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card-glass p-4">
            <h6><i class="fas fa-plus-circle me-2"></i>Ajouter un préfixe</h6>
            <form method="post" action="<?= site_url('operateur/prefixes/add') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-code me-1"></i>Préfixe (ex: 033 ou 032)</label>
                    <input type="text" name="prefixe" class="form-control form-control-lg" maxlength="5" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-tag me-1"></i>Type</label>
                    <select name="type" class="form-select" id="typePrefixe" onchange="document.getElementById('champOperateurNom').style.display = this.value === 'externe' ? 'block' : 'none';">
                        <option value="interne">Notre opérateur (interne)</option>
                        <option value="externe">Autre opérateur (externe)</option>
                    </select>
                </div>
                <div class="mb-3" id="champOperateurNom" style="display:none;">
                    <label class="form-label fw-semibold"><i class="fas fa-building me-1"></i>Nom de l'opérateur externe</label>
                    <input type="text" name="operateur_nom" class="form-control" placeholder="ex: Opérateur A">
                </div>
                <button type="submit" class="btn btn-dark-modern w-100">
                    <i class="fas fa-plus me-2"></i>Ajouter
                </button>
            </form>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card-glass">
            <div class="card-header"><i class="fas fa-home me-2"></i>Préfixes de notre opérateur</div>
            <table class="table table-modern">
                <thead><tr><th>Préfixe</th><th>Statut</th><th class="text-end">Action</th></tr></thead>
                <tbody>
                    <?php if (empty($prefixesInternes)): ?>
                        <tr><td colspan="3" class="text-center text-muted py-3"><i class="fas fa-inbox me-2"></i>Aucun préfixe interne configuré.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($prefixesInternes as $p): ?>
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

    <div class="col-md-6">
        <div class="card-glass">
            <div class="card-header"><i class="fas fa-globe me-2"></i>Préfixes des autres opérateurs</div>
            <table class="table table-modern">
                <thead><tr><th>Préfixe</th><th>Opérateur</th><th>Statut</th><th class="text-end">Action</th></tr></thead>
                <tbody>
                    <?php if (empty($prefixesExternes)): ?>
                        <tr><td colspan="4" class="text-center text-muted py-3"><i class="fas fa-inbox me-2"></i>Aucun préfixe externe configuré.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($prefixesExternes as $p): ?>
                        <tr>
                            <td><?= esc($p['prefixe']) ?></td>
                            <td><?= esc($p['operateur_nom']) ?></td>
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