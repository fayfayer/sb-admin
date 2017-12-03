<?php 
/**
* 
*/
class Helper
{
	public function pagination($result,$total_pages,$menu,$page,$position = "left")
	{
		if ($position == "right") {
			$position = "pull-right";
		} else if ($position == "left") {
			$position = "pull-left";
		}

		if($result != []) :
			$pagePrev = $page - 1;
			$pageNext = $page + 1;
	    	$search = isset($_GET["search"]) ? "&search=".$_GET["search"] : "";
			echo '<nav aria-label="...">';
				echo '<ul class="pagination '.$position.'">';
					$pagePrevDisabled = $page == 1 ? 'disabled' : '';
					echo '<li class="page-item '.$pagePrevDisabled.'">';
				      echo '<a class="page-link" href="?menu='.$menu.'&page='.$pagePrev.$search.'">Previous</a>';
				    echo '</li>';
				    	for ($i=1; $i <= $total_pages; $i++) :
				    		$pageActive = $page == $i ? 'active' : '';
						    echo '<li class="page-item '.$pageActive.'">';
						    	echo '<a class="page-link" href="?menu='.$menu.'&page='.$i.$search.'">'.$i.'</a>';
						    echo '</li>';
				    	endfor;
					$pageNextDisabled = $page == $total_pages ? 'disabled' : '';
				    echo '<li class="page-item '.$pageNextDisabled.'">';
				      echo '<a class="page-link" href="?menu='.$menu.'&page='.$pageNext.$search.'">Next</a>';
				    echo '</li>';
				echo '</ul>';
			echo '</nav>';
		endif;
	}

	public function modalSaveOpen($size="",$title="Form Modal",$idModal = "formModal")
	{
		return '
				<div class="modal fade" id="'.$idModal.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  	<div class="modal-dialog modal-'.$size.'" role="document">
				    	<div class="modal-content">
						    <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">'.$title.'</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						    </div>
				      		<div class="modal-body">
				';			
	}

	public function modalSaveClose($btnSaveName="Simpan")
	{
		return '
				 			</div>
					      	<div class="modal-footer">
						        <button type="button" id="btnModalSave" class="btn btn-primary">'.$btnSaveName.'</button>
						        <button type="button" id="btnModalClose" class="btn btn-warning" data-dismiss="modal">Batal</button>
					      	</div>
				    	</div>
				  	</div>
				</div>
			   ';
	}
	
	public function modalDeleteShow(){
	    return '
				<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  	<div class="modal-dialog modal-sm" role="document">
				    	<div class="modal-content">
						    <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						    </div>
				      		<div class="modal-body">
                                <p id="contentModalDelete"><b>Apakah anda ingin menghapus data ini.?</b></p>
                                <div id="inputMessageDelete"></div>
                            </div>
					      	<div class="modal-footer">
						        <button type="button" id="btnModalDelete" class="btn btn-danger">Ok, Hapus.</button>
						        <button type="button" id="btnModalClose" class="btn btn-default" data-dismiss="modal">Batal</button>
					      	</div>
				    	</div>
				  	</div>
				</div>
			';			
	}
	
	public function alertSuccess($message) {
	    return '<div class="alert alert-success">'.$message.'. <i class="fa fa-check"></i></div>';
	}
	
	public function alertInfo($message) {
	    return '<div class="alert alert-info">'.$message.'. <i class="fa fa-info"></i></div>';
	}
	
	public function alertWarning($message) {
	    return '<div class="alert alert-warning">'.$message.'. <i class="fa fa-warning"></i></div>';
	}
	
	public function alertDanger($message) {
	    return '<div class="alert alert-danger">'.$message.'. <i class="fa fa-ban"></i></div>';
	}

	public function spanDanger($message)
	{
		return '<span style="color:red;">'.$message.'</span>';
	}
}

 ?>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 