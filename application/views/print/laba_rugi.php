<!DOCTYPE html>
<html>

<head>
    <title>LAPORAN LABA RUGI</title>
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

        .table { 
            width: 100%; 
            border-collapse: collapse;
            padding-top: 1px;
            padding-bottom: 1px;
        }
        .td { 
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 2px;
            font-size: 12px;
        }


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
    <body onLoad="window.print()">
    <!-- <body> -->
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
            <td class="text-center" colspan="3">
                <span class="text-uppercase text-bold font18"><?=$profile->nama_lembaga?></span><br>
                <span class="font16 text-bold">LAPORAN LABA RUGI</span> <br>
                Periode : <b><?=$tahun?></b>
                <br>
                <br>
                <br>
            </td>
        </tr>

        <tr style="background: #BBB">
            <td colspan="3" class="td font16 text-uppercase text-bold" style="height: 35px;">Pendapatan</td>
        </tr>

        <tr>
            <td class="td text-uppercase">1. Saldo Tahun Lalu</td>
            <td class="td"></td>
            <td class="td">
                <table style="width: 100%;">
                    <tr>
                        <td width="10%">Rp.</td>
                        <td class="text-right"><?=rupiah2($sa->saldo_awal)?></td>
                    </tr>
                </table>
            </td>
        </tr>

        <?php
            $uangMasuk = 0;
            if($pemasukkan->num_rows() > 0){
                $no = 2;
                foreach ($pemasukkan->result() as $key => $row) {
                    // $kategori = NULL, $tipe = NULL, $tahun = NULL, $induk = NULL, $neraca = NULL
                    $pemasukkan = $this->laporan_keuangan_model->getTotalLaporan($row->id, 1, $tahun, NULL, NULL);
                    if($pemasukkan->num_rows() > 0){
                        $cashIn = $pemasukkan->row()->sub_total;
                    }else{
                        $cashIn = 0;
                    }
                    $uangMasuk += $cashIn;
                    ?>
                        <tr>
                            <td class="td text-uppercase"><?=$no++?>. <?=$row->nama_kategori?></td>
                            <td class="td"></td>
                            <td class="td">
                                <table style="width: 100%;">
                                    <tr>
                                        <td width="10%">Rp.</td>
                                        <td class="text-right"><?=rupiah2($cashIn)?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php
                }
            }else{
                ?>
                    <tr>
                        <td class="td" colspan="4">Kategori Pendapatan belum dibuat</td>
                    </tr>
                <?php
            }
        ?>
        <tr style="background: #EEE;">
            <td colspan="2" class="text-uppercase text-bold td text-right">Total Pendapatan : </td>
            <td class="text-right td text-bold">
                <table width="100%">
                    <tr>
                        <td width="10%">Rp.</td>
                        <td class="text-right"><?=rupiah2($uangMasuk + $sa->saldo_awal)?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="height: 25px;">&nbsp;</td>
        </tr>

        <tr style="background: #BBB">
            <td colspan="3" class="td font16 text-uppercase text-bold" style="height: 35px;">Pengeluaran</td>
        </tr>
        <?php
            $uangKeluar = 0;
            if($pengeluaran->num_rows() > 0){
                $no = 1;
                foreach ($pengeluaran->result() as $key => $row) {
                    // $kategori = NULL, $tipe = NULL, $tahun = NULL, $induk = NULL, $neraca = NULL
                    $pengeluaran = $this->laporan_keuangan_model->getTotalLaporan($row->id, 2, $tahun, NULL, NULL);
                    if($pengeluaran->num_rows() > 0){
                        $cashOut = $pengeluaran->row()->sub_total;
                    }else{
                        $cashOut = 0;
                    }
                    $uangKeluar += $cashOut;
                                    
                    ?>
                        <tr>
                            <td class="td text-uppercase"><?=$no++?>. <?=$row->nama_kategori?></td>
                            <td class="td">
                                <table width="100%">
                                    <tr>
                                        <td width="10%">Rp.</td>
                                        <td class="p-1 text-right"><?=rupiah2($cashOut)?></td>
                                    </tr>
                                </table>
                            </td>
                            <td class="td"></td>
                        </tr>
                    <?php
                }
            }else{
                ?>
                    <tr>
                        <td class="td" colspan="3">Kategori Pengeluaran belum dibuat</td>
                    </tr>
                <?php
            }
        ?>
        <tr style="background: #EEE;">
            <td style="width: 60%;" class="text-uppercase text-bold td text-right">Total Pengeluaran : </td>
            <td style="width: 20%;" class="text-right td text-bold">
                <table width="100%">
                    <tr>
                        <td width="10%">Rp.</td>
                        <td class="text-right"><?=rupiah2($uangKeluar)?></td>
                    </tr>
                </table>
            </td>
            <td style="width: 20%;" class="td"></td>
        </tr>
        <tr>
            <td colspan="3" style="height: 25px;">&nbsp;</td>
        </tr>
        <tr style="background: #BBB;">
            <?php
                $saldoAkhir = ($uangMasuk + $sa->saldo_awal) - $uangKeluar;
                if($saldoAkhir > 0){
                    $judulSaldo = 'Saldo Akhir';
                    // $judulSaldo = 'Laba Usaha';
                }else{
                    $judulSaldo = 'Saldo Akhir';
                    // $judulSaldo = 'Rugi Usaha';
                }
            ?>
            <td colspan="2" class="text-bold text-uppercase td font16 text-right"><?=$judulSaldo?> : </td>
            <td class="text-right td text-bold">
                <table width="100%">
                    <tr>
                        <td width="10%" class="font16">Rp.</td>
                        <td class="text-right font16"><?=rupiah2($saldoAkhir)?></td>
                    </tr>
                </table>
            </td>
        </tr>


    </table>
</body>
</html>
