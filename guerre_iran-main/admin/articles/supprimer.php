<?php
require_once '../../includes/config.php';
require_once '../../includes/database.php';
require_once '../../includes/fonctions.php';

if(!isLoggedIn()) {
    redirect('/admin/login');
}

$db = new Database();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if(!$id) {
    header('HTTP/1.0 404 Not Found');
    exit('Article non trouvé');
}

// Récupération de l'article pour confirmation
$stmt = $db->getConnection()->prepare("SELECT titre, image FROM articles WHERE id = :id");
$stmt->execute([':id' => $id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$article) {
    header('HTTP/1.0 404 Not Found');
    exit('Article non trouvé');
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Supprimer l'image associée si elle existe
    if($article['image'] && file_exists('../public/images/' . $article['image'])) {
        unlink('../public/images/' . $article['image']);
    }

    // Supprimer l'article
    $stmt = $db->getConnection()->prepare("DELETE FROM articles WHERE id = :id");
    $result = $stmt->execute([':id' => $id]);

    if($result) {
        $success = 'Article supprimé avec succès !';
        header('Location: /admin/articles?success=deleted');
        exit;
    } else {
        $error = 'Erreur lors de la suppression de l\'article';
    }
}

$meta_title = "Supprimer Article - Administration";
$meta_desc = "Confirmation de suppression de l'article: " . htmlspecialchars($article['titre']);
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
    <title>Supprimer Article - Administration</title>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/admin/dashboard">Administration</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/admin/dashboard">Dashboard</a>
                <a class="nav-link" href="/admin/articles">Articles</a>
                <a class="nav-link" href="/">← Retour au site</a>
                <a class="nav-link" href="/admin/logout">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">⚠️ Confirmer la suppression</h5>
                    </div>
                    <div class="card-body">
                        <?php if($error): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </div>
                        <?php endif; ?>

                        <?php if($success): ?>
                        <div class="alert alert-success" role="alert">
                            <?= htmlspecialchars($success) ?>
                        </div>
                        <?php endif; ?>

                        <p class="mb-4">
                            Êtes-vous sûr de vouloir supprimer définitivement l'article suivant ?
                        </p>

                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="card-title text-danger">
                                    "<?= htmlspecialchars($article['titre']) ?>"
                                </h6>
                                <?php if($article['image']): ?>
                                <img src="/images/<?= htmlspecialchars($article['image']) ?>" class="img-fluid mt-2" alt="Image de l'article" style="max-height: 200px;">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            <strong>Attention :</strong> Cette action est irréversible. L'article et son image associée seront supprimés définitivement.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/admin/articles" class="btn btn-secondary">Annuler</a>
                            <form method="POST" class="d-inline">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous vraiment sûr de vouloir supprimer cet article ?')">
                                    Supprimer définitivement
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>