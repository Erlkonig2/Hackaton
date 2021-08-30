<?php
class TransactionModel
{
  private $nTransaction;
  private $cOrigin;
  private $cDestiny;
  private $money;
  private $date;
  private $time;

  public function __construct($cOrigin, $cDestiny, $money)
  {
    $this->cOrigin = $cOrigin;
    $this->cDestiny = $cDestiny;
    $this->money = $money;
  }

  public function getTransaction()
  {
    return $this->nTransaction;
  }

  public function getOrigin()
  {
    return $this->cOrigin;
  }

  public function getDestiny()
  {
    return $this->cDestiny;
  }

  public function getMoney()
  {
    return $this->money;
  }

  public function getDate()
  {
    return $this->date;
  }

  public function getTime()
  {
    return $this->time;
  }

  public function setDate($date)
  {
    return $this->date = $date;
  }

  public function setTime($time)
  {
    return $this->time = $time;
  }

  public function transferMoney()
  {
    // Se obtiene el dinero en las dos cuentas
    $originMoney = Account::validateMoney($this->cOrigin, $this->money);
    $destinyMoney = Account::validateMoney($this->cDestiny);
    if (is_null($originMoney)) {
      return "No tienes suficiente dinero en tu cuenta para realizar esta transacción";
    }
    // Validación del estado de las cuentas
    if (!Account::validateState($this->cOrigin)) {
      return "La cuenta de origen no se encuentra activa";
    } else if (!Account::validateState($this->cDestiny)) {
      return "La cuenta de destino no se encuentra activa";
    }
    $conn = Connection::connect();
    $deduction = $originMoney - $this->money;
    $increment = $destinyMoney + $this->money;
    // Actualización de dinero en ambas cuentas
    if (
      Account::validateTransaction($this->cOrigin, $deduction)
      && Account::validateTransaction($this->cDestiny, $increment)
    ) {
      // Almacenado de registro transacción
      try {
        $query = $conn->prepare("INSERT INTO transaccion(corigen, monto, cdestino, fecha_hora) 
        VALUES(:origin, :money, :destiny, NOW())");
        $query->execute(array(":origin"=>$this->cOrigin, ":money" => $this->money, ":destiny" => $this->cDestiny));
        if ($query->rowCount() == 1) {
          return $conn->lastInsertID();
        }
      } catch (Exception $e) {
        return false;
      } finally {
        Connection::close($conn);
      }
    }
  }

  public static function transactionsList($origin = null, $destint = null) {
    
  }
}
