<?php
class Car
{
  private static $_rows = array();
  public $id, $price, $make, $model, $year, $mileage, $vin, $uri, $dealer;
  public function __construct($id = 0)
  {
    $this->id = $id;
    if (!sizeof(self::$_rows))
    {
      $query = mysql_query("select * from cars");
      while ($row = mysql_fetch_assoc($query))
        self::$_rows[$row['id']] = $row;
    }
    if (self::$_rows[$this->id])
    {
      $this->price = $rows[$this->id]['price'];
      $this->make = $rows[$this->id]['make'];
      $this->model = $rows[$this->id]['model'];
      $this->year = $rows[$this->id]['year'];
      $this->mileage = $rows[$this->id]['mileage'];
      $this->vin = $rows[$this->id]['vin'];
      $this->uri = $rows[$this->id]['uri'];
      $this->dealer = $rows[$this->id]['dealer'];
    }
  }
  public function save()
  {
    if ($this->id == 0)
    {
      mysql_query("insert into cars () values ()");
      $this->id = mysql_insert_id();
    }
    self::$_rows['id'] = $this->id;
    self::$_rows['price'] = $this->price;
    self::$_rows['make'] = $this->make;
    self::$_rows['model'] = $this->model;
    self::$_rows['year'] = $this->year;
    self::$_rows['mileage'] = $this->mileage;
    self::$_rows['vin'] = $this->vin;
    self::$_rows['uri'] = $this->uri;
    self::$_rows['dealer'] = $this->dealer;
    mysql_query('replace into cars (`'.implode('`, `',array_map('mysql_real_escape_string',array_keys(self::$_rows[$this->id]))).'`) values (\''.implode("', '",array_map('mysql_real_escape_string',self::$_rows[$this->id])).'\')');
  }
}
?>