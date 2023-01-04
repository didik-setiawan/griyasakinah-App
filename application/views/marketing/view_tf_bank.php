<p><span class="text-danger">*</span> Profil Konsumen</p>
<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>NIK</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Pekerjaan</th>
            <th>Alamat</th>
            <th>No Telp</th>
            <th>Email</th>
            <th>Status Menikah</th>
            <th>Tempat Kerja</th>
            <th>Gaji</th>
            <th>Dapat Info</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $konsumen->nik ?></td>
            <td><?= $konsumen->nama_konsumen ?></td>
            <td><?= $konsumen->jk ?></td>
            <td><?= $konsumen->pekerjaan ?></td>
            <td><?= $konsumen->alamat ?></td>
            <td><?= $konsumen->no_hp ?></td>
            <td><?= $konsumen->email ?></td>
            <td><?= $konsumen->status_menikah ?></td>
            <td><?= $konsumen->tempat_kerja ?></td>
            <td>Rp. <?= number_format($konsumen->gaji); ?></td>
            <td><?= $konsumen->dapat_info ?></td>
        </tr>
    </tbody>
</table>

<?php if($konsumen->status_menikah == 'Sudah'){ ?>
    <p><span class="text-danger">*</span> Profil Pasangan Konsumen</p>
    <table class="table table-bordered">
        <thead>
            <tr class="bg-dark text-light">
                <th>NIK</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>No Telp</th>
                <th>Email</th>
                <th>Pekerjaan</th>
                <th>Tempat Kerja</th>
                <th>Gaji</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=$pasangan->nik?></td>
                <td><?=$pasangan->nama?></td>
                <td><?=$pasangan->jk?></td>
                <td><?=$pasangan->no_hp?></td>
                <td><?=$pasangan->email?></td>
                <td><?=$pasangan->pekerjaan?></td>
                <td><?=$pasangan->tempat_kerja?></td>
                <td>Rp. <?= number_format($pasangan->gaji); ?></td>
            </tr>
        </tbody>
    </table>

<?php } ?>

<p><span class="text-danger">*</span> Transaksi Bank</p>
<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>Cluster</th>
            <th>Blok</th>
            <th>Tipe</th>
            <th>Luas Tanah (m<sup>2</sup>)</th>
            <th>Luas Bangunan (m<sup>2</sup>)</th>
            <th>Harga</th>
            <th>Harga Kesepakatan</th>
            <th>Tanda Jadi</th>
            <th>Tgl Tanda Jadi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
            <?php 
                if($status_perum == 0){
                    echo "-";
                } else if($status_perum == 1){
                    echo $bank->nama_cluster;
                } 
            ?>   
            </td>
            <td><?= $bank->blok . $bank->no_rumah ?></td>
            <td><?= $bank->tipe ?></td>
            <td><?= $bank->lt ?></td>
            <td><?= $bank->lb ?></td>
            <td>Rp. <?= number_format($bank->harga) ?></td>
            <td>Rp. <?= number_format($bank->harga_kesepakatan); ?></td>
            <td>Rp. <?= number_format($bank->tanda_jadi) ?></td>
            <td><?= $bank->tgl_tanda_jadi ?></td>
        </tr>
    </tbody>
</table>

