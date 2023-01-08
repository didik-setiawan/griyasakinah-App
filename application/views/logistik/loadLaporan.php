<div class="row">
    <div class="col-12">
        <h5>Material Keluar</h5>

        <?php foreach($kavling as $k){ 
            $id_kavling = $k->id_kavling;
            $jenis_material = $this->logistik->getJenisMaterialKeluar($id_kavling, $id_pro)->result();    
        ?>
        <table class="table table-bordered">
            <tr class="bg-info text-light">
                <th>Blok</th>
                <td colspan="2"><?= $k->blok . $k->no_rumah ?></td>
            </tr>
            <tr class="bg-info text-light">
                <th>Tipe</th>
                <td colspan="2"><?= $k->tipe?></td>
            </tr>
            <tr class="bg-info text-light">
                <th>Action</th>
                <td colspan="2"> <a href="<?= site_url('logistik/printMaterialOut/') . $id_pro .'/'. $id_kavling ?>" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-print"></i>Print</a> </td>
            </tr>

            <tr class="bg-dark text-light">
                <th>Nama Material</th>
                <th>Jumlah Keluar</th>
                <th>Satuan</th>
            </tr>

            <?php foreach($jenis_material as $jm){
                $id_jenis = $jm->id;
                $material = $this->logistik->getMaterialKeluar($id_pro, $id_kavling, $id_jenis)->result();
            ?>
            <tr>
                <th><?= $jm->kategori_produk ?></th>
                <td></td>
                <td></td>
            </tr>

                <?php foreach($material as $m){ 
                    $jml_out = $this->logistik->getMaterialKeluar($id_pro, $id_kavling, $id_jenis)->row()->keluar;
                ?>
                <tr>
                    <td><?= $m->nama_material ?></td>
                    <td><?= $jml_out ?></td>
                    <td><?= $m->nama_satuan ?></td>
                </tr>
                <?php } ?>

            <?php } ?>

        </table>
        <?php } ?>

    </div>
</div>