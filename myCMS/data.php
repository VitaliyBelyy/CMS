<?php

require( "config.php" );
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$orderCondition = isset( $_GET['orderBy'] ) ? $_GET['orderBy'] : "";

switch ( $action ) {
    case 'getBooks':
        getBooks($orderCondition);
        break;
}

function getBooks( $condition ) {
    switch ( $condition ) {
        case 'price':
            $order = "`price` ASC";
            break;
        case 'availability':
            $order = "`amount` DESC";
            break;
        case 'alphabet':
            $order = "`name` ASC";
            break;
        default:
            $order = null;
    }

    $results = array();
    $data = Book::getList( 100000, null, null, false, $order );
    $results['books'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];

    // $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    // $orderCondition = $order ? " ORDER BY " . mysql_escape_string($order) : "";
    // $numRows = 100000;

    // $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `Books`" . $orderCondition . " LIMIT :numRows";
    // $st = $conn->prepare( $sql );
    // $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    // $st->execute();
    // $list = array();

    // while ( $row = $st->fetch() ) {
    //   $list[] = $row;
    // }

    // // Получаем общее количество книг, которые соответствуют критерию
    // $sql = "SELECT FOUND_ROWS() AS totalRows";
    // $totalRows = $conn->query( $sql )->fetch();
    // $conn = null;

    header('Content-Type: application/json');
    echo $str = json_encode( $results );
}

?>