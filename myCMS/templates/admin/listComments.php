<?php include "templates/admin/include/header.php" ?>
  <main>
    <div class="container">
      <h1 class="page-title">Список коментарів для книги: '<?php echo $results['book']->name?>'</h1>

      <?php if ( isset( $results['errorMessage'] ) ) { ?>
      <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
      <?php } ?>

      <?php if ( isset( $results['statusMessage'] ) ) { ?>
      <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
      <?php } ?>

      <table>
        <tr>
          <th>ID Коментаря</th>
          <th>Автор</th>
        </tr>

        <?php foreach ( $results['comments'] as $comment ) { ?>

                <tr onclick="location='admin.php?action=editComment&amp;commentId=<?php echo $comment->id?>'">
                  <td>
                    <?php echo $comment->id?>
                  </td>
                  <td>
                    <?php echo $comment->authorName?>
                  </td>
                </tr>

        <?php } ?>

      </table>
      <p class="total-count"><?php echo $results['totalRows']?> comment<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>
    </div>
  </main>
<?php include "templates/admin/include/footer.php" ?>


