<?php
include 'bd/connexion.php';

$id = $_GET['id'];

// Récupérer l'article pour obtenir le chemin de l'image
$stmt = $conn->prepare('SELECT image FROM articles WHERE id = ?');
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if ($article) {
    // Si une image est associée à l'article, supprimer le fichier image
    if (!empty($article['image']) && file_exists($article['image'])) {
        unlink($article['image']); 
    }

    // Supprimer l'article de la base de données
    $stmt = $conn->prepare('DELETE FROM articles WHERE id = ?');
    $stmt->execute([$id]);

    // Rediriger vers la page principale
    header('Location: index.php');
} else {
    echo "L'article n'existe pas.";
    exit();
}

