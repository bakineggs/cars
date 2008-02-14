<?php
function h($val) { return htmlentities($val, ENT_QUOTES); }
require 'car.inc.php';
$dbh = mysql_connect('db.example.com', 'example_user', 'some_password');
mysql_select_db('some_database');
$car = new Car($_GET['id']);
if ($car->id == 0)
{
  header('Location:index.php');
  exit;
}
if ($_POST)
{
  $car->price = $_POST['price'];
  $car->make = $_POST['make'];
  $car->model = $_POST['model'];
  $car->year = $_POST['year'];
  $car->mileage = $_POST['mileage'];
  $car->vin = $_POST['vin'];
  $car->uri = $_POST['uri'];
  $car->dealer = $_POST['dealer'];
  $car->save();
  header('Location:index.php');
  exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Edit Car</title>
  </head>
  <body>
    <h1>Edit Car</h1>
    <form method="post">
      <table>
        <tbody>
          <tr>
            <td>Price</td>
            <td><input type="text" name="price" value="<?= h($car->price) ?>" /></td>
          </tr>
          <tr>
            <td>Make</td>
            <td><input type="text" name="make" value="<?= h($car->make) ?>" /></td>
          </tr>
          <tr>
            <td>Model</td>
            <td><input type="text" name="model" value="<?= h($car->model) ?>" /></td>
          </tr>
          <tr>
            <td>Year</td>
            <td><input type="text" name="year" value="<?= h($car->year) ?>" /></td>
          </tr>
          <tr>
            <td>Mileage</td>
            <td><input type="text" name="mileage" value="<?= h($car->mileage) ?>" /></td>
          </tr>
          <tr>
            <td>VIN</td>
            <td><input type="text" name="vin" value="<?= h($car->vin) ?>" /></td>
          </tr>
          <tr>
            <td>Website</td>
            <td><input type="text" name="uri" value="<?= h($car->uri) ?>" /></td>
          </tr>
          <tr>
            <td>Dealer</td>
            <td><input type="text" name="dealer" value="<?= h($car->dealer) ?>" /></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><input type="submit" value="Save" /></td>
          </tr>
        </tbody>
      </table>
    </form>
  </body>
</html>
<?php
mysql_close($dbh);
?>