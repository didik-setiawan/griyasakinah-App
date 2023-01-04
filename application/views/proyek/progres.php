<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Progres Pembangunan</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">


            <div class="card">
                <div class="card-body">

                <div class="form-group" style="width:45%">
                    <label>Filter Proyek</label>
                    <select name="proyek" id="filter-Proyek" class="form-control">
                        <option value="">--Semua Proyek--</option>
                        <?php foreach($proyek as $p){ 
                            $filter = $_GET['filter'];    
                        ?>
                            <?php if($filter == $p->id_proyek){ ?>
                                <option value="<?= $p->id_proyek ?>" selected><?= $p->nama_proyek ?></option>
                            <?php } else { ?>
                                <option value="<?= $p->id_proyek ?>"><?= $p->nama_proyek ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <hr>

                    <table class="table table-bordered"  id="tableProgres">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th>Nama Proyek</th>
                                <th>Tipe</th>
                                <th>Blok</th>
                                <th>Harga Kontrak</th>
                                <th>Total Harga</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($progres as $pr){ ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $pr->nama_proyek ?></td>
                                <td><?= $pr->tipe ?></td>
                                <td class="text-center">

                                    <?php
                                       
                                        $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $pr->id_proyek AND tbl_kavling.id_tipe = $pr->id_tipe";
                                        $total_blok = $this->db->query($q)->num_rows();
                                        $kavling = $this->db->query($q)->result();
                                        foreach($kavling as $k){
                                    ?>
                                 
                                    <button class="btn btn-sm btn-success m-1 detail-progres" data-blok="<?= $k->id_kavling ?>" data-upah="<?= $pr->id_upah; ?>" ><?= $k->blok . $k->no_rumah ?></button><br>
                                    <?php } ?>

                                </td>
                                <td>Rp. <?= number_format($pr->harga_kontrak) ?></td>
                                <td>
                                        <?php 
                                            $total_kontrak = $pr->harga_kontrak * $total_blok;
                                            echo "Rp. ". number_format($total_kontrak);
                                        ?>
                                </td>
                               <td>
                                <?= $pr->ket ?>
                               </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>

</div>
</div>
</div>
</section>