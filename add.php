<?php
require 'required.inc.php';
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
if ($_POST['js']=='true')
  echo $car->jsonEncode();
else
  header('Location: index.php');
mysql_close($dbh);
?>