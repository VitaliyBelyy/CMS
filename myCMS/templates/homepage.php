<?php include "templates/include/header.php" ?>
	<main class="main-index">
        <div class="main-index__banner">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="main-slider owl-carousel">
                            <div class="main-slider__slide">
                                <img class="main-slider__slide-image" src="images/book-citaty-009.jpg" alt="presentation image">
                            </div>
                            <div class="main-slider__slide">
                                <img class="main-slider__slide-image" src="images/book-citaty-001.jpg" alt="presentation image">
                            </div>
                            <div class="main-slider__slide">
                                <img class="main-slider__slide-image" src="images/book-citaty-002.jpg" alt="presentation image">
                            </div>
                            <div class="main-slider__slide">
                                <img class="main-slider__slide-image" src="images/book-citaty-003.jpg" alt="presentation image">
                            </div>
                            <div class="main-slider__slide">
                                <img class="main-slider__slide-image" src="images/book-citaty-004.jpg" alt="presentation image">
                            </div>
                            <div class="main-slider__slide">
                                <img class="main-slider__slide-image" src="images/book-citaty-005.jpg" alt="presentation image">
                            </div>
                            <div class="main-slider__slide">
                                <img class="main-slider__slide-image" src="images/book-citaty-006.jpg" alt="presentation image">
                            </div>
                            <div class="main-slider__slide">
                                <img class="main-slider__slide-image" src="images/book-citaty-007.jpg" alt="presentation image">
                            </div>
                            <div class="main-slider__slide">
                                <img class="main-slider__slide-image" src="images/book-citaty-008.jpg" alt="presentation image">
                            </div>
                            <div class="main-slider__slide">
                                <img class="main-slider__slide-image" src="images/book-citaty-010.jpg" alt="presentation image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-index__content">
            <div class="container">
                <div class="row">
                    <div class="col-3 main-index__content-left-col">

                        <?php include "templates/include/sidebar-sections.php" ?>
                        
                    </div>
                    <div class="col-9 main-index__content-right-col">
                        <section class="products-section">
                            <div class="products-section__filter">
                                <span class="products-section__filter-label">Сортувати за:</span>
                                <ul class="products-section__filter-list">
                                    <li class="products-section__filter-list-item">
                                        <a class="products-section__filter-parameter" data-order="price" href="#">Ціною</a>
                                    </li>
                                    <li class="products-section__filter-list-item">
                                        <a class="products-section__filter-parameter" data-order="availability" href="#">Наявністю</a>
                                    </li>
                                    <li class="products-section__filter-list-item">
                                        <a class="products-section__filter-parameter" data-order="alphabet" href="#">Алфавітом</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-exhibition">
                                <div class="product-exhibition__showcase">

                                    <?php 
                                        $i = 0;
                                        foreach ( $results['books'] as $book ) { ?>
                                 
                                            <div class="product-exhibition__product-preview" <?php if( $i >= HOMEPAGE_NUM_ARTICLES ) echo "data-hidden" ?> >
                                                <a href=".?action=viewBook&amp;bookId=<?php echo $book->id?>" class="product-exhibition__product-permalink">
                                                    <?php if ( $imagePath = $book->getImagePath( IMG_TYPE_THUMB ) ) { ?>
                                                        <img class="product-exhibition__product-thumbnail" src="<?php echo $imagePath ?>" alt="product thumbnail">
                                                    <?php } ?>
                                                </a>
                                                <p class="product-exhibition__product-name"><?php echo htmlspecialchars( $book->name ) ?></p>
                                                <p class="product-exhibition__product-price"><?php echo $book->price ?> грн.</p>
                                                <?php if( $book->discount ) {?>
                                                <div class="product-exhibition__product-discount">
                                                    <p class="product-exhibition__product-discount-info">-<span class="product-exhibition__product-discount-rate"><?php echo $book->discount ?></span>%</p>
                                                </div>
                                                <?php }?>
                                            </div>
                                 
                                    <?php
                                            $i++;
                                        } ?>
                                    
                                </div>
                                <button class="show-more">Завантажити більше...</button>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php include "templates/include/footer.php" ?>
