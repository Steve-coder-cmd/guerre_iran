<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/fonctions.php';

if(isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = cleanInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $db = new Database();
    $user = $db->authenticateUser($username, $password);
    
    if($user) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_role'] = $user['role'];
        redirect('dashboard.php');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin.css">
    <style>
        html, body {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        }

        .login-wrapper {
            width: 100%;
            max-width: 450px;
            padding: 0 20px;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
            color: white;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .login-header h1 {
            font-family: 'Times New Roman', Georgia, serif;
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .login-header p {
            font-size: 0.9rem;
            opacity: 0.8;
            margin: 0.5rem 0 0 0;
        }

        .login-body {
            padding: 2rem 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #c8102e;
            box-shadow: 0 0 0 0.2rem rgba(200, 16, 46, 0.15);
        }

        .btn-login {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #c8102e;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            background: #1a1a1a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(200, 16, 46, 0.3);
        }

        .alert {
            border: none;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .login-footer {
            background-color: #f8f8f8;
            padding: 1.5rem;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .login-footer p {
            font-size: 0.85rem;
            color: #666;
            margin: 0;
        }

        .login-footer strong {
            color: #c8102e;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h1>Guerre en Iran</h1>
                <p>Espace d'administration</p>
            </div>

            <div class="login-body">
                <?php if($error): ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Erreur :</strong> <?= htmlspecialchars($error) ?>
                </div>
                <?php endif; ?>

                <form method="POST" class="login-form">
                    <div class="form-group">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" id="username" name="username" class="form-control" 
                               placeholder="Entrez votre nom d'utilisateur" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control" 
                               placeholder="Entrez votre mot de passe" required>
                    </div>

                    <button type="submit" class="btn-login">Se connecter</button>
                </form>
            </div>

            <div class="login-footer">
                <p>Identifiants de test : <strong>admin</strong> / <strong>admin123</strong></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>