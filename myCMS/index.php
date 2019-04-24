<?php
 
require( "config.php" );
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
 
switch ( $action ) {
  case 'archive':
    archive();
    break;
  case 'search':
    search();
    break;
  case 'viewBook':
    viewBook();
    break;
  case 'offer':
    offer();
    break;
  case 'about':
    about();
    break;
  case 'contact':
    contact();
    break;
  default:
    homepage();
}
 
function archive() {
  $results = array();
  $sectionId = ( isset( $_GET['sectionId'] ) && $_GET['sectionId'] ) ? (int)$_GET['sectionId'] : null;
  $results['section'] = Section::getById( $sectionId );
  $data = Book::getList( 100000, $results['section'] ? $results['section']->id : null );
  $results['books'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $data = Section::getList();
  $results['sections'] = array();
  foreach ( $data['results'] as $section ) $results['sections'][$section->id] = $section;
  $results['pageHeading'] = $results['section'] ?  $results['section']->name : "Book Archive";
  $results['pageTitle'] = $results['pageHeading'];
  require( TEMPLATE_PATH . "/archive.php" );
}

function search() {
  $parameter = preg_replace ( "/[<>{}$]/", "", $_POST['searchParameter'] );
  $results = array();
  $data = Book::getList( 100000 );
  $results['books'] = array_filter($data['results'], function ($book) use ($parameter) {

    return mb_stripos($book->name, $parameter, 0, 'UTF-8') !== false;

  });
  $data = Section::getList();
  $results['sections'] = array();
  foreach ( $data['results'] as $section ) $results['sections'][$section->id] = $section;
  $results['totalRows'] = $data['totalRows'];
  $results['pageHeading'] = "Search Results";
  $results['pageTitle'] = $results['pageHeading'];
  require( TEMPLATE_PATH . "/archive.php" );
}
 
function viewBook() {
  if ( !isset($_GET["bookId"]) || !$_GET["bookId"] ) {
    homepage();
    return;
  }
 
  $results = array();
  $results['book'] = Book::getById( (int)$_GET["bookId"] );
  $results['section'] = Section::getById( $results['book']->sectionId );
  $results['specifications'] = Specifications::getById( $results['book']->specificationsId );
  $results['author'] = Author::getById( $results['specifications']->authorId );
  $results['publishingHouse'] = PublishingHouse::getById( $results['specifications']->publishingHouseId );
  $data = Comment::getList( 100000, $results['book']->id );
  $results['comments'] = $data['results'];
  $data = Book::getList( 5, $results['section']->id, $results['book']->id );
  $results['recentBooks'] = $data['results'];
  $results['pageTitle'] = $results['book']->name;
  require( TEMPLATE_PATH . "/viewBook.php" );
}

function offer() {
  $results = array();
  $data = Book::getList( 100000, null, null, true );
  $results['books'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $data = Section::getList();
  $results['sections'] = array();
  foreach ( $data['results'] as $section ) $results['sections'][$section->id] = $section;
  $results['pageHeading'] = $results['section'] ?  $results['section']->name : "Discounted Books";
  $results['pageTitle'] = $results['pageHeading'];
  require( TEMPLATE_PATH . "/archive.php" );
}

function about() {
  require( TEMPLATE_PATH . "/about.php" );
}

function contact() {
  require( TEMPLATE_PATH . "/contact.php" );
}
 
function homepage() {
  $results = array();
  $data = Book::getList( 100000 );
  $results['books'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $data = Section::getList();
  $results['sections'] = array();
  foreach ( $data['results'] as $section ) $results['sections'][$section->id] = $section;
  $results['pageTitle'] = "Homepage";
  require( TEMPLATE_PATH . "/homepage.php" );
}
 
?>