<?php
include '../config.php';

$kd_detail = $_POST['kd_simpan'];

$sql_detail = mysqli_query($koneksi, "SELECT * FROM detail WHERE kd_simpan = '$kd_detail'");

echo '<option></option>';
while($row=mysqli_fetch_array($sql_detail)) {
    echo '<option value="'.$row['kd_detail'].'">'.$row['nm_detail'].'</option>';
}