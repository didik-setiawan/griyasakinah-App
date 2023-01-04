<?php
    // 1 = progres, 2, = cancel, 3 = delete, 4 = template, 99 = selesai
    if($rab->status == 1){
        $progress = '<span class="badge badge-primary text-uppercase">on Progress</span>';
        $tombolUpdate = NULL;
    }elseif($rab->status == 2){
        $progress = '<span class="badge badge-secondary text-uppercase">Cancel</span>';
        $tombolUpdate = 'disabled';
    }elseif($rab->status == 3){
        $progress = '<span class="badge badge-danger text-uppercase">Delete</span>';
        $tombolUpdate = 'disabled';
    }elseif($rab->status == 99){
        $progress = '<span class="badge badge-success text-uppercase">Finish</span>';
        $tombolUpdate = 'disabled';
    }else{
        $progress = '<span class="badge badge-success text-uppercase">Tempplates</span>';
        $tombolUpdate = 'disabled';
    }    
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-uppercase">Detail RAB</h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="detail_rab">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Detail RAB</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-12 table-responsive">
                                <table class="table table-bordered table-striped text-nowrap">
                                    <thead>
                                        <tr class="bg-gradient-gray-dark">
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Deskripsi</th>
                                            <th class="text-center">Banyaknya</th>
                                            <th class="text-center">Harga Satuan</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">
                                                <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if($detail->num_rows() > 0){
                                                foreach ($detail->result() as $key => $row) {
                                                    if($row->level == 1){
                                                        ?>
                                                            <tr>
                                                                <td colspan="6" class="text-uppercase text-bold">
                                                                    <?=$row->deskripsi?> &nbsp;
                                                                    <?php


                                                                    ?>
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-secondary btn-xs" data-toggle="modal" id="induk_edit" data-target="#edit-induk" data-induk_id="<?=$row->id?>" data-induk_nama="<?=$row->deskripsi?>" <?=$statusU?>>
                                                                            <i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-danger btn-xs" data-toggle="modal" id="induk_delete" data-target="#delete-induk" data-induk_id="<?=$row->id?>" data-induk_nama="<?=$row->deskripsi?>" <?=$statusD?>>
                                                                            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        $no = 1;
                                                        $subtotal = 0;
                                                        foreach ($detail->result() as $key => $parent) {
                                                            if($parent->parent == $row->id){
                                                                ?>
                                                                    <tr>
                                                                        <td class="text-center"><?=$no++?>.</td>
                                                                        <td><?=$parent->deskripsi?></td>
                                                                        <td class="text-center"><?=$parent->quantity.' '.$parent->satuan?></td>
                                                                        <td class="text-right">Rp. <?=rupiah2($parent->nominal)?></td>
                                                                        <td class="text-right">Rp. <?=rupiah2($parent->total)?></td>
                                                                        <td class="text-center"></td>
                                                                    </tr>
                                                                <?php
                                                                $subtotal += $parent->total;
                                                            }
                                                        }
                                                        ?>
                                                            <tr>
                                                                <td colspan="4" class="text-right text-bold">
                                                                    Sub-Total : &nbsp;
                                                                </td>
                                                                <td class="text-right text-bold">Rp. <?=rupiah2($subtotal)?></td>
                                                                <td></td>
                                                            </tr>
                                                        <?php
                                                    }
                                                }
                                            }else{
                                                ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">
                                                            Data tidak tersedia...
                                                        </td>
                                                    </tr>
                                                <?php
                                            }
                                        ?>

                                    </tbody>
                                    <?php
                                        $jumlahTotal = 0;
                                        if($detail->num_rows() > 0){
                                            foreach ($detail->result() as $key => $value) {
                                                $jumlahTotal += $value->total;
                                                # code...
                                            }
                                            ?>
                                                <tfoot>
                                                    <tr class="bg-gradient-gray-dark">
                                                        <th colspan="4" class="text-right">Jumlah Total :</th>
                                                        <th class="text-right">Rp. <?=rupiah2($jumlahTotal)?></th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            <?php
                                        }
                                    ?>
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