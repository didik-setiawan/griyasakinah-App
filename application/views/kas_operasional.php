<?php
    $id_kas = $data->id_kas;
    $data_cicil = $this->db->get_where('cicil_kas',['id_kas' => $id_kas])->result();
    $terbayar = 0;
    $jumlah = $data->jumlah;
    foreach($data_cicil as $d){
        if($d->status == 2){
            $terbayar += $d->jumlah;
        }
    }
    $sisa = $jumlah - $terbayar;


    $q = "SELECT * FROM
        kas_operasional JOIN
        title_kode ON kas_operasional.title_kode = title_kode.id_title
        JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
        JOIN kode ON sub_kode.id_kode = kode.id_kode
        WHERE kas_operasional.id_kas = $id_kas";
        $kode = $this->db->query($q)->row();

?>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>Tanggal Input</th>
                    <th>Keterangan</th>
                    <th>Jumlah Pengajuan</th>
                    <th>Jumlah Terbayar</th>
                    <th>Sisa Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php $date = date_create($data->tgl_input); echo date_format($date, 'd F Y'); ?></td>
                    <td><?= $data->keterangan ?></td>
                    <td>Rp. <?= number_format($data->jumlah) ?></td>
                    <td>Rp. <?= number_format($terbayar) ?></td>
                    <td>Rp. <?= number_format($sisa) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>Kode</th>
                    <th>Sub Kode</th>
                    <th>Title Kode</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $kode->deskripsi_kode ?></td>
                    <td><?= $kode->deskripsi_sub_kode ?></td>
                    <td><?= $kode->deskripsi ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>