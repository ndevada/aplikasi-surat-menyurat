<?php
session_name('surat'); 
session_start();
if (empty($_SESSION['username'])){
	header('location:../index.php');	
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
<?php } ?>
<div class="panel-body">
        <section class="content-header">
          <h1 class="text-center">
            Data Master
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Halaman Awal ></a></li>
            <li class="active">Daftar Penyimpanan Surat</li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">

              <div class="box box-primary">
                <div class="box-header">
                  <i class="fa fa-file-text-o"></i>
                  <h3 class="box-title">Daftar Penyimpanan Surat</h3>
                  <div class="box-tools pull-right">
                  </div> 
                </div>

                <div class="box-body">

                  <?php
                     if(isset($_GET['aksi']) == 'delete'){
        				        $id   = $_GET['id'];
                        $data = "SELECT kd_simpan FROM mpnympn WHERE kd_simpan=?";
                        $del  = mysqli_prepare($koneksi, $data);

                          mysqli_stmt_bind_param($del, 's', $id);
                          mysqli_stmt_execute($del);

                        $result = mysqli_stmt_get_result($del);
                        $hitung = mysqli_num_rows($result);

                      if($hitung == 0){
                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert"   aria-hidden="true">&times;</button> Data tidak ditemukan.</div>';
                      }else{
                        $pro = "DELETE FROM mpnympn WHERE kd_simpan=?";
                        $del = mysqli_prepare($koneksi, $pro);

                          mysqli_stmt_bind_param($del, 's', $id);
                          mysqli_stmt_execute($del);
                          echo '<div class="alert alert-primary alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Data berhasil dihapus.</div>';                      
                      }
                      }
          			   ?>
                   <a href="input-penyimpanan.php" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Tambah Data</a>
                   <a href="laporan/laporan_penyimpanan.php" target="_blank" class="btn btn-sm btn-success pull-right"><i class="fa fa-file"></i> Cetak Laporan</a>
                   <br />
                   <br />
                     <table id="tsimpan" class="table table-bordered table-hover">  
                	     <thead bgcolor="87cefa">
                         <tr>
                         <th class="text-center" width="10%">No.</th>
                         <th class="text-center">Tempat Penyimpanan</th>
                    	 <th class="text-center" width="13%">Aksi</th> 
                  	  
                        </tr>
                      </thead>
                      <tbody>
                  	 
                  					 
                      </tbody>
                    </table>  
                </div>
                <div class="box-footer clearfix no-border">
                  
                </div>
              </div>

            </section>
          </div>

        </section>
      </div>
<?php include("include/credit.php")?>

<script>
          $(document).ready(function() {
  				var dataTable = $('#tsimpan').DataTable( {
            "responsive": true,
            "processing": true,
  					"serverSide": true, 
  					"ajax":{
  						url :"ajax-tempat.php", // json datasource
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
</body>
</html>