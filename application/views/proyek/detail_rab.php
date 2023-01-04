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


$group = $this->session->userdata('group_id');
if($group == 1){
    $show = '';
} else if($group == 2){
    $show = 'd-none';
} else if($group == 6){
    $show = '';
} else {
    $show = 'd-none';
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
                            <div class="col-sm-11">
                                <h3 class="card-title">Detail RAB</h3>
                            </div>
                            <div class="col-sm-1">
                                <a href="<?=site_url('proyek/rab/')?>" class="btn btn-warning btn-sm"><i class="fa fa-undo-alt"></i> kembali</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Material</a>
                                <a class="nav-link" id="nav-upah-tab" data-toggle="tab" href="#nav-upah" role="tab" aria-controls="nav-upah" aria-selected="false">Upah Kerja</a>
                                <a class="nav-link" id="nav-lainnya-tab" data-toggle="tab" href="#nav-lainnya" role="tab" aria-controls="nav-lainnya" aria-selected="false">Lainnya</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active mt-3" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="form-group col-sm-5">
                                    <?php
                                        if($rab->rab == 1 || $rab->rab == 2){
                                            if($group == 1){
                                                echo'
                                                <div class="btn-group '.$show.'">
                                                    <button class="btn btn-primary btn-sm" data-target="#add-rab-material" data-toggle="modal"><i class="fa fa-plus"></i> Tambah RAB Material</button>
                                                </div>
                                            ';
                                            } else {
                                                echo '
                                                    <div class="btn-group '.$show.'">
                                                        <button class="btn btn-primary btn-sm" disabled><i class="fa fa-plus"></i> Tambah RAB Material</button>
                                                    </div>
                                                ';
                                            }
                                            }else{
                                                
                                                echo'
                                            <div class="btn-group '.$show.'">
                                                <button class="btn btn-primary btn-sm" data-target="#add-rab-material" data-toggle="modal"><i class="fa fa-plus"></i> Tambah RAB Material</button>
                                            </div>
                                        ';
                                        
                                            }
                                    ?>

                                </div>
                                <div class="form-group col-sm-12 table-responsive">
                                    <table class="table table-bordered table-striped text-nowrap" id="tabel_material">
                                        <thead>
                                            <tr class="bg-gradient-gray-dark">
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Tipe</th>
                                                <th class="text-center">Blok</th>
                                                <th class="text-center">Nama Material</th>
                                                <th class="text-center">Banyaknya</th>
                                                <th class="text-center">Harga Satuan</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">
                                                    <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $i =1; foreach($detail_rab as $dr){ ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td>
                                                    <?= $this->db->get_where('tbl_tipe',['id_tipe' => $dr->tipe_id])->row()->tipe; ?>
                                                </td>
                                                <td>
                                                    
                                                <?php
                                                    $perum = $this->session->userdata('id_perumahan');
                                                    $proyek = $this->uri->segment(3);
                                                    $tipe = $dr->tipe_id;
                                                    $query = "SELECT * FROM 
                                                        master_proyek,
                                                        master_proyek_kavling,
                                                        tbl_kavling
                                                        WHERE
                                                        master_proyek.id = master_proyek_kavling.proyek_id AND
                                                        master_proyek_kavling.kavling_id = tbl_kavling.id_kavling AND
                                                        tbl_kavling.id_tipe = $tipe AND
                                                        tbl_kavling.id_perum = $perum AND
                                                        master_proyek.id = $proyek
                                                    ";
                                                    $kavling = $this->db->query($query)->result();

                                                    foreach($kavling as $k){
                                                    
                                                ?>
                                                <ul>
                                                    <li><?= $k->blok . $k->no_rumah; ?></li>
                                                </ul>
                                                <?php } ?>

                                                </td>
                                                <td>
                                                    <?php
                                                        $material = $this->db->get_where('master_material',['id' => $dr->material_id])->row();
                                                        echo "<b>".$material->nama_material."</b> </br>";
                                                        $kategori_id = $material->kategori_id;
                                                        $kategori = $this->db->get_where('master_produk_kategori',['id' => $kategori_id])->row();
                                                        echo "<span class='text-danger'>".$kategori->kategori_produk."</span>";
                                                        $satuan_id = $material->unit_id;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    
                                                    $qty = $dr->quantity; 
                                                    $satuan = $this->db->get_where('master_produk_unit',['id' => $satuan_id])->row();
                                                    

                                                    echo "<b>".$qty ." ".$satuan->nama_satuan."</b>"
                                                    
                                                    ?>
                                                </td>
                                                <td>
                                                    Rp. <?= number_format($dr->harga); ?>
                                                </td>
                                                <td>
                                                    Rp. <?= number_format($dr->total); ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $id_pro = $this->uri->segment(3);
                                                        $proyek = $this->db->get_where('master_proyek',['id' => $id_pro])->row();
                                                    ?>

                                                    <?php if($proyek->rab == 1){ ?>
                                                        <?php if($group == 1){ ?>
                                                            <button type="button" id="set_edit" class="btn btn-xs btn-secondary" data-id="<?= $dr->id ?>" data-toggle="modal" data-target="#edit_rab_material">
                                                            <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>

                                                            <button type="button" class="btn btn-xs btn-danger del-RABMaterial" data-id="<?= $dr->id ?>"><i class="fa fa-trash"></i></button>
                                                        <?php } else { ?>
                                                            <button type="button" class="btn btn-xs btn-secondary" disabled>
                                                            <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>
    
                                                            <button type="button" class="btn btn-xs btn-danger" disabled><i class="fa fa-trash"></i></button>
                                                        <?php } ?>
                                                    <?php } else { ?>

                                                        <button type="button" id="set_edit" class="btn btn-xs btn-secondary" data-id="<?= $dr->id ?>" data-toggle="modal" data-target="#edit_rab_material">
                                                        <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>

                                                        <button type="button" class="btn btn-xs btn-danger del-RABMaterial" data-id="<?= $dr->id ?>"><i class="fa fa-trash"></i></button>

                                                    <?php } ?>

                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>




                                        <?php
                                            $jumlahTotal = 0;
                                            
                                        foreach ($detail as $key => $row) {
                                            $jumlahTotal += $row->total;
                                        }
                                        ?>
                                            <tfoot>
                                                <tr class="bg-gradient-gray-dark">
                                                    <th colspan="6" class="text-right">Jumlah Total :</th>
                                                    <!-- <th class="text-right">Rp. <?=rupiah2($jumlahTotal)?></th> -->
                                                    <th class="text-right">
                                                        Rp. 
                                                        <?php 
                                                                $id_pro = $this->uri->segment(3);
                                                            $q = "SELECT SUM(total) as total1 FROM tbl_proyek_material WHERE proyek_id = $id_pro";
                                                            $total = $this->db->query($q)->row()->total1;
                                                            echo number_format($total);
                                                        ?>
                                                    </th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- <div class="tab-pane fade show active mt-3" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"> -->
                            <div class="tab-pane fade mb-3" id="nav-upah" role="tabpanel" aria-labelledby="nav-upah-tab">
                                <br>
                                <div class="form-group col-sm-5">
                                    <?php
                                        if($rab->rab == 1 || $rab->rab == 2){
                                            if($group == 1){
                                                echo '
                                                <div class="btn-group  '.$show.'">
                                                    <button class="btn btn-primary btn-sm" data-target="#add-upah" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Upah</button>
                                                </div>
                                            ';
                                            } else {
                                                echo '
                                                    <div class="btn-group  '.$show.'">
                                                        <button class="btn btn-primary btn-sm" disabled><i class="fa fa-plus"></i> Tambah Upah</button>
                                                    </div>
                                                ';
                                            }
                                        }else{
                                            echo '
                                                <div class="btn-group  '.$show.'">
                                                    <button class="btn btn-primary btn-sm" data-target="#add-upah" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Upah</button>
                                                </div>
                                            ';
                                        }
                                    ?>

                                </div>    
                                <div class="form-group col-sm-12 table-responsive">
                                    <table class="table table-bordered table-striped text-nowrap" id="list_upah">
                                        <thead>
                                            <tr class="bg-dark text-light">
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Tipe</th>
                                                <th class="text-center">Blok</th>
                                                <th class="text-center">Harga Kontrak Per Blok</th>
                                                <th class="text-center">Total Kontrak</th>
                                                <th class="text-center">Keterangan</th>
                                                <th class="text-center"><i class="fa fa-cogs"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 1; 
                                        foreach ($upah as $key => $up){
                                        ?>
                                            <!-- <tr>
                                                <td colspan="6" class="text-uppercase text-bold">
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td class="text-center"><?= $i++; ?></td>
                                                <td>
                                                <span class="text-bold"><?= $up->tipe?></span><br>
                                                <!-- <span class="small text-success">Cluster: <?= $up->nama_cluster ?></span><br> -->
                                                </td>
                                                <!-- <td><?= $up->blok ?></td> -->
                                                <td>

                                                   
                                                <?php
                                                    $perum = $this->session->userdata('id_perumahan');
                                                    $proyek = $this->uri->segment(3);
                                                    $tipe = $up->id_tipe;
                                                    $query = "SELECT * FROM 
                                                        master_proyek,
                                                        master_proyek_kavling,
                                                        tbl_kavling
                                                        WHERE
                                                        master_proyek.id = master_proyek_kavling.proyek_id AND
                                                        master_proyek_kavling.kavling_id = tbl_kavling.id_kavling AND
                                                        tbl_kavling.id_tipe = $tipe AND
                                                        tbl_kavling.id_perum = $perum AND
                                                        master_proyek.id = $proyek
                                                    ";
                                                   
                                                    $kavling = $this->db->query($query)->result();
                                                    $jml_kavling = $this->db->query($query)->num_rows();
                                                   
                                                    foreach($kavling as $k){
                                                    
                                                ?>
                                                <ul>
                                                    <li><?= $k->blok . $k->no_rumah; ?></li>
                                                </ul>
                                                <?php } ?> 
                                                    

                                                </td>
                                                <td class="text-right">Rp. <?= rupiah2($up->harga_kontrak) ?></td>
                                                <td class="text-right">
                                                    <?php $total = $jml_kavling * $up->harga_kontrak;
                                                        echo "Rp. " . rupiah2($total);
                                                    ?>
                                                </td>
                                                <td><?= $up->ket ?></td>
                                                <td class="text-center">
                                                <?php if($up->rab == 1){ ?>
                                                    <?php if($group == 1){ ?>
                                                        <button type="button" id="set_edit_upah" class="btn btn-xs btn-secondary" data-id="<?= $up->id_upah ?>" data-toggle="modal" data-target="#edit-upah">
                                                        <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>
                                                        
                                                        <button type="button" class="btn btn-xs btn-danger del-RABUpah" data-id="<?= $up->id_upah ?>"><i class="fa fa-trash"></i></button>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn btn-xs btn-secondary" disabled>
                                                        <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>
                                                        <button type="button" class="btn btn-xs btn-danger" disabled><i class="fa fa-trash"></i></button>
                                                    <?php } ?>
                                                    <?php }else{?>
                                                        <button type="button" id="set_edit_upah" class="btn btn-xs btn-secondary" data-id="<?= $up->id_upah ?>" data-toggle="modal" data-target="#edit-upah">
                                                        <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>
                                                        <button type="button" class="btn btn-xs btn-danger del-RABUpah" data-id="<?= $up->id_upah ?>"><i class="fa fa-trash"></i></button>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                        <?php 
                                        }
                                        ?>
                                        </tbody>

                                        <?php
                                            $tot = 0;
                                            
                                        foreach ($upah2 as $u2) {

                                            $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $id_pro AND tbl_kavling.id_tipe = $u2->tipe_id";
                                            $jml_kav = $this->db->query($q)->num_rows();
                                            $total = $jml_kav * $u2->harga_kontrak;
                                            $tot += $total;
                                        }
                                        ?>
                                            <tfoot>
                                                <tr class="bg-gradient-gray-dark">
                                                    <th colspan="5" class="text-right">Jumlah Total :</th>
                                                    <th class="text-right">Rp. <?=rupiah2($tot)?></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade mb-3" id="nav-lainnya" role="tabpanel" aria-labelledby="nav-lainnya-tab">
                            <br>
                                <div class="form-group col-sm-5">
                                    <?php
                                        if($rab->rab  == 1 || $rab->rab == 2){
                                            if($group == 1){
                                                echo '
                                                <div class="btn-group  '.$show.'">
                                                    <button class="btn btn-primary btn-sm" data-target="#add-lainnya" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Lainnya</button>
                                                </div>
                                            ';
                                            } else {
                                                echo '
                                                    <div class="btn-group  '.$show.'">
                                                        <button class="btn btn-primary btn-sm" disabled><i class="fa fa-plus"></i> Tambah Lainnya</button>
                                                    </div>
                                                ';
                                            }
                                        }else{
                                            echo '
                                                <div class="btn-group  '.$show.'">
                                                    <button class="btn btn-primary btn-sm" data-target="#add-lainnya" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Lainnya</button>
                                                </div>
                                            ';
                                        }
                                    ?>

                                </div> 
                                <table class="table table-bordered table-striped text-nowrap" id="list_lainnya">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Tipe</th>
                                            <th class="text-center">Blok</th>
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center"><i class="fa fa-cogs"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1; 
                                        foreach ($lainnya as $key => $lain){
                                        ?>
                                            <!-- <tr>
                                                <td colspan="6" class="text-uppercase text-bold">
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td class="text-center"><?= $i++; ?></td>
                                                <td>
                                                <span class="text-bold"><?= $lain->tipe?></span><br>
                                                <!-- <span class="small text-success">Cluster: <?= $lain->nama_cluster ?></span><br> -->
                                                </td>
                                                <!-- <td><?= $lain->blok ?></td> -->
                                                <td>

                                                <?php
                                                    $perum = $this->session->userdata('id_perumahan');
                                                    $proyek = $this->uri->segment(3);
                                                    $tipe = $lain->tipe_id;
                                                    $query = "SELECT * FROM 
                                                        master_proyek,
                                                        master_proyek_kavling,
                                                        tbl_kavling
                                                        WHERE
                                                        master_proyek.id = master_proyek_kavling.proyek_id AND
                                                        master_proyek_kavling.kavling_id = tbl_kavling.id_kavling AND
                                                        tbl_kavling.id_tipe = $tipe AND
                                                        tbl_kavling.id_perum = $perum AND
                                                        master_proyek.id = $proyek
                                                    ";
                                                    $kavling = $this->db->query($query)->result();
                                                    $jml_kav = $this->db->query($query)->num_rows();
                                                    foreach($kavling as $k){
                                                    
                                                ?>
                                                <ul>
                                                    <li><?= $k->blok . $k->no_rumah; ?></li>
                                                </ul>
                                                <?php } ?>

                                                </td>
                                                <td><?= $lain->keterangan ?></td>
                                                <td class="text-right">Rp. <?= rupiah2($lain->harga_lainnya) ?></td>
                                                <td class="text-right">Rp. <?= rupiah2($lain->harga_lainnya * $jml_kav) ?></td>
                                                <td class="text-center">
                                                    <?php if($lain->rab == 1){ ?>
                                                        <?php if($group == 1){ ?>
                                                            <button type="button" id="set_edit_lainnya" class="btn btn-xs btn-secondary" data-id="<?= $lain->id_lainnya ?>" data-toggle="modal" data-target="#edit-lainnya">
                                                            <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>
                                                            <button type="button" class="btn btn-xs btn-danger del-RABLainnya" data-id="<?= $lain->id_lainnya ?>"><i class="fa fa-trash"></i></button>
                                                        <?php } else { ?>
                                                            <button type="button" class="btn btn-xs btn-secondary" disabled>
                                                            <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>
                                                            <button type="button" class="btn btn-xs btn-danger" disabled><i class="fa fa-trash"></i></button>
                                                        <?php } ?>
                                                    <?php }else{?>
                                                        <button type="button" id="set_edit_lainnya" class="btn btn-xs btn-secondary" data-id="<?= $lain->id_lainnya ?>" data-toggle="modal" data-target="#edit-lainnya">
                                                        <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>
                                                        <button type="button" class="btn btn-xs btn-danger del-RABLainnya" data-id="<?= $lain->id_lainnya ?>"><i class="fa fa-trash"></i></button>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                        <?php 
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                            $jml = 0;
                                            
                                        foreach ($lainnya as $la2) {
                                            $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $id_pro AND tbl_kavling.id_tipe = $la2->tipe_id";
                                            $jml_kav = $this->db->query($q)->num_rows();
                                            $total = $la2->harga_lainnya * $jml_kav;
                                            $jml += $total;
                                        }
                                        ?>
                                            <tfoot>
                                                <tr class="bg-gradient-gray-dark">
                                                    <th colspan="5" class="text-right">Jumlah Total :</th>
                                                    <th class="text-right">Rp. <?=rupiah2($jml)?></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- <input type="hidden" class="proyek_id" name="proyek_id" value="<?=$rab->id?>"> -->

<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-light" id="staticBackdropLabel">List Material</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="material_list">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


    <div class="modal fade" id="add-rab-material">
        <div class="modal-dialog modal-md">
            <form id="add_rab_material_form" role="form" method="POST">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title"><i class="fa fa-plus-square"></i> Tambah RAB Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" class="proyek_id_mat"  name="proyek_id" value="<?=$rab->id?>" id="proyek_id" class="form-control">
                            <div class="form-group col-sm-12">
                                <label>Pilih Cluster</label>
                                <select class="form-control" id="id_cluster" name="id_cluster"  required>
                                <option value="0">-pilih-</option>
                                <?php foreach($cluster as $row):?>
                                <option value="<?php echo $row->id_cluster;?>"><?php echo $row->nama_cluster;?></option>
                                <?php endforeach;?>


                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Pilih Tipe</label>
                                <select class="form-control" id="id_kavling_mat" name="id_kavling_mat" required>
                                <option value="">-pilih-</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Pilih Kavling</label>
                                    <select name="blok_mat" id="blok_mat" multiple="multiple" class="form-control" disabled>
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Jenis Material</label>
                                <select class="form-control" id="id_kategori" name="id_kategori" required>
                                <option value="">-pilih-</option>
                                <!-- <?php foreach($kategori as $row):?>
                                <option value="<?php echo $row->id;?>"><?php echo $row->kategori_produk;?></option>
                                <?php endforeach;?> -->
                                
                                <?php
                                    $kategori = $this->db->get_where('master_produk_kategori',['action' => 0])->result();
                                    foreach($kategori as $k){
                                ?>
                                <option value="<?php echo $k->id;?>"><?php echo $k->kategori_produk;?></option>
                                <?php } ?>

                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Pilih Material</label>
                                <select class="form-control" id="id_material" name="id_material" required>
                                <option value="">-pilih-</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                            <label>Quantity</label>
                            <input type="number" min="0" value="0" name="add_quantity" id="add_quantity" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                            <label>Satuan</label>
                                <input type="text" name="sat_material" readonly id="sat_material" class="form-control" placeholder="..." required>
                            </div>
                            <div class="form-group col-sm-12">
                            <label for="tgl_pengajuan">Harga Satuan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                    </div>
                                <input type="text" name="add_harga" autocomplete="off" id="add_harga" class="form-control">
                                <input type="text" name="add_hargaA" id="add_hargaA" class="form-control" hidden>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                            <label for="tgl_pengajuan">Total</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                    </div>
                                <input type="text" name="add_total" id="add_total" class="form-control" readonly>
                                <input type="text" name="add_totalA" id="add_totalA" class="form-control" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="add_save" name="add_save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="add-upah">
        <div class="modal-dialog modal-md">
            <form id="add_upah_form" role="form" method="POST">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title"><i class="fa fa-plus-square"></i> Tambah Upah Kerja</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label>Pilih Cluster</label>
                                <select class="form-control" id="id_cluster_upah" name="id_cluster_upah"  required>
                                <option value="0">-pilih-</option>
                                <?php foreach($cluster as $row):?>
                                <option value="<?php echo $row->id_cluster;?>"><?php echo $row->nama_cluster;?></option>
                                <?php endforeach;?>
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                            <label>Pilih Tipe</label>
                            <select class="form-control" id="id_kavling_upah" name="id_kavling_upah" required>
                            </select>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label>Pilih Kavling</label>
                                <select name="blok_upah" id="blok_upah" multiple class="form-control" disabled>
                                </select>
                                <input type="hidden" class="proyek_id_upah"  name="proyek_id" value="<?=$rab->id?>" id="proyek_id" class="form-control">
                            </div>
                            
                            <div class="form-group col-sm-12">
                            <label for="harga_kontak">Harga Kontrak Per Blok</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                    </div>
                                <input type="text" name="harga_kontrak" autocomplete="off" id="harga_kontrak" class="form-control">
                                <input type="text" hidden name="harga_kontrakA" id="harga_kontrakA" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Keterangan</label>
                                <input type="text" name="ket" id="ket" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="add_upah_save" name="add_upah_save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="add-lainnya">
        <div class="modal-dialog modal-md">
            <form id="add_upah_form" role="form" method="POST">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title"><i class="fa fa-plus-square"></i> Tambah Item Lainnya</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label>Pilih Cluster</label>
                                <select class="form-control" id="id_cluster_lain" name="id_cluster_lain"  required>
                                <option value="0">-pilih-</option>
                                <?php foreach($cluster as $row):?>
                                <option value="<?php echo $row->id_cluster;?>"><?php echo $row->nama_cluster;?></option>
                                <?php endforeach;?>
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                            <label>Pilih Tipe</label>
                            <select class="form-control" id="id_kavling_lain" name="id_kavling_lain" required>
                            </select>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label>Pilih Kavling</label>
                                <select name="blok_lain" id="blok_lain" disabled multiple class="form-control">
                                </select>
                                <input type="hidden" class="proyek_id_lain"  name="proyek_id" value="<?=$rab->id?>" id="proyek_id" class="form-control">
                            </div>

                            <div class="form-group col-sm-12">
                                <label>Keterangan</label>
                                <input type="text" name="listrik" autocomplete="off" id="listrik" class="form-control" placeholder="...">
                            </div>
                            
                            <div class="form-group col-sm-12">
                            <label for="harga_kontak">Harga</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                    </div>
                                <input type="text" name="lainnya" autocomplete="off" id="lainnya" class="form-control">
                                <input type="text" hidden name="lainnyaA" id="lainnyaA" class="form-control" >
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="add_lainnya_save" name="add_lainnya_save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        
    <div class="modal fade" id="edit_rab_material" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="edit_rab_materialLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form id="add_rab_material_form" role="form" method="POST">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title"><i class="fa fa-plus-square"></i> Edit Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        <input type="hidden" class="proyek_id_mat_e"  name="proyek_id" value="<?=$rab->id?>" id="proyek_id">
                            <div class="form-group col-sm-12">
                                <label>Pilih Cluster</label>
                                <select class="form-control" id="edit_id_cluster" name="edit_id_cluster"  required>
                                <option value="0">-pilih-</option>
                                <?php foreach($cluster as $row):?>
                                <option value="<?php echo $row->id_cluster;?>"><?php echo $row->nama_cluster;?></option>
                                <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Pilih Tipe</label>
                                <select class="form-control" id="edit_id_kavling_mat" name="edit_id_kavling_mat" required>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Pilih Kavling</label>
                                <!-- <select name="edit_blok_mat" id="edit_blok_mat" class="form-control" multiple="multiple">
                                </select> -->
                                <select name="edit_blok_mat" id="edit_blok_mat" multiple="multiple" class="form-control" disabled>
                                </select>
                            </div>
                            <input type="hidden"  name="edit_id_proyek" id="edit_id_proyek" class="form-control">
                            <input type="hidden"  name="edit_id" id="edit_id" class="form-control">

                            <div class="form-group col-sm-6">
                                <label>Jenis Material</label>
                                <select class="form-control" id="id_kategori_e" name="id_kategori_e" required>
                                <option value="">-pilih-</option>
                                <?php foreach($kategori as $row):?>
                                <option value="<?php echo $row->id;?>"><?php echo $row->kategori_produk;?></option>
                                <?php endforeach;?>
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Pilih Material</label>
                                <select class="form-control" id="id_material_e" name="id_material_e" required>
                                <option value="">-pilih-</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                            <label>Quantity</label>
                            <input type="number" min="0" value="0" name="edit_add_quantity" id="edit_add_quantity" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                            <label>Satuan</label>
                                <input type="text" name="sat_material_e" readonly id="sat_material_e" class="form-control" placeholder="..." required>
                            </div>
                            <div class="form-group col-sm-12">
                            <label for="tgl_pengajuan">Harga Satuan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                    </div>
                                <input type="text" name="edit_add_harga" id="edit_add_harga" class="form-control">
                                <input type="text" name="edit_add_hargaA" id="edit_add_hargaA" class="form-control" hidden>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                            <label for="tgl_pengajuan">Total</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                    </div>
                                <input type="text" name="edit_add_total" id="edit_add_total" class="form-control" readonly>
                                <input type="text" name="edit_add_totalA" id="edit_add_totalA" class="form-control" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="edit_save" name="edit_save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="edit-upah">
        <div class="modal-dialog modal-md">
            <form id="edit_upah_form" role="form" method="POST">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title"><i class="fa fa-plus-square"></i> Edit Upah Kerja</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        <input type="hidden" class="proyek_id_up_e"  name="proyek_id" value="<?=$rab->id?>" id="proyek_id">
                            <div class="form-group col-sm-12">
                                <label>Pilih Cluster</label>
                                <select class="form-control" id="edit_id_cluster_upah" name="edit_id_cluster_upah"  required>
                                <option value="0">-pilih-</option>
                                <?php foreach($cluster as $row):?>
                                <option value="<?php echo $row->id_cluster;?>"><?php echo $row->nama_cluster;?></option>
                                <?php endforeach;?>
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Pilih Tipe</label>
                                <select class="form-control" id="edit_id_kavling_upah" name="edit_id_kavling_upah" required>
                                </select>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label>Pilih Kavling</label>
                                <select name="edit_blok_upah" id="edit_blok_upah" multiple disabled class="form-control">
                                </select>
                                <input type="hidden"  name="edit_proyek_id_upah" value="<?=$rab->id?>" id="edit_proyek_id_upah" class="form-control">
                                <input type="hidden"  name="edit_id_upah" value="<?=$rab->id?>" id="edit_id_upah" class="form-control">
                            </div>
                            
                            <div class="form-group col-sm-12">
                            <label for="harga_kontak">Harga Kontrak Per Blok</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                    </div>
                                <input type="text" name="edit_harga_kontrak" autocomplete="off" id="edit_harga_kontrak" class="form-control">
                                <input type="text" hidden name="edit_harga_kontrakA" id="edit_harga_kontrakA" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Keterangan</label>
                                <input type="text" name="ket_edit_upah" id="ket_edit_upah" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="edit_upah_save" name="edit_upah_save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="edit-lainnya">
        <div class="modal-dialog modal-md">
            <form id="edit_upah_form" role="form" method="POST">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title"><i class="fa fa-plus-square"></i> Edit Item Lainnya</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        <input type="hidden" class="proyek_id_la_e"  name="proyek_id" value="<?=$rab->id?>" id="proyek_id">
                            <div class="form-group col-sm-12">
                                <label>Pilih Cluster</label>
                                <select class="form-control" id="edit_id_cluster_lain" name="edit_id_cluster_lain"  required>
                                <option value="0">-pilih-</option>
                                <?php foreach($cluster as $row):?>
                                <option value="<?php echo $row->id_cluster;?>"><?php echo $row->nama_cluster;?></option>
                                <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Pilih Tipe</label>
                                <select class="form-control" id="edit_id_kavling_lainnya" name="edit_id_kavling_lainnya" required>
                                </select>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label>Pilih Kavling</label>
                                <select name="edit_blok_lainnya" id="edit_blok_lainnya" multiple disabled class="form-control">
                                </select>
                                <input type="hidden"  name="edit_proyek_id_lainnya" value="<?=$rab->id?>" id="edit_proyek_id_lainnya" class="form-control">
                                <input type="hidden"  name="edit_id_lainnya" id="edit_id_lainnya" class="form-control">
                            </div>

                            <div class="form-group col-sm-12">
                                <label>Keterangan</label>
                                <input type="text" name="edit_listrik" autocomplete="off" id="edit_listrik" class="form-control" placeholder="...">
                            </div>

                            <div class="form-group col-sm-12">
                            <label for="harga_kontak">Harga</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                    </div>
                                <input type="text" name="edit_lainnya" autocomplete="off" id="edit_lainnya" class="form-control">
                                <input type="text" hidden name="edit_lainnyaA" id="edit_lainnyaA" class="form-control" >
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="edit_lainnya_save" name="edit_lainnya_save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

