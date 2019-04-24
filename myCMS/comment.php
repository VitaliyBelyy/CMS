<?php
	require( "config.php" );
	$comment = new Comment;
    $comment->storeFormValues( $_POST );
    $comment->insert();

    header('Content-Type: application/json');
    echo $str = json_encode( $_POST );
?>