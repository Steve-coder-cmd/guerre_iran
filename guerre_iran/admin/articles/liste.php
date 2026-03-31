<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/fonctions.php';

if(!isLoggedIn()) {
    redirect('/');
}

$db = new Database();

// Pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$per_page = 20;
$offset = ($page - 1) * $per_page;

// Filtres
$status_filter = isset($_GET['status']) ? cleanInput($_GET['status']) : '';
$search = isset($_GET['search']) ? cleanInput($_GET['search']) : '';

// Construction de la requête
$query = "SELECT a.*, c.nom as categorie_nom FROM articles a LEFT JOIN categories c ON a.categorie_id = c.id";
$where = [];
$params = [];

if($status_filter) {
    $where[] = "a.status = :status";
    $params[':status'] = $status_filter;
}

if($search) {
    $where[] = "(a.titre LIKE :search OR a.contenu LIKE :search)";
    $params[':search'] = "%$search%";
}

if($where) {
    $query .= " WHERE " . implode(" AND ", $where);
}

$query .= " ORDER BY a.created_at DESC LIMIT :limit OFFSET :offset";

// Comptage total
$count_query = str_replace("SELECT a.*, c.nom as categorie_nom FROM articles a LEFT JOIN categories c ON a.categorie_id = c.id", "SELECT COUNT(*) as total FROM articles a", $query);
$count_query = preg_replace('/ORDER BY.*$/', '', $count_query);
$count_query = preg_replace('/LIMIT.*$/', '', $count_query);

$stmt = $db->getConnection()->prepare($count_query);
foreach($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$total_articles = $stmt->fetch()['total'];
$total_pages = ceil($total_articles / $per_page);

// Récupération des articles
$stmt = $db->getConnection()->prepare($query);
foreach($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$meta_title = "Gestion des Articles - Administration";
$meta_desc = "Interface de gestion des articles du site Guerre en Iran";
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
    <title>Gestion des Articles - Administration</title>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/admin/dashboard">Administration</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="dashboard">Dashboard</a>
                <a class="nav-link" href="/">← Retour au site</a>
                <a class="nav-link" href="logout">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-5 pb-5">
        <h1 class="page-title mb-4">Gestion des Articles</h1>

        <!-- Filtres et recherche -->
        <div class="filter-section">
            <form method="GET" class="filter-group">
                <div>
                    <label for="search" class="form-label">Rechercher</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="<?= htmlspecialchars($search) ?>" placeholder="Titre ou contenu...">
                </div>
                <div>
                    <label for="status" class="form-label">Statut</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Tous les statuts</option>
                        <option value="published" <?= $status_filter == 'published' ? 'selected' : '' ?>>Publié</option>
                        <option value="draft" <?= $status_filter == 'draft' ? 'selected' : '' ?>>Brouillon</option>
                    </select>
                </div>
                <div class="d-flex gap-2" style="margin-top: auto;">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    <a href="articles" class="btn btn-outline-secondary">Réinitialiser</a>
                </div>
            </form>
        </div>

        <div class="action-bar mb-4">
            <div class="action-bar-left">
                <p class="mb-0"><strong><?= $total_articles ?></strong> article(s) trouvé(s)</p>
            </div>
            <div class="action-bar-right">
                <a href="articles/ajouter" class="btn btn-primary">
                    ➕ Ajouter un article
                </a>
            </div>
        </div>

        <!-- Liste des articles -->
        <div class="card">
            <div class="card-body">
                <?php if(empty($articles)): ?>
                <div class="text-center py-5">
                    <p class="text-muted">Aucun article trouvé.</p>
                    <a href="articles/ajouter" class="btn btn-primary">Créer un article</a>
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">ID</th>
                                <th>Titre</th>
                                <th style="width: 15%">Catégorie</th>
                                <th style="width: 10%">Statut</th>
                                <th style="width: 8%">Vues</th>
                                <th style="width: 12%">Date</th>
                                <th style="width: 20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($articles as $article): ?>
                            <tr>
                                <td><code><?= $article['id'] ?></code></td>
                                <td>
                                    <a href="/article/<?= htmlspecialchars($article['slug']) ?>" target="_blank" 
                                       class="text-decoration-none text-dark">
                                        <strong><?= htmlspecialchars(substr($article['titre'], 0, 60)) ?></strong>
                                    </a>
                                </td>
                                <td>
                                    <small><?= htmlspecialchars($article['categorie_nom'] ?: 'Général') ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $article['status'] == 'published' ? 'success' : 'warning' ?>">
                                        <?= $article['status'] == 'published' ? '✓ Publié' : '⊙ Brouillon' ?>
                                    </span>
                                </td>
                                <td><small><?= $article['views'] ?></small></td>
                                <td><small><?= date('d/m/Y', strtotime($article['created_at'])) ?></small></td>
                                <td>
                                    <a href="articles/modifier/<?= $article['id'] ?>" class="btn btn-sm btn-outline-primary">✏️ Modifier</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?= $article['id'] ?>, '<?= htmlspecialchars(addslashes($article['titre'])) ?>')">🗑️ Supprimer</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($total_pages > 1): ?>
                <nav aria-label="Pagination" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php if($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=1&search=<?= urlencode($search) ?>&status=<?= urlencode($status_filter) ?>">
                                ← Première
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php for($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($status_filter) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                        <?php endfor; ?>

                        <?php if($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $total_pages ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($status_filter) ?>">
                                Dernière →
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer l'article "<span id="articleTitle"></span>" ?
                    Cette action est irréversible.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a id="deleteLink" href="#" class="btn btn-danger">Supprimer</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(id, title) {
            document.getElementById('articleTitle').textContent = title;
            document.getElementById('deleteLink').href = 'articles/supprimer/' + id;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>
</body>
</html>