<!-- Breadcrumbs -->
<ol class="breadcrumb">
  	<li class="breadcrumb-item">
    	<a href="/sb-admin">Home</a>
 	</li>
  	<li class="breadcrumb-item">
    	<a href="?menu=employees">Employees</a>
 	</li>
  	<li class="breadcrumb-item active">Add</li>
</ol>

<div class="card border-light mb-3">
  <div class="card-header text-info"> Form <i class="fa fa-plus"></i> Tambah Data</div>
  <div class="card-body">
  	<div class="col-md-6">
  		<?php 
			$model = new Model_pdo();
			$model->setTable("employees");

  		    if (isset($_POST["btnSimpan"])) {
				$name = $_POST["name"];
				$age = $_POST["age"];
				$address = $_POST["address"];
				$salary = $_POST["salary"];

                $file_photo = $_FILES["photo"];
				$data = array(
						"name"	=>	trim($name),
						"age"	=>	$age,
						"address"	=>	$address,
						"salary"	=>	$salary,
					);

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
                            $data["photo"] = $file_name;
                            move_uploaded_file($file_photo["tmp_name"],$path);
                        }
                    }
                }

                if(!isset($error)) {
                    if (!empty(trim($name)) && !empty(trim($age)) && !empty(trim($address)) && !empty(trim($salary))) {				
                        $tambah = $model->insert($data);
                        if($tambah){
                            echo $tambah."<br>";
                            echo "<script> alert('Data berhasil di simpan'); </script>";
                            echo "<script> document.location.href = '?menu=employees' </script>";
                        }
                    } else {
                        echo "<span class='text-danger'>Name, age, address, atau salary tidak boleh kosong..!</span>";
                        echo "<br>";
                    }
                }
			}

  		 ?>
	    <form action="" method="post" enctype="multipart/form-data">
		  <div class="form-group">
		    <label>Photo</label>
            <input type="file" class="form-control" name="photo">
            <div><?php echo isset($error) ? $error : ""; ?></div>
		  </div>
		  <div class="form-group">
		    <label>Name</label>
		    <input type="text" class="form-control" name="name" value="<?php echo isset($name) ? $name : ''; ?>" placeholder="Name" required>
		  </div>
		  <div class="form-group">
		    <label>Age</label>
		    <input type="number" min="0" max="200" name="age" value="<?php echo isset($age) ? $age : ''; ?>" class="form-control" placeholder="Age" required>
		  </div>
		  <div class="form-group">
		    <label>Address</label>
		    <textarea  class="form-control" name="address" placeholder="Address" required><?php echo isset($address) ? $address : ''; ?></textarea>
		  </div>
		  <div class="form-group">
		    <label>Salary</label>
		    <input type="number" min="0" name="salary" value="<?php echo isset($salary) ? $salary : ''; ?>" class="form-control" placeholder="Salary" required>
		  </div>
		  <button type="submit" class="btn btn-primary" name="btnSimpan">Simpan</button>
		</form>
	</div>
  </div>
</div>