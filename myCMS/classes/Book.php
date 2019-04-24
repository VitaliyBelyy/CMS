<?php

/**
 * Класс для обработки книг
 */

class Book
{
  
  public $id = null;

  public $name = null;

  public $description = null;

  public $excerpt = null;

  public $sectionId = null;

  public $specificationsId = null;

  public $price = null;

  public $amount = null;

  public $discount = null;

  public $imageExtension = "";


  public function __construct( $data=array() ) {
    if ( isset( $data['book_code'] ) ) $this->id = (int) $data['book_code'];
    if ( isset( $data['name'] ) ) $this->name = (string) $data['name'];
    if ( isset( $data['description'] ) ) $this->description = (string) $data['description'];
    if ( isset( $data['excerpt'] ) ) $this->excerpt = (string) $data['excerpt'];
    if ( isset( $data['section_code'] ) ) $this->sectionId = (int) $data['section_code'];
    if ( isset( $data['specifications_code'] ) ) $this->specificationsId = (int) $data['specifications_code'];
    if ( isset( $data['price'] ) ) $this->price = (int) $data['price'];
    if ( isset( $data['amount'] ) ) $this->amount = (int) $data['amount'];
    if ( isset( $data['discount'] ) ) $this->discount = (int) $data['discount'];
    if ( isset( $data['image_extension'] ) ) $this->imageExtension = (string) $data['image_extension'];
  }


  public function storeFormValues ( $params ) {

    // Сохраняем все параметры
    $this->__construct( $params );

  }


  public function storeUploadedImage( $image ) {
 
    if ( $image['error'] == UPLOAD_ERR_OK )
    {
      // Does the Article object have an ID?
      if ( is_null( $this->id ) ) trigger_error( "Book::storeUploadedImage(): Attempt to upload an image for a Book object that does not have its ID property set.", E_USER_ERROR );
 
      // Delete any previous image(s)
      $this->deleteImages();
 
      // Get and store the image filename extension
      $this->imageExtension = strtolower( strrchr( $image['name'], '.' ) );
 
      // Store the image
 
      $tempFilename = trim( $image['tmp_name'] ); 
 
      if ( is_uploaded_file ( $tempFilename ) ) {
        if ( !( move_uploaded_file( $tempFilename, $this->getImagePath() ) ) ) trigger_error( "Book::storeUploadedImage(): Couldn't move uploaded file.", E_USER_ERROR );
        if ( !( chmod( $this->getImagePath(), 0666 ) ) ) trigger_error( "Book::storeUploadedImage(): Couldn't set permissions on uploaded file.", E_USER_ERROR );
      }
 
      // Get the image size and type
      $attrs = getimagesize ( $this->getImagePath() );
      $imageWidth = $attrs[0];
      $imageHeight = $attrs[1];
      $imageType = $attrs[2];
 
      // Load the image into memory
      switch ( $imageType ) {
        case IMAGETYPE_GIF:
          $imageResource = imagecreatefromgif ( $this->getImagePath() );
          break;
        case IMAGETYPE_JPEG:
          $imageResource = imagecreatefromjpeg ( $this->getImagePath() );
          break;
        case IMAGETYPE_PNG:
          $imageResource = imagecreatefrompng ( $this->getImagePath() );
          break;
        default:
          trigger_error ( "Book::storeUploadedImage(): Unhandled or unknown image type ($imageType)", E_USER_ERROR );
      }
 
      // Copy and resize the image to create the thumbnail
      $thumbHeight = intval ( $imageHeight / $imageWidth * ARTICLE_THUMB_WIDTH );
      $thumbResource = imagecreatetruecolor ( ARTICLE_THUMB_WIDTH, $thumbHeight );
      imagecopyresampled( $thumbResource, $imageResource, 0, 0, 0, 0, ARTICLE_THUMB_WIDTH, $thumbHeight, $imageWidth, $imageHeight );
 
      // Save the thumbnail
      switch ( $imageType ) {
        case IMAGETYPE_GIF:
          imagegif ( $thumbResource, $this->getImagePath( IMG_TYPE_THUMB ) );
          break;
        case IMAGETYPE_JPEG:
          imagejpeg ( $thumbResource, $this->getImagePath( IMG_TYPE_THUMB ), JPEG_QUALITY );
          break;
        case IMAGETYPE_PNG:
          imagepng ( $thumbResource, $this->getImagePath( IMG_TYPE_THUMB ) );
          break;
        default:
          trigger_error ( "Book::storeUploadedImage(): Unhandled or unknown image type ($imageType)", E_USER_ERROR );
      }
 
      $this->update();
    }
  }
 
 
  public function deleteImages() {
 
    // Delete all fullsize images for this book
    foreach (glob( ARTICLE_IMAGE_PATH . "/" . IMG_TYPE_FULLSIZE . "/" . $this->id . ".*") as $filename) {
      if ( !unlink( $filename ) ) trigger_error( "Book::deleteImages(): Couldn't delete image file.", E_USER_ERROR );
    }
     
    // Delete all thumbnail images for this book
    foreach (glob( ARTICLE_IMAGE_PATH . "/" . IMG_TYPE_THUMB . "/" . $this->id . ".*") as $filename) {
      if ( !unlink( $filename ) ) trigger_error( "Book::deleteImages(): Couldn't delete thumbnail file.", E_USER_ERROR );
    }
 
    // Remove the image filename extension from the object
    $this->imageExtension = "";
  }
 
  
  public function getImagePath( $type=IMG_TYPE_FULLSIZE ) {
    return ( $this->id && $this->imageExtension ) ? ( ARTICLE_IMAGE_PATH . "/$type/" . $this->id . $this->imageExtension ) : false;
  }


