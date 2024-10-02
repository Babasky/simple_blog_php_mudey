<?php
include 'bd/connexion.php';

$id = $_GET['id'];

// Récupérer les données de l'article avant de traiter le formulaire
$stmt = $conn->prepare('SELECT * FROM articles WHERE id = ?');
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérification si l'article existe
if (!$article) {
    echo "L'article n'existe pas.";
    exit();
}

if (isset($_POST['submit'])) {
    // Vérification des champs obligatoires
    if (empty($_POST['title']) || !isset($_POST['title'])) {
        echo 'Le champ titre est obligatoire.';
        exit();
    } else if (empty($_POST['content']) || !isset($_POST['content'])) {
        echo 'Le champ contenu est obligatoire.';
        exit();
    }

    $title = htmlspecialchars_decode($_POST['title']);
    $content = htmlspecialchars_decode($_POST['content']);
    $image = $article['image']; 

    // Gestion de l'upload de l'image si une nouvelle image est fournie
    if (!empty($_FILES['image']['name'])) {
        $image = 'assets/images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Mise à jour de l'article avec l'image
    $stmt = $conn->prepare('UPDATE articles SET title = ?, content = ?, image = ? WHERE id = ?');
    $stmt->execute([$title, $content, $image, $id]);

    header('Location: index.php');
    exit();
}
?>

<?php include_once 'templates/header.php'; ?>
    <h1 class="text-center">Modifier l'article : <?= htmlspecialchars_decode($article['title']) ?></h1>
    <form action="update.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars_decode($article['title']) ?>" required><br>

        <label for="content">Contenu :</label>
        <textarea id="editor" name="content" rows="10" class="form-control" required><?= htmlspecialchars_decode($article['content']) ?></textarea><br>

        <label for="image">Image actuelle :</label><br>
        <?php if ($article['image']): ?>
            <img src="<?= htmlspecialchars_decode($article['image']) ?>" alt="Image de l'article" width="100%" height="200"><br>
        <?php endif; ?>
        <input type="file" class="form-control" id="image" name="image"><br>

        <input type="hidden" name="current_image" value="<?= htmlspecialchars_decode($article['image']) ?>">

        <input type="submit" class="btn btn-primary" value="Modifier" name="submit">
    </form>
<?php include_once 'templates/footer.php'; ?>
