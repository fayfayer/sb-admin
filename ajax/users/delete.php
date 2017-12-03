<?php 

    $model = new Model_pdo_ajax();
    $model->setTable("users");
        
    if ($model->isPost()) {
        $getAjax = $_GET["ajax"];
        $getAjax = explode("/", $getAjax);
        $id = $getAjax[2];
        $getById = $model->getById($id);
        $delete = $model->delete($id);
        if ($delete) {
            if (file_exists("upload/users/".$getById->photo) && $getById->photo) {
                unlink("upload/users/".$getById->photo);
            }
            $model->response->status = true;
            $model->response->message = Helper::alertSuccess("Berhasil hapus data");
        } else {
            $model->response->message = Helper::alertSuccess("Opps, Gagal hapus data");
        }
        
        $model->json();
    }

?>