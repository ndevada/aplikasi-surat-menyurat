<?php
/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbsurat";

$koneksi = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'kd_simpan',
	1 => 'nm_simpan'
);

// getting total number records without any search
$sql = "SELECT kd_simpan, nm_simpan ";
$sql.=" FROM mpnympn";
$query=mysqli_query($koneksi, $sql) or die("ajax-tempat.php: get tempat");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT kd_simpan, nm_simpan ";
	$sql.=" FROM mpnympn";
	$sql.=" WHERE nm_simpan LIKE '%".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$query=mysqli_query($koneksi, $sql) or die("ajax-tempat.php: get tempat");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
	$query=mysqli_query($koneksi, $sql) or die("ajax-tempat.php: get tempat"); // again run query with limit
	
} else {	

	$sql = "SELECT kd_simpan, nm_simpan ";
	$sql.=" FROM mpnympn";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($koneksi, $sql) or die("ajax-tempat.php: get tempat");   
	
}
$no= 1;
$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
    $nestedData[] = $no++;
	$nestedData[] = $row["nm_simpan"];
    $nestedData[] = '<td><center>
                     <a href="edit-penyimpanan.php?id='.$row['kd_simpan'].'"  data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary"> <i class="fa fa-pencil-square"></i> </a>
					 <a href="penyimpanan.php?aksi=delete&id='.$row['kd_simpan'].'"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin akan menghapus data '.$row['nm_simpan'].'?\')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </a>
					 <a href="detail-penyimpanan.php?id='.$row['kd_simpan'].'"  data-toggle="tooltip" title="Detail" class="btn btn-sm btn-default">detail tempat peyimpanan</a>
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