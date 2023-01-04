<?php $group = $this->session->userdata('group_id'); 
  if($group == 3){
    $access = '';
  } else {
    $access = 'd-none';
  }
?>
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Fee Marketing</h1>
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
                    <div class="card-body">
                   
                        <table class="table table-bordered" id="table-fee-marketing">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>Nama</th>
                                    <th>No Telp</th>
                                    <th>Status Fee Marketing</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($konsumen_b as $k){ ?>
                                <tr>
                           
                                    <td><?= $k->nama_konsumen ?></td>
                                    <td><?= $k->no_hp ?></td>
                                    <td>
                                        
                                        <?php if($k->status_fee_marketing == 0){ ?>
                                            <i class="fas fa-times text-danger"></i> Belum
                                        <?php } else if($k->status_fee_marketing == 1){ ?>
                                            <i class="fas fa-exclamation text-warning"></i> Menunggu Konfirmasi Accounting
                                        <?php } else if($k->status_fee_marketing == 2){ ?>
                                            <i class="fas fa-check text-success"></i> Approved
                                        <?php } else if($k->status_fee_marketing == 3){ ?>
                                            <i class="fas fa-check text-success"></i> Approved
                                        <?php } else if($k->status_fee_marketing == 4){ ?>
                                            <i class="fas fa-times text-danger"></i> Di Tolak Super Admin
                                        <?php } ?>

                                    </td>
                                    <td> 
                                        <button class="btn btn-info btn-sm fee-marketing" data-id="<?= $k->id_marketing ?>" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-eye"></i> View</button>
                                        
                                        <?php if($k->status_fee_marketing == 2){ ?>
                                            <button class="btn btn-sm btn-success cicilFee" data-id="<?= $k->id_marketing ?>"><i class="fa fa-plus"></i></button>
                                        <?php } ?>

                                    </td>
                                </tr>
                                <?php } ?>
                                <?php $i = 1; foreach($konsumen_i as $ki){ ?>
                                <tr>
                           
                                    <td><?= $ki->nama_konsumen ?></td>
                                    <td><?= $ki->no_hp ?></td>
                                    <td>
                                        
                                        <?php if($ki->status_fee_marketing == 0){ ?>
                                            <i class="fas fa-times text-danger"></i> Belum
                                        <?php } else if($ki->status_fee_marketing == 1){ ?>
                                            <i class="fas fa-exclamation text-warning"></i> Menunggu Konfirmasi Accounting
                                        <?php } else if($ki->status_fee_marketing == 2){ ?>
                                            <i class="fas fa-check text-success"></i> Approved
                                        <?php } else if($ki->status_fee_marketing == 3){ ?>
                                            <i class="fas fa-check text-success"></i> Sudah
                                        <?php } else if($ki->status_fee_marketing == 4){ ?>
                                            <i class="fas fa-times text-danger"></i> Di Tolak Super Admin
                                        <?php } ?>

                                    </td>
                                    <td> 
                                        <button class="btn btn-info btn-sm fee-marketing" data-id="<?= $ki->id_marketing ?>" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-eye"></i> View</button>
                                       
                                        <?php if($ki->status_fee_marketing == 2){ ?>
                                            <button class="btn btn-sm btn-success cicilFee" data-id="<?= $ki->id_marketing ?>"><i class="fa fa-plus"></i></button>
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
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="staticBackdropLabel">Fee Marketing</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="content-fee-marketing">
        
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="kodeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title" id="exampleModalLabel">Masukkan Kode</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="formCodeFee">
      <div class="modal-body">
        <div class="form-group">
            <label>Kode</label>
            <select name="kode" id="kode" class="form-control" required>
                <option value="">--Pilih--</option>
                <?php foreach($kode as $k){ ?>
                    <option value="<?= $k->id_kode ?>">(<?= $k->kode .'). '.$k->deskripsi_kode ?></option>
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
        <button type="submit" class="btn btn-success btn-sm">Save</button>
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
      <form action="<?= site_url('accounting/addCicilFee'); ?>" id="formCicilFee" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_marketing" id="id_marketing">
        <div class="row">
            <div class="col-lg-6 <?= $access ?>">
                <div class="form-group">
                    <label>Tanggal Input</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>
            </div>
            <div class="col-lg-6 <?= $access ?>">
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
                    <tbody id="showHistoryFeeMarketing">

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
        <button type="submit" id="toSave" class="btn btn-primary <?= $access ?>">Save</button>
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
      <form action="<?= site_url('accounting/editCicilFee'); ?>" id="formEditCicilFee" method="post">
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
      <form action="<?= site_url('accounting/addBuktiCicilFee'); ?>" id="formBukti" method="post">
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