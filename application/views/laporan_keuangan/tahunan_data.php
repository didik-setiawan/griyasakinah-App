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
                <tr class="bg-gradient-dark">
                    <td class="text-bold text-uppercase"><?=$row->nama_kategori?></td>
                    <td class="text-right text-bold"></td>
                    <td class="text-right text-bold"></td>
                    <td class="text-right text-bold"></td>
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
                        <td width="40%"><i class="fa fa-check-circle"></i> <?=$value->nama_kategori?></td>
                        <td class="text-right text-primary"><?=rupiah($cashIn)?></td>
                        <td class="text-right text-danger"><?=rupiah($cashOut)?></td>
                        <td class="text-right"></td>
                    </tr>
                <?php
            }
            ?>
                <tr class="bg-secondary">
                    <td class="text-bold text-uppercase text-right">Sub-Total :</td>
                    <td class="text-right text-bold"><?=rupiah($cashIn1)?></td>
                    <td class="text-right text-bold"><?=rupiah($cashOut1)?></td>
                    <td class="text-right text-bold"><?=rupiah($cashIn1 - $cashOut1)?></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                </tr>
            <?php
        }
    }else {
        echo '
            <tr>
                <td colspan="4" class="text-center">data induk kategori belum ada</td>
            </tr>
            ';
    }

?>
