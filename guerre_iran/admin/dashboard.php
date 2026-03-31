<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/fonctions.php';

if(!isLoggedIn()) {
    redirect('/');
}

$db = new Database();

// Statistiques pour le dashboard
$stats = [
    'total_articles' => $db->getConnection()->query("SELECT COUNT(*) as count FROM articles")->fetch()['count'],
    'published_articles' => $db->getConnection()->query("SELECT COUNT(*) as count FROM articles WHERE status = 'published'")->fetch()['count'],
    'draft_articles' => $db->getConnection()->query("SELECT COUNT(*) as count FROM articles WHERE status = 'draft'")->fetch()['count'],
    'total_views' => $db->getConnection()->query("SELECT SUM(views) as sum FROM articles")->fetch()['sum'] ?? 0
];

$recent_articles = $db->getArticles(5); // 5 articles récents

$meta_title = "Dashboard - Administration";
$meta_desc = "Tableau de bord d'administration du site Guerre en Iran";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= generateMetaTags($meta_title, $meta_desc) ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
    <title>Dashboard - Administration</title>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="dashboard">Administration</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/">← Retour au site</a>
                <a class="nav-link" href="logout">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="page-title mb-5">Tableau de bord</h1>

        <!-- Statistiques -->
        <div class="row mb-5">
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="stat-card bg-white">
                    <div class="stat-label">Total Articles</div>
                    <div class="stat-number"><?= $stats['total_articles'] ?></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="stat-card bg-white">
                    <div class="stat-label">Articles Publiés</div>
                    <div class="stat-number"><?= $stats['published_articles'] ?></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="stat-card bg-white">
                    <div class="stat-label">Brouillons</div>
                    <div class="stat-number"><?= $stats['draft_articles'] ?></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="stat-card bg-white">
                    <div class="stat-label">Vues Totales</div>
                    <div class="stat-number"><?= number_format($stats['total_views']) ?></div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="card mb-5">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">Actions Rapides</h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="articles/ajouter" class="btn btn-primary">
                        <span>➕</span> Ajouter un article
                    </a>
                    <a href="articles" class="btn btn-secondary">
                        <span>📋</span> Gérer les articles
                    </a>
                </div>
            </div>
        </div>

        <!-- Articles récents -->
        <div class="card">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">Articles Récents</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Titre</th>
                                <th>Statut</th>
                                <th>Vues</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recent_articles as $article): ?>
                            <tr>
                                <td>
                                    <a href="/article/<?= htmlspecialchars($article['slug']) ?>" target="_blank" class="text-decoration-none">
                                        <strong><?= htmlspecialchars(substr($article['titre'], 0, 50)) ?>...</strong>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $article['status'] == 'published' ? 'success' : 'warning' ?>">
                                        <?= $article['status'] == 'published' ? 'Publié' : 'Brouillon' ?>
                                    </span>
                                </td>
                                <td><?= $article['views'] ?></td>
                                <td><?= date('d/m/Y', strtotime($article['created_at'])) ?></td>
                                <td>
                                    <a href="articles/modifier/<?= $article['id'] ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>