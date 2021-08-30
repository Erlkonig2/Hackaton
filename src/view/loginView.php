<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio sesión</title>
</head>

<body>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  <h1>Iniciar sesión</h1>
    <label for="id">Cédula: </label>
    <input type="number" id="id" name="id">
    <label for="password">Password: </label>
    <input type="password" id="password" name="password" maxlength="4">
    <?php if (isset($msg)) : ?>
      <p class="msg"><?php echo $msg ?></p>
    <?php endif ?>
    <input type="submit" value="Iniciar sesión" name="login">
    <button type="button"><a href="src/controller/userRegistController.php">Registrar</a></button>
  </form>
</body>

</html>