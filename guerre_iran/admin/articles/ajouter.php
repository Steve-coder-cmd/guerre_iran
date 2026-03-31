<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/fonctions.php';

if(!isLoggedIn()) {
    redirect('login.php');
}

$db = new Database();
$categories = $db->getCategories();

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = cleanInput($_POST['titre']);
    $contenu = $_POST['contenu'];
    $categorie_id = intval($_POST['categorie_id'] ?? 0);
    $status = cleanInput($_POST['status'] ?? 'draft');
    $meta_title = cleanInput($_POST['meta_title']);
    $meta_description = cleanInput($_POST['meta_description']);
    $meta_keywords = cleanInput($_POST['meta_keywords']);
    $image_alt = cleanInput($_POST['image_alt']);
    
    $slug = slugify($titre);
    
    // Gestion de l'upload d'image
    $image = '';
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if(in_array($extension, $allowed)) {
            $image = $slug . '_' . time() . '.' . $extension;
            $upload_path = '../../front/images/' . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
        } else {
            $error = 'Format d\'image non autorisé';
        }
    }
    
    if(!$error) {
        $stmt = $db->getConnection()->prepare("
            INSERT INTO articles (titre, slug, contenu, image, image_alt, categorie_id, 
                                 meta_title, meta_description, meta_keywords, status)
            VALUES (:titre, :slug, :contenu, :image, :image_alt, :categorie_id,
                    :meta_title, :meta_description, :meta_keywords, :status)
        ");
        
        $result = $stmt->execute([
            ':titre' => $titre,
            ':slug' => $slug,
            ':contenu' => $contenu,
            ':image' => $image,
            ':image_alt' => $image_alt,
            ':categorie_id' => $categorie_id ?: null,
            ':meta_title' => $meta_title,
            ':meta_description' => $meta_description,
            ':meta_keywords' => $meta_keywords,
            ':status' => $status
        ]);
        
        if($result) {
            $success = 'Article créé avec succès !';
        } else {
            $error = 'Erreur lors de la création de l\'article';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un article - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
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

    <div class="container mt-5 pb-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h1 class="page-title">Ajouter un article</h1>

                <?php if($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Erreur :</strong> <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Succès :</strong> <?= htmlspecialchars($success) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="form-section">
                    <!-- Section Contenu -->
                    <div class="form-section-title">Contenu de l'article</div>

                    <div class="form-group mb-3">
                        <label for="titre" class="form-label">Titre *</label>
                        <input type="text" class="form-control" id="titre" name="titre" 
                               placeholder="Entrez le titre de l'article" required autofocus>
                        <small class="form-text text-muted">Le titre est important pour le SEO</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="categorie_id" class="form-label">Catégorie</label>
                        <select class="form-select" id="categorie_id" name="categorie_id">
                            <option value="">-- Pas de catégorie --</option>
                            <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="contenu" class="form-label">Contenu *</label>
                        <textarea class="form-control" id="contenu" name="contenu" 
                                  rows="15" placeholder="Écrivez votre article ici..." required></textarea>
                        <small class="form-text text-muted">Éditeur riche avec formatage disponible</small>
                    </div>

                    <!-- Section Image -->
                    <div class="form-section-title mt-4">Image de couverture</div>

                    <div class="form-group mb-3">
                        <label for="image" class="form-label">Télécharger une image</label>
                        <input type="file" class="form-control" id="image" name="image" 
                               accept="image/jpeg,image/jpg,image/png,image/webp">
                        <small class="form-text text-muted">Formats acceptés : JPG, PNG, WebP (max 5MB)</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image_alt" class="form-label">Texte alternatif</label>
                        <input type="text" class="form-control" id="image_alt" name="image_alt" 
                               placeholder="Description de l'image (SEO)">
                    </div>

                    <!-- Section SEO -->
                    <div class="form-section-title mt-4">Optimisation SEO</div>

                    <div class="form-group mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" 
                               maxlength="60" placeholder="Titre pour les moteurs de recherche (60 caractères max)">
                        <small class="form-text text-muted">Laissez vide pour utiliser le titre de l'article</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" 
                                  rows="3" maxlength="160" 
                                  placeholder="Description pour les moteurs de recherche (160 caractères max)"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="meta_keywords" class="form-label">Mots-clés</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                               placeholder="Mots-clés séparés par des virgules (ex: iran, guerre, politique)">
                    </div>

                    <!-- Section Statut -->
                    <div class="form-section-title mt-4">Publication</div>

                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Statut</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft">🔒 Brouillon (non publié)</option>
                            <option value="published">🌐 Publié (visible publiquement)</option>
                        </select>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="d-flex gap-2 mt-5">
                        <button type="submit" class="btn btn-primary btn-lg">
                            📝 Créer l'article
                        </button>
                        <a href="liste.php" class="btn btn-secondary btn-lg">
                            ← Revenir à la liste
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialiser CKEditor
        CKEDITOR.replace('contenu', {
            height: 400,
            toolbar: [
                { name: 'document', items: ['Source'] },
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
                { name: 'paragraph', items: ['BulletedList', 'NumberedList', '-', 'Outdent', 'Indent'] },
                { name: 'links', items: ['Link', 'Unlink'] },
                { name: 'insert', items: ['Image', 'Table'] }
            ]
        });

        // Validation du formulaire
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const titre = document.getElementById('titre').value.trim();
            const contenu = CKEDITOR.instances.contenu.getData().trim();

            if (!titre || !contenu) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs obligatoires');
            }
        });
    </script>
</body>
</html>