<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars( $results['pageTitle'] )?></title>
    <link rel="stylesheet" href="css/core.css">
    <link rel="stylesheet" href="css/owl/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl/owl.theme.default.min.css">
</head>
<body>
    <header>
        <div class="header-tools">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-2">
                        <div class="logo-wrapper">
                            <a class="link-home" href=".">
                                <img src="images/logo.png" alt="site logo" class="logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="search-wrapper">
                            <form method="post" action=".?action=search" class="search">
                                <input class="search__input" name="searchParameter" type="text" required>
                                <button class="search__submit">Пошук</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="contact-wrapper">
                           <ul class="contact-info">
                                <li class="contact-info__item contact-info__item_type_address">Проспект Соборний, 83/85,<br> Запоріжжя, Україна, 69000</li>
                                <li class="contact-info__item contact-info__item_type_phone">(+888) 88-88-888</li>
                            </ul> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="primary-menu-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <nav>
                            <ul class="primary-menu">
                                <li class="primary-menu__item"><a class="primary-menu__link" href=".">Головна</a></li>
                                <li class="primary-menu__item"><a class="primary-menu__link" href=".?action=offer">Акційні товари</a></li>
                                <li class="primary-menu__item"><a class="primary-menu__link" href=".?action=about">Про нас</a></li>
                                <li class="primary-menu__item"><a class="primary-menu__link" href=".?action=contact">Контакти</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>