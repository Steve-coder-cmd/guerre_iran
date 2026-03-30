<?php
require_once 'includes/config.php';
require_once 'includes/fonctions.php';

$meta_title = "Page non trouvée - 404";
$meta_desc = "La page que vous recherchez n'existe pas sur le site Guerre en Iran.";
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
    <title>Page non trouvée - 404</title>
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
                </ul>
            </nav>
        </div>
    </header>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h1 class="display-1 text-muted">404</h1>
                        <h2 class="card-title">Page non trouvée</h2>
                        <p class="card-text">
                            Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
                        </p>
                        <a href="/" class="btn btn-primary">Retour à l'accueil</a>
                    </div>
                </div>
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
</body>
</html>