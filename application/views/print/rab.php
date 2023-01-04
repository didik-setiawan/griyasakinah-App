<!DOCTYPE html>
<html>

<head>
    <title>RAB</title>
    <style>
        /* Styles go here */

        .page-header, .page-header-space {
            height: 100px;
        }

        .page-footer, .page-footer-space {
            height: 50px;
        }

        .page-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 1px solid black; /* for demo */
            background: yellow; /* for demo */
        }

        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;
            border-bottom: 1px solid black; /* for demo */
            background: yellow; /* for demo */
        }

        .page {
            page-break-after: always;
        }

        <?php
            if($pdf == 0){
                ?>
                    .table { 
                        width: 100%; 
                        border-collapse: collapse;
                        border: 1px solid black;
                        padding-top: 1px;
                        padding-bottom: 1px;
                    }
                    td { 
                        border: 1px solid black;
                        padding: 5px;
                        font-size: 12px;
                    }
                <?php
            }else{
                ?>
                    .table { 
                        width: 100%; 
                        border-collapse: collapse;
                        padding-top: 1px;
                        padding-bottom: 1px;
                    }
                    .td { 
                        border-top: 1px solid #000;
                        border-bottom: 1px solid #000;
                        border-left: 1px solid #000;
                        border-right: 1px solid #000;
                        padding: 5px;
                        font-size: 12px;
                    }

                <?php
            }
        ?>

        .table2 { 
            width: 100%; 
            border-collapse: collapse;
        }

        .td2 { 
            font-size: 12px;
            padding: 5px;
        }

        .text-uppercase {
            text-transform: uppercase;
        }
        .text-capitalize {
            text-transform: capitalize;
        }

        .font18 {
            font-size: 18px;
        } 
        .font16 {
            font-size: 16px;
        } 
        .font14 {
            font-size: 14px;
        } 
        .font12 {
            font-size: 12px;
        } 
        .font10 {
            font-size: 10px;
        } 
        .font9 {
            font-size: 9px;
        } 
        .text-top {
            vertical-align: top;
        } 
        .text-bottom {
            vertical-align: bottom;
        } 
        .text-middle {
            vertical-align: middle;
        } 
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        .text-bold {
            font-weight: bold;
        }
        .color-white {
            color: white;
        } 
        .bg-red {
            background: red;
        } 
        .bg-blue {
            background: blue;
        } 
        .bg-gray {
            background: gray;
        } 

        .button-red {
            background-color: red;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin: 4px 2px;
            cursor: pointer;
            width: 20%;
            text-transform: uppercase;
        }
        .button-blue {
            background-color: blue;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin: 4px 2px;
            cursor: pointer;
            width: 20%;
            text-transform: uppercase;
        }

        @page {
            margin: 10mm
        }

        @media print {
            thead {display: table-header-group;} 
            tfoot {display: table-footer-group;}
            
            button {display: none;}
            #hidden_print { display: none; }

            body {margin: 0;}
        }
    </style>

</head>

<?php
$tanggal = date('Y-m-d');
$date = date_create($tanggal);
$tanggal_dibuat = date_format($date,"j F Y");

$date2 = date_create($rab->tgl_pengajuan);
$tanggalRAB = date_format($date2,"j F Y");

