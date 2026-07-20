<?= $this->extend('layout/operateur') ?>
<?= $this->section('content') ?>
    
<div class="row mb-4">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Modifier une tranche de frais</h6>
                <form method="post" action="<?= site_url("operateur/operations/bareme/modif/" . $bareme["id"]) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Type d'opération</label>
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
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Montant min (Ar)</label>
                            <input type="number" step="1" name="montant_min" class="form-control"  value="<?=$bareme["montant_min"] ?>" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Montant max (Ar)</label>
                            <input type="number" step="1" name="montant_max" class="form-control" value="<?=$bareme["montant_max"] ?>"  required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Frais (Ar)</label>
                        <input type="number" step="1" name="frais" class="form-control" value="<?=$bareme["frais"] ?>"  required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Modifier la tranche</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

</body>
</html>