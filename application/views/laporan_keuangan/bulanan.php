<?php
if (HakAkses(3)->create == 1) {
    $statusC = NULL;
    $statusC1 = 'data-card-widget="collapse"';
} else {
    $statusC = 'disabled';
    $statusC1 = NULL;
}
if (HakAkses(3)->update == 1) {
    $statusU = NULL;
} else {
    $statusU = 'disabled';
}
if (HakAkses(3)->delete == 1) {
    $statusD = NULL;
} else {
    $statusD = 'disabled';
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-uppercase">Laporan Keuangan Bulanan</h1>
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
                                <h3 class="card-title">Laporan Keuangan Bulanan</h3>
                            </div>
                            <div class="col-sm-6">
                                <h3 class="card-title float-right text-yellow">Periode : <span class="text-bold" id="periode_laporan"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body style=" display: block;">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <div class="btn-group">
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" id="pemasukan" data-target="#form-pemasukan" <?= $statusC ?>>
                                                <i class="fa fa-plus-circle" data-toggle="tooltip" data-placement="top" title="Input Pemasukkan"></i> &nbsp; Pemasukan
                                            </button>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" id="pengeluaran" data-target="#form-pengeluaran" <?= $statusC ?>>
                                                <i class="fa fa-minus-circle" data-toggle="tooltip" data-placement="top" title="Input Pengeluaran"></i> &nbsp; Pengeluaran
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-3"">
                                        <div class=" btn-group">
                                        <button class="btn btn-secondary btn-sm" id="cetak_laporan"><i class="fa fa-print"></i> Cetak</button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-danger btn-sm" id="download_laporan"><i class="fa fa-file-pdf"></i> Download</button>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="row">
                                        <div class="col-4 form-group">
                                            <label for="tipeTransaksi">Tipe Transaksi</label>
                                            <select name="tipeTransaksi" id="tipeTransaksi" class="form-control">
                                                <option></option>
                                                <?php
                                                    $tipe = $this->laporan_keuangan_model->tipeTransaksi()->result();
                                                    foreach ($tipe as $key => $row) {
                                                        echo '<option value="' . $row->id . '">' . $row->nama . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-4 form-group">
                                            <label for="kategoriTransaksi">Kategori Transaksi</label>
                                            <select name="kategoriTransaksi" id="kategoriTransaksi" class="form-control">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-4 form-group">
                                            <label for="hari_ini">Periode</label>
                                            <input type="text" class="form-control float-right" id="hari_ini">
                                            <input type="hidden" id="id_lembaga" value="<?= idLembaga() ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 table-responsive">
                            <table class="table table-bordered text-nowrap" id="info_saldo">
                                <thead>
                                    <tr class="bg-gradient-info">
                                        <td class="text-center small text-uppercase">Saldo Awal :</td>
                                        <td class="text-center small text-uppercase">Pemasukan :</td>
                                        <td class="text-center small text-uppercase">Pengeluaran :</td>
                                        <td class="text-center small text-uppercase">Saldo Akhir :</td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group col-sm-4" id="totalMutasi" style="display: none;">
                            Total Mutasi
                        </div>
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-bordered table-striped table-hover text-nowrap" id="view_laporan_keuangan" width="100%">
                                <thead>
                                    <tr class="bg-gradient-info">
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Mutasi</th>
                                        <th class="text-center">Nominal</th>
                                        <th class="text-center">Saldo</th>
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

if (HakAkses(3)->create == 1) {
?>
    <!-- Transaksi Pemasukan -->
    <div class="modal fade" id="form-pemasukan">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-gradient-blue">
                    <h5 class="modal-title"><i class="fa fa-plus-square"></i> Transaksi Pemasukan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal_pemasukan">Tanggal * :</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" name="tanggal_pemasukan" value="<?= date('Y-m-d') ?>" class="form-control pull-right" id="tanggal_input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kategori_pemasukan">Kategori * :</label>
                        <select name="kategori_pemasukan" id="kategori_pemasukan" class="form-control" required>
                            <option value="0">-pilih-</option>
                            <?php
                            foreach ($cash_in as $key => $row) {
                                echo '<option value="' . $row->id . '">' . $row->nama_kategori . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_pemasukkan">Jumlah * :</label>
                        <input type="number" id="jumlah_pemasukkan" name="jumlah_pemasukkan" min="0" value="0" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="judul_pemasukkan">Keterangan * :</label>
                        <textarea id="judul_pemasukkan" name="judul_pemasukkan" class="form-control"></textarea>
                        <small>*) Wajib diisi</small>
                        <input type="hidden" id="tipe_kas" name="tipe_kas" value="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="add_pemasukkan" name="add_pemasukkan"><i class="fa fa-paper-plane"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Pengeluaran -->
    <div class="modal fade" id="form-pengeluaran">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-gradient-red">
                    <h5 class="modal-title"><i class="fa fa-plus-square"></i> Transaksi Pengeluaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal_pengeluaran">Tanggal * :</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" name="tanggal_pengeluaran" value="<?= date('Y-m-d') ?>" class="form-control pull-right" id="tanggal_input2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kategori_pengeluaran">Kategori * :</label>
                        <select name="kategori_pengeluaran" id="kategori_pengeluaran" class="form-control" required>
                            <option value="0">-pilih-</option>
                            <?php
                            foreach ($cash_out as $key => $row) {
                                echo '<option value="' . $row->id . '">' . $row->nama_kategori . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_pengeluaran">Jumlah * :</label>
                        <input type="number" id="jumlah_pengeluaran" name="jumlah_pengeluaran" min="0" value="0" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="judul_pengeluaran">Keterangan * :</label>
                        <textarea id="judul_pengeluaran" name="judul_pengeluaran" class="form-control"></textarea>
                        <small>*) Wajib diisi</small>
                        <input type="hidden" id="tipe_kas2" name="tipe_kas2" value="2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="add_pengeluaran" name="add_pengeluaran"><i class="fa fa-paper-plane"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

<?php
}

if (HakAkses(3)->update == 1) {
?>
    <div class="modal fade" id="edit-pemasukan">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-gradient-info">
                    <h6 class="modal-title"><i class="fa fa-edit"></i> Edit Transaksi Pemasukan</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal_pemasukan">Tanggal * :</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" name="edit_tanggal_pemasukan" class="form-control pull-right" id="tanggal_input3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kategori_pemasukan">Kategori * :</label>
                        <select name="edit_kategori_pemasukan" id="edit_kategori_pemasukan" class="form-control" required>
                            <option value="0">-pilih-</option>
                            <?php
                            foreach ($cash_in as $key => $row) {
                                echo '<option value="' . $row->id . '">' . $row->nama_kategori . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_jumlah_pemasukkan">Jumlah * :</label>
                        <input type="number" id="edit_jumlah_pemasukkan" name="edit_jumlah_pemasukkan" min="0" value="0" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="edit_judul_pemasukkan">Keterangan * :</label>
                        <textarea id="edit_judul_pemasukkan" name="edit_judul_pemasukkan" class="form-control"></textarea>
                        <small>*) Wajib diisi</small>
                        <input type="hidden" id="edit_pemasukan_id" name="edit_pemasukan_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit_pemasukkan" name="edit_pemasukkan"><i class="fa fa-paper-plane"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-pengeluaran">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-gradient-success">
                    <h6 class="modal-title"><i class="fa fa-edit"></i> Edit Transaksi Pengeluaran</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_tanggal_pengeluaran">Tanggal * :</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" name="edit_tanggal_pengeluaran" class="form-control pull-right" id="tanggal_input4">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_kategori_pengeluaran">Kategori * :</label>
                        <select name="edit_kategori_pengeluaran" id="edit_kategori_pengeluaran" class="form-control" required>
                            <option value="0">-pilih-</option>
                            <?php
                            foreach ($cash_out as $key => $row) {
                                echo '<option value="' . $row->id . '">' . $row->nama_kategori . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_jumlah_pengeluaran">Jumlah * :</label>
                        <input type="number" id="edit_jumlah_pengeluaran" name="edit_jumlah_pengeluaran" min="0" value="0" class="form-control" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="edit_judul_pengeluaran">Keterangan * :</label>
                        <textarea id="edit_judul_pengeluaran" name="edit_judul_pengeluaran" class="form-control"></textarea>
                        <small>*) Wajib diisi</small>
                        <input type="hidden" id="edit_pengeluaran_id" name="edit_pengeluaran_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit_pengeluaran" name="edit_pengeluaran"><i class="fa fa-paper-plane"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

<?php
}

if (HakAkses(3)->delete == 1) {
?>
    <div class="modal fade" id="delete-item">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-secondary">
                    <h5 class="modal-title"><i class="fa fa-times-circle"></i> Delete Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <tr id="bgr_hapus">
                            <td width="40%" class="text-right">Tipe Transaksi :</td>
                            <td><span class="text-bold text-uppercase" id="hapus_tipe_transaksi"></span></td>
                        </tr>
                        <tr>
                            <td class="text-right">Tanggal :</td>
                            <td><span class="text-bold" id="hapus_tanggal"></span></td>
                        </tr>
                        <tr>
                            <td class="text-right">Kategori Transaksi :</td>
                            <td><span class="text-bold" id="hapus_kategori_transaksi"></span></td>
                        </tr>
                        <tr>
                            <td class="text-right">Jumlah Nominal :</td>
                            <td><span class="text-bold" id="hapus_nominal_transaksi"></span></td>
                        </tr>
                        <tr>
                            <td class="text-right">Keterangan :</td>
                            <td><span class="text-bold" id="hapus_keterangan_transaksi"></span></td>
                            <input type="hidden" id="hapus_id">
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" id="delete_transaksi" name="delete_transaksi"><i class="fa fa-times-circle"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
<?php
}

?>