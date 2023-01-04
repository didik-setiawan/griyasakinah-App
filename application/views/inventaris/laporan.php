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
        <h1 class="text-uppercase">Laporan</h1>
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
                                <h3 class="card-title">Laporan</h3>
                            </div>
                            <div class="col-sm-6">
                                <h3 class="card-title float-right text-yellow">Periode : <span class="text-bold" id="periode_laporan"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body style="display: block;"">
                        <div class="row">
                            <div class="form-group col-sm-4"">
                            <div class="btn-group">
                                    <button class="btn btn-secondary btn-sm" id="cetak_laporan"><i class="fa fa-print"></i> Cetak</button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-danger btn-sm" id="download_laporan"><i class="fa fa-file-pdf"></i> Download</button>
                                </div>
                            </div>
                            <div class="col-sm-4 form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="hari_ini">
                                    <input type="hidden" id="id_lembaga" value="<?=idLembaga()?>">
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
                            </div>
                            <div class="col-sm-12 table-responsive">
                                <table id="laporan_bulanan" class="table table-striped text-nowrap">
                                    <thead>
                                        <tr class="bg-gradient-info">
                                            <th class="text-center">Kode</th>
                                            <th>Nama Barang</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Pemasukan</th>
                                            <th class="text-center">Pengeluaran</th>
                                            <th class="text-center">Sisa Barang</th>
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


