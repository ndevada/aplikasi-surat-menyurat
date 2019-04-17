<?php
    //cek session
    session_name('surat'); 
    session_start();
    if (empty($_SESSION['username'])){
        header('location:../index.php');	
    } else {
        include "../../config.php";

        echo '
        <style type="text/css">
        th 
        {
            text-align:center; 
            vertical-align:middle;
        }
        hr {
            border: none;
            height: 1px;
            /* Set the hr color */
            color: #000; /* old IE */
            background-color: #000; /* Modern Browsers */
        }
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
                        echo '<img class="logodisp" src="../logo.png"/>';
                        echo '<h6 class="up">PEMERINTAH KOTA BANJARMASIN</h6>';
                        echo '<h5 class="up" id="nama">DINAS KOMUNIKASI, INFORMATIKA, DAN STATISTIK</h5><br/>';
                        echo '<span id="alamat">Jalan R. E. Martadinata No. 1 Kode Pos 7011 Gedung Blok B Lt. Dasar - Banjarmasin</span>';
                    echo '
                </div>
                <br>
                <br>
                <div class="separator"></div>
                <div class="tgh" id="lbr">LAPORAN DATA BAGIAN</div>
                </br>
                </br>
                <div class="separator"></div>';

                echo '
                <table border="1" class="profile-table" id="tbl">
                <thead>
                <tr>
                <th>No.</th>
                <th>Nama Bagian</th>          
                </tr>
                </thead>';


                $query = mysqli_query($koneksi, "SELECT * FROM m_bagian ORDER BY kd_bagian ASC");

                $no = 1;
                while($row = mysqli_fetch_array($query)){
/*
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
*/
                echo '
                        <tbody>
                            <tr>
                                <td align="center">'.$no++.'</td>
                                <td>'.$row['nm_bagian'].'</td>
                            </tr>';
                        }}echo '
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

?>