if($pdf == 0){
    ?>
    <body onLoad="window.print()">
    <!-- <body> -->
        <button id="hidden_print" onClick="window.print()" class="button-blue">P R I N T</button>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="text-center">
                    <span class="font18 text-bold text-uppercase">Rencana Anggaran Biaya (RAB)</span> <br>
                    <span class="text-uppercase text-bold font16"><?=$profile->nama_lembaga?></span> <br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table2">
                        <tr>
                            <td class="td2" style="width: 15%;">Nama Perumahan</td>
                            <td class="td2 text-uppercase text-bold" style="width: 80%;">: <?=$this->session->userdata('nama_perumahan');?> </td>
                        </tr>
                        <tr>
                            <td class="td2" style="width: 15%;">Nama Kegiatan</td>
                            <td class="td2 text-uppercase text-bold" style="width: 80%;">: <?=$rab->nama_proyek?> </td>
                        </tr>
                        <tr>
                            <td class="td2">Tanggal</td>
                            <td class="td2 text-bold">: <?=$tanggalRAB?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="text-right" style="padding: 5px;">
                    <span class="font10">dicetak pada : <b><?=$tanggal_dibuat?></b></span>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table">
                        <thead>
                            <tr style="background: #C1C1C1;">
                                <th class="text-center">Tipe</th>
                                <th class="text-center">Blok</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Material</th>
                                <th class="text-center">Upah Kerja</th>
                                <th class="text-center">Lainnya</th>
                                <th class="text-center">Jumlah Total</th>
                                <!-- <th class="text-center"><i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i></th> -->
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1; 
                            foreach ($kavling as $key => $as){
                            ?>
                                <tr>
                                    <td>
                                    <span class="text-bold"><?= $as->tipe?></span><br>
                                    </td>
                                    <td>
                                        <?php 
                                        foreach ($tipe as $key => $oi){ 
                                            if($as->tipe == $oi->tipe){
                                        ?>
                                        <?= $oi->blok . $oi->no_rumah ?><br>
                                        <?php
                                                }else{
                                                    $oi->blok . $oi->no_rumah;
                                                } 
                                            }
                                        ?>
                                    </td>
                                    <td class="text-right"><?= $as->kav ?></td>
                                    <td class="text-right">
                                        <?php 
                                        foreach ($material as $key => $mat){ 
                                            if($as->tipe == $mat->tipe){
                                        ?>
                                        Rp. <?=rupiah2($mat->total_harga) ?><br>
                                        <?php
                                                } 
                                            }
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php 
                                        foreach ($upah as $key => $up){ 
                                            if($as->tipe == $up->tipe){
                                        ?>
                                       Rp. <?=rupiah2($up->total_harga_kontrak * $as->kav) ?><br>
                                        <?php
                                                } 
                                            }
                                        ?>
                                    </td>

                                    <td class="text-right">
                                        <?php 
                                        foreach ($lainnya as $key => $lain){ 
                                            if($as->tipe == $lain->tipe){
                                        ?>
                                       Rp. <?=rupiah2($lain->total_lainnya) ?><br>
                                        <?php
                                                } 
                                            }
                                        ?>
                                    </td>


                                    <td class="text-right">

                                        <?php 
                                            $totMat=0;
                                            $totUp=0;
                                            $totLa=0;
                                            $hasil=0;
                                            
                                            foreach ($material as $key => $mat){ 
                                                if($as->tipe == $mat->tipe){
                                                    $totMat +=$mat->total_harga;
                                                }
                                            }
                                            foreach ($upah as $key => $up){ 
                                                if($as->tipe == $up->tipe){
                                                    $totUp += $up->total_harga_kontrak * $as->kav;
                                                }
                                            }
                                            foreach ($lainnya as $key => $lain){ 
                                                if($as->tipe == $lain->tipe){
                                                
                                                    
                                                    $totLa += $lain->total_lainnya;
                                                }
                                            }

                                             $hasil=$totMat+$totUp+$totLa;
                                        ?>
                                        <span>Rp. <?= rupiah2($hasil) ?></span><br>
                                    </td>
                                   
                                </tr>
                            <?php 
                            }
                            ?>
                        </tbody>
                            <?php
                                $upahPekerja = $this->db->get_where('tbl_proyek_upah',['proyek_id' => $id_pro])->result();

                                $Totalkav = 0;
                                $jumlahTotal = 0;
                                $jumlahTotalUpah = 0;
                                $jumlahTotalLain = 0;
                                $Total_Jumlah = 0;

                            foreach ($totalKavling as $key => $tot) {

                            }
                            foreach ($detail as $key => $row) {
                                $jumlahTotal += $row->total;
                            }
                            // foreach ($UpahTOtal as $UpahTOtal) {
                            //     $jumlahTotalUpah += $UpahTOtal->harga_kontrak;
                            // }    

                            foreach ($LainnyaTotal as $LainnyaTotal) {
                                $jumlahTotalLain += $LainnyaTotal->harga_lainnya;
                            }

                            foreach($upahPekerja as $upker){
                                $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $id_pro AND tbl_kavling.id_tipe = $upker->tipe_id;
                                ";
                                $jml_kav = $this->db->query($q)->num_rows();
                                $jmlUp = $upker->harga_kontrak * $jml_kav;
                                $jumlahTotalUpah += $jmlUp;

                            }

                            $Total_Jumlah = $jumlahTotal+$jumlahTotalUpah+$jumlahTotalLain;
                            ?>

                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-right">Jumlah Total :</th>
                                        <th class="text-right"><?=$tot->total_kav ?></th>
                                        <th class="text-right">Rp. <?=rupiah2($jumlahTotal)?></th>
                                        <th class="text-right">Rp. <?=rupiah2($jumlahTotalUpah)?></th>
                                        <th class="text-right">Rp. <?=rupiah2($jumlahTotalLain)?></th>
                                        <th class="text-right">Rp. <?=rupiah2($Total_Jumlah)?></th>
                                    </tr>
                                </tfoot>
                    </table>
                </td>
            </tr>
        </table>
    <?php } ?>
</body>
</html>
