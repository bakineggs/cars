<?php
function h($val) { return htmlentities($val, ENT_QUOTES); }
require 'car.inc.php';
$dbh = mysql_connect('db.example.com', 'example_user', 'some_password');
mysql_select_db('some_database');
$car = new Car();
$car->price = $_POST['price'];
$car->make = $_POST['make'];
$car->model = $_POST['model'];
$car->year = $_POST['year'];
$car->mileage = $_POST['mileage'];
$car->vin = $_POST['vin'];
$car->uri = $_POST['uri'];
$car->dealer = $_POST['dealer'];
$car->save();
header('Location: index.php');
mysql_close($dbh);
?>