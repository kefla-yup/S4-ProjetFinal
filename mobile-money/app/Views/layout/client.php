<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= esc($titre ?? 'Mobile Money - Espace Client') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ---------- Reset & Base ---------- */
        body {
            background: #f1f5f9;
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container, .container-fluid { padding-left: 20px; padding-right: 20px; }

        /* ---------- Navbar moderne ---------- */
        .navbar-modern {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            padding: 12px 0;
        }
        .navbar-modern .navbar-brand {
            font-weight: 600;
            font-size: 1.3rem;
            letter-spacing: -0.5px;
            color: #fff;
        }
        .navbar-modern .navbar-brand i {
            color: #60a5fa;
            margin-right: 10px;
        }
        .navbar-modern .nav-link, .navbar-modern .btn-outline-light {
            font-weight: 500;
            border-radius: 40px;
            padding: 6px 18px;
            transition: all 0.2s;
        }
        .navbar-modern .btn-outline-light:hover {
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.3);
        }

        /* ---------- Cartes ---------- */
        .card-glass {
            background: #ffffff;
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15);
            transition: transform 0.25s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        .card-glass:hover {
            transform: translateY(-6px);
            box-shadow: 0 30px 50px -16px rgba(0,0,0,0.20);
        }
        .card-glass .card-header {
            background: transparent;
            border-bottom: 1px solid #eef2f6;
            font-weight: 600;
            padding: 18px 24px;
        }
        .card-glass .card-body {
            padding: 24px;
        }

        /* Carte solde */
        .card-solde {
            background: linear-gradient(145deg, #2563eb, #1d4ed8);
            color: white;
            border-radius: 24px;
            padding: 28px 24px;
            box-shadow: 0 20px 40px -12px rgba(37,99,235,0.4);
            transition: transform 0.25s;
        }
        .card-solde:hover {
            transform: scale(1.02);
        }
        .card-solde h6 { opacity: 0.8; font-weight: 400; letter-spacing: 0.5px; }
        .card-solde h2 { font-weight: 700; font-size: 2.4rem; margin: 8px 0; }
        .card-solde .small { opacity: 0.85; }

        /* ---------- Boutons modernes ---------- */
        .btn-modern {
            border: none;
            border-radius: 40px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            letter-spacing: 0.3px;
        }
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .btn-modern i { margin-right: 10px; }

        .btn-success-modern {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
        }
        .btn-success-modern:hover { color: #fff; background: #059669; }

        .btn-warning-modern {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
        }
        .btn-warning-modern:hover { color: #fff; background: #d97706; }

        .btn-info-modern {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            color: #fff;
        }
        .btn-info-modern:hover { color: #fff; background: #0891b2; }

        .btn-outline-modern {
            background: transparent;
            border: 2px solid #cbd5e1;
            color: #334155;
        }
        .btn-outline-modern:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            transform: translateY(-2px);
        }

        /* ---------- Tableaux ---------- */
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
            vertical-align: middle;
        }
        .table-modern tbody tr:hover {
            background: #f8fafc;
        }

        /* ---------- Alertes ---------- */
        .alert-modern {
            border-radius: 20px;
            border: none;
            padding: 16px 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 768px) {
            .card-solde h2 { font-size: 1.8rem; }
            .btn-modern { padding: 10px 16px; font-size: 0.9rem; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-modern">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('client/dashboard') ?>">
            <i class="fas fa-mobile-alt"></i> Mobile Money
        </a>
        <?php if (session()->get('client_id')): ?>
            <div class="d-flex align-items-center">
                <span class="text-white-50 me-3">
                    <i class="fas fa-user-circle me-1"></i> <?= esc(session()->get('client_telephone')) ?>
                </span>
                <a href="<?= site_url('client/logout') ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                </a>
            </div>
        <?php endif; ?>
    </div>
</nav>

<div class="container py-5">
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

<script src="<?= base_url("bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
</body>
</html>