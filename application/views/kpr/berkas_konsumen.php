<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Management Berkas Konsumen</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card table-responsive">
                    <div class="card-body">

                        <!-- <button class="btn btn-sm btn-success add-berkas" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-plus"></i> Tambah Berkas</button> -->

    <table class="table table-bordered" id="berkas-konsumen">
        <thead>
            <tr class="bg-dark text-light">
                <th>#</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>No Telp</th>
                <th>Berkas</th>
                <th><i class="fa fa-cogs"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach ($konsumen as $k) {
                // $status = $this->db->get_where('tbl_marketing',['id_marketing' => $k->id_marketing])->row()->status;
                ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $k->nama_konsumen ?></td>
                <td><?= $k->jk ?></td>
                <td><?= $k->no_hp ?></td>
                <td>
                    
<?php
$q = "SELECT DISTINCT keterangan FROM berkas_konsumen WHERE id_konsumen = $k->id_marketing";
$berkas = $this->db->query($q)->result();
?>
               
                <?php if($berkas){ ?>

                                <table class="table table-bordered">
                                    <tbody>
                                        <?php foreach ($berkas as $br) { ?>
                                     
                                            <tr>
                                                <td>
                                                <?= $br->keterangan ?>
                                                </td>
                                                <td>
                                                  <button class="btn btn-xs btn-success view-berkas" data-toggle="modal" data-target="#modalView" data-id="<?= $k->id_marketing ?>" data-keterangan="<?= $br->keterangan ?>"><i class="fas fa-eye"></i>
                                                </button>
                                              </td>
                                            </tr>
                                           
                                        <?php } ?>
                                    </tbody>
                                </table>
                               
                <?php } else { ?>
                    <i>No data result</i>
                <?php } ?>

                </td>
                <td>
                    <!-- <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item add-berkas" href="#" data-toggle="modal" data-target="#staticBackdrop" data-id="<?= $k->id_marketing ?>">Tambah Berkas</a>
                            <a class="dropdown-item view-berkas" data-toggle="modal" data-target="#modalView" data-id="<?= $k->id_marketing ?>" href="#">View Berkas</a>
                        </div>
                    </div> -->
                    <button class="btn btn-xs btn-primary add-berkas <?php access(); ?>" data-toggle="modal" data-target="#staticBackdrop" data-id="<?= $k->id_marketing ?>"><i class="fa fa-plus"></i></button>
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
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Tambah Berkas</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('kpr/add_berkas'); ?>" method="post" enctype="multipart/form-data">
      <div class="modal-body">
          <input type="hidden" name="id_konsumen" id="id_konsumen">
        <div class="form-group">
            <label>File Berkas</label>
            <input type="file" required name="file" id="file" class="form-control">
        </div>
        <div class="form-group">
            <label>Keterangan Berkas</label>
            <select name="kategori" id="kategori" required class="form-control">
                <option value="">--Pilih--</option>
                <?php $data = [
                    'KK','KTP','NPWP','Surat nikah/cerai','Slip gaji 3 bulan terakhir','Surat keterangan kerja','Rekening koran 3 bulan terakhir','Fotocopy sertifikat rumah','Fotokopi IMB'
                ];
                    foreach ($data as $d) {
                ?>
                        <option value="<?= $d ?>"><?= $d ?></option>

                <?php } ?>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalView" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Berkas Konsumen</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-berkas">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="msg-true" data-pesan="<?= $this->session->flashdata('true'); ?>"></div>
<div class="msg-false" data-pesan="<?= $this->session->flashdata('false'); ?>"></div>