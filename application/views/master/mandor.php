<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-3">
                <div class="card-body">
                    <h5>Master Mandor</h5>
                    <button class="btn btn-sm btn-primary mb-3 add-mandor"><i class="fa fa-plus"></i> Tambah</button>
                    <table class="table table-bordered" id="tableMandor">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th>Nama Mandor</th>
                                <th>No Telp</th>
                                <th>Data Rekening</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($mandor as $m){ ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $m->nama_mandor ?></td>
                                <td><?= $m->no_telp ?></td>
                                <td>
                                    <b><?= $m->nama_bank ?></b> <br>
                                    <span><?= $m->no_rekening ?></span> <br>
                                    <small class="text-primary"><?= $m->atas_nama ?></small>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success edit"
                                        data-id="<?= $m->id_mandor ?>"
                                        data-mandor="<?= $m->nama_mandor ?>"
                                        data-telp="<?= $m->no_telp ?>"
                                        data-rekening="<?= $m->no_rekening ?>"
                                        data-bank="<?= $m->nama_bank ?>"
                                        data-nama="<?= $m->atas_nama ?>"
                                        ><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger delete" data-id="<?= $m->id_mandor ?>"><i class="fa fa-trash"></i></button>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('master/add_mandor'); ?>" id="formAddMandor" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_mandor" id="id_mandor">
        <div class="form-group">
            <label>Nama Mandor</label>
            <input type="text" name="mandor" id="mandor" class="form-control">
            <small class="text-danger" id="err_mandor"></small>
        </div>
        <div class="form-group">
            <label>No Telp</label>
            <input type="text" name="telp" id="telp" class="form-control">
            <small class="text-danger" id="err_telp"></small>
        </div>
        <div class="form-group">
            <label>No Rekening</label>
            <input type="text" name="rekening" id="rekening" class="form-control">
            <small class="text-danger" id="err_rek"></small>
        </div>
        <div class="form-group">
            <label>Nama Bank</label>
            <input type="text" name="bank" id="bank" class="form-control">
            <small class="text-danger" id="err_bank"></small>
        </div>
        <div class="form-group">
            <label>Atas Nama</label>
            <input type="text" name="atas_nama" id="atas_nama" class="form-control">
            <small class="text-danger" id="err_name"></small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>