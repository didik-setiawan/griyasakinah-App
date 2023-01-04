<?php
    $data_cicil = $this->db->get_where('cicil_insidentil',['id_insidentil' => $insidentil->insidentil_id, 'status' => 2])->result();
    $terbayar = 0;
    foreach($data_cicil as $dc){
        $terbayar += $dc->jml_pengajuan;
    }
    $sisa = $insidentil->nilai - $terbayar;
?>
<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th colspan="2">Detail Proyek</th>
            </tr>
            <tr>
                <th>Nama Proyek</th>
                <td><?= $insidentil->nama_proyek ?></td>
            </tr>
            <tr>
                <th>Nama Perumahan</th>
                <td><?= $insidentil->nama_perumahan ?></td>
            </tr>
            <tr>
                <th>Keterangan Proyek</th>
                <td><?= $insidentil->keterangan ?></td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td>Rp. <?= number_format($insidentil->nilai); ?></td>
            </tr>
            <tr>
                <th>Total Terbayarkan</th>
                <td>Rp. <?= number_format($terbayar); ?></td>
            </tr>
            <tr>
                <th>Sisa Pembayaran</th>
                <td>Rp. <?= number_format($sisa); ?></td>
            </tr>
        </table>
    </div>
    <div class="col-lg-6">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th colspan="2">Detail Kode</th>
            </tr>
            <tr>
                <th>Kode</th>
                <td>(<?= $kode->kode .') '. $kode->deskripsi_kode ?></td>
            </tr>
            <tr>
                <th>Sub Kode</th>
                <td>(<?= $kode->sub_kode .') '. $kode->deskripsi_sub_kode ?></td>
            </tr>
            <tr>
                <th>Title Kode</th>
                <td>(<?= $kode->kode_title .') '. $kode->deskripsi ?></td>
            </tr>
        </table>
    </div>
</div>