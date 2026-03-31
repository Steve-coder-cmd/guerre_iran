<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/fonctions.php';

$db = new Database();
$categories = $db->getCategories();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - Guerre en Iran</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .error-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 60vh;
            text-align: center;
        }

        .error-content {
            max-width: 600px;
        }

        .error-code {
            font-size: 6rem;
            font-weight: 700;
            color: #c8102e;
            margin: 0;
            line-height: 1;
        }

        .error-title {
            font-size: 2rem;
            font-weight: 600;
            color: #1a1a1a;
            margin: 1rem 0;
        }

        .error-text {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .error-links {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .error-links a {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #c8102e;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .error-links a:hover {
            background: #1a1a1a;
            transform: translateY(-2px);
        }

        .error-links a.secondary {
            background: #f8f8f8;
            color: #1a1a1a;
            border: 2px solid #e0e0e0;
        }

        .error-links a.secondary:hover {
            border-color: #c8102e;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <a href="/" class="site-title">Guerre en Iran</a>
            <nav class="main-nav">
                <ul class="nav-list">
                    <li><a href="/">Accueil</a></li>
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
            <div class="error-container">
                <div class="error-content">
                    <p class="error-code">404</p>
                    <h1 class="error-title">Page non trouvée</h1>
                    <p class="error-text">
                        La page que vous recherchez n'existe pas ou a été supprimée. 
                        Retournez à l'accueil ou explorez nos catégories.
                    </p>
                    <div class="error-links">
                        <a href="/">← Retour à l'accueil</a>
                        <a href="javascript:history.back()" class="secondary">Retour précédent</a>
                    </div>
                </div>
            </div>
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