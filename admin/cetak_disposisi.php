<?php
    //cek session
    session_name('surat'); 
    session_start();
    if (empty($_SESSION['username'])){
        header('location:../index.php');	
    } else {
        include "../config.php";

        echo '
        <style type="text/css">
        @page { 
            size: auto;  margin: 0mm; 
        }
            table {
                background: #fff;
                padding: 5px;
            }
            tr, td {
                border: table-cell;
                border: 1px  solid #444;
            }
            tr,td {
                vertical-align: top!important;
            }
            #right {
                border-right: none !important;
            }
            #left {
                border-left: none !important;
            }
            #topleft{
                border-left   :none !important;
                border-top    :none !important;
                border-bottom :none !important;
            }
            .isi {
                height: 300px!important;
            }
            .disp {
                text-align: center;
                padding: 1.5rem 0;
                margin-bottom: .5rem;
            }
            .logodisp {
                float: left;
                position: relative;
                width: 110px;
                height: 110px;
                margin: 0 0 0 1rem;
            }
            #lead {
                width: auto;
                position: relative;
                margin: 25px 0 0 75%;
            }
            .lead {
                font-weight: bold;
                text-decoration: underline;
                margin-bottom: -10px;
            }
            .tgh {
                text-align: center;
            }
            #nama {
                font-size: 2.1rem;
                margin-bottom: -1rem;
            }
            #alamat {
                font-size: 16px;
            }
            .up {
                text-transform: uppercase;
                margin: 0;
                line-height: 2.2rem;
                font-size: 1.5rem;
            }
            .status {
                margin: 0;
                font-size: 1.3rem;
                margin-bottom: .5rem;
            }
            #lbr {
                font-size: 20px;
                font-weight: bold;
            }
            .separator {
                border-bottom: 2px solid #616161;
                margin: -1.3rem 0 1.5rem;
            }
            @media print{
                body {
                    font-size: 12px;
                    color: #212121;
                }
                table {
                    width: 100%;
                    font-size: 12px;
                    color: #212121;
                }
                tr, td {
                    border: table-cell;
                    border: 1px  solid #444;
                    padding: 8px!important;

                }
                tr,td {
                    vertical-align: top!important;
                }
                #lbr {
                    font-size: 20px;
                }
                .profile-table{
                        border-collapse:collapse;
                    }
                .isi {
                    height: 200px!important;
                }
                .tgh {
                    text-align: center;
                }
                .disp {
                    text-align: center;
                    margin: -.5rem 0;
                }
                .logodisp {
                    float: left;
                    position: relative;
                    width: 80px;
                    height: 80px;
                    margin: .5rem 0 0 .5rem;
                }
                #lead {
                    width: auto;
                    position: relative;
                    margin: 15px 0 0 75%;
                }
                .lead {
                    font-weight: bold;
                    text-decoration: underline;
                    margin-bottom: -10px;
                }
                #nama {
                    font-size: 20px!important;
                    font-weight: bold;
                    text-transform: uppercase;
                    margin: -10px 0 -20px 0;
                }
                .up {
                    font-size: 17px!important;
                    font-weight: normal;
                }
                .status {
                    font-size: 17px!important;
                    font-weight: normal;
                    margin-bottom: -.1rem;
                }
                #alamat {
                    margin-top: -15px;
                    font-size: 13px;
                }
                #lbr {
                    font-size: 17px;
                    font-weight: bold;
                }
                .separator {
                    border-bottom: 2px solid #616161;
                    margin: -1rem 0 1rem;
                }

            }
        </style>

        <body onload="window.print()">

        <!-- Container START -->
        <div class="container">
            <div id="colres">
                <div class="disp">';
                        echo '<img class="logodisp" src="logo.png"/>';
                        echo '<h6 class="up">PEMERINTAH KOTA BANJARMASIN</h6>';
                        echo '<h5 class="up" id="nama">DINAS KOMUNIKASI, INFORMATIKA, DAN STATISTIK</h5><br/>';
                        echo '<span id="alamat">Jalan R. E. Martadinata No. 1 Kode Pos 7011 Gedung Blok B Lt. Dasar - Banjarmasin</span>';
                    echo '
                </div>
                <br>
                <br>
                <div class="separator"></div>';

                $id_surat = mysqli_real_escape_string($koneksi, $_REQUEST['id_surat']);
                $query = mysqli_query($koneksi, "SELECT * FROM disposisi D INNER JOIN tsuratmasuk T ON D.urut=T.no_urut INNER JOIN minstansi I ON T.kd_instansi=I.kd_instansi INNER JOIN m_bagian B ON D.kd_bagian=B.kd_bagian WHERE id_disposisi='$id_surat'");

                if(mysqli_num_rows($query) > 0){
                $no = 0;
                while($row = mysqli_fetch_array($query)){

                    $y = substr($row['tgl_diterima'],0,4);
                    $m = substr($row['tgl_diterima'],5,2);
                    $d = substr($row['tgl_diterima'],8,2);

                    if($m == "01"){
                        $nm = "Januari";
                    } elseif($m == "02"){
                        $nm = "Februari";
                    } elseif($m == "03"){
                        $nm = "Maret";
                    } elseif($m == "04"){
                        $nm = "April";
                    } elseif($m == "05"){
                        $nm = "Mei";
                    } elseif($m == "06"){
                        $nm = "Juni";
                    } elseif($m == "07"){
                        $nm = "Juli";
                    } elseif($m == "08"){
                        $nm = "Agustus";
                    } elseif($m == "09"){
                        $nm = "September";
                    } elseif($m == "10"){
                        $nm = "Oktober";
                    } elseif($m == "11"){
                        $nm = "November";
                    } elseif($m == "12"){
                        $nm = "Desember";
                    }

                    $y1 = substr($row['tgl_surat'],0,4);
                    $m1 = substr($row['tgl_surat'],5,2);
                    $d1 = substr($row['tgl_surat'],8,2);

                    if($m1 == "01"){
                        $nm1 = "Januari";
                    } elseif($m1 == "02"){
                        $nm1 = "Februari";
                    } elseif($m1 == "03"){
                        $nm1 = "Maret";
                    } elseif($m1 == "04"){
                        $nm1 = "April";
                    } elseif($m1 == "05"){
                        $nm1 = "Mei";
                    } elseif($m1 == "06"){
                        $nm1 = "Juni";
                    } elseif($m1 == "07"){
                        $nm1 = "Juli";
                    } elseif($m1 == "08"){
                        $nm1 = "Agustus";
                    } elseif($m1 == "09"){
                        $nm1 = "September";
                    } elseif($m1 == "10"){
                        $nm1 = "Oktober";
                    } elseif($m1 == "11"){
                        $nm1 = "November";
                    } elseif($m1 == "12"){
                        $nm1 = "Desember";
                    }

                echo '
                    <table class="profile-table" id="tbl">
                        <tbody>
                            <tr>
                                <td class="tgh" id="lbr" colspan="5">LEMBAR DISPOSISI</td>
                            </tr>
                            <tr>
                                <td id="right" width="14%"><strong>Surat Dari</strong></td>
                                <td id="left" style="border-right: none;" width="50%">: '.$row['nm_instansi'].'</td>
                                <td id="right" width="14%"><strong>Diterima Tanggal</strong></td>
                                <td id="left"">: '.$d." ".$nm." ".$y.'</td>
                            </tr>
                            <tr>';


                                echo '

                                <td id="right" width="14%"><strong>No. Surat</strong></td>
                                <td id="left" style="border-right: none;" width="50%">: '.$row['nmr_surat'].'</td>
                                <td id="right" width="14%"><strong>No. Agenda</strong></td>
                                <td id="left"">
                                <div style="width: 100%; word-wrap: break-word">
                                : '.$row['no_urut'].'</td>
                                </div>
                            </tr>
                            <tr>
                                <td id="right" width="14%"><strong>Tanggal Surat</strong></td>
                                <td id="left" style="border-right: none;" width="50%">: '.$d1." ".$nm1." ".$y1.'</td>
                                <td id="right" width="14%"><strong>Sifat</strong></td>
                                <td id="left">:'.$row['sifat'].'</td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Perihal</strong></td>
                                <td id="left" colspan="3">: '.$row['perihal'].'</td>
                            </tr>
                            <tr>
                                <td id="right" width="14%"><strong>Diteruskan Kepada sdr</strong></td>
                                <td id="left" style="border-right: none;" width="50%">: '.$row['nm_bagian'].'</td>
                                <td id="right" width="14%"><strong>Dengan hormat harap</strong></td>
                                <td id="left">: '.$row['tgpn'].'</td>
                            </tr>
                            <tr>';
                            $query3 = mysqli_query($koneksi, "SELECT * FROM disposisi D INNER JOIN tsuratmasuk T ON D.urut=T.no_urut INNER JOIN minstansi I ON T.kd_instansi=I.kd_instansi INNER JOIN m_bagian B ON D.kd_bagian=B.kd_bagian WHERE id_disposisi='$id_surat'");

                            if(mysqli_num_rows($query3) > 0){
                                $no = 0;
                                $row = mysqli_fetch_array($query3);{
                                echo '
                            <tr class="isi">
                            <td colspan="4">
                            <strong>Isi Disposisi :</strong><br/>'.$row['isi'].'
                            <div style="height: 50px;"></div>
                            <strong>Catatan</strong> :<br/> '.nl2br($row['catatan']).'
                            <div style="height: 25px;"></div>
                        </td>
                            </tr>';
                                }
                            } else {
                                echo '
                                <tr class="isi">
                                    <td id="right"><strong>Catatan</strong></td>
                                    <td id="left" colspan="3">: -</td>
                                </tr>';
                            }
                        } echo '
                </tbody>
            </table>
            <div id="lead">
                <b><p>Kepala Dinas</p></b>
                <div style="height: 50px;"></div>';
                    echo '<b><p class="lead">Drs. H. HERMANSYAH, MM</p></b>';
                    echo '<b><p>NIP. 19690927 199003 1 008</p></b>';
                echo '
            </div>
        </div>
        <div class="jarak2"></div>
    </div>
    <!-- Container END -->

    </body>';
    }
}
?>
