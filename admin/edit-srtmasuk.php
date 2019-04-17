<?php
session_name('surat');  
session_start();
if (empty($_SESSION['username'])){
	header('location:../index.php');	
} else {
if($_SESSION['level']!=="admin"){
die("Anda bukan admin");//jika bukan admin jangan lanjut
} else {
	include "../config.php";
?>
<!DOCTYPE html>
<html lang="en">
<!-- Head  -->
    <?php include ("include/head.php")?>
<!-- Head  -->
<body>
<!-- Menu -->
    <?php include("include/menu.php")?>
<!-- Menu -->
<?php
$timeout = 60; // Set timeout minutes
$logout_redirect_url = "../index.php"; // Set logout URL

$timeout = $timeout * 60; // Converts minutes to seconds
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
        session_destroy();
        echo "<script>alert('Session Anda Telah Habis!'); window.location = '$logout_redirect_url'</script>";
    }
}
$_SESSION['start_time'] = time();
?>
<?php } }?>
     <!-- Content Wrapper. Contains page content -->
      <div class="container">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <?php
          $id = $_GET['id'];
          $select = "SELECT * FROM tsuratmasuk WHERE no_urut =?";
          $check  = mysqli_prepare($koneksi, $select);
          
              mysqli_stmt_bind_param($check, 's', $id);
              mysqli_stmt_execute($check);

          $result = mysqli_stmt_get_result($check);
          $num_row = mysqli_num_rows($result);

          if ($num_row == 0){
                echo "<script>alert('Data Tidak Ditemukan'); window.location = 'surat-masuk.php'</script>";
          }else{
            $row = mysqli_fetch_assoc($result);
          }

          if(isset($_POST['ubah'])){
            $no_urut        = $_POST['no_urut'];
            $tgl_surat      = date('Y-m-d',strtotime($_POST['tgl_surat']));
            $nmr_surat      = strtoupper($_POST['nmr_surat']);
            $kd_instansi    = $_POST['kd_instansi'];
            $tgl_diterima   = date('Y-m-d',strtotime($_POST['tgl_diterima']));
            $perihal        = strtoupper($_POST['perihal']);
            $catatan        = strtoupper($_POST['catatan']);
            $kd_simpan      = $_POST['kd_simpan'];
            $kd_detail      = $_POST['detail'];
            //$ganti          = "-";
    
            $check = mysqli_prepare($koneksi, "SELECT * FROM tsuratmasuk WHERE no_urut=? AND tgl_surat=? AND nmr_surat=? AND kd_instansi=? AND tgl_diterima=? AND perihal=? AND catatan=? AND kd_simpan=? AND kd_detail=?");
    
              mysqli_stmt_bind_param($check, 'sssssssss', $no_urut, $tgl_surat, $nmr_surat, $kd_instansi, $tgl_surat,$perihal, $catatan, $kd_simpan, $kd_detail);
              mysqli_stmt_execute($check);
    
            $result=mysqli_stmt_get_result($check);
            $num_rows=mysqli_num_rows($result);

          if($num_rows == 0){

            if($tgl_surat <= $tgl_diterima){
                $check=mysqli_prepare($koneksi, "UPDATE tsuratmasuk SET tgl_surat=?, nmr_surat=?, tgl_diterima=?, kd_instansi=?, perihal=?, catatan=?, kd_simpan=?, kd_detail=? WHERE no_urut=?");
      
                  mysqli_stmt_bind_param($check, 'sssssssss', $tgl_surat, $nmr_surat, $tgl_diterima, $kd_instansi, $perihal, $catatan, $kd_simpan, $kd_detail, $no_urut);
                  mysqli_stmt_execute($check);
                  echo "<script>alert('Surat masuk berhasil disimpan!'); window.location = 'surat-masuk.php'</script>";
              } 
              else{
                $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Tanggal yang anda masukan salah..!</div>";
                $script =  "<script> $(document).ready(function(){ $('#tambahData').modal('show'); }); </script>";
                }
            } else{
              $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Data Sudah Ada..!</div>";
              $script =  "<script> $(document).ready(function(){ $('#tambahData').modal('show'); }); </script>";
              }
            }
      ?>
            
    <div class="box-body">
    <div id="alertModal" class="modal fade tes" data-target="md1" data-backdrop="static" tabindex="-1" id="aa" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kesalahan!</h4>
            </div>
            <div class="modal-body">
                <h4></h4>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-default" data-dismiss="modal">
                    Tutup!</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Tambah Data -->
    <div class="modal fade bs-example-modal-lg" data-keyboard="false" data-backdrop="static" id="ubahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel">Ubah Data Surat Masuk</h4>
    </div>
    <div class="modal-body">
    <?php if(isset($error_msg)){ echo $error_msg; } ?>
    <form class="form" onSubmit="return validasi_input(this)" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <div style="display:none">  
    <input class ="form-control" name="no_urut" data-toggle="tooltip" data-placement="top" title="Nomor urut surat" value="<?php echo $row['no_urut']; ?>" required readonly>
    </div>
      <div class ="col-sm-6">
        <div class ="input-group form-group has-feedback label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">looks_one</i>
		  </span>
			    <label for="no_urut" class="control-label">NOMOR SURAT MASUK *</label>
				    <input type="text" class ="form-control" value="<?php echo $row['nmr_surat']; ?>" name="nmr_surat" id="name">
		    </div>
      </div>

      <?php
          $sql = "SELECT * FROM tsuratmasuk WHERE no_urut='$_GET[id]'";
          $edit = $koneksi->query($sql);
          $r = $edit->fetch_assoc();
      ?>
      <div class ="col-sm-6">
             <div class ="input-group form-group label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">date_range</i>
		  </span>
			    <label for="no_urut" class="control-label">TANGGAL SURAT MASUK *</label>
				    <input id="tanggalmsk" class="datepicker form-control" type="text" name="tgl_surat" value="<?php echo date('d-m-Y',strtotime($row['tgl_surat'])); ?>" readonly> 
		    </div>
      </div>
    
      <div class="col-sm-6">
      <div class ="input-group form-group has-feedback label-floating">
         <span class="input-group-addon">
          <i class="material-icons">domain</i>
    </span>
    <label class="control-label" for="selectbasic">PILIH PENGIRIM SURAT *</label>
        <select name='kd_instansi' id='instansi' class='form-control'>
        <?php    
						$sql="SELECT * FROM minstansi ORDER BY nm_instansi";
						$instansi = $koneksi->query($sql);
					    while ($ra = $instansi->fetch_assoc()) {
					    	if($r[kd_instansi]==$ra[kd_instansi]){
							echo " <option value='$ra[kd_instansi]' selected>$ra[nm_instansi]</option>";
							} else {
								echo "<option value='$ra[kd_instansi]'>$ra[nm_instansi]</option>";
							}
            }

							?>
        </select>
 
    </div>
    </div>

     <div class ="col-sm-6">
        <div class ="input-group form-group label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">date_range</i>
		  </span>
			    <label for="no_urut" class="control-label">TANGGAL SURAT DITERIMA *</label>
				    <input id="tanggaldtr" class="datepicker form-control" type="text" value="<?php echo date('d-m-Y',strtotime($row['tgl_diterima'])); ?>" name="tgl_diterima" readonly> 
		    </div>
      </div>
      

    <div class="col-md-12">
    <div class ="input-group form-group has-feedback label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">looks_one</i>
		  </span>
			    <label for="no_urut" class="control-label">PERIHAL SURAT *</label>
				    <input type ="text" class ="form-control" id="perihal" name="perihal" value="<?php echo  $row['perihal']; ?>">
		    </div>
    </div>

    <div class ="col-sm-6">
        <div class ="input-group form-group has-feedback label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">mail_outline</i>
		  </span>
			    <label for="perihal" class="control-label has-feedback">CATATAN *</label>
				    <textarea class ="form-control" id="catatan" name="catatan" rows="5"><?php echo strip_tags($row['catatan']); ?></textarea>
		    </div>
      </div>
      
      <div class="col-sm-6">
      <div class ="input-group form-group has-feedback label-floating">
        <span class="input-group-addon">
          <i class="material-icons">save</i>
        </span>
          <label class="control-label" for="selectbasic">PILIH TEMPAT PENYIMPANAN *</label>
              <select name='kd_simpan' id='tempat' class='form-control'>
               <option value=''></option>
               <?php    
					    	$sql="SELECT * FROM mpnympn ORDER BY nm_simpan";
					    	$simpan = $koneksi->query($sql);
					      while ($ra = $simpan->fetch_assoc()) {
					    	if($r[kd_simpan]==$ra[kd_simpan]){
						  	echo " <option value='$ra[kd_simpan]' selected>$ra[nm_simpan]</option>";
							  } else {
							  echo "<option value='$ra[kd_simpan]'>$ra[nm_simpan]</option>";
							  }
					  	}
							?>
               </select>
