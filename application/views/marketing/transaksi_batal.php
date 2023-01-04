
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Management Pembatalan Transaksi</h1>
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
                       
                        <table class="table table-bordered" id="table-batal-transaksi">
                            <thead>
                                <tr class="text-light bg-secondary">
                                  
                                    <th>Nama</th>
                                    <th>No Telp</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status Pengembalian Uang</th>
                                    <th>Status Transfer Dana</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($bank as $b){ 
                                  $status = $this->db->get_where('pembatalan_transaksi',['id_user' => $b->id_marketing])->row();

                                  if(isset($status)){
                                    $cicil = $this->db->get_where('cicil_pembatalan',['id_pembatalan' => $status->id_pembatalan])->result();
                                    $terbayar = 0;
                                    foreach($cicil as $c){
                                      if($c->status == 2){
                                        $terbayar += $c->jumlah;
                                      }
                                    }
                                    $sisa = $status->total_pengembalian - $terbayar;
                                    if($sisa == 0){
                                      $lunas = 'Lunas';
                                    } else {
                                      $lunas = 'Belum Lunas';
                                    }
                                  }

                                ?>
                                <tr>
                                
                                    <td><?= $b->nama_konsumen ?></td>
                                    <td><?= $b->no_hp ?></td>
                                    <td><?= $b->jk ?></td>
                                    <td>
                                      <?php if(empty($status->status)){ ?>
                                        Belum ada
                                      <?php } else { ?>
                                        <?php if($status->status == 1){
                                          echo "menunggu persetujuan accounting";
                                        } else if($status->status == 2){
                                          echo "Approved";
                                        } else if($status->status == 0){
                                          echo "Di Tolak";
                                        } ?>
                                      <?php } ?>
                                    </td>
                                    <td>

                                    <?php if(isset($status)){ ?>
                                        <b><?= $lunas; ?></b> <br>
                                        <small class="text-success">(Terbayar : Rp. <?= number_format($terbayar) ?>)</small> <br>
                                        <small class="text-danger">(Sisa : Rp. <?= number_format($sisa) ?>)</small>
                                      <?php } ?>

                                    </td>
                                    <td>
                                    
                                        <button class="btn btn-xs btn-info detail-pembatalan " data-toggle="modal" data-target="#staticBackdrop" data-id="<?= $b->id_marketing ?>"><i class="fas fa-search"></i></button>
                                       

                                        <button type="button" class="btn btn-success btn-xs cetak-spkb <?php access(); ?>" data-toggle="modal" data-target="#staticBackdropcetakspkb" data-id="<?= $b->id_marketing ?>" data-tf="1">
                                          <i class="fa fa-print"></i> Cetak SPKB
                                        </button>

                                        <button type="button" class="btn btn-warning btn-xs to-accounting <?php access(); ?>" data-toggle="modal" data-target="#staticBackdropcetakspkb" data-id="<?= $b->id_marketing ?>" data-tf="1">
                                         Pengembalian Uang
                                        </button>

                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                                Bukti SPKB
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item bukti-spkb" data-id="<?= $b->id_marketing ?>" href="#" data-toggle="modal" data-target="#bukti-spkb">Lihat Bukti SPKB</a>
                                                <a class="dropdown-item add-bukti-spkb <?php access(); ?>" data-id="<?= $b->id_marketing ?>" href="#" data-toggle="modal" data-target="#add-bukti-spkb">Tambah Bukti SPKB</a>
                                            </div>
                                        </div>
                                      
                                    </td>
                                </tr>
                                <?php } ?>

                                <?php $i = 1; foreach($inhouse as $h){ 
                                  $status = $this->db->get_where('pembatalan_transaksi',['id_user' => $h->id_marketing])->row();  
                                  if(isset($status)){
                                    $cicil = $this->db->get_where('cicil_pembatalan',['id_pembatalan' => $status->id_pembatalan])->result();
                                    $terbayar = 0;
                                    foreach($cicil as $c){
                                      if($c->status == 2){
                                        $terbayar += $c->jumlah;
                                      }
                                    }
                                    $sisa = $status->total_pengembalian - $terbayar;
                                    if($sisa == 0){
                                      $lunas = 'Lunas';
                                    } else {
                                      $lunas = 'Belum Lunas';
                                    }
                                  }
                                ?>
                                <tr>
                                
                                    <td><?= $h->nama_konsumen ?></td>
                                    <td><?= $h->no_hp ?></td>
                                    <td><?= $h->jk ?></td>
                                    <td>
                                     
                                      <?php if(empty($status->status)){ ?>
                                        Belum ada
                                      <?php } else { ?>
                                        <?php if($status->status == 1){
                                          echo "menunggu persetujuan accounting";
                                        } else if($status->status == 2){
                                          echo "Approved";
                                        } else if($status->status == 0){
                                          echo "Di Tolak";
                                        } ?>
                                      <?php } ?>
                                    </td>
                                    <td>

                                      <?php if(isset($status)){ ?>
                                        <b><?= $lunas; ?></b> <br>
                                        <small class="text-success">(Terbayar : Rp. <?= number_format($terbayar) ?>)</small> <br>
                                        <small class="text-danger">(Sisa : Rp. <?= number_format($sisa) ?>)</small>
                                      <?php } ?>

                                    </td>
                                    <td>
                                    
                                        <button class="btn btn-xs btn-info detail-pembatalan" data-toggle="modal" data-target="#staticBackdrop" data-id="<?= $h->id_marketing ?>"><i class="fas fa-search"></i></button>
                                       

                                        <button type="button" class="btn btn-success btn-xs cetak-spkb <?php access(); ?>" data-toggle="modal" data-target="#staticBackdropcetakspkb" data-id="<?= $h->id_marketing ?>" data-tf="2">
                                          <i class="fa fa-print"></i> Cetak SPKB
                                        </button>

                                        <button type="button" class="btn btn-warning btn-xs to-accounting <?php access(); ?>" data-toggle="modal" data-target="#staticBackdropcetakspkb" data-id="<?= $h->id_marketing ?>" data-tf="2">
                                         Pengembalian Uang
                                        </button>

                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                                Bukti SPKB
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item bukti-spkb" data-id="<?= $h->id_marketing ?>" href="#" data-toggle="modal" data-target="#bukti-spkb">Lihat Bukti SPKB</a>
                                                <a class="dropdown-item add-bukti-spkb <?php access(); ?>" data-id="<?= $h->id_marketing ?>" href="#" data-toggle="modal" data-target="#add-bukti-spkb">Tambah Bukti SPKB</a>
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

<div class="false" data-pesan="<?= $this->session->flashdata('false'); ?>"></div>
<div class="true" data-pesan="<?= $this->session->flashdata('true'); ?>"></div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Detail Transaksi Konsumen</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detail-pembatalan">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal bukti spkb-->
<div class="modal fade" id="bukti-spkb" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bukti SPKB</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bukti-spkb-show">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal add bukti spkb-->
<div class="modal fade" id="add-bukti-spkb" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Bukti SPKB</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('marketing/add_bukti_spkb'); ?>" enctype="multipart/form-data" method="post">
        <div class="modal-body">
                <input type="hidden" name="id_konsumen" id="id_konsumen_spkb">
                <input type="file" name="bukti_spkb" class="form-control" required id="bukti_spkb">
                <small class="text-danger">File yang di izinkan : gif, png, jpg, jpeg, pdf</small>
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
<div class="modal fade" id="staticBackdropcetakspkb" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Pilih Pengembalian Uang</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('marketing/gen_spkb'); ?>" method="post" id="theFormPengembalian" target="_blank">
      <div class="modal-body">
        <input type="hidden" name="id_konsumen" id="id_cetak_spkb">

        <div class="tf-bank">
          <div class="form-check" id="tj_b">
            <input class="form-check-input" type="checkbox" value="1" name="tj" id="ck_tj_b">
            <label class="form-check-label" for="defaultCheck1">
              Tanda Jadi
            </label>
          </div>
          
          <div class="form-check" id="tjl_b">
            <input class="form-check-input" type="checkbox" value="1" name="tjl" id="ck_tjl_b">
            <label class="form-check-label" for="defaultCheck1">
              Tanda Jadi Lokasi
            </label>
          </div>

          <div class="form-check" id="um_b">
            <input class="form-check-input" type="checkbox" value="1" name="um" id="ck_um_b">
            <label class="form-check-label" for="defaultCheck1">
              Uang Muka
            </label>
          </div>

          <div class="form-check" id="kt_b">
            <input class="form-check-input" type="checkbox" value="1" name="kt" id="ck_kt_b">
            <label class="form-check-label" for="defaultCheck1">
              Kelebihan Tanah
            </label>
          </div>

          <div class="form-check" id="pak_b">
            <input class="form-check-input" type="checkbox" value="1" name="pak" id="ck_pak_b">
            <label class="form-check-label" for="defaultCheck1">
              PAK
            </label>
          </div>

          <div class="form-check" id="lain_b">
            <input class="form-check-input" type="checkbox" value="1" name="lain" id="ck_lain_b">
            <label class="form-check-label" for="defaultCheck1">
              Lain-lain
            </label>
          </div>

          <div class="form-check" id="angsur_b">
            <input class="form-check-input" type="checkbox" value="1" name="angsur" id="ck_angsur_b">
            <label class="form-check-label" for="defaultCheck1">
              Angsuran Bank
            </label>
          </div>

          <div class="form-check" id="piutang_b">
            <input class="form-check-input" type="checkbox" value="1" name="piutang" id="ck_piutang_b">
            <label class="form-check-label" for="defaultCheck1">
              Piutang Bank
            </label>
          </div>

        </div>

        <div class="tf-inhouse">

          <div class="form-check" id="tj_i">
            <input class="form-check-input" type="checkbox" value="1" name="tj_i" id="ck_tj_i">
            <label class="form-check-label" for="defaultCheck1">
              Tanda Jadi
            </label>
          </div>

          <div class="form-check" id="hk_i">
            <input class="form-check-input" type="checkbox" value="1" name="hk_i" id="ck_hk_i">
            <label class="form-check-label" for="defaultCheck1">
              Harga Kesepakatan
            </label>
          </div>

          <div class="form-check" id="um_i">
            <input class="form-check-input" type="checkbox" value="1" name="um_i" id="ck_um_i">
            <label class="form-check-label" for="defaultCheck1">
              Uang Muka
            </label>
          </div>

          <div class="form-check" id="kt_i">
            <input class="form-check-input" type="checkbox" value="1" name="kt_i" id="ck_kt_i">
            <label class="form-check-label" for="defaultCheck1">
              Kelebihan Tanah
            </label>
          </div>

          <div class="form-check" id="tjl_i">
            <input class="form-check-input" type="checkbox" value="1" name="tjl_i" id="ck_tjl_i">
            <label class="form-check-label" for="defaultCheck1">
              Tanda Jadi Lokasi
            </label>
          </div>

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" id="btnSubmit"><i class="fa fa-print"></i> Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>