<?php
require("../model/Connection.php");
require("../model/UserModel.php");
$msg;
if (isset($_POST['register'])) {
  if (
    strlen($_POST['id']) != 0 && strlen($_POST['name']) != 0
    && strlen($_POST['lastN']) != 0 && strlen($_POST['password']) != 0
  ) {
    if (preg_match(('/^[0-9]{4}$/'), $_POST['password'])) {
      if ($password === $_POST['conf']) {
        // print "Hola";
        UserModel::getUser(
          filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT),
          filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
          filter_input(INPUT_POST, 'lastN', FILTER_SANITIZE_STRING)
        );
        $msg = UserModel::regist(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
      } else {
        $msg = "Las claves no coinciden";
      }
    } else {
      $msg = "La clave ingresada no es válida";
    }
  } else {
    $msg = "No deben haber campos vacíos";
  }
}
require('../view/userRegistrationView.php');
