<?php

require( "config.php" );
session_start();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

if ( $action != "login" && $action != "logout" && !$username ) {
  login();
  exit;
}

switch ( $action ) {
  case 'login':
    login();
    break;
  case 'logout':
    logout();
    break;
  case 'newBook':
    newBook();
    break;
  case 'editBook':
    editBook();
    break;
  case 'deleteBook':
    deleteBook();
    break;
  case 'listSections':
    listSections();
    break;
  case 'newSection':
    newSection();
    break;
  case 'editSection':
    editSection();
    break;
  case 'deleteSection':
    deleteSection();
    break;
  case 'listAuthors':
    listAuthors();
    break;
  case 'newAuthor':
    newAuthor();
    break;
  case 'editAuthor':
    editAuthor();
    break;
  case 'deleteAuthor':
    deleteAuthor();
    break;
  case 'listPublishingHouses':
    listPublishingHouses();
    break;
  case 'newPublishingHouse':
    newPublishingHouse();
    break;
  case 'editPublishingHouse':
    editPublishingHouse();
    break;
  case 'deletePublishingHouse':
    deletePublishingHouse();
    break;
  case 'listSpecifications':
    listSpecifications();
    break;
  case 'newSpecifications':
    newSpecifications();
    break;
  case 'editSpecifications':
    editSpecifications();
    break;
  case 'deleteSpecifications':
    deleteSpecifications();
    break;
  case 'listComments':
    listComments();
    break;
  case 'editComment':
    editComment();
    break;
  case 'deleteComment':
    deleteComment();
    break;
  default:
    listBooks();
}


function login() {
  $results = array();
  $results['pageTitle'] = "Admin Login";

  if ( isset( $_POST['login'] ) ) {

    // User has posted the login form: attempt to log the user in

    if ( $_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD ) {

      // Login successful: Create a session and redirect to the admin homepage
      $_SESSION['username'] = ADMIN_USERNAME;
      header( "Location: admin.php" );

    } else {

      // Login failed: display an error message to the user
      $results['errorMessage'] = "Incorrect username or password. Please try again.";
      require( TEMPLATE_PATH . "/admin/loginForm.php" );
    }

  } else {

    // User has not posted the login form yet: display the form
    require( TEMPLATE_PATH . "/admin/loginForm.php" );
  }
}


function logout() {
  unset( $_SESSION['username'] );
  header( "Location: admin.php" );
}


function newBook() {
  $results = array();
  $results['pageTitle'] = "New Book";
  $results['formAction'] = "newBook";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the book edit form: save the new book
    $book = new Book;
    $book->storeFormValues( $_POST );
    $book->insert();
    if ( isset( $_FILES['image'] ) ) $book->storeUploadedImage( $_FILES['image'] );
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the book list
    header( "Location: admin.php" );
  } else {

    // User has not posted the book edit form yet: display the form
    $results['book'] = new Book;
    $data = Section::getList();
    $results['sections'] = $data['results'];
    $data = Specifications::getList();
    $results['specifications'] = $data['results'];
    require( TEMPLATE_PATH . "/admin/editBook.php" );
  }
}


function editBook() {
  $results = array();
  $results['pageTitle'] = "Edit Book";
  $results['formAction'] = "editBook";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the book edit form: save the book changes

    if ( !$book = Book::getById( (int)$_POST['book_code'] ) ) {
      header( "Location: admin.php?error=bookNotFound" );
      return;
    }

    $book->storeFormValues( $_POST );
    if ( isset($_POST['deleteImage']) && $_POST['deleteImage'] == "yes" ) $book->deleteImages();
    $book->update();
    if ( isset( $_FILES['image'] ) ) $book->storeUploadedImage( $_FILES['image'] );
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the book list
    header( "Location: admin.php" );
  } else {

    // User has not posted the book edit form yet: display the form
    $results['book'] = Book::getById( (int)$_GET['bookId'] );
    $data = Section::getList();
    $results['sections'] = $data['results'];
    $data = Specifications::getList();
    $results['specifications'] = $data['results'];
    require( TEMPLATE_PATH . "/admin/editBook.php" );
  }
}


