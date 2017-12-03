<?php 

    $model = new Model_pdo_ajax();
    $model->setTable("users");
    
    if ($model->isPost()) {
        $action = explode("/", $_GET["ajax"]); // check url palng akhir
        $getById = $model->getById($action[2]);
        
        if ($getById) {
            $model->response->status = true;
            $model->response->message = "Data users berdasarkan id";
            $model->response->data = $getById;
        } else {
            $model->response->message = Helper::alertDanger("Opps, Data users tidak ada, atau tidak terdaftar..!!<br> Silahkan coba lagi.");
            $model->response->data = $getById;
        }
        
        $model->json();
    }


?>