<?php

//strict type
declare(strict_types=1);

//enable errors
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//enable sessions
session_start();

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

//products with price
if(isset($_GET["food"]) && $_GET["food"] == 0){
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
} else {
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $alerts = [];
    $errors = [];

//email
    $email = test_input($_POST["email"]);

    //if empty, alert
    if (empty($email)) {
        $alerts[] = "Please fill in your <a href='#email' class='alert-link'>E-mail</a>!";
    } else {
        //if invalid email, error
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "<a href='#email' class='alert-link'>$email</a> is not a valid email address!";
        }
    }

    //address
    $street = test_input($_POST["street"]);
    $streetnumber = test_input($_POST["streetnumber"]);
    $city = test_input($_POST["city"]);
    $zipcode = test_input($_POST["zipcode"]);

    //making sure address is valid
    if (empty($street)) {
        $alerts[] = "Please fill in your <a href='#street' class='alert-link'>street</a>!";
    }

    if (empty($streetnumber)) {
        $alerts[] = "Please fill in your <a href='#streetnumber' class='alert-link'>street number</a>!";
    } else {
        if (!is_numeric($streetnumber)) {
            $errors[] = "<a href='#streetnumber' class='alert-link'>Street Number</a> only numbers!";
        }
    }

    if (empty($city)) {
        $alerts[] = "Please fill in your <a href='#city' class='alert-link'>city</a>!";
    }

    if (empty($zipcode)) {
        $alerts[] = "Please fill in your <a href='#zipcode' class='alert-link'>zipcode</a>!";
    } else {
        if (!is_numeric($zipcode)) {
            $errors[] = "<a href ='#zipcode' class='alert-link'>Zipcode</a> only numbers!";
        }

    }
//making sure they order

    $checked = [];

    if (!empty($_POST["products"])){
        $checked = $_POST["products"];
    }

    if (empty($checked)){
        $errors[] = "You didn't <a href ='#products' class='alert-link'>order</a> something";
    }


    if (empty($alerts) && empty($errors)) {
        echo ("<div class='alert alert-success text-center' role='alert'>
           <p class='alert-heading'>You have placed your <a href ='#products' class='alert-link'>order</a></p></div>");

    }

}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

 //session variables
$street = "";
$streetNumber = "";
$city = "";
$zipCode = "";
$email = "";

if (!empty($_POST)) {
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["street"] = $_POST["street"];
    $_SESSION["streetnumber"] = $_POST["streetnumber"];
    $_SESSION["city"] = $_POST["city"];
    $_SESSION["zipcode"] = $_POST["zipcode"];
}
if (!empty($_SESSION["email"])) {
    $email = $_SESSION["email"];
}
if (!empty($_SESSION["street"])) {
    $street = $_SESSION["street"];
}
if (!empty($_SESSION["streetnumber"])) {
    $streetNumber = $_SESSION["streetnumber"];
}
if (!empty($_SESSION["city"])) {
    $city = $_SESSION["city"];
}
if (!empty($_SESSION["zipcode"])) {
    $zipCode = $_SESSION["zipcode"];
}
if (!empty($errors)){
    foreach ($errors as $error){
        echo ("<div class='alert alert-danger' role='alert'>" . $error . "</div>");
    }
}
if (!empty($alerts)){
    foreach ($alerts as $alert){
        echo ("<div class='alert alert-warning' role='alert'>" . $alert . "</div>");
    }
}
//create cookies

if (!isset($_COOKIE["sum"])){
    if(!empty($checked)){
        $totalValue = array_sum($checked);
        setcookie("sum", strval($totalValue), time()+(365*24*60*60));
    }
    else{
        $totalValue = '0';
        setcookie("sum", strval($totalValue), time()+(365*24*60*60));
    }
}
else{
    if (!empty($checked)){
        $totalValue = $_COOKIE["sum"] + array_sum($checked);
        setcookie("sum", strval($totalValue), time()+(365*24*60*60));
    }
    else{
        $totalValue = $_COOKIE["sum"];
        setcookie("sum", strval($totalValue), time()+(365*24*60*60));
    }

}

require 'form-view.php';