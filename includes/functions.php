<?php

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;

//Gerer les dépendences avec composer
//require '../vendor/autoload.php';

// * Utils

function emptyInputs($inputs)
{
    if (!is_array($inputs))
        return true;

    foreach ($inputs as $input) {
        if (empty($input))
            return true;
    }

    return false;
}

function is_between($value, $min, $max)
{
    if (!is_numeric($value))
        return false;

    return ($value >= $min && $value <= $max);
}


function userexists($dbh, $email)
{
    $q = 'SELECT email FROM utilisateurs WHERE email = :email;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'email' => $email
        )
    );

    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['email'])
            return true;
    }

    return false;
}

function getuserinfo($dbh, $info, $email)
{
    $q = 'SELECT ' . $info . ' FROM utilisateurs WHERE email = :email;';
    $stmt = $dbh->prepare($q);

    $status = $stmt->execute(
        array(
            'email' => $email
        )
    );

    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result[$info];
    }

    return false;
}


function getmaxID($dbh)
{

    $q = 'SELECT MAX(id) FROM utilisateurs';
    $req = $dbh->prepare($q);
    $status = $req->execute();

    if ($status) {
        $result = $req->fetch();
        return $result[0];
    } else {
        return false;
    }
}

function sendVerificationMail($id, $to, $code)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->SMTPAuth = false;
        $mail->SMTPSecure = false;
        $mail->SMTPAutoTLS = false;

        $mail->Host = 'localhost';
        $mail->Port = 25;

        $mail->isHTML(true);
        $mail->SetFrom('no-reply@myteam.fr', '[MyTeam]');
        $mail->Subject = "Confirmation d'inscription";
        $mail->Body = 'Votre code de vérification est :'
            . $code
            . "<br><a href='141.94.17.218/includes/code_check.php?id={$id}&type=signup&code={$code}'>Cliquez sur ce lien pour vérifier votre compte</a>";
        $mail->CharSet = 'utf-8';

        $mail->AddAddress($to);

        $mail->Send();
        echo 'Mail sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mail Error: ' . $mail->ErrorInfo;
    }
}

function checkVerificationCode($dbh, $email, $code)
{
    if (!userexists($dbh, $email))
        return false;

    if (useractivated($dbh, $email))
        return false;
}

function useractivated($dbh, $id)
{


    $q = 'SELECT actif FROM utilisateurs WHERE id = :id;';
    $stmt = $dbh->prepare($q);

    $status = $stmt->execute(
        array(
            'id' => $id
        )
    );

    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['actif'];
    }

    return false;
}

function activateuser($dbh, $id)
{
    $q = 'UPDATE utilisateurs SET actif = 1 WHERE id = :id;';
    $stmt = $dbh->prepare($q);

    $status = $stmt->execute(
        array(
            'id' => $id
        )
    );

    return $status;
}


// * End Utils

// * Signup



function invalidAge($age)
{
    if (!is_numeric($age))
        return true;

    return $age < 18;
}

function createUser($dbh, $nom, $prenom, $age, $email, $mdp)
{
    $q = 'INSERT INTO utilisateurs (id, nom, prenom, age, email, mdp, hash, actif) VALUES(:id, :nom, :prenom, :age, :email, :mdp, :hash, :actif);';
    $stmt = $dbh->prepare($q);

    $code = rand(0, 1000);
    $hash = md5($code);



    $id = getmaxID($dbh) + 1;


    $status = $stmt->execute(
        array(
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'age' => $age,
            'email' => $email,
            'mdp' => password_hash($mdp, PASSWORD_DEFAULT),
            'hash' => $hash,
            'actif' => 0
        )
    );

    if ($status) {
        sendVerificationMail($id, $email, $code);
        return true;
    }

    return false;
}


// * End Signup


// * Login

function validpassword($dbh, $email, $mdp)
{
    $q = 'SELECT mdp FROM utilisateurs WHERE email = :email;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'email' => $email
        )
    );

    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['mdp']) {
            return password_verify($mdp, $result['mdp']);
        }
    }

    return false;
}

// * End Login
