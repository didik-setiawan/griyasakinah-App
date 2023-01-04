<?php $accounting = $this->session->userdata('group_id'); 
  if($accounting == 3){
    $acs = '';
  } else {
    $acs = 'd-none';
  }
?>
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Pembangunan</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">

                        <table class="table table-bordered" id="tablePembangunan">
                            <thead>
                                <tr class="bg-dark text-ligt">
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($pembangunan as $p){ ?>
                                <tr>
                                    <td><?= $p->tanggal ?></td>
                                    <td class="text-right">Rp. <?= number_format($p->total) ?></td>
                                    <td class="text-center">
                                        
                                        <?php if($p->status == 1){ ?>
                                            <span class="badge badge-danger">Ditolak Accounting</span>
                                        <?php } else if($p->status == 2){ ?>
                                            <span class="badge badge-warning">Menunggu Persetujuan Accounting</span>
                                        <?php } else if($p->status == 3){ ?>
                                            <span class="badge badge-success">Approved</span>
                                        
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($accounting == 3){ ?>
                                            <?php if($p->status == 2){ ?>
                                            <button class="btn btn-xs btn-success approve" data-id="<?= $p->id_progres ?>" data-up="<?= $p->upah_id ?>"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-xs btn-danger tolak" data-id="<?= $p->id_progres ?>"><i class="fas fa-times"></i></button>
                                            <?php } else if($p->status == 0){ ?>
                                              <button class="btn btn-xs btn-warning repeat" data-id="<?= $p->id_progres ?>" data-up="<?= $p->upah_id ?>"><i class="fas fa-redo-alt"></i></button>
                                            <?php } else if($p->status == 3){ ?>
                                              <button class="btn btn-xs btn-primary addCicil" data-id="<?= $p->id_progres ?>" ><i class="fa fa-plus"></i></button>
                                            <?php } ?>
                                       
                                            <button class="btn btn-xs btn-dark detail" data-id="<?= $p->id_progres ?>"><i class="fas fa-search"></i></button>
                                        <?php } else { ?>
                                            <?php if($p->status == 3){ ?>
                                              <button class="btn btn-xs btn-primary addCicil" data-id="<?= $p->id_progres ?>" ><i class="fa fa-plus"></i></button>
                                            <?php } ?>
                                            <button class="btn btn-xs btn-dark detail" data-id="<?= $p->id_progres ?>"><i class="fas fa-search"></i></button>
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
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-light" id="exampleModalLabel">Detail Pembangunan</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body detail-show">
        <div class="spinner text-center">
            <div class="spinner-border text-dark" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="formCode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light" id="exampleModalLabel">Pilih Kode</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/approve_pembangunan'); ?>" method="post" id="formCodeSubmit">
      <div class="modal-body">
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="id_up" id="id_up">
            <div class="form-group">
                <label>Kode</label>
                <select name="kode" id="kode" class="form-control" required>
                    <option value="">--Pilih--</option>
                    <?php foreach($kode as $k){ ?>
                        <option value="<?= $k->id_kode ?>">(<?= $k->kode .').'.$k->deskripsi_kode ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Sub Kode</label>
                <select name="sub_kode" id="sub_kode" class="form-control" required>
                    <option value="">--Pilih--</option>
                </select>
            </div>
            <div class="form-group">
              <label>Title Kode</label>
              <select name="title_kode" id="title_kode" class="form-control" required>
                <option value="">--Pilih--</option>
              </select>
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

<!-- Modal -->
<div class="modal fade" id="modalCicil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pengajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/addCicilProgres'); ?>" id="formCicilFee" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_progres" id="id_progres">
        <div class="row">
            <div class="col-lg-6 <?= $acs ?>">
                <div class="form-group">
                    <label>Tanggal Input</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>
            </div>
            <div class="col-lg-6 <?= $acs ?>">
                <div class="form-group">
                    <label>Jumlah Pengajuan</label>
                    <input type="text" name="jml" id="jml" class="form-control" required>
                    <input type="hidden" name="max_jml" id="max_jml">
                </div>
            </div>
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-info text-light">
                            <th colspan="5">History Pengajuan</th>
                        </tr>
                        <tr class="bg-dark text-light">
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Bukti Pembayaran</th>
                            <th>Status</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody id="showHistory">

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total Terbayar</th>
                            <td id="showTerbayar" colspan="2"></td>
                        </tr>
                        <tr>
                            <th colspan="3">Sisa Pembayaran</th>
                            <td id="showSisa" colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="toSave" class="btn btn-primary <?= $acs ?>">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xs">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title" id="exampleModalLabel">Edit Pengajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/editCicilProgres'); ?>" id="formEditCicilFee" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_edit" id="id_edit">
        <div class="form-group">
            <label>Tanggal Input</label>
            <input type="date" name="date" required id="date" required class="form-control">
        </div>
        <div class="form-group">
            <label>Jumlah Pengajuan</label>
            <input type="text" name="jml_edit" required id="jml_edit" class="form-control">
            <input type="hidden" name="max_edit" id="max_edit">
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

<div class="modal fade" id="modalBukti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambahkan Bukti</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/addBuktiCicilProgres'); ?>" id="formBukti" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_bukti" id="id_bukti">
        <div class="form-group">
            <label>Bukti</label>
            <input type="file" name="bukti" required id="bukti" class="form-control">
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