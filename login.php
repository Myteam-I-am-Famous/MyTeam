<?php session_start();
$title = "Se connecter";
include 'includes/head.php';
include 'includes/header.php';
?>



<main>
    <div class="login-form">

        <h1>SE CONNECTER À <span class="red">MY</span><span class="blue">TEAM</span></h1>

        <div id="bg-video">
            <video src="assets/videos/james_harden.mp4" autoplay loop muted></video>
        </div>

        <div class="login-container">

            <i class="fas fa-user"></i>

            <form action="login_check.php" method="POST">
                <label for="uid">Nom d'utilisateur/Email</label>
                <input type="text" name="uid" placeholder="Email/Username...">
                <label for="uid">Mot de passe</label>
                <input type="password" name="password" placeholder="Password...">
                <button type="submit" name="submit">SE CONNECTER</button>

            </form>
        </div>

    </div>
</main>





<?php include 'includes/head.php'; ?>
