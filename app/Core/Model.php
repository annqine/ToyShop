<?php
require_once 'Config.php';

class Model
{
	protected $db;

	public function __construct()
	{
		try {
			$this->db = new PDO(Config::getDSN(), Config::DB_USER, Config::DB_PASS);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die('Database Connection Error: ' . $e->getMessage());
		}
	}
}
?>