<?php
require 'required.inc.php';

$recaptcha_response = recaptcha_check_answer(RECAPTCHA_PRIVATE_KEY,
                                             $_SERVER["REMOTE_ADDR"],
                                             $_POST["recaptcha_challenge_field"],
                                             $_POST["recaptcha_response_field"]);
if (!$recaptcha_response->is_valid) {
  $recaptcha = recaptcha_get_html(RECAPTCHA_PUBLIC_KEY, $recaptcha_response->error);

  if ($_POST['js'] == 'true')
    echo json_encode(array('recaptcha' => $recaptcha));
  else
    header('Location: index.php?recaptcha_error='.urlencode($recaptcha_response->error));
  die();
}

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
?>