  public static function getById( $id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT * FROM `Books` WHERE `book_code` = :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Book( $row );
  }


  public static function getList( $numRows=1000000, $sectionId=null, $exceptionId=null, $discount=false, $orderParam=null ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );

    $sectionCondition = $sectionId ? " WHERE `section_code` = :sectionId" : "";
    $exceptionCondition = $exceptionId ? " AND `book_code` <> :exceptionId" : "";
    $discountCondition = $discount ? " WHERE `discount` > 0" : "";
    $orderCondition = $orderParam ? " ORDER BY " . mysql_escape_string($orderParam) : "";

    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `Books`" . $sectionCondition . $discountCondition . $exceptionCondition . $orderCondition . " LIMIT :numRows";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    if ( $sectionId ) $st->bindValue( ":sectionId", $sectionId, PDO::PARAM_INT );
    if ( $exceptionId ) $st->bindValue( ":exceptionId", $exceptionId, PDO::PARAM_INT );
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $book = new Book( $row );
      $list[] = $book;
    }

    // Получаем общее количество книг, которые соответствуют критерию
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Вставляем текущий объект книги в базу данных, устанавливаем его свойства.
  */

  public function insert() {

    // Есть ли у объекта ID?
    if ( !is_null( $this->id ) && $this->id != 0 ) trigger_error ( "Book::insert(): Attempt to insert a Book object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Вставляем книгу
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO `Books` ( name, description, excerpt, section_code, specifications_code, price, amount, discount, image_extension ) VALUES ( :name, :description, :excerpt, :sectionId, :specificationsId, :price, :amount, :discount, :imageExtension )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
    $st->bindValue( ":description", $this->description, PDO::PARAM_STR );
    $st->bindValue( ":excerpt", $this->excerpt, PDO::PARAM_STR );
    $st->bindValue( ":sectionId", $this->sectionId, PDO::PARAM_INT );
    $st->bindValue( ":specificationsId", $this->specificationsId, PDO::PARAM_INT );
    $st->bindValue( ":price", $this->price, PDO::PARAM_INT );
    $st->bindValue( ":amount", $this->amount, PDO::PARAM_INT );
    $st->bindValue( ":discount", $this->discount, PDO::PARAM_INT );
    $st->bindValue( ":imageExtension", $this->imageExtension, PDO::PARAM_STR );
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Обновляем текущий объект книги в базе данных
  */

  public function update() {

    // Есть ли у объекта ID?
    if ( is_null( $this->id ) ) trigger_error ( "Book::update(): Attempt to update a Book object that does not have its ID property set.", E_USER_ERROR );
   
    // Обновляем книгу
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE `Books` SET name=:name, description=:description, excerpt=:excerpt, section_code=:sectionId, specifications_code=:specificationsId, price=:price, amount=:amount, discount=:discount, image_extension=:imageExtension WHERE `book_code` = :id";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
    $st->bindValue( ":description", $this->description, PDO::PARAM_STR );
    $st->bindValue( ":excerpt", $this->excerpt, PDO::PARAM_STR );
    $st->bindValue( ":sectionId", $this->sectionId, PDO::PARAM_INT );
    $st->bindValue( ":specificationsId", $this->specificationsId, PDO::PARAM_INT );
    $st->bindValue( ":price", $this->price, PDO::PARAM_INT );
    $st->bindValue( ":amount", $this->amount, PDO::PARAM_INT );
    $st->bindValue( ":discount", $this->discount, PDO::PARAM_INT );
    $st->bindValue( ":imageExtension", $this->imageExtension, PDO::PARAM_STR );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Удаляем текущий объект книги из базы данных
  */

  public function delete() {

    // Есть ли у объекта ID?
    if ( is_null( $this->id ) ) trigger_error ( "Book::delete(): Attempt to delete a Book object that does not have its ID property set.", E_USER_ERROR );

    // Удаляем книгу
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM `Books` WHERE `book_code` = :id LIMIT 1" );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>