<?php

include_once 'IP.php';

class Searchs extends Database
{
	public $id;
	public $ip;
	public $token;
	public $allowed;
	public $alias;

	public function __construct()
	{
		parent::__construct(); // Llama al constructor de la clase padre

		$this->id = 'id';
		$this->ip = 'ip';
		$this->token = 'token';
		$this->allowed = 'allowed';
		$this->alias = 'alias';
	}

	// Verificar si la IP del usuario está autorizada (osea esta allowed 1)
	public static function IsAllowed($ip)
	{
		$db = new Database(); // Assuming Database is a class you extend or use
		$stmt = $db->prepare("SELECT * FROM allowed_users WHERE ip = :ip AND allowed = 1");
		$stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
		$stmt->execute();
		$uInfo = $stmt->fetch(PDO::FETCH_ASSOC);
		return $uInfo;
	}

	public static function InsertNewAllowedIP($ip, $token, $allowed, $alias)
	{
		$db = new Database();

		// Verificar si la IP ya existe
		$stmt = $db->prepare('SELECT * FROM allowed_users WHERE ip = :ip');
		$stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
		$stmt->execute();

		if ($stmt->fetch(PDO::FETCH_ASSOC)) {
			// La IP ya existe, devolver un error
			return "Error: la IP ya existe en la base de datos";
		}

		// Si la IP no existe, insertarla
		$stmt = $db->prepare('INSERT INTO allowed_users (ip, token, allowed, alias) VALUES (:ip, :token, :allowed, :alias)');
		$stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
		$stmt->bindParam(':token', $token, PDO::PARAM_STR);
		$stmt->bindParam(':allowed', $allowed, PDO::PARAM_INT);
		$stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
		$stmt->execute();
	}
}