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
                    $id = $_GET['id'];
                    $select = "SELECT * FROM mpnympn WHERE kd_simpan=?";
                    $check  = mysqli_prepare($koneksi, $select);
                
                            mysqli_stmt_bind_param($check, 's', $id);
                            mysqli_stmt_execute($check);
                
                    $result = mysqli_stmt_get_result($check);
                    $row = mysqli_fetch_assoc($result);
$no = 1;
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
            Detail Tempat Penyimpanan Surat
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Halaman Awal</a></li>
            <li class="active">Detail Tempat Penyimpanan Surat</li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">

              <div class="box box-primary">
                <div class="box-header">
                  <i class="fa fa-file-text-o"></i>
                  <h3 class="box-title">Detail <?php echo ucwords(strtolower($row['nm_simpan']));?></h3>
                  <div class="box-tools pull-right">
                  </div> 
                </div>

                <div class="box-body">
<div class="modal fade bs-example-modal-md" data-keyboard="false" data-backdrop="static" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		 <div class="modal-dialog modal-md">
		   <div class="modal-content">
		     <div class="modal-header">
		       <h4 class="modal-title" id="myModalLabel">Tambah Data Tempat Peyimpanan Surat</h4>
		     </div>
		     <div class="modal-body">
		     <?php if(isset($error_msg)){ echo $error_msg; } ?>
		     <form class="tamb" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

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
		       <label for="no_urut" class="control-label">Nama Detail</label>
		         <input type ="text" class ="form-control" id="name" name="nm_detail">
		     </div>
		   </div>
		     </div>
		     <div class="modal-footer">
             <button class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
		       <button type="submit" class="btn btn-info btn-sm" id="input" name="input">Simpan</button>
		     </form>
		     </div>
		   </div>
		 </div>
		 </div>
		 <?php if(isset($script)){ echo $script; } ?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Cetak Laporan Surat Keluar</h4>
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
                        <option value="lprslr">Laporan Seluruh Surat Keluar</option>
    					<option value="lprtgl">Laporan Surat Keluar Per Periode</option>
    					<option value="lprnow">Laporan Surat Keluar Hari Ini</option>
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
                <h4 class="modal-title">Cetak Laporan Surat Keluar Per Periode</h4>
            </div>
            <div class="modal-body">
            <form class="form" target="_blank" action="laporan/laporan_srtpertanggalkl.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
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
                <button type="submit" class="btn btn-default" name="cetak">Cetak</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->    

                  <?php
                     if(isset($_GET['aksi']) == 'delete'){
        				        $id = $_GET['id'];
                        $data = "SELECT kd_detail FROM detail WHERE kd_detail=?";
                        $del  = mysqli_prepare($koneksi, $data);

                          mysqli_stmt_bind_param($del, 's', $id);   
                          mysqli_stmt_execute($del);

                        $result = mysqli_stmt_get_result($del);
                        $check  = mysqli_num_rows($result);

        			             if($check == 0){
                            echo "<script>alert('Data tidak ditemukan!');window.history.go(-1)</script>";
        			             }else{
                             $pro = "DELETE FROM detail WHERE kd_detail=?";
                             $del =   mysqli_prepare($koneksi, $pro);

                              mysqli_stmt_bind_param($del, 's', $id);
                              mysqli_stmt_execute($del);

        				                if($del){
        				    		          echo "<script>alert('Data berhasil dihapus!');window.history.go(-1)</script>";
        			   		            }else{
                                  echo "<script>alert('Data gagal di hapus!');window.history.go(-1)</script>";
              					         }
              				     }
                            }
                            
                            if(isset($_POST['input'])){
                                $nm_detail   = strtoupper($_POST['nm_detail']);
                                $kd_simpan   = $_POST['kd_simpan']; 
                                $select      = "SELECT * FROM detail WHERE nm_detail=?";
                                $query       = mysqli_prepare($koneksi, $select);
                        
                                  mysqli_stmt_bind_param($query, 's', $nm_detail);
                                  mysqli_stmt_execute($query);
                        
                                $result      = mysqli_stmt_get_result($query);
                                $hitung      = mysqli_num_rows($result);
                        
                              if($hitung == 0){
                                $data  = "INSERT INTO detail (nm_detail, kd_simpan) VALUES (?, ?)";
                                $query = mysqli_prepare($koneksi, $data);
                        
                                  mysqli_stmt_bind_param($query, 'ss', $nm_detail, $kd_simpan);
                                  mysqli_stmt_execute($query);
                                  echo "<script>alert('Detail tempat penyimpanan surat berhasil disimpan!');</script>";
                              }else{
                                echo "<script>alert('Detail tempat penyimpanan surat sudah ada!');</script>";
                                  }
                              }
          			   ?>
                   <div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                   </div>
                   <a data-toggle="modal" data-target="#tambahData" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Tambah Detail</a>
                   <br />
                   <br />
                     <table id="tsrtkeluar" class="table table-bordered table-hover table-condensed">  
                	     <thead bgcolor="87cefa">
                         <tr>
                         <th class="text-center">No.</th>
                         <th class="text-center">Nama Detail Tempat Penyimpanan</th>
                         <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
