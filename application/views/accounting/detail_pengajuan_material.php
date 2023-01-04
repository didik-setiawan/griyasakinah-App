<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>#</th>
                    <th>Nama Material</th>
                    <th>Jumlah Pengajuan</th>
                    <th>Sumber Material</th>
                    <th>Harga RAB</th>
                    <th>Harga Rill</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;
                $harga_rab = 0;
                $harga_rill = 0;

                 foreach($list as $l){ 
                     
                    // $harga_rab += $l->harga * $l->jml_pengajuan;
                    // $harga_rill += $harga_real->harga_real * $l->jml_pengajuan;

                    $proyek_name = $this->db->get_where('master_proyek',['id' => $l->proyek_id])->row()->nama_proyek;

                    if($l->type == 1){
                        $harga_real = $this->db->get_where('master_logistik_detail',['logistik_id' => $l->id_logistik])->row();  
                        
                        $source = 'RAB';
                        $harga_rab += $l->harga * $l->jml_pengajuan;
                        $harga_rill += $harga_real->harga_real * $l->jml_pengajuan;
                    } else if($l->type == 2){
                        $source = 'Logistik Gudang';
                    }

                ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><b><?= $l->nama_material ?></b> <br> <small class="text-success"><?= $l->kategori_produk ?></small></td>
                    <td><?= $l->jml_pengajuan .' '. $l->nama_satuan ?></td>
                    <td><b><?= $source ?></b> <br> <small class="text-success">Proyek <?= $proyek_name ?></small> </td>
                    <td>
                        <?php if($l->type == 1){ ?>
                            <b>Rp. <?= number_format($l->harga * $l->jml_pengajuan) ?></b> <br> <small class="text-primary">(Rp. <?= number_format($l->harga); ?> / item)</small>
                        <?php } else if($l->type == 2) { ?>
                            -
                        <?php } ?>
                    </td>
                    <td>
                        <?php if($l->type == 1){ ?>
                            <?php if($harga_real){ ?>
                                <b>Rp. <?= number_format($harga_real->harga_real * $l->jml_pengajuan); ?></b> <br> <small class="text-danger">(Rp.<?= number_format($harga_real->harga_real); ?> / item)</small>
                            <?php } else { ?>
                                -
                            <?php } ?>
                        <?php } else if($l->type == 2){ ?>
                            -
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tr>
                <th colspan="4">Total Jumlah</th>
                <th>Rp. <?= number_format($harga_rab) ?></th>
                <th>Rp. <?= number_format($harga_rill) ?></th>
            </tr>
        </table>

        <table class="table table-bordered">
            <thead>
                <tr class="bg-info text-success">
                    <th colspan="2">Bukti Nota</th>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <th>Bukti Nota</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($nota as $n){ ?>
                <tr>
                    <td><?php $date = date_create($n->tgl_upload); echo date_format($date, 'd F Y') ?></td>
                    <td class="text-center">
                        <img src="<?= base_url('assets/bukti_pembayaran/') . $n->nota ?>" alt="nota pembayaran" width="50%">
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>