<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars( $results['pageTitle'] )?></title>
    <link rel="stylesheet" href="css/admin-styles.css">
  </head>
  <body class="body_type_login-page">
    <div class="login-panel">
      <form class="login-form" action="admin.php?action=login" method="post">
        <input type="hidden" name="login" value="true" />

        <?php if ( isset( $results['errorMessage'] ) ) { ?>
          <div class="errorMessage login-form__errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php } ?>

        <ul>
          <li>
            <label class="login-form__label" for="username">Логін</label>
            <input class="login-form__input" type="text" name="username" id="username" placeholder="Your admin username" required autofocus maxlength="20" />
          </li>
          <li>
            <label class="login-form__label" for="password">Пароль</label>
            <input class="login-form__input" type="password" name="password" id="password" placeholder="Your admin password" required maxlength="20" />
          </li>
        </ul>
        <div class="buttons">
            <input type="submit" name="login" value="Увійти" />
        </div>
      </form>
      <a href="." class="login-panel__return">← Назад до сайту</a>
    </div>
  </body>
</html>



      



