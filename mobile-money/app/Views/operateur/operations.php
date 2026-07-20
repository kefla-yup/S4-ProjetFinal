<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<h4 class="mb-4"><i class="fas fa-list-ul me-2"></i>Types d'opération & barèmes de frais</h4>

<div class="row g-4 mb-4">
    <div class="col-md-5">
        <div class="card-glass p-4">
            <h6><i class="fas fa-plus-circle me-2"></i>Ajouter une tranche de frais</h6>
            <form method="post" action="<?= site_url('operateur/operations/bareme/add') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-tag me-1"></i>Type d'opération</label>
                    <select name="type_operation_id" class="form-select" required>
                        <?php foreach ($types as $t): ?>
                            <?php if ($t['code'] !== 'depot'): ?>
                                <option value="<?= $t['id'] ?>"><?= esc($t['libelle']) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold"><i class="fas fa-arrow-down me-1"></i>Montant min (Ar)</label>
                        <input type="number" step="1" name="montant_min" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold"><i class="fas fa-arrow-up me-1"></i>Montant max (Ar)</label>
                        <input type="number" step="1" name="montant_max" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <label class="form-label fw-semibold"><i class="fas fa-coins me-1"></i>Frais (Ar)</label>
                    <input type="number" step="1" name="frais" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-dark-modern w-100">
                    <i class="fas fa-plus me-2"></i>Ajouter la tranche
                </button>
            </form>
        </div>
    </div>
</div>

<?php foreach ($types as $t): ?>
    <div class="card-glass mb-4">
        <div class="card-header"><i class="fas fa-tag me-2"></i><?= esc($t['libelle']) ?></div>
        <?php if ($t['code'] === 'depot'): ?>
            <div class="card-body text-muted"><i class="fas fa-info-circle me-1"></i>Le dépôt est gratuit, aucun barème de frais n'est appliqué.</div>
        <?php else: ?>
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Montant min</th>
                        <th>Montant max</th>
                        <th>Frais</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($t['baremes'])): ?>
                        <tr><td colspan="4" class="text-center text-muted py-3"><i class="fas fa-inbox me-2"></i>Aucune tranche configurée.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($t['baremes'] as $b): ?>
                        <tr>
                            <td><?= formater_ariary($b['montant_min']) ?></td>
                            <td><?= formater_ariary($b['montant_max']) ?></td>
                            <td><?= formater_ariary($b['frais']) ?></td>
                            <td class="text-end">
                                <a href="<?= site_url('operateur/operations/bareme/edit/' . $b['id']) ?>"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-trash-alt me-1"></i>Modifier
                                </a>
                            </td>

                            <td class="text-end">
                                <a href="<?= site_url('operateur/operations/bareme/delete/' . $b['id']) ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Supprimer cette tranche ?');">
                                    <i class="fas fa-trash-alt me-1"></i>Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?= $this->endSection() ?>