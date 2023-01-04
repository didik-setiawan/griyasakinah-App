<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Master Material</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <!-- Default box -->
                <div class="card">
                    <div class="card-header <?php access(); ?>">
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-plus"></i> Tambah Material</button>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped" id="material-table">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>#</th>
                                    <th>Kategori</th>
                                    <th>Nama Material</th>
                                    <th>Satuan</th>
                                    <th>
                                        <i class="fa fa-cogs"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i =1; foreach($material as $k){ ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $k->kategori_produk ?></td>
                                    <td><?= $k->nama_material ?></td>
                                    <td><?= $k->nama_satuan ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-xs edit-material-act <?php access(); ?>" data-toggle="modal" data-target="#modal1" data-id="<?= $k->id ?>"><i class="fa fa-edit"></i></button>
                                        <button type="button" data-toggle="tooltip" data-placement="left" title="Hapus" class="btn btn-danger btn-xs del-material <?php access(); ?>" data-id="<?= $k->id ?>"><i class="fa fa-trash"></i></button>
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
<!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Tambah Data Material</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-sm-12">
                <label>Jenis Material</label>
                <select class="form-control" id="kategori_id" name="kategori_id" required>
                    <option value="0">-pilih-</option>
                    <?php
                        foreach ($kategori as $key => $row) {
                            echo '<option value="'.$row->id.'">'.$row->kategori_produk.'</option>';
                        }
                        ?>
                </select>
                </div>
                <div class="form-group col-sm-12">
                <label>Nama Material</label>
                    <input type="text" name="nama_material" autocomplete="off" id="nama_material" class="form-control" placeholder="..." required>
                </div>
                <div class="form-group col-sm-12">
                <label>Satuan Unit</label>
                <select class="form-control" id="unit_id" name="unit_id" required>
                    <option value="0">-pilih-</option>
                    <?php
                        foreach ($unit as $key => $row) {
                            echo '<option value="'.$row->id.'">'.$row->nama_satuan.'</option>';
                        }
                        ?>
                </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="add-material"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Edit Data Kavling</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input type="hidden" name="id" id="id">
            <div class="row">
                <div class="form-group col-sm-12">
                <label>Jenis Material</label>
                <select class="form-control" id="kategori_id_edit" name="kategori_id_edit" required>
                    <option value="0">-pilih-</option>
                    <?php
                        foreach ($kategori as $key => $row) {
                            echo '<option value="'.$row->id.'">'.$row->kategori_produk.'</option>';
                        }
                        ?>
                </select>
                </div>
                <div class="form-group col-sm-12">
                <label>Nama Material</label>
                    <input type="text" name="nama_material_edit" autocomplete="off" id="nama_material_edit" class="form-control" placeholder="..." required>
                </div>
                <div class="form-group col-sm-12">
                <label>Satuan Unit</label>
                <select class="form-control" id="unit_id_edit" name="unit_id_edit" required>
                    <option value="0">-pilih-</option>
                    <?php
                        foreach ($unit as $key => $row) {
                            echo '<option value="'.$row->id.'">'.$row->nama_satuan.'</option>';
                        }
                        ?>
                </select>
                </div>
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="edit-material"><i class="fa fa-edit"></i> Edit Data</button>
      </div>
    </div>
  </div>
</div>