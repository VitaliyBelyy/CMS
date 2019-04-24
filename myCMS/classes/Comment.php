<?php

/**
 * Класс для обработки комментариев
 */

class Comment
{
  
  public $id = null;

  public $bookId = null;

  public $authorName = null;

  public $authorEmail = null;

  public $message = null;


  public function __construct( $data=array() ) {
    if ( isset( $data['comment_code'] ) ) $this->id = (int) $data['comment_code'];
    if ( isset( $data['book_code'] ) ) $this->bookId = (int) $data['book_code'];
    if ( isset( $data['author_name'] ) ) $this->authorName = preg_replace ( "/[<>{}$]/", "", $data['author_name'] );
    if ( isset( $data['author_email'] ) ) $this->authorEmail = preg_replace ( "/[<>{}$]/", "", $data['author_email'] );
    if ( isset( $data['message'] ) ) $this->message = preg_replace ( "/[<>{}$]/", "", $data['message'] );
  }


  public function storeFormValues ( $params ) {

    // Сохраняем все параметры
    $this->__construct( $params );

  }

  public static function getById( $id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT * FROM `Comments` WHERE `comment_code`= :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Comment( $row );
  }


  public static function getList( $numRows=1000000, $bookId ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );

    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `Comments` WHERE `book_code` = :bookId LIMIT :numRows";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":bookId", $bookId, PDO::PARAM_INT );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $comment = new Comment( $row );
      $list[] = $comment;
    }

    // Получаем общее количество комментариев, которые соответствуют критерию
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Вставляем текущий объект в базу данных, устанавливаем его свойства.
  */

  public function insert() {

    // Есть у объекта ID?
    if ( !is_null( $this->id ) && $this->id != 0 ) trigger_error ( "Comment::insert(): Attempt to insert a Comment object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Вставляем книгу
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO `Comments` ( book_code, author_name, author_email, message ) VALUES ( :bookId, :authorName, :authorEmail, :message )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":bookId", $this->bookId, PDO::PARAM_INT );
    $st->bindValue( ":authorName", $this->authorName, PDO::PARAM_STR );
    $st->bindValue( ":authorEmail", $this->authorEmail, PDO::PARAM_STR );
    $st->bindValue( ":message", $this->message, PDO::PARAM_STR );
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Обновляем текущий объект в базе данных
  */

  public function update() {

    // Есть ли у объекта ID?
    if ( is_null( $this->id ) ) trigger_error ( "Comment::update(): Attempt to update a Comment object that does not have its ID property set.", E_USER_ERROR );
   
    // Обновляем комментарий
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE `Comments` SET book_code=:bookId, author_name=:authorName, author_email=:authorEmail, message=:message  WHERE `comment_code` = :id";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":bookId", $this->bookId, PDO::PARAM_INT );
    $st->bindValue( ":authorName", $this->authorName, PDO::PARAM_STR );
    $st->bindValue( ":authorEmail", $this->authorEmail, PDO::PARAM_STR );
    $st->bindValue( ":message", $this->message, PDO::PARAM_STR );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Удаляем текущий объект из базы данных
  */

  public function delete() {

    // Есть ли у объекта ID?
    if ( is_null( $this->id ) ) trigger_error ( "Comment::delete(): Attempt to delete a Comment object that does not have its ID property set.", E_USER_ERROR );

    // Удаляем комментарий
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM `Comments` WHERE `comment_code` = :id LIMIT 1" );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>