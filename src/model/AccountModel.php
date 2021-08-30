<?php
class Account
{
	private $nAccount;
	private $client;
	private $money;
	private $state;

	public function __construct($nAccount, $client, $money, $state)
	{
		$this->nAccount = $nAccount;
		$this->client = $client;
		$this->money = $money;
		$this->state = $state;
	}

	public function getAccount()
	{
		return $this->nAccount;
	}

	public function getClient()
	{
		return $this->client;
	}

	public function getMoney()
	{
		return $this->money;
	}

	public function getState()
	{
		return $this->state;
	}

	public static function validateMoney($account, $transfering = null)
	{
		$conn = Connection::connect();
		try {
			$query = $conn->prepare("SELECT monto FROM cuenta WHERE ncuenta=:account");
			$query->execute(array(":account" => $account));
			$result = $query->fetch(PDO::FETCH_ASSOC);
			if (!is_null($transfering)) {
				if ($transfering > $result['monto']) {
					return null;
				}
			}
			return $result['monto'];
		} catch (Exception $e) {
			die("Algo salió mal: {$e->getMessage()} en la línea {$e->getLine()}");
		} finally {
			Connection::close($conn);
		}
	}

	public static function validateState($account)
	{
		$conn = Connection::connect();
		try {
			$query = $conn->prepare("SELECT estado FROM cuenta WHERE ncuenta=:account");
			$query->execute(array(":account" => $account));
			$result = $query->fetch(PDO::FETCH_ASSOC);
			if ($result['estado'] !== "Activa") {
				return false;
			}
			return true;
		} catch (Exception $e) {
			die("Algo salió mal: {$e->getMessage()} en la línea {$e->getLine()}");
		} finally {
			Connection::close($conn);
		}
	}

	public static function validateTransaction($account, $money)
	{
		$deduction = null;
		$increment = null;
		$conn = Connection::connect();
		try {
			$query = $conn->prepare("UPDATE cuenta SET monto=:money WHERE ncuenta=:account");
			$query->execute(array(":money"=>$money, ":account"=>$account));
			if ($query->rowCount() == 1) {
				return true;
			}
			return false;
		} catch (Exception $e) {
			echo ("Algo salió mal: {$e->getMessage()} en la línea {$e->getLine()}");
			return false;
		} finally {
			Connection::close($conn);
		}
	}
}