</div>

      <div class ="input-group form-group has-feedback label-floating">
        <span class="input-group-addon">
          <i class="material-icons">save</i>
        </span>
        <label class="control-label" for="selectbasic">PILIH LOKASI TEMPAT PENYIMPANAN *</label>
        <select name="detail" id="detail" class="form-control">
        <option value=""></option>
        <?php    
					    	$sql="SELECT * FROM detail ORDER BY nm_detail";
					    	$simpan = $koneksi->query($sql);
					      while ($ra = $simpan->fetch_assoc()) {
					    	if($r[kd_detail]==$ra[kd_detail]){
						  	echo " <option value='$ra[kd_detail]' selected>$ra[nm_detail]</option>";
							  } else {
							  echo "<option value='$ra[kd_detail]'>$ra[nm_detail]</option>";
							  }
					  	}
							?>
               </select>
        </select>
</div>
      </div>

    </div>
    <div class="modal-footer">
    <div class="col-sm-12 text-right">
      <a href="surat-masuk.php" class="btn btn-danger btn-sm">Batal</a>
      <button type="submit" class="btn btn-info btn-sm" name="ubah">Simpan</button>
    </div>
    </form>
    </div>
  </div>
</div>
</div>
<?php if(isset($script)){ echo $script; } ?>`
</div><!-- /.box-body -->

</div><!-- /.box -->

</section><!-- /.Left col -->
</div><!-- /.row (main row) -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php //include("include/credit.php")?>

<script>
          $(document).ready(function() {
  				var dataTable = $('#tkadis').DataTable( {
            "responsive": true,
            "processing": true,
  					"serverSide": true, 
  					"ajax":{
  						url :"ajax-instansi.php", // json datasource
  						type: "post",  // method  , by default get
  						error: function(){  // error handling
  							$(".lookup-error").html("");
  							$("#lookup").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data tidak ditemukan!</th></tr></tbody>');
  							$("#lookup_processing").css("display","none");
  							
  						}
  					}
  				} );
  			} );
    </script>
<script>
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    $('input.datepicker').datepicker({
      format : 'dd-mm-yyyy',
      onRender: function (date) {
        return date.valueOf() > now.valueOf() ? 'disabled' : '';
    }
    }).on('changeDate', function(e){
        // this next line fixed the floating label issue for me     
        $(this).parent('.label-floating').removeClass('is-empty'); 
    });
</script>
<script type="text/javascript">
$(function() {
    $([data-toggle="popover"])
    });
</script>
<script type="text/javascript">
$(window).on('load',function(){
    $('#ubahData').modal('show');
});
</script>
<script>
  $(".alert-dismissable").fadeTo(10000, 500).slideUp(500, function(){
 $(".alert-dismissable").alert('close');
});
</script>
<script>
var elmt = document.getElementById('name');

elmt.addEventListener('keydown', function (event) {
//    if (elmt.value.length === 0 && event.which === 32) {
//        event.preventDefault();
//    }
    if (event.which === 32) {
        elmt.value = elmt.value.replace(/^\s+/, '');
        if (elmt.value.length === 0) {
            event.preventDefault();
        }
    }
});
var elmt = document.getElementById('perihal');

elmt.addEventListener('keydown', function (event) {
//    if (elmt.value.length === 0 && event.which === 32) {
//        event.preventDefault();
//    }
    if (event.which === 32) {
        elmt.value = elmt.value.replace(/^\s+/, '');
        if (elmt.value.length === 0) {
            event.preventDefault();
        }
    }
});
var elmt = document.getElementById('catatan');

elmt.addEventListener('keydown', function (event) {
//    if (elmt.value.length === 0 && event.which === 32) {
//        event.preventDefault();
//    }
    if (event.which === 32) {
        elmt.value = elmt.value.replace(/^\s+/, '');
        if (elmt.value.length === 0) {
            event.preventDefault();
        }
    }
});
</script>
<script>
  function validasi_input(form){
    if (form.name.value == ""){
      var message = "Nomor surat tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);
  }else
       var mincar = 5;
        if (form.name.value.length < mincar){
          var message = "Nomor surat minimal 5 karakter!";
          $('#alertModal').find('.modal-body h4').text(message);
          $('#alertModal').modal('show')
          return (false);
  }else
  if (form.tanggalmsk.value == ""){
      var message = "Tanggal surat masuk tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false); 
  }else
  if (form.instansi.value == ""){
      var message = "Pengirim surat tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
  }else
  if (form.tanggaldtr.value == ""){
      var message = "Tanggal surat diterima tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
  }else
  if (form.perihal.value == ""){
      var message = "Perihal surat tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
  }else
  if (form.catatan.value == ""){
      var message = "Catatan surat tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
  }else
  if (form.tempat.value == ""){
      var message = "Tempat penyimpanan surat masuk tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
}
}
</script>
<script>
$(document).ready(function (){
    $('#tempat').change(function () {
        var kd_simpan = $(this).val();

            $.ajax({
                type : 'post',
                url  : 'detail.php',
                data : 'kd_simpan='+kd_simpan,
                success : function (response) {
                    $('#detail').html(response);
                }
            });
    })
});
</script>
</body>
</html>