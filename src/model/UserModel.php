<?php
class UserModel
{
	public static $user;
	private $id;
	private $name;
	private $lastName;
	private $ownAccounts;
	private $thirdAccounts;

	// Hago uso de Singleton ya que no se necesita más de una instancia de usuario
	private function __construct($id, $name, $lastName)
	{
		$this->id = $id;
		$this->name = $name;
		$this->lastName = $lastName;
		$this->accounts = [];
		$this->thirdAccounts = [];
	}

	public static function getUser($id, $name, $lastName)
	{
		if (!isset(self::$user)) {
			self::$user = new UserModel($id, $name, $lastName);
		}
		return self::$user;
		// Si no existe la instancia de usuario la crea, luego la retorna
	}

	public function getId()
	{
		return self::$user->id;
	}

	public function getAccounts()
	{
		return self::$user->ownAccounts;
	}

	private static function searchUser()
	{
		$conn = Connection::connect();
		try {
			$result = $conn->prepare("SELECT * FROM usuario WHERE cedula = :id");
			$result->execute(array(":id" => self::$user->id));
			if ($result->rowCount() === 1) {
				return true;
				// Retorna true si encuentra al usuario
			}
			return false;
		} catch (Exception $e) {
			die("Algo salió mal: {$e->getMessage()}");
		} finally {
			$conn = null;
		}
	}

	public static function regist($password)
	{
		if (self::searchUser()) {
			return "Este usuario ya se encuentra registrado";
		}
		$conn = Connection::connect();
		try {
			$hash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
			// Se encripta la clave del usuario con Blowfish y una sal de 12
			$query = $conn->prepare("INSERT INTO usuario (cedula, nombres, apellidos, clave) 
			VALUES (:id, :name, :lastN, :password)");
			$query->execute(array(
				":id" => self::$user->id,
				":name" => self::$user->name,
				":lastN" => self::$user->lastName, ":password" => $hash
			));
			if ($query->rowCount() != 0) {
				return "Usuario creado con éxito";
			}
		} catch (Exception $e) {
			return $e->getMessage();
		} finally {
			Connection::close($conn);
		}
	}

	public static function login($id, $password)
	{
		$conn = Connection::connect();
		try {
			$query = $conn->prepare("SELECT * FROM usuario WHERE cedula=:id");
			$query->execute(array(":id" => $id));
			if ($query->rowCount() != 0) {
				$register = $query->fetch(PDO::FETCH_ASSOC);
				if (password_verify($password, $register['clave'])) {
					session_start();
					// Se inicia sesión guardando los datos del usuario
					$_SESSION['user'] = $register['cedula'];
					$_SESSION['name'] = $register['nombres'];
					$_SESSION['lastN'] = $register['apellidos'];
					Connection::close($conn);
					header("location:src/controller/menuController.php");
				} else {
					return "Usuario o contraseña incorrecta";
				}
			} else {
				return "Usuario o contraseña incorrecta";
			}
		} catch (Exception $e) {
			return "Ha ocurrido un error: {$e->getMessage()} en la línea {$e->getLine()}";
		} finally {
			Connection::close(($conn));
		}
	}

	public function searchOwnAccounts()
	{
		$conn = Connection::connect();
		try {
			$query = $conn->prepare("SELECT * FROM cuenta WHERE usuario = :id AND estado=:state");
			$query->execute(array(":id" => self::$user->id, ":state" => "Activa"));
			while ($account = $query->fetch(PDO::FETCH_ASSOC)) {
				self::$user->ownAccounts[] = new Account(
					$account['ncuenta'],
					$account['usuario'],
					$account['monto'],
					$account['estado']
				);
			}
			return self::$user->ownAccounts;
		} catch (Exception $e) {
			return "Algo salió mal: {$e->getMessage()}";
		} finally {
			Connection::close($conn);
		}
	}

	public function searchThirdsAccounts()
	{
		$conn = Connection::connect();
		try {
			$query = $conn->prepare("SELECT * FROM terceros WHERE cedula = :id");
			$query->execute(array(":id" => self::$user->id));
			while ($account = $query->fetch(PDO::FETCH_ASSOC)) {
				self::$user->thirdAccounts[] = new Account(
					$account['ncuenta'],
					$account['cedula']
				);
			}
			return self::$user->thirdAccounts;
		} catch (Exception $e) {
			return "Algo salió mal: {$e->getMessage()}";
		} finally {
			Connection::close($conn);
		}
	}
}
