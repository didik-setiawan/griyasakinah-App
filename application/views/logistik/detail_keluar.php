<?php
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
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-uppercase">Material Keluar</h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header" data-card-widget="collapse">
                        <h3 class="card-title">Detail RAB</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="">Nama Proyek :</label>
                                <input type="text" class="form-control" readonly value="<?=$rab->nama_proyek?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="">Waktu/Tanggal :</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" readonly value="<?= date('d F Y', strtotime($rab->tgl_pengajuan))?>">
                                </div>
                            </div>
                            <!-- <table class="table table-bordered">
                                <thead>
                                    <tr class="text-light bg-dark">
                                        <th class="text-center">Cluster</th>
                                        <th class="text-center">Tipe</th>
                                        <th class="text-center">Blok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1; 
                                    foreach ($kavling as $key => $as){
                                    ?>
                                        <tr>
                                        <td><span class="text-bold"><?= $as->nama_cluster?></span></td>
                                            <td>
                                            <span class="text-bold"><?= $as->tipe?></span><br>
                                            </td>
                                            <td>
                                                <?php 
                                                foreach ($tipe as $key => $oi){ 
                                                    if($as->tipe == $oi->tipe){
                                                ?>
                                                <?= $oi->blok ?><br>
                                                <?php
                                                        }else{
                                                            $oi->blok;
                                                        } 
                                                    }
                                                ?>
                                            </td>

                                        </tr>
                                    <?php 
                                    }
                                    ?>
                                </tbody>
                            </table> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="detail_rab">
                <div class="card card-info">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-11">
                                <h3 class="card-title">Daftar RAB Material</h3>
                            </div>
                            <div class="col-sm-1">
                                <a href="<?=site_url('logistik/material_keluar/')?>" class="btn btn-warning btn-sm"><i class="fa fa-undo-alt"></i> kembali</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-12 table-responsive">
                                <table class="table table-bordered table-striped" id="tabel_material">
                                    <thead>
                                        <tr class="text-light bg-dark">
                                            <th class="text-center">Tipe</th>
                                            <th class="text-center">Material</th>
                                            <!-- <th class="text-center">Quantity</th> -->
                                            <!-- <th class="text-center">Harga Satuan</th> -->
                                            <th class="text-center">Stok</th>
                                            <th class="text-center">Material Keluar</th>
                                            <th class="text-center">
                                                <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1; 
                                    foreach ($detail as $key => $row){
                                        if($row->material_keluar == 0){
                                            $warna = 'danger';
                                            $keluar = "Kosong";
                                        }else{
                                            $warna = 'success';
                                            $keluar = $row->material_keluar." <span class='text-bold'>".$row->nama_satuan."</span>";
                                        }

                                        if($row->stok == 0){
                                            $color = 'danger';
                                            $stok = "Kosong";
                                        }else{
                                            $color = 'success';
                                            $stok = $row->stok." <span class='text-bold'>".$row->nama_satuan."</span>";
                                        }
                                    ?>
                                        <tr>
                                            <td>
                                            <span class="text-bold"><?= $row->tipe ?></span>
                                            </td>
                                            <td>
                                            <span class="text-bold"><?= $row->nama_material?></span><br>
                                            <span class="small text-danger"><?= $row->kategori_produk ?></span><br>
                                            </td>
                                            <td class="text-center"><span class="badge badge-<?=$color?> text-uppercase"><?=$stok?></span></td>
                                            <td class="text-center"><span class="badge badge-<?=$warna?> text-uppercase"><?=$keluar?> </span></td>
                                           
                                            <td>
                                                <?php if($row->stok != 0) {?>
                                            <button class="btn btn-primary btn-sm <?= $act ?>" data-toggle="modal" id="set_edit" data-id="<?= $row->id_logistik ?>" data-target="#add-rab-material">
                                                <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="top"></i> Keluarkan
                                            </button>
                                                <?php }else{?>
                                            <button class="btn btn-primary btn-sm <?= $act ?>" disabled>
                                                <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="top"></i> Keluarkan
                                            </button>
                                                <?php }?>
                                            </td>
                                        </tr>
                                    <?php 
                                    }
                                    ?>
                                    </tbody>

                                    <?php
                                        $jumlahTotal = 0;
                                        
                                    foreach ($detail as $key => $row) {
                                        $jumlahTotal += $row->harga_mat;
                                    }
                                    ?>
                                        <!-- <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-right">Jumlah Total :</th>
                                                <th class="text-right">Rp. <?=rupiah2($jumlahTotal)?></th>
                                                <th class="text-center">
                                                <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                            </th>
                                            </tr>
                                        </tfoot> -->
                                </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->


<div class="modal fade" id="add-rab-material" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="add-rab-materialLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form role="form" method="POST">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title"><i class="fa fa-plus-square"></i> Keluarkan Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group col-sm-12">
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

                            <div class="form-group col-sm-12">
                            <label>Quantity</label>
                            <input type="hidden" name="id_proyek" id="id_proyek">
                            <input type="hidden" name="id_logistik" id="id_logistik">
                            <input type="hidden" name="id_max" id="id_max">
                            <input type="hidden" name="id_tipe" id="id_tipe">
                            <input type="hidden" name="id_keluar" id="id_keluar">
                            <input type="hidden" name="id_stok" id="id_stok">
                            <input type="number" min="1" name="add_quantity" id="add_quantity" class="form-control">
                            <span class="small text-danger">Input Quantity Tidak Boleh Melebihi Max Material!</span>
                            </div> 
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group col-sm-12">
                            <label>Tipe</label>
                            <input type="text" readonly name="tipe" id="tipe" class="form-control">
                            </div>
                            <div class="form-group col-sm-12">
                            <label>Kavling1</label>
                                <!-- <select class="form-control" id="kavling" disabled multiple="multiple" name="kavling" required> -->
                                <select name="kavling" id="kavling" class="form-control">
                                    <option value="">--Pilih--</option>
                                </select>
                            </select>
                            </div>
                            <div class="form-group col-sm-12">
                            <label>Nama Material</label>
                            <input type="text" readonly name="nama_material" id="nama_material" class="form-control">
                            </div>

                            <!-- <div class="form-group col-sm-12">
                            <label>Stok</label>
                            <input type="number" name="stok" id="stok" readonly class="form-control">
                            </div> -->
                            
                            <div class="form-group col-sm-12">
                            <label>Max Material</label>
                            <input type="number" readonly name="max" id="max" class="form-control">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="add_save" name="add_save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>