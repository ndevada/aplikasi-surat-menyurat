<?php
//if ( ! empty($_POST)) {
    //$q = http_build_query(array(
        //'secret'    => '6LeKSzkUAAAAALfrVCkhAc2FCMCckUD7gL-3zZsu',
        //'response'  => $_POST['g-recaptcha-response'],
        //'remoteip'  => $_SERVER['REMOTE_ADDR'],
    //));
    //$result = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?'.$q));
    //if ($result->success) {
        // Continue processing form data
include ("config.php");
date_default_timezone_set('Asia/Singapore');
session_name('surat');
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

//$username = mysqli_real_escape_string($username);
//$password = mysqli_real_escape_string($password);

if (empty($username) && empty($password)) {
	echo "<script>alert('Username Atau Password Salah'); window.location = 'index.php?error=4'</script>";
} else if (empty($username)) {
	echo "<script>alert('Username Atau Password Salah'); window.location = 'index.php?error=4'</script>";
} else if (empty($password)) {
	echo "<script>alert('Username Atau Password Salah'); window.location = 'index.php?error=4'</script>";
}

$log   = "SELECT * FROM tpengguna WHERE username=?";
$query = mysqli_prepare($koneksi, $log);

    mysqli_stmt_bind_param($query, 's', $username);
    mysqli_stmt_execute($query);

$result  = mysqli_stmt_get_result($query);
$check   = mysqli_num_rows($result);

if ($check > 0) {
$row = mysqli_fetch_array($result);

    if(password_verify($password, $row['password'])){

    $_SESSION['user_id']   = $row['user_id'];
	$_SESSION['username']  = $username;
	$_SESSION['nama_user'] = $row['nama_user'];
    $_SESSION['level']     = $row['level'];
    }else{
        echo "<script>alert('Password Salah'); window.location = 'index.php?error=4'</script>";
    }    
    if ($_SESSION['level'] == 'admin'){
        header('location:admin/index.php');
    } else if ($_SESSION['level'] == 'pegawai'){
        header('location:pegawai/index.php');
    } else if ($_SESSION['level'] == 'siswa'){
        header('location:siswa/index.php');
    }
	
} else {
	echo "<script>alert('Username tidak dikenali!'); window.location = 'index.php?error=4'</script>";
}
//}
//}
?>

