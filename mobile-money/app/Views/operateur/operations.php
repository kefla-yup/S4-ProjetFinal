<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4">Types d'opération & barèmes de frais</h4>

<div class="row mb-4">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Ajouter une tranche de frais</h6>
                <form method="post" action="<?= site_url('operateur/operations/bareme/add') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Type d'opération</label>
                        <select name="type_operation_id" class="form-select" required>
                            <?php foreach ($types as $t): ?>
                                <?php if ($t['code'] !== 'depot'): ?>
                                    <option value="<?= $t['id'] ?>"><?= esc($t['libelle']) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Montant min (Ar)</label>
                            <input type="number" step="1" name="montant_min" class="form-control" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Montant max (Ar)</label>
                            <input type="number" step="1" name="montant_max" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Frais (Ar)</label>
                        <input type="number" step="1" name="frais" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Ajouter la tranche</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php foreach ($types as $t): ?>
    <div class="card shadow-sm mb-4">
        <div class="card-header"><?= esc($t['libelle']) ?></div>
        <?php if ($t['code'] === 'depot'): ?>
            <div class="card-body text-muted">Le dépôt est gratuit, aucun barème de frais n'est appliqué.</div>
        <?php else: ?>
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Montant min</th>
                        <th>Montant max</th>
                        <th>Frais</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($t['baremes'])): ?>
                        <tr><td colspan="4" class="text-center text-muted py-2">Aucune tranche configurée.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($t['baremes'] as $b): ?>
                        <tr>
                            <td><?= formater_ariary($b['montant_min']) ?></td>
                            <td><?= formater_ariary($b['montant_max']) ?></td>
                            <td><?= formater_ariary($b['frais']) ?></td>
                            <td class="text-end">
                                <a href="<?= site_url('operateur/operations/bareme/delete/' . $b['id']) ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Supprimer cette tranche ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?= $this->endSection() ?>
