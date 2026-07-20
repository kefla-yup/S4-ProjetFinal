<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-md-5">
        <div class="card-glass p-4">
            <h6><i class="fas fa-edit me-2"></i>Modifier une tranche de frais</h6>
            <form method="post" action="<?= site_url("operateur/operations/bareme/modif/" . $bareme["id"]) ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fas fa-tag me-1"></i>Type d'opération</label>
                    <select name="type_operation_id" class="form-select" required>
                        <?php foreach ($types as $t): ?>
                            <?php if ($t['code'] !== 'depot'): ?>
                                <option value="<?= $t['id'] ?>" <?= $bareme['type_operation_id'] == $t['id'] ? 'selected' : '' ?>>
                                    <?= esc($t['libelle']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold"><i class="fas fa-arrow-down me-1"></i>Montant min (Ar)</label>
                        <input type="number" step="1" name="montant_min" class="form-control" value="<?=$bareme["montant_min"] ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold"><i class="fas fa-arrow-up me-1"></i>Montant max (Ar)</label>
                        <input type="number" step="1" name="montant_max" class="form-control" value="<?=$bareme["montant_max"] ?>" required>
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <label class="form-label fw-semibold"><i class="fas fa-coins me-1"></i>Frais (Ar)</label>
                    <input type="number" step="1" name="frais" class="form-control" value="<?=$bareme["frais"] ?>" required>
                </div>
                <button type="submit" class="btn btn-dark-modern w-100">
                    <i class="fas fa-save me-2"></i>Modifier la tranche
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>