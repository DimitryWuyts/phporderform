<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//we are going to use session variables so we need to enable sessions
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

//your products with their price.
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
            $errors[] = "<a href='#email' class='alert-link'>$email</a> is not a valid email addres!";
        }
    }
}
$totalValue = 0;

 require 'form-view.php';

?>

