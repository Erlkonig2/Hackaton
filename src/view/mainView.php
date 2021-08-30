<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menú</title>
</head>

<body>
  <header>
    <h3><?php echo ($_SESSION['name']); ?></h3>
    <nav>
      <ul>
        <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>?transaction=1">Transacciones bancarias</a></li>
        <li><a href="">Estado de cuenta</a></li>
        <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>?exit=1">Salir</a></li>
      </ul>
    </nav>
  </header>
  <?php
  if (isset($_GET['transaction'])) {
    generateTransactionForm($_SERVER['PHP_SELF']);
  }

  if (isset($user)) {
    if (!isset($msg)) {
      echo ("<form action='" . $_SERVER['PHP_SELF'] . "' method='GET'>
      <h3>Cuenta origen</h3>");
      foreach ($origins as $origin) {
        buildAccountArticle(true, "left", $origin);
        echo "<br>";
      }
      echo "<h3>Cuenta Destino</h3>";
      foreach ($destinies as $destiny) {
        buildAccountArticle(false, "right", $destiny);
        echo "<br>";
      }
      echo ("<label for='money'>Monto transferir: </label>
      <input type='number' name='money' id='money'>
      <input type='submit' name='transfer' value='Transferir'>
      </form>");
    } else {
      echo "<p class='error'>$msg</p>";
    }
  }
  if (isset($msg)) {
    echo "<p class='advise'>$msg</p>";
  }

  if (isset($_GET['exit'])) {
    echo ("<form action'" . $_SERVER['PHP_SELF'] . "' method='POST'
      <p>¿Seguro de que quieres cerrar sesión?</p>
      <input type='submit' name='confirm' value='Confirmar'>
      <input type='submit' name='cancel' value='Cancelar'>
      </form>");
  }
  ?>
</body>

</html>