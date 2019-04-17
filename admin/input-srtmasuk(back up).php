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
      if(isset($_POST['input'])){
        $no_urut        = $_POST['no_urut'];
        $tgl_surat      = date('Y-m-d',strtotime($_POST['tgl_surat']));
        $nmr_surat      = strtoupper($_POST['nmr_surat']);
        $kd_instansi    = $_POST['kd_instansi'];
        $tgl_diterima   = date('Y-m-d',strtotime($_POST['tgl_diterima']));
        $sifat          = strtoupper($_POST['sifat']);
        $kd_bagian      = $_POST['kd_bagian'];
        $tgpn           = strtoupper($_POST['tgpn']);
        $perihal        = strtoupper($_POST['perihal']);
        $catatan        = $_POST['catatan'];
        $kd_simpan      = $_POST['kd_simpan'];
        $today_date     = date('d-m-Y');
        $valid_date     = strtotime($today_date);
        $ganti          = "-";
        //$current_date   = strtotime($today_date);

        $check = mysqli_prepare($koneksi, "SELECT no_urut FROM tsuratmasuk WHERE no_urut=?");

          mysqli_stmt_bind_param($check, 's', $no_urut);
          mysqli_stmt_execute($check);

        $result=mysqli_stmt_get_result($check);
        $num_rows=mysqli_num_rows($result);

      if($num_rows == 0){
        
        if($sifat=" " && $tgl_surat <= $tgl_diterima){
          $sifat = $ganti;
          $check = mysqli_prepare($koneksi, "INSERT INTO tsuratmasuk (no_urut, tgl_surat, nmr_surat, tgl_diterima, sifat, kd_instansi, kd_bagian, perihal, catatan, tgpn, kd_simpan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            mysqli_stmt_bind_param($check, 'sssssssssss', $no_urut, $tgl_surat, $nmr_surat, $tgl_diterima, $sifat, $kd_instansi, $kd_bagian, $perihal, $catatan, $tgpn, $kd_simpan);
            mysqli_stmt_execute($check);
          echo "<script>alert('Surat masuk berhasil disimpan!'); window.location = 'surat-masuk.php'</script>";
        }  
        elseif($tgpn=" " && $tgl_surat <= $tgl_diterima){
          $tgpn = $ganti;
          $check= mysqli_prepare($koneksi, "INSERT INTO tsuratmasuk (no_urut, tgl_surat, nmr_surat, tgl_diterima, sifat, kd_instansi, kd_bagian, perihal, catatan, tgpn, kd_simpan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          
            mysqli_stmt_bind_param($check, 'sssssssssss', $no_urut, $tgl_surat, $nmr_surat, $tgl_diterima, $sifat, $kd_instansi, $kd_bagian, $perihal, $catatan, $tgpn, $kd_simpan);
            mysqli_stmt_execute($check);
          echo "<script>alert('Surat masuk berhasil disimpan!'); window.location = 'surat-masuk.php'</script>";
        }
        elseif($tgpn=" " && $sifat=" " && $tgl_surat <= $tgl_diterima){
          $tgpn  = $ganti;
          $sifat = $ganti;
          $check = mysqli_prepare($koneksi, "INSERT INTO tsuratmasuk (no_urut, tgl_surat, nmr_surat, tgl_diterima, sifat, kd_instansi, kd_bagian, perihal, catatan, tgpn, kd_simpan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          
            mysqli_stmt_bind_param($check, 'sssssssssss', $no_urut, $tgl_surat, $nmr_surat, $tgl_diterima, $sifat, $kd_instansi, $kd_bagian, $perihal, $catatan, $tgpn, $kd_simpan);
            mysqli_stmt_execute($check);
          echo "<script>alert('Surat masuk berhasil disimpan!'); window.location = 'surat-masuk.php'</script>";
        } 
        elseif($tgl_surat <= $tgl_diterima){
          $check = mysqli_prepare($koneksi, "INSERT INTO tsuratmasuk (no_urut, tgl_surat, nmr_surat, tgl_diterima, sifat, kd_instansi, kd_bagian, perihal, catatan, tgpn, kd_simpan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            mysqli_stmt_bind_param($check, 'sssssssssss', $no_urut, $tgl_surat, $nmr_surat, $tgl_diterima, $sifat, $kd_instansi, $kd_bagian, $perihal, $catatan, $tgpn, $kd_simpan);
            mysqli_stmt_execute($check);
          echo "<script>alert('Surat masuk berhasil disimpan!'); window.location = 'surat-masuk.php'</script>";
        } else{
          $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Tanggal yang anda masukan salah..!</div>";
          $script =  "<script> $(document).ready(function(){ $('#tambahData').modal('show'); }); </script>";
          }
        //else {
        //  $error_msg = "<div class='tambahData alert alert-danger alert-dismissable'><button type='button' class='close'data-dismiss='alert' aria-hidden='true'>&times;</button>Nomor Surat Sudah Ada..!</div>";
         // $script =  "<script> $(document).ready(function(){ $('#tambahData').modal('show'); }); </script>";
       // }
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

<!-- Tambah Data -->
<div class="modal fade bs-example-modal-lg" data-keyboard="false" data-backdrop="static" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">Tambah Surat Masuk</h4>
    </div>
    <div class="modal-body">
    <?php if(isset($error_msg)){ echo $error_msg; } ?>
    <form class="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <div style="display:none">  
    <input class ="form-control" name="no_urut" data-toggle="tooltip" data-placement="top" title="Nomor urut surat" value="<?php echo $newKD; ?>" required readonly>
    </div>
      <div class ="col-sm-6">
        <div class ="input-group form-group has-feedback label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">looks_one</i>
		  </span>
			    <label for="no_urut" class="control-label">NOMOR SURAT MASUK *</label>
				    <input type ="text" class ="form-control" value="<?php echo isset($nmr_surat) ? $nmr_surat : ''; ?>" name="nmr_surat" required>
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
				    <input class="datepicker form-control" type="text" name="tgl_surat" value="<?php echo isset($tgl_surat) ? date('d-m-Y',strtotime($tgl_surat)) : ''; ?>" readonly required> 
		    </div>
      </div>
    
        <div class="col-sm-6">
       <div class ="input-group form-group label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">looks_two</i>
		  </span>
			<label class="control-label" for="selectbasic">PILIH SIFAT SURAT (KOSONGKAN BILA TIDAK PERLU)</label>
					<select name="sifat" class="form-control">
					<option value=""></option>
				  <option value="Sangat segera">Sangat Segera</option>
          <option value="Segera">Segera</option>
          <option value="Rahasi">Rahasia</option>
					</select>
			</div>
      </div>

     <div class ="col-sm-6">
        <div class ="input-group form-group label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">date_range</i>
		  </span>
			    <label for="no_urut" class="control-label">TANGGAL SURAT DITERIMA *</label>
				    <input class="datepicker form-control readonly" type="text" value="<?php echo isset($tgl_diterima) ? date('d-m-Y',strtotime($tgl_diterima)) : ''; ?>" name="tgl_diterima" required> 
		    </div>
      </div>
      
      <div class="col-sm-6">
        <div class ="input-group form-group label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">domain</i>
		  </span>
			<label class="control-label" for="selectbasic">PILIH PENGIRIM SURAT *</label>
			<?php
					echo "<select name='kd_instansi' class='form-control' required>
					<option value=''</option>";
					$tampil = mysqli_query($koneksi, "SELECT * FROM minstansi");
					while ($r=mysqli_fetch_array($tampil)){
					echo "<option value='$r[kd_instansi]'>$r[nm_instansi]</option>";	
					}
					echo "</select>";
				?>
			</div>
      </div>
      
      <div class="col-sm-6">
	      <div class="input-group form-group label-floating">
		     <span class="input-group-addon">
			      <i class="material-icons">group</i>
		  </span>
    	<label class="control-label" for="selectbasic">DITERUSKAN KEPADA *</label>
			<?php
					echo "<select name='kd_bagian' class='form-control' required>
					<option value=''</option>";
					$tampil = mysqli_query($koneksi, "SELECT * FROM m_bagian");
					while ($r=mysqli_fetch_array($tampil)){
					echo "<option value='$r[kd_bagian]'>$r[nm_bagian]</option>";	
					}
					echo "</select>";
				?>
	  </div>
      </div>

    <div class="col-md-12">
    <div class ="input-group form-group has-feedback label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">looks_one</i>
		  </span>
			    <label for="no_urut" class="control-label">PERIHAL SURAT *</label>
				    <input type ="text" class ="form-control" name="perihal" value="<?php echo isset($perihal) ? $perihal : ''; ?>" required>
		    </div>
    </div>

      <div class="col-sm-6">
        <div class ="input-group form-group label-floating">
          <span class="input-group-addon">
            <i class="material-icons">bookmark</i>
      </span>
          <label class="control-label" for="selectbasic">DENGAN HORMAT HARAP (KOSONGKAN BILA TIDAK PERLU)</label>
             <select name="tgpn" class="form-control">
             <option value=""></option>
             <option value="Tanggapan dan saran">Tanggapan dan saran</option>
             <option value="Proses lebih lanjut">Proses lebih lanjut</option>
             <option value="Koordinasi/konfirmasikan">Koordinasi/konfirmasikan</option>
     </select>
 </div>
      <div class ="input-group form-group label-floating">
        <span class="input-group-addon">
          <i class="material-icons">save</i>
        </span>
          <label class="control-label" for="selectbasic">PILIH TEMPAT PENYIMPANAN *</label>
            <?php
              echo "<select name='kd_simpan' class='form-control' required>
               <option value=''</option>";
                $tampil = mysqli_query($koneksi, "SELECT * FROM mpnympn");
                while ($r=mysqli_fetch_array($tampil)){
               echo "<option value='$r[kd_simpan]'>$r[nm_simpan]</option>";	
               }
               echo "</select>";
              ?>
</div>
      </div>

     <div class ="col-sm-6">
        <div class ="input-group form-group has-feedback label-floating">
           <span class="input-group-addon">
			      <i class="material-icons">mail_outline</i>
		  </span>
			    <label for="perihal" class="control-label">CATATAN *</label>
				    <textarea class ="form-control" name="catatan" rows="5" <?php echo isset($catatan) ? ($catatan) : ''; ?> required></textarea>
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
</body>
</html>