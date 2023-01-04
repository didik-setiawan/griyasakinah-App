<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Management Rekening Bank</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card table-responsive">
                    <div class="card-body">

                        <button class="btn btn-sm btn-success add-rekening mb-4 <?php access(); ?>" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-plus"></i> Tambah Rekening Bank</button>

                        <table class="table table-bordered" id="table-Rekening">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>#</th>
                                    <th>Nama Pemilik</th>
                                    <th>Bank</th>
                                    <th>No. Rekening</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($rek as $r){ ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $r->nama_pemilik ?></td>
                                    <td><?= $r->nama_bank ?></td>
                                    <td><?= $r->no_rekening ?></td>
                                    <td>
                                        <div class="<?php access(); ?>">
                                        <button class="btn btn-sm btn-warning btn-xs edit-rekening" data-id="<?= $r->id_rekening ?>" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-edit"></i></button>
                                        <a href="<?= site_url('kpr/del_rekening/') . $r->id_rekening; ?>" class="btn btn-xs btn-danger del-rekening"><i class="fa fa-trash"></i></a>
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
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="aksi">
      <div class="modal-body">
        <input type="hidden" name="id_rek" id="id_rekening">

        <div class="form-group">
            <label>Nama Bank</label>
            <input type="text" name="bank" id="bank" required class="form-control">
        </div>
        <div class="form-group">
            <label>Nama Pemilik</label>
            <input type="text" name="pemilik" id="pemilik" required class="form-control">
        </div>
        <div class="form-group">
            <label>No Rekening</label>
            <input type="text" name="no_rek" id="no_rek" required class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="msg-true" data-pesan="<?= $this->session->flashdata('true'); ?>"></div>
<div class="msg-false" data-pesan="<?= $this->session->flashdata('false'); ?>"></div>