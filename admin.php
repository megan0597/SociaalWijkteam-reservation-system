<?php
session_start();

// if $_SESSION['admin'] does not exist, return to index.php
if (!isset($_SESSION['admin'])) {
    header('location: index.php');
    exit;
}

$name = $_SESSION['login'];

//including database connection
require_once("config.php");


if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    // if delete is clicked, delete the select with a query
    if (isset($_POST['delete'])) {


        $sql_delete = "DELETE FROM Appointment WHERE id = $id ";


        $retval = mysqli_query($dbLink, $sql_delete);
    }
}

// shows all the appointments on screen
$sql_select = "SELECT id, day, time, location, User_id FROM Appointment";
$result = mysqli_query($dbLink, $sql_select);

if ($result->num_rows > 0) {

?>
<!doctype html>
<html>
<head>
    <title>Admin</title>
    <meta name="description" content="Admin"/>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Fresca' rel='stylesheet' type='text/css'>
    <link href="admin.css" type="text/css" rel="stylesheet"/>
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

</div>
<div id="main-image">
    <img id="image" src="http://www.swtzaanstad.nl/media/1012/foto-homepage.jpg" alt="">
</div>
<div id="tittle">
    Admin
</div>

<div id="main-text">
    Als admin heeft u hier de mogelijkheid afspraken te verwijderen wanneer dit nodig is.
</div>

<div id="appointments">
    Alle afspraken:
</div>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    <table id="table">
        <tr>
            <th>id</th>
            <th>dag</th>
            <th>tijd</th>
            <th>locatie</th>
            <th>id-gebruiker</th>
        </tr>
        <?php
        // a while loop to loop through the appointments
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?= $_SESSION['id'] = $row["id"]; ?></td>
                <td><?= $row["day"]; ?></td>
                <td><?= $row["time"]; ?></td>
                <td><?= $row["location"]; ?></td>
                <td><?= $row["User_id"]; ?></td>
                <td><input name="delete" type="submit" id="delete" value="Verwijder afspraak"></td>
            </tr>
        <?php } ?>
    </table>
    <?php } ?>
</form>

</body>
</html>
