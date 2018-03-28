<?php 
require_once 'config_database.php';

/**
* @package		:	db_pdo query builder
* @subpackage	:	Model
* @author 	    :	Musafi'i (musafii.fai@gmail.com)	
* @copyright	:	2017
* Defaut parent model class
*/
class Db_pdo extends Database
{
	protected $db;
	protected $table;
	protected $primary_id = "id";

	public $response;
	function __construct()
	{
		$this->db = parent::db_pdo();

		$this->response = new StdClass();
		$this->response->status = false;
		$this->response->message = "";
		$this->response->data = new StdClass();
		$this->response->error = new StdClass();
	}

	/**
	* @param $tableName  = "table_name";
	*/
	public function setTable($tableName)
	{
		$this->table = $tableName;
	}

	/**
	* @param $id  = "id" or "id_data" or "kode"; // for all
	*/
	public function setPrimaryId($id) // untuk setting id yang id pakai di getById, update, dan delete.
	{
		$this->primary_id = $id;
	}

	/**
	* @param $select  = "name, age, address" OR array("name","age","address");
	* @param $where   = array("name" => $name,"age" => $age,"address" => $address);
	* @param $orderBy =	"name ASC, age DESC" OR array("name" => "ASC","age" => "DESC");
	* @param $search  = array("name" => $search,"age",$search);
	* @param $join 	  = array(
	*							array("table[2]","table[2].id = table[1].table[2]_id","INNER"),
	*							array("table[3]","table[3].id = table[2].table[3]_id","LEFT"),
	*						);
	* @param $limit   = 10;
	* @param $offset  = 25;
	* @param $whereOR   = jika false maka $where menggunakan AND jika True maka $where menggunakan OR;
	* @param $searchOR   = jika false maka $where menggunakan AND jika True maka $where menggunakan OR;
	* @param $whereIn = array(
	*							"id" => array(1,3,5,6,7),
	*						);
	* @param $whereNotIn = true ? "NOT IN" : "IN";
	* @param $groupBy = "name,age";
	*/
	public function findData($select=false,$where=false,$orderBy=false,$search=false,$join=false,$limit=false,$offset=false,$whereOR=false,$searchOR=false,$whereIn=false,$whereNotIn=false,$groupBy=false)
	{
		if ($select) {
			$select = is_array($select) ? implode(", ", $select) : $select;
		} else {
			$select = "*";
		}
		$sql = "SELECT ".$select." FROM ".$this->table." ";

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
		
		if ($where) {
			if ($whereOR) {
				$sql .= " WHERE ";
				$field = null;
				foreach ($where as $key => $value) {
					$key = explode(" ", $key);
					$key = count($key) > 1 ?  $key[0]." ".($key[1] == "" ? "= " : $key[1]) : $key[0]." = ";
					$value = $this->db->quote($value);
					$field .= " OR ".$key." ".$value." ";
				}
				$sql .= substr($field,3);
			} else {
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
		}

		/*untuk where in*/
		if ($whereIn) {
			if(is_array($whereIn)) {
				$field = null;
				$key = array_keys($whereIn);
				$val = array_values($whereIn);
				if (is_array($val[0])) {
					foreach ($val[0] as $val) {
						$field .= ", ".self::quote($val);
					} 
					$field = substr($field, 1);
				} else {
					$field = $val[0];
				}

				$whereNotIn = $whereNotIn == true ? " NOT" : "";
				if ($where) {
					$sql .= " AND ".$key[0].$whereNotIn." IN (".$field." ) "; //$where;
				} else  {
					$sql .= " WHERE ".$key[0].$whereNotIn." IN (".$field." ) "; //$where;
				}
			}
		}

		if ($search) {
			if ($searchOR) {
				$field = null;
				if (($where && $whereIn) || ($where && !$whereIn) || (!$where && $whereIn)) {

					$sql .= " AND ( ";

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
			} else {
				$field = null;
				if (($where && $whereIn) || ($where && !$whereIn) || (!$where && $whereIn)) {
					foreach ($search as $key => $value) {
						$value = $this->db->quote("%".$value."%");
						$field .= "AND ".$key." LIKE ".$value." ";
					}
					$sql .= substr($field, 4);
				} else {
					$sql .= " WHERE ";
					foreach ($search as $key => $value) {
						$value = $this->db->quote("%".$value."%");
						$field .= "AND ".$key." LIKE ".$value." ";
					}
					$sql .= substr($field, 4);
				}
			}
		}

		$groupBy == true ? $sql.= " GROUP BY ".$groupBy." " : "";

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
		
		/*$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt->fetchALL(PDO::FETCH_OBJ);*/

		return self::fetchAllObj($sql);
	}

	/**
	* @param $page    = index.php?page=1;
	* @param $limit   = 10;
	* @param $select  = "name, age, address" OR array("name","age","address");
	* @param $where   = array("name" => $name,"age" => $age,"address" => $address);
	* @param $orderBy =	"name ASC, age DESC" OR array("name" => "ASC","age" => "DESC");
	* @param $search  = array("name" => $search,"age",$search);
	* @param $join 	  = array(
	*							array("table[2]","table[2].id = table[1].table[2]_id","INNER"),
	*							array("table[3]","table[3].id = table[2].table[3]_id","LEFT"),
	*						);	*/
	public function findDataPaging($page,$limit=10,$select=false,$where=false,$orderBy=false,$search=false,$join=false)
	{
		$offset = ($page - 1) * $limit;
		$result = self::findData($select,$where,$orderBy,$search,$join,$limit,$offset,false,true);
		return $result;
	}

	/**
	* @param $where   = array("name" => $name,"age" => $age,"address" => $address);
	* @param $search  = array("name" => $search,"age",$search);
	* @param $join 	  = array(
	*							array("table[2]","table[2].id = table[1].table[2]_id","INNER"),
	*							array("table[3]","table[3].id = table[2].table[3]_id","LEFT"),
	*						);
	* @param $whereOR   = jika false maka $where menggunakan AND jika True maka $where menggunakan OR;
	* @param $searchOR   = jika false maka $where menggunakan AND jika True maka $where menggunakan OR;
	* @param $whereIn = array(
	*							"id" => array(1,3,5,6,7),
	*						);
	* @param $whereNotIn = true ? "NOT IN" : "IN";
	* @param $groupBy = "age, address";
	*/
	public function getCount($where=false,$search=false,$join=false,$whereOR=false,$searchOR=false,$whereIn=false,$whereNotIn=false,$groupBy=false)
	{
		$sql = "SELECT * FROM ".$this->table." ";
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
		if ($where) {
			if ($whereOR) {
				$sql .= " WHERE ";
				$field = null;
				foreach ($where as $key => $value) {
					$key = explode(" ", $key);
					$key = count($key) > 1 ?  $key[0]." ".($key[1] == "" ? "= " : $key[1]) : $key[0]." = ";
					$value = $this->db->quote($value);
					$field .= " OR ".$key." ".$value." ";
				}
				$sql .= substr($field,3);
			} else {
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
		}

		/*untuk where in*/
		if ($whereIn) {
			if(is_array($whereIn)) {
				$field = null;
				$key = array_keys($whereIn);
				$val = array_values($whereIn);
				if (is_array($val[0])) {
					foreach ($val[0] as $val) {
						$field .= ", ".self::quote($val);
					} 
					$field = substr($field, 1);
				} else {
					$field = $val[0];
				}

				$whereNotIn = $whereNotIn == true ? " NOT" : "";
				if ($where) {
					$sql .= " AND ".$key[0].$whereNotIn." IN (".$field." ) "; //$where;
				} else  {
					$sql .= " WHERE ".$key[0].$whereNotIn." IN (".$field." ) "; //$where;
				}
			}
		}

		if ($search) {
			$field = null;
			if ($searchOR) {
				if (($where && $whereIn) || ($where && !$whereIn) || (!$where && $whereIn)) {
					$sql .= " AND ( ";
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
			} else {
				if (($where && $whereIn) || ($where && !$whereIn) || (!$where && $whereIn)) {
					foreach ($search as $key => $value) {
						$value = $this->db->quote("%".$value."%");
						$field .= "AND ".$key." LIKE ".$value." ";
					}
					$sql .= substr($field, 4);
				} else {
					$sql .= " WHERE ";
					foreach ($search as $key => $value) {
						$value = $this->db->quote("%".$value."%");
						$field .= "AND ".$key." LIKE ".$value." ";
					}
					$sql .= substr($field, 4);
				}
			}
		}
		
		$groupBy == true ? $sql.= " GROUP BY ".$groupBy : "";
		
		/*return $sql;
		exit();*/

		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt->rowCount();
	}

	/**
	* @param $limit   = 10;
	* @param $where   = array("name" => $name,"age" => $age,"address" => $address);
	* @param $search  = array("name" => $search,"age",$search);
	* @param $join 	  = array(
	*							array("table[2]","table[2].id = table[1].table[2]_id","INNER"),
	*							array("table[3]","table[3].id = table[2].table[3]_id","LEFT"),
	*						);
	*/
	public function getCountPaging($limit=10,$where=false,$search=false,$join=false)
	{
		$result = self::getCount($where,$search,$join,false,true);
		$result = ceil($result / $limit);
		return $result;
	}

	/**
	* @param $select  = "name, age, address" OR array("name","age","address");
	* @param $where   = array("name" => $name,"age" => $age,"address" => $address);
	* @param $orderBy =	"name ASC, age DESC" OR array("name" => "ASC","age" => "DESC");
	* @param $join 	  = array(
	*							array("table[2]","table[2].id = table[1].table[2]_id","INNER"),
	*							array("table[3]","table[3].id = table[2].table[3]_id","LEFT"),
	*						);
	* @param $whereIn = array(
	*							"id" => array(1,3,5,6,7),
	*						);
	* @param $groupBy = "age";
	*/
	public function getAll($select=false,$where=false,$orderBy=false,$join=false,$limit=false,$whereIn=false,$whereNotIn=false,$groupBy=false)
	{
		if ($select) {
			$select = is_array($select) ? implode(", ", $select) : $select;
		} else {
			$select = "*";
		}
		$sql = "SELECT ".$select." FROM ".$this->table." ";

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
		
		/*untuk where in*/
		if ($whereIn) {
			if(is_array($whereIn)) {
				$field = null;
				$key = array_keys($whereIn);
				$val = array_values($whereIn);
				if (is_array($val[0])) {
					foreach ($val[0] as $val) {
						$field .= ", ".self::quote($val);
					} 
					$field = substr($field, 1);
				} else {
					$field = $val[0];
				}

				$whereNotIn = $whereNotIn == true ? " NOT" : "";
				if ($where) {
					$sql .= " AND ".$key[0].$whereNotIn." IN (".$field." ) "; //$where;
				} else  {
					$sql .= " WHERE ".$key[0].$whereNotIn." IN (".$field." ) "; //$where;
				}
			}
		}
		
		$groupBy == true ? $sql.= " GROUP BY ".$groupBy : "";
		
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
			$sql .= " LIMIT ".$limit." ";
		}
		
		/*return $sql;
		exit();*/

		return self::fetchAllObj($sql);
	}

	/**
	* @param $id  = 1 or 2 or 3;
	*/
	public function getById($id)
	{
		$id = $this->db->quote($id);
		$sql = "SELECT * FROM ".$this->table." WHERE ".$this->primary_id." = ".$id;
		return self::fetchObj($sql);
	}

	/**
	* @param $where   = array("name" => $name,"age" => $age,"address" => $address);
	* @param $or_where  = array("name" => $search,"age",$search);
	* @param $join 	  = array(
	*							array("table[2]","table[2].id = table[1].table[2]_id","INNER"),
	*							array("table[3]","table[3].id = table[2].table[3]_id","LEFT"),
	*						);
	*/
	public function getByWhere($where,$or_where=false,$join=false)
	{
		$sql = "SELECT * FROM ".$this->table." ";

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
		$sql .= " WHERE ";
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
		// return $sql;
		return self::fetchObj($sql);
	}

	/**
	* @param $or_where  = array("name" => $search,"age",$search);
	* @param $select  = "name, age, address" OR array("name","age","address");
	* @param $join 	  = array(
	*							array("table[2]","table[2].id = table[1].table[2]_id","INNER"),
	*							array("table[3]","table[3].id = table[2].table[3]_id","LEFT"),
	*						);
	*/
	public function getByOrWhere($or_where,$select=false,$join=false)
	{
		if ($select) {
			$select = is_array($select) ? implode(", ", $select) : $select;
		} else {
			$select = "*";
		}
		// $sql = "SELECT * FROM ".$this->table." ";
		$sql = "SELECT ".$select." FROM ".$this->table." ";

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

		$sql .= " WHERE ";
		$field = null;
		foreach ($where as $key => $value) {
			$key = explode(" ", $key);
			$key = count($key) > 1 ?  $key[0]." ".($key[1] == "" ? "= " : $key[1]) : $key[0]." = ";
			$value = $this->db->quote($value);
			$field .= " OR ".$key." ".$value." ";
		}
		$sql .= substr($field,3);

		// return $sql;
		return self::fetchObj($sql);
	}

	/**
	* @param $where   = array("name" => $name,"age" => $age,"address" => $address);
	* @param $select  = "name, age, address" OR array("name","age","address");
	* @param $or_where  = array("name" => $search,"age",$search);
	* @param $join 	  = array(
	*							array("table[2]","table[2].id = table[1].table[2]_id","INNER"),
	*							array("table[3]","table[3].id = table[2].table[3]_id","LEFT"),
	*						);
	*/
	public function getByWhereSelect($where,$select=false,$or_where=false,$join=false)
	{
		if ($select) {
			$select = is_array($select) ? implode(", ", $select) : $select;
		} else {
			$select = "*";
		}
		// $sql = "SELECT * FROM ".$this->table." ";
		$sql = "SELECT ".$select." FROM ".$this->table." ";

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
		$sql .= " WHERE ";
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
		// return $sql;
		return self::fetchObj($sql);
	}

	/**
	* @param $data 	  = array(
	*							"name" => $name,
	*							"address" => $address,
	*							"age"	=>	$age,
	*						);
	* @param $table   = jika false ? $this->table : "table_name";
	*/
	public function insert($data,$table=false)
	{
		$table = $table ? $table : $this->table;
		$sql = "INSERT INTO ".$table." ";
		$fields = null;
		$values = null;
		foreach ($data as $key => $val) {

			// var_dump($val);

			$fields .= ", ".$key;
			if (($val == "NULL" || $val == "null") || ($val == NULL || $val == null)) {
				if (is_int($val) && $val == 0) {
					$val = 0;
				} else {
					$val = "NULL";
				}
			} else {
				$val = $this->db->quote($val);
			}
			$values .= ", ".$val." ";
		}
		$sql .= "(".substr($fields, 2).") ";
		$sql .= "VALUES (".substr($values, 2).")";

		/*return $sql;
		exit();*/

		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $this->db->lastInsertId();
	}

	/**
	* @param $sql = "Insert Into table(id,name,age) values(1,'jojon',54)";
	*/
	public function insertQuery($sql)
	{
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $this->db->lastInsertId();
	}

	/**
	* @param $id = 1 or 2 or 3
	* @param $data 	  = array(
	*							"name" => $name,
	*							"address" => $address,
	*							"age"	=>	$age,
	*						);
	* @param $table   = jika false ? $this->table : "table_name";
	*/
	public function update($id,$data,$table=false)
	{
		$table = $table ? $table : $this->table;
		$sql = "UPDATE ".$table." SET ";
		$set = null;
		foreach ($data as $key => $value) {

			if (($value == "NULL" || $value == "null") || ($value == NULL || $value == null)) {
				if (is_int($value) && $value == 0) {
					$value = 0;
				} else {
					$value = "NULL";
				}
			} else {
				$value = $this->db->quote($value);
			}

			$set .= ", ".$key." = ".$value." ";
		}
		$id = $this->db->quote($id);
		$sql .= substr($set, 2)." WHERE ".$this->primary_id." = ".$id; //$id, recomended using $_POST["id"];
		$stmt = $this->db->prepare($sql);
		return $stmt->execute();
	}

	/**
	* @param $sql = "Update table set name = 'jojon',age = 54 Where id = 1;
	*/
	public function updateQuery($sql)
	{
		/*var_dump($sql);
		exit();*/

		$stmt = $this->db->prepare($sql);
		return $stmt->execute();
	}

	/**
	* @param $where   = array("code" => $code,"date" => $date);
	* @param $data 	  = array(
	*							"name" => $name,
	*							"address" => $address,
	*							"age"	=>	$age,
	*						);
	* @param $table   = jika false ? $this->table : "table_name";
	*/
	public function updateWhere($where,$data,$table=false)
	{
		$table = $table ? $table : $this->table;
		$sql = "UPDATE ".$table." SET ";
		$field = null;
		foreach ($where as $key => $value) {
			$key = explode(" ", $key);
			$key = count($key) > 1 ?  $key[0]." ".($key[1] == "" ? "= " : $key[1]) : $key[0]." = ";
			$value = $this->db->quote($value);
			$field .= " AND ".$key." ".$value." ";
		}

		$set = null;
		foreach ($data as $key => $value) {

			if (($value == "NULL" || $value == "null") || ($value == NULL || $value == null)) {
				if (is_int($value) && $value == 0) {
					$value = 0;
				} else {
					$value = "NULL";
				}
			} else {
				$value = $this->db->quote($value);
			}
			$set .= ", ".$key." = ".$value." ";
		}
		$sql .= substr($set, 2)." WHERE ".substr($field,4); //$where;
		$stmt = $this->db->prepare($sql);
		return $stmt->execute();
	}

	/**
	* @param $whereIn = array(
	*							"id" => array(1,3,5,6,7),
	*						);
	* @param $data 	  = array(
	*							"name" => $name,
	*							"address" => $address,
	*							"age"	=>	$age,
	*						);
	* @param $where   = array("code" => $code,"date" => $date);
	* @param $table   = jika false ? $this->table : "table_name";
	*/
	public function updateWhereIn($whereIn,$data,$where=false,$table=false)
	{
		$table = $table ? $table : $this->table;
		$sql = "UPDATE ".$table." SET ";

		$set = null;
		foreach ($data as $key => $value) {

			if (($value == "NULL" || $value == "null") || ($value == NULL || $value == null)) {
				if (is_int($value) && $value == 0) {
					$value = 0;
				} else {
					$value = "NULL";
				}
			} else {
				$value = $this->db->quote($value);
			}
			$set .= ", ".$key." = ".$value." ";
		}

		if ($where) {
			$fieldWhere = null;
			foreach ($where as $key => $value) {
				$key = explode(" ", $key);
				$key = count($key) > 1 ?  $key[0]." ".($key[1] == "" ? "= " : $key[1]) : $key[0]." = ";
				$value = $this->db->quote($value);
				$fieldWhere .= " AND ".$key." ".$value." ";
			}
			$where = substr($fieldWhere,4)." AND ";
		} else {
			$where = "";
		}

		/*untuk where in*/
		$field = null;
		$key = array_keys($whereIn);
		$value = array_values($whereIn);
		if (is_array($value[0])) {
			foreach ($value[0] as $val) {
				$field .= ", ".self::quote($val);
			} 
			$field = substr($field, 1);
		} else {
			$field = $value[0];
		}

		$sql .= substr($set, 2)." WHERE ".$where.$key[0]." IN (".$field." )"; //$where;
		/*return $sql;
		exit();*/

		$stmt = $this->db->prepare($sql);
		return $stmt->execute();
	}

	/**
	* @param $id = 1 or 2 or 3
	* @param $table   = jika false ? $this->table : "table_name";
	*/
	public function delete($id,$table=false)
	{
		$table = $table ? $table : $this->table;
		$id = $this->db->quote($id);
		$sql= "DELETE FROM ".$table." WHERE ".$this->primary_id." = ".$id;
		$stmt = $this->db->prepare($sql);
		$delete = $stmt->execute();
		return $delete;
	}


	/**
	* @param $where = array("name" => $name,"age" => $age);
	* @param $table   = jika false ? $this->table : "table_name";
	*/
	public function deleteWhere($where,$table=false)
	{
		$table = $table ? $table : $this->table;

		$field = null;
		foreach ($where as $key => $value) {
			$key = explode(" ", $key);
			$key = count($key) > 1 ?  $key[0]." ".($key[1] == "" ? "= " : $key[1]) : $key[0]." = ";
			$value = $this->db->quote($value);
			$field .= " AND ".$key." ".$value." ";
		}

		$sql= "DELETE FROM ".$table." WHERE ".substr($field,4); //$where;;
		$stmt = $this->db->prepare($sql);
		$delete = $stmt->execute();
		return $delete;
	}

	/**
	* @param $whereIn = array(
	*							"id" => array(1,3,5,6,7),
	*						);
	* @param $where = array("name" => $name,"age" => $age);
	* @param $table   = jika false ? $this->table : "table_name";
	*/
	public function deleteWhereIn($whereIn,$where=false,$table=false)
	{
		$table = $table ? $table : $this->table;

		$field = null;
		$id = array_keys($whereIn);
		$value = array_values($whereIn);

		if (is_array($value[0])) {
			foreach ($value[0] as $val) {
				$field .= ", ".self::quote($val);
			} 
			$field = substr($field, 1);
		} else {
			$field = $value[0];
		}

		if ($where) {
			$fieldWhere = null;
			foreach ($where as $key => $value) {
				$key = explode(" ", $key);
				$key = count($key) > 1 ?  $key[0]." ".($key[1] == "" ? "= " : $key[1]) : $key[0]." = ";
				$value = $this->db->quote($value);
				$fieldWhere .= " AND ".$key."".$value;
			}
			$where = substr($fieldWhere, 4)." AND ";
		} else {
			$where = "";
		}
		
		$sql= "DELETE FROM ".$table." WHERE ".$where.$id[0]." IN (".$field." )"; //$where;
		/*return $sql;
		exit();*/
		$stmt = $this->db->prepare($sql);
		$delete = $stmt->execute();
		return $delete;
	}

	/**
	*	field value sql yang mau di injection
	* @param $sql = id or name or age
	*/
	public function quote($sql) // sql injection
	{
		return $this->db->quote($sql);
	}

	/**
	* @param $sql   = "SELECT * FROM table_name";
	* untuk hasil satu row Object = $query->field_name
	*/
	public function fetchObj($sql)	// for function getById and getByWhere
	{
		$stmt = $this->db->prepare($sql);
		if ($stmt->execute()) {
			return $stmt->fetch(PDO::FETCH_OBJ);
		} else {
			return false;
		}
	}

	/**
	* @param $sql   = "SELECT * FROM table_name";
	* untuk hasil jumlah banyak Object = array(
												$query->field_name1,
												$query->fiele_name2,
												$query->fiele_name3,
												$query->fiele_name4,
											);
	*/
	public function fetchAllObj($sql) 
	{
		$stmt = $this->db->prepare($sql);
		if ($stmt->execute()) {
			return $stmt->fetchALL(PDO::FETCH_OBJ);
		} else {
			return false;
		}
	}

	/**
	* @param $sql   = "SELECT * FROM table_name";
	* untuk hasil satu row Associative = $query['field_name']
	*/
	public function fetchAssoc($sql)	// for function getById and getByWhere
	{
		$stmt = $this->db->prepare($sql);
		if ($stmt->execute()) {
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	/**
	* @param $sql   = "SELECT * FROM table_name";
	* untuk hasil jumlah banyak Associative = array(
												$query['field_name1'],
												$query['fiele_name2'],
												$query['fiele_name3'],
												$query['fiele_name4'],
											);
	*/
	public function fetchAllAssoc($sql)
	{
		$stmt = $this->db->prepare($sql);
		if ($stmt->execute()) {
			return $stmt->fetchALL(PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}


	/* for ajax function datatables */
	/**
	* @param $where   = array("name" => $name,"age" => $age,"address" => $address);
	* @param $select  = "name, age, address" OR array("name","age","address");
	* @param $columnOrderBy = array("name","age");
	* @param $search  = array("name","age");
	* @param $join 	  = array(
	*							array("table[2]","table[2].id = table[1].table[2]_id","INNER"),
	*							array("table[3]","table[3].id = table[2].table[3]_id","LEFT"),
	*						);
	* @param $whereOR   = jika false maka $where menggunakan AND jika True maka $where menggunakan OR;
	* @param $whereIn = array(
	*							"id" => array(1,3,5,6,7),
	*						);
	* @param $whereNotIn = true ? "NOT IN" : "IN";
	*/
	public function findDataTable($where=false,$select=false,$columnOrderBy=false,$search=false,$join=false,$whereOR=false,$whereIn=false,$whereNotIn=false,$groupBy=false)
	{
		$orderBy = false;
		if ($columnOrderBy) {
			if (isset($_POST["order"])) {
				$valColumnName = $columnOrderBy[$_POST["order"]["0"]["column"]];
				$valKeyword = $_POST["order"]["0"]["dir"];
				$orderBy = array($valColumnName => $valKeyword);
			}
		}
		if ($search) {
			$input_search = isset($_POST["search"]) ? $_POST["search"]["value"] : "";
			$dataSearch = array();
			foreach ($search as $val) {
				$dataSearch[$val] = $input_search;
			}
			$search = $dataSearch;
		}
		$limit = isset($_POST["length"]) ? $_POST["length"] : 10;
		$offset = isset($_POST["start"]) ? $_POST["start"] : 0;
		$data = self::findData($select,$where,$orderBy,$search,$join,$limit,$offset,$whereOR,true,$whereIn,$whereNotIn,$groupBy);
		$no = isset($_POST["start"]) ? $_POST["start"] : 0;
		foreach ($data as &$item) {
			$no++;
			$item->no = $no;
		}
		return $data;
	}

	/**
	* @param $data = input dari hasil keluaran array findDataTable
	* @param $where   = array("name" => $name,"age" => $age,"address" => $address);
	* @param $search  = array("name","age");
	* @param $join 	  = array(
	*							array("table[2]","table[2].id = table[1].table[2]_id","INNER"),
	*							array("table[3]","table[3].id = table[2].table[3]_id","LEFT"),
	*						);
	* @param $whereOR   = jika false maka $where menggunakan AND jika True maka $where menggunakan OR;
	* @param $whereIn = array(
	*							"id" => array(1,3,5,6,7),
	*						);
	* @param $whereNotIn = true ? "NOT IN" : "IN";
	*/
	public function findDataTableOutput($data=null,$where=false,$search=false,$join=false,$whereOR=false,$whereIn=false,$whereNotIn=false,$groupBy=false)
	{
		$response = new StdClass();
		$response->status = true;
		$response->draw = isset($_POST["draw"]) ? $_POST["draw"] : null;
		if ($search) {
			$input_search = isset($_POST["search"]) ? $_POST["search"]["value"] : "";
			$dataSearch = array();
			foreach ($search as $val) {
				$dataSearch[$val] = $input_search;
			}
			$search = $dataSearch;
		}
		$response->recordsTotal = self::getCount($where,$search,$join,$whereOR,true,$whereIn,$whereNotIn,$groupBy);
		// $response->recordsTotal = self::getCount($where,false,$join);
		$response->recordsFiltered = self::getCount($where,$search,$join,$whereOR,true,$whereIn,$whereNotIn,$groupBy);
		$response->data = $data;
		self::json($response);
	}

	/**
	* @param $where   = array("name" => $name,"age" => $age,"address" => $address);
	* @param $select  = "name, age, address" OR array("name","age","address");
	* @param $columnOrderBy = array("name","age");
	* @param $search  = array("name","age");
	* @param $join 	  = array(
	*							array("table[2]","table[2].id = table[1].table[2]_id","INNER"),
	*							array("table[3]","table[3].id = table[2].table[3]_id","LEFT"),
	*						);
	* @param $whereOR   = jika false maka $where menggunakan AND jika True maka $where menggunakan OR;
	* @param $whereIn = array(
	*							"id" => array(1,3,5,6,7),
	*						);
	* @param $whereNotIn = true ? "NOT IN" : "IN";
	*/
	public function findDataTableObject($where=false,$select=false,$columnOrderBy=false,$search=false,$join=false,$whereOR=false,$whereIn=false,$whereNotIn=false,$groupBy=false)
	{
		$result = self::findDataTable($where,$select,$columnOrderBy,$search,$join,$whereOR,$whereIn,$whereNotIn,$groupBy);
		/*var_dump($result);
		exit();*/

		$data = array();
		$no = isset($_POST["start"]) ? $_POST["start"] : 0;
		foreach ($result as &$item) {
			$no++;
			$item->no = $no;
			$data[] = $item;
		}
		self::findDataTableOutput($data,$where,$search,$join,$whereOR,$whereIn,$whereNotIn,$groupBy);
	}

	/**
	*	untuk check method post
	*/
	public function isPost()
	{
		$method = $_SERVER["REQUEST_METHOD"];
		if (strtoupper($method) == "POST") {
			return true;
		} else {
			// echo "REQUEST_METHOD Not Allow";
			$this->response->message = "Not allow get request";
			self::json();
			return false;
		}
	}

	/**
	*	untuk output json
	* @param $data = untuk data yang akan ditampilkan format json
	*/
	public function json($data = null)
	{
		header("Content-Type: application/jsonp; charset=utf-8");
		header('Access-Control-Allow-Origin: *');
		$data = isset($data) ? $data : $this->response;
		echo json_encode($data,JSON_UNESCAPED_SLASHES);
	}
}
?>
