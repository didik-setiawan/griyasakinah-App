<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Pengeluaran Lain</h1>
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
                    <div class="card-header <?php access(); ?>">
                        <button type="button" class="btn btn-primary btn-sm add-data" data-toggle="modal" data-target="#staticBackdrop">
                        <i class="fa fa-plus"></i> Add
                        </button>

                        <button class="btn btn-sm btn-success to-excel" data-toggle="modal" data-target="#exampleModalCetak">
                            Export Excel <i class="fas fa-file-excel"></i>
                        </button>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered" id="pengTable">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Ket</th>
                                    <th>Status</th>
                                    <th>Status Transfer Dana</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($pengeluaran as $p){ 
                                  $cicil = $this->db->get_where('cicil_pengeluaran_lain',['id_pengeluaran' => $p->id_pengeluaran])->result();
                                  ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $p->tgl_pengeluaran ?></td>
                                    <td>Rp. <?= number_format($p->jml_pengeluaran); ?></td>
                                    <td><?= $p->keterangan ?></td>
                                    <td>
                                    <?php if($p->status == 0){ ?>
                                        <span class="badge badge-danger">Di Tolak</span>
                                      <?php } else if($p->status == 1){ ?>
                                        <span class="badge badge-warning">Menunggu Persetujuan Accounting</span>
                                      <?php } else if($p->status == 2){ ?>
                                        <span class="badge badge-success">Approved</span>
                                      <?php } ?>
                                    </td>
                                    <td>
                                        <?php if(isset($cicil)){ 
                                            $terbayar = 0;
                                            foreach($cicil as $c){
                                              if($c->status == 2){
                                                $terbayar += $c->jumlah;
                                              }
                                            }
                                            $sisa = $p->jml_pengeluaran - $terbayar;
                                            if($sisa == 0){
                                              $lunas = 'Lunas';
                                            } else {
                                              $lunas = 'Belum Lunas';
                                            }
                                          ?>
                                          <span class="badge badge-secondary"><?= $lunas ?></span> <br>
                                          <small class="text-success">(Terbayar: Rp. <?= number_format($terbayar) ?>)</small> <br>
                                          <small class="text-danger">(Sisa : Rp. <?= number_format($sisa); ?>)</small>
                                        <?php } else { ?>
                                          -
                                        <?php } ?>
                                    </td>
                                    <td>
                                      <div class="<?php access(); ?>">
                                        <?php if($p->status == 0){ ?>
                                          <a href="<?= site_url('other/del_pengeluaran'); ?>" class="btn btn-xs btn-danger delete-data" data-id="<?=$p->id_pengeluaran?>"><i class="fa fa-trash"></i></a>
                                      
                                        <button class="btn btn-xs btn-primary edit-data" data-id="<?=$p->id_pengeluaran?>" data-toggle="modal" data-target="#staticBackdrop">
                                          <i class="fa fa-edit"></i>
                                        </button>
                                        <?php } ?>
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

<div class="scs-message" data-msg="<?= $this->session->flashdata('scs') ?>"></div>
<div class="err-message" data-msg="<?= $this->session->flashdata('err') ?>"></div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
      <div class="modal-body">
        <input type="hidden" name="id" id="id_p">
        <div class="form-group">
            <label>Tgl Pengeluaran</label>
            <input type="date" class="form-control" name="tgl" id="tgl" required>
        </div>
        <div class="form-group">
            <label>Jumlah Pengeluaran</label>
            <input type="text" class="form-control" name="v_jml" id="v_jml" required>
            <input type="text" class="form-control" hidden name="jml" id="jml" required>
        </div>
        <div class="form-group">
            <label>Keterangan Pengeluaran</label>
            <textarea class="form-control" name="ket" id="ket" rows="7" required></textarea>
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
<div class="modal fade" id="exampleModalCetak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success bg-gradient">
        <h5 class="modal-title text-light" id="exampleModalLabel">Export Excel</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('other/gen_pengeluaran_excel'); ?>" method="post" target="_blank">
      <div class="modal-body">
        <h5 class="text-center"> <i class="fas fa-filter"></i> Filter Tanggal</h5><hr>
        <div class="row">
            <div class="col-6">
                <label>Dari Tanggal</label>
                <input type="date" name="tgl_f" id="tgl_f" class="form-control" required>
            </div>
            <div class="col-6">
                <label>Sampai Tanggal</label>
                <input type="date" name="tgl_t" id="tgl_t" class="form-control" required>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Export</button>
      </div>
      </form>
    </div>
  </div>
</div>