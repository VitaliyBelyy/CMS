<aside class="sidebar">
    <div class="sidebar__widget">
        <h3 class="sidebar__widget-title">Може вас зацікавити</h3>
        <ul class="sidebar__widget-product-list">
            <?php foreach ( $results['recentBooks'] as $book ) { ?>
            <li class="sidebar__product-preview">
                <?php if ( $imagePath = $book->getImagePath( IMG_TYPE_THUMB ) ) { ?>
                    <div class="sidebar__product-thumbnail-wrapper">
                        <img class="sidebar__product-thumbnail" src="<?php echo $imagePath ?>" alt="product thumbnail">
                    </div>
                <?php } ?>
                
                <div class="sidebar__product-info">
                    <p class="sidebar__product-name"><?php echo htmlspecialchars( $book->name ) ?></p>
                    <p class="sidebar__product-price"><?php echo $book->price ?> грн.</p>
                    <a class="sidebar__product-link" href=".?action=viewBook&amp;bookId=<?php echo $book->id?>">Дізнатися більше</a>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</aside>