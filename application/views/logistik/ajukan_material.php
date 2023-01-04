<?php
    $this->cart->destroy();
    $group = $this->session->userdata('group_id');
    if($group == 1){
        $act = '';
    } else if($group == 2){
        $act = 'd-none';
    } else if($group == 5){
        $act = '';
    } else {
        $act = 'd-none';
    }

    // var_dump($proyek); die;

?>

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
                            <div class="form-group col-sm-9">
                                                  
                                            <div class="btn-group <?= $act ?>">
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahPengajuan" id="addPengajuan"><i class="fa fa-plus"></i> Pengajuan Material</button>
                                            </div>
                                      
                            </div>
     
                            <div class="form-group col-sm-3">
                                
                            </div>
                            <div class="form-group col-sm-4">
                            </div>

                            <div class="col-sm-12 table-responsive">
                                <table class="table table-bordered table-striped table-hover text-nowrap" id="tablePengajuan">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>No.</th>
                                            <th class="text-center">Tgl Pengajuan</th>
                                            <th class="text-center">Nama Proyek</th>
                                           
                                            <th class="text-center">Status</th>
                                            <th class="text-center">
                                                <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($data as $d){ ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            
                                            <td><?php $date = date_create($d->tgl_pengajuan); echo date_format($date, 'd F Y'); ?></td>
                                            <td><?= $d->nama_proyek ?></td>
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
                                                <button class="btn btn-xs btn-secondary detail" data-id="<?= $d->id_pengajuan ?>"><i class="fas fa-search"></i></button>
                                                <?php if($group == 1){ ?>
                                                    <?php if($d->status_pengajuan == 1){ ?>
                                                    <button class="btn btn-xs btn-success check" data-id="<?= $d->id_pengajuan ?>"><i class="fa fa-check"></i></button>
                                                    <button class="btn btn-xs btn-danger reject" data-id="<?= $d->id_pengajuan ?>"><i class="fa fa-times"></i></button>
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
            
        </div>
    </div>
</section>





    <div class="modal fade" id="tambahPengajuan"> 
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title"><i class="fa fa-plus-circle"></i> Pengajuan Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" id="add_pengajuan" role="form" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="tgl_pengajuan">Tanggal : </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" name="tgl_pengajuan" value="<?=date('Y-m-d')?>" class="form-control pull-right" id="tgl_pengajuan" required>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Pilih Proyek</label>
                            <select class="form-control" id="id_proyek" name="id_proyek" required>
                                <option value="0">-pilih-</option>
                                <?php foreach($rab as $row):?>
                                <option value="<?php echo $row->id_proyek;?>"><?php echo $row->nama_proyek;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Pilih Tipe</label>
                            <select class="form-control" id="id_tipe" name="id_tipe" required>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Total Kavling</label>
                            <select class="form-control" id="kavling" disabled multiple="multiple" name="kavling" required>
                            </select>
                        </div>

                        <!-- <div class="form-group col-sm-12">
                            <label>Pilih Kavling</label>
                            <select class="form-control" id="id_kavling" name="id_kavling" required>
                            </select>
                        </div> -->

                        <div class="form-group col-sm-3">
                            <label>Pilih Jenis Material</label>
                            <select class="form-control jenis" id="kategori_id" name="kategori_id" required>
                            <option value="">-pilih-</option>
                            </select>
                            <input type="hidden" id="total" name="total">
                            <input type="hidden" id="id_proyek_material" name="id_proyek_material">
                        </div>

                        <div class="form-group col-sm-3">
                            <label>Pilih Material</label>
                            <select class="form-control material" id="material" name="material" required>
                            <option value="">-pilih-</option>
                            </select>
                            <input type="hidden" id="id" name="id">       
                        </div>

                       

                        <div class="form-group col-sm-3">
                            <label for="quntity">Jumlah Pengajuan : </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-cubes"></i>
                                    </span>
                                </div>
                                <input type="number" name="jumlah" class="form-control" id="jumlah" required>
                                    
                                <input type="hidden" name="max_out" id="max_out">

                            </div>
                            <small class="text-danger" id="showMaxPengajuan"></small>
                        </div>

                        <div class="form-group col-sm-2">
                            <label>Satuan</label>
                            <input type="text" name="satuan" id="satuan" disabled class="form-control">
                        </div>
                        <div class="form-group col-sm-1">
                            <label>Add Item</label>
                            <button class="btn btn-sm btn-success" id="toAddItem" type="button"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>


                    <div class="list-item">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>#</th>
                                    <th>Nama Material</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Sumber Material</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody id="loadList">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                </form>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="addfrom">Tambah material dari gudang</button>
                    <button type="button" class="btn btn-primary" id="save" name="save"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
    
<!-- Modal -->
<div class="modal fade" id="addFromOther" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-light">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Material Dari Gudang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>Filter by Proyek</label>
            <select name="filter" id="filter" class="form-control">
                <option value="">--pilih--</option>
                <?php foreach($proyek as $p){ ?>
                    <option value="<?= $p->proyek_id ?>"><?= $p->nama_proyek ?></option>
                <?php } ?>
            </select>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-secondary text-light">
                    <th>Nama Proyek</th>
                    <th>Nama Material</th>
                    <th>Stok</th>
                    <th><i class="fa fa-cogs"></i></th>
                </tr>
            </thead>
            <tbody id="bodyAddFrom">
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>


        <div class="modal fade" id="approve-item">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-info">
                        <h4 class="modal-title">Approve Pengajuan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <p>Apakah Anda Yakin Ingin Mengapprove Data?</p>
                    <input type="hidden" name="id" id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info float-right" id="approve_save"><i class="fa fa-save"></i> Approve</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tolak-item">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-warning">
                        <h4 class="modal-title"> Tolak Pengajuan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <p>Apakah Anda Yakin Ingin Menolak Pengajuan?</p>
                    <input type="hidden" name="id" id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-warning float-right" id="tolak_save"><i class="fa fa-save"></i> Tolak</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit-item">

            <div class="modal-dialog modal-sm" >
                <div class="modal-content">
                    <div class="modal-header bg-gradient-success">
                        <h5 class="modal-title"><i class="fa fa-edit"></i> Edit Pengajuan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="tgl_pengajuan">Tanggal : </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="tgl_pengajuan_e" class="form-control pull-right" id="tgl_pengajuan_e" required>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Pilih Proyek</label>
                                <select class="form-control" id="id_proyek_e" name="id_proyek_e" required>
                                    <option value="0">-pilih-</option>
                                    <?php foreach($rab as $row):?>
                                    <option value="<?php echo $row->id_proyek;?>"><?php echo $row->nama_proyek;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>

                            <div class="form-group col-sm-12">
                                <label>Pilih Jenis Material</label>
                                <select class="form-control jenis_e" id="kategori_id_e" name="kategori_id_e" required>
                                <option value="">-pilih-</option>
                                </select>

                                <input type="hidden" id="id_proyek_material_e" name="id_proyek_material_e">
                            </div>

                            <div class="form-group col-sm-12">
                                <label>Pilih Material</label>
                                <select class="form-control material_e" id="material_e" name="material_e" required>
                                <option value="">-pilih-</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="edit_produk_save" name="edit_produk_save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>

  

        <div class="modal fade" id="delete-item">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-danger">
                        <h4 class="modal-title">Delete Pengajuan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <p>Apakah Anda Yakin Ingin Menghapus Data?</p>
                    <input type="hidden" name="delete_id" id="delete_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger float-right" id="del_data"><i class="fa fa-times"></i> Delete</button>
                    </div>
                </div>
            </div>
        </div>
 


        <!-- Modal -->


<div class="modal fade" id="detailPengajuan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Detail Pengajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body loadDetailPengajuan">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="jmlFromGudang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Jumlah Pengajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('logistik/addFromGudang'); ?>" id="formFromGudang" method="post">
      <div class="modal-body">
        <input type="hidden" name="stok_id" id="stok_id">
        <input type="hidden" name="proyek_id" id="proyek_id">
        <input type="hidden" name="kategori_show" id="kategori_show">
        <input type="hidden" name="satuan_show" id="satuan_show">
        <input type="hidden" name="material_show" id="material_show">
        <input type="hidden" name="max_material" id="max_material">


        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Jumlah Pengajuan" aria-label="Recipient's username" aria-describedby="basic-addon2" name="qty" id="qty">
            <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2"></span>
            </div>
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