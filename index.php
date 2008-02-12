<?php
function h($val) { return htmlentities($val, ENT_QUOTES); }
require 'car.inc.php';
mysql_connect('db.example.com', 'example_user', 'some_password');
$dbh = mysql_select_db('some_database');
$cars = Car::findAll();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Cars</title>
    <script type="text/javascript" src="jquery-1.2.3.min.js"></script>
    <script type="text/javascript" src="jquery.ui-1.0.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() { $('#cars').tablesorter(); });
    </script>
    <link rel="stylesheet" type="text/css" href="flora.tablesorter.css" />
  </head>
  <body>
    <h1>Cars</h1>
    <table id="cars" class="tablesorter">
      <thead>
        <tr>
          <th>Price</th>
          <th>Make</th>
          <th>Model</th>
          <th>Year</th>
          <th>Mileage</th>
          <th>VIN</th>
          <th>Dealer</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cars as $car) { ?>
        <tr>
          <td><?= h($car->price) ?></td>
          <td><?= h($car->make) ?></td>
          <td><?= h($car->model) ?></td>
          <td><?= h($car->year) ?></td>
          <td><?= h($car->mileage) ?></td>
          <td><a href="carfax/<?= h($car->vin) ?>.html"><?= h($car->vin) ?></a></td>
          <td><a href="<?= h($car->uri) ?>"><?= h($car->dealer) ?></a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </body>
</html>
<?php
mysql_close($dbh);
?>