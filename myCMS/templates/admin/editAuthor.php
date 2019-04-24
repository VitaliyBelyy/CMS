<?php include "templates/admin/include/header.php" ?>
  <main>
    <div class="container clearfix">
      <h1 class="page-title"><?php echo $results['pageTitle']?></h1>
      <form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
        <input type="hidden" name="author_code" value="<?php echo $results['author']->id ?>"/>

        <?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php } ?>

        <ul>
          <li>
            <label for="name">Ім'я автора</label>
            <input type="text" name="full_name" id="name" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['author']->fullName )?>" />
          </li>
        </ul>
        <div class="buttons">
          <input type="submit" name="saveChanges" value="Зберегти зміни" />
          <input type="submit" formnovalidate name="cancel" value="Скасувати" />
        </div>
      </form>

      <?php if ( $results['author']->id ) { ?>
      <a class="delete" href="admin.php?action=deleteAuthor&amp;authorId=<?php echo $results['author']->id ?>" onclick="return confirm('Видалити Автора?')">Видалити Автора</a>
      <?php } ?>

    </div>
  </main>
<?php include "templates/admin/include/footer.php" ?>

