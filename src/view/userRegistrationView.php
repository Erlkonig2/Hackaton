<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar</title>
</head>

<body>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  <h1>Registrar</h1>
    <label for="id">Cédula: </label>
    <input type="number" name="id" id="id">
    <label for="name"> Nombres: </label>
    <input type="text" name="name" id="name">
    <label for="lastN">Apellidos: </label>
    <input type="text" name="lastN" inputmode="lastN">
    <label for="password">Clave: </label>
    <input type="password" name="password" id="password" maxlength="4">
    <label for="conf">Confirmar clave: </label>
    <input type="password" name="conf" id="conf" maxlength="4">

    <?php if (isset($msg)) : ?>
      <p class="msg"><?php echo $msg ?></p>
    <?php endif ?>

    <input type="submit" value="Registrar" name="register">
    <button type="button"><a href="../../index.php">Volver</a></button>
  </form>
</body>

</html>