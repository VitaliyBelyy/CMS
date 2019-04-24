<?php
	ini_set( "display_errors", true );
	date_default_timezone_set( "Europe/Zaporozhye" );  // http://www.php.net/manual/en/timezones.php
	define( "DB_DSN", "mysql:host=localhost;dbname=BookStore_db" );
	define( "DB_USERNAME", "root" );
	define( "DB_PASSWORD", "" );
	define( "CLASS_PATH", "classes" );
	define( "TEMPLATE_PATH", "templates" );
	define( "HOMEPAGE_NUM_ARTICLES", 10 );
	define( "ADMIN_USERNAME", "admin" );
	define( "ADMIN_PASSWORD", "admin" );
	define( "ARTICLE_IMAGE_PATH", "images/books" );
	define( "IMG_TYPE_FULLSIZE", "fullsize" );
	define( "IMG_TYPE_THUMB", "thumb" );
	define( "ARTICLE_THUMB_WIDTH", 98 );
	define( "JPEG_QUALITY", 85 );
	require( CLASS_PATH . "/Book.php" );
	require( CLASS_PATH . "/Author.php" );
	require( CLASS_PATH . "/Section.php" );
	require( CLASS_PATH . "/PublishingHouse.php" );
	require( CLASS_PATH . "/Specifications.php" );
	require( CLASS_PATH . "/Comment.php" );

	function handleException( $exception ) {
	  echo "Sorry, a problem occurred. Please try later.";
	  error_log( $exception->getMessage() );
	}

	set_exception_handler( 'handleException' );
?>