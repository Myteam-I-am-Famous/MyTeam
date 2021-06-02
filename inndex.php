<?php

if(isset($_SESSION['user']) && !empty($_SESSION['user'])){

    ?>
    <p>Bonjour <?= $_SESSION['user']['pseudo'] ?> <a class="btn btn-danger" href="login.php">Déconnexion</a></p>
<?php
}else{
    ?>
    <a class="btn btn-primary mr-2" href="login.php">Connexion</a> <a class="btn btn-primary" href="login.php">Inscription</a>
<?php
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Mon chat</title>
</head>

<body>
    <section class="container">
        <main class="row">
<div class="col-12 my-1">
    <div class="p-2" id="discussion">
    </div>
</div>
<div class="col-12 saisie">
    <div class="input-group">
        <input type="text" class="form-control" id="texte" placeholder="Entrez votre texte">
        <div class="input-group-append">
            <span class="input-group-text" id="valid"><i class="la la-check"></i></span>
        </div>
    </div>
</div>
        </main>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript" src="scripts.js/scripts.js"></script>
       <style>
       body{
	overflow: hidden;
	background-color: rgba(255,255,255,0.1);
}

#discussion{
	height: 78vh;
	box-shadow: 0 0 5px grey;
	overflow-y: scroll;
}

.saisie{
	height: 20vh;
}
       </style>
</body>

</html>


