<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/fonctions.php';

if(isLoggedIn()) {
    redirect('/admin/dashboard');
}

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = cleanInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $db = new Database();
    $stmt = $db->getConnection()->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        redirect('/admin/dashboard');
    } else {
        $error = 'Identifiants incorrects';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Administration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-container card shadow mt-5">
                    <div class="card-body p-4">
                        <h1 class="card-title text-center mb-4">Administration</h1>
                        
                        <?php if($error): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Nom d'utilisateur</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            
                            <div class="form-group mb-4">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">Identifiants par défaut : admin / admin123</small>
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