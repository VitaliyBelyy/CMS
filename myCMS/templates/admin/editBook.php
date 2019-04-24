<?php include "templates/admin/include/header.php" ?>
  <main>
    <div class="container clearfix">
      <h1 class="page-title"><?php echo $results['pageTitle']?></h1>
      <form action="admin.php?action=<?php echo $results['formAction']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="book_code" value="<?php echo $results['book']->id ?>"/>

        <?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php } ?>

        <ul>
          <li>
            <label for="title">Назва книги</label>
            <input type="text" name="name" id="title" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['book']->name )?>" />
          </li>
          <li>
            <label for="description">Опис книги</label>
            <textarea name="description" id="description" required maxlength="2000" style="height: 10em;"><?php echo htmlspecialchars( $results['book']->description )?></textarea>
          </li>
          <li>
            <label for="excerpt">Уривок з книги</label>
            <textarea name="excerpt" id="excerpt" required maxlength="2000" style="height: 10em;"><?php echo htmlspecialchars( $results['book']->excerpt )?></textarea>
          </li>
          <li>
            <label for="section_code">Розділ книги</label>
            <select name="section_code" id="section_code">
              <option value="0"<?php echo !$results['book']->sectionId ? " selected" : ""?>>(none)</option>

              <?php foreach ( $results['sections'] as $section ) { ?>
              <option value="<?php echo $section->id?>"<?php echo ( $section->id == $results['book']->sectionId ) ? " selected" : ""?>><?php echo htmlspecialchars( $section->name )?></option>
              <?php } ?>

            </select>
          </li>
          <li>
            <label for="specifications_code">Характеристики книги</label>
            <select name="specifications_code" id="specifications_code">

              <option value="0"<?php echo !$results['book']->specificationsId ? " selected" : ""?>>(none)</option>
              <?php foreach ( $results['specifications'] as $specifications ) { ?>
              <option value="<?php echo $specifications->id?>"<?php echo ( $specifications->id == $results['book']->specificationsId ) ? " selected" : ""?>><?php echo $specifications->id ?></option>
              <?php } ?>

            </select>
          </li>
          <li>
            <label for="price">Ціна книги</label>
            <input type="text" name="price" id="price" required value="<?php echo $results['book']->price ?>" />
          </li>
          <li>
            <label for="amount">Кількість книг</label>
            <input type="text" name="amount" id="amount" required value="<?php echo $results['book']->amount ?>" />
          </li>
          <li>
            <label for="discount">Відсоток знижки</label>
            <input type="text" name="discount" id="discount" value="<?php echo $results['book']->discount ?>" />
          </li>

          <?php if ( $results['book'] && $imagePath = $results['book']->getImagePath() ) { ?>
          <li>
            <label>Поточне зображення</label>
            <img id="bookImage" src="<?php echo $imagePath ?>" alt="Book Image" />
          </li>
          <li>
            <label for="deleteImage">Видалити</label>
            <input type="checkbox" name="deleteImage" id="deleteImage" value="yes"/ >
          </li>
          <?php } ?>
 
          <li>
            <label for="image">Нове зображення</label>
            <input type="file" name="image" id="image" placeholder="Choose an image to upload" maxlength="255" />
          </li>
        </ul>
        <div class="buttons">
          <input type="submit" name="saveChanges" value="Зберегти зміни" />
          <input type="submit" formnovalidate name="cancel" value="Скасувати" />
        </div>
      </form>

      <?php if ( $results['book']->id ) { ?>
      <a class="delete" href="admin.php?action=deleteBook&amp;bookId=<?php echo $results['book']->id ?>" onclick="return confirm('Видалити Книгу?')">Видалити Книгу</a>
      <a class="view-comments" href="admin.php?action=listComments&amp;bookId=<?php echo $results['book']->id ?>">Переглянути Коментарі</a>
      <?php } ?>

    </div>
  </main>
<?php include "templates/admin/include/footer.php" ?>