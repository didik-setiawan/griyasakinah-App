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
                    <div class="card-body">
                       
                        <table class="table table-bordered" id="kpr-konsumen">
                            <thead>
                                <tr class="bg-secondary">
                                    
                                    <th>Nama</th>
                                    <th>No Telp</th>
                                    <th>Fee Marketing</th>
                                    <th>Status</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($bank as $b){
                                    $sbb = $this->db->get_where('tbl_marketing',['id_marketing' => $b->id_marketing])->row();
                                    ?>
                                <tr>
                                    <td><?= $b->nama_konsumen ?></td>
                                    <td><?= $b->no_hp ?></td>
                                    <td>
                                            <?php if($b->status_fee_marketing == 0){ ?>
                                                <p class="text-danger"><i class="fas fa-times"></i> Belum</p>
                                            <?php } else if($b->status_fee_marketing == 1){ ?>
                                                <p class="text-warning"><i class="fas fa-exclamation"></i> Menunggu Konfirmasi Accounting</p>
                                            <?php } else if($b->status_fee_marketing == 2){ ?>
                                                <p class="text-warning"><i class="fas fa-exclamation"></i> Menunggu Konfirmasi Super Admin</p>
                                            <?php } else if($b->status_fee_marketing == 3){ ?>
                                                <p class="text-success"><i class="fas fa-check"></i> Sudah</p>
                                            <?php } else if($b->status_fee_marketing == 4){ ?>
                                                <p class="text-danger"><i class="fas fa-times"></i> Di tolak super admin</p>
                                            <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($sbb->status == 2){ ?>
                                            Konsumen
                                        <?php } else if($sbb->status == 3){ ?>
                                            Konsumen
                                        <?php } else if($sbb->status == 4){ ?>
                                            Pemberkasan
                                        <?php } else if($sbb->status == 5){ ?>
                                            Wawancara
                                        <?php } else if($sbb->status == 6){ ?>
                                            SP3K
                                        <?php } else if($sbb->status == 7){ ?>
                                            Pembangunan
                                        <?php } else if($sbb->status == 8){ ?>
                                            Realisasi
                                        <?php } ?>
                                    </td>
                                    <td>
                                            <div class="btn-group <?php access(); ?>">
                                                <button type="button" class="btn btn-danger dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                                                    Edit Status Konsumen
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="<?= site_url('kpr/pemberkasan/') . $b->id_marketing; ?>">Pemberkasan</a>
                                                    <a class="dropdown-item" href="<?= site_url('kpr/wawancara/') . $b->id_marketing; ?>">Wawancara</a>
                                                    <a class="dropdown-item" href="<?= site_url('kpr/sp3k/') . $b->id_marketing; ?>">SP3K</a>
                                                    <a class="dropdown-item" href="<?= site_url('kpr/pembangunan/') . $b->id_marketing; ?>">Pembangunan</a>
                                                    <a class="dropdown-item" href="<?= site_url('kpr/realisasi/') . $b->id_marketing; ?>">Realisasi</a>
                                                    <a class="dropdown-item rejec-konsumen" href="<?= site_url('kpr/rejec_konsumen/') . $b->id_marketing; ?>">Rejec</a>
                                                </div>
                                            </div>
                                       
                                    </td>
                                </tr>
                                <?php } ?>


                                <?php $i = 1; foreach($inhouse as $h){ 
                                    $sb = $this->db->get_where('tbl_marketing',['id_marketing' => $h->id_marketing])->row();
                                    ?>
                                <tr>
                                    <td><?= $h->nama_konsumen ?></td>
                                    <td><?= $h->no_hp ?></td>
                                    <td>
                                            <?php if($h->status_fee_marketing == 0){ ?>
                                                <p class="text-danger"><i class="fas fa-times"></i> Belum</p>
                                            <?php } else if($h->status_fee_marketing == 1){ ?>
                                                <p class="text-warning"><i class="fas fa-exclamation"></i> Menunggu Konfirmasi Accounting</p>
                                            <?php } else if($h->status_fee_marketing == 2){ ?>
                                                <p class="text-warning"><i class="fas fa-exclamation"></i> Menunggu Konfirmasi Super Admin</p>
                                            <?php } else if($h->status_fee_marketing == 3){ ?>
                                                <p class="text-success"><i class="fas fa-check"></i> Sudah</p>
                                            <?php } else if($h->status_fee_marketing == 4){ ?>
                                                <p class="text-danger"><i class="fas fa-times"></i> Di tolak super admin</p>
                                            <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($sb->status == 2){ ?>
                                            Konsumen
                                        <?php } else if($sb->status == 3){ ?>
                                            Konsumen
                                        <?php } else if($sb->status == 4){ ?>
                                            Pemberkasan
                                        <?php } else if($sb->status == 5){ ?>
                                            Wawancara
                                        <?php } else if($sb->status == 6){ ?>
                                            SP3K
                                        <?php } else if($sb->status == 7){ ?>
                                            Pembangunan
                                        <?php } else if($sb->status == 8){ ?>
                                            Realisasi
                                        <?php } ?>
                                    </td>
                                    <td>
                                            <div class="btn-group <?php access(); ?>">
                                                <button type="button" class="btn btn-danger dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                                                    Edit Status Konsumen
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="<?= site_url('kpr/pemberkasan/') . $h->id_marketing; ?>">Pemberkasan</a>
                                                    <a class="dropdown-item" href="<?= site_url('kpr/wawancara/') . $h->id_marketing; ?>">Wawancara</a>
                                                    <a class="dropdown-item" href="<?= site_url('kpr/sp3k/') . $h->id_marketing; ?>">SP3K</a>
                                                    <a class="dropdown-item" href="<?= site_url('kpr/pembangunan/') . $h->id_marketing; ?>">Pembangunan</a>
                                                    <a class="dropdown-item" href="<?= site_url('kpr/realisasi/') . $h->id_marketing; ?>">Realisasi</a>
                                                    <a class="dropdown-item rejec-konsumen" href="<?= site_url('kpr/rejec_konsumen/') . $h->id_marketing; ?>">Rejec</a>
                                                </div>
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
<!-- /.content -->
<div class="scs" data-flashdata="<?= $this->session->flashdata('scs'); ?>"></div>
<div class="err" data-flashdata="<?= $this->session->flashdata('err'); ?>"></div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Fee Marketing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-check"></i> Konfirmasi Fee Marketing</button>
      </div> -->
    </div>
  </div>
</div>