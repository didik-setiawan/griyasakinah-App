<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Management Data Perumahan</h1>
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
                    <div class="card-header <?php access(); ?>">
                        <button class="btn btn-primary btn-sm add-perum" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-plus"></i> Add</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover" id="table-perum">
                            <thead>
                                <tr class="bg-gradient-dark">
                                    <th>#</th>
                                    <th>Nama Perumahan</th>
                                    <th>Kota</th>
                                    <th>Alamat</th>
                                    <th>Cluster</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($perum as $p){ ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $p->nama_perumahan ?></td>
                                        <td><?= $p->kabupaten ?></td>
                                        <td><?= $p->alamat_perumahan ?></td>
                                        <td><?php 
                                                if($p->cluster == 0){
                                                    echo "Tidak Ada";
                                                } else if($p->cluster == 1){
                                                    echo "Ada";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="<?php access(); ?>">
                                            <a href="<?= site_url('master/del_perum/') . $p->id_perumahan; ?>" class="btn btn-danger btn-sm del-perum"><i class="fa fa-trash"></i></a>
                                            <button class="btn btn-sm btn-primary edit-perum" data-id="<?= $p->id_perumahan ?>" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-edit"></i></button>
                                            </div>
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


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary text-light">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        <input type="hidden" name="id_perum" id="id_perum">
        <div class="form-group">
            <label>Nama Perumahan</label>
            <input type="text" name="perum" id="perum" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Kota</label>
            <input type="text" name="lokasi" id="lokasi" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Alamat Perumahan</label>
            <input type="text" name="alamat" id="alamat" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Cluster Perumahan</label>
            <select class="form-control" name="cluster" id="cluster" required>
                <option value="">--Pilih--</option>
                <option value="1">Ada</option>
                <option value="0">Tidak Ada</option>
            </select>
        </div>

        <div class="form-group">
            <label>Logo Perumahan</label>
            <input type="file" name="logo" id="logo" class="form-control">
        </div>


        <div class="logo">
            <img src="" alt="logo-perum" class="img-thumbnail img-logo">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="err_msg" data-msg="<?= $this->session->flashdata('err'); ?>"></div>
<div class="scs_msg" data-msg="<?= $this->session->flashdata('scs'); ?>"></div>