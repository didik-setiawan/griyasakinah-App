<?php
    if(HakAkses(8)->create == 1){
        $statusC = NULL;
        $statusC1 = 'data-card-widget="collapse"';
    }else{
        $statusC = 'disabled';
        $statusC1 = NULL;
    }
    if(HakAkses(8)->update == 1){
        $statusU = NULL;
    }else{
        $statusU = 'disabled';
    }
    if(HakAkses(8)->delete == 1){
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
        <h1 class="text-uppercase">Keluar Masuk Barang</h1>
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
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="card-title">Keluar Masuk Barang</h3>
                            </div>
                            <div class="col-sm-6">
                                <h3 class="card-title float-right text-yellow">Periode : <span class="text-bold" id="periode_laporan"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body style="display: block;"">
                        <div class="row">
                            <div class="form-group col-sm-3">
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm" id="barang_masuk" data-target="#stok_in" data-toggle="modal" <?=$statusC?>><i class="fa fa-plus-circle"></i> Pemasukan</button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-danger btn-sm" id="barang_keluar" data-target="#stok_out" data-toggle="modal" <?=$statusC?>><i class="fa fa-minus-circle"></i> Pengeluaran</button>
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <div class="btn-group">
                                    <button class="btn btn-secondary btn-sm" id="cetak_laporan"><i class="fa fa-print"></i> Cetak</button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-danger btn-sm" id="download_laporan"><i class="fa fa-file-pdf"></i> Download</button>
                                </div>
                            </div>
                            <div class="form-group col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="hari_ini">
                                </div>
                                <input type="hidden" id="id_lembaga" value="<?=idLembaga()?>">
                            </div>
                            <div class="form-group col-sm-3">
                                <select class="form-control" id="tipe_stok">
                                    <option></option>
                                    <option value="1">Barang Masuk</option>
                                    <option value="2">Barang Keluar</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                            </div>
                            <div class="col-sm-12 table-responsive">
                                <table id="history_stok" class="table table-striped text-nowrap">
                                    <thead>
                                        <tr class="bg-gradient-info">
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Deskripsi</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">
                                                <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
    if(HakAkses(8)->create == 1){
        ?>
            <div class="modal fade" id="stok_in">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title"><i class="fa fa-plus-circle"></i> Input Pemasukkan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12 bg-gradient-primary p-2 text-center text-bold">
                                    Input Penerimaan Barang / Stok In
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="tanggal_stok_in">Tanggal : </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="tanggal_stok_in" value="<?=date('Y-m-d')?>" class="form-control pull-right" id="tanggal_stok_in">
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="nama_barang_in">Pilih  Barang : </label>
                                    <select name="nama_barang_in" id="nama_barang_in" class="form-control">
                                        <option value=""></option>
                                        <?php
                                            foreach ($barang as $key => $row) {
                                                echo '<option value="'.$row->id.'">'.$row->nama_produk.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="quantity_in">Quantity : </label>
                                    <input type="number" min="0" value="0" name="quantity_in" id="quantity_in" class="form-control">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="keterangan_in">Keterangan : </label>
                                    <textarea name="keterangan_in" id="keterangan_in" class="form-control"></textarea>
                                    <input type="hidden" id="tipe_pemasukkan" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="add_pemasukkan" name="add_pemasukkan"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="stok_out">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title"><i class="fa fa-minus-circle"></i> Input Pengeluaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12 bg-gradient-danger p-2 text-center text-bold">
                                    Input Pengeluaran Barang / Stok Out
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="tanggal_stok_out">Tanggal : </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="tanggal_stok_out" value="<?=date('Y-m-d')?>" class="form-control pull-right" id="tanggal_stok_out">
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="nama_barang_out">Pilih  Barang : </label>
                                    <select name="nama_barang_out" id="nama_barang_out" class="form-control">
                                        <option value=""></option>
                                        <?php
                                            foreach ($barang as $key => $row) {
                                                echo '<option value="'.$row->id.'">'.$row->nama_produk.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="quantity_out">Quantity : </label>
                                    <input type="number" min="0" value="0" name="quantity_out" id="quantity_out" class="form-control">
                                    <input type="hidden" id="tipe_pengeluaran" value="2">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="keterangan_out">Keterangan : </label>
                                    <textarea name="keterangan_out" id="keterangan_out" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="add_pengeluaran" name="add_pengeluaran"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>

<?php
    if(HakAkses(8)->update == 1){
        ?>
            <div class="modal fade" id="edit-item">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-info">
                            <h5 class="modal-title"><i class="fa fa-pencil-alt"></i> Edit Transaksi Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12 p-2 text-center text-bold" id="class_tipe">
                                   <span id="text_tipe" class="text-uppercase"></span>
                                   <input type="hidden" id="tipe_stok_edit">
                                   <input type="hidden" id="id_stok_edit">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="tanggal_edit">Tanggal : </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="tanggal_edit" value="<?=date('Y-m-d')?>" class="form-control pull-right" id="tanggal_edit">
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="nama_barang_edit">Pilih  Barang : </label>
                                    <select name="nama_barang_edit" id="nama_barang_edit" class="form-control">
                                        <option value=""></option>
                                        <?php
                                            foreach ($barang as $key => $row) {
                                                echo '<option value="'.$row->id.'">'.$row->nama_produk.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="quantity_edit">Quantity : </label>
                                    <input type="number" min="0" name="quantity_edit" id="quantity_edit" class="form-control">
                                    <input type="hidden" id="quantity_old">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="keterangan_edit">Keterangan : </label>
                                    <textarea name="keterangan_edit" id="keterangan_edit" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" id="edit_data"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>

<?php
    if(HakAkses(8)->delete == 1){
        ?>
            <div class="modal fade" id="delete-item">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-danger">
                            <h5 class="modal-title"><i class="fa fa-times"></i> Delete Transaksi Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td class="text-right" style="width: 35%;">Tanggal : </td>
                                    <td><span id="del_tanggal" class="text-bold"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="width: 35%;">Kode Barang : </td>
                                    <td><span id="del_kode_barang" class="text-bold"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="width: 35%;">Nama Barang : </td>
                                    <td><span id="del_nama_barang" class="text-bold"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="width: 35%;">Kategori Barang : </td>
                                    <td><span id="del_kategori" class="text-bold"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="width: 35%;">Keterangan : </td>
                                    <td><span id="del_keterangan" class="text-bold"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="width: 35%;">Quantity : </td>
                                    <td><span id="del_quantity" class="text-bold"></span> <span id="del_satuan" class="text-bold"></span></td>
                                </tr>
                                <tr id="del_status2">
                                    <td class="text-right" style="width: 35%;">Status : </td>
                                    <td><span id="del_status" class="text-bold"></span></td>
                                </tr>
                            </table>
                            <input type="hidden" id="del_id">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="yes_delete"><i class="fa fa-times"></i> Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>



