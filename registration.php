<?php

require_once("config.php"); //includes the database connection


if (isset($_POST['submit'])) {


    // variables for the validation
    $formok = true;
    $emailError = $passwordError = $nameError = $surnameError = $streetError = $numberError = $zipcodeError = $districtError = "";

    //variables so you don't have to write everything out
    $email = mysqli_escape_string($dbLink, $_POST['email']);
    $password = mysqli_escape_string($dbLink, $_POST['password']);
    $password = md5($password); // md5() for password protection
    $name = mysqli_escape_string($dbLink, $_POST['name']);
    $surname = mysqli_escape_string($dbLink, $_POST['surname']);
    $street = mysqli_escape_string($dbLink, $_POST['street']);
    $number = mysqli_escape_string($dbLink, $_POST['number']);
    $zipcode = mysqli_escape_string($dbLink, $_POST['zipcode']);
    $district = mysqli_escape_string($dbLink, $_POST['district']);

    // here we check if the form is filled
    if (empty($email)) {
        //if not, set $formok on false and give error message
        $formok = false;
        $emailError = "Vul alle velden in a.u.b.";
    }

    if (empty($password)) {
        $formok = false;
        $passwordError = "Vul alle velden in a.u.b.";
    }

    if (empty($name)) {
        $formok = false;
        $nameError = "Vul alle velden in a.u.b.";
    }

    if (empty($surname)) {
        $formok = false;
        $surnameError = "Vul alle velden in a.u.b.";
    }

    if (empty($street)) {
        $formok = false;
        $streetError = "Vul alle velden in a.u.b.";
    }

    if (empty($number)) {
        $formok = false;
        $numberError = "Vul alle velden in a.u.b.";
    }

    if (empty($zipcode)) {
        $formok = false;
        $zipcodeError = "Vul alle velden in a.u.b.";
    }

    if (empty($district)) {
        $formok = false;
        $districtError = "Vul alle velden in a.u.b.";
    }

    // if everything is filled, insert with data
    if ($formok) {
        $sql = "INSERT INTO User (email, password, name, surname, street, number, zipcode, district)
                VALUES ('$email', '$password', '$name', '$surname', '$street', '$number', '$zipcode', '$district')";


        if ($result = mysqli_query($dbLink, $sql)) {
            $success = "Account succesvol aangemaakt";
        } else {
            echo "er ging iets mis!";
        }

    }
}
?>
<!doctype html>
<html>
<head>
    <title>Registreren</title>
    <meta name="description" content="Registreren"/>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Fresca' rel='stylesheet' type='text/css'>
    <link href="registration.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div id="container">
    <div id="text">Acount aanmaken</div>
    <div id="registration">

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <label for="email"></label>
            <input type="email" name="email" class="left" id="email" placeholder="Email"/>

            <label for="password"></label>
            <input type="password" name="password" class="left" id="password" placeholder="Wachtwoord"/>

            <label for="name"></label>
            <input type="text" name="name" class="left" id="name" placeholder="Voornaam"/>

            <label for="surname"></label>
            <input type="text" name="surname" class="left" id="surname" placeholder="Achternaam"/>

            <label for="street"></label>
            <input type="text" name="street" class="right" id="street" placeholder="Straatnaam"/>

            <label for="number"></label>
            <input type="text" name="number" class="right" id="number" placeholder="Huisnummer"/>

            <label for="zipcode"></label>
            <input type="text" name="zipcode" class="right" id="zipcode" placeholder="Postcode"/>

            <label for="district"></label>
            <select class="right" id="district" name="district">
                <option value="pelders-/hoornseveld">Pelders-/Hoornseveld</option>
                <option value="poelenburg">Poelenburg</option>
            </select>

            <label for="submit"></label>
            <input type="submit" name="submit" id="submit" value="Maak aan"/>
        </form>
        <div id="fail">
            <?php
            echo isset($emailError, $passwordError, $nameError, $surnameError, $streetError, $numberError, $zipcodeError, $districtError)
                ? $emailError . $passwordError . $nameError . $surnameError . $streetError . $numberError . $zipcodeError . $districtError : "";
                 // if exists echo $...Error, else echo " " (nothing)
            ?>
        </div>

        <div id="success">
            <?php
            echo isset($success) ? $success : ""; //if exists echo $success, else echo " " (nothing)
            ?>
        </div>

        <div id="link">
            <a id="back-to-page" href="index.php">Terug</a>
        </div>

    </div>
</div>
</body>
</html>

