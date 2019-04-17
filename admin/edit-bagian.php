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
          $select = "SELECT kd_bagian, nm_bagian FROM m_bagian WHERE kd_bagian=?";
          $check  = mysqli_prepare($koneksi, $select);

            mysqli_stmt_bind_param($check, 's', $id);
            mysqli_stmt_execute($check);

          $result = mysqli_stmt_get_result($check);
          $hitung = mysqli_num_rows($result);
          
            if ($hitung == 0){
              echo "<script>alert('Data Tidak Ditemukan'); window.location = 'instansi.php'</script>";
            } else{
              $row = mysqli_fetch_assoc($result);
            }

             if(isset($_POST['ubah'])){
                $kd_bagian    = $_POST['kd_bagian'];
                $nm_bagian    = strtoupper($_POST['nm_bagian']);
                $data         = "SELECT nm_bagian FROM m_bagian WHERE nm_bagian=?";
                $query        = mysqli_prepare($koneksi, $data);

                  mysqli_stmt_bind_param($query, 's', $nm_bagian);
                  mysqli_stmt_execute($query);

                $hasil = mysqli_stmt_get_result($query);
                $valid = mysqli_num_rows($hasil);

              if ($valid == 0){
                $up    = "UPDATE m_bagian SET nm_bagian=? WHERE kd_bagian=?";
                $query = mysqli_prepare($koneksi, $up);

                  mysqli_stmt_bind_param($query, "ss", $nm_bagian, $kd_bagian);
                  mysqli_stmt_execute($query);
                  echo "<script>alert('Data Bagian berhasil disimpan!'); window.location = 'bagian.php'</script>";
              }else{
                $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Bagian sudah ada..!</div>";
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
<div class="modal fade bs-example-modal-md" data-keyboard="false" data-backdrop="static" id="ubahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel">Ubah Data Bagian</h4>
    </div>
    <div class="modal-body">
    <?php if(isset($error_msg)){ echo $error_msg; } ?>
    <form class="form" onSubmit="return validasi_input(this)" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

  <div class ="col-sm-12">
  <div class ="input-group form-group label-floating">
     <span class="input-group-addon">
      <i class="material-icons">lock</i>
    </span>
    <label for="no_urut" class="control-label">Kode Bagian</label>
      <input type ="text" class ="form-control" name="kd_bagian" value="<?php echo $row['kd_bagian']; ?>" readonly required>
  </div>
</div>

<div class ="col-sm-12">
    <div class ="input-group form-group has-feedback label-floating">
      <span class="input-group-addon">
        <i class="material-icons">group</i>
      </span>
      <label for="no_urut" class="control-label">Nama Bagian</label>
        <input type ="text" class ="form-control" id="name" name="nm_bagian" value="<?php echo $row['nm_bagian'];?>">
    </div>
  </div>

    </div>
    <div class="modal-footer">
      <a href="bagian.php" class="btn btn-danger btn-sm">Batal</a>
      <button type="submit" class="btn btn-info btn-sm" name="ubah">Simpan</button>
    </form>
    </div>
  </div>
</div>
</div>
<?php if(isset($script)){ echo $script; } ?>`
<!-- Tambah Data -->
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
      var message = "Nama Bagian tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);
 }else
 var mincar = 5;
  if (form.name.value.length < mincar){
     var message = "Nama Bagian minimal 5 karakter!";
     $('#alertModal').find('.modal-body h4').text(message);
     $('#alertModal').modal('show')
        return (false);
}else
  pola_wa=/^[A-Za-z\s]/;
   if (!pola_wa.test(form.name.value)){
    var message = "Nama Bagian tidak boleh mengandung simbol!";
    $('#alertModal').find('.modal-body h4').text(message);
    $('#alertModal').modal('show')
      return (false);
}
}
</script>
</body>
</html>