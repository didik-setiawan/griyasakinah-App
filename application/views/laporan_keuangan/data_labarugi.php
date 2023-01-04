<tr class="bg-info">
    <td class="text-uppercase text-bold p-2" width="60%">Pendapatan</td>
    <td class="p-2" width="20%"></td>
    <td class="p-2" width="20%"></td>
</tr>
<tr>
    <td class="p-1" colspan="2">1. Saldo Tahun Lalu</td>
    <td>
        <table width="100%">
            <tr>
                <td class="p-1">Rp.</td>
                <td class="p-1 text-right"><?=rupiah2($sa->saldo_awal)?></td>
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
                    <td class="p-1" colspan="2"><?=$no++?>. <?=$row->nama_kategori?></td>
                    <td>
                        <table width="100%">
                            <tr>
                                <td class="p-1">Rp.</td>
                                <td class="p-1 text-right"><?=rupiah2($cashIn)?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <?php
        }
    }else{
        ?>
            <tr>
                <td class="p-1" colspan="3">Kategori Pendapatan belum dibuat</td>
            </tr>
        <?php
    }
?>
<tr>
    <td colspan="2"></td>
    <td style="border-bottom: 2px solid black;"></td>
</tr>
<tr>
    <td class="text-bold p-2"></td>
    <td class="text-bold p-2 text-right">Total Pendapatan : </td>
    <td class="text-right p-2 text-bold">
        <table width="100%">
            <tr>
                <td class="p-1" width="10%">Rp.</td>
                <td class="p-1 text-right"><?=rupiah2($uangMasuk + $sa->saldo_awal)?></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td colspan="3" class="p-2">&nbsp;</td>
</tr>
<tr class="bg-info">
    <td class="text-uppercase text-bold p-2" width="60%">Pengeluaran</td>
    <td class="p-2" width="20%"></td>
    <td class="p-2" width="20%"></td>
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
                    <td class="p-1"><?=$no++?>. <?=$row->nama_kategori?></td>
                    <td>
                        <table width="100%">
                            <tr>
                                <td class="p-1">Rp.</td>
                                <td class="p-1 text-right"><?=rupiah2($cashOut)?></td>
                            </tr>
                        </table>
                    </td>
                    <td class="p-1"></td>
                </tr>
            <?php
        }
    }else{
        ?>
            <tr>
                <td class="p-1" colspan="3">Kategori Pengeluaran belum dibuat</td>
            </tr>
        <?php
    }
?>

<tr>
    <td></td>
    <td style="border-bottom: 2px solid black;"></td>
    <td></td>
</tr>
<tr>
    <td class="text-bold p-2 text-right">Total Pengeluaran : </td>
    <td class="text-right p-2 text-bold">
        <table width="100%">
            <tr>
                <td class="p-1" width="10%">Rp.</td>
                <td class="p-1 text-right"><?=rupiah2($uangKeluar)?></td>
            </tr>
        </table>
    </td>
    <td class="text-bold p-2"></td>
</tr>
<tr>
    <td colspan="3">&nbsp;</td>
</tr>
<tr class="bg-dark">
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
    <td class="text-bold p-2"></td>
    <td class="text-bold p-2 text-right"><?=$judulSaldo?> : </td>
    <td class="text-right p-2 text-bold">
        <table width="100%">
            <tr>
                <td class="p-1" width="10%">Rp.</td>
                <td class="p-1 text-right"><?=rupiah2($saldoAkhir)?></td>
            </tr>
        </table>
    </td>
</tr>
