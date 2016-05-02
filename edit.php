<?php

session_start();

require_once("config.php"); // including database connection


if (isset($_POST['submit'])) {

    // variables for the validation
    $formok = true;
    $emailError = $passwordError = $nameError = $surnameError = $streetError = $numberError = $zipcodeError = $districtError = "";

    //variables so you don't have to write everything out
    $email = mysqli_escape_string($dbLink, $_POST['email']);
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
        $districtErrorError = "Vul alle velden in a.u.b.";
    }

    // if everything is filled, update with new data
    if ($formok) {

        // update database
        $sql_update = "UPDATE User
            SET email ='$email', name ='$name', surname='$surname', street='$street', number='$number', zipcode='$zipcode', district='$district'
            WHERE id='" . $_POST['id'] . "'";

        if (!mysqli_query($dbLink, $sql_update)) {
            echo "er is iets fout gegaan";
        }

        //if the update worked locate user back to where they were
        header('Location: index.php');
        exit;
    }

} else {
    // we get the ID from a session we made
    $updateId = $_SESSION['login_id'];
}

//Select current user
$sql_select = "SELECT * FROM User WHERE id='" . $_SESSION['login_id'] . "'";

//Get current user
If (!($resultUser = mysqli_query($dbLink, $sql_select))) {
    echo "er is iets fout gegaan" . mysqli_error($dbLink) . ' QUERY: ' . $sql_select;
    $user = false;
} else {
    // this shows the users information on the screen
    $user = mysqli_fetch_assoc($resultUser);
}

?>
<!doctype html>
<html>
<head>
    <title>Aanpassen</title>
    <meta name="description" content="Aanpassen"/>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Fresca' rel='stylesheet' type='text/css'>
    <link href="edit.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div id="container">
    <div id="text">Gegevens</div>
    <div id="registration">

<!--        if you have the right user show his information in the form-->
        <?php if ($user != false) { ?>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <label for="email"></label>
                <input type="email" name="email" class="left" id="email" placeholder="Email"
                       value="<?= $user['email']; ?>"/>

                <label for="name"></label>
                <input type="text" name="name" class="left" id="name" placeholder="Voornaam"
                       value="<?= $user['name']; ?>"/>

                <label for="surname"></label>
                <input type="text" name="surname" class="left" id="surname" placeholder="Achternaam"
                       value="<?= $user['surname']; ?>"/>

                <label for="street"></label>
                <input type="text" name="street" class="right" id="street" placeholder="Straatnaam"
                       value="<?= $user['street']; ?>"/>

                <label for="number"></label>
                <input type="text" name="number" class="right" id="number" placeholder="Huisnummer"
                       value="<?= $user['number']; ?>"/>

                <label for="zipcode"></label>
                <input type="text" name="zipcode" class="right" id="zipcode" placeholder="Postcode"
                       value="<?= $user['zipcode']; ?>"/>

                <label for="district"></label>
                <select class="right" id="district" name="district">
                    <option
                        value="Pelders-/Hoornseveld" <?= ($user['district'] == "Pelders-/Hoornseveld") ? "selected" : "" ?>>
                        Pelders-/Hoornseveld
                    </option>
                    <option value="Poelenburg" <?= ($user['district'] == "Poelenburg") ? "selected" : "" ?>>Poelenburg
                    </option>
                </select>

                <input type="hidden" name="id" value="<?php print $user ['id']; ?>">

                <label for="submit"></label>
                <input type="submit" name="submit" id="submit" value="Aanpassen"/>
            </form>
        <?php } ?>

        <div id="fail">
            <?php
            echo isset($emailError, $passwordError, $nameError, $surnameError, $streetError, $numberError, $zipcodeError)
                ? $emailError . $passwordError . $nameError . $surnameError . $streetError . $numberError . $zipcodeError : "";
                //if exists echo $...Error, else echo " " (nothing)
            ?>
        </div>

        <div id="link">
            <a id="back-to-page" href="index.php">Terug</a>
        </div>

    </div>
</div>
</body>
</html>
