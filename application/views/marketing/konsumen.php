<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Management Konsumen</h1>
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
                    <div class="card-body table-responsive">
                <?php if($this->session->flashdata('true')){ ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><?= $this->session->flashdata('true'); ?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } else if($this->session->flashdata('false')){ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?= $this->session->flashdata('false'); ?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>

                
                    <a href="<?= site_url('marketing/rekap_konsumen'); ?>" class="btn btn-sm btn-success mb-3">Rekap Konsumen</a>
                        <table class="table table-bordered" id="table-konsumen">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>Nama</th>
                                    <th>Telp</th>
                                    <th>Pekerjaan</th>
                                    <th>Blok</th>
                                    <th>Status</th>
                                    <th>Fee marketing</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($bank as $b){ ?>
                                    <tr>
                                        <td><?= $b->nama_konsumen ?></td>
                                        <td><?= $b->no_hp ?></td>
                                        <td><?= $b->pekerjaan ?></td>
                                        <td><?= $b->blok . $b->no_rumah ?></td>
                                        <td>
                                        <?php $st = $this->db->get_where('tbl_marketing',['id_marketing' => $b->id_marketing])->row()->status;

                                        if($st == 2){
                                            echo "Konsumen";
                                        } else if($st == 4){
                                            echo "Pemberkasan";
                                        } else if($st == 5){
                                            echo "Wawancara";
                                        } else if($st == 6){
                                            echo "SP3K";
                                        } else if($st == 7){
                                            echo "Pembangunan";
                                        } else if($st == 8){
                                            echo "Realisasi";
                                        }

                                        ?>
                                        </td>
                                        <td>
                                            <?php if($b->status_fee_marketing == 0){ ?>
                                                <p class="text-danger"><i class="fas fa-times"></i> Belum</p>
                                            <?php } else if($b->status_fee_marketing == 1){ ?>
                                                <p class="text-warning"><i class="fas fa-exclamation"></i> Menunggu Konfirmasi Accounting</p>
                                            <?php } else if($b->status_fee_marketing == 2){ ?>
                                                <p class="text-success"><i class="fas fa-check"></i> Approved</p>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <!-- <div class="<?php access(); ?>"> -->
                                            <button class="btn btn-xs btn-danger btn-batal-transaksi-bank <?php access(); ?>" data-id="<?= $b->id_konsumen ?>"><i class="fa fa-times"></i> Batalkan Transaksi</button>
                                            <?php if($b->status_fee_marketing == 0){ ?>
                                                <?php if($st == 8){ ?>
                                            <button class="btn btn-xs btn-primary ajukan-feemarketing <?php access(); ?>" data-toggle="modal" data-target="#staticBackdrop" data-id="<?= $b->id_konsumen ?>"><i class="fas fa-hand-holding"></i> Ajukan Fee Marketing</button>
                                            <?php } ?>
                                            <?php } else if($b->status_fee_marketing == 1){ ?>

                                            <!-- <button class="btn btn-success btn-xs acc-fee-marketing" data-id="<?= $b->id_marketing ?>"><i class="fas fa-check"></i> Acc Fee Marketing</button> -->

                                            <button class="btn btn-xs btn-secondary detail-fee-marketing <?php access(); ?>" data-id="<?= $b->id_marketing ?>"  data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i> Detail Fee Marketing</button>

                                            <?php } else if($b->status_fee_marketing == 2){ ?>
                                                <button class="btn btn-xs btn-secondary detail-fee-marketing <?php access(); ?>" data-id="<?= $b->id_marketing ?>"  data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i> Detail Fee Marketing</button>

                                                
                                            <?php } ?>
                                                
                                            
                                            <a href="<?= site_url('marketing/gen_spr/' . $b->id_marketing); ?>" target="_blank" class="btn btn-xs btn-success <?php access(); ?>"><i class="fa fa-print"></i> Cetak SPR</a>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-secondary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    Bukti SPR
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item bukti-spr" data-id="<?= $b->id_marketing ?>" href="#" data-toggle="modal" data-target="#bukti-spr">Lihat Bukti SPR</a>
                                                    <a class="dropdown-item add-bukti-spr <?php access(); ?>" data-id="<?= $b->id_marketing ?>" href="#" data-toggle="modal" data-target="#add-bukti-spr">Tambah Bukti SPR</a>
                                                </div>
                                            </div>

                                            <div class="dropdown">
                                                <button class="btn btn-xs btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                    Sertifikat
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item view-sertifikat" href="#" data-id="<?= $b->id_marketing ?>">Lihat Sertifikat</a>
                                                    <a class="dropdown-item add-sertifikat" href="#" data-id="<?= $b->id_marketing ?>">Tambah Sertifikat</a>
                                                </div>
                                            </div>

                                            <!-- </div> -->
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php foreach($inhouse as $i){ ?>
                                    <tr>
                                        <td><?= $i->nama_konsumen ?></td>
                                        <td><?= $i->no_hp ?></td>
                                        <td><?= $i->pekerjaan ?></td>
                                        <td><?= $i->blok . $i->no_rumah ?></td>
                                        <td><?php $st = $this->db->get_where('tbl_marketing',['id_marketing' => $i->id_marketing])->row()->status;

                                        if($st == 3){
                                            echo "Konsumen";
                                        } else if($st == 4){
                                            echo "Pemberkasan";
                                        } else if($st == 5){
                                            echo "Wawancara";
                                        } else if($st == 6){
                                            echo "SP3K";
                                        } else if($st == 7){
                                            echo "Pembangunan";
                                        } else if($st == 8){
                                            echo "Realisasi";
                                        }

                                        ?></td>
                                        <td>
                                            <?php if($i->status_fee_marketing == 0){ ?>
                                                <p class="text-danger"><i class="fas fa-times"></i> Belum</p>
                                            <?php } else if($i->status_fee_marketing == 1){ ?>
                                                <p class="text-warning"><i class="fas fa-exclamation"></i> Menunggu Konfirmasi Accounting</p>
                                            <?php } else if($i->status_fee_marketing == 2){ ?>
                                               <p class="text-success"><i class="fas fa-check"></i> Approved</p>
                                            <?php } ?>
                                        </td>
                                        <td>
                                        <!-- <div class="<?php access(); ?>"> -->
                                            <button class="btn btn-xs btn-danger btn-batal-transaksi-inhouse <?php access(); ?>" data-id="<?= $i->id_konsumen ?>"><i class="fa fa-times"></i> Batalkan Transaksi</button>

                                            <?php if($i->status_fee_marketing == 0){ ?>
                                                <?php if($st == 8){ ?>
                                            <button class="btn btn-xs btn-primary ajukan-feemarketing <?php access(); ?>" data-toggle="modal" data-target="#staticBackdrop" data-id="<?= $i->id_konsumen ?>"><i class="fas fa-hand-holding"></i> Ajukan Fee Marketing</button>
                                            <?php } ?>
                                            
                                            <?php } else if($i->status_fee_marketing == 1){ ?>

                                                <!-- <button class="btn btn-success btn-xs acc-fee-marketing" data-id="<?= $i->id_marketing ?>"><i class="fas fa-check"></i> Acc Fee Marketing</button> -->

                                                <button class="btn btn-xs btn-secondary detail-fee-marketing <?php access(); ?>" data-id="<?= $i->id_marketing ?>"  data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i> Detail Fee Marketing</button>
                                            
                                            <?php } else if($i->status_fee_marketing == 2){ ?>
                                                <button class="btn btn-xs btn-secondary detail-fee-marketing <?php access(); ?>" data-id="<?= $i->id_marketing ?>"  data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i> Detail Fee Marketing</button>
                                            <?php } ?>

                                          
                                                <a href="<?= site_url('marketing/gen_spr/' . $i->id_marketing); ?>" target="_blank" class="btn btn-xs btn-success <?php access(); ?>"><i class="fa fa-print"></i> Cetak SPR</a>

                                                <div class="btn-group">
                                                <button type="button" class="btn btn-secondary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    Bukti SPR
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item bukti-spr" data-id="<?= $i->id_marketing ?>" href="#" data-toggle="modal" data-target="#bukti-spr">Lihat Bukti SPR</a>
                                                    <a class="dropdown-item add-bukti-spr <?php access(); ?>" data-id="<?= $i->id_marketing ?>" href="#" data-toggle="modal" data-target="#add-bukti-spr">Tambah Bukti SPR</a>
                                                </div>
                                            </div>
                                          
                                            <div class="dropdown">
                                                    <button class="btn btn-xs btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                                        Sertifikat
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item view-sertifikat" href="#" data-id="<?= $i->id_marketing ?>">Lihat Sertifikat</a>
                                                        <a class="dropdown-item add-sertifikat" href="#" data-id="<?= $i->id_marketing ?>">Tambah Sertifikat</a>
                                                    </div>
                                                </div>
                                        <!-- </div> -->
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


<!-- Modal add fee marketing -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Ajukan Fee Marketing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('marketing/ajukan_fee_marketing'); ?>" enctype="multipart/form-data" method="post">
      <div class="modal-body">
          <input type="hidden" name="id_konsumen" id="id_konsumen">
            <div class="form-group">
                <label>Nomial</label>
                <input type="text" name="nominal" required id="nominal" class="form-control">
            </div>
            <div class="form-group">
                <label>Foto</label>
                    <input type="file" name="foto" required id="foto" class="form-control">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal detail fee marketing-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Fee Marketing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detail-fee-marketing">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal bukti spr-->
<div class="modal fade" id="bukti-spr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bukti SPR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bukti-spr-show">
        
        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="add-bukti-spr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Bukti SPR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- <form action="" enctype="multipart/form-data" method="post"> -->
      <?= form_open_multipart('marketing/add_bukti_spr') ?>
        <div class="modal-body">
                <input type="hidden" name="id_konsumen" id="id_konsumen_spr">
                <input type="file" required name="userfile" id="bukti_spr" class="form-control">
                <small class="text-danger">File yang di izinkan : gif, jpg, png, jpeg, pdf</small>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewSertifikat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sertifikat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body showSertifikat">
                                                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addSertifikat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Sertifikat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('marketing/add_sertifikat') ?>" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        <input type="hidden" name="id_konsumen" id="id_konsumen_sertifikat">
        <div class="form-group">
            <label>File Sertifikat</label>
            <input type="file" name="file" id="file" required class="form-control">
            <small class="text-danger">File yang di izinkan: jpg, jpeg, png, gif</small>
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