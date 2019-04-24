<?php include "templates/admin/include/header.php" ?>
  <main>
    <div class="container">
      <h1 class="page-title">Список Книг</h1>

      <?php if ( isset( $results['errorMessage'] ) ) { ?>
      <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
      <?php } ?>

      <?php if ( isset( $results['statusMessage'] ) ) { ?>
      <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
      <?php } ?>

      <table>
        <tr>
          <th>Книга</th>
          <th>Розділ</th>
          <th>ID Характеристик</th>
        </tr>

        <?php foreach ( $results['books'] as $book ) { ?>

                <tr onclick="location='admin.php?action=editBook&amp;bookId=<?php echo $book->id?>'">
                  <td>
                    <?php echo $book->name ?>
                  </td>
                  <td>
                    <?php echo $results['sections'][$book->sectionId]->name ?>
                  </td>
                  <td>
                    <?php echo $book->specificationsId ?>
                  </td>
                </tr>

        <?php } ?>

      </table>
      <p class="total-count"><?php echo $results['totalRows']?> book<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>
      <a class="add-new" href="admin.php?action=newBook">Додати Книгу</a>
    </div>
  </main>
<?php include "templates/admin/include/footer.php" ?>

