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
            <div class="col-12">
            <!-- Default box -->
                <div class="card">
                    <div class="card-body">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Material Masuk</a>
                                <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Material Keluar</a>
                                <a class="nav-link" id="nav-belanja-tab" data-toggle="tab" href="#nav-belanja" role="tab" aria-controls="nav-belanja" aria-selected="false">Belanja Material</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active mt-3" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row">
                                    <div class="form-group col-sm-9">

                                    </div>
            
                                    <div class="form-group col-sm-3">
                                        <!-- <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control float-right" id="hari_ini">
                                        </div> -->
                                    </div>
                                </div>
                            
                                <div class="col-sm-12 table-responsive">
                                    <table class="table table-bordered " id="table_masuk">
                                        <thead>
                                            <tr class="bg-dark text-light">
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Jumlah Material</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    
                                            <tr>
                                            <?php foreach($masuk as $key){ ?>
                                                <td class="text-center"><span class="text-uppercase"><?= date('d F Y', strtotime($key->created_at))?></span></td>
                                                <td class="text-right"><?= $key->total_masuk ?></td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            }?>
                                             <?php
                                                $jumlahTotal = 0;
                                                
                                            foreach ($masuk as $key => $row) {
                                                $jumlahTotal += $row->total_masuk;
                                            }
                                            ?>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="1" class="text-right">Jumlah Total :</th>
                                                        <th class="text-right"><?=$jumlahTotal?></th>
                                                    </tr>
                                                </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade mb-3" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <br>
                                <div class="col-sm-12 table-responsive">
                                    <table class="table table-bordered " id="table_keluar">
                                        <thead>
                                            <tr class="bg-dark text-light">
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Jumlah Material</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    
                                            <tr>
                                            <?php foreach($keluar as $kel){ ?>
                                                <td class="text-center"><span class="text-uppercase"><?= date('d F Y', strtotime($kel->tgl_keluar))?></span></td>
                                                <td class="text-right"><?= $kel->total_keluar ?></td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            }?>

                                            <?php
                                                $totalKeluar = 0;
                                                
                                            foreach ($keluar as $key => $as) {
                                                $totalKeluar += $as->total_keluar;
                                            }
                                            ?>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="1" class="text-right">Jumlah Total :</th>
                                                        <th class="text-right"><?=$totalKeluar?></th>
                                                    </tr>
                                                </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade mb-3" id="nav-belanja" role="tabpanel" aria-labelledby="nav-belanja-tab">
                                            <br>
                                <div class="col-sm-12 table-responsive">
                                    <table class="table table-bordered " id="table_belanja">
                                        <thead>
                                            <tr class="bg-dark text-light">
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Jumlah Material</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    
                                            <tr>
                                            <?php foreach($belanja as $bel){ ?>
                                                <td class="text-center"><span class="text-uppercase"><?= date('d F Y', strtotime($bel->tgl_belanja))?></span></td>
                                                <td class="text-right"><?= $bel->total_belanja ?></td>
                                            </tr>
                                        </tbody>
                                        <?php
                                            }?>

                                            <?php
                                                $totalBelanja = 0;
                                                
                                            foreach ($belanja as $key => $bela) {
                                                $totalBelanja += $bela->total_belanja;
                                            }
                                            ?>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="1" class="text-right">Jumlah Total :</th>
                                                        <th class="text-right"><?=$totalBelanja?></th>
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
    </div>
</section>




