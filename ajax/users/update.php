<?php 
    $model = new Model_pdo_ajax();
    $model->setTable("users");
    
    if ($model->isPost()) {
        $userId = $_POST["userId"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
        $role = $_POST["role"];
        
        $getById = $model->getById($userId);
        $data = array();
        if(isset($_FILES["photo"])) {
            $file_photo = $_FILES["photo"];
            $file_name = explode(".",$file_photo["name"]);
            $file_name = sha1(uniqid()).".".end($file_name);
            $path = "upload/users/".basename($file_name);
            $imageFileType = pathinfo($path,PATHINFO_EXTENSION);
            
            if (!empty($file_photo["tmp_name"])) {
                $allowType = array("jpg","jpeg","png","gif");
                if (!in_array($imageFileType,$allowType)) {
                    $error = "Format gambar tidak di boleh kan...<br>";
                    $error .= "yang di bolehkan adalah jpg,jpeg,png dan gif..";
                    $model->response->error->photo = Helper::spanDanger($error);
                } else {
                    if ($file_photo["size"] > (1000 * 1024)) {
                        $model->response->error->photo =  Helper::spanDanger("Ukuran gambar ke gedean.. maksimal 1 mb ..!");
                    } else {
                        if (file_exists("upload/users/".$getById->photo) && $getById->photo) {
                            unlink("upload/users/".$getById->photo);
                        }
                        $data["photo"] = $file_name;
                        move_uploaded_file($file_photo["tmp_name"],$path);
                    }
                }
            }
        }
        
        if ( empty(trim($firstname)) || empty(trim($lastname)) || empty(trim($role)) ) {
            if ( empty(trim($firstname)) ) {
                $model->response->error->firstname = "<span class='text-danger'><i>Firstname harus di isi.!</i></span>";
            } else {$model->response->error->firstname = ""; } 
            if (empty(trim($lastname))) {
                $model->response->error->lastname = "<span class='text-danger'><i>Lastname harus di isi.!</i></span>";
            } else {$model->response->error->lastname = "";}
            if (empty(trim($role))) {
                $model->response->error->role = "<span class='text-danger'><i>Role harus di isi.!</i></span>";
            } else { $model->response->error->role = ""; }
        } else {
            $data["firstname"] = $firstname;
            $data["lastname"] = $lastname;
            $data["role"] = $role;
                
            if (!empty(trim($password)) || !empty(trim($confirmPassword))) {
                if ($password != $confirmPassword) {
                    $model->response->status = false;
                    $model->response->error->checkConfirm = "<span class='text-danger'><i>Confirm password tidak sama dengan password.!</i></span>";
                } else {
                    if(!isset($model->response->error->photo)){
                        if (isset($_POST["hapusPhoto"])) {
                            if (file_exists("upload/users/".$getById->photo) && $getById->photo) {
                                unlink("upload/users/".$getById->photo);
                            }
                            $data["photo"] = "";
                        }
                        $data["password"] = md5($password);
                        $update = $model->update($userId,$data);
                        if ($update) {
                            $model->response->status = true;
                            $model->response->message = Helper::alertSuccess("Update data user berhasil di prosess.");
                        } else {
                            $model->response->message = Helper::alertDanger("Opps, Gagal update data user.");
                        }
                    }
                }
            } else {
                if(!isset($model->response->error->photo)){
                    if (isset($_POST["hapusPhoto"])) {
                        if (file_exists("upload/users/".$getById->photo) && $getById->photo) {
                            unlink("upload/users/".$getById->photo);
                        }
                        $data["photo"] = "";
                    }
                    $update = $model->update($userId,$data);
                    if ($update) {
                        $model->response->status = true;
                        $model->response->message = Helper::alertSuccess("Update data user berhasil di prosess.");
                    } else {
                        $model->response->message = Helper::alertDanger("Opps, Gagal update data user.");
                    }
                }
            }
        }
        
        $model->json();
    }

?>















