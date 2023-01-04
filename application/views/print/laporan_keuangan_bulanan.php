<!DOCTYPE html>
<html>

<head>
    <title>LAPORAN KEUANGAN BULANAN</title>
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
            <body onLoad="window.print()">
                <button id="hidden_print" onClick="window.print()" class="button-blue">P R I N T</button>
                <table style="width: 100%;">
            
                    <tr>
                        <td class="text-center">
                            <span class="font18 text-bold">LAPORAN KEUANGAN BULANAN</span> <br>
                            <span class="text-uppercase text-bold font16"><?=$profile->nama_lembaga?></span><br>
                            Periode : <b><?=$periodeTanggal?></b>
                            <br>
                            <br>
                            <br>
                        </td>
                    </tr>
            
                    <tr>
                        <td class="text-center">
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
                        <td>
                            <table class="table">
                                <thead>
                                    <tr style="background: #C1C1C1;">
                                        <td class="td text-center text-middle text-uppercase text-bold" style="height: 35px;">Tanggal</td>
                                        <td class="td text-center text-middle text-uppercase text-bold">Keterangan</td>
                                        <td class="td text-center text-middle text-uppercase text-bold">Mutasi</td>
                                        <td class="td text-center text-middle text-uppercase text-bold">Nominal</td>
                                        <td class="td text-center text-middle text-uppercase text-bold">Saldo</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1;
                                        $saldo = 0;
                                        foreach ($laporan as $key => $row) {
                                            if($this->input->get('periode')) {
                                                $tgl = explode(" - ", $this->input->get('periode'));
                                                $today = date('Y-m-d');
                                                if($tgl[0] == $today AND $tgl[1] == $today){
                                                    $cekSaldo = $this->laporan_keuangan_model->cekSaldo(NULL, NULL, idLembaga());
                                                }else{
                                                    $cekSaldo = $this->laporan_keuangan_model->cekSaldo($tgl[0], $tgl[1], idLembaga());
                                                }
                                            }else{
                                                $cekSaldo = $this->laporan_keuangan_model->cekSaldo(NULL, NULL, idLembaga());
                                            }
                                
                                            if($row->id == $idRow->id){
                                                $saldo_awal = $cekSaldo->saldo_awal;
                                            }else{
                                                $saldo_awal = 0;
                                            }
                                            if($row->tipe_id == 1){
                                                $kredit = $row->nominal;
                                                $saldo = ($saldo + $kredit) + $saldo_awal;
                                            }else{
                                                $debit = $row->nominal;
                                                $saldo = ($saldo - $debit) + $saldo_awal;
                                            }
                                
                                            echo '
                                                <tr>
                                                    <td class="td text-top text-center" style="width: 12%">'.$row->tanggal.'</td>
                                                    <td class="td text-top text-uppercase" style="width: 45%">'.$row->nama_transaksi.'<br><span class="font9 text-success">Kategori : '.$row->kategori.'</span></td>
                                                    <td class="td text-top text-uppercase text-center" style="width: 13%">'.$row->nama_tipe.'</td>
                                                    <td class="td text-top text-right" style="width: 15%">'.rupiah($row->nominal).'</td>
                                                    <td class="td text-top text-right" style="width: 15%">'.rupiah($saldo).'</td>
                                                </tr>
                                            ';
                                        }
                                    ?>
                                    <tr>
                                        <td class="td text-right text-uppercase text-bold" colspan="4">Saldo Awal : &nbsp;</td>
                                        <td class="td text-right text-bold" style="background: #DDDDDD;"><?=rupiah($sa->saldo_awal)?></td>
                                    </tr>
                                    <tr>
                                        <td class="td text-right text-uppercase text-bold" colspan="4">Pemasukkan : &nbsp;</td>
                                        <td class="td text-right text-bold" style="background: #DDDDDD;"><?=rupiah($saldo2->pemasukan)?></td>
                                    </tr>
                                    <tr>
                                        <td class="td text-right text-uppercase text-bold" colspan="4">Pengeluaran : &nbsp;</td>
                                        <td class="td text-right text-bold" style="background: #DDDDDD;"><?=rupiah($saldo2->pengeluaran)?></td>
                                    </tr>
                                    <tr>
                                        <td class="td text-right text-uppercase text-bold" colspan="4">Saldo Akhir : &nbsp;</td>
                                        <td class="td text-right text-bold" style="background: #DDDDDD;"><?=rupiah($sa->saldo_awal + $saldo2->saldo_akhir)?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
            
                </table>
            </body>
        <?php
    }else{
        ?>
            <body>
                <table class="table">
                    <tr>
                        <td class="text-center" colspan="5">
                            <span class="font18 text-bold">LAPORAN KEUANGAN BULANAN</span> <br>
                            <span class="text-uppercase text-bold font16"><?=$profile->nama_lembaga?></span><br>
                            Periode : <b><?=$periodeTanggal?></b>
                            <br>
                            <br>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="5">
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
                    <thead>
                        <tr style="background: #C1C1C1;">
                            <td class="td text-center text-middle text-uppercase text-bold" style="height: 25px;">Tanggal</td>
                            <td class="td text-center text-middle text-uppercase text-bold">Keterangan</td>
                            <td class="td text-center text-middle text-uppercase text-bold">Mutasi</td>
                            <td class="td text-center text-middle text-uppercase text-bold">Nominal</td>
                            <td class="td text-center text-middle text-uppercase text-bold">Saldo</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            $saldo = 0;
                            foreach ($laporan as $key => $row) {
                                if($this->input->get('periode')) {
                                    $tgl = explode(" - ", $this->input->get('periode'));
                                    $today = date('Y-m-d');
                                    if($tgl[0] == $today AND $tgl[1] == $today){
                                        $cekSaldo = $this->laporan_keuangan_model->cekSaldo(NULL, NULL, idLembaga());
                                    }else{
                                        $cekSaldo = $this->laporan_keuangan_model->cekSaldo($tgl[0], $tgl[1], idLembaga());
                                    }
                                }else{
                                    $cekSaldo = $this->laporan_keuangan_model->cekSaldo(NULL, NULL, idLembaga());
                                }
                    
                                if($row->id == $idRow->id){
                                    $saldo_awal = $cekSaldo->saldo_awal;
                                }else{
                                    $saldo_awal = 0;
                                }
                                if($row->tipe_id == 1){
                                    $kredit = $row->nominal;
                                    $saldo = ($saldo + $kredit) + $saldo_awal;
                                }else{
                                    $debit = $row->nominal;
                                    $saldo = ($saldo - $debit) + $saldo_awal;
                                }
                    
                                echo '
                                    <tr>
                                        <td class="td text-top text-center" style="width: 12%">'.$row->tanggal.'</td>
                                        <td class="td text-top text-uppercase" style="width: 45%">'.$row->nama_transaksi.'<br><span class="font9 text-success">Kategori : '.$row->kategori.'</span></td>
                                        <td class="td text-top text-uppercase text-center font10" style="width: 13%">'.$row->nama_tipe.'</td>
                                        <td class="td text-top text-right" style="width: 15%">'.rupiah($row->nominal).'</td>
                                        <td class="td text-top text-right" style="width: 15%">'.rupiah($saldo).'</td>
                                    </tr>
                                ';
                            }
                        ?>
                        <tr>
                            <td class="td text-right text-uppercase text-bold" colspan="4">Saldo Awal : &nbsp;</td>
                            <td class="td text-right text-bold" style="background: #DDDDDD;"><?=rupiah($sa->saldo_awal)?></td>
                        </tr>
                        <tr>
                            <td class="td text-right text-uppercase text-bold" colspan="4">Pemasukkan : &nbsp;</td>
                            <td class="td text-right text-bold" style="background: #DDDDDD;"><?=rupiah($saldo2->pemasukan)?></td>
                        </tr>
                        <tr>
                            <td class="td text-right text-uppercase text-bold" colspan="4">Pengeluaran : &nbsp;</td>
                            <td class="td text-right text-bold" style="background: #DDDDDD;"><?=rupiah($saldo2->pengeluaran)?></td>
                        </tr>
                        <tr>
                            <td class="td text-right text-uppercase text-bold" colspan="4">Saldo Akhir : &nbsp;</td>
                            <td class="td text-right text-bold" style="background: #DDDDDD;"><?=rupiah($sa->saldo_awal + $saldo2->saldo_akhir)?></td>
                        </tr>
                    </tbody>
                </table>
            </body>
        <?php
    }
?>
</html>