function deleteBook() {
  if ( !$book= Book::getById( (int)$_GET['bookId'] ) ) {
    header( "Location: admin.php?error=bookNotFound" );
    return;
  }

  $book->deleteImages();

  $book->delete();
  header( "Location: admin.php?status=bookDeleted" );
}


function listBooks() {
  $results = array();
  $data = Book::getList();
  $results['books'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $data = Section::getList();
  $results['sections'] = array();
  foreach ( $data['results'] as $section ) $results['sections'][$section->id] = $section;
  $results['pageTitle'] = "All Books";

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "bookNotFound" ) $results['errorMessage'] = "Error: Book not found.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
    if ( $_GET['status'] == "bookDeleted" ) $results['statusMessage'] = "Book deleted.";
  }

  require( TEMPLATE_PATH . "/admin/listBooks.php" );
}


function listSections() {
  $results = array();
  $data = Section::getList();
  $results['sections'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Book Sections";

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "sectionNotFound" ) $results['errorMessage'] = "Error: Section not found.";
    if ( $_GET['error'] == "sectionContainsBooks" ) $results['errorMessage'] = "Error: Section contains books. Delete the books, or assign them to another section, before deleting this section.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
    if ( $_GET['status'] == "sectionDeleted" ) $results['statusMessage'] = "Section deleted.";
  }

  require( TEMPLATE_PATH . "/admin/listSections.php" );
}


function newSection() {
  $results = array();
  $results['pageTitle'] = "New Section";
  $results['formAction'] = "newSection";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the section edit form: save the new section
    $section = new Section;
    $section->storeFormValues( $_POST );
    $section->insert();
    header( "Location: admin.php?action=listSections&status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the section list
    header( "Location: admin.php?action=listSections" );
  } else {

    // User has not posted the section edit form yet: display the form
    $results['section'] = new Section;
    require( TEMPLATE_PATH . "/admin/editSection.php" );
  }
}


function editSection() {
  $results = array();
  $results['pageTitle'] = "Edit Section";
  $results['formAction'] = "editSection";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the section edit form: save the section changes

    if ( !$section = Section::getById( (int)$_POST['section_code'] ) ) {
      header( "Location: admin.php?action=listSections&error=sectionNotFound" );
      return;
    }

    $section->storeFormValues( $_POST );
    $section->update();
    header( "Location: admin.php?action=listSections&status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the section list
    header( "Location: admin.php?action=listSections" );
  } else {

    // User has not posted the section edit form yet: display the form
    $results['section'] = Section::getById( (int)$_GET['sectionId'] );
    require( TEMPLATE_PATH . "/admin/editSection.php" );
  }
}


function deleteSection() {
  if ( !$section = Section::getById( (int)$_GET['sectionId'] ) ) {
    header( "Location: admin.php?action=listSections&error=sectionNotFound" );
    return;
  }

  $books = Book::getList( 1000000, $section->id );

  if ( $books['totalRows'] > 0 ) {
    header( "Location: admin.php?action=listSections&error=sectionContainsBooks" );
    return;
  }

  $section->delete();
  header( "Location: admin.php?action=listSections&status=sectionDeleted" );
}


function listAuthors() {
  $results = array();
  $data = Author::getList();
  $results['authors'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Book Authors";

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "authorNotFound" ) $results['errorMessage'] = "Error: Author not found.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
    if ( $_GET['status'] == "authorDeleted" ) $results['statusMessage'] = "Author deleted.";
  }

  require( TEMPLATE_PATH . "/admin/listAuthors.php" );
}


function newAuthor() {
  $results = array();
  $results['pageTitle'] = "New Author";
  $results['formAction'] = "newAuthor";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the author edit form: save the new author
    $author = new Author;
    $author->storeFormValues( $_POST );
    $author->insert();
    header( "Location: admin.php?action=listAuthors&status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the author list
    header( "Location: admin.php?action=listAuthors" );
  } else {

    // User has not posted the author edit form yet: display the form
    $results['author'] = new Author;
    require( TEMPLATE_PATH . "/admin/editAuthor.php" );
  }
}


