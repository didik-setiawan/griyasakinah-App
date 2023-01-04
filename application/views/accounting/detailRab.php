   <?php if($type == 'material'){ ?>
   <div class="row">
        <div class="col-lg">
            <table class="table table-bordered">
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
                    <th>Tipe</th>
                    <td><?= $material->tipe ?></td>
                </tr>
                <tr>
                    <th>Cluster</th>
                    <td><?= $material->nama_cluster ?></td>
                </tr>
                <tr>
                    <th>Kavling</th>
                    <td>
                        <ul>
                            <?php 
                                $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $material->id_proyek AND tbl_kavling.id_tipe = $material->id_tipe";
                                $data = $this->db->query($q)->result();
                                foreach($data as $d){
                            ?>
                                <li><?= $d->blok . $d->no_rumah ?></li>
                            <?php } ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<?php } else if($type == 'upah'){ ?>
    <div class="row">
        <div class="col-lg">
            <table class="table table-bordered">
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
                                $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $upah->id_proyek AND tbl_kavling.id_tipe = $upah->id_tipe";
                                $data = $this->db->query($q)->result();
                                foreach($data as $d){
                            ?>
                                <li><?= $d->blok . $d->no_rumah ?></li>
                            <?php } ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<?php } else if($type == 'lain'){ ?>
    <div class="row">
        <div class="col-lg">
            <table class="table table-bordered">
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
                                $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $lain->id_proyek AND tbl_kavling.id_tipe = $lain->id_tipe";
                                $data = $this->db->query($q)->result();
                                foreach($data as $d){
                            ?>
                                <li><?= $d->blok . $d->no_rumah ?></li>
                            <?php } ?>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<?php }  ?>