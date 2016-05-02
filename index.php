<?php

session_start();

//including database connection
require_once("config.php");

//if user is already logged in, send him back to secure.php
if (isset($_SESSION['login'])) {
    header('location: secure.php');
    exit;
}

// if submit is clicked, run the query
if (isset($_POST['submit'])) {

    // variables so you don't have to write everything out
    $email = mysqli_escape_string($dbLink, $_POST['email']);
    $password = mysqli_escape_string($dbLink, $_POST['password']);
    $password = md5($password); // md5() for password protection

    $sql = "SELECT id, name, admin FROM User WHERE email ='" . $email . "' AND password ='" . $password . "'";
    $result = mysqli_query($dbLink, $sql);

    // if there is something in the db, header('Location: ...') sends user to the secure.php page
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        //create sessions to use in other pages
        $_SESSION['login'] = $user['name'];
        $_SESSION['login_id'] = $user['id'];
        $_SESSION['admin'] = $user['admin'];

        //if admin is 1 then send the admin to the admin.php page
        if ($_SESSION['admin'] == 1) {
            header('Location: admin.php');
            exit;
        }

        header('Location: secure.php');
        exit;
    } else {
        $error = "verkeerde gegevens!";
    }
}

?>
<!doctype html>
<html>
<head>
    <title>Login</title>
    <meta name="description" content="Login"/>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Fresca' rel='stylesheet' type='text/css'>
    <link href="index.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div id="header">
    <a href="http://www.swtzaanstad.nl/peldersveld-plus-hoornseveld/" target="_blank">
        <img id="logo" src="http://www.swtzaanstad.nl/images/masterPage/logoNew.png" alt="Sociaal Wijkteam logo">
    </a>

    <div class="intro">Peldersveld</div>
    <div class="intro">Hoornseveld</div>
    <div id="login">Log-in</div>
    <form id="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="email" name="email" class="input" placeholder="Email"/>
        <input type="password" name="password" class="input" placeholder="Wachtwoord"/>
        <input type="submit" id="submit" value="Inloggen" name="submit"/>
    </form>
    <div id="error">
        <?php
        echo isset($error) ? $error : ""; //if exists echo $error, else echo " " (nothing)
        ?>
    </div>
    <a id="create-account" href="registration.php">Creeër account</a>

</div>
<div id="main-image">
    <img id="image" src="http://www.swtzaanstad.nl/media/1012/foto-homepage.jpg" alt="">
</div>
<div id="main-text">
    Afspraak maken
</div>
<div id="login-text">
    Log in om een afspraak te maken
</div>
</body>
</html>
