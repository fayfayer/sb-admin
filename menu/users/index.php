<!-- Breadcrumbs -->
<ol class="breadcrumb">
  	<li class="breadcrumb-item">
    	<a href="/sb-admin">Home</a>
 	</li>
  	<li class="breadcrumb-item active">Users</li>
</ol>

<div class="card border-primary ">
  	<div class="card-header"><i class="fa fa-table"></i> Table Users</div>
  	<div class="card-body ">
  		<div class="container">
  			<div class="row">
  				<div class="col-md-4">
			  		<h4 class="card-title">
				    	<button type="button" onclick="btnAdd()" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i>	Tambah Data</button> &nbsp; &nbsp;
				    	<button type="button" onclick="btnRefresh()" class="btn btn-outline-success btn-sm"><i class="fa fa-refresh"></i> Refresh</button>
				    </h4>
			  	</div>
  			</div>
		</div>
	    <table id="tableUsers" class="table table-striped table-bordered table-sm table-responsive" style="width:100%">
			<thead class="thead-inverse">
				<tr>
    				<th>No</th>
    				<th>First Name</th>
    				<th>Last Name</th>
					<th>Email</th>
					<th>Photo</th>
    				<th>Role</th>
    				<th>Action</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
  	</div>
</div>

<!-- Form Modal -->
<?php //$helper = new Helper(); ?>

<?php echo Helper::modalSaveOpen(); ?>
	<div id="inputMessage"></div>
	<form action="" method="post" id="formData">
        <div class="form-group">
          <input type="hidden" name="userId" id="inputId">
          <div class="form-row">
            <div class="col-md-6">
              <label>First name</label>
              <input type="text" class="form-control" name="firstname" id="inputFirstname" placeholder="First name">
              <div id="errorFirstname"></div>
            </div>
            <div class="col-md-6">
              <label>Last name</label>
              <input type="text" class="form-control" name="lastname" id="inputLastname" placeholder="Last name">
              <div id="errorLastname"></div>
            </div>
          </div>
        </div>
        <div class="form-group">
        	<div class="form-row">
        		<div class="col-md-6">
        			<label>Username</label>
              		<input type="text" class="form-control" name="username" id="inputUsername" placeholder="Username">
              		<div id="errorUsername"></div>
              		<div id="errorCheckUsername"></div>
        		</div>
        		<div class="col-md-6">
        			<label>Email</label>
                  	<input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email">
                  	<div id="errorEmail"></div>
                  	<div id="errorCheckEmail"></div>
        		</div>
        	</div>   
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <label>Password</label>
              <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
              <div id="errorPassword"></div>
            </div>
            <div class="col-md-6">
              <label>Confirm password</label>
              <input type="password" class="form-control" name="confirmPassword" id="inputConfirmPassword" placeholder="Confirm password">
              <div id="errorConfirmPassword"></div>
              <div id="errorCheckConfirm"></div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div id="showPhotoAja" class="col-md-6">
             	<label>Photo</label><br>
				<img src="" id="showPhoto" class="img-responsive img-thumbnail" style="width:100px; height:100px;">
				<label id="checkboxPhoto">
					<input type="checkbox" id="hapusPhoto" name="hapusPhoto"> Hapus photo
				</label>
            </div>
            <div id="gantiPhoto" class="col-md-6">
				<label id="labelPhoto">Ganti Photo</label>
				<input type="file" class="form-control" id="inputPhoto" name="photo">
				<div id="errorPhoto"></div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label>Role</label>
          <select name="role" class="form-control" id="inputRole">
          	<option value="">--Pilih Role--</option>
          	<option value="admin">Admin</option>
          	<option value="user">User</option>
          </select>
          <div id="errorRole"></div>
        </div>
    </form>
<?php echo Helper::modalSaveClose(); ?>

<!-- Modal Delete Show -->
<?php echo Helper::modalDeleteShow(); ?>
    

