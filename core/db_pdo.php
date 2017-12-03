<?php 

require_once 'config_database.php';
/**
* 
*/
class Model_pdo extends Database
{
	protected $db;
	protected $table;
	protected $primary_id = "id";

	function __construct()
	{
		$this->db = parent::db_pdo();
	}

	public function setTable($tablName)
	{
		$this->table = $tablName;
	}

	public function getTable()
	{
		return $this->table;
	}

	/**
	* @param $select  = "name, age, address" OR array("name","age","address");
	* @param $where   = array("name" => $name,"age" => $age,"address" => $address);
	* @param $orderBy =	"name ASC, age DESC" OR array("name" => "ASC","age" => "DESC");
	* @param $search  = array("name" => $search,"age",$search);
	* @param $join 	  = array(
	*							array("table[2]","table[2].id = table[1].table[2]_id",["INNER"]),
	*							array("table[3]","table[3].id = table[2].table[3]_id",["INNER"]),
	*						);
	* @param $limit   = 10;
	* @param $offset  = 25;
	*/
	public function findData($select=false,$where=false,$orderBy=false,$search=false,$join=false,$limit=false,$offset=false)
	{
		if ($select) {
			$select = is_array($select) ? implode(", ", $select) : $select;
		} else {
			$select = "*";
		}

		$sql = "SELECT ".$select." FROM ".$this->table;

		if ($where) {
			$sql .= " WHERE ";
			$field = null;
			foreach ($where as $key => $value) {
				$key = explode(" ", $key);
				$key = count($key) > 1 ?  $key[0]." ".($key[1] == "" ? "= " : $key[1]) : $key[0]." = ";
				$value = $this->db->quote($value);
				$field .= " AND ".$key." ".$value." ";
			}
			$sql .= substr($field,4);
		}

		if ($search) {
			$field = null;
			if ($where) {
				$sql .= " ( ";
				foreach ($search as $key => $value) {
					$value = $this->db->quote("%".$value."%");
					$field .= "OR ".$key." LIKE ".$value." ";
				}
				$sql .= substr($field, 3)." ) ";
			} else {
				$sql .= " WHERE ";
				foreach ($search as $key => $value) {
					$value = $this->db->quote("%".$value."%");
					$field .= "OR ".$key." LIKE ".$value." ";
				}
				$sql .= substr($field, 3);
			}
		}

		if ($join) {
			$data = null;
			foreach ($join as $val) {
				// val[0] == table
				// val[1] == field penghubung
				// val[2] == type(INNER or LEFT or RIGHT or FULL)
				$type = isset($val[2]) ? $val[2] : "INNER";
				$data .= $type." JOIN ".$val[0]." ON ".$val[1]." ";
			}
			$sql .= $data;
		}

		if ($orderBy) {
			$sql .= " ORDER BY ";
			$field = null;
			if (is_array($orderBy)) {
				foreach ($orderBy as $key => $value) {
					$field .= ", ".$key." ".$value;
				}
				$sql .= substr($field, 2);
			} else {
				$sql .= $orderBy;
			}
		}

		if ($limit) {
			$offset = $offset == true ? " OFFSET ".$offset : "";
			$sql .= " LIMIT ".$limit." ".$offset;
		}
		/*return $sql;
		exit();*/
		
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt->fetchALL(PDO::FETCH_OBJ);
	}

	public function findDataPaging($page,$limit=10,$select=false,$where=false,$orderBy=false,$search=false,$join=false)
	{
		$offset = ($page - 1) * $limit;
		$result = self::findData($select,$where,$orderBy,$search,$join,$limit,$offset);
		return $result;
	}

