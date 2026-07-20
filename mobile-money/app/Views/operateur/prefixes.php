<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4">Configuration des préfixes valables</h4>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Ajouter un préfixe</h6>
                <form method="post" action="<?= site_url('operateur/prefixes/add') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Préfixe (ex: 033)</label>
                        <input type="text" name="prefixe" class="form-control" maxlength="5" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Ajouter</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">Préfixes configurés</div>
            <table class="table mb-0">
                <thead><tr><th>Préfixe</th><th>Statut</th><th></th></tr></thead>
                <tbody>
                    <?php foreach ($prefixes as $p): ?>
                        <tr>
                            <td><?= esc($p['prefixe']) ?></td>
                            <td><?= $p['actif'] ? '<span class="badge bg-success">Actif</span>' : '<span class="badge bg-secondary">Inactif</span>' ?></td>
                            <td class="text-end">
                                <a href="<?= site_url('operateur/prefixes/delete/' . $p['id']) ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Supprimer ce préfixe ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
