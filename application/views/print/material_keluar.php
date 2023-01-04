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
                            <td class="td2" style="width: 15%;">Nama Kegiatan</td>
                            <td class="td2 text-uppercase text-bold" style="width: 80%;">: <?=$rab->nama_proyek?> </td>
                        </tr>
                        <tr>
                            <td class="td2">Waktu / Tanggal</td>
                            <td class="td2 text-bold">: <?=$tanggalRAB?></td>
                        </tr>
                        <tr>
                            <td class="td2">Kavling Tipe</td>
                            <td class="td2 text-bold">: 
                                <?php
                                foreach ($kavling as $key => $as){
                                ?>
                                <?= $as->tipe?>
                                <?php }?>
                            </td>
                        </tr>
                        <tr>
                            <td class="td2">Kavling Blok</td>
                            <td class="td2 text-bold">: 
                                <?php 
                                foreach ($kavling as $key => $as){
                                foreach ($tipe as $key => $oi){ 
                                    if($as->tipe == $oi->tipe){
                                ?>
                                [ <?= $oi->blok ?> ]
                                <?php
                                        }else{
                                            $oi->blok;
                                        } 
                                    }
                                ?>
                                <?php 
                                }
                                ?>
                            </td>
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
                    <?php foreach ($material as $key => $mat){
                    if($mat->keluar == 1){
                    ?>
                    <h2>Daftar Material Keluar</h2>
                    <table class="table">
                        <thead>
                            <tr style="background: #C1C1C1;">
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Nama Material</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Harga Satuan</th>
                                <th class="text-center">Total</th>
                                <!-- <th class="text-center"><i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i></th> -->
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1; 
                        foreach ($detail as $key => $row){
                        ?>
                            <tr>
                                <td class="text-center"><?= date('d F Y', strtotime($row->tgl_keluar))?></td>
                                <td>
                                <span class="text-bold"><?= $row->nama_material?></span><br>
                                </td>
                                <td class="text-center"><?= $row->quantity ?>  <?= $row->nama_satuan ?></td>
                                <td class="text-right">Rp. <?= rupiah2($row->harga) ?></td>
                                <td class="text-right">Rp. <?= rupiah2($row->total) ?></td>
                            </tr>
                        <?php 
                        }
                        ?>
                        </tbody>

                        <?php
                            $jumlahTotal = 0;
                            
                        foreach ($detail as $key => $row) {
                            $jumlahTotal += $row->total;
                        }
                        ?>
                            <tfoot>
                                <tr">
                                    <th colspan="4" class="text-right">Jumlah Total :</th>
                                    <th class="text-right">Rp. <?=rupiah2($jumlahTotal)?></th>
                                </tr>
                            </tfoot>
                    </table>
                    <?php }if($mat->belanja == 1){?>
                    
                    <h2>Daftar Belanja Material</h2>
                    <table class="table">
                        <thead>
                            <tr style="background: #C1C1C1;">
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Nama Material</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Harga Satuan</th>
                                <th class="text-center">Total</th>
                                <!-- <th class="text-center"><i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i></th> -->
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1; 
                        foreach ($belanja as $key => $bel){
                        ?>
                            <tr>
                                <td class="text-center"><?= date('d F Y', strtotime($bel->tgl_keluar))?></td>
                                <td>
                                <span class="text-bold"><?= $bel->nama_material?></span><br>
                                </td>
                                <td class="text-center"><?= $bel->quantity ?>  <?= $bel->nama_satuan ?></td>
                                <td class="text-right">Rp. <?= rupiah2($bel->harga) ?></td>
                                <td class="text-right">Rp. <?= rupiah2($bel->total) ?></td>
                            </tr>
                        <?php 
                        }
                        ?>
                        </tbody>

                        <?php
                            $TotalBel = 0;
                            
                        foreach ($belanja as $key => $bel) {
                            $TotalBel += $bel->total;
                        }
                        ?>
                            <tfoot>
                                <tr">
                                    <th colspan="4" class="text-right">Jumlah Total :</th>
                                    <th class="text-right">Rp. <?=rupiah2($TotalBel)?></th>
                                </tr>
                            </tfoot>
                    </table>

                    <?php }} ?>
                </td>
            </tr>
        </table>
    <?php } ?>
</body>
</html>
