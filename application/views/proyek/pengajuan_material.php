
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
    </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="card-title">Pengajuan Material</h3>
                            </div>
                            <div class="col-sm-6">
                                <h3 class="card-title float-right text-yellow">Periode : <span class="text-bold" id="periode_laporan"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body style="display: block;">
                        <div class="row">
                            <div class="form-group col-lg-6">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                              <div class="form-group">
                                <label>Filter by Proyek</label>
                                <select name="filter" id="filter" class="form-control">
                                  <option value="">--All--</option>
                                  <?php foreach($filter as $f){ ?>
                                    <?php if($_GET['filter'] == $f->id_pro){ ?>
                                      <option value="<?= $f->id_pro ?>" selected><?= $f->nama_proyek ?></option>
                                    <?php } else { ?>
                                      <option value="<?= $f->id_pro ?>"><?= $f->nama_proyek ?></option>
                                    <?php } ?>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-sm-12 table-responsive">
                                <table class="table table-bordered table-striped table-hover text-nowrap" id="tablePengajuan">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th class="text-center">Tgl Pengajuan</th>
                                            <th class="text-center">Nama Proyek</th>
                                            <th class="text-center">Status</th>
                                           
                                            
                                            <th class="text-center">
                                                <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($data as $d){ 
                                         
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $i++; ?></td>
                                            <td class="text-center"><?php $date = date_create($d->tgl_pengajuan); echo date_format($date, 'd F Y'); ?></td>
                                            <td class="text-center"><?= $d->nama_proyek ?></td>
                                            <td class="text-center">
                                                <?php
                                                    if($d->status_pengajuan == 1){
                                                        $show = 'Di ajukan';
                                                        $color = 'secondary';
                                                    } else if($d->status_pengajuan == 2){
                                                        $show = 'Approved';
                                                        $color = 'warning';
                                                    } else if($d->status_pengajuan == 3){
                                                        $show = 'Menunggu accounting';
                                                        $color = 'success';
                                                    } else if($d->status_pengajuan == 4){
                                                        $show = 'Approved';
                                                        $color = 'info';
                                                    } else if($d->status_pengajuan == 5){
                                                        $show = 'Approved super admin';
                                                        $color = 'primary';
                                                    } else if($d->status_pengajuan == 0){
                                                        $show = 'Di tolak';
                                                        $color = 'danger';
                                                    }
                                                    echo '<span class="badge badge-pill badge-'.$color.'">'.$show.'</span>'
                                                ?>
                                            </td>
                                            
                                            <td class="text-center">
                                            <div class="dropdown">
                                                <a class="btn btn-secondary btn-xs dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-cogs"></i>
                                                </a>

                                                <div class="dropdown-menu">
                                                  <?php if($d->status_pengajuan == 2){ ?>
                                                    <a class="dropdown-item addSupplier" href="#" data-id="<?= $d->id_pengajuan ?>">Tambah Data Supplier</a>
                                                  <?php } ?>
                                                    <a class="dropdown-item addNota" data-id="<?= $d->id_pengajuan ?>" href="#">Tambah Nota</a>
                                                    
                                                    <a class="dropdown-item detail-pengajuan" data-id="<?= $d->id_pengajuan ?>" href="#">Detail</a>
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
    </div>
</section>

<div class="modal fade" id="detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="detailKavlingLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title text-light" id="detailKavlingLabel">Detail Pengajuan Material</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detail-pengajuan">
          <input type="hidden" id="id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="addSupplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body showSupplier">
        
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addNota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Nota</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('proyek/addNotaPengajuan') ?>" method="post" id="formAddNota" enctype="multipart/form-data">
      <div class="modal-body">
        <input type="hidden" name="id_pengajuan" id="id_pengajuan_nota" class="form-control">
        <div class="form-group">
            <label>Bukti Nota</label>
            <input type="file" name="nota" id="nota" class="form-control">
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
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-light">
        <h5 class="modal-title" id="exampleModalLabel">Detail Pengajuan Material</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body showDetails">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="msg_error" data-msg="<?= $this->session->flashdata('error') ?>"></div>
<div class="msg_success" data-msg="<?= $this->session->flashdata('success') ?>"></div>