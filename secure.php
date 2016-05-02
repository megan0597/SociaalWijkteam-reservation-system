<?php
session_start();

// if there is no login then send person back to index.php page to login
if (!isset($_SESSION['login'])) {
    header('location: index.php');
    exit;
}
//session for name
$name = $_SESSION['login'];
//session for id
$id = $_SESSION['login_id'];

require_once("config.php"); // includes the database connection


if (isset($_POST['submit'])) {

    // variables for the validation
    $formok = true;
    $dayError = $timeError = $locationError = "";

    //variables so you don't have to write everything out
    $day = mysqli_escape_string($dbLink, $_POST['day']);
    $time = mysqli_escape_string($dbLink, $_POST['time']);
    $location = mysqli_escape_string($dbLink, $_POST['location']);

    // here we check if the form is filled
    if (empty($day)) {
        //if not, set $formok on false and give error message
        $formok = false;
        $dayError = "Vul alle velden in a.u.b.";
    }

    if (empty($time)) {
        $formok = false;
        $timeError = "Vul alle velden in a.u.b.";
    }

    if (empty($location)) {
        $formok = false;
        $locationError = "Vul alle velden in a.u.b.";
    }

    // if everything is filled, select with data
    if ($formok == true) {
        $sql_select = "SELECT day, time, location FROM Appointment WHERE day ='" . $day . "' AND time ='" . $time . "' AND location ='" . $location . "'";
        $result_select = mysqli_query($dbLink, $sql_select);

        if (mysqli_num_rows($result_select) == 1) {
            $booked = "tijd is bezet, kies een andere tijd";

        } else {
            $sql_insert = "INSERT INTO Appointment (day, time, location, User_id) VALUES ('$day', '$time', '$location', '$id')";
            $result_insert = mysqli_query($dbLink, $sql_insert);

            if ($result_insert != false) {
                $success = "De afspraak is gemaakt";
            } else {
                echo "er is geen resultaat";
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <title>Afspraak maken</title>
    <meta name="description" content="Afspraak maken"/>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Fresca' rel='stylesheet' type='text/css'>
    <link href="secure.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div id="header">
    <a href="http://www.swtzaanstad.nl/peldersveld-plus-hoornseveld/" target="_blank">
        <img id="logo" src="http://www.swtzaanstad.nl/images/masterPage/logoNew.png" alt="Sociaal Wijkteam logo">
    </a>

    <div class="intro">Peldersveld</div>
    <div class="intro">Hoornseveld</div>

    <div id="welcome-text">
        Welkom <?= $name; ?>,<br> Je bent ingelogd!
    </div>
    <div id="logout">
        <a href="logout.php">Uitloggen</a>
    </div>
    <div id="edit">
        <a href="edit.php">Gegevens</a>
    </div>
</div>
<div id="main-image">
    <img id="image" src="http://www.swtzaanstad.nl/media/1012/foto-homepage.jpg" alt="">
</div>
<div id="tittle">
    Afspraak maken
</div>

<div id="main-text">
    Om een afspraak te maken kiest u eerst een dag:
    Wij zijn open van Maandag tot en met Donderdag.
    Verder krijgt u de mogelijkheid om een tijd te kiezen die u het beste uitkomt.
    Als laatste kiest u de locatie. Voor het geval u niet goed te been bent is er de mogelijkheid dat wij naar u toekomen.
    Anders gaan wij ervan uit dat u op locatie naar ons toe komt.
</div>

<form id="form" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

    <label for="day">Openingsdagen: Maandag t/m Donderdag</label>
    <input type="date" name="day" id="day" class="form">

    <label for="time">Kies een tijd:</label>
    <select id="time" name="time" class="form">
        <option value="09:00-10:00">09:00-10:00</option>
        <option value="10:00-11:00">10:00-11:00</option>
        <option value="10:00-11:00">11:00-12:00</option>
        <option value="10:00-11:00">12:00-13:00</option>
        <option value="10:00-11:00">13:00-14:00</option>
        <option value="10:00-11:00">14:00-15:00</option>
        <option value="10:00-11:00">15:00-16:00</option>
    </select>

    <label for="visit">Thuisbezoek</label>
    <input type="radio" name="location" value="Thuisbezoek" id="visit" class="form" required>

    <label for="location">Op locatie</label>
    <input type="radio" name="location" value="Op locatie" id="location" class="form" required>

    <label for="submit"></label>
    <input type="submit" id="submit" value="Maak afspraak" name="submit"/>
</form>

<div id="success">
    <?php
    echo isset($success) ? $success : ""; //if exists echo $success, else echo " " (nothing)
    ?>
</div>

<div id="booked">
    <?php
    echo isset($booked) ? $booked : ""; //if exists echo $booked, else echo " " (nothing)
    ?>
</div>

<div id="fail">
    <?php
    echo isset($dayError, $timeError, $locationError) ? $dayError . $timeError . $locationError : ""; //if exists echo $....Error, else echo " " (nothing)
    ?>
</div>
<script type="text/javascript" src="secure.js"></script>
</body>
</html>

