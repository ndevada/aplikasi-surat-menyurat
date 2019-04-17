<?php   
      include '../config.php';     
      $kd_detail    = $_POST['kd_detail'];
      $kd_simpan    = $_POST['kd_simpan'];
      $nm_detail    = strtoupper($_POST['nm_detail']);
      $data         = "SELECT * FROM detail WHERE kd_detail=? AND kd_simpan=? AND nm_detail=?";
      $query        = mysqli_prepare($koneksi, $data);

        mysqli_stmt_bind_param($query, 'sss', $kd_detail, $kd_simpan, $nm_detail);
        mysqli_stmt_execute($query);

      $hasil = mysqli_stmt_get_result($query);
      $valid = mysqli_num_rows($hasil);

    if ($valid == 0){
      $up    = "UPDATE detail SET kd_simpan=?, nm_detail=? WHERE kd_detail=?";
      $query = mysqli_prepare($koneksi, $up);

        mysqli_stmt_bind_param($query, 'sss', $kd_simpan, $nm_detail, $kd_detail);
        mysqli_stmt_execute($query);
        echo "<script>alert('Detail Tempat Penyimpanan Surat berhasil disimpan!');window.history.go(-1)</script>";                  
    }else{
      echo "<script>alert('Detail Tempat Penyimpanan Sudah Ada!');window.history.go(-1)</script>";
    }