<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Management Calon Konsumen</h1>
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
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop">
                            <i class="fa fa-plus"></i> Tambah Calon Konsumen
                        </button>
                    </div>
               
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped mt-2" id="calon_konsumen">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>No Hp</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pekerjaan</th>
                                    <th>Dapat Info</th>
                                    <th>Status</th>
                                    <th class="<?php access(); ?>">
                                        <i class="fa fa-cogs"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($calon_konsumen as $c){ ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $c->nama_konsumen ?></td>
                                    <td><?= $c->no_hp ?></td>
                                    <td><?= $c->jk ?></td>
                                    <td><?= $c->pekerjaan ?></td>
                                    <td><?= $c->dapat_info ?></td>
                                    <td>Calon Konsumen</td>
                                    <td class="<?php access(); ?>">
                                        <button type="button" class="btn btn-xs btn-danger del-calon-konsumen" data-id="<?= $c->id_marketing ?>"><i class="fa fa-trash"></i></button>
                                       
                                        <button type="button" class="btn btn-xs btn-secondary edit-calon-konsumen" data-id="<?= $c->id_marketing ?>" data-toggle="modal" data-target="#modal1">
                                        <i class="fa fa-edit"></i></button>
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
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="staticBackdropLabel">Tambah Calon Konsumen</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Nama" id="nama" class="form-control">
        </div>
        <div class="form-group">
            <label>No Hp</label>
            <input type="text" name="no_hp" placeholder="No hp" id="no_hp" class="form-control">
        </div>
        <div class="form-group">
            <label>Pekerjaan</label>
            <select name="pekerjaan" id="pekerjaan" class="form-control">
                <option value="">--Pilih--</option>
                <option value="PNS">PNS</option>
                <option value="TNI">TNI</option>
                <option value="Polri">Polri</option>
                <option value="Karyawan Swasta">Karyawan Swasta</option>
                <option value="Tenaga Kontrak">Tenaga Kontrak</option>
                <option value="Wiraswasta">Wiraswasta</option>
                <option value="BUMN">BUMN</option>
                <option value="Honorer / Sukwan">Honorer / Sukwan</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" id="jk" class="form-control">
                <option value="">--Pilih--</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Dapat Info Dari</label>
            <select name="info" id="info" class="form-control">
                <option value="">--Pilih--</option>
                <option value="Banner">Banner</option>
                <option value="Brosur">Brosur</option>
                <option value="Teman">Teman</option>
                <option value="Media Sosial">Media Sosial</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="add_calon_konsumen" name="add_calon_konsumen"><i class="fa fa-save"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Calon Konsumen</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="id" id="id_calon">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Nama" id="nama_edit" class="form-control">
        </div>
        <div class="form-group">
            <label>No Hp</label>
            <input type="text" name="no_hp" placeholder="No hp" id="no_hp_edit" class="form-control">
        </div>
        <div class="form-group">
            <label>Pekerjaan</label>
            <select name="pekerjaan" id="pekerjaan_edit" class="form-control">
                <option value="">--Pilih--</option>
                <option value="PNS">PNS</option>
                <option value="TNI">TNI</option>
                <option value="Polri">Polri</option>
                <option value="Karyawan Swasta">Karyawan Swasta</option>
                <option value="Tenaga Kontrak">Tenaga Kontrak</option>
                <option value="Wiraswasta">Wiraswasta</option>
                <option value="BUMN">BUMN</option>
                <option value="Honorer / Sukwan">Honorer / Sukwan</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" id="jk_edit" class="form-control">
                <option value="">--Pilih--</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Dapat Info Dari</label>
            <select name="info" id="info_edit" class="form-control">
                <option value="">--Pilih--</option>
                <option value="Banner">Banner</option>
                <option value="Brosur">Brosur</option>
                <option value="Teman">Teman</option>
                <option value="Media Sosial">Media Sosial</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="edit_calon_konsumen" name="edit_calon_konsumen"><i class="fa fa-edit"></i> Edit</button>
      </div>
    </div>
  </div>
</div>