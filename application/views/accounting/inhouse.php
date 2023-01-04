<?php $group = $this->session->userdata('group_id');
  if($group == 1){
    $add = 'd-none';
  } else {
    $add = '';
  }
 ?>
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Accounting Transaksi Inhouse</h1>
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
                        
                        <div class="row">
                          <div class="col-12 col-sm-12 col-md-6 col-lg-6"></div>
                          <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                              <label>Filter by Cluster</label>
                              <select name="f_cluster" id="f_cluster" class="form-control">
                                <option value="">--Pilih--</option>
                                <?php $cluster = $this->master->getClusterByPerum();
                                  $cl = $_GET['cluster'];
                                  foreach($cluster as $c){
                                ?>
                                <?php if($cl == $c->id_cluster){ ?>
                                    <option value="<?= $c->id_cluster ?>" selected><?= $c->nama_cluster ?></option>
                                  <?php } else { ?>
                                    <option value="<?= $c->id_cluster ?>"><?= $c->nama_cluster ?></option>
                                <?php } ?>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>

                    <table class="table table-bordered" id="transaksi-inhouse-table">
                        <thead>
                            <tr class="bg-secondary text-light">
                                <th>#</th>
                                <th>Nama</th>
                                <th>No Telp</th>
                                <th>Blok</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($bank as $b){ ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $b->nama_konsumen ?></td>
                                <td><?= $b->no_hp ?></td>
                                <td><?= $b->blok . $b->no_rumah ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info mb-2 tj"  data-toggle="modal" data-target="#tj" data-id="<?= $b->id_konsumen ?>">Tanda Jadi <i class="fa fa-arrow-right" ></i></button><br>

                                    <button class="btn btn-sm btn-info mb-2 hk"  data-toggle="modal" data-target="#hk" data-id="<?= $b->id_konsumen ?>">Harga Kesepakatan <i class="fa fa-arrow-right" ></i></button><br>

                                    <button class="btn btn-sm btn-info mb-2 tjl"  data-toggle="modal" data-target="#tjl" data-id="<?= $b->id_konsumen ?>">Tanda Jadi Lokasi <i class="fa fa-arrow-right" ></i></button><br>

                                    <button class="btn btn-sm btn-info mb-2 um"  data-toggle="modal" data-target="#um" data-id="<?= $b->id_konsumen ?>">Uang Muka <i class="fa fa-arrow-right"></i></button><br>

                                    <button class="btn btn-sm btn-info mb-2 kt"  data-toggle="modal" data-target="#kt" data-id="<?= $b->id_konsumen ?>">Kelebihan Tanah <i class="fa fa-arrow-right"></i></button><br>

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
<div class="message" data-msg="<?= $this->session->flashdata('true') ?>"></div>

<!-- Modal hk-->
<div class="modal fade" id="hk" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="hktitle" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closehk">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <div class="datahk text-center">
            <div class="spinner-grow text-danger" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal tjl-->
<div class="modal fade" id="tjl" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="tjltitle" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closetjl">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <div class="datatjl text-center">
                    <div class="spinner-grow text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal um-->
<div class="modal fade" id="um" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="umtitle" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeum">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <div class="dataum text-center">

                                <div class="spinner-grow text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal kt-->
<div class="modal fade" id="kt" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="kttitle" id="staticBackdropLabel">Tanda Jadi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closekt">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <div class="datakt text-center">
            <div class="spinner-grow text-secondary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal kt-->
<div class="modal fade" id="tj" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="kttitle" id="staticBackdropLabel">Tanda Jadi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closetj">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <div class="dataTj text-center">
            <div class="spinner-grow text-secondary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- upload bukti transfer -->
<div class="modal fade" id="modalTF" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modaltitle text-light" id="exampleModalLabel">Tambahkan Kode</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form enctype="multipart/form-data" id="submit" action="<?= site_url('pemasukan/to_code'); ?>">
      <div class="modal-body">
          <input type="hidden" name="type" id="type">
          <input type="hidden" name="id" id="id_pembayaran">
      
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
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('pemasukan/add_pemasukan_konsumen'); ?>" id="formPemasukan" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_pembayaran" id="id_add_pembayaran">
        <input type="hidden" name="tipe" id="tipe">
        <div class="row">

          <div class="col-6 <?= $add ?>">
            <div class="form-group">
              <label>Tanggal Pembayaran</label>
              <input type="date" name="tanggal_bayar" id="tanggal_bayar" required class="form-control">
            </div>
          </div>

          <div class="col-6 <?= $add ?>">
            <div class="form-group">
              <label>Jumlah Pembayaran</label>
              <input type="text" name="jml_bayar" id="jml_bayar" required class="form-control">
              <input type="hidden" name="max_bayar" id="max_bayar">
            </div>
          </div>

        </div>


              <table class="table table-bordered">
                <thead>
                  <tr class="bg-info text-light">
                    <td colspan="7">History Pembayaran</td>
                  </tr>
                  <tr class="bg-secondary text-light">
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Bukti Transfer</th>
                    <th>Bukti Nota</th>
                    <th>Status</th>
                    <th><i class="fa fa-cogs"></i></th>
                  </tr>
                </thead>
                <tbody id="loadHistory"></tbody>
                
              </table>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary <?= $add ?>" id="toSave">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modalBukti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title titleBukti" id="exampleModalLabel">Tambahkan Bukti</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('pemasukan/add_bukti'); ?>" id="formAddBukti" method="post">
      <div class="modal-body">
          <input type="hidden" name="id_cicil" id="id_cicil">
          <input type="hidden" name="tipe" id="tipe_cicil">
          <div class="form-group">
            <label>Bukti Transfer</label>
            <input type="file" required name="transfer" id="transfer" class="form-control">
          </div>
          <div class="form-group">
            <label>Bukti Nota</label>
            <input type="file" required name="nota" id="nota" class="form-control">
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