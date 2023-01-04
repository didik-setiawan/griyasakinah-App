<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        
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
                <div class="card card-dark">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-11">
                                <h3 class="card-title">Detail Tipe</h3>
                            </div>
                            <div class="col-sm-1">
                                <a href="<?=site_url('master/tipe/')?>" class="btn btn-warning btn-sm"><i class="fa fa-undo-alt"></i> kembali</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="max-table">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th style="text-align: center;">Tipe</th>
                                <th style="text-align: center;">Material</th>
                                <th style="text-align: center;">Max Quantity</th>
                                <th style="text-align: center;">
                                    <i class="fa fa-cogs"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i =1; foreach($materialMax as $key => $row){ ?>
                                <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?=$row->tipe?> </td>
                                        <td>
                                        <span class="text-bold"><?= $row->nama_material?></span><br>
                                        <span class="small text-danger"><?= $row->kategori_produk ?></span><br>
                                        </td>
                                        <td class="text-center"><?= $row->max ?>  <?= $row->nama_satuan ?></td>
                                        <td class="text-center">
                                        <button type="button" class="btn btn-info btn-xs set_edit_max <?php access(); ?>" data-toggle="modal" data-target="#edit_max" data-id_max="<?= $row->id_max ?>"><i class="fa fa-edit"></i></button>
                                        <button type="button" data-toggle="tooltip" data-placement="left" title="Hapus" class="btn btn-danger btn-xs del-max <?php access(); ?>" data-id_max="<?= $row->id_max ?>"><i class="fa fa-trash"></i></button>
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
<div class="modal fade" id="edit_max" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Edit Data tipe</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <input type="hidden" name="id_max" id="id_max">
                <input type="hidden" name="id_tipe" id="id_tipe">

                    <div class="form-group col-sm-12">
                        <label>Jenis Material</label>
                        <select class="form-control" id="id_kategori_e" name="id_kategori_e" required>
                        <option value="">-pilih-</option>
                        <?php foreach($material as $row):?>
                        <option value="<?php echo $row->id;?>"><?php echo $row->kategori_produk;?></option>
                        <?php endforeach;?>
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Pilih Material</label>
                        <select class="form-control" id="id_material_e" name="id_material_e" required>
                        <option value="">-pilih-</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">      
                            <label>Max Quantity</label>
                            <input type="number" min="0" value="0" name="max_e" id="max_e" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <label>Satuan Unit</label>
                            <input readonly class="form-control" id="unit_id_e" name="unit_id_e" required>
                        </div>
                    </div>
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="edit-max"><i class="fa fa-edit"></i> Edit Data</button>
      </div>
    </div>
  </div>
</div>