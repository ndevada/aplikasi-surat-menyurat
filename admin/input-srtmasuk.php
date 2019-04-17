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
    $cekno = mysqli_query($koneksi, "SELECT max(no_urut) as maxKode FROM tsuratmasuk where no_urut LIKE '%$today'");
    $data  = mysqli_fetch_array($cekno);
    $kd_instansi = $data['maxKode'];
    $noUrut = (int) substr($kd_instansi, 0, 3);
    $noUrut++;
    $char = "DISKOMINFOTIK";
    $newKD = sprintf("%03s", $noUrut).'/'. $char. '/'. $today;
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
      if(isset($_POST['input'])){
        $no_urut        = $_POST['no_urut'];
        $tgl_surat      = date('Y-m-d',strtotime($_POST['tgl_surat']));
        $nmr_surat      = strtoupper($_POST['nmr_surat']);
        $kd_instansi    = $_POST['kd_instansi'];
        $tgl_diterima   = date('Y-m-d',strtotime($_POST['tgl_diterima']));
        $perihal        = strtoupper($_POST['perihal']);
        $catatan        = strtoupper($_POST['catatan']);
        $kd_simpan      = $_POST['kd_simpan'];
        $kd_detail      = $_POST['kd_detail'];
        $ganti          = "-";

        $check = mysqli_prepare($koneksi, "SELECT * FROM tsuratmasuk WHERE nmr_surat=?");

          mysqli_stmt_bind_param($check, 's', $nmr_surat);
          mysqli_stmt_execute($check);

        $result=mysqli_stmt_get_result($check);
        $num_rows=mysqli_num_rows($result);

      if($num_rows == 0){
        
        if($tgl_surat <= $tgl_diterima){
          $check = mysqli_prepare($koneksi, "INSERT INTO tsuratmasuk (no_urut, tgl_surat, nmr_surat, tgl_diterima, kd_instansi, perihal, catatan, kd_simpan, kd_detail) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            mysqli_stmt_bind_param($check, 'sssssssss', $no_urut, $tgl_surat, $nmr_surat, $tgl_diterima, $kd_instansi, $perihal, $catatan, $kd_simpan, $kd_detail);
            mysqli_stmt_execute($check);
          echo "<script>alert('Surat masuk berhasil disimpan!'); window.location = 'surat-masuk.php'</script>";
        } else{
          $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Tanggal yang anda masukan salah..!</div>";
          $script =  "<script> $(document).ready(function(){ $('#tambahData').modal('show'); }); </script>";
          }
      } else{
        $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Nomor surat sudah ada..!</div>";
        $script =  "<script> $(document).ready(function(){ $('#tambahData').modal('show'); }); </script>";
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
<div class="modal fade bs-example-modal-lg" data-keyboard="false"  data-backdrop="static" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Tambah Surat Masuk</h4>
    </div>
    <div class="modal-body">
    <?php if(isset($error_msg)){ echo $error_msg; } ?>
    <form class="form" action="" onSubmit="return validasi_input(this)" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <div style="display:none">  
    <input class ="form-control" name="no_urut" data-toggle="tooltip" data-placement="top" title="Nomor urut surat" value="<?php echo $newKD; ?>" required readonly>
    </div>
      <div class ="col-sm-6">
        <div class ="input-group form-group label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">looks_one</i>
		  </span>
			    <label for="no_urut" class="control-label">NOMOR SURAT MASUK *</label>
				    <input type="text" class ="form-control" value="<?php echo isset($nmr_surat) ? $nmr_surat : ''; ?>" name="nmr_surat" id="name">
		    </div>
      </div>

      <?php
      $tgl = date('d-m-Y');
      ?>
      <div class ="col-sm-6">
             <div class ="input-group form-group label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">date_range</i>
		  </span>
			    <label for="no_urut" class="control-label">TANGGAL SURAT MASUK *</label>
				    <input id="tanggalmsk" class="datepicker form-control" type="text" name="tgl_surat" value="<?php echo isset($tgl_surat) ? date('d-m-Y',strtotime($tgl_surat)) : ''; ?>" readonly> 
		    </div>
      </div>
    
      <div class="col-sm-6">
      <div class ="input-group form-group has-feedback label-floating">
         <span class="input-group-addon">
          <i class="material-icons">domain</i>
    </span>
    <label class="control-label" for="selectbasic">PILIH PENGIRIM SURAT *</label>
    <?php
        echo "<select name='kd_instansi' id='instansi' class='form-control'>
        <option value=''</option>";
        $tampil = mysqli_query($koneksi, "SELECT * FROM minstansi");
        while ($r=mysqli_fetch_array($tampil)){
        echo "<option value='$r[kd_instansi]'>$r[nm_instansi]</option>";	
        }
        echo "</select>";
      ?>
    </div>
    </div>

     <div class ="col-sm-6">
        <div class ="input-group form-group label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">date_range</i>
		  </span>
			    <label for="no_urut" class="control-label">TANGGAL SURAT DITERIMA *</label>
				    <input class="datepicker form-control" id="tanggaldtr" type="text" value="<?php echo isset($tgl_diterima) ? date('d-m-Y',strtotime($tgl_diterima)) : ''; ?>" name="tgl_diterima" readonly> 
		    </div>
      </div>
      

    <div class="col-md-12">
    <div class ="input-group form-group has-feedback label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">looks_one</i>
		  </span>
			    <label for="no_urut" class="control-label">PERIHAL SURAT *</label>
				    <input type ="text" class ="form-control" id="perihal" name="perihal" value="<?php echo isset($perihal) ? $perihal : ''; ?>">
		    </div>
    </div>

    <div class ="col-sm-6">
        <div class ="input-group form-group has-feedback label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">mail_outline</i>
		  </span>
			    <label for="perihal" class="control-label has-feedback">CATATAN *</label>
				    <textarea class ="form-control" name="catatan" id="catatan" rows="5" <?php echo isset($catatan) ? ($catatan) : ''; ?>></textarea>
		    </div>
      </div>
      
      <div class="col-sm-6">
      <div class ="input-group form-group has-feedback label-floating">
        <span class="input-group-addon">
          <i class="material-icons">save</i>
        </span>
          <label class="control-label" for="selectbasic">PILIH TEMPAT PENYIMPANAN *</label>
            <?php
              echo "<select name='kd_simpan' id='tempat' class='form-control'>
               <option value=''></option>";
                $tampil = mysqli_query($koneksi, "SELECT * FROM mpnympn");
                while ($r=mysqli_fetch_array($tampil)){
               echo "<option value='$r[kd_simpan]'>$r[nm_simpan]</option>";	
               }
               echo "</select>";
              ?>
</div>

<div class ="input-group form-group has-feedback label-floating">
        <span class="input-group-addon">
          <i class="material-icons">save</i>
        </span>
        <label class="control-label" for="selectbasic">PILIH LOKASI TEMPAT PENYIMPANAN *</label>
        <select name="kd_detail" id="detail" class="form-control">

        </select>
</div>
      </div>

    </div>
    <div class="modal-footer">
    <div class="col-sm-12 text-right">
      <a href="surat-masuk.php" class="btn btn-danger btn-sm">Batal</a>
      <button type="submit" class="btn btn-info btn-sm" name="input">Simpan</button>
    </div>
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
<?php //include ("include/credit.php")?>

<script type="text/javascript">
$(function() {
    $([data-toggle="popover"])
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
<script type="text/javascript">
$(window).on('load',function(){
    $('#tambahData').modal('show');
});
</script>
<script>
    $(".readonly").keydown(function(e){
        e.preventDefault();
    });
</script>
<script>
  $(".alert-dismissable").fadeTo(10000, 500).slideUp(500, function(){
 $(".alert-dismissable").alert('close');
});
</script>
<!--<script>
var elmt = document.getElementById('name');

elmt.addEventListener('keydown', function (event) {
//    if (elmt.value.length === 0 && event.which === 32) {
//        event.preventDefault();
//    }
    if (event.which === 32) {
        elmt.value = elmt.value.replace(/^\s+/, '');
        if (elmt.value.length === 0) {
            event.preventDefault();
        }
    }
});
var elmt = document.getElementById('perihal');

elmt.addEventListener('keydown', function (event) {
//    if (elmt.value.length === 0 && event.which === 32) {
//        event.preventDefault();
//    }
    if (event.which === 32) {
        elmt.value = elmt.value.replace(/^\s+/, '');
        if (elmt.value.length === 0) {
            event.preventDefault();
        }
    }
});
var elmt = document.getElementById('catatan');

elmt.addEventListener('keydown', function (event) {
//    if (elmt.value.length === 0 && event.which === 32) {
//        event.preventDefault();
//    }
    if (event.which === 32) {
        elmt.value = elmt.value.replace(/^\s+/, '');
        if (elmt.value.length === 0) {
            event.preventDefault();
        }
    }
});
</script>-->
<script>
  function validasi_input(form){
    if (form.name.value == ""){
      var message = "Nomor surat tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);
  }else
       var mincar = 5;
        if (form.name.value.length < mincar){
          var message = "Nomor surat minimal 5 karakter!";
          $('#alertModal').find('.modal-body h4').text(message);
          $('#alertModal').modal('show')
          return (false);
  }else
  if (form.tanggalmsk.value == ""){
      var message = "Tanggal surat masuk tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false); 
  }else
  if (form.instansi.value == ""){
      var message = "Pengirim surat tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
  }else
  if (form.tanggaldtr.value == ""){
      var message = "Tanggal surat diterima tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
  }else
  if (form.perihal.value == ""){
      var message = "Perihal surat tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
  }else
  if (form.catatan.value == ""){
      var message = "Catatan surat tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
  }else
  if (form.tempat.value == ""){
      var message = "Tempat penyimpanan surat masuk tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
  }else
  if (form.detail.value == ""){
    var message = "Lokasi penyimpanan surat masuk tidak boleh kosong!";
    $('#alertModal').find('.modal-body h4').text(message);
    $('#alertModal').modal('show')
      return (false);   
  }
}
</script>
<script>
$(document).ready(function (){
    $('#tempat').change(function () {
        var kd_simpan = $(this).val();

            $.ajax({
                type : 'post',
                url  : 'detail.php',
                data : 'kd_simpan='+kd_simpan,
                success : function (response) {
                    $('#detail').html(response);
                }
            });
    })
});
</script>
</body>
</html>