function editAuthor() {
  $results = array();
  $results['pageTitle'] = "Edit Author";
  $results['formAction'] = "editAuthor";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the author edit form: save the author changes

    if ( !$author = Author::getById( (int)$_POST['author_code'] ) ) {
      header( "Location: admin.php?action=listAuthors&error=authorNotFound" );
      return;
    }

    $author->storeFormValues( $_POST );
    $author->update();
    header( "Location: admin.php?action=listAuthors&status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the author list
    header( "Location: admin.php?action=listAuthors" );
  } else {

    // User has not posted the author edit form yet: display the form
    $results['author'] = Author::getById( (int)$_GET['authorId'] );
    require( TEMPLATE_PATH . "/admin/editAuthor.php" );
  }
}


function deleteAuthor() {
  if ( !$author = Author::getById( (int)$_GET['authorId'] ) ) {
    header( "Location: admin.php?action=listAuthors&error=authorNotFound" );
    return;
  }

  $author->delete();
  header( "Location: admin.php?action=listAuthors&status=authorDeleted" );
}


function listPublishingHouses() {
  $results = array();
  $data = PublishingHouse::getList();
  $results['publishingHouses'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Publishing Houses";

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "publishingHouseNotFound" ) $results['errorMessage'] = "Error: Publishing house not found.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
    if ( $_GET['status'] == "publishingHouseDeleted" ) $results['statusMessage'] = "Publishing house deleted.";
  }

  require( TEMPLATE_PATH . "/admin/listPublishingHouses.php" );
}


