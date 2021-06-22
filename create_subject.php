<?php session_start();

if (!isset($_SESSION['uid'])) {
    header('location: index.php?code=accessdenied');
    exit;
}

if (isset($_SESSION['status']) && $_SESSION['status'] == 0) {
    header('location: forums.php?blockunverified');
    exit;
}

$title = "Créer un sujet";

include 'includes/head.php';
include 'includes/header.php'; ?>


<main>

    <div class="create-forum">

        <div class="create-forum-title">
            <i class="fas fa-comments"></i>
            <h1>Créer un sujet</h1>
        </div>

        <form action="create_subject_check.php" method="POST" enctype="multipart/form-data">
            <label for="category">Choisissez une catégorie*</label>
            <select name="category" id="category">
                <option value="1">Toutes</option>
                <option value="2">Sports</option>
                <option value="3">NBA</option>
                <option value="4">Football</option>
                <option value="5">Joueurs</option>
                <option value="6">MyTeam</option>
                <option value="7">Site</option>
            </select>
            <label for="title">Titre du sujet (150 caractères maximum)*</label>
            <input type="text" name="title" id="title">
            <label for="content">Contenu du sujet*</label>
            <textarea name="content" id="content" cols="150" rows="35"></textarea>
            <button name="submit">POSTER</button>
        </form>

    </div>


</main>



<?php include 'includes/footer.php'; ?>
