<?php
function h($val) { return htmlentities($val, ENT_QUOTES); }
require 'car.inc.php';
$dbh = mysql_connect('db.example.com', 'example_user', 'some_password');
mysql_select_db('some_database');
$cars = Car::findAll();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Cars</title>
    <script type="text/javascript" src="jquery-1.2.3.min.js"></script>
    <script type="text/javascript" src="jquery.livequery.min.js"></script>
    <script type="text/javascript" src="jquery.ui-1.0.min.js"></script>
    <script type="text/javascript" src="cars.js"></script>
    <link rel="stylesheet" type="text/css" href="flora.tablesorter.css" />
    <link rel="stylesheet" type="text/css" href="flora.resizable.css" />
    <link rel="stylesheet" type="text/css" href="flora.dialog.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" type="text/css" href="print.css" media="print" />
  </head>
  <body class="flora">
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
<?php foreach ($cars as $car) { $carfax=file_exists('carfax/'.$car->vin.'.html'); ?>
        <tr id="<?= h($car->id) ?>">
          <td class="price"><?= h($car->price) ?></td>
          <td class="make"><?= h($car->make) ?></td>
          <td class="model"><?= h($car->model) ?></td>
          <td class="year"><?= h($car->year) ?></td>
          <td class="mileage"><?= h($car->mileage) ?></td>
          <td class="vin"><? if ($carfax) { ?><a href="carfax/<?= h($car->vin) ?>.html"><? } ?><?= h($car->vin) ?><? if ($carfax) { ?></a><? } ?></td>
          <td class="dealer"><a href="<?= h($car->uri) ?>"><?= h($car->dealer) ?></a></td>
          <td class="edit"><a href="edit.php?id=<?= h($car->id) ?>"><img src="images/edit.png" alt="Edit" /></a></td>
          <td class="delete">
            <form method="post" action="delete.php" class="delete_form">
              <p>
                <input type="hidden" name="id" value="<?= h($car->id) ?>" />
                <input type="image" src="images/delete.png" value="Delete" alt="Delete" />
              </p>
            </form>
          </td>
        </tr>
<?php } ?>
      </tbody>
    </table>
    <div id="add">
      <h2>Add Car</h2>
      <form id="add_form" method="post" action="add.php">
        <table>
          <tbody>
            <tr>
              <td>Price</td>
              <td><input type="text" name="price" /></td>
            </tr>
            <tr>
              <td>Make</td>
              <td><input type="text" name="make" /></td>
            </tr>
            <tr>
              <td>Model</td>
              <td><input type="text" name="model" /></td>
            </tr>
            <tr>
              <td>Year</td>
              <td><input type="text" name="year" /></td>
            </tr>
            <tr>
              <td>Mileage</td>
              <td><input type="text" name="mileage" /></td>
            </tr>
            <tr>
              <td>VIN</td>
              <td><input type="text" name="vin" /></td>
            </tr>
            <tr>
              <td>Website</td>
              <td><input type="text" name="uri" /></td>
            </tr>
            <tr>
              <td>Dealer</td>
              <td><input type="text" name="dealer" /></td>
            </tr>
            <tr>
              <td colspan="2" align="right"><input type="submit" value="Add" /></td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
  </body>
</html>
<?php
mysql_close($dbh);
?>