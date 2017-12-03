<h1>Selamat Datang di mana kita bisa bertemu lagi ya..</h1>
<?php 

	if (isset($_SESSION["user_admin"])) {
		$admin = $_SESSION["user_admin"];
	} else {
		$admin = null;
	}
	echo json_encode($admin);
?>


<?php
	echo Helper::modalSaveOpen();
?>
	<b>Test Modal start...</b>
<?php
	echo Helper::modalSaveClose();
?>

<script>
	$(document).ajaxStart(function(){
		$("#formModal").modal("show");
	});
</script>