<?php

/**
 * Class to handle book authors
 */

class Author
{
  // Properties

  public $id = null;

  public $fullName = null;

  public function __construct( $data=array() ) {
    if ( isset( $data['author_code'] ) ) $this->id = (int) $data['author_code'];
    if ( isset( $data['full_name'] ) ) $this->fullName = (string) $data['full_name'];
  }


  public function storeFormValues ( $params ) {

    // Store all the parameters
    $this->__construct( $params );
  }


  public static function getById( $id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT * FROM `Authors` WHERE `author_code`= :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Author( $row );
  }


  public static function getList( $numRows=1000000, $order="`full_name` ASC" ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `Authors`
            ORDER BY " . mysql_escape_string($order) . " LIMIT :numRows";

    $st = $conn->prepare( $sql );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $author = new Author( $row );
      $list[] = $author;
    }

    // Now get the total number of authors that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current Author object into the database, and sets its ID property.
  */

  public function insert() {

    // Does the Author object already have an ID?
    // ОШИБКА is_null
    if ( !is_null( $this->id ) && $this->id != 0 ) trigger_error ( "Author::insert(): Attempt to insert an Author object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Insert the Author
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO `Authors` ( full_name ) VALUES ( :fullName )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":fullName", $this->fullName, PDO::PARAM_STR );
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current Author object in the database.
  */

  public function update() {

    // Does the Author object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Author::update(): Attempt to update an Author object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the Author
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE `Authors` SET full_name=:fullName WHERE `author_code` = :id";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":fullName", $this->fullName, PDO::PARAM_STR );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Deletes the current Author object from the database.
  */

  public function delete() {

    // Does the Author object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Author::delete(): Attempt to delete an Author object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Author
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM `Authors` WHERE `author_code` = :id LIMIT 1" );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>
