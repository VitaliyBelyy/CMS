<?php

/**
 * Class to handle book sections
 */

class Section
{
  // Properties

  public $id = null;

  public $name = null;

  public function __construct( $data=array() ) {
    if ( isset( $data['section_code'] ) ) $this->id = (int) $data['section_code'];
    if ( isset( $data['name'] ) ) $this->name = (string) $data['name'];
  }


  public function storeFormValues ( $params ) {

    // Store all the parameters
    $this->__construct( $params );
  }


  public static function getById( $id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT * FROM `Sections` WHERE `section_code`= :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Section( $row );
  }


  public static function getList( $numRows=1000000, $order="`name` ASC" ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `Sections`
            ORDER BY " . mysql_escape_string($order) . " LIMIT :numRows";

    $st = $conn->prepare( $sql );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $section = new Section( $row );
      $list[] = $section;
    }

    // Now get the total number of sections that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current Section object into the database, and sets its ID property.
  */

  public function insert() {

    // Does the Section object already have an ID?
    if ( !is_null( $this->id ) && $this->id != 0 ) trigger_error ( "Section::insert(): Attempt to insert a Section object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Insert the Section
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO `Sections` ( name ) VALUES ( :name )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current Section object in the database.
  */

  public function update() {

    // Does the Section object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Section::update(): Attempt to update a Section object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the Section
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE `Sections` SET name=:name WHERE `section_code` = :id";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Deletes the current Section object from the database.
  */

  public function delete() {

    // Does the Section object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Section::delete(): Attempt to delete a Section object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Section
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM `Sections` WHERE `section_code` = :id LIMIT 1" );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>
