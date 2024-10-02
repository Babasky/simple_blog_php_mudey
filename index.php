<?php
require_once 'bd/table.php';

$query = $conn->query('SELECT * FROM articles ORDER BY created_at DESC');
$articles = $query->fetchAll();

?>

<?php include_once 'templates/header.php'; ?>
<div class="container">
    <div class="post-head">
        <h1>Liste des articles</h1>
        <a href="create.php">
            <button class="btn btn-primary">Ajouter un nouvel article</button>
        </a>
    </div>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Image</th>
                <th>Date de création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (empty($articles)):
                echo '<tr><td colspan="5">Aucun article trouvé</td></tr>';
            endif;
            foreach ($articles as $article): 
                $formatDate = new DateTime($article['created_at']);
                $date = $formatDate->format('d/m/Y');
            ?>
                
            <tr>
                <td><a href="article.php?id=<?= $article['id'] ?>"><?= htmlspecialchars(htmlspecialchars_decode($article['title'])) ?></a></td>
                <td>
                    <?php if ($article['image']): ?>
                        <img src="<?= $article['image'] ?>" alt="Image de l'article" width="100">
                    <?php else: ?>
                        Pas d'image
                    <?php endif; ?>
                </td>
                <td> Crée le : <?= $date ?></td>
                <td>
                    <a href="update.php?id=<?= $article['id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a>
                    <a href="delete.php?id=<?= $article['id'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')"><i class="fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include_once 'templates/footer.php'; ?>
