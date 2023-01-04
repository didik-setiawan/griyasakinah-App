<?php
$id = $data->id_pembayaran;
 $list = $this->master_model->get_show_details($db, $id, $where); 
 $kode = $this->master_model->get_kode_transaksi_konsumen($db, $where,$id);
 ?>
<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">

                <tr class="bg-dark text-light">
                    <th colspan="2">Data Konsumen</th>
                </tr>

                <tr>
                    <th>NIK</th>
                    <td><?= $list->nik ?></td>
                </tr>

                <tr>
                    <th>Nama</th>
                    <td><?= $list->nama_konsumen ?></td>
                </tr>
        
                <tr>
                    <th>No telp</th>
                    <td><?= $list->no_hp ?></td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td><?= $list->email; ?></td>
                </tr>
        </table>    
    </div>

    <div class="col-lg-6">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th colspan="2">Data Pembayaran</th>
            </tr>
            <tr>
                <th>Pembayaran</th>
                <td><?= $type ?></td>
            </tr>
            <tr>
                <th>Jatuh Tempo</th>
                <td><?php $date = date_create($list->jatuh_tempo); echo date_format($date, 'd F Y') ?></td>
            </tr>
            <tr>
                <th>Tgl Pembayaran</th>
                <td><?php $date1 = date_create($data->tanggal); echo date_format($date1, 'd F Y'); ?></td>
            </tr>
            <tr>
                <th>Jumlah Harus di Bayarkan</th>
                <td>Rp. <?= number_format($list->cicilan_angsuran); ?></td>
            </tr>
            <tr>
                <th>Jumlah di Bayarkan</th>
                <td>Rp. <?= number_format($data->jumlah); ?></td>
            </tr>
            <tr>
                <th>Denda</th>
                <td>Rp. <?= number_format($list->denda) ?></td>
            </tr>
        </table>
    </div>

    <div class="col-lg-6">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th colspan="2">Kode Pembayaran</th>
            </tr>
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
        </table>
    </div>

    <div class="col-lg-6">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>Bukti Transfer</th>
                    <th>Bukti Nota</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="<?= base_url('assets/bukti_pembayaran/') . $data->bukti_transfer; ?>" width="100%" alt="bukti"></td>
                    <td>
                    <img src="<?= base_url('assets/bukti_pembayaran/') . $data->bukti_nota; ?>" width="100%" alt="bukti">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>