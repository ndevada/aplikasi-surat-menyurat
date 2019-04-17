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
$id_table = 'no_urut';

$columns = array(
    'no_urut',
    'nm_instansi',
    'tgl_diterima',
    'perihal',
    'catatan',
    'nm_simpan',
    'nm_detail'
           );

// gunakan join disini
$from = 'tsuratmasuk T LEFT JOIN minstansi I ON T.kd_instansi = I.kd_instansi LEFT JOIN mpnympn P ON T.kd_simpan = P.kd_simpan LEFT JOIN detail D on T.kd_detail=D.kd_detail';

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
        $fields[] = $row['no_urut'];
        $fields[] = $row['nm_instansi'];
        $fields[] = date('d-m-Y',strtotime($row['tgl_diterima']));
        $fields[] = $row['perihal'];
        $fields[] = nl2br($row['catatan']);
        $fields[] = $row['nm_simpan']." - ".$row['nm_detail'];
        $fields[] = '<a class="btn btn-sm btn-primary" href="edit-srtmasuk.php?id='.$row['no_urut'].'" title="Edit" ><i class="fa fa-pencil-square"></i></a>
        <a href="surat-masuk.php?aksi=delete&id='.$row['no_urut'].'"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin akan menghapus surat dari '.$row['nm_instansi'].' Tanggal '.$row['tgl_diterima'].'?\')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i></a>
        <a href="input-disposisi.php?id='.$row['no_urut'].'" class="btn btn-sm"> <i class="fa fa-clone"></i> Disposisi</a>
        </td>';
    

    $datatable['data'][] = $fields;
}

$data->close();
echo json_encode($datatable);
