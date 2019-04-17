<?php
// memanggil file config.php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'dbsurat';

// koneksi ke database
$database = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($database->connect_error) {
    die('Oops!! database Not Connect : ' . $database->connect_error);
}

// Alternative SQL join in Datatables
$id_table = 'kode_srtkeluar';

$columns = array(
    'no_surat',
    'tgl_surat',
    'nm_jenis',
    'nm_instansi',
    'perihal'
           );

// gunakan join disini
$from = 'tsuratkeluar T INNER JOIN mjenis I ON T.kd_jenis = I.kd_jenis INNER JOIN minstansi B ON T.kd_instansi = B.kd_instansi';

$id_table = $id_table != '' ? $id_table . ',' : '';
// custom SQL
$sql = "SELECT {$id_table} ".implode(',', $columns)." FROM {$from}";

// search
if (isset($_GET['search']['value']) && $_GET['search']['value'] != '') {
    $search = $_GET['search']['value'];
    $where  = '';
    // create parameter pencarian kesemua kolom yang tertulis
    // di $columns
    for ($i=0; $i < count($columns); $i++) {
        $where .= $columns[$i] . ' LIKE "%'.$search.'%"';

        // agar tidak menambahkan 'OR' diakhir Looping
        if ($i < count($columns)-1) {
            $where .= ' OR ';
        }
    }

    $sql .= ' WHERE ' . $where;
}

//SORT Kolom
$sortColumn = isset($_GET['order'][0]['column']) ? $_GET['order'][0]['column'] : 0;
$sortDir    = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : 'asc';

$sortColumn = $columns[$sortColumn];

$sql .= " ORDER BY {$sortColumn} {$sortDir}";

// var_dump($sql);
$count = $database->query($sql);
// hitung semua data
$totaldata = $count->num_rows;

$count->close();

// memberi Limit
$start  = isset($_GET['start']) ? $_GET['start'] : 0;
$length = isset($_GET['length']) ? $_GET['length'] : 10;


$sql .= " LIMIT {$start}, {$length}";

$data  = $database->query($sql);
$no= 1;
// create json format
$datatable['draw']            = isset($_GET['draw']) ? $_GET['draw'] : 1;
$datatable['recordsTotal']    = $totaldata;
$datatable['recordsFiltered'] = $totaldata;
$datatable['data']            = array();
while ($row = $data->fetch_array()) {

    $fields = array();
    $fields[] = $no++;
    $fields[] = $row['no_surat'];
    $fields[] = date('d-m-Y',strtotime($row['tgl_surat']));
    $fields[] = $row['nm_jenis'];
    $fields[] = $row['nm_instansi'];
    $fields[] = $row['perihal'];
    $fields[] = '<a class="btn btn-sm btn-primary" href="edit-srtkeluar.php?id='.$row['kode_srtkeluar'].'" title="Edit" ><i class="fa fa-pencil-square"></i></a>
    <a href="surat-keluar.php?aksi=delete&id='.$row['kode_srtkeluar'].'"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin akan menghapus surat untuk '.$row['nm_instansi'].' Tanggal '.$row['tgl_surat'].'?\')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </a>
    </td>';
    

    $datatable['data'][] = $fields;
}

$data->close();
echo json_encode($datatable);
