<!DOCTYPE html>
<html>

<head>
    <title>LAPORAN KEUANGAN TAHUNAN</title>
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
if($pdf == 0){
    ?>
    <!-- <body onLoad="window.print()"> -->
    <body>
    <button id="hidden_print" onClick="window.print()" class="button-blue">P R I N T</button>
    <?php
}else{
    ?>
    <body>
    <?php
}
?>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td class="text-center" colspan="4">
                <span class="font18 text-bold">LAPORAN KEUANGAN TAHUNAN</span> <br>
                <span class="text-uppercase text-bold font16"><?=$profile->nama_lembaga?></span><br>
                Periode Tahun : <b><?=$tahun?></b>
                <br>
                <br>
                <br>
            </td>
        </tr>
        <tr>
            <td class="text-center" colspan="4">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="background: #C1C1C1;">
                        <td class="td text-center text-middle text-uppercase text-bold" style="width: 25%;">SALDO AWAL</td>
                        <td class="td text-center text-middle text-uppercase text-bold" style="width: 25%;">PEMASUKKAN</td>
                        <td class="td text-center text-middle text-uppercase text-bold" style="width: 25%;">PENGELUARAN</td>
                        <td class="td text-center text-middle text-uppercase text-bold" style="width: 25%;">SALDO AKHIR</td>
                    </tr>
                    <tr style="background: #dddddd;">
                        <td class="td text-center text-middle"><?=rupiah($sa->saldo_awal)?></td>
                        <td class="td text-center text-middle"><?=rupiah($saldo2->pemasukan)?></td>
                        <td class="td text-center text-middle"><?=rupiah($saldo2->pengeluaran)?></td>
                        <td class="td text-center text-middle"><?=rupiah($sa->saldo_awal + $saldo2->saldo_akhir)?></td>
                    </tr>
                    <tr>
                        <td style="height: 35px;" colspan="4"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="height: 40px;" class="text-center text-bold font18">REKAPITULASI TRANSAKSI</td>
        </tr>
        <tr style="background: #C1C1C1;">
            <td class="td text-center text-middle text-uppercase text-bold" style="height: 35px; width: 46%;">INDUK TRANSAKSI</td>
            <td class="td text-center text-middle text-uppercase text-bold" style="height: 35px; width: 18%;">PEMASUKKAN</td>
            <td class="td text-center text-middle text-uppercase text-bold" style="height: 35px; width: 18%;">PENGELUARAN</td>
            <td class="td text-center text-middle text-uppercase text-bold" style="height: 35px; width: 18%;">SALDO</td>
        </tr>

        <?php
            if($induk->num_rows() > 0){
                $saldo = 0;
                $cashIn1 = 0;
                $cashOut1 = 0;
                $no = 1;
                foreach ($induk->result() as $key => $row) {
                    $kategori = $this->laporan_keuangan_model->kategoriTransaksi(NULL, NULL, $row->id, NULL, NULL)->result();
                    // $kategori = NULL, $tipe = NULL, $tahun = NULL, $induk = NULL
                    $pemasukkan = $this->laporan_keuangan_model->getTotalLaporan(NULL, 1, $tahun, $row->id);
                    if($pemasukkan->num_rows() > 0){
                        $cashIn1 = $pemasukkan->row()->pemasukan;
                    }else{
                        $cashIn1 = 0;
                    }
                    $pengeluaran = $this->laporan_keuangan_model->getTotalLaporan(NULL, 2, $tahun, $row->id);
                    if($pengeluaran->num_rows() > 0){
                        $cashOut1 = $pengeluaran->row()->pengeluaran;
                    }else{
                        $cashOut1 = 0;
                    }
                    
                    ?>
                        <tr>
                            <td class="td text-uppercase"><?=$no++.'. '.$row->nama_kategori?></td>
                            <td class="td text-right"><?=rupiah2($cashIn1)?></td>
                            <td class="td text-right"><?=rupiah2($cashOut1)?></td>
                            <td class="td text-right"></td>
                        </tr>
                    <?php
                }
                ?>
                    <tr style="background: #C1C1C1;">
                        <td class="td text-right text-middle text-bold" style="height: 35px;">JUMLAH TOTAL : </td>
                        <td class="td text-right text-middle text-bold"><?=rupiah($saldo2->pemasukan)?></td>
                        <td class="td text-right text-middle text-bold"><?=rupiah($saldo2->pengeluaran)?></td>
                        <td class="td text-right text-middle text-bold"><?=rupiah($sa->saldo_awal + $saldo2->saldo_akhir)?></td>
                    </tr>
                <?php
            }else {
                echo '
                    <tr>
                        <td colspan="4" class="td text-center">data induk kategori belum ada</td>
                    </tr>
                ';
            }
        ?>
        <tr>
            <td colspan="4" style="height: 35px;"></td>
        </tr>
        <tr>
            <td colspan="4" style="height: 40px;" class="text-center text-bold font18">RINCIAN PER KATEGORI TRANSAKSI</td>
        </tr>
        <?php
            if($induk->num_rows() > 0){
                $saldo = 0;
                $cashIn1 = 0;
                $cashOut1 = 0;
                foreach ($induk->result() as $key => $row) {
                    $kategori = $this->laporan_keuangan_model->kategoriTransaksi(NULL, NULL, $row->id, NULL, NULL)->result();
                    // $kategori = NULL, $tipe = NULL, $tahun = NULL, $induk = NULL
                    $pemasukkan = $this->laporan_keuangan_model->getTotalLaporan(NULL, 1, $tahun, $row->id);
                    if($pemasukkan->num_rows() > 0){
                        $cashIn1 = $pemasukkan->row()->pemasukan;
                    }else{
                        $cashIn1 = 0;
                    }
                    $pengeluaran = $this->laporan_keuangan_model->getTotalLaporan(NULL, 2, $tahun, $row->id);
                    if($pengeluaran->num_rows() > 0){
                        $cashOut1 = $pengeluaran->row()->pengeluaran;
                    }else{
                        $cashOut1 = 0;
                    }
                    
                    ?>
                        <tr>
                            <td class="text-bold text-uppercase font18" colspan="4"><?=$row->nama_kategori?></td>
                        </tr>
                        <tr style="background: #C1C1C1;">
                            <td class="td text-center text-middle text-uppercase text-bold" style="height: 35px;">DESKRIPSI</td>
                            <td class="td text-center text-middle text-uppercase text-bold">PEMASUKKAN</td>
                            <td class="td text-center text-middle text-uppercase text-bold">PENGELUARAN</td>
                            <td class="td text-center text-middle text-uppercase text-bold">SALDO</td>
                        </tr>
                    <?php
                    foreach ($kategori as $key => $value) {
                        // $kategori = NULL, $tipe = NULL, $tahun = NULL, $induk = NULL
                        $pemasukkan = $this->laporan_keuangan_model->getTotalLaporan($value->id, 1, $tahun, NULL);
                        if($pemasukkan->num_rows() > 0){
                            $cashIn = $pemasukkan->row()->sub_total;
                        }else{
                            $cashIn = 0;
                        }
                        $pengeluaran = $this->laporan_keuangan_model->getTotalLaporan($value->id, 2, $tahun, NULL);
                        if($pengeluaran->num_rows() > 0){
                            $cashOut = $pengeluaran->row()->sub_total;
                        }else{
                            $cashOut = 0;
                        }
                        ?>
                            <tr>
                                <td class="td" width="40%"><?=$value->nama_kategori?></td>
                                <td class="td text-right text-primary"><?=rupiah2($cashIn)?></td>
                                <td class="td text-right text-danger"><?=rupiah2($cashOut)?></td>
                                <td class="td text-right"></td>
                            </tr>
                        <?php
                    }
                    ?>
                        <tr style="background: #DDD;">
                            <td class="td text-bold text-uppercase text-right">Sub-Total :</td>
                            <td class="td text-right text-bold"><?=rupiah($cashIn1)?></td>
                            <td class="td text-right text-bold"><?=rupiah($cashOut1)?></td>
                            <td class="td text-right text-bold"><?=rupiah($cashIn1 - $cashOut1)?></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="height: 35px;"></td>
                        </tr>
                    <?php
                }
            }else {
                echo '
                    <tr>
                        <td colspan="4" class="td text-center">data induk kategori belum ada</td>
                    </tr>
                ';
            }
        ?>

    </table>
</body>
</html>
