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
                                <h3 class="card-title">Rekap Stok Material</h3>
                            </div>
                            <div class="col-sm-6">
                                <h3 class="card-title float-right text-yellow">Periode : <span class="text-bold" id="periode_laporan"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body style="display: block;">
                        <div class="row">
                        <div class="form-group col-sm-6">
                        </div>
                            <div class="form-group col-sm-3">
                            <label>Filter Jenis Material</label>
                                <select class="form-control" id="id_kategori" name="id_kategori" required>
                                    <option value="">-pilih-</option>
                                    <?php foreach($kategori as $row):?>
                                    <option value="<?php echo $row->id;?>"><?php echo $row->kategori_produk;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>

                            <div class="form-group col-sm-3">
                                <label>Filter Material</label>
                                <select class="form-control" id="id_material" name="id_material" required>
                                <?php if(isset($_GET['jenis'])){ ?>
                                <option value="">All</option>
                                <?php $mat = $this->db->get_where('master_material',['kategori_id' => $_GET['jenis']])->result();
                                foreach($mat as $c){
                                ?>

                                    <?php if($_GET['material'] == $c->id){ ?>
                                        <option value="<?= $c->id ?>" selected><?= $c->nama_material ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $c->id ?>"><?= $c->nama_material ?></option>
                                    <?php } ?>

                                <?php } ?>

                                <?php } else { ?>
                                    <option value="">All</option>
                            <?php } ?>
                                </select>
                            </div>

                            <div class="col-sm-12 table-responsive">
                                <table class="table table-bordered table-striped table-hover text-nowrap" id="table_list">
                                    <thead>
                                        <tr class="text-light bg-dark">
                                            <th class="text-center">Material</th>
                                            <th class="text-center">Material Masuk</th>
                                            <th class="text-center">Material Keluar</th>
                                            <th class="text-center">Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1; 
                                    foreach ($detail as $key => $row){
                                        $q_masuk_ulang = "SELECT SUM(stok) as st FROM logistik_stok WHERE type = 1 AND stok_id = $row->id_stok";
                                        $q_masuk = "SELECT SUM(material_masuk) as mm FROM master_logistik_masuk WHERE logistik_id = $row->id";
                                        $q_keluar = "SELECT SUM(material_keluar) as mk FROM master_logistik_keluar WHERE logistik_id = $row->id";
                                        $masukUlang = $this->db->query($q_masuk_ulang)->row()->st;
                                        
                                        $Q_keluartype2 = "SELECT SUM(material_keluar) as keluar FROM master_logistik_keluar JOIN master_logistik ON master_logistik_keluar.logistik_id = master_logistik.id WHERE master_logistik.stok_id = $row->id_stok";
                                        $keluartype2 = $this->db->query($Q_keluartype2)->row()->keluar;
                                        


                                        $stok = $masukUlang + $row->stok_logistik;
                                        $masuk = $this->db->query($q_masuk)->row()->mm;
                                        $keluar = $this->db->query($q_keluar)->row()->mk + $keluartype2;

                                        if($stok == 0){
                                            $total_stok = "<span class='badge badge-danger text-uppercase'>Kosong</span>";
                                        }else{
                                            $total_stok = $stok." <span class='text-bold'>".$row->nama_satuan."</span>";
                                        }

                                        if($masuk == 0){
                                            $total_masuk = "<span class='badge badge-danger text-uppercase'>Kosong</span>";
                                        }else{
                                            $total_masuk = $masuk." <span class='text-bold'>".$row->nama_satuan."</span>";
                                        }

                                        if($keluar == 0){
                                            $total_keluar = "<span class='badge badge-danger text-uppercase'>Kosong</span>";
                                        }else{
                                            $total_keluar = $keluar." <span class='text-bold'>".$row->nama_satuan."</span>";
                                        }



                                    ?>
                                        <tr>
                                            <td>
                                            <span class="text-bold"><?= $row->nama_material?></span><br>
                                            <span class="small text-danger"><?= $row->kategori_produk ?></span><br>
                                            </td>
                                            <td class="text-right"><?= $total_masuk ?></span></td>
                                            <td class="text-right"><?= $total_keluar ?></span></td>
                                            <td class="text-right"><?= $total_stok ?></td>
                                        </tr>
                                    <?php 
                                    }
                                    ?>
                                    </tbody>

                                
                                </table>
                            </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>