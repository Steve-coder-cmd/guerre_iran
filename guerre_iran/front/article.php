<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/fonctions.php';

$slug = isset($_GET['slug']) ? cleanInput($_GET['slug']) : null;

if(!$slug) {
    header('HTTP/1.0 404 Not Found');
    include '404.php';
    exit;
}

$db = new Database();
$article = $db->getArticleBySlug($slug);

if(!$article) {
    header('HTTP/1.0 404 Not Found');
    include '404.php';
    exit;
}

// Données structurées JSON-LD pour le SEO
$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $article['titre'],
    'description' => $article['meta_description'] ?: truncate(strip_tags($article['contenu']), 160),
    'datePublished' => $article['created_at'],
    'dateModified' => $article['updated_at'],
    'author' => [
        '@type' => 'Organization',
        'name' => SITE_NAME
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => SITE_NAME
    ]
];

if($article['image']) {
    $schema['image'] = SITE_URL . '/images/' . $article['image'];
}

$meta_title = $article['meta_title'] ?: $article['titre'];
$meta_desc = $article['meta_description'] ?: truncate(strip_tags($article['contenu']), 160);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= generateMetaTags($meta_title, $meta_desc, $article['meta_keywords'], $article['image']) ?>
    <link rel="canonical" href="<?= SITE_URL ?>/article/<?= htmlspecialchars($article['slug']) ?>">
    <script type="application/ld+json">
    <?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
    </script>
    <link rel="stylesheet" href="/css/style.css">
    <title><?= htmlspecialchars($article['titre']) ?> - Guerre en Iran</title>
</head>
<body>
    <header>
        <div class="header-container">
            <a href="/" class="site-title">Guerre en Iran</a>
            <nav class="main-nav">
                <ul class="nav-list">
                    <li><a href="/">Accueil</a></li>
                    <li><a href="javascript:history.back()">← Retour</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="content-area">
            <article class="article-full">
                <header class="article-header">
                    <div class="article-meta">
                        <span class="article-category">
                            <?= htmlspecialchars($article['categorie_nom'] ?: 'Général') ?>
                        </span>
                        <span class="article-date">
                            <?= date('d F Y', strtotime($article['created_at'])) ?>
                        </span>
                        <span class="article-views">
                            <?= $article['views'] ?> vues
                        </span>
                    </div>
                    <h1 class="article-title-main">
                        <?= htmlspecialchars($article['titre']) ?>
                    </h1>
                </header>

                <?php if($article['image']): ?>
                <figure class="article-image-main">
                    <img src="/images/<?= htmlspecialchars($article['image']) ?>"
                         alt="<?= htmlspecialchars($article['image_alt'] ?: $article['titre']) ?>">
                    <?php if($article['image_alt']): ?>
                    <figcaption class="article-caption">
                        <?= htmlspecialchars($article['image_alt']) ?>
                    </figcaption>
                    <?php endif; ?>
                </figure>
                <?php endif; ?>

                <div class="article-content">
                    <?= $article['contenu'] ?>
                </div>
            </article>
        </div>

        <aside class="sidebar">
            <h3 class="sidebar-title">Navigation</h3>
            <ul class="categories-list">
                <li><a href="/">← Retour à l'accueil</a></li>
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