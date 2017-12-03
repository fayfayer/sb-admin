<!-- Breadcrumbs -->
<ol class="breadcrumb">
  	<li class="breadcrumb-item">
    	<a href="/sb-admin">Home</a>
 	</li>
  	<li class="breadcrumb-item active">Customers</li>
</ol>

<?php 

	$model = new Model_mysqli();
	$model->setTable("customers");

	$orderBy = array(
			"name"	=>	"ASC",
		);
	$search = array(
			"name"	=>	isset($_GET["search"]) ? $_GET["search"] : '',
			"age"	=>	isset($_GET["search"]) ? $_GET["search"] : '',
			"address"	=>	isset($_GET["search"]) ? $_GET["search"] : '',
			"salary"	=>	isset($_GET["search"]) ? $_GET["search"] : '',
		);
	$page = isset($_GET["page"]) ? $_GET["page"] : 1;
	$result = $model->findDataPaging($page,10,false,false,$orderBy,$search);

	$total_pages = $model->getCountPaging(10,false,$search);	// for pagination

	/* for delete */
	if (isset($_GET["delete"])) {
		$idDelete = $_GET["delete"];
		$hapus = $model->delete($idDelete);
		if ($hapus) {
			echo "<script> document.location.href = '".$backRedirect."'; </script>";
		}
	}


?>


<div class="card border-primary ">
  	<div class="card-header"><i class="fa fa-table"></i> Table Customers</div>
  	<div class="card-body ">
  		<div class="row">
		  	<div class="col-md-4">
		  		<h4 class="card-title">
			    	<a href="?menu=customers/add" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i>	Tambah Data</a>
			    </h4>
		  	</div>
		  	<div class="col-md-8">
		  		<form method="get" class="form-inline pull-right">
					<div class="form-group">
					    <div class="input-group">
					    	<input type="hidden" name="menu" value="customers">
					    	<input type="hidden" name="page" value="1">
						    <input type="text" name="search" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : ''; ?>" class="form-control" placeholder="Cari">
						    <button type="submit" class="btn btn-outline-info btn-sm"><i class="fa fa-search"></i> Cari</button>
					    </div>
					</div>
				</form>
		  	</div>
		</div>
	    <table class="table table-striped table-bordered table-sm table-responsive">
			<thead class="thead-inverse">
				<tr>
    				<th>No</th>
    				<th>Name</th>
    				<th>Age</th>
    				<th>Address</th>
    				<th>Salary</th>
    				<th>Action</th>
    			</tr>
			</thead>
			<tbody>
			<?php 
				$no = ($page - 1) * 10;
				foreach($result as $item) : 
					$no++;
			?>
				<tr>
					<td><?php echo $no; ?></td>	
					<td><?php echo $item["name"]; ?></td>
					<td><?php echo $item["age"]; ?></td>
					<td><?php echo $item["address"]; ?></td>
					<td><?php echo "Rp.".number_format($item["salary"],0,",","."); ?></td>	
					<td>
						<a href="?menu=customers/update/<?php echo $item["id"].$redirect; ?>" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i> Edit</a> &nbsp; &nbsp;
						<a href="?menu=customers&delete=<?php echo $item["id"].$redirect; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini.?')"><i class="fa fa-trash-o"></i> Hapus</a>
					</td>
				</tr>
			<?php 
				endforeach; 

				if($result == []) :
			?>
				<tr><td colspan="6" align="center" class="text-danger"><b><i>Data tidak di temukan..</i></b></td></tr>
			<?php 
				endif;
			?>
			</tbody>
		</table>
		<?php 
			/* For Pagination */
			$helper = new Helper();
			$helper->pagination($result,$total_pages,"customers",$page,"left");
		?>
  	</div>
</div>