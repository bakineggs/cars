<?php
class Car
{
  private static $_rows = array();
  public $id = 0, $price, $make, $model, $year, $mileage, $vin, $uri, $dealer;
  public function __construct($id = 0)
  {
    self::getRows();
    if (self::$_rows[$id])
    {
      $this->id = $id;
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
      $query = mysql_query("select * from cars where deleted=0");
      while ($row = mysql_fetch_assoc($query))
        self::$_rows[$row['id']] = $row;
    }
  }
  public function save()
  {
    if ($this->id == 0)
    {
      mysql_query("insert into cars () values ()");
      $this->id = mysql_insert_id();
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
    mysql_query('replace into cars (`'.implode('`, `',array_map('mysql_real_escape_string',array_keys(self::$_rows[$this->id]))).'`) values (\''.implode("', '",array_map('mysql_real_escape_string',self::$_rows[$this->id])).'\')');
    self::getRows(true);
  }
  public function delete()
  {
    if ($this->id == 0)
      return false;
    mysql_query('update cars set deleted=1 where id=\''.mysql_real_escape_string($this->id).'\'');
    self::getRows(true);
    return mysql_affected_rows()>0;
  }
}
?>