	public function getCount($where=false,$search=false,$join=false)
	{
		$sql = "SELECT * FROM ".$this->table;
		if ($where) {
			$sql .= " WHERE ";
			$field = null;
			foreach ($where as $key => $value) {
				$key = explode(" ", $key);
				$key = count($key) > 1 ?  $key[0]." ".($key[1] == "" ? "= " : $key[1]) : $key[0]." = ";
				$value = $this->db->quote($value);
				$field .= " AND ".$key." ".$value." ";
			}
			$sql .= substr($field,4);
		}

		if ($search) {
			$field = null;
			if ($where) {
				$sql .= " ( ";
				foreach ($search as $key => $value) {
					$value = $this->db->quote("%".$value."%");
					$field .= "OR ".$key." LIKE ".$value." ";
				}
				$sql .= substr($field, 3)." ) ";
			} else {
				$sql .= " WHERE ";
				foreach ($search as $key => $value) {
					$value = $this->db->quote("%".$value."%");
					$field .= "OR ".$key." LIKE ".$value." ";
				}
				$sql .= substr($field, 3);
			}
		}

		if ($join) {
			$data = null;
			foreach ($join as $val) {
				// val[0] == table
				// val[1] == field penghubung
				// val[2] == type(INNER or LEFT or RIGHT or FULL)
				$type = isset($val[2]) ? $val[2] : "INNER";
				$data .= $type." JOIN ".$val[0]." ON ".$val[1]." ";
			}
			$sql .= $data;
		}
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function getCountPaging($limit=10,$where=false,$search=false,$join=false)
	{
		$result = self::getCount($where,$search,$join);
		$result = ceil($result / $limit);
		return $result;
	}

	public function setPrimaryId($id)
	{
		$this->primary_id = $id;
	}

	public function getById($id)
	{
		$id = $this->db->quote($id);
		$sql = "SELECT * FROM ".$this->table." WHERE ".$this->primary_id." = ".$id;
		return self::fetchObj($sql);
	}

	public function getByWhere($where,$or_where=false)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE ";
		$field = null;
		foreach ($where as $key => $value) {
			$key = explode(" ", $key);
			$key = count($key) > 1 ?  $key[0]." ".($key[1] == "" ? "= " : $key[1]) : $key[0]." = ";
			$value = $this->db->quote($value);
			$field .= " AND ".$key." ".$value." ";
		}
		$sql .= substr($field,4);
		if ($or_where) {
			$field_or = null;
			foreach ($or_where as $key => $value) {
				$key = explode(" ", $key);
				$key = count($key) > 1 ?  $key[0]." ".($key[1] == "" ? "= " : $key[1]) : $key[0]." = ";
				$value = $this->db->quote($value);
				$field_or .= " OR ".$key." ".$value." ";
			}
			$sql .= " AND ( ".substr($field_or, 3)." )";
		}
		return self::fetchObj($sql);
	}

	public function fetchObj($sql)	// for function getById and getByWhere
	{
		$stmt = $this->db->prepare($sql);
		if ($stmt->execute()) {
			return $stmt->fetch(PDO::FETCH_OBJ);
		} else {
			return false;
		}
	}

	public function insert($data,$table=false)
	{
		$table = $table ? $table : $this->table;
		$sql = "INSERT INTO ".$table." ";
		$fields = null;
		$values = null;
		foreach ($data as $key => $val) {
			$fields .= ", ".$key;
			$val = $this->db->quote($val);
			$values .= ", ".$val." ";
		}
		$sql .= "(".substr($fields, 2).") ";
		$sql .= "VALUES (".substr($values, 2).")";

		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $this->db->lastInsertId();
	}

	public function update($id,$data,$table=false)
	{
		$table = $table ? $table : $this->table;
		$sql = "UPDATE ".$table." SET ";
		$set = null;
		foreach ($data as $key => $value) {
			$value = $this->db->quote($value);
			$set .= ", ".$key." = ".$value." ";
		}
		$id = $this->db->quote($id);
		$sql .= substr($set, 2)." WHERE ".$this->primary_id." = ".$id; //$id, recomended using $_POST["id"];
		$stmt = $this->db->prepare($sql);
		return $stmt->execute();
	}

	public function delete($id,$table=false)
	{
		$table = $table ? $table : $this->table;
		$id = $this->db->quote($id);
		$sql= "DELETE FROM ".$table." WHERE ".$this->primary_id." = ".$id;
		$stmt = $this->db->prepare($sql);
		$delete = $stmt->execute();
		return $delete;
	}

}

?>