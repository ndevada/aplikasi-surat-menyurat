<?php
    include '../config.php';
	$modal_id=$_GET['kd_detail'];
	$modal=mysqli_query($koneksi,"SELECT * FROM detail WHERE kd_detail='$modal_id'");
	while($row=mysqli_fetch_array($modal)){
?>

<div class="modal-dialog">
    <div class="modal-content">

    	<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-clone"></i></button>
            <h4 class="modal-title" id="myModalLabel">Ubah Data</h4>
        </div>
        <div class="modal-body">
        	<form action="proses_edit.php" name="modal_popup" enctype="multipart/form-data" method="POST">
        	<div style="display:none">
            <input type ="text" class ="form-control" name="kd_detail" value="<?php echo $row['kd_detail']; ?>" readonly required>
          </div>
          <div class ="col-sm-12">
          <div class ="input-group form-group label-floating">
             <span class="input-group-addon">
              <i class="material-icons">lock</i>
            </span>
            <label for="no_urut" class="control-label">Kode Tempat Penyimpanan Surat</label>
              <input type ="text" class ="form-control" name="kd_simpan" value="<?php echo $row['kd_simpan']; ?>" readonly required>
          </div>
        </div>
        
        <div class ="col-sm-12">
            <div class ="input-group form-group has-feedback label-floating">
              <span class="input-group-addon">
                <i class="material-icons">domain</i>
              </span>
              <label for="no_urut" class="control-label">Nama Tempat Penyimpanan Surat</label>
                <input type ="text" class ="form-control" id="name" name="nm_detail" value="<?php echo $row['nm_detail']; ?>">
            </div>
          </div>
            <div class="modal-footer">
               <button type="reset" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-info btn-sm" name="ubah">Simpan</button>
              </div>
            </form>
  <?php } ?>
          </div>
</div>