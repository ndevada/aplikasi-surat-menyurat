<?php
/* Koneksi  ke databse*/
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "dbsurat";

$koneksi = mysqli_connect($servername, $username, $password, $dbname) or die("Koneksi gagal: " . mysqli_connect_error());
/* Akhir koneksi */

// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;

$columns = array(
// datatable column index => database column name
    0 => 'nip',
    1 => 'nm_kadis',
    2 => 'thn_mnjbt'
);

// getting total number records without any search
$sql = "SELECT nip, nm_kadis, thn_mnjbt";
$sql.= "FROM mkadis";
$query=mysqli_query($koneksi, $sql) or die("ajax-kadis.php : get mkadis");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData; //when there is no search parameter then total number rows = total number filtered

if( !empty($requestData['search']['value'])) {
    //jika terdapat parameter yang dicari
    $sql = "SELECT nip, nm_kadis, thn_mnjbt";
    $sql.= "FROM mkadis";
    $sql.= "WHERE nip LIKE '".$requestData['search']['value']."%'";
    $sql.= "OR nm_kadis LIKE '".$requestData['search']['value']."%'";
    $sql.= "OR thn_mnjbt LIKE '".$requestData['search']['value']."%'";
    $query=mysqli_query($koneksi, $sql) or die("ajax-kadis.php: get mkadis");
    $totalFiltered = mysqli_num_rows($query); //ketika ditemukan parameter yang dicari maka kita harus memodifikasi total dari data yang ditemukan

    $sql.= "ORDER BY". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']." "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
    $query=mysqli_query($koneksi, $sql) or die("ajax-kadis.php: get mkadis"); //again run query with limit

} else {
    $sql = "SELECT nip, nm_kadis, thn_mnjbt";
    $sql.= "FROM mkadis";
    $sql.= "ORDER BY". $columns[$requestData['order'][0]['column']]."  ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']." ";
    $query=mysqli_query($koneksi, $sql) or die("ajax-kadis.php: get mkadis");

}

$data = array();
while($row=mysqli_fetch_array($query)) { //menyiapkan array
    $nestedData=array();

    $nestedData[] = $row["nip"];
    $nestedData[] = $row["nm_kadis"];
    $nestedData[] = $row["thn_mnjbt"];
    $nestedData[] = '<td><center>
                    <a href ="edit-kadis.php?id='.$row['nip'].'" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary" <i class="glyphicon glyphicon-edit"></i></a>
                    <a href="kadis.php?aksi=delete&id='.$row['nip'].'" data-toggle="tooltip" title="Delete" onClick="return confirm (\'Anda yakin akan menghapus data '.$row['nm_kadis'].'?\')" class="btn btn-sm btn-danger"> <i class="glyphicon glyphicon-trash"></i></a>
                    </center></td>';

    $data[] = $nestedData;
}

$json_data = array(
             "draw"            => intval( $requestData['draw']),// for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
             "recordsTotal"    => intval( $totalData), //total number of records
             "recordsFiltered" => intval( $totalFiltered), //total number of records after searchin, if there is no searching then totalFiltered = totalData
             "data"            => $data //total data array
);

echo json_encode($json_data); //send data as json format
?>
