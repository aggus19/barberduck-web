<?php

include_once 'IP.php';

class User extends Database
{
	public $id_usuario;
	public $nombre;
	public $apellido;
	public $email;
	public $telefono;
	public $password;

	public function __construct()
	{
		$this->id_usuario = ['id_usuario'];
		$this->nombre = ['nombre'];
		$this->apellido = ['apellido'];
		$this->email = ['email'];
		$this->telefono = ['telefono'];
		$this->password = ['password'];
	}

	public static function GetUserById($id)
	{
		$mbd = new Database();
		$ads = $mbd->prepare("SELECT * FROM usuarios WHERE id_usuario = :id");
		$ads->bindParam(':id', $id, PDO::PARAM_STR);
		$ads->execute();
		$uInfo = $ads->fetchAll();
		return $uInfo[0];
	}

	public static function GetInfoByTelefono($telefono)
	{
		$mbd = new Database();
		$ads = $mbd->prepare("SELECT * FROM usuarios WHERE telefono = :telefono");
		$ads->bindParam(':telefono', $telefono, PDO::PARAM_STR);
		$ads->execute();
		$uInfo = $ads->fetch(PDO::FETCH_ASSOC);
		return $uInfo;
	}


	public static function CreateNewUser($nombre, $apellido, $email, $telefono)
	{
		$mbd = new Database();

		// Verificar si el número de teléfono ya está en uso
		$stmt = $mbd->prepare("SELECT COUNT(*) FROM usuarios WHERE telefono = :telefono");
		$stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
		$stmt->execute();

		if ($stmt->fetchColumn() > 0) {
			// El número de teléfono ya está en uso, no se puede crear un nuevo usuario
			throw new Exception('El número de teléfono ya está en uso.');
		}

		// Crear el nuevo usuario
		$stmt = $mbd->prepare("INSERT INTO usuarios (nombre, apellido, email, telefono) VALUES (:nombre, :apellido, :email, :telefono)");
		$stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
		$stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
		$stmt->execute();

		// Obtener la información del nuevo usuario y devolverla
		$id = $mbd->lastInsertId();
		$stmt = $mbd->prepare("SELECT * FROM usuarios WHERE id_usuario = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$uInfo = $stmt->fetch(PDO::FETCH_ASSOC);

		return $uInfo;
	}
}
