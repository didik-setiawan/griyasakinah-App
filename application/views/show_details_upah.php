<?php
    $detail = $this->master->get_upah_confirm_id($data->id_progres);
    $kode = $this->master_model->get_kode_upah($data->id_progres);
    $terbayar = 0;
    $cicil = $this->db->get_where('cicil_progres',['id_progres' => $data->id_progres])->result();
    foreach($cicil as $c){
        if($c->status == 2){
            $terbayar += $c->jumlah;
        }
    }
    
    $sisa = $detail->total - $terbayar;

?>

<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <td><?= $detail->nama_proyek ?></td>
                </tr>
                <tr>
                    <th>Tipe</th>
                    <td><?= $detail->tipe ?></td>
                </tr>
                <tr>
                    <th>Blok</th>
                    <td><?= $detail->blok . $detail->no_rumah ?></td>
                </tr>
                <tr>
                    <th>Cluster</th>
                    <td><?= $detail->nama_cluster ?></td>
                </tr>
                <tr>
                    <th>Harga Kontrak per Blok</th>
                    <td>Rp. <?= number_format($detail->harga_kontrak); ?></td>
                </tr>
            </thead>
        </table>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Kode</th>
                    <td>(<?= $kode->kode ?>). <?= $kode->deskripsi_kode ?></td>
                </tr>
                <tr>
                    <th>Sub Kode</th>
                    <td>(<?= $kode->sub_kode ?>). <?= $kode->deskripsi_sub_kode ?></td>
                </tr>
                <tr>
                    <th>Title Kode</th>
                    <td>(<?= $kode->kode_title ?>). <?= $kode->deskripsi ?></td>
                </tr>
            </thead>
        </table>

    </div>
    <div class="col-lg-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <td><?php $date = date_create($detail->tanggal); echo date_format($date, 'd F Y'); ?></td>
                </tr>
                <tr>
                    <th>Progres Pembangunan</th>
                    <td><?= $detail->progres ?>%</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>Rp. <?= number_format($detail->total) ?></td>
                </tr>
                <tr>
                    <th>Terbayar</th>
                    <td>Rp. <?= number_format($terbayar) ?></td>
                </tr>
                <tr>
                    <th>Sisa Pembayaran</th>
                    <td>Rp. <?= number_format($sisa); ?></td>
                </tr>
                <tr>
                    <th colspan="2">
                        <img src="<?= base_url('assets/upload/progres/') . $detail->foto; ?>" alt="foto-progres" width="100%">
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>