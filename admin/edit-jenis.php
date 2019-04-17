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
        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
      <?php
          $id = $_GET['id'];
          $select = "SELECT kd_jenis, nm_jenis FROM mjenis WHERE kd_jenis=?";
          $check  = mysqli_prepare($koneksi, $select);

            mysqli_stmt_bind_param($check, 's', $id);
            mysqli_stmt_execute($check);

          $result = mysqli_stmt_get_result($check);
          $hitung = mysqli_num_rows($result);
          
            if ($hitung == 0){
              echo "<script>alert('Data Tidak Ditemukan'); window.location = 'jenis.php'</script>";
            } else{
              $row = mysqli_fetch_assoc($result);
            }

             if(isset($_POST['ubah'])){
                $kd_jenis    = $_POST['kd_jenis'];
                $nm_jenis    = strtoupper($_POST['nm_jenis']);
                $data         = "SELECT kd_jenis, nm_jenis FROM mjenis WHERE nm_jenis=?";
                $query        = mysqli_prepare($koneksi, $data);

                  mysqli_stmt_bind_param($query, 's', $nm_jenis);
                  mysqli_stmt_execute($query);

                $hasil = mysqli_stmt_get_result($query);
                $valid = mysqli_num_rows($hasil);

              if ($valid == 0){
                $up    = "UPDATE mjenis SET nm_jenis=? WHERE kd_jenis=?";
                $query = mysqli_prepare($koneksi, $up);

                  mysqli_stmt_bind_param($query, "ss", $nm_jenis, $kd_jenis);
                  mysqli_stmt_execute($query);
                  echo "<script>alert('Data Jenis berhasil disimpan!'); window.location = 'jenis.php'</script>";
              }else{
                $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Jenis surat sudah ada..!</div>";
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
    <!-- MODAL -->
    <div class="modal fade bs-example-modal-md" data-keyboard="false" data-backdrop="static" id="ubahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel">Ubah Jenis Surat</h4>
    </div>
    <div class="modal-body">
    <?php if(isset($error_msg)){ echo $error_msg; } ?>
      <form class="form-horizontal" onSubmit="return validasi_input(this)" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

      <div class ="col-sm-12">
      <div class ="input-group form-group label-floating">
         <span class="input-group-addon">
          <i class="material-icons">lock</i>
        </span>
        <label for="no_urut" class="control-label">Kode Jenis Surat</label>
          <input type ="text" class ="form-control" name="kd_jenis" value="<?php echo $row['kd_jenis']; ?>" readonly required>
      </div>
    </div>
    
    <div class ="col-sm-12">
        <div class ="input-group form-group has-feedback label-floating">
          <span class="input-group-addon">
            <i class="material-icons">group</i>
          </span>
          <label for="no_urut" class="control-label">Nama Jenis Surat</label>
            <input type ="text" class ="form-control" id="name" name="nm_jenis" value="<?php echo $row['nm_jenis'];?>">
        </div>
      </div>
</div>
<div class="modal-footer">
  <a href="jenis.php" class="btn btn-danger btn-sm">Batal</a>
  <button type="submit" class="btn btn-info btn-sm" name="ubah">Simpan</button>
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
<?php include("include/credit.php")?>
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
  function validasi_input(form){
    if (form.name.value == ""){
      var message = "Nama Jenis tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);
 }else
 var mincar = 5;
  if (form.name.value.length < mincar){
     var message = "Nama Jenis minimal 5 karakter!";
     $('#alertModal').find('.modal-body h4').text(message);
     $('#alertModal').modal('show')
        return (false);
}else
  pola_wa=/^[A-Za-z\s]/;
   if (!pola_wa.test(form.name.value)){
    var message = "Nama Jenis tidak boleh mengandung simbol!";
    $('#alertModal').find('.modal-body h4').text(message);
    $('#alertModal').modal('show')
      return (false);
}
}
</script>
</body>
</html>