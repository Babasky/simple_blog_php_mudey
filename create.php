<?php
require_once 'bd/table.php';

if (isset($_POST['submit'])) {
    if(empty($_POST['title'])|| !isset($_POST['title'])){
        echo 'Le champ titre est obligatoire.';
        exit();
    }else if(empty($_POST['content']) || !isset($_POST['content'])){
        echo 'Le champ contenu est obligatoire.';
        exit();
    }else{
      
        $title = htmlspecialchars(htmlspecialchars_decode($_POST['title']));
        $content = htmlspecialchars(htmlspecialchars_decode($_POST['content']));
        $image = null;
    
        // Gestion de l'upload de l'image
        if (!empty($_FILES['image']['name'])) {
            $image = 'assets/images/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        }
    
        // Insertion de l'article avec l'image
        $stmt = $conn->prepare('INSERT INTO articles (title, content, image) VALUES (?, ?, ?)');
        $stmt->execute([$title, $content, $image]);
    }
    
    header('Location: index.php');
}
?>

<?php include_once 'templates/header.php'; ?>
    <h1 class="text-center">Créer un article</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Titre de l'article :</label>
        <input type="text" id="title" class="form-control" name="title" required><br>

        <label for="content">Contenu de l'article :</label>
        <textarea id="content" name="content" class="form-control" rows="10" required></textarea><br>

        <label for="image">Image de l'article :</label>
        <input type="file" class="form-control" id="image" name="image"><br>

        <input type="submit" class="btn btn-primary" value="Publier" name="submit">
    </form>
<?php include_once 'templates/footer.php'; ?>