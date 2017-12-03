<?php 
    $model = new Model_pdo_ajax();
    $model->setTable("users");
        
    if ($model->isPost()) {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
        $role = $_POST["role"];
        
        $data = array(
            "firstname" =>  $firstname,
            "lastname"  =>  $lastname,
            "username"  =>  $username,
            "email"     =>  $email,
            "password"  =>  md5($password),
            "role"      =>  $role,
        );
        
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
                        $data["photo"] = $file_name;
                        move_uploaded_file($file_photo["tmp_name"],$path);
                    }
                }
            }
        }

        if ( empty(trim($firstname)) || empty(trim($lastname)) || empty(trim($username)) || empty(trim($email)) || empty(trim($password)) || empty(trim($confirmPassword)) || empty(trim($role)) ) {
            if ( empty(trim($firstname)) ) {
                $model->response->error->firstname = "<span class='text-danger'><i>Firstname harus di isi.!</i></span>";
            } else {$model->response->error->firstname = ""; } 
            
            if (empty(trim($lastname))) {
                $model->response->error->lastname = "<span class='text-danger'><i>Lastname harus di isi.!</i></span>";
            } else {$model->response->error->lastname = "";}
            
            if (empty(trim($username))) {
                $model->response->error->username = "<span class='text-danger'><i>Username harus di isi.!</i></span>";
            } else { $model->response->error->username = ""; }
            
            if (empty(trim($email))) {
                $model->response->error->email = "<span class='text-danger'><i>Email harus di isi.!</i></span>";
            } else { $model->response->error->email = ""; }
            
            if (empty(trim($password))) {
                $model->response->error->password = "<span class='text-danger'><i>Password harus di isi.!</i></span>";
            } else { $model->response->error->password = ""; }
                
            if (empty(trim($confirmPassword))) {
                $model->response->error->confirmPassword = "<span class='text-danger'><i>Confirm Password harus di isi.!</i></span>";
            } else { $model->response->error->confirmPassword = ""; }
                
            if (empty(trim($role))) {
                $model->response->error->role = "<span class='text-danger'><i>Role harus di isi.!</i></span>";
            } else { $model->response->error->role = ""; }
        } else {
            $checkUsername = $model->getByWhere(array("username" => $username));
            if ($checkUsername) {
                $model->response->error->checkUsername = "<span class='text-danger'><i>Username sudah terdaftar..</i></span>";
            } else {
                $checkEmail = $model->getByWhere(array("email" => $email));
                if ($checkEmail) {
                    $model->response->error->checkEmail = "<span class='text-danger'><i>Email sudah terdaftar..</i></span>";
                } else {
                    if ($password != $confirmPassword) {
                        $model->response->error->checkConfirm = "<span class='text-danger'><i>Confirm password tidak sama dengan password.!</i></span>";
                    } else {
                        if(!isset($model->response->error->photo)){
                            $update = $model->insert($data);
                            if ($update) {
                                $model->response->status = true;
                                $model->response->message = Helper::alertSuccess("Tambah data atau register user berhasil di prosess.");
                            } else {
                                $model->response->message = Helper::alertDanger("Opps, Gagal Tambah data atau register user.");
                            }
                        }
                    }
                }
            }
        }
        $model->json();
    }

?>