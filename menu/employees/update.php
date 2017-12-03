<!-- Breadcrumbs -->
<ol class="breadcrumb">
  	<li class="breadcrumb-item">
    	<a href="/sb-admin">Home</a>
 	</li>
  	<li class="breadcrumb-item">
    	<a href="<?php echo $backRedirect; ?>">Employees</a>
 	</li>
  	<li class="breadcrumb-item active">Update</li>
</ol>

<?php 

	$model = new Model_pdo();
	$model->setTable("employees");

	$action = explode("/", $_GET["menu"]); // check url palng akhir
	$getById = $model->getById($action[2]);
	
 ?>

<div class="card border-light mb-3">
  <div class="card-header text-info">Form <i class="fa fa-edit"></i> Update Data</div>
  <div class="card-body">
  	<div class="col-md-6">
  		<?php 
  			if ($getById == null) {
				echo "<span class='text-danger'>Data yang anda pilih tidak ada.!!</span><br><br>";
			}

			if (isset($_POST["btnSimpan"])) {
				$id = $_POST["id"]; // recomended using $_POST["id"];
				$name = $_POST["name"];
				$age = $_POST["age"];
				$address = $_POST["address"];
				$salary = $_POST["salary"];
                
                $data = array(
                        "name"	=>	trim($name),
                        "age"	=>	$age,
                        "address"	=>	$address,
                        "salary"	=>	$salary,
                    );

                $file_photo = $_FILES["photo"];
                $file_name = explode(".",$file_photo["name"]);
                $file_name = sha1(uniqid()).".".end($file_name);
                $path = "upload/employees/".basename($file_name);
                $imageFileType = pathinfo($path,PATHINFO_EXTENSION);
                
                if ($file_photo["tmp_name"] !== "") {
                    $allowType = array("jpg","jpeg","png","gif");
                    if (!in_array($imageFileType,$allowType)) {
                        $error = Helper::spanDanger("Format gambar tidak di boleh kan...")."<br>";
                        $error .= Helper::spanDanger("yang di bolehkan adalah jpg,jpeg,png dan gif..");
                    } else {
                        if ($file_photo["size"] > (1000 * 1024)) {
                            $error = Helper::spanDanger("Ukuran gambar ke gedean..");
                        } else {
                            if (file_exists("upload/employees/".$getById->photo) && $getById->photo) {
                                unlink("upload/employees/".$getById->photo);
                            }
                            $data["photo"] = $file_name;
                            move_uploaded_file($file_photo["tmp_name"],$path);
                        }
                    }
                }

                if(!isset($error)) {
                    if (!empty(trim($name)) && !empty(trim($age)) && !empty(trim($address)) && !empty(trim($salary))) {
                        $update = $model->update($id,$data);
                        if($update){
                            echo "<script> alert('Data berhasil di simpan'); </script>";
                            echo "<script> document.location.href = '".$backRedirect."' </script>";
                        }
                    } else {
                        echo "<span class='text-danger'>Name, age, address, atau salary tidak boleh kosong..!</span>";
                        echo "<br>";
                    }	
                }
			}

  		 ?>
	    <form action="" method="post" enctype="multipart/form-data" >
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-8">
                        <label>Ganti Photo</label>
                        <input type="file" class="form-control" name="photo">
                        <div><?php echo isset($error) ? $error : ""; ?></div>
                    </div>
                    <div class="col-md-4">
                        <label>Photo</label><br>
                        <?php $img = $getById->photo == "" ? "img/user_image.png" : "upload/employees/".$getById->photo; ?>
                        <img src="<?php echo $img; ?>" class="img-responsive img-thumbnail" style="width:100px; height:100px;">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="hidden" name="id" value="<?php echo $getById->id; ?>">
                <input type="text" class="form-control" name="name" value="<?php echo $getById->name; ?>" placeholder="Name" required>
            </div>
            <div class="form-group">
                <label>Age</label>
                <input type="number" min="0" max="200" name="age" value="<?php echo $getById->age; ?>" class="form-control" placeholder="Age" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea  class="form-control" name="address" placeholder="Address" required><?php echo $getById->address; ?></textarea>
            </div>
            <div class="form-group">
                <label>Salary</label>
                <input type="number" min="0" name="salary" value="<?php echo $getById->salary; ?>" class="form-control" placeholder="Salary" required>
            </div>
            <button type="submit" class="btn btn-primary" name="btnSimpan">Simpan</button>
		</form>
	</div>
  </div>
</div>