<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">
            <tr class="bg-dark text-light">
                <th colspan="2">Detail Upah</th>
            </tr>
            <tr>
                <th>Nama Proyek</th>
                <td><?= $upah->nama_proyek ?></td>
            </tr>
            <tr>
                <th>Nama Perumahan</th>
                <td><?= $upah->nama_perumahan ?></td>
            </tr>
            <tr>
                <th>Kota</th>
                <td><?= $upah->kabupaten ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?= $upah->alamat_perumahan ?></td>
            </tr>
            <tr>
                <th>Tipe</th>
                <td><?= $upah->tipe ?></td>
            </tr>
            <tr>
                <th>Cluster</th>
                <td><?= $upah->nama_cluster ?></td>
            </tr>
            <tr>
                <th>Kavling</th>
                <td>
                    <ul>
                        <?php
                            $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $upah->proyek_id AND tbl_kavling.id_tipe = $upah->tipe_id";
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
                <th>Harga Kontrak (/kavling)</th>
                <td>Rp. <?= number_format($upah->harga_kontrak) ?></td>
            </tr>
            <tr>
                <th>Total</th>
                <td>
                    Rp. <?php $qty = $jml_kav * $upah->harga_kontrak; echo number_format($qty); ?>
                </td>
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