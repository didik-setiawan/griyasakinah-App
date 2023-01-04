<?php $role = $this->session->userdata('group_id'); ?>
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Sub Kode <?= $kode->deskripsi_kode ?></h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-dark">
                        <a href="<?= site_url('accounting/kode') ?>" class="btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                    <div class="card-body">
                    <?php if($role == 3){ ?>
                        <button class="btn btn-sm btn-primary add-sub mb-3"><i class="fa fa-plus"></i> Tambah Sub Kode</button>
                    <?php } ?>

                        <table class="table table-bordered" id="tableSub">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>Sub Kode</th>
                                    <th>Deskripsi</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($sub_kode as $sb){ ?>
                                <tr>
                                    <td><?= $sb->sub_kode ?></td>
                                    <td><?= $sb->deskripsi_sub_kode ?></td>
                                    <td>
                                    <?php if($role == 3){ ?>
                                        <button class="btn btn-xs btn-success edit-sub" data-id="<?= $sb->id_sub ?>"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-xs btn-danger del-sub" data-id="<?= $sb->id_sub ?>"><i class="fa fa-trash"></i></button>
                                    <?php } ?>
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
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <form action="" method="post" id="formSub">
      <div class="modal-body">
      <input type="hidden" name="id_kode" id="id_kode" value="<?= $this->uri->segment(3) ?>">
      <input type="hidden" name="id_sub" id="id_sub">
        <div class="form-group">
            <label>Sub Kode</label>
            <input type="text" class="form-control" name="sub" id="sub">
            <small class="text-danger" id="sub_err"></small>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" class="form-control" name="desc" id="desc">
            <small class="text-danger" id="desc_err"></small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>