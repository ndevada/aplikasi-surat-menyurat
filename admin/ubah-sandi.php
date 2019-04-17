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
          $id = $_SESSION['user_id'];
          $select = "SELECT user_id, username, password, nama_user, level FROM tpengguna WHERE user_id=?";
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
                $user_id      = $_SESSION['user_id'];
                $passlama     = $_POST['passlama'];
                $passbaru     = $_POST['passbaru'];
                $newpass      = password_hash($passbaru, PASSWORD_BCRYPT, array(
                  'cost' => 10
                ));  
              /*  $data         = "SELECT user_id, password FROM tpengguna WHERE user_id=? AND password=?";
                $query        = mysqli_prepare($koneksi, $data);

                  mysqli_stmt_bind_param($query, 'ss', $user_id, $passlama);
                  mysqli_stmt_execute($query);

                $hasil = mysqli_stmt_get_result($query);
                $valid = mysqli_num_rows($hasil);*/

              if (password_verify($passlama, $row['password'])){
                  if($passlama != $passbaru){
                $up    = "UPDATE tpengguna SET password=? WHERE user_id=?";
                $query = mysqli_prepare($koneksi, $up);

                  mysqli_stmt_bind_param($query, "ss", $newpass, $user_id);
                  mysqli_stmt_execute($query);
                  echo "<script>alert('Password berhasil dirubah!'); window.location = 'index.php'</script>";
                  }else{
                    $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Password yang anda masukkan harus berbeda dengan password lama..!</div>";
                    $script =  "<script> $(document).ready(function(){ $('#tambahData').modal('show'); }); </script>";
                  }
              }else{
                $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Password lama yg anda masukkan salah..!</div>";
                $script =  "<script> $(document).ready(function(){ $('#tambahData').modal('show'); }); </script>";
              }
             }
      ?>
            
    <div class="box-body">
    <!-- Tambah Data -->
<div class="modal fade bs-example-modal-md" data-keyboard="false" data-backdrop="static" id="ubahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel">Ubah Kata Sandi</h4>
    </div>
    <div class="modal-body">
    <?php if(isset($error_msg)){ echo $error_msg; } ?>
    <form class="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

  <div class ="col-sm-12">
  <div class ="input-group form-group label-floating">
     <span class="input-group-addon">
      <i class="material-icons">group</i>
    </span>
    <label for="no_urut" class="control-label">NAMA PENGGUNA</label>
      <input type ="text" class ="form-control" name="nm_user" value="<?php echo $row['username']; ?>" readonly required>
  </div>
</div>

<div class ="col-sm-12">
    <div class ="input-group form-group has-feedback label-floating">
      <span class="input-group-addon">
        <i class="material-icons">lock</i>
      </span>
      <label for="no_urut" class="control-label">PASSWORD LAMA</label>
        <input type ="password" class ="form-control" data-minlength="3" maxlength="20" name="passlama" required>
    </div>
  </div>

  <div class ="col-sm-12">
    <div class ="input-group form-group has-feedback label-floating">
      <span class="input-group-addon">
        <i class="material-icons">lock</i>
      </span>
      <label for="no_urut" class="control-label">PASSWORD BARU</label>
        <input type ="password" class ="form-control" data-minlength="3" maxlength="20" name="passbaru" required>
    </div>
  </div>

    </div>
    <div class="modal-footer">
      <a href="index.php" class="btn btn-danger btn-sm">Batal</a>
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
</body>
</html>