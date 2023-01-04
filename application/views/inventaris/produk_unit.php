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
        <h1>Unit Produk</h1>
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
                        <a href="<?=site_url('inventaris/daftar_barang/')?>" class="btn btn-warning btn-sm"><i class="fa fa-undo-alt"></i> kembali</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <table class="table table-condensed table-striped" id="list_unit">
                                    <thead>
                                        <tr>
                                            <th>Nama Unit</th>
                                            <th class="text-center" width="20%">
                                                <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($unit as $key => $row) {
                                                ?>
                                                    <tr>
                                                        <td><?=$row->nama_satuan?></td>
                                                        <td class="text-center">
                                                            <button class="btn btn-primary btn-sm" id="edit_unit" data-target="#edit-unit" data-toggle="modal" 
                                                                data-id_unit="<?=$row->id?>" 
                                                                data-nama_unit="<?=$row->nama_satuan?>" 
                                                            <?=$statusU?>><i class="fa fa-pencil-alt"></i></button>

                                                            <button class="btn btn-danger btn-sm" id="delete_unit" 
                                                                data-id_unit="<?=$row->id?>" 
                                                            <?=$statusD?>><i class="fa fa-times"></i></button>

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


<?php
    if(HakAkses(7)->update == 1){
        ?>
            <div class="modal fade" id="edit-unit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary">
                            <h4 class="modal-title text-uppercase"><i class="fa fa-plus-square"></i> Edit Unit</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <input type="text" name="nama_unit" id="nama_unit" class="form-control" autofocus>
                                    <input type="hidden" id="id_unit">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="unit_save" name="unit_save"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>


