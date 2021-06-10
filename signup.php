<?php session_start();
$title = "Créer un compte";
include 'includes/head.php';
?>


<main>

    <div class="signup-container">

        <div class="signup-showcase">
            <video src="./assets/videos/james_harden.mp4" class="showcase-video" autoplay muted loop></video>
            <h1 class="logo">MyTeam</h1>
        </div>

        <div class="signup-form">


            <div class="description">
                <h2>Joignez notre communauté et exprimer votre compétitivité et passion pour le sport !</h2>
                <p>L'inscription est totalement gratuite, offrez vous un abonnement <span class="red question bold">MyTeam</span> pour profiter d'avantages exclusif... <span class="blue">En savoir plus !</span>
                <p>
            </div>

            <form action="signup_check.php" method="POST">
                <div class="sign-input-row">
                    <div class="sign-input">
                        <i class="fas fa-user"></i>
                        <input type="text" name="firstname" placeholder="First Name...">
                    </div>
                    <div class="sign-input">
                        <i class="fas fa-user"></i>
                        <input type="text" name="lastname" placeholder="Last Name...">
                    </div>
                </div>
                <div class="sign-input">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username...">
                </div>
                <div class="sign-input">
                    <i class="fas fa-number"></i>
                    <input type="number" name="age" placeholder="Age...">
                </div>
                <div class="sign-input">
                    <i class="fas fa-envelope"></i>
                    <input type="text" name="email" placeholder="Email...">
                </div>
                <div class="sign-input">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password...">
                </div>
                <div class="sign-input">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password_repeat" placeholder="Repeat the password...">
                </div>
                <select name="sport" id="select-fav-sport">
                    <option disabled selected>Sport </option>
                    <option value="1">Soccer</option>
                    <option value="2">Basketball</option>
                </select>
                <div class="terms">
                    <input type="checkbox" name="terms" id="terms">
                    <label for="terms">J'accepte les termes de <span class="blue">sécurité et confidentialité</span></label>
                </div>
                <!-- <select name="plan" id="select-plan">
                    <option value="1">Basic</option>
                    <option value="2">Premium</option>
                </select> -->
                <!-- <select name="role" id="select-role">
                    <option value="1">User</option>
                    <option value="2">Technician</option>
                    <option value="3">Admin</option>
                    <option value="4">Super Admin</option>
                </select> -->
                <!-- <select name="status" id="select-status">
                    <option value="1">Unverified</option>
                    <option value="2">Active</option>
                    <option value="3">Unavaiable</option>
                    <option value="4">Banned temp.</option>
                    <option value="5">Banned def.</option>
                </select> -->

                <button name="submit" type="submit">Sign Up !</button>


            </form>

        </div>

    </div>

</main>


<?php

include 'includes/footer.php';
