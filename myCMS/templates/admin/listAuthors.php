<?php include "templates/admin/include/header.php" ?>
  <main>
    <div class="container">
      <h1 class="page-title">Список Авторів</h1>

      <?php if ( isset( $results['errorMessage'] ) ) { ?>
      <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
      <?php } ?>

      <?php if ( isset( $results['statusMessage'] ) ) { ?>
      <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
      <?php } ?>

      <table>
        <tr>
          <th>Автор</th>
        </tr>

        <?php foreach ( $results['authors'] as $author ) { ?>

                <tr onclick="location='admin.php?action=editAuthor&amp;authorId=<?php echo $author->id?>'">
                  <td>
                    <?php echo $author->fullName ?>
                  </td>
                </tr>

        <?php } ?>

      </table>
      <p class="total-count"><?php echo $results['totalRows']?> author<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>
      <a class="add-new" href="admin.php?action=newAuthor">Додати Автора</a>
    </div>
  </main>
<?php include "templates/admin/include/footer.php" ?>


