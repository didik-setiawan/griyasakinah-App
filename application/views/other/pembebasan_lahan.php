<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Pembebasan Lahan</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header <?php access(); ?>">
                        <button type="button" class="btn btn-success btn-sm add-data" data-toggle="modal" data-target="#staticBackdrop">
                        <i class="fa fa-plus"></i> Add
                        </button>
                    </div>
                    <div class="card-body">

                    <table class="table table-bordered" id="pemTable">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th>Nama Penjual</th>
                                <th>Perumahan</th>
                                <th>No Surat</th>
                                <th>Jenis Surat</th>
                                <th>Tgl Pengalihan</th>
                                <th>Total Pembelian</th>
                                <th>Status</th>

                                <th>Status Trasfer Dana</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($pembebasan as $p){ 
                              $cicil = $this->db->get_where('cicil_pembebasan_lahan',['id_pembebasan' => $p->id_pembebasan])->result();
                              ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $p->nama_penjual ?></td>
                                    <td><?= $p->nama_perumahan ?></td>
                                    <td><?= $p->no_surat ?></td>
                                    <td><?= $p->jenis_surat ?></td>
                                    <td><?= $p->tgl_pengalihan ?></td>
                                    <td>Rp. <?= number_format($p->total_pembelian) ?></td>
                                    <td>
                                      <?php if($p->status == 1){ ?>
                                        <span class="badge badge-secondary">Menunggu Accounting</span>
                                      <?php } else if($p->status == 2){ ?>
                                        <span class="badge badge-success">Approved</span>
                                      <?php } else if($p->status == 0){ ?>
                                        <span class="badge badge-danger">Di tolak</span>
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
                                        $sisa = $p->total_pembelian - $terbayar;
                                        if($sisa == 0){
                                          $lunas = 'Lunas';
                                        } else {  
                                          $lunas = 'Belum Lunas';
                                        }
                                      ?>
                                        <span class="badge badge-secondary"><?= $lunas ?></span> <br>
                                        <small class="text-success">(Terbayar: Rp. <?= number_format($terbayar) ?>)</small> <br>
                                        <small class="text-danger">(Sisa: Rp. <?= number_format($sisa) ?>)</small>
                                      <?php } else { ?>
                                        -
                                      <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($p->status == 0){ ?>
                                          <a href="<?= site_url('other/del_pembebasan/') . $p->id_pembebasan; ?>" class="btn btn-xs btn-danger delete-data <?php access(); ?>" data-id="<?= $p->id_pembebasan ?>"><i class="fa fa-trash"></i></a>

                                          <button class="btn btn-xs btn-primary edit-data <?php access(); ?>" data-id="<?= $p->id_pembebasan ?>" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-edit"></i></button>
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
<div class="scs-message" data-msg="<?= $this->session->flashdata('scs') ?>"></div>
<div class="err-message" data-msg="<?= $this->session->flashdata('err') ?>"></div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
      <div class="modal-body">
        <input type="hidden" name="id" id="id_p">
        <div class="form-group">
            <label>Nama Penjual</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Jenis Surat Tanah</label>
            <select name="surat" id="surat" class="form-control" required>
                <option value="">--Pilih--</option>
                <option value="SHM">SHM</option>
                <option value="AJB">AJB</option>
                <option value="HGB">HGB</option>
                <option value="Girik">Girik</option>
                <option value="Petok">Petok</option>
            </select>
        </div>

        <div class="form-group">
            <label>No Surat</label>
            <input type="text" name="no_surat" id="no_surat" class="form-control">
        </div>

        <div class="form-group">
            <label>Perumahan</label>
            <select name="perum" id="perum" class="form-control" required>
                <option value="">--Pilih--</option>
                <?php foreach($perum as $p){ ?>
                    <option value="<?= $p->id_perumahan ?>"><?= $p->nama_perumahan ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Tgl Pengalihan</label>
            <input type="date" name="tgl" id="tgl" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Total Harga Pembelian</label>
            <input type="text" name="v_total" id="v_total" class="form-control">
            <input type="text" name="total" id="total" class="form-control" hidden required>
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
<div class="modal fade" id="cicil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Cicilan</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('other/add_cicil'); ?>" method="post">
      <div class="modal-body">
          <input type="hidden" name="id" id="id_cicil">
          <div class="form-group">
                <label>Jumlah Cicilan</label>
                <input type="text" name="v_cicil" id="v_cicil" class="form-control">
                <input type="text" name="cicil" id="cicil_jml" hidden class="form-control" placeholder="" required>
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
<div class="modal fade" id="detailHistory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">History Cicilan</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="history">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>