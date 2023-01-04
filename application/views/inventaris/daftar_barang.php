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
        <h1>Daftar Barang Inventaris</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Barang Inventaris</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-5"">
                                <?php
                                    if(HakAkses(7)->create == 1){
                                        echo '
                                            <div class="btn-group">
                                                <button class="btn btn-primary btn-sm" id="tambah_produk" data-target="#add-produk" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Barang</button>
                                            </div>
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="dropdown">Kategori</button>
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item small" data-target="#add-kategori" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Kategori</a>
                                                        <a class="dropdown-item small" href="'.site_url('inventaris/kategori_list/').'"><i class="fa fa-list"></i> Daftar Kategori</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="dropdown">Unit</button>
                                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item small" href="#" data-target="#add-unit" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Unit</a>
                                                        <a class="dropdown-item small" href="'.site_url('inventaris/unit_list/').'"><i class="fa fa-list"></i> Daftar Unit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                ?>

                            </div>
                            <div class="form-group col-sm-3">
                                <div class="btn-group">
                                    <button class="btn btn-secondary btn-sm" id="cetak_laporan"><i class="fa fa-print"></i> Cetak</button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-danger btn-sm" id="download_laporan"><i class="fa fa-file-pdf"></i> Download</button>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <select class="form-control" id="kategori_produk">
                                    <option></option>
                                    <?php
                                        foreach ($kategori as $key => $kat) {
                                            echo '<option value="'.$kat->id.'">'.$kat->kategori_produk.'</option>';
                                        }
                                    ?>
                                </select>
                                <input type="hidden" id="id_lembaga" value="<?=idLembaga()?>">
                            </div>
                            <div class="col-sm-12 table-responsive">
                                <table class="table table-bordered table-striped table-hover text-nowrap" id="produk_list">
                                    <thead>
                                        <tr class="bg-gradient-gray">
                                            <th class="text-center">Kode Barang</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Stok</th>
                                            <th class="text-center">Nilai</th>
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

if(HakAkses(7)->create == 1){
    ?>
        <div class="modal fade" id="add-produk">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h5 class="modal-title"><i class="fa fa-plus-square"></i> Tambah Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label>Nama Barang</label>
                                <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Nama Barang" required>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Kode Barang</label>
                                <input type="text" name="kode_barang" id="kode_barang" class="form-control" placeholder="Kode Barang" required>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Kategori Barang</label>
                                <select class="form-control" id="kategori_produk2" name="kategori_produk2" required>
                                    <option value="0">-pilih-</option>
                                    <?php
                                        foreach ($kategori as $key => $kat) {
                                            echo '<option value="'.$kat->id.'">'.$kat->kategori_produk.'</option>';
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Satuan Unit</label>
                                <select class="form-control" id="unit_produk" name="unit_produk" required>
                                    <option value="0">-pilih-</option>
                                    <?php
                                        foreach ($unit as $key => $row) {
                                            echo '<option value="'.$row->id.'">'.$row->nama_satuan.'</option>';
                                        }
                                        ?>
                                </select>

                            </div>
                            <div class="form-group col-sm-12">
                                <label>Estimasi Harga</label>
                                <input type="number" min="0" value="0" id="estimasi_harga" name="estimasi_harga" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="add_produk_save" name="add_produk_save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add-kategori">
            <div class="modal-dialog modal-sm">
                <form id="add_kategori_form" role="form" method="POST">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-secondary">
                            <h5 class="modal-title"><i class="fa fa-plus-square"></i> Tambah Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="add_kategori_save" name="add_kategori_save"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="modal fade" id="add-unit">
            <div class="modal-dialog modal-sm">
                <form id="add_unit_form" role="form" method="POST">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-success">
                            <h5 class="modal-title"><i class="fa fa-plus-square"></i> Tambah Unit baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <input type="text" name="nama_unit" id="nama_unit" class="form-control" placeholder="Input Nama unit" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="add_unit_save" name="add_unit_save"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <?php
}

if(HakAkses(7)->update == 1){
    ?>
        <div class="modal fade" id="edit-item">
            <div class="modal-dialog modal-sm" >
                <div class="modal-content">
                    <div class="modal-header bg-gradient-success">
                        <h5 class="modal-title"><i class="fa fa-edit"></i> Edit Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label>Nama Barang</label>
                                <input type="text" name="edit_nama_produk" id="edit_nama_produk" class="form-control" placeholder="Nama Produk">
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Kode Barang</label>
                                <input type="text" name="edit_kode_produk" id="edit_kode_produk" class="form-control" placeholder="Kode Produk">
                                <input type="hidden" name="edit_id_produk" id="edit_id_produk">
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Kategori Barang</label>
                                <select class="form-control" id="edit_kategori_produk" name="edit_kategori_produk">
                                    <?php
                                        foreach ($kategori as $key => $kat) {
                                            echo '<option value="'.$kat->id.'">'.$kat->kategori_produk.'</option>';
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Unit Produk</label>
                                <select class="form-control" id="edit_unit_produk" name="edit_unit_produk">
                                    <?php
                                        foreach ($unit as $key => $row) {
                                            echo '<option value="'.$row->id.'">'.$row->nama_satuan.'</option>';
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Estimasi Harga</label>
                                <input type="number" min="0" name="edit_harga" id="edit_harga" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="edit_produk_save" name="edit_produk_save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>

    <?php
}

if(HakAkses(7)->delete == 1){
    ?>
        <div class="modal fade" id="delete-item">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-danger">
                        <h4 class="modal-title"><i class="fa fa-times"></i> Delete Produk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td class="text-right" style="width: 40%;">Kode Barang : </td>
                                <td><span class="text-bold text-uppercase" id="del_kode_barang"></span></td>
                            </tr>
                            <tr>
                                <td class="text-right">Nama Barang : </td>
                                <td><span class="text-bold text-uppercase" id="del_nama_barang"></span></td>
                            </tr>
                            <tr>
                                <td class="text-right">Kategori : </td>
                                <td><span class="text-bold text-capitalize" id="del_kategori"></span></td>
                            </tr>
                            <tr>
                                <td class="text-right">Unit Satuan : </td>
                                <td><span class="text-bold text-uppercase" id="del_unit"></span></td>
                            </tr>
                            <tr>
                                <td class="text-right">Estimasi Harga : </td>
                                <td><span class="text-bold" id="del_harga"></span></td>
                            </tr>
                            <tr>
                                <td class="text-right">Stok Akhir : </td>
                                <td><span class="text-bold" id="del_stok"></span> <span class="text-bold" id="del_unit2"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="delete_id_produk" id="delete_id_produk">
                        <input type="hidden" name="del_stok2" id="del_stok2">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger float-right" id="delete_produk_save"><i class="fa fa-times"></i> Delete</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
}


?>




