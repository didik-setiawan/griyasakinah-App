<?php
    if(HakAkses(17)->create == 1){
        $statusC = NULL;
        $statusC1 = 'data-card-widget="collapse"';
    }else{
        $statusC = 'disabled';
        $statusC1 = NULL;
    }
    if(HakAkses(17)->update == 1){
        $statusU = NULL;
    }else{
        $statusU = 'disabled';
    }
    if(HakAkses(17)->delete == 1){
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
        <h1 class="text-uppercase">Laporan Laba / Rugi</h1>
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
                            <div class="col-sm-10">
                                <h3 class="card-title">Laporan Laba Rugi</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body style="display: block;">
                        <div class="row">
                            <div class="form-group col-sm-9">
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
                                    <select class="form-control" id="periode_tahun">
                                        <option></option>
                                        <option value="2020">Tahun 2020</option>
                                        <option value="2021">Tahun 2021</option>
                                        <option value="2022">Tahun 2022</option>
                                        <option value="2023">Tahun 2023</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 table-responsive">
                                <h4 class="text-center text-uppercase text-bold text-primary"><?=$profile->nama_lembaga?></h4>
                                <h6 class="text-center text-bold text-gray">Laporan Laba Rugi</h6>
                                <h6 class="text-center text-bold text-gray">Periode : <span id="p_tahun"></span></h6>
                                <br>
                                <table width="100%" id="load_data">
                                    <?php $this->view('laporan_keuangan/data_labarugi'); ?>
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


