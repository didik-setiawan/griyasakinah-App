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
                    .td { 
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

$date2 = date_create($rab->waktu);
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
                            <td class="td2 text-uppercase text-bold" style="width: 80%;">: <?=$rab->judul_rab?> </td>
                        </tr>
                        <tr>
                            <td class="td2">Waktu / Tanggal</td>
                            <td class="td2 text-bold">: <?=$tanggalRAB?></td>
                        </tr>
                        <tr>
                            <td class="td2">Tempat/Lokasi</td>
                            <td class="td2 text-bold">: <?=$rab->lokasi?> </td>
                        </tr>
                        <tr>
                            <td class="td2">Deskripsi</td>
                            <td class="td2">: <?=$rab->keterangan?></td>
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
                                <td class="td text-center text-middle text-bold" style="height: 25px;">No.</td>
                                <td class="td text-center text-middle text-bold">Deskripsi</td>
                                <td class="td text-center text-middle text-bold">Banyaknya</td>
                                <td class="td text-center text-middle text-bold">Harga Satuan</td>
                                <td class="td text-center text-middle text-bold">Total</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($detail->num_rows() > 0){
                                    foreach ($detail->result() as $key => $row) {
                                        if($row->level == 1){
                                            ?>
                                                <tr style="background: #DDD">
                                                    <td colspan="5" class="td text-uppercase text-bold">
                                                        <?=$row->deskripsi?>
                                                    </td>
                                                </tr>
                                            <?php
                                            $no = 1;
                                            $subtotal = 0;
                                            foreach ($detail->result() as $key => $parent) {
                                                if($parent->parent == $row->id){
                                                    ?>
                                                        <tr>
                                                            <td class="td text-center" style="width: 5%;"><?=$no++?>.</td>
                                                            <td class="td" style="width: 50%;"><?=$parent->deskripsi?></td>
                                                            <td class="td text-center" style="width: 13%;"><?=$parent->quantity.' '.$parent->satuan?></td>
                                                            <td class="td text-right" style="width: 16%;">Rp. <?=rupiah2($parent->nominal)?></td>
                                                            <td class="td text-right" style="width: 16%;">Rp. <?=rupiah2($parent->total)?></td>
                                                        </tr>
                                                    <?php
                                                    $subtotal += $parent->total;
                                                }
                                            }
                                            ?>
                                                <tr>
                                                    <td colspan="4" class="td text-right text-bold">
                                                        Sub-Total : &nbsp;
                                                    </td>
                                                    <td class="td text-right text-bold">Rp. <?=rupiah2($subtotal)?></td>
                                                </tr>
                                            <?php
                                        }
                                    }

                                    // for ($i=1; $i < 160; $i++) { 
                                    //     echo '
                                    //         <tr>
                                    //             <td class="td text-center" style="width: 5%;">'.$i.'</td>
                                    //             <td class="td" style="width: 50%;">Beras kantong ukuran 5Kg</td>
                                    //             <td class="td text-center" style="width: 13%;">300 KG</td>
                                    //             <td class="td text-right" style="width: 16%;">Rp. 12.000</td>
                                    //             <td class="td text-right" style="width: 16%;">Rp. 3.600.000</td>
                                    //         </tr>
                                    //     ';
                                    // }
                
                                }else{
                                    ?>
                                        <tr>
                                            <td colspan="5" class="td text-center">
                                                Data tidak tersedia...
                                            </td>
                                        </tr>
                                    <?php
                                }

                                $jumlahTotal = 0;
                                if($detail->num_rows() > 0){
                                    foreach ($detail->result() as $key => $value) {
                                        $jumlahTotal += $value->total;
                                    }
                                    ?>
                                        <tr style="background: #C1C1C1">
                                            <th colspan="4" class="td text-right text-bold">Jumlah Total :</th>
                                            <th class="td text-right text-bold">Rp. <?=rupiah2($jumlahTotal)?></th>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

    <?php
}else{
    ?>
    <body>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="text-center" colspan="5">
                    <span class="font18 text-bold text-uppercase">Rencana Anggaran Biaya (RAB)</span> <br>
                    <span class="text-uppercase text-bold font16"><?=$profile->nama_lembaga?></span> <br><br>
                    <table class="table2">
                        <tr>
                            <td class="td2" style="width: 15%;">Nama Kegiatan</td>
                            <td class="td2 text-uppercase text-bold" style="width: 80%;">: <?=$rab->judul_rab?> </td>
                        </tr>
                        <tr>
                            <td class="td2">Waktu / Tanggal</td>
                            <td class="td2 text-bold">: <?=$tanggalRAB?></td>
                        </tr>
                        <tr>
                            <td class="td2">Tempat/Lokasi</td>
                            <td class="td2 text-bold">: <?=$rab->lokasi?> </td>
                        </tr>
                        <tr>
                            <td class="td2">Deskripsi</td>
                            <td class="td2">: <?=$rab->keterangan?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="text-right" colspan="5" style="padding: 5px;">
                    <span class="font10">dicetak pada : <b><?=$tanggal_dibuat?></b></span>
                </td>
            </tr>
            <thead>
                <tr style="background: #C1C1C1;">
                    <td class="td text-center text-middle text-bold" style="height: 25px;">No.</td>
                    <td class="td text-center text-middle text-bold">Deskripsi</td>
                    <td class="td text-center text-middle text-bold">Banyaknya</td>
                    <td class="td text-center text-middle text-bold">Harga Satuan</td>
                    <td class="td text-center text-middle text-bold">Total</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($detail->num_rows() > 0){
                        foreach ($detail->result() as $key => $row) {
                            if($row->level == 1){
                                ?>
                                    <tr style="background: #DDD">
                                        <td colspan="5" class="td text-uppercase text-bold">
                                            <?=$row->deskripsi?>
                                        </td>
                                    </tr>
                                <?php
                                $no = 1;
                                $subtotal = 0;
                                foreach ($detail->result() as $key => $parent) {
                                    if($parent->parent == $row->id){
                                        ?>
                                            <tr>
                                                <td class="td text-center" style="width: 5%;"><?=$no++?>.</td>
                                                <td class="td" style="width: 50%;"><?=$parent->deskripsi?></td>
                                                <td class="td text-center" style="width: 13%;"><?=$parent->quantity.' '.$parent->satuan?></td>
                                                <td class="td text-right" style="width: 16%;">Rp. <?=rupiah2($parent->nominal)?></td>
                                                <td class="td text-right" style="width: 16%;">Rp. <?=rupiah2($parent->total)?></td>
                                            </tr>
                                        <?php
                                        $subtotal += $parent->total;
                                    }
                                }
                                ?>
                                    <tr>
                                        <td colspan="4" class="td text-right text-bold">
                                            Sub-Total : &nbsp;
                                        </td>
                                        <td class="td text-right text-bold">Rp. <?=rupiah2($subtotal)?></td>
                                    </tr>
                                <?php
                            }
                        }

                        // for ($i=1; $i < 160; $i++) { 
                        //     echo '
                        //         <tr>
                        //             <td class="td text-center" style="width: 5%;">'.$i.'</td>
                        //             <td class="td" style="width: 50%;">Beras kantong ukuran 5Kg</td>
                        //             <td class="td text-center" style="width: 13%;">300 KG</td>
                        //             <td class="td text-right" style="width: 16%;">Rp. 12.000</td>
                        //             <td class="td text-right" style="width: 16%;">Rp. 3.600.000</td>
                        //         </tr>
                        //     ';
                        // }
    
                    }else{
                        ?>
                            <tr>
                                <td colspan="5" class="td text-center">
                                    Data tidak tersedia...
                                </td>
                            </tr>
                        <?php
                    }

                    $jumlahTotal = 0;
                    if($detail->num_rows() > 0){
                        foreach ($detail->result() as $key => $value) {
                            $jumlahTotal += $value->total;
                        }
                        ?>
                            <tr style="background: #C1C1C1">
                                <th colspan="4" class="td text-right text-bold">Jumlah Total :</th>
                                <th class="td text-right text-bold">Rp. <?=rupiah2($jumlahTotal)?></th>
                            </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    <?php
}
?>
</body>
</html>
