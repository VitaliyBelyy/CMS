<?php

/**
 * Class to handle publishing houses
 */

class PublishingHouse
{
  // Properties

  public $id = null;

  public $name = null;

  public function __construct( $data=array() ) {
    if ( isset( $data['publishing_house_code'] ) ) $this->id = (int) $data['publishing_house_code'];
    if ( isset( $data['name'] ) ) $this->name = (string) $data['name'];
  }


  public function storeFormValues ( $params ) {

    // Store all the parameters
    $this->__construct( $params );
  }


  public static function getById( $id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT * FROM `Publishing_houses` WHERE `publishing_house_code`= :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new PublishingHouse( $row );
  }


  public static function getList( $numRows=1000000, $order="`name` ASC" ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `Publishing_houses`
            ORDER BY " . mysql_escape_string($order) . " LIMIT :numRows";

    $st = $conn->prepare( $sql );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $publishingHouse = new PublishingHouse( $row );
      $list[] = $publishingHouse;
    }

    // Now get the total number of records that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current PublishingHouse object into the database, and sets its ID property.
  */

  public function insert() {

    // Does the PublishingHouse object already have an ID?
    if ( !is_null( $this->id ) && $this->id != 0 ) trigger_error ( "PublishingHouse::insert(): Attempt to insert a PublishingHouse object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Insert the PublishingHouse
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO `Publishing_houses` ( name ) VALUES ( :name )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current PublishingHouse object in the database.
  */

  public function update() {

    // Does the PublishingHouse object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "PublishingHouse::update(): Attempt to update a PublishingHouse object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the PublishingHouse
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE `Publishing_houses` SET name=:name WHERE `publishing_house_code` = :id";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Deletes the current PublishingHouse object from the database.
  */

  public function delete() {

    // Does the Author object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "PublishingHouse::delete(): Attempt to delete a PublishingHouse object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Author
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM `Publishing_houses` WHERE `publishing_house_code` = :id LIMIT 1" );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>