<p><span class="text-danger">*</span> Tanda Jadi Lokasi</p>
<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>Tanda Jadi Lokasi</th>
            <th>Angsuran</th>
            <th>Cicilan Angsuran</th>
            <th>Tgl Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($tjl)){ ?>
            <tr>
                <td colspan="4" class="text-center">No Data Result</td>
            </tr>
        <?php } else { ?>
            <tr>
                <td>Rp. <?= number_format($tjl->jml_tjl) ?></td>
                <td><?= $tjl->angsuran ?></td>
                <td>Rp. <?= number_format($tjl->cicilan_angsuran) ?></td>
                <td><?= $tjl->tgl_bayar ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<p><span class="text-danger">*</span> Uang Muka</p>
<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>Uang Muka</th>
            <th>Angsuran</th>
            <th>Cicilan Angsuran</th>
            <th>Tgl Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($um)){ ?>
            <tr>
                <td colspan="4" class="text-center">No Data Result</td>
            </tr>
        <?php } else { ?>
            <tr>
                <td>Rp. <?= number_format($um->jml_um) ?></td>
                <td><?= $um->angsuran ?></td>
                <td>Rp. <?= number_format($um->cicilan_angsuran) ?></td>
                <td><?= $um->tgl_bayar ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<p><span class="text-danger">*</span> Kelebihan Tanah</p>
<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>Kelebihan Tanah</th>
            <th>Angsuran</th>
            <th>Cicilan Angsuran</th>
            <th>Tgl Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($kt)){ ?>
            <tr>
                <td colspan="4" class="text-center">No Data Result</td>
            </tr>
        <?php } else { ?>
            <tr>
                <td>Rp. <?= number_format($kt->jml_kt) ?></td>
                <td><?= $kt->angsuran ?></td>
                <td>Rp. <?= number_format($kt->cicilan_angsuran) ?></td>
                <td><?= $kt->tgl_bayar ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<p><span class="text-danger">*</span> PAK</p>
<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>PAK</th>
            <th>Angsuran</th>
            <th>Cicilan Angsuran</th>
            <th>Tgl Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($pak)){ ?>
            <tr>
                <td colspan="4" class="text-center">No Data Result</td>
            </tr>
        <?php } else { ?>
            <tr>
                <td>Rp. <?= number_format($pak->jml_pak) ?></td>
                <td><?= $pak->angsuran ?></td>
                <td>Rp. <?= number_format($pak->cicilan_angsuran) ?></td>
                <td><?= $pak->tgl_bayar ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<p><span class="text-danger">*</span> Angsuran Bank</p>
<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>Jumlah Angsuran Bank</th>
            <th>Angsuran</th>
            <th>Cicilan Angsuran</th>
            <th>Tgl Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($angsuran_bank)){ ?>
            <tr>
                <td colspan="4" class="text-center">No Data Result</td>
            </tr>
        <?php } else { ?>
            <tr>
                <td>Rp. <?= number_format($angsuran_bank->jml_angsur) ?></td>
                <td><?= $angsuran_bank->angsuran ?></td>
                <td>Rp. <?= number_format($angsuran_bank->cicilan_angsuran) ?></td>
                <td><?= $angsuran_bank->tgl_bayar ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<p><span class="text-danger">*</span> Realisasi Bank</p>
<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>Jumlah Realisasi Bank</th>
            <th>Angsuran</th>
            <th>Cicilan Angsuran</th>
            <th>Tgl Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($piutang_bank)){ ?>
            <tr>
                <td colspan="4" class="text-center">No Data Result</td>
            </tr>
        <?php } else { ?>
            <tr>
                <td>Rp. <?= number_format($piutang_bank->jml_piutang) ?></td>
                <td><?= $piutang_bank->angsuran ?></td>
                <td>Rp. <?= number_format($piutang_bank->cicilan_angsuran) ?></td>
                <td><?= $piutang_bank->tgl_bayar ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<p><span class="text-danger">*</span> Lain-Lain</p>
<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>Lain-Lain</th>
            <th>Angsuran</th>
            <th>Cicilan Angsuran</th>
            <th>Tgl Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($lain)){ ?>
            <tr>
                <td colspan="4" class="text-center">No Data Result</td>
            </tr>
        <?php } else { ?>
            <tr>
                <td>Rp. <?= number_format($lain->jml_lain) ?></td>
                <td><?= $lain->angsuran ?></td>
                <td>Rp. <?= number_format($lain->cicilan_angsuran) ?></td>
                <td><?= $lain->tgl_bayar ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
