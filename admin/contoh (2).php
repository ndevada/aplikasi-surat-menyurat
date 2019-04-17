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
        <section class="content-header">
          <br>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Halaman Awal ></a></li>
            <li><a href="instansi.php">Daftar Instansi ></a></li>
            <li class="active">Tambah Data Bagian</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">

              <!-- TO DO List -->
              <div class="box box-primary">
                <div class="box-header text-center">
                  <i class="material-icons">group_add</i>
                  <h3 class="title">Tambah Data Bagian</h3>
                  <div class="box-tools pull-right">
                  </div> 
                </div><!-- /.box-header -->
                <?php
      if(isset($_POST['input'])){
        $nm_bagian    = strtoupper($_POST['nm_bagian']);
 
        $cek = mysqli_prepare($koneksi, "SELECT * FROM m_bagian WHERE nm_bagian =?");
        mysqli_stmt_bind_param($cek, "s", $nm_bagian);
        mysqli_stmt_execute($cek);
        $reslut=mysqli_stmt_get_result($cek);
        $num_rows =mysqli_num_rows($reslut);
        if($num_rows == 0){
          $aaa= mysqli_prepare($koneksi, "INSERT INTO m_bagian VALUES (?)");
          mysqli_stmt_bind_param($aaa, "s", $nm_bagian);
          mysqli_stmt_execute($aaa);
        }else{
           echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Nama Bagian Sudah Ada..!</div>';
        }
      }
      ?>
            
    <div class="box-body">
      <form class="form-horizontal" data-toggle="validator" action="input-bagian.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
	      <div class ="form-group has-feedback">
			    <label for="nm_bagian" class="col-sm-2 control-label">Nama Bagian :</label>
			  <div class ="col-sm-10">
				  <input type ="text" pattern="[A-Za-z\s']{1,}$" data-minlength="3" maxlength="70" class ="form-control" name="nm_bagian" placeholder="Masukan Nama Bagian" required>
				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				  <div class="help-block">Minimal 3 karakter dan harus menggunakan huruf!</div>
			  </div>
		  </div>

  <div class="form-group">
      <label class="col-sm-2 col-sm-2 control-label"></label>
    <div class="col-sm-10 text-right">
      <input type="submit" name="input" value="Simpan" class="btn btn-sm btn-primary" />&nbsp;
	      <a href="bagian.php" class="btn btn-sm btn-danger">Batal </a>
    </div>
  </div>
</form>
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
</body>
</html>