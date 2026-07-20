<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= esc($titre ?? 'Mobile Money - Back-office Opérateur') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/all.min.css') ?>">
    <style>
        body {
            background: #f1f5f9;
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        }
        /* Navbar sombre moderne */
        .navbar-operateur {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            box-shadow: 0 8px 24px rgba(0,0,0,0.25);
            padding: 10px 0;
        }
        .navbar-operateur .navbar-brand {
            font-weight: 600;
            color: #fff;
            font-size: 1.2rem;
        }
        .navbar-operateur .navbar-brand i { color: #60a5fa; margin-right: 10px; }
        .navbar-operateur .nav-link {
            color: #cbd5e1 !important;
            border-radius: 40px;
            padding: 6px 18px;
            transition: 0.2s;
            font-weight: 500;
        }
        .navbar-operateur .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff !important;
        }
        .navbar-operateur .nav-link i { margin-right: 8px; }

        /* Cartes */
        .card-glass {
            background: #fff;
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.12);
            transition: transform 0.25s, box-shadow 0.3s;
            overflow: hidden;
        }
        .card-glass:hover {
            transform: translateY(-4px);
            box-shadow: 0 28px 48px -16px rgba(0,0,0,0.18);
        }
        .card-glass .card-header {
            background: transparent;
            border-bottom: 1px solid #eef2f6;
            font-weight: 600;
            padding: 18px 24px;
        }

        /* Boutons */
        .btn-dark-modern {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border: none;
            border-radius: 40px;
            padding: 12px 24px;
            font-weight: 600;
            color: #fff;
            transition: all 0.25s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .btn-dark-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            color: #fff;
        }
        .btn-dark-modern i { margin-right: 10px; }

        .btn-outline-dark-modern {
            border: 2px solid #cbd5e1;
            color: #334155;
            border-radius: 40px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s;
            background: transparent;
        }
        .btn-outline-dark-modern:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            transform: translateY(-2px);
        }

        /* Tableaux */
        .table-modern {
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        .table-modern thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 16px 16px;
            border-bottom: 2px solid #e2e8f0;
        }
        .table-modern tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        .table-modern tbody tr:hover {
            background: #f8fafc;
        }

        .alert-modern {
            border-radius: 20px;
            border: none;
            padding: 16px 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .badge-modern {
            padding: 6px 14px;
            border-radius: 40px;
            font-weight: 500;
        }

        .card-stats {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #fff;
            border-radius: 24px;
            padding: 20px;
            box-shadow: 0 12px 24px -8px rgba(0,0,0,0.2);
            transition: transform 0.25s;
        }
        .card-stats:hover { transform: scale(1.02); }
        .card-stats h6 { opacity: 0.8; font-weight: 400; }
        .card-stats h2 { font-weight: 700; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-operateur">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="<?= site_url('operateur/dashboard') ?>">
            <i class="fas fa-cogs"></i> Back-office Opérateur
        </a>
        <?php if (session()->get('operateur_id')): ?>
            <div class="collapse navbar-collapse" id="navbarOp">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('operateur/prefixes') ?>"><i class="fas fa-tags"></i>Préfixes</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('operateur/operations') ?>"><i class="fas fa-list-ul"></i>Types & barèmes</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('operateur/parametres') ?>"><i class="fas fa-sliders-h"></i>Paramètres</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('operateur/situation/gains') ?>"><i class="fas fa-chart-line"></i>Gains</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('operateur/situation/clients') ?>"><i class="fas fa-users"></i>Comptes clients</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('operateur/situation/montants-a-envoyer') ?>"><i class="fas fa-paper-plane"></i>Montants à envoyer</a></li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <span class="text-white-50 me-3">
                    <i class="fas fa-user-shield me-1"></i> <?= esc(session()->get('operateur_nom')) ?>
                </span>
                <a href="<?= site_url('operateur/logout') ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                </a>
            </div>
        <?php endif; ?>
    </div>
</nav>

<div class="container-fluid px-4 py-5">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>