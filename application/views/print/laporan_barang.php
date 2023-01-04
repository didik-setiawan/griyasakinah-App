<!DOCTYPE html>
<html>

<head>
    <title>LAPORAN BARANG INVENTARIS</title>
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
                    <span class="font18 text-bold text-uppercase">Laporan Inventaris</span> <br>
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
                                <td class="td text-center text-middle text-uppercase text-bold" style="height: 25px;">Kode</td>
                                <td class="td text-center text-middle text-uppercase text-bold">Nama Barang</td>
                                <td class="td text-center text-middle text-uppercase text-bold">KAT</td>
                                <td class="td text-center text-middle text-uppercase text-bold">IN</td>
                                <td class="td text-center text-middle text-uppercase text-bold">OUT</td>
                                <td class="td text-center text-middle text-uppercase text-bold">STOK</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $saldo = 0;
                            $stok_akhir = 0;
                            $nilaiStok = 0;
                        
                            foreach ($list as $key => $row) {
                                if($this->input->get('periode')) {
                                    $tgl = explode(" - ", $this->input->get('periode'));
                                    $today = date('Y-m-d');
                                    if($tgl[0] == $today && $tgl[1] == $today){
                                        $stokA = $this->inventaris_model->totalStok($row->id_produk, 1, NULL, NULL)->row();
                                        $stokB = $this->inventaris_model->totalStok($row->id_produk, 2, NULL, NULL)->row();
                                    }else{
                                        $stokA = $this->inventaris_model->totalStok($row->id_produk, 1, $tgl[0], $tgl[1])->row();
                                        $stokB = $this->inventaris_model->totalStok($row->id_produk, 2, $tgl[0], $tgl[1])->row();
                                    }
                                }else{
                                    $stokA = $this->inventaris_model->totalStok($row->id_produk, 1, NULL, NULL)->row();
                                    $stokB = $this->inventaris_model->totalStok($row->id_produk, 2, NULL, NULL)->row();                
                                }
                    
                                if(!empty($stokA->total_stok)){
                                    $stok_masukA = $stokA->total_stok;
                                    $textA = NULL;
                                }else{
                                    $stok_masukA = 0;
                                    $textA = 'text-danger';
                                }
                    
                                if(!empty($stokB->total_stok)){
                                    $stok_keluarA = $stokB->total_stok;
                                    $textB = NULL;
                                }else{
                                    $stok_keluarA = 0;
                                    $textB = 'text-danger';
                                }
                                $stok_akhir = $stok_masukA - $stok_keluarA;
                                $nilaiStok = $row->harga * $stok_akhir;
                    
                                ?>
                                    <tr>
                                        <td class="text-center text-bold td text-uppercase" style="width: 10%;"><?=$row->kode_produk?></td>
                                        <td class="td" style="width: 40%;">
                                            <span class="text-uppercase text-bold"><?=$row->nama_produk?></span> <br>
                                            <span class="small text-info">Estimasi harga <b><?=rupiah($row->harga)?></b></span> <br>
                                            <span class="small text-success">Nilai Stok = <?=rupiah($row->harga)?> x <?=rupiah2($stok_akhir).' '.$row->nama_satuan.' = <b>'.rupiah($nilaiStok)?></b></span>
                                        </td>
                                        <td class="text-center td" style="width: 10%;"><span class="text-capitalize"><?=$row->nama_kategori?></span></td>
                                        <td class="text-center td" style="width: 10%;"><?=rupiah2($stok_masukA).' '.$row->nama_satuan?></td>
                                        <td class="text-center td" style="width: 10%;"><?=rupiah2($stok_keluarA).' '.$row->nama_satuan?></td>
                                        <td class="text-center td" style="width: 10%;"><?=rupiah2($stok_akhir).' '.$row->nama_satuan?></td>
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
                <td class="text-center" colspan="6">
                    <span class="font18 text-bold text-uppercase">Laporan Inventaris</span> <br>
                    <span class="text-uppercase text-bold font16"><?=$profile->nama_lembaga?></span><br>
                    <span class="font12">dicetak pada : <b><?=$tanggal_dibuat?></b></span>
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <thead>
                <tr style="background: #C1C1C1;">
                    <td class="td text-center text-middle text-uppercase text-bold" style="height: 25px;">Kode</td>
                    <td class="td text-center text-middle text-uppercase text-bold">Nama Barang</td>
                    <td class="td text-center text-middle text-uppercase text-bold">KAT</td>
                    <td class="td text-center text-middle text-uppercase text-bold">IN</td>
                    <td class="td text-center text-middle text-uppercase text-bold">OUT</td>
                    <td class="td text-center text-middle text-uppercase text-bold">STOK</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $saldo = 0;
                    $stok_akhir = 0;
                    $nilaiStok = 0;
                
                    foreach ($list as $key => $row) {
                        if($this->input->get('periode')) {
                            $tgl = explode(" - ", $this->input->get('periode'));
                            $today = date('Y-m-d');
                            if($tgl[0] == $today && $tgl[1] == $today){
                                $stokA = $this->inventaris_model->totalStok($row->id_produk, 1, NULL, NULL)->row();
                                $stokB = $this->inventaris_model->totalStok($row->id_produk, 2, NULL, NULL)->row();
                            }else{
                                $stokA = $this->inventaris_model->totalStok($row->id_produk, 1, $tgl[0], $tgl[1])->row();
                                $stokB = $this->inventaris_model->totalStok($row->id_produk, 2, $tgl[0], $tgl[1])->row();
                            }
                        }else{
                            $stokA = $this->inventaris_model->totalStok($row->id_produk, 1, NULL, NULL)->row();
                            $stokB = $this->inventaris_model->totalStok($row->id_produk, 2, NULL, NULL)->row();                
                        }
            
                        if(!empty($stokA->total_stok)){
                            $stok_masukA = $stokA->total_stok;
                            $textA = NULL;
                        }else{
                            $stok_masukA = 0;
                            $textA = 'text-danger';
                        }
            
                        if(!empty($stokB->total_stok)){
                            $stok_keluarA = $stokB->total_stok;
                            $textB = NULL;
                        }else{
                            $stok_keluarA = 0;
                            $textB = 'text-danger';
                        }
                        $stok_akhir = $stok_masukA - $stok_keluarA;
                        $nilaiStok = $row->harga * $stok_akhir;
            
                        ?>
                            <tr>
                                <td class="text-center text-bold td text-uppercase" style="width: 10%;"><?=$row->kode_produk?></td>
                                <td class="td" style="width: 40%;">
                                    <span class="text-uppercase text-bold"><?=$row->nama_produk?></span> <br>
                                    <span class="small text-info">Estimasi harga <b><?=rupiah($row->harga)?></b></span> <br>
                                    <span class="small text-success">Nilai Stok = <?=rupiah($row->harga)?> x <?=rupiah2($stok_akhir).' '.$row->nama_satuan.' = <b>'.rupiah($nilaiStok)?></b></span>
                                </td>
                                <td class="text-center td" style="width: 10%;"><span class="text-capitalize"><?=$row->nama_kategori?></span></td>
                                <td class="text-center td" style="width: 10%;"><?=rupiah2($stok_masukA).' '.$row->nama_satuan?></td>
                                <td class="text-center td" style="width: 10%;"><?=rupiah2($stok_keluarA).' '.$row->nama_satuan?></td>
                                <td class="text-center td" style="width: 10%;"><?=rupiah2($stok_akhir).' '.$row->nama_satuan?></td>
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
