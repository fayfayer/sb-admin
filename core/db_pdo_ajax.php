<?php 

require_once 'db_pdo.php';

/**
* 
*/
class Model_pdo_ajax extends Model_pdo
{
	public $response;

	function __construct()
	{
		parent::__construct();

		$this->response = new StdClass();
		$this->response->status = false;
		$this->response->message = "";
		$this->response->data = new StdClass();
		$this->response->error = new StdClass();
	}

	public function findDataTable($select=false,$columnOrderBy=false,$search=false,$where=false,$join=false)
	{
		$orderBy = false;
		if ($columnOrderBy) {
			if (isset($_POST["order"])) {
				$valColumnName = $columnOrderBy[$_POST["order"]["0"]["column"]];
				$valKeyword = $_POST["order"]["0"]["dir"];
				$orderBy = array($valColumnName => $valKeyword);
			}
		}
		$limit = isset($_POST["length"]) ? $_POST["length"] : 10;
		$offset = isset($_POST["start"]) ? $_POST["start"] : 0;
		$data = parent::findData($select,$where,$orderBy,$search,$join,$limit,$offset);
		return $data;
	}

	public function findDataTableOutput($data=null,$where=false,$search=false,$join=false)
	{
		$response = new StdClass();
		$response->status = true;
		$response->draw = isset($_POST["draw"]) ? $_POST["draw"] : null;
		$response->recordsTotal = parent::getCount($where,$search,$join);
		$response->recordsFiltered = parent::getCount($where,$search,$join);
		$response->data = $data;

		self::json($response);
	}

	public function findDataTableObject($select=false,$columnOrderBy=false,$search=false,$where=false,$join=false)
	{
		$result = self::findDataTable($select,$columnOrderBy,$search,$where,$join);
		$data = array();
		$no = isset($_POST["start"]) ? $_POST["start"] : 0;
		foreach ($result as &$item) {
			$no++;
			$item->no = $no;
			$data[] = $item;
		}

		self::findDataTableOutput($data,$where,$search,$join);
	}

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

	public function json($data = null)
	{
		header("Content-Type: application/json; charset=utf-8");
		$data = isset($data) ? $data : $this->response;
		echo json_encode($data);
	}
}


?>