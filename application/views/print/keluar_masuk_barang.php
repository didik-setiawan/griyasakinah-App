<!DOCTYPE html>
<html>

<head>
    <title>DAFTAR BARANG INVENTARIS</title>
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

if($pdf == 0){
    ?>
    <body onLoad="window.print()">
    <!-- <body> -->
        <button id="hidden_print" onClick="window.print()" class="button-blue">P R I N T</button>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="text-center">
                    <span class="font18 text-bold text-uppercase">Daftar Barang Inventaris</span> <br>
                    <span class="text-uppercase text-bold font16"><?=$profile->nama_lembaga?></span><br>
                    <span class="font12">dicetak pada : <b><?=$tanggal_dibuat?></b></span>
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table">
                        <thead>
                            <tr style="background: #C1C1C1;">
                                <td class="td text-center text-middle text-uppercase text-bold" style="height: 25px;">Tanggal</td>
                                <td class="td text-center text-middle text-uppercase text-bold">Deskripsi</td>
                                <td class="td text-center text-middle text-uppercase text-bold">Quantity</td>
                                <td class="td text-center text-middle text-uppercase text-bold">Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($list as $key => $row) {
                                    ?>
                                        <tr>
                                            <td class="text-center text-bold td" style="width: 15%;"><span class="text-uppercase"><?=$row->tanggal.'<br>'.$row->jam?></span></td>
                                            <td class="td" style="width: 55%;">
                                                <span class="text-uppercase text-bold"><?=$row->nama_produk.' ['.$row->kode_produk.']'?></span><br>
                                                <span class="small text-success">Kategori : <?=$row->nama_kategori?></span> <br>
                                                <span class="small text-info">Keterangan : <?=$row->keterangan?></span> <br>
                                            </td>
                                            <td class="text-center td" style="width: 15%;"><?=rupiah2($row->quantity).' '.$row->nama_satuan?></td>
                                            <td class="text-center td" style="width: 15%;"><span class="font10 text-uppercase"><?=$row->nama_tipe?></span></td>
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
        <table class="table">
            <tr>
                <td class="text-center" colspan="4">
                    <span class="font18 text-bold text-uppercase">Daftar Keluar Masuk Barang</span> <br>
                    <span class="text-uppercase text-bold font16"><?=$profile->nama_lembaga?></span><br>
                    <span class="font12">dicetak pada : <b><?=$tanggal_dibuat?></b></span>
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <thead>
                <tr style="background: #C1C1C1;">
                    <td class="td text-center text-middle text-uppercase text-bold" style="height: 25px;">Tanggal</td>
                    <td class="td text-center text-middle text-uppercase text-bold">Deskripsi</td>
                    <td class="td text-center text-middle text-uppercase text-bold">Quantity</td>
                    <td class="td text-center text-middle text-uppercase text-bold">Status</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($list as $key => $row) {
                        ?>
                            <tr>
                                <td class="text-center text-bold td" style="width: 15%;"><span class="text-uppercase"><?=$row->tanggal.'<br>'.$row->jam?></span></td>
                                <td class="td" style="width: 55%;">
                                    <span class="text-uppercase text-bold"><?=$row->nama_produk.' ['.$row->kode_produk.']'?></span><br>
                                    <span class="small text-success">Kategori : <?=$row->nama_kategori?></span> <br>
                                    <span class="small text-info">Keterangan : <?=$row->keterangan?></span> <br>
                                </td>
                                <td class="text-center td" style="width: 15%;"><?=rupiah2($row->quantity).' '.$row->nama_satuan?></td>
                                <td class="text-center td" style="width: 15%;"><span class="font10 text-uppercase"><?=$row->nama_tipe?></span></td>
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
