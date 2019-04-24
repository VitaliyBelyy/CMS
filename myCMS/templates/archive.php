<?php include "templates/include/header.php" ?>
	<main class="main-category">
        <div class="main-category__content">
            <div class="container">
                <div class="row">
                    <div class="col-3 main-category__content-left-col">

                        <?php include "templates/include/sidebar-sections.php" ?>

                    </div>
                    <div class="col-9 main-category__content-right-col">
                        <div class="product-exhibition">
                            <?php if ( $results['section'] ) { ?>
                            <h1 class="product-exhibition__title"><?php echo htmlspecialchars( $results['section']->name ) ?></h1>
                            <?php } ?>
                            <?php if ( !$results['books'] ) { ?>
                            <p class="product-exhibition__attention">Нажаль за вашим запитом нічого не знайдено.</p>
                            <?php } ?>
                            <div class="product-exhibition__showcase">
                                <?php foreach ( $results['books'] as $book ) { ?>
                                 
                                    <div class="product-exhibition__product-preview">
                                        <a href=".?action=viewBook&amp;bookId=<?php echo $book->id?>" class="product-exhibition__product-permalink">
                                            <?php if ( $imagePath = $book->getImagePath( IMG_TYPE_THUMB ) ) { ?>
                                                <img class="product-exhibition__product-thumbnail" src="<?php echo $imagePath ?>" alt="product thumbnail">
                                            <?php } ?>
                                        </a>
                                        <p class="product-exhibition__product-name"><?php echo htmlspecialchars( $book->name )?></p>
                                        <p class="product-exhibition__product-price"><?php echo $book->price ?> грн.</p>
                                        <?php if( $book->discount ) {?>
                                        <div class="product-exhibition__product-discount">
                                            <p class="product-exhibition__product-discount-info">-<span class="product-exhibition__product-discount-rate"><?php echo $book->discount ?></span>%</p>
                                        </div>
                                        <?php }?>
                                    </div>
                                 
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php include "templates/include/footer.php" ?>