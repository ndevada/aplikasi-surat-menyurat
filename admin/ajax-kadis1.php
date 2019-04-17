<?php
/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "akademik";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'nis',
    1 => 'nama_siswa', 
	2 => 'alamat_siswa',
	3 => 'tgl_lhr',
    4 => 'j_kelamin'
);

// getting total number records without any search
$sql = "SELECT nis, nama_siswa, alamat_siswa, tgl_lhr, j_kelamin ";
$sql.=" FROM siswa";
$query=mysqli_query($conn, $sql) or die("ajax-siswa.php: get siswa");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT nis, nama_siswa, alamat_siswa, tgl_lhr, j_kelamin ";
	$sql.=" FROM siswa";
	$sql.=" WHERE nis LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR nama_siswa LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR alamat_siswa LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR tgl_lhr LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR j_kelamin LIKE '".$requestData['search']['value']."%' ";
	$query=mysqli_query($conn, $sql) or die("ajax-siswa.php: get siswa");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
	$query=mysqli_query($conn, $sql) or die("ajax-siswa.php: get siswa"); // again run query with limit
	
} else {	

	$sql = "SELECT nis, nama_siswa, alamat_siswa, tgl_lhr, j_kelamin ";
	$sql.=" FROM siswa";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($conn, $sql) or die("ajax-siswa.php: get siswa");   
	
}

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["nis"];
    $nestedData[] = $row["nama_siswa"];
	$nestedData[] = $row["alamat_siswa"];
	$nestedData[] = $row["tgl_lhr"];
    $nestedData[] = $row["j_kelamin"];
    $nestedData[] = '<td><center>
                     <a href="profil-siswa.php?id='.$row['nis'].'"  data-toggle="tooltip" title="Lihat Profil" class="btn btn-sm btn-info"> <i class="glyphicon glyphicon-user"></i> </a>
                     <a href="edit-siswa.php?id='.$row['nis'].'"  data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary"> <i class="glyphicon glyphicon-edit"></i> </a>
				     <a href="siswa.php?aksi=delete&id='.$row['nis'].'"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin akan menghapus data '.$row['nama_siswa'].'?\')" class="btn btn-sm btn-danger"> <i class="glyphicon glyphicon-trash"> </i> </a>
	                 </center></td>';		
	
	$data[] = $nestedData;
    
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
