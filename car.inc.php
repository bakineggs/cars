<?php
class Car
{
  private static $_rows = array();
  public $id = 0, $price, $make, $model, $year, $mileage, $vin, $uri, $dealer;
  public function __construct($id = 0)
  {
    self::getRows();
    if (self::$_rows[$id])
      $this->id = $id;
    $this->loadVariables(false);
  }
  public static function findAll()
  {
    self::getRows();
    $cars = array();
    foreach (array_keys(self::$_rows) as $id)
      $cars[] = new Car($id);
    return $cars;
  }
  private static function getRows($force = false)
  {
    if (!sizeof(self::$_rows) || $force)
    {
      $query = pg_query("select * from cars where not deleted");
      while ($row = pg_fetch_assoc($query))
        self::$_rows[$row['id']] = $row;
    }
  }
  public function jsonEncode()
  {
    return json_encode(array(
      'id' => $this->id,
      'price' => $this->price,
      'make' => $this->make,
      'model' => $this->model,
      'year' => $this->year,
      'mileage' => $this->mileage,
      'vin' => $this->vin,
      'carfax' => file_exists('carfax/'.$this->vin.'.html'),
      'uri' => $this->uri,
      'dealer' => $this->dealer
    ));
  }
  public function save()
  {
    if ($this->id == 0)
    {
      $this->id = pg_last_oid(pg_query("insert into cars () values ()"));
      self::$_rows[$this->id] = array();
    }
    self::$_rows[$this->id]['id'] = $this->id;
    self::$_rows[$this->id]['price'] = $this->price;
    self::$_rows[$this->id]['make'] = $this->make;
    self::$_rows[$this->id]['model'] = $this->model;
    self::$_rows[$this->id]['year'] = $this->year;
    self::$_rows[$this->id]['mileage'] = $this->mileage;
    self::$_rows[$this->id]['vin'] = $this->vin;
    self::$_rows[$this->id]['uri'] = $this->uri;
    self::$_rows[$this->id]['dealer'] = $this->dealer;

    $updates = array();
    foreach (self::$_rows[$this->id] as $col => $val)
      $updates[] = pesc($col) . '=' . pesc($val);

    pg_query('update cars set ' . implode(', ', $updates) . ' where id=\'' . pesc($this->id) . '\'');
    $this->loadVariables();
  }
  public function delete()
  {
    if ($this->id == 0)
      return false;
    $result = pg_query('update cars set deleted=TRUE where id=\''.pesc($this->id).'\'');
    self::getRows(true);
    return pg_affected_rows($result) > 0;
  }
  private function loadVariables($getrows = true)
  {
    if ($getrows)
      self::getRows(true);
    if (self::$_rows[$this->id])
    {
      $this->price = self::$_rows[$this->id]['price'];
      $this->make = self::$_rows[$this->id]['make'];
      $this->model = self::$_rows[$this->id]['model'];
      $this->year = self::$_rows[$this->id]['year'];
      $this->mileage = self::$_rows[$this->id]['mileage'];
      $this->vin = self::$_rows[$this->id]['vin'];
      $this->uri = self::$_rows[$this->id]['uri'];
      $this->dealer = self::$_rows[$this->id]['dealer'];
    }
  }
}
?>
