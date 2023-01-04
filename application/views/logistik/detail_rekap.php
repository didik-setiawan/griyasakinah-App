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
        <div class="col-sm-6">
        <h1>Detail Rekap Material</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-default">
                    <div class="card-header">
                        <!-- <h3 class="card-title">unit List</h3> -->
                        <a href="<?=site_url('logistik/rekap_material/')?>" class="btn btn-warning btn-sm"><i class="fa fa-undo-alt"></i> kembali</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <table class="table table-condensed table-striped" id="list_unit">
                                    <thead>
                                        <tr>
                                            <th>Kavling</th>
                                            <th>Item Material</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($detail as $key => $row) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                        <span class="text-uppercase text-bold">Tipe : <?=$row->tipe?></span> <br>
                                                        <span class="small text-info text-bold">Blok : <?=$row->blok?></b></span><br>
                                                        <span class="small text-danger text-bold">Harga : <?=rupiah($row->harga)?></b></span><br>
                                                        </td>
                                                        <td>
                                                        <span class="text-uppercase text-bold"><?=$row->item_material?></span> <br>
                                                        <span class="small text-info text-bold">Kategori : <?=$row->nama_material?></b></span><br>
                                                        </td>
                                                        <td>
                                                        <span class="text-uppercase text-bold"><?=$row->quantity?> <?= $row->nama_satuan?></b></span><br>
                                                        </td>
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
    </div>
</section>
<!-- /.content -->


