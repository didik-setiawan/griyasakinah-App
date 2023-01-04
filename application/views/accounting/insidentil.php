<?php $user = $this->session->userdata('group_id'); 
  if($user == 3){
    $access = '';
  } else {
    $access = 'd-none';
  }
?>
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Pekerjaan Insidentil</h1>
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
                    <div class="card-body">
                        <table class="table table-bordered" id="tabelIns">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>Tanggal</th>
                                    <th>Nama Proyek</th>
                                    <th>keterangan</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr> 
                            </thead>
                            <tbody>
                                <?php foreach($insidentil as $i){ ?>
                                <tr>
                                    <td>
                                        <?php
                                            $date = date_create($i->tanggal_insidentil);
                                            echo date_format($date,'d F Y');
                                        ?>
                                    </td>
                                    <td><?= $i->nama_proyek ?></td>
                                    <td><?= $i->keterangan ?></td>
                                    <td>Rp. <?= number_format($i->nilai) ?></td>
                                    <td>
                                                    <?php if($i->status == 0){ ?>
                                                        <span class="badge badge-pill badge-danger">Di Tolak Super Admin</span>
                                                    <?php } else if($i->status == 1){ ?>
                                                        <span class="badge badge-pill badge-warning">Menunggu Super Admin</span>
                                                    <?php } else if($i->status == 2){ ?>
                                                        <span class="badge badge-pill badge-success">Approved Super Admin</span>
                                                    <?php } else if($i->status == 3){ ?>
                                                        <span class="badge badge-pill badge-primary">Approved Accounting</span>
                                                    <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($user == 3){ ?>
                                            <?php if($i->status == 2){ ?>
                                                <button class="btn btn-xs btn-success check" data-id="<?= $i->id ?>"><i class="fas fa-check"></i></button>
                                            <?php } else if($i->status == 3){ ?>
                                                <!-- <button class="btn btn-xs btn-warning repeat" data-id="<?= $i->id ?>"><i class="fas fa-redo"></i></button> -->
                                                <button class="btn btn-xs btn-primary addPengajuan" data-id="<?= $i->id ?>"><i class="fa fa-plus"></i></button>
                                            <?php } ?>
                                        <?php } else if($user == 1){ ?>
                                            <?php if($i->status == 3){ ?>
                                                <button class="btn btn-xs btn-primary addPengajuan" data-id="<?= $i->id ?>"><i class="fa fa-plus"></i></button>
                                            <?php } ?>
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


<!-- Modal Kode-->
<div class="modal fade" id="modalKode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambahkan Kode</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/kodeInsidentil'); ?>" method="post" id="formKode">
      <div class="modal-body">
        <input type="hidden" name="id" id="id">

        <div class="form-group">
            <label>Kode</label>
            <select name="kode" id="kode" class="form-control" required>
                <option value="">--Pilih--</option>
                <?php foreach($kode as $k){ ?>
                    <option value="<?= $k->id_kode ?>">(<?= $k->kode .'). '. $k->deskripsi_kode?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Sub Kode</label>
            <select name="sub_kode" id="sub_kode" required class="form-control">
                <option value="">--Pilih--</option>
            </select>
        </div>
        <div class="form-group">
            <label>Title Kode</label>
            <select name="title_kode" id="title_kode" required class="form-control">
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



<!-- Modal Kode-->
<div class="modal fade" id="modalCicil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Pengajuan Pembayaran</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/addCicilInsidentil'); ?>" method="post" id="formInsidentil">
      <div class="modal-body">
        <input type="hidden" name="id" id="id_pengajuan">

        <div class="row">
            <div class="col-lg-6 <?= $access ?>">
                <div class="form-group">
                    <label>Tanggal Pengajuan</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>
            </div>
            <div class="col-lg-6 <?= $access ?>">
                <div class="form-group">
                    <label>Jumlah Pengajuan</label>
                    <input type="text" name="pengajuan" required id="pengajuan" class="form-control">
                    <input type="hidden" name="max_pengajuan" id="max_pengajuan">
                </div>
            </div>
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-info text-light">
                            <th colspan="5">History Pengajuan</th>
                        </tr>
                        <tr class="bg-dark text-light">
                            <th>Tanggal Pengjuan</th>
                            <th>Jumlah Pengjuan</th>
                            <th>Bukti Transaksi</th>
                            <th>Status Pengajuan</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody id="showHistoryInsidentil">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">Total Terbayarkan</td>
                            <td colspan="2" id="totalTerbayar"></td>
                        </tr>
                        <tr>
                            <td colspan="3">Sisa Pembayaran</td>
                            <td colspan="2" id="sisaTerbayar"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" id="toSave" class="btn btn-primary btn-sm <?= $access ?>">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- Modal Kode-->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Edit Pengajuan</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/editCicilInsidentil'); ?>" method="post" id="formEdit">
      <div class="modal-body">
        <input type="hidden" name="id_edit" id="id_edit">

       <div class="form-group">
        <label>Tanggal Input</label>
        <input type="date" name="tgl_edit" id="tgl_edit" required class="form-control">
       </div>

       <div class="form-group">
        <label>Jumlah Pengajuan</label>
        <input type="text" name="jml_edit" id="jml_edit" required class="form-control">
        <input type="hidden" name="max_edit" id="max_edit">
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



<!-- Modal Kode-->
<div class="modal fade" id="modalBukti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambahkan Bukti</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/addBuktiCicilInsidentil'); ?>" method="post" id="formBukti">
      <div class="modal-body">
        <input type="hidden" name="id_cicil" id="id_cicil">

       <div class="form-group">
        <label>Bukti</label>
        <input type="file" name="bukti" id="bukti" required class="form-control">
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

<div class="errmsg" data-msg="<?= $this->session->flashdata('error') ?>"></div>
<div class="scsmsg" data-msg="<?= $this->session->flashdata('success') ?>"></div>