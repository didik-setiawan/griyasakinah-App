<?php
$pengeluaran = $this->master_model->get_pengeluaran_id($data->id_pengeluaran);
$kode = $this->master_model->get_kode_pengeluaran($data->id_pengeluaran);
$terbayar = 0;
$cicil = $this->db->get_where('cicil_pengeluaran_lain',['id_pengeluaran' => $data->id_pengeluaran])->result();
foreach($cicil as $c){
    if($c->status == 2){
        $terbayar += $c->jumlah;
    }
}

$sisa = $pengeluaran->jml_pengeluaran - $terbayar;

?>

<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th colspan="2">Detail Pengeluaran</th>
            </tr>
            <tr>
                <th>Tanggal Pengeluaran</th>
                <td><?php $date = date_create($data->tanggal); echo date_format($date, 'd F Y'); ?></td>
            </tr>
            <tr>
                <th>Total Pengeluaran</th>
                <td>Rp. <?= number_format($pengeluaran->jml_pengeluaran) ?></td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td><?= $pengeluaran->keterangan ?></td>
            </tr>
            <tr>
                <th>Total Terbayar</th>
                <td>Rp. <?= number_format($terbayar) ?></td>
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
                <th colspan="2">Kode</th>
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