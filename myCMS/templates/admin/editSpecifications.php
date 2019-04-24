<?php include "templates/admin/include/header.php" ?>
  <main>
    <div class="container clearfix">
      <h1 class="page-title"><?php echo $results['pageTitle']?></h1>
      <form action="admin.php?action=<?php echo $results['formAction']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="specifications_code" value="<?php echo $results['specifications']->id ?>"/>

        <?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php } ?>

        <ul>
          <li>
            <label for="author_code">Автор книги</label>
            <select name="author_code" id="author_code">
              <option value="0"<?php echo !$results['specifications']->authorId ? " selected" : ""?>>(none)</option>

              <?php foreach ( $results['authors'] as $author ) { ?>
              <option value="<?php echo $author->id?>"<?php echo ( $author->id == $results['specifications']->authorId ) ? " selected" : ""?>><?php echo htmlspecialchars( $author->fullName ) ?></option>
              <?php } ?>

            </select>
          </li>
          <li>
            <label for="publishing_house_code">Видавництво</label>
            <select name="publishing_house_code" id="publishing_house_code">

              <option value="0"<?php echo !$results['specifications']->publishingHouseId ? " selected" : ""?>>(none)</option>
              <?php foreach ( $results['publishingHouses'] as $publishingHouse ) { ?>
              <option value="<?php echo $publishingHouse->id?>"<?php echo ( $publishingHouse->id == $results['specifications']->publishingHouseId ) ? " selected" : ""?>><?php echo htmlspecialchars( $publishingHouse->name ) ?></option>
              <?php } ?>

            </select>
          </li>
          <li>
            <label for="language">Мова</label>
            <input type="text" name="language" id="language" value="<?php echo $results['specifications']->language ?>" />
          </li>
          <li>
            <label for="publishing_year">Рік видання</label>
            <input type="text" name="publishing_year" id="publishing_year" value="<?php echo $results['specifications']->publishingYear ?>" />
          </li>
          <li>
            <label for="pages_number">Кількість сторінок</label>
            <input type="text" name="pages_number" id="pages_number" value="<?php echo $results['specifications']->pagesNumber ?>" />
          </li>
          <li>
            <label for="format">Формат</label>
            <input type="text" name="format" id="format" value="<?php echo $results['specifications']->format ?>" />
          </li>
          <li>
            <label for="cover">Палітурка</label>
            <input type="text" name="cover" id="cover" value="<?php echo $results['specifications']->cover ?>" />
          </li>
          <li>
            <label for="isbn">ISBN</label>
            <input type="text" name="isbn" id="isbn" value="<?php echo $results['specifications']->isbn ?>" />
          </li>
        </ul>
        <div class="buttons">
          <input type="submit" name="saveChanges" value="Зберегти зміни" />
          <input type="submit" formnovalidate name="cancel" value="Скасувати" />
        </div>
      </form>

      <?php if ( $results['specifications']->id ) { ?>
      <a class="delete" href="admin.php?action=deleteSpecifications&amp;specificationsId=<?php echo $results['specifications']->id ?>" onclick="return confirm('Видалити Характеристики?')">Видалити Характеристики</a>
      <?php } ?>

    </div>
  </main>
<?php include "templates/admin/include/footer.php" ?>