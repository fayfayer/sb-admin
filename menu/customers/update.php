<!-- Breadcrumbs -->
<ol class="breadcrumb">
  	<li class="breadcrumb-item">
    	<a href="/sb-admin">Home</a>
 	</li>
  	<li class="breadcrumb-item">
    	<a href="<?php echo $backRedirect; ?>">Customers</a>
 	</li>
  	<li class="breadcrumb-item active">Update</li>
</ol>


<div class="card border-light mb-3">
  <div class="card-header text-info">Form <i class="fa fa-edit"></i> Update Data</div>
  <div class="card-body">
  	<div class="col-md-6">
  		<?php 
			$model = new Model_mysqli();
			$model->setTable("customers");
			$action = explode("/", $_GET["menu"]); // check url palng akhir
			$getById = $model->getById($action[2]);

  			if ($getById == null) {
				echo "<span class='text-danger'>Data yang anda pilih tidak ada.!!</span><br><br>";
			}

			if (isset($_POST["btnSimpan"])) {
				$id = $_POST["id"]; // recomended using $_POST["id"];
				$name = $_POST["name"];
				$age = $_POST["age"];
				$address = $_POST["address"];
				$salary = $_POST["salary"];

				if (!empty(trim($name)) && !empty(trim($age)) && !empty(trim($address)) && !empty(trim($salary))) {	
					$data = array(
							"name"	=>	trim($name),
							"age"	=>	$age,
							"address"	=>	$address,
							"salary"	=>	$salary,
						);
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

  		 ?>

	    <form action="" method="post">
		  <div class="form-group">
		    <label>Name</label>
		    <input type="hidden" name="id" value="<?php echo $getById["id"]; ?>">
		    <input type="text" class="form-control" name="name" value="<?php echo $getById["name"]; ?>" placeholder="Name" required>
		  </div>
		  <div class="form-group">
		    <label>Age</label>
		    <input type="number" min="0" max="200" name="age" value="<?php echo $getById["age"]; ?>" class="form-control" placeholder="Age" required>
		  </div>
		  <div class="form-group">
		    <label>Address</label>
		    <textarea  class="form-control" name="address" placeholder="Address" required><?php echo $getById["address"]; ?></textarea>
		  </div>
		  <div class="form-group">
		    <label>Salary</label>
		    <input type="number" min="0" name="salary" value="<?php echo $getById["salary"]; ?>" class="form-control" placeholder="Salary" required>
		  </div>
		  <button type="submit" class="btn btn-primary" name="btnSimpan">Simpan</button>
		</form>
	</div>
  </div>
</div>