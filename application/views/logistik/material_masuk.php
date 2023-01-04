<?php
if(HakAkses(7)->create == 1){
    $statusC = NULL;
}else{
    $statusC = 'disabled';
}
if(HakAkses(7)->update == 1){
    $statusU = NULL;
}else{
    $statusU = 'disabled';
}
if(HakAkses(7)->delete == 1){
    $statusD = NULL;
}else{
    $statusD = 'disabled';
}

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
                                <h3 class="card-title">Material Masuk</h3>
                            </div>
                            <div class="col-sm-6">
                                <h3 class="card-title float-right text-yellow">Periode : <span class="text-bold" id="periode_laporan"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body style="display: block;">
                        <div class="row">
                            <div class="form-group col-sm-9">
                            <?php if($this->session->flashdata('true',300)){ ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong><?= $this->session->flashdata('true',300); ?></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } else if($this->session->flashdata('false',300)){ ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong><?= $this->session->flashdata('false',300); ?></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } ?>
                            </div>
     
                            <div class="form-group col-sm-3">
                                
                            </div>
                            <div class="form-group col-sm-4">
                            </div>

                            <div class="col-sm-12 table-responsive">
                                <table class="table table-bordered table-striped table-hover text-nowrap " id="tableMasuk">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>No.</th>
                                            <th class="text-center">Tgl Pengajuan</th>
                                            <th class="text-center">Nama Proyek</th>
                                            <th class="text-center">Material</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Harga Total</th>
                                            <th class="text-center">Status Pengajuan</th>
                                           
                                            <th class="text-center">
                                                <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($data as $d){ 
                                            $id_pengajuan = $d->id_pengajuan;
                                            $doc = $this->db->get_where('master_logistik_masuk',['logistik_id' => $d->id_logistik])->row();

                                            $count = $this->logistik->CountSisaPembayaran($id_pengajuan)->result();
                                            $total = 0;
                                            foreach($count as $c){
                                                if($c->type == 1){
                                                    $total += $c->jml_pengajuan * $c->harga_real;
                                                }
                                            }
                                            $cicil = $this->db->get_where('cicil_material',['id_pengajuan' => $id_pengajuan])->result();
                                            $terbayar = 0;
                                            foreach($cicil as $ci){
                                                if($ci->status == 2){
                                                    $terbayar += $ci->jml_pengajuan;
                                                }
                                            }

                                            $sisa = $total - $terbayar;
                                            if($sisa == 0){
                                                $lunas = 'Lunas';
                                            } else {
                                                $lunas = 'Belum Lunas';
                                            }

                                        ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?php $date = date_create($d->tgl_pengajuan); echo date_format($date, 'd F Y') ?></td>
                                                <td><?= $d->nama_proyek ?></td>
                                                <td><b><?= $d->nama_material ?></b> <br> <small class="text-success"><?= $d->kategori_produk ?></small></td>
                                                <td><?= $d->jml_pengajuan .' '. $d->nama_satuan ?></td>
                                                <td><b>Rp. <?= number_format($d->harga_real * $d->jml_pengajuan); ?></b> <br> <small class="text-primary"> (Rp. <?= number_format($d->harga_real) ?> / item)</small>
                                                    
                                                </td>
                                                <td>
                                                <?php
                                                   if($d->status_pengajuan == 4){
                                                        $show = 'Approved';
                                                        $color = 'info';
                                                    } else if($d->status_pengajuan == 5){
                                                        $show = 'Approved super admin';
                                                        $color = 'primary';
                                                    } 
                                                    echo '<span class="badge badge-pill badge-'.$color.'">'.$show.'</span>'
                                                ?>
                                                <br>
                                                <span class="badge badge-secondary"><?= $lunas ?></span>
                                                </td>
                                                <td>
                                                    <?php if(empty($doc)){ ?>
                                                    <button class="btn btn-xs btn-success add-image"
                                                    data-id="<?= $d->id_logistik; ?>"
                                                    data-proyek="<?= $d->proyek_material_id ?>"
                                                    data-qty="<?= $d->jml_pengajuan ?>"
                                                    ><i class="fa fa-plus"></i></button>
                                                    <?php } else { ?>
                                                    <button class="btn btn-xs btn-dark details" data-id="<?= $d->id_logistik; ?>"><i class="fa fa-search"></i></button>
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

<div class="modal fade" id="detail_material" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="detail_materialLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title text-light" id="detail_materialLabel">Detail Material Masuk</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detail_tabel">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="approve-item" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="approve-itemLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h5 class="modal-title" id="approve-itemLabel">Material Masuk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('logistik/add_material_masuk/'); ?>" enctype="multipart/form-data" method="post">
      <div class="modal-body">

        <input type="hidden" name="id" id="id">
        <input type="hidden" name="proyek_material_id" id="proyek_material_id">
        <input type="hidden" name="quantity" id="quantity">

            <div class="form-group col-sm-12">
                <label for="tgl_masuk">Tanggal </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" name="tgl_masuk" value="<?=date('Y-m-d')?>" class="form-control pull-right" id="tgl_masuk" required>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label>Dokumentasi</label>
                <input type="file" name="foto" id="foto" class="form-control">
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