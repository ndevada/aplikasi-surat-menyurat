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
$id_table = 'id_disposisi';

$columns = array(
    'urut',
    'tgl_disposisi',
             'isi',
             'nm_bagian',
             'sifat'
           );

// gunakan join disini
$from = 'disposisi D INNER JOIN tsuratmasuk T ON D.urut = T.no_urut INNER JOIN m_bagian B on D.kd_bagian = B.kd_bagian';

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

while ($row = $data->fetch_assoc()) {

    $fields = array();
    $fields[] = $no++;
    $fields[] = $row['urut'];
    $fields[] = date('d-m-Y',strtotime($row['tgl_disposisi']));
    $fields[] = $row['isi'];
    $fields[] = $row['nm_bagian'];
    $fields[] = $row['sifat'];
    $fields[] = '<a class="btn btn-sm btn-primary" href="edit-disposisi.php?id='.$row['id_disposisi'].'" data-toggle="tooltip" data-placement="top" title="Tooltip on top" ><i class="fa fa-pencil-square"></i></a>
    <a href="disposisi.php?aksi=delete&id='.$row['id_disposisi'].'"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin akan menghapus disposisi '.$row['isi'].' sifat '.$row['sifat'].'?\')" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i></a>
    <a class="btn btn-sm btn-default" href="cetak_disposisi.php?id_surat='.$row['id_disposisi'].'" target="_blank" title="Edit" ><i class="fa fa-print"></i> Cetak</a>
    </td>';
    

    $datatable['data'][] = $fields;
}

$data->close();
echo json_encode($datatable);