function newPublishingHouse() {
  $results = array();
  $results['pageTitle'] = "New Publishing House";
  $results['formAction'] = "newPublishingHouse";

  if ( isset( $_POST['saveChanges'] ) ) {

    $publishingHouse = new PublishingHouse;
    $publishingHouse->storeFormValues( $_POST );
    $publishingHouse->insert();
    header( "Location: admin.php?action=listPublishingHouses&status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    header( "Location: admin.php?action=listPublishingHouses" );

  } else {

    $results['publishingHouse'] = new PublishingHouse;
    require( TEMPLATE_PATH . "/admin/editPublishingHouse.php" );
  }
}


function editPublishingHouse() {
  $results = array();
  $results['pageTitle'] = "Edit Publishing House";
  $results['formAction'] = "editPublishingHouse";

  if ( isset( $_POST['saveChanges'] ) ) {

    if ( !$publishingHouse = PublishingHouse::getById( (int)$_POST['publishing_house_code'] ) ) {
      header( "Location: admin.php?action=listPublishingHouses&error=publishingHouseNotFound" );
      return;
    }

    $publishingHouse->storeFormValues( $_POST );
    $publishingHouse->update();
    header( "Location: admin.php?action=listPublishingHouses&status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    header( "Location: admin.php?action=listPublishingHouses" );
    
  } else {

    $results['publishingHouse'] = PublishingHouse::getById( (int)$_GET['publishingHouseId'] );
    require( TEMPLATE_PATH . "/admin/editPublishingHouse.php" );
  }
}


function deletePublishingHouse() {
  if ( !$publishingHouse = PublishingHouse::getById( (int)$_GET['publishingHouseId'] ) ) {
    header( "Location: admin.php?action=listPublishingHouses&error=publishingHouseNotFound" );
    return;
  }

  $publishingHouse->delete();
  header( "Location: admin.php?action=listPublishingHouses&status=publishingHouseDeleted" );
}


function newSpecifications() {
  $results = array();
  $results['pageTitle'] = "New Specifications";
  $results['formAction'] = "newSpecifications";

  if ( isset( $_POST['saveChanges'] ) ) {

    $specifications = new Specifications;
    $specifications->storeFormValues( $_POST );
    $specifications->insert();
    header( "Location: admin.php?action=listSpecifications&status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    header( "Location: admin.php?action=listSpecifications" );

  } else {

    $results['specifications'] = new Specifications;
    $data = Author::getList();
    $results['authors'] = $data['results'];
    $data = PublishingHouse::getList();
    $results['publishingHouses'] = $data['results'];
    require( TEMPLATE_PATH . "/admin/editSpecifications.php" );

  }
}


function editSpecifications() {
  $results = array();
  $results['pageTitle'] = "Edit Specifications";
  $results['formAction'] = "editSpecifications";

  if ( isset( $_POST['saveChanges'] ) ) {

    if ( !$specifications = Specifications::getById( (int)$_POST['specifications_code'] ) ) {
      header( "Location: admin.php?action=listSpecifications&error=specificationsNotFound" );
      return;
    }

    $specifications->storeFormValues( $_POST );
    $specifications->update();
    header( "Location: admin.php?action=listSpecifications&status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    header( "Location: admin.php?action=listSpecifications" );

  } else {

    $results['specifications'] = Specifications::getById( (int)$_GET['specificationsId'] );
    $data = Author::getList();
    $results['authors'] = $data['results'];
    $data = PublishingHouse::getList();
    $results['publishingHouses'] = $data['results'];
    require( TEMPLATE_PATH . "/admin/editSpecifications.php" );

  }
}


function deleteSpecifications() {
  if ( !$specifications= Specifications::getById( (int)$_GET['specificationsId'] ) ) {
    header( "Location: admin.php?action=listSpecifications&error=specificationsNotFound" );
    return;
  }

  $specifications->delete();
  header( "Location: admin.php?action=listSpecifications&status=specificationsDeleted" );
}


function listSpecifications() {
  $results = array();
  $data = Specifications::getList();
  $results['specifications'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "All Specifications";

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "specificationsNotFound" ) $results['errorMessage'] = "Error: Specifications not found.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
    if ( $_GET['status'] == "specificationsDeleted" ) $results['statusMessage'] = "Specifications deleted.";
  }

  require( TEMPLATE_PATH . "/admin/listSpecifications.php" );
}


function editComment() {
  $results = array();
  $results['pageTitle'] = "Edit Comment";
  $results['formAction'] = "editComment";

  if ( isset( $_POST['saveChanges'] ) ) {

    if ( !$comment = Comment::getById( (int)$_POST['comment_code'] ) ) {
      header( "Location: admin.php?action=listComments&bookId=" . (int)$_POST['book_code'] . "&error=commentNotFound" );
      return;
    }

    $comment->storeFormValues( $_POST );
    $comment->update();
    header( "Location: admin.php?action=listComments&bookId=" . (int)$_POST['book_code'] . "&status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    header( "Location: admin.php?action=listComments&bookId=" . (int)$_POST['book_code'] );

  } else {

    $results['comment'] = Comment::getById( (int)$_GET['commentId'] );
    require( TEMPLATE_PATH . "/admin/editComment.php" );

  }
}


function deleteComment() {
  if ( !$comment= Comment::getById( (int)$_GET['commentId'] ) ) {
    header( "Location: admin.php?action=listComments&bookId=" . (int)$_GET['bookId'] . "&error=commentNotFound" );
    return;
  }

  $comment->delete();
  header( "Location: admin.php?action=listComments&bookId=" . (int)$_GET['bookId'] . "&status=commentDeleted" );
}


function listComments() {
  $results = array();
  $results['book'] = Book::getById( (int)$_GET['bookId'] );
  $data = Comment::getList( 100000, $results['book']->id );
  $results['comments'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Comments for book: " . $results['book']->name;

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "commentNotFound" ) $results['errorMessage'] = "Error: Comment not found.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
    if ( $_GET['status'] == "commentDeleted" ) $results['statusMessage'] = "Comment deleted.";
  }

  require( TEMPLATE_PATH . "/admin/listComments.php" );
}

?>
