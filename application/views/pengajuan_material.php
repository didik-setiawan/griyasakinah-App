<?php
$id_pengajuan = $list->id_pengajuan;
$time = $list->time;

$q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $list->id_proyek AND tbl_kavling.id_tipe = $list->id_tipe";
$kav = $this->db->query($q)->result();

$q1 = "SELECT SUM(jml_pengajuan) AS pengajuan_jml FROM cicil_material WHERE id_pengajuan = $id_pengajuan AND status = 2";
$jml_pengajuan = $this->db->query($q1)->row()->pengajuan_jml;

$q2 = "SELECT master_logistik.jml_pengajuan, master_logistik_detail.harga_real FROM master_logistik, master_logistik_detail WHERE master_logistik.time = $time AND master_logistik.id = master_logistik_detail.logistik_id";
$harga_real = $this->db->query($q2)->result();
$harga_rill = 0;

$q3 = "SELECT * FROM
pengajuan_material JOIN
title_kode ON pengajuan_material.title_kode = title_kode.id_title
JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
JOIN kode ON sub_kode.id_kode = kode.id_kode
WHERE pengajuan_material.id_pengajuan = $id_pengajuan";
$kode = $this->db->query($q3)->row();

foreach($harga_real as $hr){
    $math = $hr->harga_real * $hr->jml_pengajuan;
    $harga_rill += $math;
}
$sisa_pembayaran = $harga_rill - $jml_pengajuan;



$id_perum = $this->session->userdata('id_perumahan');
        $this->db->select('
            pengajuan_material.*,
            master_logistik.jml_pengajuan,
            master_logistik.id as id_logistik,
            master_logistik.tipe as type,
            tbl_proyek_material.harga,
            tbl_proyek_material.proyek_id,
            master_proyek.nama_proyek,
            master_material.nama_material,
            master_produk_kategori.kategori_produk,
            master_produk_unit.nama_satuan,
            tbl_tipe.tipe
        ')
        ->from('pengajuan_material')
        ->join('master_logistik','pengajuan_material.time = master_logistik.time')
        ->join('tbl_proyek_material', 'master_logistik.proyek_material_id = tbl_proyek_material.id')
        ->join('master_proyek','pengajuan_material.id_proyek = master_proyek.id')
        ->join('master_material','tbl_proyek_material.material_id = master_material.id')
        ->join('master_produk_kategori','master_material.kategori_id = master_produk_kategori.id')
        ->join('master_produk_unit','master_material.unit_id = master_produk_unit.id')
        ->join('tbl_tipe','tbl_proyek_material.tipe_id = tbl_tipe.id_tipe')
        ->where('pengajuan_material.id_pengajuan', $id_pengajuan)
        ->where('tbl_tipe.id_perum', $id_perum);
        $material =  $this->db->get()->result();

?>
<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th colspan="2">Detail Pengajuan</th>
                </tr>
                <tr>
                    <th>Jumlah Pengajuan</th>
                    <td>Rp. <?= number_format($list->pengajuan_jml) ?></td>
                </tr>
                <tr>
                    <th>Total Pembayaran</th>
                    <td>Rp. <?= number_format($harga_rill); ?></td>
                </tr>
                <tr>
                    <th>Total Terbayarkan</th>
                    <td>Rp. <?= number_format($jml_pengajuan); ?></td>
                </tr>
                <tr>
                    <th>Sisa Pembayaran</th>
                    <td>Rp. <?= number_format($sisa_pembayaran); ?></td>
                </tr>
            </thead>
        </table>
    </div>
    <div class="col-lg-6">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th colspan="2">Detail Proyek</th>
            </tr>
            <tr>
                <th>Nama Proyek</th>
                <td><?= $list->nama_proyek ?></td>
            </tr>
            <tr>
                <th>Nama Perumahan</th>
                <td><?= $list->nama_perumahan ?></td>
            </tr>
            <tr>
                <th>Tipe</th>
                <td><?= $list->nama_tipe ?></td>
            </tr>
            <tr>
                <th>Cluster</th>
                <td><?= $list->nama_cluster ?></td>
            </tr>
            <tr>
                <th>Kavling</th>
                <td>
                    <ul>
                        <?php foreach($kav as $k){ ?>
                            <li><?= $k->blok . $k->no_rumah ?></li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-lg-12">
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
    <div class="col-lg-12">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th colspan="5">Detail Material</th>
            </tr>
            <tr>
                <th>Nama Material</th>
                <th>Jumlah Pengajuan</th>
                <th>Sumber Material</th>
                <th>Harga RAB</th>
                <th>Hraga Real</th>
            </tr>
            <?php
                $harga_rab = 0;
                $harga_rill1 = 0;

                 foreach($material as $l){ 
                     
                    // $harga_rab += $l->harga * $l->jml_pengajuan;
                    // $harga_rill += $harga_real->harga_real * $l->jml_pengajuan;

                    $proyek_name = $this->db->get_where('master_proyek',['id' => $l->proyek_id])->row()->nama_proyek;

                    if($l->type == 1){
                        $harga_real = $this->db->get_where('master_logistik_detail',['logistik_id' => $l->id_logistik])->row();  
                        
                        $source = 'RAB';
                        $harga_rab += $l->harga * $l->jml_pengajuan;
                        $harga_rill1 += $harga_real->harga_real * $l->jml_pengajuan;
                    } else if($l->type == 2){
                        $source = 'Logistik Gudang';
                    }

                ?>
                <tr>
                   
                    <td><b><?= $l->nama_material ?></b> <br> <small class="text-success"><?= $l->kategori_produk ?></small></td>
                    <td><?= $l->jml_pengajuan .' '. $l->nama_satuan ?></td>
                    <td><b><?= $source ?></b> <br> <small class="text-success">Proyek <?= $proyek_name ?></small> </td>
                    <td>
                        <?php if($l->type == 1){ ?>
                            <b>Rp. <?= number_format($l->harga * $l->jml_pengajuan) ?></b> <br> <small class="text-primary">(Rp. <?= number_format($l->harga); ?> / item)</small>
                        <?php } else if($l->type == 2) { ?>
                            -
                        <?php } ?>
                    </td>
                    <td>
                        <?php if($l->type == 1){ ?>
                            <?php if($harga_real){ ?>
                                <b>Rp. <?= number_format($harga_real->harga_real * $l->jml_pengajuan); ?></b> <br> <small class="text-danger">(Rp.<?= number_format($harga_real->harga_real); ?> / item)</small>
                            <?php } else { ?>
                                -
                            <?php } ?>
                        <?php } else if($l->type == 2){ ?>
                            -
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <th colspan="3">Total</th>
                    <th class="text-danger">Rp. <?= number_format($harga_rab) ?></th>
                    <th class="text-success">Rp. <?= number_format($harga_rill1) ?></th>
                </tr>
        </table>
    </div>
</div>