<?php $role = $this->session->userdata('group_id'); ?>
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Management Kode</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <div class="card">
                    <div class="card-body">
                        <?php if($role == 3){ ?>
                        <button class="btn btn-sm btn-success mb-3 add-kode" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah Kode</button>
                        <?php } ?>
                        <table class="table table-bordered" id="tableKode">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>Kode</th>
                                    <th>Deskripsi</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($kode as $k){ ?>
                                    <tr>
                                        <td><?= $k->kode; ?></td>
                                        <td><?= $k->deskripsi_kode ?></td>
                                        <td>
                                            <?php if($role == 3){ ?>
                                            <button class="btn btn-xs btn-primary edit-kode" data-id="<?= $k->id_kode ?>"><i class="fa fa-edit"></i></button>
                                            <a href="<?= site_url('accounting/del_kode/') . $k->id_kode; ?>" class="btn btn-xs btn-danger del-kode"><i class=" fa fa-trash"></i></a>
                                            <?php } ?>
                                            <a href="<?= site_url('accounting/sub_kode/') . $k->id_kode; ?>" class="btn btn-xs btn-dark"><i class="fas fa-search"></i> Sub kode</a>
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="form-kode">
      <div class="modal-body">
        <input type="hidden" name="id" id="id_kode">
        <div class="form-group">
            <label>Kode</label>
            <input type="text" name="kode" id="kode" class="form-control">
            <small class="text-danger" id="err_kode"></small>
        </div>
        <div class="form-group">
            <label>Deskripsi Kode</label>
            <input type="text" name="desc" id="desc" class="form-control">
            <small class="text-danger" id="err_desc"></small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm btn-save">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>