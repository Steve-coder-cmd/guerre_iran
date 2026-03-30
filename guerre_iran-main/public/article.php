<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/fonctions.php';

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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header class="bg-primary text-white py-4">
        <div class="container">
            <nav class="mb-3">
                <a href="/" class="btn btn-light">← Retour à l'accueil</a>
            </nav>
            <h1 class="text-center"><?= htmlspecialchars($article['titre']) ?></h1>
        </div>
    </header>
    
    <main class="container my-5">
        <article class="article-full">
            <div class="meta text-muted mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <strong>Catégorie :</strong> <?= htmlspecialchars($article['categorie_nom']) ?>
                    </div>
                    <div class="col-md-4">
                        <strong>Publié le :</strong> <?= date('d/m/Y H:i', strtotime($article['created_at'])) ?>
                    </div>
                    <div class="col-md-4">
                        <strong>Vues :</strong> <?= $article['views'] ?>
                    </div>
                </div>
            </div>
            
            <?php if($article['image']): ?>
            <figure class="text-center mb-4">
                <img src="/images/<?= htmlspecialchars($article['image']) ?>" 
                     class="img-fluid rounded" 
                     alt="<?= htmlspecialchars($article['image_alt'] ?: $article['titre']) ?>">
                <?php if($article['image_alt']): ?>
                <figcaption class="text-muted mt-2">
                    <?= htmlspecialchars($article['image_alt']) ?>
                </figcaption>
                <?php endif; ?>
            </figure>
            <?php endif; ?>
            
            <div class="content">
                <?= $article['contenu'] ?>
            </div>
            
            <div class="mt-4 pt-4 border-top">
                <a href="/" class="btn btn-primary">Retour à l'accueil</a>
            </div>
        </article>
    </main>
    
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; 2026 - Informations sur la guerre en Iran</p>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>