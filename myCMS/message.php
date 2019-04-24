<?php
	$letter_body = "Name: " . $_POST['name'] .
					"\nEmail: " . $_POST['email'] .
					"\nMessage: " . $_POST['message'];
	$address = "belyyy1998@gmail.com";
	$subject = "Повідомлення з сайту Book-store";

	echo mail($address, $subject, $letter_body) ? 200 : 500;
?>