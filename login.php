<?php session_start();
$title = "Se connecter";
include 'includes/head.php'; ?>



<main>
    <div class="signup-form">

        <form action="login_check.php" method="POST">

            <input type="text" name="uid" placeholder="Email/Username...">
            <input type="password" name="password" placeholder="Password...">
            <button type="submit" name="submit">Log In</button>

        </form>

    </div>
</main>





<?php include 'includes/head.php'; ?>