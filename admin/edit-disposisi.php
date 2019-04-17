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
    $cekno = mysqli_query($koneksi, "SELECT max(id_disposisi) as maxKode FROM disposisi where id_disposisi LIKE '%$today'");
    $data  = mysqli_fetch_array($cekno);
    $kd_instansi = $data['maxKode'];
    $noUrut = (int) substr($kd_instansi, 0, 4);
    $noUrut++;
    $char = "DISPOSISI";
    $newKD = sprintf("%04s", $noUrut).'/'. $char. '/'. $today;
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
         $select = "SELECT * FROM disposisi D INNER JOIN tsuratmasuk T ON D.urut = T.no_urut INNER JOIN m_bagian B on D.kd_bagian = B.kd_bagian INNER JOIN minstansi I on T.kd_instansi=I.kd_instansi WHERE id_disposisi=?";
         $check  = mysqli_prepare($koneksi, $select);
         
             mysqli_stmt_bind_param($check, 's', $id);
             mysqli_stmt_execute($check);

         $result = mysqli_stmt_get_result($check);
         $num_row = mysqli_num_rows($result);

         if ($num_row == 0){
               echo "<script>alert('Data Tidak Ditemukan'); window.location = 'disposisi.php'</script>";
         }else{
           $row = mysqli_fetch_assoc($result);
         }    
      if(isset($_POST['input'])){
        $no_urut        = $_POST['no_urut'];
        $id_disposisi   = $_POST['id_disposisi'];
        //$tgl_surat      = date('Y-m-d',strtotime($_POST['tgl_surat']));
        //$nmr_surat      = strtoupper($_POST['nmr_surat']);
        //$kd_instansi    = $_POST['kd_instansi'];
        //$tgl_diterima   = date('Y-m-d',strtotime($_POST['tgl_diterima']));
        $sifat          = strtoupper($_POST['sifat']);
        $kd_bagian      = $_POST['kd_bagian'];
        $tgpn           = strtoupper($_POST['tgpn']);
        $isi            = strtoupper($_POST['isi']);
        //$perihal        = strtoupper($_POST['perihal']);
        //$catatan        = $_POST['catatan'];
        //$kd_simpan      = $_POST['kd_simpan'];
        //$today_date     = date('d-m-Y');
        //$valid_date     = strtotime($today_date);
        $ganti          = "-";
        //$current_date   = strtotime($today_date);

        $check = mysqli_prepare($koneksi, "SELECT * FROM disposisi WHERE urut=? AND id_disposisi=? AND sifat=? AND kd_bagian=? AND tgpn=? AND isi=?");

          mysqli_stmt_bind_param($check, 'ssssss', $no_urut, $id_disposisi, $sifat, $kd_bagian, $tgpn, $isi);
          mysqli_stmt_execute($check);

        $result=mysqli_stmt_get_result($check);
        $num_rows=mysqli_num_rows($result);

      if($num_rows == 0){
        
        if((empty($tgpn)) && (empty($sifat))){
            $sifat = $ganti;
            $tgpn  = $ganti;
            $check = mysqli_prepare($koneksi, "UPDATE disposisi SET urut=?, sifat=?, kd_bagian=?, tgpn=?, isi=? WHERE id_disposisi=?");
            
            mysqli_stmt_bind_param($check, 'ssssss', $no_urut, $sifat, $kd_bagian, $tgpn, $isi, $id_disposisi);
            mysqli_stmt_execute($check);
          echo "<script>alert('Disposisi berhasil disimpan!'); window.location = 'disposisi.php'</script>";
        }elseif(empty($sifat)){
          $sifat = $ganti;
          $check = mysqli_prepare($koneksi, "UPDATE disposisi SET urut=?, sifat=?, kd_bagian=?, tgpn=?, isi=? WHERE id_disposisi=?");
            
            mysqli_stmt_bind_param($check, 'ssssss', $no_urut, $sifat, $kd_bagian, $tgpn, $isi, $id_disposisi);
            mysqli_stmt_execute($check);
          echo "<script>alert('Disposisi berhasil disimpan!'); window.location = 'disposisi.php'</script>";
        }elseif(empty($tgpn)){
          $tgpn = $ganti;
          $check = mysqli_prepare($koneksi, "UPDATE disposisi SET urut=?, sifat=?, kd_bagian=?, tgpn=?, isi=? WHERE id_disposisi=?");
            
          mysqli_stmt_bind_param($check, 'ssssss', $no_urut, $sifat, $kd_bagian, $tgpn, $isi, $id_disposisi);
            mysqli_stmt_execute($check);
          echo "<script>alert('Disposisi berhasil disimpan!'); window.location = 'disposisi.php'</script>";
        }else{
            $check = mysqli_prepare($koneksi, "UPDATE disposisi SET urut=?, sifat=?, kd_bagian=?, tgpn=?, isi=? WHERE id_disposisi=?");
            
            mysqli_stmt_bind_param($check, 'ssssss', $no_urut, $sifat, $kd_bagian, $tgpn, $isi, $id_disposisi);
            mysqli_stmt_execute($check);
          echo "<script>alert('Disposisi berhasil disimpan!'); window.location = 'disposisi.php'</script>";
        }
        //else {
        //  $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Nomor Surat Sudah Ada..!</div>";
         // $script =  "<script> $(document).ready(function(){ $('#tambahData').modal('show'); }); </script>";
       // }
      } else{
        $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Disposisi sudah ada..!</div>";
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
                <button class="btn btn-danger btn-default" id="btl" data-dismiss="modal">
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
      <h5 class="modal-title" id="myModalLabel">Ubah Disposisi Surat</h4>
    </div>
    <div class="modal-body">
    <?php if(isset($error_msg)){ echo $error_msg; } ?>
    <form class="form" onSubmit="return validasi_input(this)" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <div style="display:none">  
    <input class ="form-control" name="no_urut" data-toggle="tooltip" data-placement="top" title="Nomor urut surat" value="<?php echo $row['no_urut']; ?>" required readonly>
    <input class ="form-control" name="id_disposisi" data-toggle="tooltip" data-placement="top" title="Nomor urut surat" value="<?php echo $row['id_disposisi']; ?>" required readonly>
    </div>
    <div class="alert alert-danger">
    <div class="container-fluid">
	  <b>PERIHAL SURAT:</b> <?php echo $row['perihal'].' - '.$row['nm_instansi']; ?>
    </div>
</div>

    <div class="col-sm-12">
       <div class ="input-group form-group label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">looks_one</i>
		  </span>
			<label class="control-label" for="selectbasic">PILIH SIFAT (KOSONGKAN BILA TIDAK PERLU)</label>
			<select name="sifat" class="form-control">
			<option value=""></option>
                <?php if($row['sifat']==strtoupper("Sangat Segera")) { ?>
		        <option value="Sangat segera" selected>Sangat Segera</option>
                <option value="Segera">Segera</option>
                <option value="Rahasi">Rahasia</option>
                <?php } elseif($row['sifat']==strtoupper("segera")) { ?>
		        <option value="Sangat segera">Sangat Segera</option>
                <option value="Segera" selected>Segera</option>
                <option value="Rahasi">Rahasia</option>
                <?php } elseif($row['sifat']==strtoupper("Rahasia")) { ?>
		        <option value="Sangat segera">Sangat Segera</option>
                <option value="Segera">Segera</option>
                <option value="Rahasi" selected>Rahasia</option>
                <?php } else { ?>
		        <option value="Sangat segera">Sangat Segera</option>
                <option value="Segera">Segera</option>
                <option value="Rahasi">Rahasia</option>
                <?php } ?>
					</select>
			</div>
      </div>
           
      <div class="col-sm-12">
        <div class ="input-group form-group label-floating">
          <span class="input-group-addon">
            <i class="material-icons">looks_two</i>
      </span>
          <label class="control-label" for="selectbasic">DENGAN HORMAT HARAP (KOSONGKAN BILA TIDAK PERLU)</label>
             <select name="tgpn" class="form-control">
             <option value=""></option>
             <?php if($row['tgpn']==strtoupper("Tanggapan dan Saran")) { ?>
             <option value="Tanggapan dan saran" selected>Tanggapan dan saran</option>
             <option value="Proses lebih lanjut">Proses lebih lanjut</option>
             <option value="Koordinasi/konfirmasikan">Koordinasi/konfirmasikan</option>
             <?php } elseif($row['tgpn']==strtoupper("Proses lebih lanjut")) { ?>
             <option value="Tanggapan dan saran">Tanggapan dan saran</option>
             <option value="Proses lebih lanjut" selected>Proses lebih lanjut</option>
             <option value="Koordinasi/konfirmasikan">Koordinasi/konfirmasikan</option>
             <?php } elseif($row['tgpn']==strtoupper("Koordinasi/konfirmasikan")) { ?>
             <option value="Tanggapan dan saran">Tanggapan dan saran</option>
             <option value="Proses lebih lanjut">Proses lebih lanjut</option>
             <option value="Koordinasi/konfirmasikan" selected>Koordinasi/konfirmasikan</option>
             <?php } else { ?>
             <option value="Tanggapan dan saran">Tanggapan dan saran</option>
             <option value="Proses lebih lanjut">Proses lebih lanjut</option>
             <option value="Koordinasi/konfirmasikan">Koordinasi/konfirmasikan</option>
             <?php } ?>
     </select>
 </div>
      </div>
      <?php
          $sql = "SELECT * FROM disposisi WHERE id_disposisi='$_GET[id]'";
          $edit = $koneksi->query($sql);
          $r = $edit->fetch_assoc();
      ?>
      <div class="col-sm-12">
	      <div class="input-group form-group label-floating">
		     <span class="input-group-addon">
			      <i class="material-icons">group</i>
		  </span>
    	<label class="control-label" for="selectbasic">TUJUAN DISPOSISI *</label>
            <select name='kd_bagian' class='form-control' id="tujuan">
            <?php
			$sql="SELECT * FROM m_bagian ORDER BY nm_bagian";
            $bagian = $koneksi->query($sql);
            while ($ra = $bagian->fetch_assoc()) {
                if($r[kd_bagian]==$ra[kd_bagian]){
                echo " <option value='$ra[kd_bagian]' selected>$ra[nm_bagian]</option>";
                } else {
                    echo "<option value='$ra[kd_bagian]'>$ra[nm_bagian]</option>";
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
              <label for="perihal" class="control-label has-feedback">CATATAN *</label>
                  <textarea class ="form-control" name="isi" id="isi" rows="5"><?php echo strip_tags($row['isi']); ?></textarea>
          </div>
    </div>


    </div>
    <div class="modal-footer">
    <div class="col-sm-12 text-right">
      <a href="disposisi.php" class="btn btn-danger btn-sm">Batal</a>
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
<script>
  function validasi_input(form){
    if (form.tujuan.value == ""){
      var message = "Tujuan disposisi tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false);
 }else
  if (form.isi.value == ""){
      var message = "Isi disposisi tidak boleh kosong!";
      $('#alertModal').find('.modal-body h4').text(message);
      $('#alertModal').modal('show')
        return (false); 
  }
}
</script>
</body>
</html>