<script type="text/javascript">

	var method_save;
	var idAction;
	var idDelete
	
	function btnAdd() {
		$("#formModal").modal("show");
		$(".modal-title").text("Form Tambah User.");
		$("#formData")[0].reset();
		$("#inputUsername").attr("disabled",false);
		$("#inputEmail").attr("disabled",false);
		$("#showPhotoAja").hide();
		$("#gantiPhoto").removeClass("col-md-6");
		$("#gantiPhoto").addClass("col-md-12");
		$("#labelPhoto").text("Pilih Photo");
		method_save = "add";
	}

	function btnRefresh() {
		reloadTable();
	}

	function btnUpdate(id) {
		$("#formModal").modal("show");
		$(".modal-title").text("Form Update User.");
		$("#inputUsername").attr("disabled",true);
		$("#inputEmail").attr("disabled",true);
		$("#inputMessage").html("");
    	$("#inputPassword").val("");
    	$("#inputConfirmPassword").val("");
		$("#showPhotoAja").show();
		$("#gantiPhoto").removeClass("col-md-12");
		$("#gantiPhoto").addClass("col-md-6");
		$("#labelPhoto").text("Ganti Photo");
		$("#inputPhoto").val("");
		$("#hapusPhoto").prop("checked",false);
		method_save = "update";
		
		idAction = id;
		$.post("?ajax=users/get_by_id/"+idAction,function(json){
			if(json.status == true) {
				$("#inputId").val(json.data.id);
				$("#inputFirstname").val(json.data.firstname);
    			$("#inputLastname").val(json.data.lastname);
    			$("#inputUsername").val(json.data.username);
    			$("#inputEmail").val(json.data.email);
				img = json.data.photo == "" ? "img/user_image.png" : "upload/users/"+json.data.photo;
				$("#showPhoto").attr("src",img);
				json.data.photo == "" ? $("#checkboxPhoto").hide() : $("#checkboxPhoto").show();
    			$("#inputRole").val(json.data.role);
			} else {
				$("#inputMessage").html(json.message);
			}	
		});
	}

	$("#btnModalSave").click(function() {
		var url;
		if(method_save == "add"){
			url = "?ajax=users/add";
		} else {
			url = "?ajax=users/update";
		}

		var formData = new FormData($('#formData')[0]); // untuk yang menggunakan photo
		$.ajax({
			url:url,
			type:'POST',
			// data:$("#formData").serialize(), // untuk form biasa atau tanpa photo 
			data:formData,
	        contentType: false, // untuk yang menggunakan photo
	        processData: false, // untuk yang menggunakan photo
			dataType:'json',
			success: function(json){
				if (json.status == true) {
					$("#inputMessage").html(json.message);
					reloadTable();
					setTimeout(function(){
						$("#inputMessage").html("");
						$("#formModal").modal("hide");
					},1500);
				} else {
					$("#errorFirstname").html(json.error.firstname);
					$("#errorLastname").html(json.error.lastname);
					$("#errorUsername").html(json.error.username);
					$("#errorEmail").html(json.error.email);
					$("#errorPassword").html(json.error.password);
					$("#errorConfirmPassword").html(json.error.confirmPassword);
					$("#errorCheckConfirm").html(json.error.checkConfirm);
					$("#errorCheckUsername").html(json.error.checkUsername);
					$("#errorCheckEmail").html(json.error.checkEmail);
					$("#errorPhoto").html(json.error.photo);
					$("#errorRole").html(json.error.role);

					setTimeout(function(){
						$("#errorFirstname").html("");
						$("#errorLastname").html("");
						$("#errorUsername").html("");
						$("#errorEmail").html("");
						$("#errorPassword").html("");
						$("#errorConfirmPassword").html("");
						$("#errorCheckConfirm").html("");
						$("#errorCheckUsername").html("");
						$("#errorCheckEmail").html("");
						$("#errorPhoto").html("");
						$("#errorRole").html("");
					},3000);
				}
			}			
		});
	});

	function btnDelete(id) {
		$("#modalDelete").modal("show");
		idDelete = id;
		$.post("?ajax=users/get_by_id/"+idDelete,function(json){
			if(json.status == true) {
				$("#inputMessageDelete").html("<b>Firstname : </b> <u>"+json.data.firstname+"</u>");
			} else {
				$("#inputMessageDelete").html(json.message);
			}	
		});
	}

	$("#btnModalDelete").click(function(){
		$.post("?ajax=users/delete/"+idDelete,function(json){
			if(json.status == true) {
				$("#inputMessageDelete").html(json.message);
				$("#contentModalDelete").hide();

				setTimeout(function(){
					$("#inputMessageDelete").html("");
					$("#contentModalDelete").show();
					$("#modalDelete").modal("hide");
					reloadTable();
				},1500);
			} else {
				$("#inputMessageDelete").html(json.message);
			}	
		});
	});

	function reloadTable() {
		$("#tableUsers").DataTable().ajax.reload(null,false);
	}
	
	$(document).ready(function() {
		btnEdit = '<button type="button" onclick="" class="btn btn-sm btn-outline-warning"><i class="fa fa-edit"></i> Edit</button> &nbsp; &nbsp;';
		btnHapus = '<button type="button" onclick="" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Hapus</button>';
		$("#tableUsers").DataTable({
			serverSide:true,
			processing:true,
			ordering: true,

			ajax:{
				url:'?ajax=users',
				type:'POST',
			},

			order:[[1, 'ASC']],
			columns:[
				{
					data:'no',
					orderable:false,
					searchable:false,
				},
				{ data:'firstname' },
				{ data:'lastname' },
				{ data:'email' },
				{
					data:null,
					orderable:false,
					searchable:false,
					defaultContent:'<img src="" class="img-responsive img-thumbnail" style="width:50px; height:55px;">',
				},
				{ data:'role' },
				{
					data: null,
					orderable:false,
					searchable:false,
					defaultContent: btnEdit+" "+btnHapus,
				}
			],

			aoColumnDefs:[{
				aTargets: [4,6],
				fnCreatedCell:function(nTd,sData,oData,iRow,iCol){
					if (iCol == 4) {
						img = oData.photo == "" ? "img/user_image.png" : "upload/users/"+oData.photo;
						$(nTd.children[0]).attr("src",img);
					}
					if (iCol == 6) {
						$(nTd.children[0]).attr("onclick","btnUpdate("+oData.id+")");
						$(nTd.children[1]).attr("onclick","btnDelete("+oData.id+")");
					}
				}
			}],
		});
	});

</script>
