<?php
    $kode = $this->master->getKodePembatalan($batal->id_pembatalan);
    $terbayar = 0;
    $cicil = $this->db->get_where('cicil_pembatalan',['id_pembatalan' => $batal->id_pembatalan])->result();
    foreach($cicil as $c){
        if($c->status == 2){
            $terbayar += $c->jumlah;
        }
    }

    $sisa = $batal->total_pengembalian - $terbayar;

?>
<div class="row">
    <div class="col-lg-6">
      
<table class="table table-bordered">
<tr>
    <th>Nama Konsumen</th>
    <td><?= $batal->nama_konsumen ?></td>
</tr>
<tr>
    <th>NIK</th>
    <td><?= $batal->nik ?></td>
</tr>
<tr>
    <th>No Hp</th>
    <td><?= $batal->no_hp ?></td>
</tr>
<tr>
    <th>Email</th>
    <td><?= $batal->email ?></td>
</tr>
<tr>
    <th>Pekerjaan</th>
    <td><?= $batal->pekerjaan ?></td>
</tr>
<tr>
    <th>Jenis Kelamin</th>
    <td><?= $batal->jk ?></td>
</tr>
<tr>
    <th>Total Pengembalian</th>
    <td>Rp. <?= number_format($batal->total_pengembalian) ?></td>
</tr>
<tr>
    <th>Jumlah Terbayar</th>
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
            <td>(<?= $kode->title_kode .'). '. $kode->deskripsi ?></td>
        </tr>
    </table>
</div>
</div>