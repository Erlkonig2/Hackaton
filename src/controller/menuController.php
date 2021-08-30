<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("location:../../");
}

require("../assets/php/helpers.php");
require("../model/Connection.php");
require("../model/AccountModel.php");
require("../model/TransactionModel.php");
require("../model/UserModel.php");
$transactions;
$user;
$origins = [];
$destinies = [];
$msg;
$client = UserModel::getUser($_SESSION['user'], $_SESSION['name'], $_SESSION['lastN']);
// Datos formulario selección tipo cuenta destino
if (isset($_GET['search'])) {
  $user = UserModel::getUser($_SESSION['user'], $_SESSION['name'], $_SESSION['lastN']);
  $origins = $user->searchOwnAccounts();
  if ($_GET['type-destiny'] === "own") {
    $destinies = array_merge($destinies, $origins);
    if (count($origins) <= 1) {
      $msg = "No tienes cuentas suficientes para realizar esta operación";
    }
  } else {
    $destinies = $user->searchThirdsAccounts();
    var_dump($destinies);
  }
}

// Datos para transferencia de dinero
if (isset($_GET['transfer'])) {
    if ($_GET['origin'] == $_GET['destiny']) {
      $msg = "No puedes realizar una transferencia a la misma cuenta";
    } else {
      if ($_GET['money'] > 0) {
        $transaction = new TransactionModel($_GET['origin'], $_GET['destiny'], $_GET['money']);
        $msg = "Transacción éxitosa, el código de la transacción es: {$transaction->transferMoney()}";
      } else {
        $msg = "El monto introducido no es válido";
      }
    }
}
require("../view/mainView.php");
