<?php
    $kode = $this->master_model->get_kode_pembebasan($pembebasan->id_pembebasan);
    $cicil = $this->db->get_where('cicil_pembebasan_lahan',['id_pembebasan' => $pembebasan->id_pembebasan])->result();
    $terbayar = 0;
    foreach($cicil as $c){
        if($c->status == 2){
            $terbayar += $c->jumlah;
        }
    }
    $sisa = $pembebasan->total_pembelian - $terbayar;
?>
<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th colspan="2">Pembebasan Lahan</th>
            </tr>
            <tr>
                <th>Perumahan</th>
                <td><?= $pembebasan->nama_perumahan ?></td>
            </tr>
            <tr>
                <th>Nama Penjual</th>
                <td><?= $pembebasan->nama_penjual ?></td>
            </tr>
            <tr>
                <th>No Surat</th>
                <td><?= $pembebasan->no_surat ?></td>
            </tr>
            <tr>
                <th>Jenis Surat</th>
                <td><?= $pembebasan->jenis_surat ?></td>
            </tr>
            <tr>
                <th>Tanggal Pengalihan</th>
                <td><?php
                    $date = date_create($pembebasan->tgl_pengalihan);
                    echo date_format($date, 'd M Y');
                ?></td>
            </tr>
            <tr>
                <th>Total Pembelian</th>
                <td>Rp. <?= number_format($pembebasan->total_pembelian) ?></td>
            </tr>
            <tr>
                <th>Total pembayaran</th>
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
                <th colspan="2">Cicilan Pembayaran</th>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td><?= $pembebasan->tanggal ?></td>
            </tr>
            <tr>
                <th>Jumlah Pembayaran</th>
                <td>Rp. <?= number_format($pembebasan->jumlah) ?></td>
            </tr>
            <tr>
                <th>Kode</th>
                <td>(<?= $kode->kode .'). '. $kode->deskripsi_kode ?></td>
            </tr>
            <tr>
                <th>Sub Kode</th>
                <td>(<?= $kode->sub_kode .'). '. $kode->deskripsi_sub_kode ?></td>
            </tr>
            <tr>
                <th>Title Kode</th>
                <td>(<?= $kode->kode_title .'). '. $kode->deskripsi ?></td>
            </tr>
        </table>
    </div>
</div>
