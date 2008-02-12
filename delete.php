<?php
function h($val) { return htmlentities($val, ENT_QUOTES); }
require 'car.inc.php';
$dbh = mysql_connect('db.example.com', 'example_user', 'some_password');
mysql_select_db('some_database');
$car = new Car($_POST['id']);
$deleted = $car->delete();
if ($_POST['js']=='true')
  echo json_encode(array('deleted' => $deleted));
else
  header('Location: index.php');
mysql_close($dbh);
?>