<?php include "templates/include/header.php" ?>
	<main class="main-single">
        <div class="main-single__primary-part">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <!-- <ul class="breadcrumbs main-single__breadcrumbs">
                            <li class="breadcrumbs__item">
                                <a href="#" class="breadcrumbs__link">Home</a>
                            </li>
                            <li class="breadcrumbs__item">
                                <a href="#" class="breadcrumbs__link">Star Wars Episode I</a>
                            </li>
                        </ul> -->
                        <section class="product-panel">
                            <?php if ( $imagePath = $results['book']->getImagePath() ) { ?>
                                <div class="product-panel__image-wrapper">
                                    <img class="product-panel__image" src="<?php echo $imagePath ?>" alt="product">
                                </div>
                            <?php } ?>
                            
                            <div class="product-panel__content">
                                <h1 class="product-panel__title" data-id="<?php echo $results['book']->id ?>"><?php echo htmlspecialchars( $results['book']->name )?></h1>
                                <p class="product-panel__description"><?php echo htmlspecialchars( $results['book']->description )?></p>
                                <div class="payment-block <?php echo $results['book']->amount == 0 ? 'payment-block_item-unavailable' : '' ?>">
                                    <div class="payment-block__pricing-wrapper">
                                        <div class="payment-block__pricing">
                                            <p class="payment-block__price">Наша ціна: <span class="payment-block__price-value"><?php echo $results['book']->price ?> грн.</span></p>
                                            <p class="payment-block__order-details">Для замовлення зв'яжіться з нами за телефоном: (+888) 88-88-888, або <a class="payment-block__contact-link" href=".?action=contact">завітайте до нашого магазину</a>.</p>
                                        </div>
                                        <span class="payment-block__no-item">Товар відсутній</span>
                                    </div>
                                    <div class="payment-block__info">
                                        <p class="payment-block__info-text">Безпечні покупки</p>
                                        <ul class="cards-list">
                                            <li class="cards-list__card cards-list__card_type_paypal cards-list__card_theme_payment-block"></li>
                                            <li class="cards-list__card cards-list__card_type_mastercard cards-list__card_theme_payment-block"></li>
                                            <li class="cards-list__card cards-list__card_type_american-express cards-list__card_theme_payment-block"></li>
                                            <li class="cards-list__card cards-list__card_type_visa-white cards-list__card_theme_payment-block"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-single__additional-part">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <section class="details-panel">
                            <ul class="details-panel__navigation">
                                <li class="details-panel__navigation-item">
                                    <a href="#" data-direction="excerpt" class="details-panel__navigation-direction details-panel__navigation-direction_active">Уривок</a>
                                </li>
                                <li class="details-panel__navigation-item">
                                    <a href="#" data-direction="attributes" class="details-panel__navigation-direction">Додаткова інформація</a>
                                </li>
                            </ul>
                            <div class="details-panel__info">
                                <p id="excerpt" class="details-panel__info-item details-panel__info-item_visible"><?php echo htmlspecialchars( $results['book']->excerpt )?></p>
                                <table id="attributes" class="product-attributes details-panel__info-item">
                                    <tbody>
                                        <tr class="product-attributes__row">
                                            <td class="product-attributes__column product-attributes__column_type_caption"><span>Автор</span></td>
                                            <td class="product-attributes__column"><span><?php echo htmlspecialchars( $results['author']->fullName )?></span></td>
                                        </tr>
                                        <tr class="product-attributes__row">
                                            <td class="product-attributes__column product-attributes__column_type_caption"><span>Видавництво</span></td>
                                            <td class="product-attributes__column"><span><?php echo htmlspecialchars( $results['publishingHouse']->name )?></span></td>
                                        </tr>
                                        <?php foreach($results['specifications'] as $key => $value) {
                                            $title = $results['specifications']->titles[$key];
                                            if($title && $value) { ?>

                                            <tr class="product-attributes__row">
                                                <td class="product-attributes__column product-attributes__column_type_caption"><span><?php echo $title ?></span></td>
                                                <td class="product-attributes__column"><span><?php echo htmlspecialchars( $value )?></span></td>
                                            </tr>

                                            <?php }
                                         } ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <section class="comments-panel">
                            <div class="comments-panel__comments-part">
                                <h3 class="comments-panel__title">Рецензії</h3>
                                <ul class="comments-panel__comment-list">

                                    <?php if( count($results['comments']) == 0 ) {?>
                                        <li class="comments-panel__notice">Додайте першу рецензію для цієї книги.</li>
                                    <?php }?>

                                    <?php foreach($results['comments'] as $comment) {?>
                                        <li class="comments-panel__comment">
                                            <div class="comments-panel__author-details">
                                                <img src="images/comment-author.png" class="comments-panel__author-thumbnail" alt="author photo">
                                                <p class="comments-panel__author-name"><?php echo htmlspecialchars( $comment->authorName ) ?></p>
                                            </div>
                                            <div class="comments-panel__comment-content">
                                                <p class="comments-panel__comment-text"><?php echo htmlspecialchars( $comment->message ) ?></p>
                                            </div>
                                        </li>
                                    <?php }?>
                                    
                                </ul>
                            </div>
                            <div class="form-part">
                                <h3 class="form-part__title">Напишіть відгук</h3>
                                <form class="form-part__form comments-form" action="#">
                                    <div class="form-part__form-row">
                                        <label class="form-part__form-label" for="name-input">Ім'я</label>
                                        <input class="form-part__form-input" id="name-input" required type="text">
                                    </div>
                                    <div class="form-part__form-row">
                                        <label class="form-part__form-label" for="email-input">Email</label>
                                        <input class="form-part__form-input" id="email-input" required type="email">
                                    </div>
                                    <div class="form-part__form-row">
                                        <label class="form-part__form-label" for="textarea">Повідомлення</label>
                                        <textarea class="form-part__form-textarea" id="textarea" required></textarea>
                                    </div>
                                    <div class="form-part__form-row form-part__form-row_attachment_right">
                                        <input class="form-part__form-submit comments-form__submit" type="submit" value="Надіслати">
                                    </div>
                                </form>
                            </div>
                        </section>
                    </div>
                    <div class="col-3">
                        
                        <?php include "templates/include/sidebar-recentBooks.php" ?>

                    </div>
                </div>
            </div>
        </div>
    </main>
<?php include "templates/include/footer.php" ?>