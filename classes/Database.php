<?php
require_once __DIR__ . '/../vendor/autoload.php';

class Database extends PDO
{
	private $servername;
	private $user;
	private $password;
	private $dbname;

	public function __construct()
	{
		// Carga las variables de entorno desde el archivo .env
		$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
		$dotenv->load();

		// Asigna los valores de las variables de entorno a las propiedades de la clase
		$this->servername = $_ENV['DB_HOST'];
		$this->user = $_ENV['DB_USER'];
		$this->password = $_ENV['DB_PASSWORD'];
		$this->dbname = $_ENV['DB_NAME'];

		try {
			parent::__construct("mysql:dbname={$this->dbname};host={$this->servername};port=3306;charset=utf8", $this->user, $this->password);
		} catch (PDOException $e) {
			echo '[Database] Ha surgido un error y no se puede conectar a la base de datos. (' . $e->getMessage() . ')';
			exit;
		}
	}
}
