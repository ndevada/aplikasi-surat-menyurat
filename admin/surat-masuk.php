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
    <?php include ("include/menu.php")?>
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
            Data Surat Masuk
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Halaman Awal ></a></li>
            <li class="active">Surat Masuk</li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">

              <div class="box box-primary">
                <div class="box-header">
                  <i class="fa fa-file-text-o"></i>
                  <h3 class="box-title">Surat Masuk</h3>
                  <div class="box-tools pull-right">
                  </div> 
                </div>
<!--Modal Laporan Mulai-->
<div class="box-body">
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Cetak Laporan Surat Masuk</h4>
	</div>
	<div class="modal-body">
		 <form role="form">
     <div class ="input-group form-group label-floating">
          <span class="input-group-addon">
           <i class="material-icons">print</i>
      </span>
          <label class="control-label" for="selectbasic">PILIH LAPORAN YANG INGIN DI CETAK</label>
             <select id="pilih" class="form-control">
             <option value=""></option>
                        <option value="lprslr">Laporan Seluruh Surat Masuk</option>
    					<option value="lprtgl">Laporan Surat Per Periode</option>
    					<option value="lprnow">Laporan Surat Masuk Hari Ini</option>
     </select>
 </div>
 
                </form>   
    </div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">BATAL</button>
	</div>
</div>
</div>
</div>
<!--Modal Laporan Selesai-->

<div id="laporantgl" class="modal fade tes" data-backdrop="static" id="aa" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cetak Laporan Surat Masuk Per Periode</h4>
            </div>
            <div class="modal-body">
            <form class="form" target="_blank" action="laporan/laporan_srtpertanggal.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                <div class ="input-group form-group label-floating">
                <span class="input-group-addon">
			            <i class="material-icons">date_range</i>
		            </span>
			          <label for="no_urut" class="control-label">DARI TANGGAL</label>
				          <input id="tanggalmsk" class="datepicker form-control" type="text" name="dari" readonly> 
		          </div>

                <div class ="input-group form-group label-floating">
                <span class="input-group-addon">
			            <i class="material-icons">date_range</i>
		            </span>
			          <label for="no_urut" class="control-label">SAMPAI TANGGAL</label>
				          <input id="tanggalmsk" class="datepicker form-control" type="text" name="sampai" readonly> 
		          </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-default" id="btl" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-default btn-defaukt" name="cetak">Cetak</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->    

            <?php
             if(isset($_GET['aksi']) == 'delete'){
              $id = $_GET['id'];
              $data = "SELECT no_urut FROM tsuratmasuk WHERE no_urut=?";
              $del  = mysqli_prepare($koneksi, $data);

                mysqli_stmt_bind_param($del, 's', $id);   
                mysqli_stmt_execute($del);

              $result = mysqli_stmt_get_result($del);
              $check  = mysqli_num_rows($result);

                 if($check == 0){
                     echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert"   aria-hidden="true">&times;</button> Data tidak ditemukan.</div>';
                 }else{
                   $pro = "DELETE FROM tsuratmasuk WHERE no_urut=?";
                   $del =   mysqli_prepare($koneksi, $pro);

                    mysqli_stmt_bind_param($del, 's', $id);
                    mysqli_stmt_execute($del);

                      if($del){
                          echo '<div class="alert alert-primary alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Data berhasil dihapus.</div>';
                       }else{
                          echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Data gagal dihapus.</div>';
                       }
                 }
            }
                        
                   ?>
                   <a href="input-srtmasuk.php" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Tambah Surat Masuk</a>
                   <a data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-success pull-right"><i class="fa fa-file"></i> Cetak Laporan</a>
                   <br />
                   <br />
                     <table id="tsrtmasuk" class="table table-bordered table-condensed table-hover">  
                	     <thead bgcolor="87cefa">
                         <tr>
                         <th class="text-center">No</th>
                         <th class="text-center">No. Urut</th>
                         <th class="text-center">Nama Instansi</th>
                         <th class="text-center">Tanggal Diterima</th>
                         <th class="text-center">Perihal</th>
                         <th class="text-center">Catatan</th>
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
      $('#tsrtmasuk').DataTable( {
           "processing": true,
           "serverSide": true,
           "ajax": "ajax-srtmasuk.php",
       } );
   } );
   </script>
<script type="text/javascript">
$(function() {
    $([data-toggle="popover"])
    });
</script>
<script>
$('[data-toggle="tooltip"]').tooltip();
</script>
<script>

  $("#pilih").on("change", function () {        
      $modal = $('#laporantgl');
      if($(this).val() === 'lprtgl'){
        $modal.modal('show') && $('#myModal').modal('hide');
    }else
      if($(this).val() === 'lprslr'){
        window.open('laporan/laporan_srtmasuk.php','_blank');
    }else
      if($(this).val() === 'lprnow'){
        window.open('laporan/laporan_srtmskhari.php','_blank');
    }
 });

 $("#btl").click(function() {
    $('#myModal').modal('show');
});
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
</body>
</html>