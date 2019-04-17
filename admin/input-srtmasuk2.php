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

    $today = date("Y");
    $cekno = mysqli_query($koneksi, "SELECT max(no_urut) as maxKode FROM tsuratmasuk ORDER BY no_urut DESC");
    $data  = mysqli_fetch_array($cekno);
    $kd_instansi = $data['maxKode'];
    $noUrut = (int) substr($kd_instansi, 18, 3);
    $noUrut++;
    $char = "DISKOMINFOTIK/";
    $newKD = $char. $today. sprintf("%03s", $noUrut);
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
            <li><a href="surat-masuk.php">Daftar Instansi ></a></li>
            <li class="active">Tambah Surat Masuk</li>
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
                  <i class="material-icons">email</i>
                  <h3 class="title">Tambah Surat Masuk</h3>
                  <div class="box-tools pull-right">
                  </div> 
                </div><!-- /.box-header -->
                <?php
      if(isset($_POST['input'])){
        $no_urut        = $_POST['no_urut'];
        $tgl_surat      = $_POST['tgl_surat'];
        $nmr_surat      = $_POST['nmr_surat'];
        $kd_instansi    = $_POST['kd_instansi'];
        $tgl_diterima   = $_POST['tgl_diterima'];
        $sifat          = $_POST['sifat'];
        $kd_bidang      = $_POST['kd_bidang'];
        $tgpn           = $_POST['tgpn'];
        $perihal        = $_POST['perihal'];
        $cttn           = $_POST['cttn'];
        $tgl_bts        = $_POST['tgl_bts'];
        $tempat         = $_POST['tempat'];
        $kd_simpan      = $_POST['kd_simpan'];

        $check = mysqli_prepare($koneksi, "SELECT nmr_surat FROM tsuratmasuk WHERE nmr_surat=?");

          mysqli_stmt_bind_param($check, 's', $nmr_surat);
          mysqli_stmt_execute($check);

        $result=mysqli_stmt_get_result($check);
        $num_rows=mysqli_num_rows($result);

      if($num_rows == 0){

        $check=mysqli_prepare($koneksi, "INSERT INTO minstansi (kd_instansi, nm_instansi, almt_instansi) VALUES (?, ?, ?)");
          
          mysqli_stmt_bind_param($check, 'sss', $kd_instansi, $nm_instansi, $almt_instansi);
          mysqli_stmt_execute($check);

      if($check){ 
        echo "<script>alert('Surat Masuk berhasil disimpan!'); window.location = 'instansi.php'</script>";
      } else{
        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Ups, Surat Masuk Gagal Di simpan !</div>';
        }
      } else{
        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Nomor Surat Sudah Ada..!</div>';
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
      <form class="form-horizontal" data-toggle="validator" action="input-instansi.php" method="post" enctype="multipart/form-data" name="form1" id="form1">

      <div class ="form-group has-feedback">
			    <label for="nm_siswa" class="col-sm-2 control-label">Nomor Urut Surat</label>
			  <div class ="col-sm-4">
				 <input type ="text" class ="form-control" name="kd_instansi" value="<?php echo $newKD; ?>" required>
				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				  <div class="help-block">Minimal 3 karakter dan harus menggunakan huruf!</div>
			  </div>
               <label for="nm_siswa" class="col-sm-2 control-label">Nomor Surat</label>
			  <div class ="col-sm-4">
				 <input type ="text" class ="form-control" name="kd_instansi" value="<?php echo $newKD; ?>" required>
				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				  <div class="help-block">Minimal 3 karakter dan harus menggunakan huruf!</div>
            <label class="col-sm-2 col-sm-2 control-label"></label>
    <div class="col-sm-10 text-right">
      <input type="submit" name="input" value="Simpan" class="btn btn-sm btn-primary" />&nbsp;
	      <a href="instansi.php" class="btn btn-sm btn-danger">Batal </a>
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
<script>
$('.datepicker').datepicker({
  format: "dd-mm-yyyy",
	weekStart:1
});
</script>
</body>
</html>