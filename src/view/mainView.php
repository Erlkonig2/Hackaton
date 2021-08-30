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
        <li><a href="">Cuentas propias</a></li>
        <li><a href="">Salir</a></li>
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
      }
      echo "<h3>Cuenta Destino</h3>";
      foreach ($destinies as $destiny) {
        buildAccountArticle(false, "right", $destiny);
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
  ?>
</body>

</html>