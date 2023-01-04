<?php
    if(HakAkses(5)->create == 1){
        $statusC = NULL;
        $statusC1 = 'data-card-widget="collapse"';
    }else{
        $statusC = 'disabled';
        $statusC1 = NULL;
    }
    if(HakAkses(5)->update == 1){
        $statusU = NULL;
    }else{
        $statusU = 'disabled';
    }
    if(HakAkses(5)->delete == 1){
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
        <h1 class="text-uppercase">Setup Transaksi</h1>
        </div>
    </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Setup Transaksi</h3>
                    </div>
                    <div class="card-body style="display: block;">
                        <div class="row">
                            <div class="form-group col-sm-8">
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm" id="tambah_induk" data-target="#add-induk" data-toggle="modal" <?=$statusC?>><i class="fa fa-plus"></i> Induk Transaksi</button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-info btn-sm" id="tambah_kategori" data-target="#add-kategori" data-toggle="modal" <?=$statusC?>><i class="fa fa-plus"></i> Kategori Transaksi</button>
                                </div>
                            </div>

                            <div class="col-sm-12 table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="bg-gradient-info">
                                            <th class="text-center">Induk Transaksi</th>
                                            <th class="text-center">Kategori Transaksi</th>
                                            <th class="text-center">Tipe</th>
                                            <th class="text-center">
                                                <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if($induk->num_rows() > 0){
                                                foreach ($induk->result() as $key => $row) {
                                                    // $id = NULL, $tipe = NULL, $induk = NULL, $nama = NULL, $limit = NULL
                                                    $kategori = $this->laporan_keuangan_model->kategoriTransaksi(NULL, NULL, $row->id, NULL, NULL);
                                                    $limit = $this->laporan_keuangan_model->kategoriTransaksi(NULL, NULL, $row->id, NULL, 1);
                                                    $total_kategori = $kategori->num_rows();
                                                    foreach ($kategori->result() as $key => $row2) {
                                                        $tipe = $this->laporan_keuangan_model->tipeTransaksi($row2->tipe)->row();
                                                        if($limit->row()->id == $row2->id){
                                                            ?>
                                                                <tr>
                                                                    <td rowspan="<?=$total_kategori?>" class="text-center" style="vertical-align: middle; width: 300px;">
                                                                        <div class="row">
                                                                            <div class="btn-group text-uppercase h5 text-bold p-1">
                                                                                <?=$row->nama_kategori?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="btn-group p-1">
                                                                                <button type="button" class="btn btn-block bg-gradient-primary btn-xs" id="edit_induk_transaksi"
                                                                                    data-toggle="modal" 
                                                                                    data-target="#edit-induk" 
                                                                                    data-nama_induk="<?=$row->nama_kategori?>"
                                                                                    data-id_induk="<?=$row->id?>"
                                                                                    <?=$statusU?>
                                                                                >
                                                                                    <i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Induk Transaksi"></i>
                                                                                </button>
                                                                            </div>

                                                                            <div class="btn-group p-1">
                                                                                <button type="button" class="btn btn-block bg-gradient-danger btn-xs" id="del_induk"
                                                                                    data-toggle="modal" 
                                                                                    data-target="#del-induk" 
                                                                                    data-del_nama_induk="<?=$row->nama_kategori?>"
                                                                                    data-del_id_induk="<?=$row->id?>"
                                                                                    <?=$statusD?>
                                                                                >
                                                                                    <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete Induk Transaksi"></i>
                                                                                </button>
                                                                            </div>

                                                                        </div>
                                                                    </td>
                                                                    <td><?=$row2->nama_kategori?></td>
                                                                    <td class="text-center text-uppercase"><span class="badge badge-<?=$tipe->warna?>"><?=$tipe->nama?></span></td>
                                                                    <td class="text-center">
                                                                        <button class="btn btn-success btn-xs" id="edit_kategori"
                                                                            data-toggle="modal" 
                                                                            data-target="#edit-kategori" 
                                                                            data-id_kat="<?=$row2->id?>"
                                                                            data-nama_kat="<?=$row2->nama_kategori?>"
                                                                            data-tipe_kat="<?=$row2->tipe?>"
                                                                            data-induk_kat="<?=$row2->induk?>"
                                                                            <?=$statusU?>
                                                                        ><i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Kategori"></i></button>

                                                                        <button class="btn btn-danger btn-xs" id="del_kategori"
                                                                            data-toggle="modal" 
                                                                            data-target="#del-kategori" 
                                                                            data-del_id_kat="<?=$row2->id?>"
                                                                            <?=$statusD?>
                                                                        ><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete Kategori"></i></button>

                                                                    </td>
                                                                </tr>
                                                            <?php
                                                        }else{
                                                            ?>
                                                                <tr>
                                                                    <td><?=$row2->nama_kategori?></td>
                                                                    <td class="text-center text-uppercase"><span class="badge badge-<?=$tipe->warna?>"><?=$tipe->nama?></span></td>
                                                                    <td class="text-center">
                                                                        <button class="btn btn-success btn-xs" id="edit_kategori"
                                                                            data-toggle="modal" 
                                                                            data-target="#edit-kategori" 
                                                                            data-id_kat="<?=$row2->id?>"
                                                                            data-nama_kat="<?=$row2->nama_kategori?>"
                                                                            data-tipe_kat="<?=$row2->tipe?>"
                                                                            data-induk_kat="<?=$row2->induk?>"
                                                                            <?=$statusU?>
                                                                        ><i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Kategori"></i></button>

                                                                        <button class="btn btn-danger btn-xs" id="del_kategori"
                                                                            data-toggle="modal" 
                                                                            data-target="#del-kategori" 
                                                                            data-del_id_kat="<?=$row2->id?>"
                                                                            <?=$statusD?>
                                                                        ><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete Kategori"></i></button>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                        }
                                                    }
                                                    if($total_kategori == 0){
                                                        ?>
                                                            <tr>
                                                                <td class="text-center" style="vertical-align: middle; width: 300px;">
                                                                    <div class="row">
                                                                        <div class="btn-group text-uppercase h5 text-bold p-1">
                                                                            <?=$row->nama_kategori?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="btn-group p-1">
                                                                            <button type="button" class="btn btn-block bg-gradient-primary btn-xs" id="edit_induk_transaksi"
                                                                                data-toggle="modal" 
                                                                                data-target="#edit-induk" 
                                                                                data-nama_induk="<?=$row->nama_kategori?>"
                                                                                data-id_induk="<?=$row->id?>"
                                                                                <?=$statusU?>
                                                                            >
                                                                                <i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Induk Transaksi"></i>
                                                                            </button>
                                                                        </div>

                                                                        <div class="btn-group p-1">
                                                                            <button type="button" class="btn btn-block bg-gradient-danger btn-xs" id="del_induk"
                                                                                data-toggle="modal" 
                                                                                data-target="#del-induk" 
                                                                                data-del_nama_induk="<?=$row->nama_kategori?>"
                                                                                data-del_id_induk="<?=$row->id?>"
                                                                                <?=$statusD?>
                                                                            >
                                                                                <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete Induk Transaksi"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        <?php
                                                    }
                                                }
                                            }else {
                                                echo '
                                                    <tr>
                                                        <td colspan="4" class="text-center">data induk kategori belum ada</td>
                                                    </tr>
                                                    ';
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
    if(HakAkses(5)->create == 1){
        ?>
            <div class="modal fade" id="add-induk">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title"><i class="fa fa-plus-square"></i> Add Induk Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Nama Induk Transaksi</label>
                                    <input type="text" name="nama_induk" id="nama_induk" class="form-control" placeholder="Nama Induk Transaksi" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="add_induk" name="add_induk"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="add-kategori">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-info">
                            <h5 class="modal-title"><i class="fa fa-plus-square"></i> Add Kategori Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Nama Kategori Transaksi</label>
                                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" placeholder="Nama Kategori Transaksi" required>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Induk Transaksi</label>
                                    <select name="induk_kategori" id="induk_kategori" class="form-control">
                                        <option value="0">-pilih-</option>
                                        <?php
                                            foreach ($induk->result() as $key => $row2) {
                                                echo '<option value="'.$row2->id.'">'.$row2->nama_kategori.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Tipe Transaksi</label>
                                    <select name="tipe_transaksi" id="tipe_transaksi" class="form-control">
                                        <option value="0">-pilih-</option>
                                        <?php
                                            foreach ($tipe2 as $key => $row3) {
                                                echo '<option value="'.$row3->id.'">'.$row3->nama.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="add_kategori" name="add_kategori"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>


        <?php
    }

    if(HakAkses(5)->update == 1){
        ?>
            <div class="modal fade" id="edit-induk">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title"><i class="fa fa-edit"></i> Edit Induk Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Nama Induk Transaksi</label>
                                    <input type="text" name="edit_nama_induk" id="edit_nama_induk" class="form-control" placeholder="Nama Induk Transaksi" required>
                                    <input type="hidden" id="induk_id">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="edit_induk_save" name="edit_induk_save"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit-kategori">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-info">
                            <h5 class="modal-title"><i class="fa fa-edit"></i> Edit Kategori Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Nama Kategori Transaksi</label>
                                    <input type="text" name="edit_nama_kategori" id="edit_nama_kategori" class="form-control" placeholder="Nama Kategori Transaksi" required>
                                    <input type="hidden" id="kategori_id">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Induk Transaksi</label>
                                    <select name="edit_induk_kategori" id="edit_induk_kategori" class="form-control">
                                        <option value="0">-pilih-</option>
                                        <?php
                                            foreach ($induk->result() as $key => $row2) {
                                                echo '<option value="'.$row2->id.'">'.$row2->nama_kategori.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Tipe Transaksi</label>
                                    <select name="edit_tipe_transaksi" id="edit_tipe_transaksi" class="form-control">
                                        <option value="0">-pilih-</option>
                                        <?php
                                            foreach ($tipe2 as $key => $row3) {
                                                echo '<option value="'.$row3->id.'">'.$row3->nama.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="edit_kategori_save" name="edit_kategori_save"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>

        <?php
    }

    if(HakAkses(5)->delete == 1){
        ?>
            <div class="modal fade" id="del-induk">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-danger">
                            <h5 class="modal-title"><i class="fa fa-edit"></i> Delete Induk Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <span>Nama Induk Transaksi :</span> <br>
                                    <span class="text-bold text-uppercase h4" id="del_nama_induk"></span>
                                    <input type="hidden" id="del_induk_id">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="del_induk_save" name="del_induk_save"><i class="fa fa-times"></i> Ya, Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="del-kategori">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-danger">
                            <h5 class="modal-title"><i class="fa fa-edit"></i> Delete Kategori Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td width="40%" class="text-right">Nama Kategori :</td>
                                    <td><span class="text-bold text-uppercase" id="del_nama_kategori"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Induk Transaksi :</td>
                                    <td><span class="text-bold" id="del_induk_transaksi"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Tipe Transaksi :</td>
                                    <td><span class="text-bold" id="del_tipe_transaksi"></span></td>
                                </tr>
                            </table>
                            <input type="hidden" id="del_kategori_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="del_kategori_save" name="del_kategori_save"><i class="fa fa-times"></i> Ya, Delete</button>
                        </div>
                    </div>
                </div>
            </div>


        <?php
    }


?>
