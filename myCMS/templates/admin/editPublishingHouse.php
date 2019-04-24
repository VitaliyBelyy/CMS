<?php include "templates/admin/include/header.php" ?>
  <main>
    <div class="container clearfix">
      <h1 class="page-title"><?php echo $results['pageTitle']?></h1>
      <form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
        <input type="hidden" name="publishing_house_code" value="<?php echo $results['publishingHouse']->id ?>"/>

        <?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php } ?>

        <ul>
          <li>
            <label for="name">Назва видавництва</label>
            <input type="text" name="name" id="name" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['publishingHouse']->name )?>" />
          </li>
        </ul>
        <div class="buttons">
          <input type="submit" name="saveChanges" value="Зберегти зміни" />
          <input type="submit" formnovalidate name="cancel" value="Скасувати" />
        </div>
      </form>

      <?php if ( $results['publishingHouse']->id ) { ?>
      <a class="delete" href="admin.php?action=deletePublishingHouse&amp;publishingHouseId=<?php echo $results['publishingHouse']->id ?>" onclick="return confirm('Видалити Видавництво?')">Видалити Видавництво</a>
      <?php } ?>

    </div>
  </main>
<?php include "templates/admin/include/footer.php" ?>

