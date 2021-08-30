<?php

function generateTransactionForm($action)
{
  echo ("<form action='" . $action . "' method='GET'>
      <label for='type-origin'>Seleccione el tipo de cuenta de destino: </label>
      <select name='type-destiny' id='type-destiny'>
        <option value='own'>Cuenta propia</option>
        <option value='third'>Cuenta tercero</option>
      </select>
      <input type='submit' name='search' value='Ver cuentas'>
    </form>");
}

function buildAccountArticle($origin, $artClass, $account)
{
  $name = $origin ? 'origin' : 'destiny';
  echo ("
    <article class='artClass'>
      <input type='checkbox' name='$name' value='{$account->getAccount()}'>
      <h4>{$account->getAccount()}</h4>");
  if ($name == "origin") {
    // Solo mostrará el dinero en la cuenta si es cuenta de origen
    echo ("<p>{$account->getMoney()}</p>");
  }
  echo ("</article>");
}
