
    <form action="<?= site_url('proyek/addSupplierData') ?>" id="formSuppl" method="post">
<div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Data Supplier</label>
                    <select name="supplier" id="supplier" class="form-control" required>
                        <option value="">--pilih--</option>
                        <?php foreach($supplier as $sup){ ?>
                            <option value="<?= $sup->id_supplier ?>"><?= $sup->nama_toko ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-9">
                <table class="table table-bordered">
                    <tr class="bg-secondary text-light">
                        <th>Nama Toko</th>
                        <th>Alamat</th>
                        <th>No telp</th>
                    </tr>
                    <tr>
                        <td id="nama_toko"></td>
                        <td id="alamat"></td>
                        <td id="no_telp"></td>
                    </tr>
                </table>
            </div>
            <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $id_pengajuan ?>">
            <div class="col-lg-12 mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-info text-light">
                            <th>#</th>
                            <th>Nama Material</th>
                            <th>Jumlah</th>
                            <th>Sumber Material</th>
                            <th>Harga RAB</th>
                            <th>Harga Rill</th>
                        </tr>
                    </thead>
                   <tbody>
                    <?php $i=1; foreach($data as $d){ 
                        $proyek_name = $this->db->get_where('master_proyek',['id' => $d->proyek_id])->row()->nama_proyek;  

                        if($d->type == 1){
                            $source = 'RAB';
                        } else if($d->type == 2) {
                            $source = 'Logistik Gudang';
                        }
                    ?>
                        <tr>
                            <td><?= $i++; ?>
                            <input type="hidden" name="id_material_pengajuan[]" id="id_material_pengajuan" value="<?= $d->id_logistik ?>">
                            </td>
                            <td><b><?= $d->nama_material ?></b> <br>
                                <small class="text-primary"><?= $d->kategori_produk ?></small>
                            </td>
                            <td>
                                <?= $d->jml_pengajuan .' '. $d->nama_satuan ?>
                            </td>
                            <td>
                                <b><?= $source ?></b> <br> <small class="text-danger">Proyek <?= $proyek_name ?></small>
                            </td>
                            <td>
                                <?php if($d->type == 1){ ?>
                                    <b>Rp. <?= number_format($d->jml_pengajuan * $d->harga); ?></b> <br>
                                    <small class="text-success">(Rp. <?= number_format($d->harga); ?> / item)</small>
                                <?php } else if($d->type == 2){ ?>
                                    -
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($d->type == 1){ ?>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                       
                                        <input type="text" name="harga_rill[]" id="harga_rill" class="form-control harga-rill real" required>

                                        <div class="input-group-append">
                                            <span class="input-group-text">/ item</span>
                                        </div>
                                    </div>
                                <?php } else if($d->type == 2){ ?>
                                    <input type="hidden" name="harga_rill[]"  id="harga_real" value="0" class="form-control" required>
                                    -
                                <?php } ?>
                                <!-- <input type="text" name="harga_rill[]" required id="harga_rill" class="form-control harga-rill"> -->
                            </td>
                        </tr>
                    <?php } ?>
                   </tbody>
                </table>
            </div>
            <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </form>


        <script>
            $('#supplier').change(function(){
                let id = $(this).val();
                $.ajax({
                    url: '<?= site_url('proyek/getSupllierID'); ?>',
                    data: {id:id},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(d){
                        $('#nama_toko').html(d.nama_toko);
                        $('#alamat').html(d.alamat);
                        $('#no_telp').html(d.no_tlp);
                    }
                });
            });

            $('.real').mask("#.##0", {reverse: true});

            $('#formSuppl').submit(function(){
                // e.preventDefault();
                $('.real').unmask();
                // let real = $('.real').val();
                // console.log(real);
            });

        </script>