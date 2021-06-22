<?php session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 2){
        header('location: ../home');
        exit;
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link rel="stylesheet" href="css/event.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body>


    <div class="create-event-container">

        <h1>CREER UN EVENEMENT !</h1>

        <form class="create-event" action="create_event_check.php" method="POST" enctype="multipart/form-data">

            <div class="input">
                <label for="title">TITRE</label>
                <input type="text" name="title" id="title">
            </div>
            <div class="input-row">

                <div class="input">
                    <label for="begin">DEBUT</label>
                    <input type="date" name="begin" id="begin">
                </div>
                <div class="input">
                    <label for="begin">FIN</label>
                    <input type="date" name="end" id="end">
                </div>
            </div>
            <div class="input">
                <label for="description">DESCRIPTION</label>
                <textarea name="description" id="description" cols="50" rows="10"></textarea>
            </div>

            <div class="input">
                <label for="image">Image de fond<small>(1920x1080 recommander)</small></label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>

            <div class="rules">
                <label class="rule">
                    <input type="checkbox" name="rule_1" value="1">
                    Minimum de points
                    <input type="number" name="min_points" min="10">
                </label>
                <label class="rule">
                    <input type="checkbox" name="rule_2" value="2">
                    Minimum de connexion
                    <input type="number" name="min_login" min="10">
                </label>
            </div>
            <label class="rule">
                RECOMPENSE 1er
                <input type="number" name="reward_first" min="10">
            </label>
            <label class="rule">
                RECOMPENSE 2nd
                <input type="number" name="reward_second" min="10">
            </label>
            <label class="rule">
                RECOMPENSE 3ieme
                <input type="number" name="reward_third" min="10">
            </label>
            <label class="rule">
                RECOMPENSE AUTRES
                <input type="number" name="reward_others" min="10">
            </label>

            <button type="submit" name="submit">CREER EVENEMENT !</button>

        </form>
    </div>

</body>

</html>
