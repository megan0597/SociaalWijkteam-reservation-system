<?php

//settings
$host = 'localhost';
$user = '0892322';
$password = '1f18d59e';
$db = '0892322';


$dbLink = mysqli_connect($host, $user, $password, $db); //connection to database

// admin login:
//             email: admin@admin.nl
//             password: admin

// costumer login:
//                email: test@test.nl
//                password: test


// if you want to make another admin you need to set the value in the admin row to 1
// the admin row's standard is NULL
