<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th colspan="2">Detail Lain Lain</th>
            </tr>
            <tr>
                <th>Nama Proyek</th>
                <td><?= $lain->nama_proyek ?></td>
            </tr>
            <tr>
                <th>Nama Perumahan</th>
                <td><?= $lain->nama_perumahan ?></td>
            </tr>
            <tr>
                <th>Kota</th>
                <td><?= $lain->kabupaten ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?= $lain->alamat_perumahan ?></td>
            </tr>
            <tr>
                <th>Tipe</th>
                <td><?= $lain->tipe ?></td>
            </tr>
            <tr>
                <th>Cluster</th>
                <td><?= $lain->nama_cluster ?></td>
            </tr>
            <tr>
                <th>Kavling</th>
                <td>
                    <ul>
                        <?php
                            $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $lain->proyek_id AND tbl_kavling.id_tipe = $lain->tipe_id";
                            $kav = $this->db->query($q)->result();
                            $jml_kav = $this->db->query($q)->num_rows();
                            foreach($kav as $k){
                        ?>
                            <li><?= $k->blok . $k->no_rumah ?></li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td><?= $lain->keterangan ?></td>
            </tr>
            <tr>
                <th>Jumlah (/kavling)</th>
                <td>Rp. <?= number_format($lain->harga_lainnya) ?></td>
            </tr>
            <tr>
                <th>Total</th>
                <td>Rp. <?= number_format($jml_kav * $lain->harga_lainnya) ?></td>
            </tr>
        </table>
    </div>
    <div class="col-lg-6">
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
</div>