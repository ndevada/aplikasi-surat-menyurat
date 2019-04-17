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
    $cekno = mysqli_query($koneksi, "SELECT max(kode_srtkeluar) as maxKode FROM tsuratkeluar where kode_srtkeluar LIKE '%$today'");
    $data  = mysqli_fetch_array($cekno);
    $kd_instansi = $data['maxKode'];
    $noUrut = (int) substr($kd_instansi, 0, 3);
    $noUrut++;
    //$char = "DISKOMINFOTIK";
    $newKD = sprintf("%03s", $noUrut).'/'. $today;
?>
<!DOCTYPE html>
<html lang="en">
<!-- Head  -->
    <?php include ("include/head.php")?>
    <style>
    .modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
    </style>
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
          $id = $_GET['id'];
          $select = "SELECT * FROM tsuratkeluar WHERE kode_srtkeluar =?";
          $check  = mysqli_prepare($koneksi, $select);
          
              mysqli_stmt_bind_param($check, 's', $id);
              mysqli_stmt_execute($check);

          $result = mysqli_stmt_get_result($check);
          $num_row = mysqli_num_rows($result);

          if ($num_row == 0){
                echo "<script>alert('Data Tidak Ditemukan'); window.location = 'surat-masuk.php'</script>";
          }else{
            $row = mysqli_fetch_assoc($result);
          }

      if(isset($_POST['ubah'])){
        $kode_srtkeluar = $_POST['kode_srtkeluar'];
        $tgl_surat      = date('Y-m-d',strtotime($_POST['tgl_surat']));
        $no_surat       = strtoupper($_POST['no_surat']);
        $kd_instansi    = $_POST['kd_instansi'];
        $kd_jenis       = $_POST['kd_jenis'];
        //$tgl_diterima   = date('Y-m-d',strtotime($_POST['tgl_diterima']));
        $perihal        = strtoupper($_POST['perihal']);
        //$catatan        = $_POST['catatan'];
        //$kd_simpan      = $_POST['kd_simpan'];
        //$ganti          = "-";

        $check = mysqli_prepare($koneksi, "SELECT * FROM tsuratkeluar WHERE kode_srtkeluar=? AND tgl_surat=? AND no_surat=? AND kd_instansi=? AND kd_jenis=? AND perihal=?");

          mysqli_stmt_bind_param($check, 'ssssss', $kode_srtkeluar, $tgl_surat, $no_surat, $kd_instansi, $kd_jenis, $perihal);
          mysqli_stmt_execute($check);

        $result=mysqli_stmt_get_result($check);
        $num_rows=mysqli_num_rows($result);

      if($num_rows == 0){
        
        $check=mysqli_prepare($koneksi, "UPDATE tsuratkeluar SET tgl_surat=?, no_surat=?, kd_instansi=?, kd_jenis=?, perihal=? WHERE kode_srtkeluar=?");
      
        mysqli_stmt_bind_param($check, 'ssssss', $tgl_surat, $no_surat, $kd_instansi, $kd_jenis, $perihal, $kode_srtkeluar);
        mysqli_stmt_execute($check);
        echo "<script>alert('Surat keluar berhasil disimpan!'); window.location = 'surat-keluar.php'</script>";
        } else{
        $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Data sama..!</div>";
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
<div class="modal fade bs-example-modal-lg" data-keyboard="false" data-backdrop="static" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Ubah Surat Keluar</h4>
    </div>
    <div class="modal-body">
    <?php if(isset($error_msg)){ echo $error_msg; } ?>
    <form class="form" onSubmit="return validasi_input(this)" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <div style="display:none">  
    <input class ="form-control" name="kode_srtkeluar" data-toggle="tooltip" data-placement="top" title="Nomor urut surat" value="<?php echo $row['kode_srtkeluar']; ?>" required readonly>
    </div>
      <div class ="col-sm-6">
        <div class ="input-group form-group has-feedback label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">looks_one</i>
		  </span>
			    <label for="no_urut" class="control-label">NOMOR SURAT KELUAR *</label>
				    <input type="text" class ="form-control" value="<?php echo $row['no_surat']; ?>" name="no_surat" id="name">
		    </div>
      </div>
      
      <?php
          $sql = "SELECT * FROM tsuratkeluar WHERE kode_srtkeluar='$_GET[id]'";
          $edit = $koneksi->query($sql);
          $r = $edit->fetch_assoc();
      ?>

      <div class ="col-sm-6">
             <div class ="input-group form-group label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">date_range</i>
		  </span>
			    <label for="no_urut" class="control-label">TANGGAL SURAT KELUAR *</label>
				    <input class="datepicker form-control" type="text" id="tglsurat" name="tgl_surat" value="<?php echo date('d-m-Y',strtotime($row['tgl_surat'])); ?>" readonly> 
		    </div>
      </div>

      <div class="col-sm-6">
      <div class ="input-group form-group has-feedback label-floating">
         <span class="input-group-addon">
          <i class="material-icons">domain</i>
    </span>
    <label class="control-label" for="selectbasic">PILIH JENIS SURAT *</label>
    <select name='kd_jenis' class='form-control' id="jenis">
    <?php
    	$sql="SELECT * FROM mjenis ORDER BY nm_jenis";
      $jenis = $koneksi->query($sql);
        while ($ra = $jenis->fetch_assoc()) {
          if($r[kd_jenis]==$ra[kd_jenis]){
        echo " <option value='$ra[kd_jenis]' selected>$ra[nm_jenis]</option>";
        } else {
          echo "<option value='$ra[kd_jenis]'>$ra[nm_jenis]</option>";
        }
      }
      ?>
      </select>
    </div>
    </div>
    
      <div class="col-sm-6">
      <div class ="input-group form-group has-feedback label-floating">
         <span class="input-group-addon">
          <i class="material-icons">domain</i>
    </span>
    <label class="control-label" for="selectbasic">PILIH PENERIMA SURAT *</label>
    <select name='kd_instansi' class='form-control' id="instansi">
    <?php
        	$sql="SELECT * FROM minstansi ORDER BY nm_instansi";
          $instansi = $koneksi->query($sql);
            while ($ra = $instansi->fetch_assoc()) {
              if($r[kd_instansi]==$ra[kd_instansi]){
            echo " <option value='$ra[kd_instansi]' selected>$ra[nm_instansi]</option>";
            } else {
              echo "<option value='$ra[kd_instansi]'>$ra[nm_instansi]</option>";
            }
          }
      ?>
      </select>
    </div>
    </div>

    <div class ="col-sm-12">
    <div class ="input-group form-group has-feedback label-floating">
       <span class="input-group-addon">
        <i class="material-icons">mail_outline</i>
  </span>
      <label for="perihal" class="control-label has-feedback">PERIHAL *</label>
        <textarea class ="form-control" name="perihal" id="perihal" rows="5"><?php echo $row['perihal']; ?></textarea>
    </div>
  </div>

    </div>
    <div class="modal-footer">
    <div class="col-sm-12 text-right">
      <a href="surat-keluar.php" class="btn btn-danger btn-sm">Batal</a>
      <button type="submit" class="btn btn-info btn-sm" name="ubah">Simpan</button>
    </div>
    </form>
    </div>
  </div>
</div>
</div>
<?php if(isset($script)){ echo $script; } ?>
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
  if (form.tglsurat.value == ""){
      var message = "Tanggal surat masuk tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false); 
  }else
  if (form.jenis.value == ""){
      var message = "Jenis surat tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
  }else
  if (form.instansi.value == ""){
      var message = "Penerima surat tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
  }else
  if (form.perihal.value == ""){
      var message = "Perihal surat tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);   
}
}
</script>
</body>
</html>