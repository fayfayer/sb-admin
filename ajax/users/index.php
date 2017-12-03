<?php 

	$model = new Model_pdo_ajax();
	$model->setTable("users");

	if ($model->isPost()) {
		// $select = array("firstname","lastname","email",'role');
		$columns = array(null,"firstname","lastname","email",null,'role');
		$input_search = isset($_POST["search"]) ? $_POST["search"]["value"] : "";
		$search = array(
					"firstname"	=>	$input_search,
					"lastname"	=>	$input_search,
					"email"		=>	$input_search,
					"role"		=>	$input_search,
				);
		$model->findDataTableObject(false,$columns,$search);
	}

	/*$data = $model->findDataTable();
	$model->json($data);*/

 ?>