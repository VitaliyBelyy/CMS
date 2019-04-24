<?php include "templates/admin/include/header.php" ?>
  <main>
    <div class="container clearfix">
      <h1 class="page-title"><?php echo $results['pageTitle']?></h1>
      <form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
        <input type="hidden" name="section_code" value="<?php echo $results['section']->id ?>"/>

        <?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php } ?>

        <ul>
          <li>
            <label for="name">Назва розділу</label>
            <input type="text" name="name" id="name" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['section']->name )?>" />
          </li>
        </ul>
        <div class="buttons">
          <input type="submit" name="saveChanges" value="Зберегти зміни" />
          <input type="submit" formnovalidate name="cancel" value="Скасувати" />
        </div>
      </form>

      <?php if ( $results['section']->id ) { ?>
      <a class="delete" href="admin.php?action=deleteSection&amp;sectionId=<?php echo $results['section']->id ?>" onclick="return confirm('Видалити Розділ?')">Видалити Розділ</a>
      <?php } ?>

    </div>
  </main>
<?php include "templates/admin/include/footer.php" ?>

