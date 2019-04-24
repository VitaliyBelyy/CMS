<?php include "templates/admin/include/header.php" ?>
  <main>
    <div class="container clearfix">
      <h1 class="page-title"><?php echo $results['pageTitle']?></h1>
      <form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
        <input type="hidden" name="comment_code" value="<?php echo $results['comment']->id ?>"/>
        <input type="hidden" name="book_code" value="<?php echo $results['comment']->bookId ?>"/>

        <?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php } ?>

        <ul>
          <li>
            <label for="name">Автор</label>
            <input type="text" name="author_name" id="name" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['comment']->authorName )?>" />
          </li>
          <li>
            <label for="email">Email автора</label>
            <input type="text" name="author_email" id="email" required maxlength="255" value="<?php echo htmlspecialchars( $results['comment']->authorEmail )?>" />
          </li>
          <li>
            <label for="message">Повідомлення</label>
            <textarea name="message" id="message" required maxlength="2000" style="height: 10em;"><?php echo htmlspecialchars( $results['comment']->message )?></textarea>
          </li>
        </ul>
        <div class="buttons">
          <input type="submit" name="saveChanges" value="Зберегти зміни" />
          <input type="submit" formnovalidate name="cancel" value="Скасувати" />
        </div>
      </form>

      <?php if ( $results['comment']->id ) { ?>
      <a class="delete" href="admin.php?action=deleteComment&amp;commentId=<?php echo $results['comment']->id ?>&amp;bookId=<?php echo $results['comment']->bookId ?>" onclick="return confirm('Видалити Коментар?')">Видалити Коментар</a>
      <?php } ?>

    </div>
  </main>
<?php include "templates/admin/include/footer.php" ?>

