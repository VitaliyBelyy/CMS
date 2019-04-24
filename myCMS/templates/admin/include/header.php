<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo htmlspecialchars( $results['pageTitle'] )?></title>
	<link rel="stylesheet" href="css/admin-styles.css">
</head>
	<body>
		<header>
			<div class="admin-menu-wrapper">
			    <div class="container">
			        <ul class="admin-menu">
			            <li class="admin-menu__item"><p class="admin-menu__autorization-text">Ви увійшли як <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b></p></li>
			            <li class="admin-menu__item"><a class="admin-menu__link" href="admin.php?action=listBooks">Список Книг</a></li>
			            <li class="admin-menu__item"><a class="admin-menu__link" href="admin.php?action=listSections">Список Розділів</a></li>
			            <li class="admin-menu__item"><a class="admin-menu__link" href="admin.php?action=listAuthors">Список Авторів</a></li>
			            <li class="admin-menu__item"><a class="admin-menu__link" href="admin.php?action=listPublishingHouses">Список Видавництв</a></li>
			            <li class="admin-menu__item"><a class="admin-menu__link" href="admin.php?action=listSpecifications">Список Характеристик</a></li>
			            <li class="admin-menu__item"><a class="admin-menu__link" href="admin.php?action=logout">Вийти</a></li>
			        </ul>  
			    </div>
			</div>
		</header>

