<?php $group = $this->session->userdata('group_id'); 

    if($group == 1){
        $add = 'disabled';
        $approve = '';
        $reject = '';
        $add_cicil = '';
        $edit = 'disabled';
        $delete = 'disabled';
        $access = 'd-none';
    } else if($group == 3){
        $add = '';
        $approve = 'disabled';
        $reject = 'disabled';
        $add_cicil = '';
        $edit = '';
        $delete = '';
        $access = '';
    } else {
        $add = 'disabled';
        $approve = 'disabled';
        $reject = 'disabled';
        $add_cicil = 'disabled';
        $edit = 'disabled';
        $delete = 'disabled';
        $access = 'd-none';
    }

?>
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Kas Operasional</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-sm btn-success addKas mb-3" <?= $add ?>><i class="fa fa-plus"></i> Tambah</button>

                        <table class="table table-bordered" id="tableKas">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>#</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($data as $d){ 
                                    if($d->status == 1){
                                        $color = 'warning';
                                        $text = 'Menunggu Super Admin';
                                    } else if($d->status == 2){
                                        $color = 'primary';
                                        $text = 'Approved Super Admin';
                                    } else if($d->status == 0){
                                        $color = 'danger';
                                        $text = 'Di Tolak Super Admin';
                                    }
                                    
                                    

                                ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?php $date = date_create($d->tgl_input); echo date_format($date, 'd F Y'); ?></td>
                                    <td><?= $d->keterangan ?></td>
                                    <td>Rp. <?= number_format($d->jumlah); ?></td>
                                    <td><span class="badge badge-<?= $color ?>"><?= $text ?></span></td>
                                    <td>
                                        <?php if($d->status == 1){ ?>
                                            <button class="btn btn-xs btn-success approve" data-id="<?= $d->id_kas ?>" <?= $approve ?>><i class="fa fa-check"></i></button>
                                            <button class="btn btn-xs btn-danger reject" data-id="<?= $d->id_kas ?>" <?= $reject ?>><i class="fa fa-times"></i></button>
                                        <?php } else if($d->status == 2){ ?>
                                            <button class="btn btn-xs btn-primary addcicil" data-id="<?= $d->id_kas ?>" <?= $add_cicil ?>><i class="fa fa-plus"></i></button>
                                        <?php } else if($d->status == 0){ ?>
                                            <button class="btn btn-xs btn-warning edit" data-id="<?= $d->id_kas ?>" data-ket="<?= $d->keterangan ?>" data-jml="<?= $d->jumlah ?>" data-tgl="<?= $d->tgl_input ?>" <?= $edit ?>><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger delete" data-id="<?= $d->id_kas ?>" <?= $delete ?>><i class="fa fa-trash"></i></button>
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
<div class="modal fade" id="modalAddPengajuan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-light">
        <h5 class="modal-title" id="staticBackdropLabel">Pengajuan Dana</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/adddCicilKas') ?>"  method="post" id="formCicil">
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-6 <?= $access ?>">
                <input type="hidden" name="id_dana_kas" id="id_dana_kas">
                <div class="form-group">
                    <label>Tanggal Input</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>
            </div>
            <div class="col-lg-6 <?= $access ?>">
                <div class="form-group">
                    <label>Jumlah Pengajuan</label>
                    <input type="text" name="dana" id="dana" class="form-control" required>
                    <input type="hidden" name="max_dana" id="max_dana">
                </div>
            </div>
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-info text-light">
                            <th colspan="5">History Pengajuan</th>
                        </tr>
                        <tr class="bg-dark text-light">
                            <th>Tanggal Pengajuan</th>
                            <th>Jumlah</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody id="tableHistory">
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">Total Terbayarakan</td>
                            <td colspan="2" id="totalterbayarKas"></td>
                        </tr>
                        <tr>
                            <td colspan="3">Sisa Pembayaran</td>
                            <td colspan="2" id="sisaPembayaranKas"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="toSubmit" class="btn btn-primary <?= $access ?>">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" id="formKas" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_kas" id="id_kas">
        <div class="form-group">
            <label>Tanggal Input</label>
            <input type="date" name="tgl" id="tgl" required class="form-control">
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="ket" id="ket" cols="15" rows="5" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Jumlah Pengajuan</label>
            <input type="text" name="jml" id="jml" required class="form-control">
        </div>

        <div class="form-group">
            <label>Kode</label>
            <select name="kode" id="kode" class="form-control" required>
              <option value="">--Pilih--</option>
              <?php foreach($kode as $k){ ?>
                <option value="<?= $k->id_kode ?>"><?= $k->kode . '.' .$k->deskripsi_kode ?></option>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="addBukti" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xs">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title" id="staticBackdropLabel">Tambahkan Bukti</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/addBuktiKas'); ?>" id="formBukti" method="post">
      <div class="modal-body">
        <div class="form-group">
            <label>Bukti</label>
            <input type="file" name="bukti" id="bukti" class="form-control" required>
            <input type="hidden" name="id_cicil" id="id_cicil">
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


<!-- Modal -->
<div class="modal fade" id="modalEditCicil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Edit Pengajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/editCicilKas') ?>" id="formEditPengajuanDana" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_cicil_edit" id="id_cicil_edit">
        <div class="form-group">
            <label>Tanggal Input</label>
            <input type="date" name="date_edit" id="date_edit" class="form-control">
        </div>
        <div class="form-group">
            <label>Jumlah Pengajuan</label>
            <input type="text" name="jml_edit" id="jml_edit" class="form-control">
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