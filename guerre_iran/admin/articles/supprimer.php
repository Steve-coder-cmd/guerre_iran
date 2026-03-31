<?php
require_once '../../includes/config.php';
require_once '../../includes/database.php';
require_once '../../includes/fonctions.php';

if(!isLoggedIn()) {
    redirect('login.php');
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('liste.php');
}

$id = intval($_GET['id']);
$db = new Database();

try {
    $stmt = $db->getConnection()->prepare("DELETE FROM articles WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $success = "Article supprimé avec succès.";
} catch (Exception $e) {
    $error = "Erreur lors de la suppression: " . $e->getMessage();
}

redirect('liste.php?' . (isset($success) ? 'success=' . urlencode($success) : 'error=' . urlencode($error)));
?>