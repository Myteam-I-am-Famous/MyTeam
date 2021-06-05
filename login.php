<?php session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://kit.fontawesome.com/7d4db968a5.js" crossorigin="anonymous"></script>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>


<main>

        <div class="sign-bg-video">
            <video src="./assets/videos/anthony_edwards.mp4" autoplay loop muted>Video not found</video>
        </div>

        <div class="sign-container">
            <div class="form-container">
                <div class="sign">
                    <!--  Sign in -->
                    <form action="./includes/login_check.php" class="sign-in" method="POST">
                       <span class="text-danger"><?php echo $message; ?></span>
                        <h2 class="title">Connexion</h2>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" name="email" placeholder="Email">
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="mdp" placeholder="Mot de passe">
                        </div>
                        <input type="submit" id="submit" name="submit" value="Se connecter" class="btn solid">

                        <p class="social-text">Ou se connecter avec :</p>
                        <div class="social-media">
                            <a href="#" class="social-icon">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-icon">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-icon">
                                <i class="fab fa-google"></i>
                            </a>
                            <a href="#" class="social-icon">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </div>
                    </form>

                    <!-- Sign Up -->
                    <form action="./includes/signup_check.php" class="sign-up" method="POST">
                        <h2 class="title">Inscription</h2>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" name="nom" placeholder="Nom">
                        </div>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" name="prenom" placeholder="Prénom">
                        </div>
                           <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" name="pseudo" placeholder="pseudo">
                        </div>
                        <div class="input-field">
                            <i class="fas fa-envelope"></i>
                            <input type="text" name="email" placeholder="Email">
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="mdp" placeholder="Mot de passe">
                        </div>
                        <input type="submit" name="submit" value="S'inscrire" class="btn solid">

                        <p class="social-text">Ou s'inscrire avec : </p>
                        <div class="social-media">
                            <a href="#" class="social-icon">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-icon">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-icon">
                                <i class="fab fa-google"></i>
                            </a>
                            <a href="#" class="social-icon">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </div>
                    </form>

                </div>
            </div>

            <div class="panels-container">
                <div class="panel left-panel">
                    <div class="content">
                        <h3>Nouveau ici ?</h3>
                        <p>Devenez privilegiez et accédez à du contenu inédit !</p>
                        <button class="btn transparent" id="sign-up-btn">S'inscrire</button>
			<a href="index.php"><button class="btn transparent">Accueil</button></a>
                    </div>

                    <img src="./assets/images/basketball.svg" alt="" class="image">
                </div>

                <div class="panel right-panel">
                    <div class="content">
                        <h3>Déjà l'un d'entre nous ?</h3>
                        <p>Connecte toi et retrouve ton contenu privé ainsi que tes privilèges insolites !</p>
                        <button class="btn transparent" id="sign-in-btn">Se connecter</button>
			<a href="index.php"><button class="btn transparent">Accueil</button></a>
                    </div>

                    <img src="./assets/images/goal.svg" alt="" class="image">
                </div>
            </div>

        </div>
    </main>

    <script src="./js/app.js"></script>

    </body>
</html>

