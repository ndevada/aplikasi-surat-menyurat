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

  //$today = date("Y");
    $cekno = mysqli_query($koneksi, "SELECT max(kd_instansi) as maxKode FROM minstansi ORDER BY kd_instansi DESC");
    $data  = mysqli_fetch_array($cekno);
    $kd_instansi = $data['maxKode'];
    $noUrut = (int) substr($kd_instansi, 3, 4);
    $noUrut++;
    $char = "IN-";
    $newKD = $char. sprintf("%03s", $noUrut);
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

              <!-- TO DO List -->

                <?php
      if(isset($_POST['input'])){
        $kd_instansi    = $_POST['kd_instansi'];
        $nm_instansi    = strtoupper($_POST['nm_instansi']);
        $almt_instansi  = strtoupper($_POST['almt_instansi']);

        $check = mysqli_prepare($koneksi, "SELECT nm_instansi FROM minstansi WHERE nm_instansi=?");

          mysqli_stmt_bind_param($check, 's', $nm_instansi);
          mysqli_stmt_execute($check);

        $result=mysqli_stmt_get_result($check);
        $num_rows=mysqli_num_rows($result);

      if($num_rows == 0){

        $check=mysqli_prepare($koneksi, "INSERT INTO minstansi (kd_instansi, nm_instansi, almt_instansi) VALUES (?, ?, ?)");

          mysqli_stmt_bind_param($check, 'sss', $kd_instansi, $nm_instansi, $almt_instansi);
          mysqli_stmt_execute($check);
          echo "<script>alert('Data Instansi berhasil disimpan!'); window.location = 'instansi.php'</script>";
      } else{
        $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Instansi sudah ada..!</div>";
        $script =  "<script> $(document).ready(function(){ $('#tambahData').modal('show'); }); </script>";
        }
      }

        /*$cek = mysqli_query($koneksi, "SELECT * FROM minstansi WHERE nm_instansi='$nm_instansi'");
        if(mysqli_num_rows($cek) == 0){
            $insert = mysqli_query($koneksi, "INSERT INTO minstansi(kd_instansi, nm_instansi, almt_instansi)
                              VALUES('$kd_instansi''$nm_instansi','$almt_instansi')") or die(mysqli_error());
            if($insert){
              echo "<script>alert('Data Instansi berhasil disimpan!'); window.location = 'instansi.php'</script>";
            }else{
              echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Ups, Data Jurusan Gagal Di simpan !</div>';
            }
        }else{
          echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Instansi Sudah Ada..!</div>';
        }
      }*/
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
<div class="modal fade bs-example-modal-md" data-keyboard="false" data-backdrop="static" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel">Tambah Data Instansi</h4>
    </div>
    <div class="modal-body">
    <?php if(isset($error_msg)){ echo $error_msg; } ?>
    <form class="form" onSubmit="return validasi_input(this)" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

  <div class ="col-sm-12">
  <div class ="input-group form-group label-floating">
     <span class="input-group-addon">
      <i class="material-icons">lock</i>
    </span>
    <label for="no_urut" class="control-label">Kode Instansi</label>
      <input type ="text" class ="form-control" name="kd_instansi" value="<?php echo $newKD; ?>" readonly required>
  </div>
</div>

<div class ="col-sm-12">
    <div class ="input-group form-group has-feedback label-floating">
      <span class="input-group-addon">
        <i class="material-icons">domain</i>
      </span>
      <label for="no_urut" class="control-label">Nama Instansi</label>
        <input type ="text" class ="form-control" name="nm_instansi" id="name">
    </div>
  </div>

  <div class ="col-sm-12">
    <div class ="input-group form-group has-feedback label-floating">
      <span class="input-group-addon">
        <i class="material-icons">location_on</i>
      </span>
      <label for="no_urut" class="control-label">Alamat Instansi</label>
        <input type ="text" class ="form-control" pattern="[A-Za-z0-9\s',.-]{1,}$" name="almt_instansi" id="almt">
    </div>
  </div>
    </div>
    <div class="modal-footer">
      <a href="instansi.php" class="btn btn-danger btn-sm">Batal</a>
      <button type="submit" class="btn btn-info btn-sm" name="input">Simpan</button>
    </form>
    </div>
  </div>
</div>
</div>
<?php if(isset($script)){ echo $script; } ?>
<!-- Tambah Data -->
</div><!-- /.box-body -->



</section><!-- /.Left col -->
</div><!-- /.row (main row) -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include("include/credit.php")?>

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
<script type="text/javascript">
$(function() {
    $([data-toggle="popover"])
    });
</script>
<script type="text/javascript">
$(window).on('load',function(){
    $('#tambahData').modal('show');
});
</script>
<script>
  function validasi_input(form){
    if (form.name.value == ""){
      var message = "Nama Instansi tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);
 }else
 var mincar = 5;
  if (form.name.value.length < mincar){
     var message = "Nama Instansi minimal 5 karakter!";
     $('#alertModal').find('.modal-body h4').text(message);
     $('#alertModal').modal('show')
        return (false);
}else
  pola_wa=/^[A-Za-z\s'.]/;
   if (!pola_wa.test(form.name.value)){
    var message = "Nama Instansi tidak boleh mengandung simbol selain petik tunggal dan titik!";
    $('#alertModal').find('.modal-body h4').text(message);
    $('#alertModal').modal('show')
      return (false);
}else
  if (form.almt.value == ""){
      var message = "Alamat Instansi tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false); 
  }
}
</script>
</body>
</html>
