<?php
    $id_marketing = $fee->id_marketing;
    $q = "SELECT * FROM
    tbl_marketing JOIN
    title_kode ON tbl_marketing.title_kode = title_kode.id_title
    JOIN sub_kode ON title_kode.id_sub = sub_kode.id_sub 
    JOIN kode ON sub_kode.id_kode = kode.id_kode
    WHERE tbl_marketing.id_marketing = $id_marketing
    ";
    $kode = $this->db->query($q)->row();
    $cicil = $this->db->get_where('cicil_fee_marketing',['id_marketing' => $id_marketing])->result();
    $terbayar = 0;
    foreach($cicil as $c){
        if($c->status == 2){
            $terbayar += $c->jumlah;
        }
    }
    $sisa = $fee->nominal_fee_marketing - $terbayar;

?>
<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Konsumen</th>
                    <td><?= $fee->nama_konsumen ?></td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td><?= $fee->jk ?></td>
                </tr>
                <tr>
                    <th>No telp</th>
                    <td><?= $fee->no_hp ?></td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td><?= $fee->alamat ?></td>
                </tr>
                <tr>
                    <th>Status Menikah</th>
                    <td><?= $fee->status_menikah ?></td>
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
                    <th>Nominal Fee Marketing</th>
                    <td>Rp. <?= number_format($fee->nominal_fee_marketing); ?></td>
                </tr>
                <tr>
                    <th>Terbayarkan</th>
                    <td>Rp. <?= number_format($terbayar) ?></td>
                </tr>
                <tr>
                    <th>Sisa Pembayaran</th>
                    <td>Rp. <?= number_format($sisa) ?></td>
                </tr>
                <tr>
                    <th>Status Fee Marketing</th>
                    <td>
                                        <?php if($fee->status_fee_marketing == 0){ ?>
                                            Belum
                                        <?php } else if($fee->status_fee_marketing == 1){ ?>
                                            Menunggu Konfirmasi Accounting
                                        <?php } else if($fee->status_fee_marketing == 2){ ?>
                                            Menunggu Konfirmasi Super Admin
                                        <?php } else if($fee->status_fee_marketing == 3){ ?>
                                            Sudah
                                        <?php } else if($fee->status_fee_marketing == 4){ ?>
                                            Di tolak super admin
                                        <?php } ?>
                    </td>
                </tr>
                <tr>
               
                    <td colspan="2">
                        <img src="<?= base_url('assets/upload/fee-marketing/') . $fee->img_fee_marketing; ?>" alt="img-bukti" width="100%">
                    </td>
                </tr>
            </thead>
        </table>
    </div>

</div>