<?php
$query =mysqli_query($koneksi, "SELECT * FROM detail WHERE kd_simpan='$id'");
                    while($row = mysqli_fetch_assoc($query))
                    {
                        $nos       = $no++;
                        $kode      = $row['kd_detail'];
                        $nm        = $row['nm_detail'];
                        echo "
                            <tr>
                            <td class='text-center'>$nos</td>
                            <td class='text-center'>$nm</td>
                            <td class='text-center'><a class='open_modal btn btn-sm btn-primary' title='Edit' id='$row[kd_detail]' ><i class='fa fa-pencil-square' ></i></a>
                            <a href='detail-penyimpanan.php?aksi=delete&id=$kode'  data-toggle='tooltip' title='Delete' onclick='return confirm(\'Anda yakin akan menghapus surat untuk'?\)' class='btn btn-sm btn-danger'> <i class='fa fa-trash'></i> </a>
                            </td>
                        ";
                    }
?>
                  					 
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

<!--<script>
    $(document).ready(function() {
      $('#tsrtkeluar').DataTable( {
           "processing": true,
           "serverSide": true,
           "ajax": "ajax-srtkeluar.php",
       } );
   } );
   </script>-->
<script>
$(document).ready(function(){ $('#tsrtkeluar').DataTable(); }); 
</script>
<script type="text/javascript">
$(function() {
    $([data-toggle="popover"])
    });
</script>
<script>

$("#pilih").on("change", function () {        
    $modal = $('#laporantgl');
    if($(this).val() === 'lprtgl'){
      $modal.modal('show') && $('#myModal').modal('hide');
  }else
    if($(this).val() === 'lprslr'){
      window.open('laporan/laporan_srtkeluar.php','_blank');
  }else
    if($(this).val() === 'lprnow'){
      window.open('laporan/laporan_srtklrhari.php','_blank');
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
<script>

function validasi_input(form) 
{
  if(form.name.value == "")
  {
  var message = "Nama detail tempat penyimpanan surat tidak boleh kosong!";
  $('#alertModal').find('.modal-body h4').text(message);
  $('#alertModal').modal('show')
    return (false);
  }else
    var mincar = 5;
    if(form.name.value < mincar)
    {
      var message = "Nama detail tempat penyimpanan surat tidak boleh kurang dari 5 karakter!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);
    }else
      pola=/^[A-Za-z\s]/;
      if(!pola.test(form.name.value))
      {
        var message = "Nama detail tempat penyimpanan surat tidak boleh mengandung simbol!";
        $('#alertModal').find('.modal-body h4').text(message);
        $('#alertModal').modal('show')
          return(false);
      }
}

</script>
<script type="text/javascript">
   $(document).ready(function () {
   $(".open_modal").click(function(e) {
      var m = $(this).attr("id");
		   $.ajax({
    			   url: "modal-edit.php",
    			   type: "GET",
    			   data : {kd_detail: m,},
    			   success: function (ajaxData){
      			   $("#ModalEdit").html(ajaxData);
      			   $("#ModalEdit").modal('show',{backdrop: 'true'});
      		   }
    		   });
        });
      });
</script>
</body>
</html>