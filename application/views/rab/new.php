<?php
    if(HakAkses(11)->create == 1){
        $statusC = NULL;
        $statusC1 = 'data-card-widget="collapse"';
    }else{
        $statusC = 'disabled';
        $statusC1 = NULL;
    }
    if(HakAkses(11)->update == 1){
        $statusU = NULL;
    }else{
        $statusU = 'disabled';
    }
    if(HakAkses(11)->delete == 1){
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
                <h1 class="text-uppercase">Buat RAB Baru</h1>
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
                        <h3 class="card-title">Nama Kegiatan</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="">Nama Kegiatan :</label>
                                <input type="text" class="form-control" name="nama_kegiatan" id="nama_kegiatan" placeholder="Nama Kegiatan">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="">Waktu/Tanggal :</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="tanggal_input">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="">Tempat/Lokasi :</label>
                                <input type="text" class="form-control" name="tempat_lokasi" id="tempat_lokasi" placeholder="Tempat/Lokasi Kegiatan">
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="">Deskripsi :</label>
                                <textarea name="deskripsi_kegiatan" id="deskripsi_kegiatan" class="form-control" placeholder="Deskripsi Kegiatan"></textarea>
                                <input type="hidden" id="id_rab" value="">
                            </div>
                            <div class="form-group col-sm-12 text-right">
                                <div class="btn-group">
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#reset_rab" <?=$statusC?>>
                                        <i class="fa fa-sync" data-toggle="tooltip" data-placement="top" title="Reset RAB"></i> Reset
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-primary" id="simpan_rab" data-toggle="modal" data-target="#proses_rab" <?=$statusC?>>
                                        <i class="fa fa-save" data-toggle="tooltip" data-placement="top" title="Reset RAB"></i> Simpan RAB
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="detail_rab">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Detail RAB</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" id="add_kategori" data-target="#add-induk" <?=$statusC?>>
                                        <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="top" title="Add Kategori"></i> Kategori
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" id="add_detail" data-target="#add-detail" <?=$statusC?>>
                                        <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="top" title="Add Detail Anggaran"></i> Anggaran
                                    </button>
                                </div>
                            </div>
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
                                                                        <td class="text-center">
                                                                            <div class="btn-group">
                                                                                <button class="btn btn-secondary btn-xs" data-toggle="modal" id="item_edit" data-target="#edit-item" data-item_id="<?=$parent->id?>" <?=$statusU?>>
                                                                                    <i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="btn-group">
                                                                                <button class="btn btn-danger btn-xs" data-toggle="modal" id="item_delete" data-target="#delete-item" data-item_id="<?=$parent->id?>" <?=$statusD?>>
                                                                                    <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                                                                                </button>
                                                                            </div>
                                                                        </td>
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

<?php
    if(HakAkses(11)->create == 1){
        ?>
            <div class="modal fade" id="add-induk">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title"><i class="fa fa-plus-square"></i> Add Kategori Induk RAB</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Nama Kategori : </label>
                                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="add_kategori_save" name="add_kategori_save"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="add-detail">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title"><i class="fa fa-plus-square"></i> Add Detail Anggaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Kategori Induk :</label>
                                    <select name="induk_kategori" id="induk_kategori" class="form-control">
                                        <option value="0">-pilih-</option>
                                        <?php
                                            foreach ($detail->result() as $key => $pilih) {
                                                if($pilih->level == 1){
                                                    echo '<option value="'.$pilih->id.'">'.$pilih->deskripsi.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Deskripsi :</label>
                                    <textarea name="add_deskripsi" id="add_deskripsi" class="form-control" placeholder="Deskripsi"></textarea>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Quantity :</label>
                                    <input type="number" min="0" value="0" name="add_quantity" id="add_quantity" class="form-control">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Satuan :</label>
                                    <select name="add_satuan" id="add_satuan" class="form-control">
                                        <option value="0">-pilih-</option>
                                        <?php
                                            foreach ($unit as $key => $satuan) {
                                                echo '<option value="'.$satuan->id.'">'.$satuan->nama_satuan.'</option>';
                                                # code...
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Harga Satuan :</label>
                                    <input type="number" min="0" value="0" name="add_nominal" id="add_nominal" class="form-control">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Total :</label>
                                    <input type="number" min="0" value="0" name="add_total" id="add_total" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="add_detail_save" name="add_detail_save"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="proses_rab">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title"><i class="fa fa-sync"></i> Data RAB akan diproses...???</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12 h5 text-bold text-center text-primary">
                                    Pastikan data RAB sudah dibuat dengan benar sebelum diproses...
                                </div>
                                <div class="form-group col-sm-12">
                                    <table class="table table-borderless table-striped">
                                        <tr>
                                            <td class="text-right" width="40%">Nama Kegiatan : </td>
                                            <td><span id="view_nama_kegiatan" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Waktu/Tanggal : </td>
                                            <td><span id="view_tanggal" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Tempat/Lokasi : </td>
                                            <td><span id="view_tempat" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Deskripsi : </td>
                                            <td><span id="view_deskripsi" class="text-bold"></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="ya_proses" name="ya_proses"><i class="fa fa-paper-plane"></i> Ya, Proses</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="reset_rab">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-danger">
                            <h5 class="modal-title"><i class="fa fa-sync"></i> Data RAB akan direset...!!!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12 h4 text-center">
                                    Apakah yakin Data RAB akan direset...???
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="ya_reset" name="ya_reset"><i class="fa fa-times"></i> Ya, Reset</button>
                        </div>
                    </div>
                </div>
            </div>


        <?php
    }

    if(HakAkses(11)->update == 1){
        ?>
            <div class="modal fade" id="edit-induk">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-success">
                            <h5 class="modal-title"><i class="fa fa-plus-square"></i> Edit Kategori Induk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Nama Kategori : </label>
                                    <input type="text" name="edit_nama_kategori" id="edit_nama_kategori" class="form-control">
                                    <input type="hidden" id="edit_id_kategori">
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

            <div class="modal fade" id="edit-item">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-success">
                            <h5 class="modal-title"><i class="fa fa-plus-square"></i> Edit Detail Anggaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Kategori Induk :</label>
                                    <select name="edit_kategori" id="edit_kategori" class="form-control">
                                        <option value="0">-pilih-</option>
                                        <?php
                                            foreach ($detail->result() as $key => $pilih) {
                                                if($pilih->level == 1){
                                                    echo '<option value="'.$pilih->id.'">'.$pilih->deskripsi.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Deskripsi :</label>
                                    <textarea name="edit_deskripsi" id="edit_deskripsi" class="form-control" placeholder="Deskripsi"></textarea>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Quantity :</label>
                                    <input type="number" min="0" value="0" name="edit_quantity" id="edit_quantity" class="form-control">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Satuan :</label>
                                    <select name="edit_satuan" id="edit_satuan" class="form-control">
                                        <option value="0">-pilih-</option>
                                        <?php
                                            foreach ($unit as $key => $satuan) {
                                                echo '<option value="'.$satuan->id.'">'.$satuan->nama_satuan.'</option>';
                                                # code...
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Harga Satuan :</label>
                                    <input type="number" min="0" value="0" name="edit_nominal" id="edit_nominal" class="form-control">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Total :</label>
                                    <input type="number" min="0" value="0" name="edit_total" id="edit_total" class="form-control" readonly>
                                    <input type="hidden" id="edit_id_detail">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="edit_detail" name="edit_detail"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }

    if(HakAkses(11)->delete == 1){
        ?>
            <div class="modal fade" id="delete-induk">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-danger">
                            <h5 class="modal-title"><i class="fa fa-plus-square"></i> Delete Kategori Induk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Nama Kategori : </label>
                                    <input type="text" name="del_nama_kategori" id="del_nama_kategori" class="form-control" placeholder="Nama Kategori" readonly>
                                    <input type="hidden" id="del_id_kategori">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="delete_kategori" name="delete_kategori"><i class="fa fa-times"></i> Ya, Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="delete-item">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-danger">
                            <h5 class="modal-title"><i class="fa fa-plus-square"></i> Delete Detail Anggaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td class="text-right" width="40%">Kategori Induk : </td>
                                            <td><span id="del_kategori" class="text-bold text-uppercase text-primary"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Deskripsi : </td>
                                            <td><span id="del_deskripsi" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Quantity : </td>
                                            <td><span id="del_quantity" class="text-bold"></span> <span id="del_satuan" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Harga Satuan : </td>
                                            <td><span id="del_nominal" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Total : </td>
                                            <td><span id="del_total" class="text-bold"></span></td>
                                        </tr>
                                    </table>
                                    <input type="hidden" id="del_id_detail">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="del_detail" name="del_detail"><i class="fa fa-times"></i> Ya, Delete</button>
                        </div>
                    </div>
                </div>
            </div>

        <?php
    }
?>

