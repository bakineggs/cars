<?php
require 'required.inc.php';
$car = new Car($_POST['id']);
$deleted = $car->delete();
if ($_POST['js']=='true')
  echo json_encode(array('deleted' => $deleted));
else
  header('Location: index.php');
mysql_close($dbh);
?>