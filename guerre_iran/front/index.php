<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/fonctions.php';

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
    <link rel="stylesheet" href="/css/style.css">
    <title>Guerre en Iran - Actualités et analyses</title>
</head>
<body>
    <header>
        <div class="header-container">
            <a href="/" class="site-title">Guerre en Iran</a>
            <nav class="main-nav">
                <ul class="nav-list">
                    <li><a href="/" class="active">Accueil</a></li>
                    <?php foreach($categories as $cat): ?>
                    <li><a href="/categorie/<?= htmlspecialchars($cat['slug']) ?>">
                        <?= htmlspecialchars($cat['nom']) ?>
                    </a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="content-area">
            <section class="articles-section">
                <h2>Dernières actualités</h2>
                <div class="articles-grid">
                    <?php foreach($articles as $article): ?>
                    <article class="article-card">
                        <?php if($article['image']): ?>
                        <div class="article-image">
                            <img src="/images/<?= htmlspecialchars($article['image']) ?>"
                                 alt="<?= htmlspecialchars($article['image_alt'] ?: $article['titre']) ?>">
                        </div>
                        <?php endif; ?>
                        <div class="article-content">
                            <h3 class="article-title">
                                <a href="/article/<?= htmlspecialchars($article['slug']) ?>">
                                    <?= htmlspecialchars($article['titre']) ?>
                                </a>
                            </h3>
                            <div class="article-meta">
                                <span class="article-category">
                                    <?= htmlspecialchars($article['categorie_nom'] ?: 'Général') ?>
                                </span>
                                <span class="article-date">
                                    <?= date('d/m/Y', strtotime($article['created_at'])) ?>
                                </span>
                            </div>
                            <p class="article-excerpt">
                                <?= truncate(strip_tags($article['contenu']), 150) ?>
                            </p>
                            <a href="/article/<?= htmlspecialchars($article['slug']) ?>" class="read-more">
                                Lire la suite
                            </a>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>

        <aside class="sidebar">
            <h3 class="sidebar-title">Catégories</h3>
            <ul class="categories-list">
                <?php foreach($categories as $cat): ?>
                <li>
                    <a href="/categorie/<?= htmlspecialchars($cat['slug']) ?>">
                        <?= htmlspecialchars($cat['nom']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </aside>
    </main>

    <footer>
        <div class="footer-container">
            <p class="footer-text">&copy; 2026 - Guerre en Iran - Informations et analyses</p>
        </div>
    </footer>

    <script src="/js/main.js"></script>
</body>
</html>