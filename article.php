<?php
include 'bd/connexion.php';

$id = $_GET['id'];
$stmt = $conn->prepare('SELECT * FROM articles WHERE id = ?');
$stmt->execute([$id]);
$article = $stmt->fetch();

if(!$article){
    echo "L'article n'existe pas.";
    exit();
}

$formatDate = new DateTime($article['created_at']);
$date = $formatDate->format('d/m/Y');
?>

<?php include_once 'templates/header.php'; ?>
<div class="container">
    <div class="post-detail">
        <?php if ($article['image']): ?>
            <img src="<?= $article['image'] ?>" alt="Image de l'article">
        <?php endif; ?>
        <div class="p-10">
            <h1><?=$article['title'] ?></h1>
            <p class="text-justify"><?= strip_tags(htmlspecialchars_decode($article['content'])) ?></p>
            <p>Crée le : <?= $date ?></p>
        </div>
    </div>
    <a href="index.php" class="btn btn-primary">Retour à la liste</a>
</div>
<?php include_once 'templates/footer.php'; ?>
