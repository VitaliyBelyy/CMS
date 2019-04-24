<?php

/**
 * Class to handle book specifications
 */

class Specifications
{
  // Properties

  public $id = null;

  public $authorId = null;

  public $publishingHouseId = null;

  public $language = null;

  public $publishingYear = null;

  public $pagesNumber = null;

  public $format = null;

  public $cover = null;

  public $isbn = null;

  public $titles = [
    "language" => "Мова",
    "publishingYear" => "Рік видання",
    "pagesNumber" => "Кількість сторінок",
    "format" => "Формат",
    "cover" => "Палітурка",
    "isbn" => "ISBN"
  ];

  public function __construct( $data=array() ) {
    if ( isset( $data['specifications_code'] ) ) $this->id = (int) $data['specifications_code'];
    if ( isset( $data['author_code'] ) ) $this->authorId = (int) $data['author_code'];
    if ( isset( $data['publishing_house_code'] ) ) $this->publishingHouseId = (int) $data['publishing_house_code'];
    if ( isset( $data['language'] ) ) $this->language = (string) $data['language'];
    if ( isset( $data['publishing_year'] ) ) $this->publishingYear = (int) $data['publishing_year'];
    if ( isset( $data['pages_number'] ) ) $this->pagesNumber = (int) $data['pages_number'];
    if ( isset( $data['format'] ) ) $this->format = (string) $data['format'];
    if ( isset( $data['cover'] ) ) $this->cover = (string) $data['cover'];
    if ( isset( $data['isbn'] ) ) $this->isbn = preg_replace ( "/[^0-9\-]/", "", $data['isbn'] );
  }


  public function storeFormValues ( $params ) {

    // Store all the parameters
    $this->__construct( $params );
  }


  public static function getById( $id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT * FROM `Specifications` WHERE `specifications_code`= :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Specifications( $row );
  }


  public static function getList( $numRows=1000000 ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `Specifications` LIMIT :numRows";

    $st = $conn->prepare( $sql );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $specifications = new Specifications( $row );
      $list[] = $specifications;
    }

    // Now get the total number of sections that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current Specifications object into the database, and sets its ID property.
  */

  public function insert() {

    // Does the Specifications object already have an ID?
    if ( !is_null( $this->id ) && $this->id != 0 ) trigger_error ( "Specifications::insert(): Attempt to insert a Specifications object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Insert the Specifications
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO `Specifications` ( author_code, publishing_house_code, language, publishing_year, pages_number, format, cover, isbn ) VALUES ( :authorId, :publishingHouseId, :language, :publishingYear, :pagesNumber, :format, :cover, :isbn )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":authorId", $this->authorId, PDO::PARAM_INT );
    $st->bindValue( ":publishingHouseId", $this->publishingHouseId, PDO::PARAM_INT );
    $st->bindValue( ":language", $this->language, PDO::PARAM_STR );
    $st->bindValue( ":publishingYear", $this->publishingYear, PDO::PARAM_INT );
    $st->bindValue( ":pagesNumber", $this->pagesNumber, PDO::PARAM_INT );
    $st->bindValue( ":format", $this->format, PDO::PARAM_STR );
    $st->bindValue( ":cover", $this->cover, PDO::PARAM_STR );
    $st->bindValue( ":isbn", $this->isbn, PDO::PARAM_STR );
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current Specifications object in the database.
  */

  public function update() {

    // Does the Specifications object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Specifications::update(): Attempt to update a Specifications object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the Specifications
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE `Specifications` SET author_code=:authorId, publishing_house_code=:publishingHouseId, language=:language, publishing_year=:publishingYear, pages_number=:pagesNumber, format=:format, cover=:cover, isbn=:isbn WHERE `specifications_code` = :id";
    $st = $conn->prepare ( $sql );
     $st->bindValue( ":authorId", $this->authorId, PDO::PARAM_INT );
    $st->bindValue( ":publishingHouseId", $this->publishingHouseId, PDO::PARAM_INT );
    $st->bindValue( ":language", $this->language, PDO::PARAM_STR );
    $st->bindValue( ":publishingYear", $this->publishingYear, PDO::PARAM_INT );
    $st->bindValue( ":pagesNumber", $this->pagesNumber, PDO::PARAM_INT );
    $st->bindValue( ":format", $this->format, PDO::PARAM_STR );
    $st->bindValue( ":cover", $this->cover, PDO::PARAM_STR );
    $st->bindValue( ":isbn", $this->isbn, PDO::PARAM_STR );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Deletes the current Specifications object from the database.
  */

  public function delete() {

    // Does the Specifications object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Specifications::delete(): Attempt to delete a Specifications object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Specifications
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM `Specifications` WHERE `specifications_code` = :id LIMIT 1" );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>
