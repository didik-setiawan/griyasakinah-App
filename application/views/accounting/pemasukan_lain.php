<?php
    $kode = $this->db->get('kode')->result();
    $role = $this->session->userdata('group_id');
?>
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Pemasukan Lain</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

        <div class="card">
            <div class="card-body">
                <button class="btn btn-sm btn-success btnAdd mb-3"><i class="fa fa-plus"></i> Tambah</button>

                <table class="table table-bordered" id="tableLain">
                    <thead>
                        <tr class="bg-dark text-light">
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($data as $d){ ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?php $date = date_create($d->tanggal); echo date_format($date, 'd F Y'); ?></td>
                            <td><?= $d->keterangan ?></td>
                            <td>Rp. <?= number_format($d->jumlah); ?></td>
                            <td>
                                <?php
                                    if($d->status == 0){
                                        $color = 'danger';
                                        $txt = 'Di Tolak';
                                    } else if($d->status == 1){
                                        $color = 'warning';
                                        $txt = 'Menunggu Super Admin';
                                    } else if($d->status == 2){
                                        $color = 'primary';
                                        $txt = 'Approved Super Admin';
                                    }
                                    echo '<span class="badge badge-'.$color.'">'.$txt.'</span>';
                                ?>
                            </td>
                            <td>
                                <button class="btn btn-xs btn-secondary details" data-id="<?= $d->id_pemasukan ?>"><i class="fa fa-search"></i></button>

                                <?php if($role == 1){ ?>
                                    <?php if($d->status == 1){ ?>
                                        <button class="btn btn-xs btn-success approve" data-id="<?= $d->id_pemasukan ?>"><i class="fa fa-check"></i></button>
                                        <button class="btn btn-xs btn-danger reject" data-id="<?= $d->id_pemasukan ?>"><i class="fa fa-times"></i></button>
                                    <?php } ?>
                                <?php } else if($role == 3 || $role == 7){ ?>
                                    <?php if($d->status == 0){ ?>
                                        <button class="btn btn-xs btn-warning edit" data-id="<?= $d->id_pemasukan ?>"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-xs btn-danger delete" data-id="<?= $d->id_pemasukan ?>"><i class="fa fa-trash"></i></button>
                                    <?php } ?>
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
<div>

</section>


<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title titleAdd" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" id="formAdd" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_pemasukan" id="id_pemasukan">
        <div class="form-group">
            <label>Keterangan</label>
            <input type="text" name="ket" id="ket" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Jumlah</label>
            <input type="text" name="vjumlah" id="v_jumlah" class="form-control" required>
            <input type="hidden" name="jumlah" id="jml">
        </div>
        <div class="form-group">
            <label>Bukti</label>
            <input type="file" name="bukti" id="bukti" class="form-control">
        </div>

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

        <div class="text-center form-group showBukti">
            <label>Bukti</label> <br>
            <img src="" width="80%" id="imgBukti" alt="">
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
<div class="modal fade" id="modalDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title" id="exampleModalLabel">Detail Pemasukan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body showDetail">
        
        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>