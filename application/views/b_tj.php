<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">
            <tr>
                <th>Nama Konsumen</th>
                <td><?= $data->nama_konsumen ?></td>
            </tr>
            <tr>
                <th>NIK</th>
                <td><?= $data->nik ?></td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td><?= $data->jk ?></td>
            </tr>
            <tr>
                <th>No Telp</th>
                <td><?= $data->no_hp ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= $data->email ?></td>
            </tr>
            <tr>
                <th>Pekerjaan</th>
                <td><?= $data->pekerjaan ?></td>
            </tr>
            <tr>
                <th>Jumlah harus di bayarkan</th>
                <td>Rp. <?= number_format($data->tanda_jadi) ?></td>
            </tr>
            <tr>
                <th>Jumlah pembayaran</th>
                <td>Rp. <?= number_format($cicil->jumlah) ?></td>
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
    <div class="col-lg-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Bukti Transfer</th>
                    <th>Bukti Nota</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="<?= base_url('assets/bukti_pembayaran/') . $cicil->bukti_transfer; ?>" width="100%" alt="bukti"></td>
                    <td><img src="<?= base_url('assets/bukti_pembayaran/') . $cicil->bukti_transfer; ?>" width="100%" alt="bukti"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>