<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/fonctions.php';

$db = new Database();
$articles = $db->getArticles(10);
$categories = $db->getCategories();

$meta_title = "Accueil - Actualités du conflit en Iran";
$meta_desc = "Suivez en temps réel l'actualité du conflit en Iran : analyses, témoignages, reportages et informations vérifiées.";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= generateMetaTags($meta_title, $meta_desc) ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header class="bg-primary text-white py-5">
        <div class="container">
            <h1 class="text-center mb-4">Guerre en Iran - Informations et analyses</h1>
            <nav>
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/">Accueil</a>
                    </li>
                    <?php foreach($categories as $cat): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/categorie/<?= htmlspecialchars($cat['slug']) ?>">
                            <?= htmlspecialchars($cat['nom']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    <li class="nav-item">
                        <a class="nav-link text-white bg-secondary rounded px-3" href="/admin/login">
                            Administration
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <section class="articles">
                    <h2 class="mb-4">Dernières actualités</h2>
                    <div class="row">
                        <?php foreach($articles as $article): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card article-card h-100">
                                <?php if($article['image']): ?>
                                <img src="/images/<?= htmlspecialchars($article['image']) ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($article['image_alt'] ?: $article['titre']) ?>">
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <h3 class="card-title h5">
                                        <a href="/article/<?= htmlspecialchars($article['slug']) ?>" class="text-decoration-none">
                                            <?= htmlspecialchars($article['titre']) ?>
                                        </a>
                                    </h3>
                                    <p class="meta text-muted small mb-2">
                                        Catégorie : <?= htmlspecialchars($article['categorie_nom']) ?> | 
                                        Date : <?= date('d/m/Y', strtotime($article['created_at'])) ?>
                                    </p>
                                    <p class="card-text flex-grow-1">
                                        <?= truncate(strip_tags($article['contenu']), 150) ?>
                                    </p>
                                    <a href="/article/<?= htmlspecialchars($article['slug']) ?>" class="btn btn-primary mt-auto">
                                        Lire la suite
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
            
            <div class="col-lg-4">
                <aside class="bg-light p-4 rounded">
                    <h3 class="mb-3">Catégories</h3>
                    <ul class="list-group list-group-flush">
                        <?php foreach($categories as $cat): ?>
                        <li class="list-group-item">
                            <a href="/categorie/<?= htmlspecialchars($cat['slug']) ?>" class="text-decoration-none">
                                <?= htmlspecialchars($cat['nom']) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </aside>
            </div>
        </div>
    </main>
    
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; 2026 - Informations sur la guerre en Iran</p>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/main.js"></script>
</body>
</html>