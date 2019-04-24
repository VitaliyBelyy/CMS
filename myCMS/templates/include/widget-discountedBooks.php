<h3 class="footer__widget-title">Товари зі знижкою</h3>
<?php
  function renderDiscountedPosts() {
    $results = array();
    $data = Book::getList( 5, null, null, true );
    $results['books'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
?>
    <ul class="footer__widget-list">

    <?php foreach ( $results['books'] as $book ) { ?>
      
      <li class="footer__widget-list-item">
          <a class="footer__widget-list-link" href=".?action=viewBook&amp;bookId=<?php echo $book->id?>"><?php echo htmlspecialchars( $book->name )?></a>
      </li>

    <?php } ?>
    
    </ul>

<?php
  }
  renderDiscountedPosts();
?>