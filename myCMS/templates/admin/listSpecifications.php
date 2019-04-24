<?php include "templates/admin/include/header.php" ?>
  <main>
    <div class="container">
      <h1 class="page-title">Список Характеристик</h1>

      <?php if ( isset( $results['errorMessage'] ) ) { ?>
      <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
      <?php } ?>

      <?php if ( isset( $results['statusMessage'] ) ) { ?>
      <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
      <?php } ?>

      <table>
        <tr>
          <th>ID Характеристик</th>
        </tr>

        <?php foreach ( $results['specifications'] as $specifications ) { ?>

                <tr onclick="location='admin.php?action=editSpecifications&amp;specificationsId=<?php echo $specifications->id?>'">
                  <td>
                    <?php echo $specifications->id ?>
                  </td>
                </tr>

        <?php } ?>

      </table>
      <p class="total-count"><?php echo $results['totalRows']?> specifications in total.</p>
      <a class="add-new" href="admin.php?action=newSpecifications">Додати Характеристики</a>
    </div>
  </main>
<?php include "templates/admin/include/footer.php" ?>


