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

              <!-- TO DO List -->
                </div><!-- /.box-header -->
      <?php
          $id = $_GET['id'];
          $select = "SELECT kd_simpan, nm_simpan FROM mpnympn WHERE kd_simpan=?";
          $check  = mysqli_prepare($koneksi, $select);

            mysqli_stmt_bind_param($check, 's', $id);
            mysqli_stmt_execute($check);

          $result = mysqli_stmt_get_result($check);
          $hitung = mysqli_num_rows($result);
          
            if ($hitung == 0){
              echo "<script>alert('Data Tidak Ditemukan'); window.location = 'penyimpanan.php'</script>";
            } else{
              $row = mysqli_fetch_assoc($result);
            }

             if(isset($_POST['ubah'])){
                $kd_simpan    = $_POST['kd_simpan'];
                $nm_simpan    = strtoupper($_POST['nm_simpan']);
                $data         = "SELECT nm_simpan FROM mpnympn WHERE nm_simpan=?";
                $query        = mysqli_prepare($koneksi, $data);

                  mysqli_stmt_bind_param($query, 's', $nm_simpan);
                  mysqli_stmt_execute($query);

                $hasil = mysqli_stmt_get_result($query);
                $valid = mysqli_num_rows($hasil);

              if ($valid == 0){
                $up    = "UPDATE mpnympn SET nm_simpan=? WHERE kd_simpan=?";
                $query = mysqli_prepare($koneksi, $up);

                  mysqli_stmt_bind_param($query, "ss", $nm_simpan, $kd_simpan);
                  mysqli_stmt_execute($query);
                  echo "<script>alert('Data Tempat Penyimpanan Surat berhasil disimpan!'); window.location = 'penyimpanan.php'</script>";                  
              }else{
                $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Tempat penyimpanan surat sudah ada..!</div>";
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
<!-- modal -->
    <div class="modal fade bs-example-modal-md" data-keyboard="false" data-backdrop="static" id="ubahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel">Ubah Data Tempat Penyimpanan Surat</h4>
    </div>
    <div class="modal-body">
    <?php if(isset($error_msg)){ echo $error_msg; } ?>
    <form class="form" onSubmit="return validasi_input(this)" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

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
        <input type ="text" class ="form-control" id="name" name="nm_simpan" value="<?php echo $row['nm_simpan']; ?>">
    </div>
  </div>

    </div>
    <div class="modal-footer">
      <a href="penyimpanan.php" class="btn btn-danger btn-sm">Batal</a>
      <button type="submit" class="btn btn-info btn-sm" name="ubah">Simpan</button>
    </form>
    </div>
  </div>
</div>
</div>
<?php if(isset($script)){ echo $script; } ?>
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
  function validasi_input(form)
  {
    if (form.name.value == "")
    {
      var message = "Nama tempat penyimpanan surat tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false)
    }else
      mincar = 5;
      if(form.name.value < mincar)
      {
        var message = "Nama tempat penyimpanan surat tidak boleh kurang dari 5 karakter!";
        $('#alertModal').find('.modal-body h4').text(message);
        $('#alertModal').modal('show')
          return (false)
      }else
        pola = /^[A-Za-z\s]/;
        if(!pola.test(form.name.value))
        {
          var message = "Nama tempat penyimpanan surat tidak boleh mengandung simbol..!";
          $('#alertModal').find('.modal-body h4').text(message);
          $('#alertModal').modal('show')
            return (false)
        }
  }
</script>
</body>
</html>