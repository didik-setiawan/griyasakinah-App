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
        <h1>Pembatalan Transaksi</h1>
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
                        <table class="table table-bordered" id="theTable">
                            <thead class="bg-dark text-light">
                                <tr>
                                   
                                    <th>Nama</th>
                                    <th>Status Pengembalian Uang</th>
                                    <th>Total Pengembalian</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($bank as $d){ ?>
                                <tr>
                                    <td><?= $d->nama_konsumen ?></td>
                                    <td>
                                        <?php if($d->status == 1){
                                            echo "menunggu persetujuan accounting";
                                        } else if($d->status == 2){
                                            echo "Approved";
                                        } else if($d->status == 0){
                                            echo "Di Tolak";
                                        } ?>
                                    </td>
                                    <td>
                                        Rp. <?= number_format($d->total_pengembalian) ?>
                                    </td>
                                    <td>
                                        <?php if($user == 3){ ?>
                                            <?php if($d->status == 1){ ?>
                                                <button class="btn btn-xs btn-success check" data-id="<?= $d->id_pembatalan ?>"><i class="fa fa-check"></i></button>
                                               
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if($d->status == 2){ ?>
                                            <button class="btn btn-xs btn-primary addCicil" data-id="<?= $d->id_pembatalan ?>"><i class="fa fa-plus"></i></button>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>

                                <?php foreach($inhouse as $i){ ?>
                                <tr>
                                   
                                    <td><?= $i->nama_konsumen ?></td>
                                    <td>
                                        <?php if($i->status == 1){
                                            echo "menunggu persetujuan accounting";
                                        } else if($i->status == 2){
                                            echo "Approved";
                                        } else if($i->status == 0){
                                            echo "Di Tolak";
                                        } ?>
                                    </td>
                                    <td>
                                        Rp. <?= number_format($i->total_pengembalian) ?>
                                    </td>
                                    <td>
                                        <?php if($user == 3){ ?>
                                            <?php if($i->status == 1){ ?>
                                                <button class="btn btn-xs btn-success check" data-id="<?= $i->id_pembatalan ?>"><i class="fa fa-check"></i></button>
                                                
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if($i->status == 2){ ?>
                                            <button class="btn btn-xs btn-primary addCicil" data-id="<?= $i->id_pembatalan ?>"><i class="fa fa-plus"></i></button>
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


<div class="modal fade" id="modalKode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambahkan Kode</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/toCodePembatalan'); ?>" id="postKode" method="post">
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


<div class="modal fade" id="modalCicil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambahkan Pengajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/addCicilPembatalan'); ?>" id="formPengajuan" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_pembatalan" id="id_pembatalan">
        <div class="row">
            <div class="col-lg-6 <?= $access ?>">
                <div class="form-group">
                    <label>Tanggal Input</label>
                    <input type="date" name="tgl" id="tgl" class="form-control" required>
                </div>
            </div>
            <div class="col-lg-6 <?= $access ?>">
                <div class="form-group">
                    <label>Jumlah Pengajuan</label>
                    <input type="text" name="jml" id="jml" class="form-control" required>
                    <input type="hidden" name="jml_max" id="jml_max">
                </div>
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
                    <th>Bukti</th>
                    <th>Status</th>
                    <th><i class="fa fa-plus"></i></th>
                </tr>
                </thead>
                <tbody id="toShowHistoryPembatalan">
                    
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="3">Total Terbayar</th>
                    <th colspan="2" id="showTerbayar"></th>
                  </tr>
                  <tr>
                    <th colspan="3">Sisa Pembayaran</th>
                    <th colspan="2" id="showSisaPembayaran"></th>
                  </tr>
                </tfoot>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" <?= $access ?> id="toSave" class="btn btn-primary">Save</button>
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
      <form action="<?= site_url('accounting/editCicilPembatalan'); ?>" id="formEditCicilFee" method="post">
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
      <form action="<?= site_url('accounting/addBuktiCicilPembatalan'); ?>" id="formBukti" method="post">
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