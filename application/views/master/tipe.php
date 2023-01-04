<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Management Data tipe</h1>
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
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-plus"></i> Tambah Tipe</button>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped" id="tipe-table">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>#</th>
                                    <th>Lokasi</th>
                                    <th>Cluster</th>
                                    <th>Tipe</th>
                                    <th>
                                        <i class="fa fa-cogs"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($tipe as $k){ 
                                    if($k->nama_cluster == null){
                                        $warna = 'danger';
                                        $cluster = 'Kosong';
                                    }else{
                                        $warna = 'success';
                                        $cluster = $k->nama_cluster;
                                    }
                                    ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $k->nama_perumahan ?></td>
                                    <td><span class="badge badge-<?=$warna?> text-uppercase"><?=$cluster?></span></td>
                                    <td><?= $k->tipe ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-xs edit-tipe-act <?php access(); ?>" data-toggle="modal" data-target="#modal1" data-id="<?= $k->id_tipe ?>" data-status="<?= $k->cluster ?>"><i class="fa fa-plus"></i> Tambah Max Material</button>
                                        <button type="button" class="btn btn-xs btn-secondary" id="open_detail" data-id="<?= $k->id_tipe ?>" data-toggle="modal" data-target="#detailMax"><i class="fa fa-search"></i>
                                         Detail</button>
                                        <button type="button" data-toggle="tooltip" data-placement="left" title="Hapus" class="btn btn-danger btn-xs del-tipe <?php access(); ?>" data-id="<?= $k->id_tipe ?>"><i class="fa fa-trash"></i></button>
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
        <h5 class="modal-title text-light" id="staticBackdropLabel">Tambah Data tipe</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label>Lokasi Perumahan</label>
                <select name="lokasi" id="lokasi" class="form-control">
                    <option value="">--Pilih--</option>
                    <?php foreach($perum as $p){ ?>
                        <option value="<?= $p['id_perumahan'] ?>"><?= $p['nama_perumahan'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" name="status_cluster" id="status_cluster">
            <div class="form-group">
                <label>Cluster</label>
                <select class="form-control" name="cluster" id="cluster">
                    <option value="">--Pilih--</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tipe</label>
                <input type="text" name="tipe" id="tipe" class="form-control">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-success btn-sm" id="add-tipe"><i class="fa fa-save"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Edit Data tipe</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                    <h4>Master Tipe</h4>
                    <hr>

                <input type="hidden" name="id_tipe" id="id_tipe">

                    <div class="form-group">
                        <label>Lokasi Perumahan</label>
                        <select name="lokasi_e" id="lokasi_e" class="form-control">
                            <option value="">--Pilih--</option>
                            <?php foreach($perum as $p){ ?>
                                <option value="<?= $p['id_perumahan'] ?>"><?= $p['nama_perumahan'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="status_cluster_e" id="status_cluster_e">
                    <div class="form-group">
                        <label>Cluster</label>
                        <select class="form-control" name="cluster_e" id="cluster_e">
                            <option value="">--Pilih--</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipe</label>
                        <input type="text" name="tipe_e" id="tipe_e" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                        <h4>Material Max</h4>
                        <hr>
                    <div class="form-group col-sm-12">
                        <label>Jenis Material</label>
                        <select class="form-control" id="id_kategori" name="id_kategori" required>
                        <option value="">-pilih-</option>
                        <?php foreach($material as $row):?>
                        <option value="<?php echo $row->id;?>"><?php echo $row->kategori_produk;?></option>
                        <?php endforeach;?>
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Pilih Material</label>
                        <select class="form-control" id="id_material" name="id_material" required>
                        <option value="">-pilih-</option>
                        </select>
                    </div>
                        <div class="row">
                            <div class="col-sm-6">      
                                <label>Max Quantity</label>
                                <input type="number" min="0" value="0" name="max" id="max" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label>Satuan Unit</label>
                                <input readonly class="form-control" id="unit_id" name="unit_id" required>
                            </div>
                        </div>
                </div>
            </div>       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="edit-tipe"><i class="fa fa-edit"></i> Edit Data</button>
      </div>
    </div>
  </div>
</div>