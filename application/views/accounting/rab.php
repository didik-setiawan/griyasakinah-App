<?php $user = $this->session->userdata('group_id'); ?>
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>RAB</h1>
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

                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">RAB Material</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">RAB Upah Pekerja</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">RAB Lain</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            
                            <table class="table table-bordered" id="RABMaterial">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th>Tanggal</th>
                                        <th>Material</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th><i class="fa fa-cogs"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($material as $m){ ?>
                                    <tr>
                                        <td>
                                            <?php
                                                $date = date_create($m->tgl_rab_material);
                                                echo date_format($date, 'd M Y');
                                            ?>
                                        </td>
                                        <td>
                                            <b><?= $m->nama_material ?></b> <br>
                                            <small class="text-danger"><?= $m->kategori_produk ?></small>
                                        </td>
                                        <td>
                                            <?= $m->quantity .' '. $m->nama_satuan; ?>
                                        </td>
                                        <td>
                                            Rp. <?= number_format($m->harga) ?>
                                        </td>
                                        <td>
                                            Rp. <?= number_format($m->total); ?>
                                        </td>
                                        <td>
                                            <?php if($m->status == 0){ ?>
                                                <span class="badge badge-pill badge-danger">Di Tolak</span>
                                            <?php } else if($m->status == 1){ ?>
                                                <span class="badge badge-pill badge-warning">Menunggu Accountig</span>
                                            <?php } else if($m->status == 2){ ?>
                                                <span class="badge badge-pill badge-success">Menunggu Super Admin</span>
                                            <?php } else if($m->status == 3){ ?>
                                                <span class="badge badge-pill badge-primary">Approved</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if($user == 3){ ?>
                                                <?php if($m->status == 1){ ?>
                                                    <button class="btn btn-xs btn-success check" data-id="<?= $m->id ?>" data-type="material"><i class="fas fa-check"></i></button>
                                                <?php } else if($m->status == 0){ ?>
                                                    <button class="btn btn-xs btn-warning repeat" data-id="<?= $m->id ?>" data-type="material"><i class="fas fa-redo"></i></button>
                                                <?php } ?>
                                            <?php } ?>
                                            <button class="btn btn-xs btn-dark detail" data-id="<?= $m->id ?>" data-type="material"><i class="fas fa-search"></i></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            
                            <table class="table table-bordered" id="tableUpah">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th>Tanggal</th>
                                        <th>Tipe</th>
                                        <th>Harga Kontrak (/kavling)</th>
                                        <th>Jumlah Kavling</th>
                                        <th>Total Harga Kontrak</th>
                                        <th>Status</th>
                                        <th><i class="fa fa-cogs"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($upah as $u){ ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                    $date = date_create($u->tgl_upah);
                                                    echo date_format($date, 'd M Y');
                                                ?>
                                            </td>
                                            <td><?= $u->tipe ?></td>
                                            <td>Rp. <?= number_format($u->harga_kontrak) ?></td>
                                            <td>
                                                <?php
                                                    $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $u->proyek_id AND tbl_kavling.id_tipe = $u->tipe_id";
                                                    $kav = $this->db->query($q)->num_rows();
                                                    echo $kav;
                                                ?>
                                            </td>
                                            <td>
                                                Rp. <?php $qty = $kav * $u->harga_kontrak; echo number_format($qty); ?>
                                            </td>
                                            <td>
                                                <?php if($u->status_upah == 0){ ?>
                                                    <span class="badge badge-pill badge-danger">Di Tolak</span>
                                                <?php } else if($u->status_upah == 1){ ?>
                                                    <span class="badge badge-pill badge-warning">Menunggu Accountig</span>
                                                <?php } else if($u->status_upah == 2){ ?>
                                                    <span class="badge badge-pill badge-success">Menunggu Super Admin</span>
                                                <?php } else if($u->status_upah == 3){ ?>
                                                    <span class="badge badge-pill badge-primary">Approved</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($user == 3){ ?>
                                                    <?php if($u->status_upah == 1){ ?>
                                                        <button class="btn btn-xs btn-success check" data-id="<?= $u->id_upah ?>" data-type="upah"><i class="fas fa-check"></i></button>
                                                    <?php } else if($u->status_upah == 0){ ?>
                                                        <button class="btn btn-xs btn-warning repeat" data-id="<?= $u->id_upah ?>" data-type="upah"><i class="fas fa-redo"></i></button>
                                                    <?php } ?>
                                                <?php } ?>
                                                <button class="btn btn-xs btn-dark detail" data-id="<?= $u->id_upah ?>" data-type="upah"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            
                            <table class="table table-bordered" id="tableLain">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th>Tanggal</th>
                                        <th>tipe</th>
                                        <th>Jumlah Kavling</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th><i class="fa fa-cogs"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($lain as $l){ ?>
                                    <tr>
                                        <td>
                                            <?php
                                                $date = date_create($l->created_at);
                                                echo date_format($date, 'd M y');
                                            ?>
                                        </td>
                                        <td><?= $l->tipe ?></td>
                                        <td>
                                                <?php
                                                    $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $l->proyek_id AND tbl_kavling.id_tipe = $l->tipe_id";
                                                    $kav = $this->db->query($q)->num_rows();
                                                    echo $kav;
                                                ?>
                                        </td>
                                        <td><?= $l->keterangan ?></td>
                                        <td>Rp. <?= number_format($l->harga_lainnya) ?></td>
                                        <td>
                                            <?php $t = $l->harga_lainnya * $kav; echo number_format($t); ?>
                                        </td>
                                        <td>
                                                <?php if($l->status_lain == 0){ ?>
                                                    <span class="badge badge-pill badge-danger">Di Tolak</span>
                                                <?php } else if($l->status_lain == 1){ ?>
                                                    <span class="badge badge-pill badge-warning">Menunggu Accountig</span>
                                                <?php } else if($l->status_lain == 2){ ?>
                                                    <span class="badge badge-pill badge-success">Menunggu Super Admin</span>
                                                <?php } else if($l->status_lain == 3){ ?>
                                                    <span class="badge badge-pill badge-primary">Approved</span>
                                                <?php } ?>
                                        </td>
                                        <td>
                                                <?php if($user == 3){ ?>
                                                    <?php if($l->status_lain == 1){ ?>
                                                        <button class="btn btn-xs btn-success check" data-id="<?= $l->id_lain ?>" data-type="lain"><i class="fas fa-check"></i></button>
                                                    <?php } else if($l->status_lain == 0){ ?>
                                                        <button class="btn btn-xs btn-warning repeat" data-id="<?= $l->id_lain ?>" data-type="lain"><i class="fas fa-redo"></i></button>
                                                    <?php } ?>
                                                <?php } ?>
                                                <button class="btn btn-xs btn-dark detail" data-id="<?= $l->id_lain ?>" data-type="lain"><i class="fas fa-search"></i></button>
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
        </div>

    </div>
</section>


<!-- Modal detail -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body detailRAB">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Kode-->
<div class="modal fade" id="modalKode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambahkan Kode</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/check_kode_RAB'); ?>" method="post" id="formKode">
      <div class="modal-body">
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="type" id="type">


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