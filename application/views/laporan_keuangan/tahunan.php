<?php
    if(HakAkses(4)->create == 1){
        $statusC = NULL;
        $statusC1 = 'data-card-widget="collapse"';
    }else{
        $statusC = 'disabled';
        $statusC1 = NULL;
    }
    if(HakAkses(4)->update == 1){
        $statusU = NULL;
    }else{
        $statusU = 'disabled';
    }
    if(HakAkses(4)->delete == 1){
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
        <h1 class="text-uppercase">Laporan Keuangan Tahunan</h1>
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
                                <h3 class="card-title">Laporan Keuangan Tahunan</h3>
                            </div>
                            <div class="col-sm-6">
                                <h3 class="card-title float-right text-yellow">Periode : <span class="text-bold" id="periode_laporan"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body style="display: block;">
                        <div class="row">
                            <div class="form-group col-sm-8">
                                <div class="btn-group">
                                    <button class="btn btn-secondary btn-sm" id="cetak_laporan"><i class="fa fa-print"></i> Cetak</button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-danger btn-sm" id="download_laporan"><i class="fa fa-file-pdf"></i> Download</button>
                                </div>
                            </div>

                            <div class="form-group col-sm-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" id="tahun_laporan">
                                        <option value=""></option>
                                        <option value="2020">Tahun 2020</option>
                                        <option value="2021">Tahun 2021</option>
                                        <option value="2022">Tahun 2022</option>
                                        <option value="2023">Tahun 2023</option>
                                    </select>
                                </div>
                                <input type="hidden" id="id_lembaga" value="<?=idLembaga()?>">
                            </div>
                            <div class="col-sm-12 table-responsive">
                                <table class="table table-bordered text-nowrap" id="info_saldo">
                                    <thead>
                                        <tr class="bg-gradient-info">
                                            <td class="text-center text-bold small text-uppercase">Saldo Awal :</td>
                                            <td class="text-center text-bold small text-uppercase">Pemasukan :</td>
                                            <td class="text-center text-bold small text-uppercase">Pengeluaran :</td>
                                            <td class="text-center text-bold small text-uppercase">Saldo Akhir :</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-sm-12">
                                <br>
                            </div>

                            <div class="col-sm-12 table-responsive">
                                <table class="table table-bordered table-striped" style="padding-top: 10px;" id="laporan_tahunan1">
                                    <thead>
                                        <tr class="bg-gradient-info">
                                            <th class="text-center text-uppercase" width="40%">Deskripsi</th>
                                            <th class="text-center text-uppercase" width="20%">Pemasukan</th>
                                            <th class="text-center text-uppercase" width="20%">Pengeluaran</th>
                                            <th class="text-center text-uppercase" width="20%">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="load_laporan">
                                        <?php $this->view('laporan_keuangan/tahunan_data'); ?>
                                        <tr>
                                            <td colspan="4"></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gradient-info">
                                            <th class="text-center text-uppercase">Deskripsi</th>
                                            <th class="text-center text-uppercase">Pemasukan</th>
                                            <th class="text-center text-uppercase">Pengeluaran</th>
                                            <th class="text-center text-uppercase">Saldo</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- /.content -->

