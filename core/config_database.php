<?php 
/**
* 
*/
class Database
{	
	private $config = array(
				"servername"	=>	"localhost",
				"username"		=>	"root",
				"password"		=>	"",
				"dbname"		=>	"test",
			);
	private $db;

	function mySqli()
	{
		$this->db = new mysqli($this->config["servername"], $this->config["username"], $this->config["password"], $this->config["dbname"]);

		if ($this->db->connect_errno) {
			$pesan = "<span style='color:red;'>Gagal Koneksi Database = </span>";
			die($pesan.$this->db->connect_error);
			// echo $pesan." : ".$this->db->connect_error;
		}/* else {
			die("berhasil Koneksi.");
		}*/
		return $this->db;
	}

	function db_pdo()
	{
		try {
		    $this->db = new PDO("mysql:host=".$this->config["servername"].";dbname=".$this->config["dbname"], $this->config["username"], $this->config["password"]);
		    // set the PDO error mode to exception
		    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    // echo "Connected successfully"; 

		} catch(PDOException $e) {
			$pesan = "<span style='color:red;'>Gagal Koneksi Database = </span>";
			die($pesan.$e->getMessage());
		}
		return $this->db;
	}
}


?>