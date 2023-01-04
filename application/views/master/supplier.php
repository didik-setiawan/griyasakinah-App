<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Master Supplier</h1>
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
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-plus"></i> Tambah Supplier</button>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped" id="sup-table">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>#</th>
                                    <th style="text-align: center;">Nama</th>
                                    <th style="text-align: center;">Alamat</th>
                                    <th style="text-align: center;">Nama Toko</th>
                                    <th style="text-align: center;">Kontak</th>
                                    <th style="text-align: center;">Data Rekening</th>
                                    <th style="text-align: center;">
                                        <i class="fa fa-cogs"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i =1; foreach($supplier as $key => $row){ ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                            <td><?=$row->nama?></td>
                                            <td><?=$row->alamat?></td>
                                            <td><?=$row->nama_toko?></td>
                                            <td><?=$row->no_tlp?></td>
                                            <td>
                                               <?= $row->atas_nama ?> <br>
                                               <strong><?= $row->no_rek ?></strong> <br>
                                               <small class="text-primary"><?= 'Bank '.$row->nama_bank ?></small>
                                            </td>
                                            <td class="text-center">
                                            <button type="button" class="btn btn-info btn-xs edit-sub-act <?php access(); ?>" data-toggle="modal" data-target="#modal1" data-id="<?= $row->id_supplier ?>"><i class="fa fa-edit"></i></button>
                                            <button type="button" data-toggle="tooltip" data-placement="left" title="Hapus" class="btn btn-danger btn-xs del-sup <?php access(); ?>" data-id="<?= $row->id_supplier ?>"><i class="fa fa-trash"></i></button>
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
        <h5 class="modal-title text-light" id="staticBackdropLabel">Tambah Data Jenis unit</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-sm-12">
                <label>Nama</label>
                <input class="form-control" id="nama" autocomplete="off" name="nama" placeholder="Nama" required>
                </div>
                <div class="form-group col-sm-12">
                <label>Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" required></textarea>
                </div>

                <div class="form-group col-sm-12">
                <label>Nama Toko</label>
                  <input class="form-control" id="nama_toko" autocomplete="off" name="nama_toko" placeholder="Nama Toko" required>
                </div>
                <div class="form-group col-sm-12">
                    <label>No Telpon</label>
                    <input class="form-control" maxlength="12" id="no_tlp" autocomplete="off" name="no_tlp" placeholder="No Telpon" required>
                </div>
                <div class="form-group col-sm-12">
                    <label>No Rekening</label>
                    <input class="form-control"  id="no_rek" autocomplete="off" name="no_rek" placeholder="No Rekening" required>
                </div>
                <div class="form-group col-sm-12">
                    <label>Atas Nama</label>
                    <input class="form-control"  id="atas_nama" autocomplete="off" name="atas_nama" placeholder="Atas Nama" required>
                </div>
                <div class="form-group col-sm-12">
                    <label>Nama Bank</label>
                    <input class="form-control"  id="nama_bank" autocomplete="off" name="nama_bank" placeholder="Nama Bank" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="add-sup"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Edit Data Satuan Unit</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input type="hidden" name="id_e" id="id_e">
            <div class="row">
            <div class="form-group col-sm-12">
                <label>Nama</label>
                <input class="form-control" id="nama_e" autocomplete="off" name="nama_e" placeholder="Nama" required>
                </div>
                <div class="form-group col-sm-12">
                <label>Alamat</label>
                <textarea class="form-control" id="alamat_e" name="alamat_e" placeholder="Alamat" required></textarea>
                </div>

                <div class="form-group col-sm-12">
                <label>Nama Toko</label>
                <input class="form-control" id="nama_toko_e" autocomplete="off" name="nama_toko_e" placeholder="Nama Toko" required>
                </div>
                <div class="form-group col-sm-12">
                    <label>No Telpon</label>
                    <input class="form-control" maxlength="12" id="no_tlp_e" autocomplete="off" name="no_tlp_e" placeholder="No Telpon" required>
                </div>
                <div class="form-group col-sm-12">
                    <label>No Rekening</label>
                    <input class="form-control"  id="no_rek_e" autocomplete="off" name="no_rek_e" placeholder="No Rekening" required>
                </div>
                <div class="form-group col-sm-12">
                    <label>Atas Nama</label>
                    <input class="form-control"  id="atas_nama_e" autocomplete="off" name="atas_nama_e" placeholder="Atas Nama" required>
                </div>
                <div class="form-group col-sm-12">
                    <label>Nama Bank</label>
                    <input class="form-control"  id="nama_bank_e" autocomplete="off" name="nama_bank_e" placeholder="Nama Bank" required>
                </div>
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="edit-sup"><i class="fa fa-edit"></i> Edit Data</button>
      </div>
    </div>
  </div>
</div>