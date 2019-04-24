<?php include "templates/admin/include/header.php" ?>
  <main>
    <div class="container">
      <h1 class="page-title">Список Видавництв</h1>

      <?php if ( isset( $results['errorMessage'] ) ) { ?>
      <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
      <?php } ?>

      <?php if ( isset( $results['statusMessage'] ) ) { ?>
      <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
      <?php } ?>

      <table>
        <tr>
          <th>Видавництво</th>
        </tr>

        <?php foreach ( $results['publishingHouses'] as $publishingHouse ) { ?>

                <tr onclick="location='admin.php?action=editPublishingHouse&amp;publishingHouseId=<?php echo $publishingHouse->id?>'">
                  <td>
                    <?php echo $publishingHouse->name ?>
                  </td>
                </tr>

        <?php } ?>

      </table>
      <p class="total-count"><?php echo $results['totalRows']?> Publishing house<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>
      <a class="add-new" href="admin.php?action=newPublishingHouse">Додати Видавництво</a>
    </div>
  </main>
<?php include "templates/admin/include/footer.php" ?>


