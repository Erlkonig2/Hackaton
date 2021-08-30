<?php
require("src/model/Connection.php");
require("src/model/UserModel.php");
$msg;
if (isset($_POST['login'])) {
  if (strlen($_POST['id'] != 0 && strlen($_POST['password']) != 0)) {
    if (preg_match('/^[0-9]{4}$/', $_POST['password'])) {
      // Se verifica la validez de la clave con esta expresión regular
      $msg = UserModel::login(
        filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT),
        filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)
        // Eliminación de caracteres especiales para que no lleguen a la consulta a la BBDD
      );
    } else {
      $msg = "La contraseña no es válida";
    }
  } else {
    $msg = "No deben haber campos vacíos";
  }
}
require("src/view/loginView.php");
