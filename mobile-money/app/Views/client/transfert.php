<?= $this->extend('layout/client') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-3">🔁 Transfert</h4>
                <p class="text-muted">
                    Solde disponible : <strong><?= formater_ariary($client['solde']) ?></strong><br>
                    Des frais s'appliquent selon le barème de l'opérateur.
                </p>

                <form method="post" action="<?= site_url('client/transfert') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Numéro du destinataire</label>
                        <input type="text" name="telephone_destinataire" class="form-control" placeholder="0371234567" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Montant à transférer (Ar)</label>
                        <input type="number" step="1" min="1" name="montant" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-info text-white w-100">Valider le transfert</button>
                    <a href="<?= site_url('client/dashboard') ?>" class="btn btn-link w-100 mt-2">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
