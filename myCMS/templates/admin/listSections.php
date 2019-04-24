<?php include "templates/admin/include/header.php" ?>
  <main>
    <div class="container">
      <h1 class="page-title">Список Розділів</h1>

      <?php if ( isset( $results['errorMessage'] ) ) { ?>
      <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
      <?php } ?>

      <?php if ( isset( $results['statusMessage'] ) ) { ?>
      <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
      <?php } ?>

      <table>
        <tr>
          <th>Розділ</th>
        </tr>

        <?php foreach ( $results['sections'] as $section ) { ?>

                <tr onclick="location='admin.php?action=editSection&amp;sectionId=<?php echo $section->id?>'">
                  <td>
                    <?php echo $section->name?>
                  </td>
                </tr>

        <?php } ?>

      </table>
      <p class="total-count"><?php echo $results['totalRows']?> section<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>
      <a class="add-new" href="admin.php?action=newSection">Додати Розділ</a>
    </div>
  </main>
<?php include "templates/admin/include/footer.php" ?>


