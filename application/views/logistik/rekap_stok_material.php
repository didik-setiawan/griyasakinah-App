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
                            <label>Filter by Proyek</label>
                            <select name="proyek" id="proyek" class="form-control">
                                <option value="">--All--</option>
                                <?php foreach($proyek as $p){ ?>
                                    <option value="<?= $p->id ?>"><?= $p->nama_proyek ?></option>
                                    <?php if($_GET['proyek'] == $p->id){ ?>
                                        <option value="<?= $p->id ?>" selected><?= $p->nama_proyek ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
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
                                        
                                        $q_masuk = "SELECT SUM(material_masuk) AS masuk FROM master_logistik_masuk JOIN master_logistik ON master_logistik_masuk.logistik_id = master_logistik.id WHERE master_logistik.material_id = $row->material_id";

                                        $q_keluar = "SELECT SUM(jml_keluar) AS keluar FROM material_keluar JOIN master_logistik ON material_keluar.id_logistik = master_logistik.id WHERE master_logistik.material_id = $row->material_id";

                                        $q_stok = "SELECT SUM(stok) AS stock FROM logistik_stok JOIN master_logistik ON logistik_stok.logistik_id = master_logistik.id WHERE master_logistik.material_id = $row->material_id";
                                        

                                        $masuk = $this->db->query($q_masuk)->row()->masuk;
                                        $keluar = $this->db->query($q_keluar)->row()->keluar;
                                        $stok = $this->db->query($q_stok)->row()->stock;

                                        if($masuk > 0){
                                            $s_masuk = '<span class="badge badge-primary">'.$masuk.' '.$row->nama_satuan.'</span>'; 
                                        } else {
                                            $s_masuk = '<span class="badge badge-danger">Kosong</span>';
                                        }

                                        if($keluar > 0){
                                            $s_keluar = '<span class="badge badge-primary">'.$keluar.' '.$row->nama_satuan.'</span>'; 
                                        } else {
                                            $s_keluar = '<span class="badge badge-danger">Kosong</span>';
                                        }

                                        if($stok > 0){
                                            $s_stok = '<span class="badge badge-primary">'.$stok.' '.$row->nama_satuan.'</span>'; 
                                        } else {
                                            $s_stok = '<span class="badge badge-danger">Kosong</span>';
                                        }

                                    ?>
                                        <tr>
                                            <td>
                                            <span class="text-bold"><?= $row->nama_material ?></span><br>
                                            <span class="small text-danger"><?= $row->kategori_produk ?></span><br>
                                            </td>
                                            <td class="text-right"><?= $s_masuk ?></span></td>
                                            <td class="text-right"><?= $s_keluar ?></span></td>
                                            <td class="text-right"><?= $s_stok ?></td>
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