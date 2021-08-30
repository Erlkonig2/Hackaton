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
if (isset($_GET['search'])) {
  $user = UserModel::getUser($_SESSION['user'], $_SESSION['name'], $_SESSION['lastN']);
  if ($_GET['type-destiny'] === "own") {
    $origins = $user->searchOwnAccounts();
    $destinies = array_merge($destinies, $origins);
    if (count($origins) <= 1) {
      $msg = "No tienes cuentas suficientes para realizar esta operación";
    }
  }
}

if (isset($_GET['transfer'])) {
  if ($_GET['origin'] == $_GET['destiny']) {
    $msg = "No puedes realizar una transferencia a la misma cuenta";
  } else {
    $transaction = new TransactionModel($_GET['origin'], $_GET['destiny'], $_GET['money']);
    $msg = "Transacción éxitosa, el código de la transacción es: {$transaction->transferMoney()}";
  }
}
require("../view/mainView.php");
