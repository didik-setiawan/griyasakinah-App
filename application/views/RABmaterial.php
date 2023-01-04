<div class="row">
    <div class="col-lg-4">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th colspan="2">Detail Material</th>
            </tr>
            <tr>
                <th>Nama Material</th>
                <td><?= $material->nama_material ?></td>
            </tr>
            <tr>
                <th>kategori Produk</th>
                <td><?= $material->kategori_produk ?></td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td><?= $material->quantity .' '. $material->nama_satuan ?></td>
            </tr>
            <tr>
                <th>Harga Satuan</th>
                <td>Rp. <?= number_format($material->harga) ?></td>
            </tr>
            <tr>
                <th>Total</th>
                <td>Rp. <?= number_format($material->total) ?></td>
            </tr>
        </table>
    </div>
    <div class="col-lg-4">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th colspan="2">Detail Proyek</th>
            </tr>
            <tr>
                <th>Nama Proyek</th>
                <td><?= $material->nama_proyek ?></td>
            </tr>
            <tr>
                <th>Nama Perumahan</th>
                <td><?= $material->nama_perumahan ?></td>
            </tr>
            <tr>
                <th>Kota</th>
                <td><?= $material->kabupaten ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?= $material->alamat_perumahan ?></td>
            </tr>
            <tr>
                <th>Cluster</th>
                <td><?= $material->nama_cluster ?></td>
            </tr>
            <tr>
                <th>Tipe</th>
                <td><?= $material->tipe ?></td>
            </tr>
            <tr>
                <th>Kavling</th>
                <td>
                    <ul>
                    <?php
                        $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $material->proyek_id AND tbl_kavling.id_tipe = $material->tipe_id";
                        $kav = $this->db->query($q)->result();
                        foreach($kav as $k){
                    ?>
                        <li><?= $k->blok . $k->no_rumah; ?></li>
                    <?php } ?>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-lg-4">
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