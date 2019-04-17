<?php
session_name('surat');
session_start();
if (empty($_SESSION['username'])){
	header('location:../index.php');	
} else {
if($_SESSION['level']!=="admin"){
    die("Anda bukan admin");
} else {
	include "../config.php";
?>
<!DOCTYPE html>
<html lang="en">
<!-- Head  -->
    <?php include ("include/head.php")?>
    <style>
    hr {
    border: none;
    height: 3px;
    /* Set the hr color */
    color: #000; /* old IE */
    background-color: #000; /* Modern Browsers */
}
    </style>
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
    <div class="panel-body">
    <div class="col-xs-12">
        <div class="col-sm-3">
        <br>
        <br>
        <img src="logo.png" class="img-responsive center-block">
        </div>
        <div class="col-sm-9">
        <h1 class="text-left"><b>Dinas Komunikasi, Informatika, dan Statistik</b></h1>
        <hr>
        <!--<h2 class="text-left"><b>Kota Banjarmasin</b></h2>-->
        </div>
        <?php $tampil=mysqli_query($koneksi, "SELECT * FROM minstansi ORDER BY kd_instansi DESC");
                $total=mysqli_num_rows($tampil);
            ?>
        <div class="col-lg-3 col-xs-6 animated fadeIn">
            <div class ="small-box bg-gray">
                <div class="inner">
                <h3><?php echo $total; ?></h3>
                <p>Instansi</p>
            </div>
            <div class="icon"><br>
                <i class="fa fa-bank"></i>
            </div>
            <a href="instansi.php" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div>
         <?php $tampil1=mysqli_query($koneksi, "SELECT * FROM m_bagian ORDER BY kd_bagian DESC");
                        $total1=mysqli_num_rows($tampil1);
                    ?>
            <div class="col-lg-3 col-xs-6 animated fadeIn">
              <!-- small box -->
              <div class="small-box bg-gray">
                <div class="inner">
                  <h3><?php echo $total1; ?><!--<sup style="font-size: 20px">%</sup>--></h3>
                  <p>Bagian</p>
                </div>
                <div class="icon"><br>
                  <i class="fa fa-users"></i>
                </div>
                <a href="guru.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <?php $tampil2=mysqli_query($koneksi, "SELECT * FROM mjenis ORDER BY kd_jenis DESC");
                        $total2=mysqli_num_rows($tampil2);
                    ?>
            <div class="col-lg-3 col-xs-6 animated fadeIn">
              <!-- small box -->
              <div class="small-box bg-gray">
                <div class="inner">
                  <h3><?php echo $total2; ?></h3>
                  <p>Jenis Surat</p>
                </div>
                <div class="icon"><br>
                  <i class="fa fa-list-ul"></i>
                </div>
                <a href="jpel.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
            <?php $tampil4=mysqli_query($koneksi, "SELECT * FROM tsuratmasuk ORDER BY no_urut DESC");
                        $total4=mysqli_num_rows($tampil4);
                    ?>
            <div class="col-lg-3 col-xs-6 animated fadeIn">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h3><?php echo $total4; ?></h3>
                  <p>Surat Masuk</p>
                </div>
                <div class="icon"><br>
                  <i class="fa fa-envelope"></i>
                </div>
                <a href="tpel.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <?php $tampil5=mysqli_query($koneksi, "SELECT * FROM tsuratkeluar ORDER BY kode_srtkeluar DESC");
                        $total5=mysqli_num_rows($tampil5);
                    ?>
            <div class="col-lg-3 col-xs-6 animated fadeIn">
            <div class ="small-box bg-blue">
                <div class="inner">
                <h3><?php echo $total5; ?></h3>
                <p>Surat Keluar</p>
            </div>
            <div class="icon"><br>
                <i class="fa fa-envelope"></i>
            </div>
            <a href="instansi.php" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <?php $tampil6=mysqli_query($koneksi, "SELECT * FROM disposisi ORDER BY id_disposisi DESC");
                        $total6=mysqli_num_rows($tampil6);
                    ?>
        <div class="col-lg-3 col-xs-6 animated fadeIn">
            <div class ="small-box bg-blue">
                <div class="inner">
                <h3><?php echo $total6; ?></h3>
                <p>Disposisi Surat</p>
            </div>
            <div class="icon"><br>
                <i class="fa fa-spin fa-refresh"></i>
            </div>
            <a href="instansi.php" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div>
    </div>
        </div>
<!-- credit -->
<?php include("include/credit-index.php")?>
<!-- credit -->
<script type="text/javascript">
$(function() {
    $([data-toggle="popover"])
    });
</script>
</body>
</html>