<!-- Breadcrumbs -->
<ol class="breadcrumb">
  	<li class="breadcrumb-item">
    	<a href="/sb-admin">Home</a>
 	</li>
  	<li class="breadcrumb-item">
    	<a href="?menu=customers">Customers</a>
 	</li>
  	<li class="breadcrumb-item active">Add</li>
</ol>

<div class="card border-light mb-3">
  <div class="card-header text-info"> Form <i class="fa fa-plus"></i> Tambah Data</div>
  <div class="card-body">
  	<div class="col-md-6">
  	<?php 
		$model = new Model_mysqli();
		$model->setTable("customers");

		if (isset($_POST["btnSimpan"])) {
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
				$tambah = $model->insert($data);
				if($tambah){
					echo $tambah."<br>";
					echo "<script> alert('Data berhasil di simpan'); </script>";
					echo "<script> document.location.href = '?menu=customers' </script>";
				}
			} else {
				echo "<span class='text-danger'>Name, age, address, atau salary tidak boleh kosong..!</span>";
				echo "<br>";
			}
		} else {
			$name = "";
			$age = "";
			$address = "";
			$salary = "";
		}

	?>
	    <form action="" method="post">
		  <div class="form-group">
		    <label>Name</label>
		    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="Name" required>
		  </div>
		  <div class="form-group">
		    <label>Age</label>
		    <input type="number" min="0" max="200" name="age" value="<?php echo $age; ?>" class="form-control" placeholder="Age" required>
		  </div>
		  <div class="form-group">
		    <label>Address</label>
		    <textarea  class="form-control" name="address" placeholder="Address" required><?php echo $address; ?></textarea>
		  </div>
		  <div class="form-group">
		    <label>Salary</label>
		    <input type="number" min="0" name="salary" value="<?php echo $salary; ?>" class="form-control" placeholder="Salary" required>
		  </div>
		  <button type="submit" class="btn btn-primary" name="btnSimpan">Simpan</button>
		</form>
	</div>
  </div>
</div>