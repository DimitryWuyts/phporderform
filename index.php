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
$totalValue = 0;

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
    $email = input($_POST["email"]);

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
    $street = input($_POST["street"]);
    $streetNumber = input($_POST["streetnumber"]);
    $city = input($_POST["city"]);
    $zipCode = input($_POST["zipcode"]);

//making sure address is valid
    if (empty($street)) {
        $alerts[] = "Please fill in your <a href='#street' class='alert-link'>street</a>!";
    }
    if (empty($streetnumber)) {
        $alerts[] = "Please fill in your <a href='#streetnumber' class='alert-link'>street number</a>!";
    } else {
        if (!is_numeric($streetnumber)) {
            $errors[] = "<a href='#streetnumber' class='alert-link'>Street Number</a> only accepts numbers!";
        }
        if (empty($city)) {
            $alerts[] = "Please fill in your <a href='#city' class='alert-link'>city</a>!";
        }

        if (empty($zipcode)) {
            $alerts[] = "Please fill in your <a href='#zipcode' class='alert-link'>zipcode</a>!";
        } else {
            if (!is_numeric($zipcode)) {
                $errors[] = "<a href ='#zipcode' class='alert-link'>Zipcode</a> only accepts numbers!";
            }
        }
    }
}
require 'form-view.php';

