<?php
    if(HakAkses(12)->create == 1){
        $statusC = NULL;
        $statusC1 = 'data-card-widget="collapse"';
    }else{
        $statusC = 'disabled';
        $statusC1 = NULL;
    }
    if(HakAkses(12)->update == 1){
        $statusU = NULL;
    }else{
        $statusU = 'disabled';
    }
    if(HakAkses(12)->delete == 1){
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
        <h1 class="text-uppercase">Daftar RAB</h1>
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
                            <div class="form-group col-sm-5">
                                <!-- <div class="btn-group">
                                    <button class="btn btn-secondary btn-sm" id="cetak_laporan"><i class="fa fa-print"></i> Cetak</button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-danger btn-sm" id="download_laporan"><i class="fa fa-file-pdf"></i> Download</button>
                                </div> -->
                            </div>
                            <div class="form-group col-sm-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i> &nbsp; Periode : 
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="hari_ini">
                                </div>
                                <input type="hidden" id="id_lembaga" value="<?=idLembaga()?>">
                            </div>
                            <div class="form-group col-sm-3">
                                <select name="status_rab" id="status_rab" class="form-control">
                                    <!-- 1 = progres, 2, = cancel, 3 = delete, 4 = template, 99 = selesai -->
                                    <option value=""></option>
                                    <option value="1">On Progress</option>
                                    <option value="99">Finish</option>
                                    <option value="2">Cancel</option>
                                    <!-- <option value="3">Delete</option> -->
                                </select>
                            </div>
                            <div class="col-sm-12 table-responsive">
                                <table id="daftar_rab" class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr class="bg-gradient-info">
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Nama Kegiatan</th>
                                            <th class="text-center">Total Anggaran</th>
                                            <th class="text-center">Progress</th>
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
    if(HakAkses(12)->update == 1){
        ?>
            <div class="modal fade" id="cancel-rab">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-info">
                            <h5 class="modal-title"><i class="fa fa-ban"></i> Batalkan RAB</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <table class="table table-borderless table-striped">
                                        <tr>
                                            <td class="text-right" width="40%">Nama Kegiatan : </td>
                                            <td><span id="nama_kegiatan" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Waktu/Tanggal : </td>
                                            <td><span id="waktu" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Tempat/Lokasi : </td>
                                            <td><span id="tempat" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Deskripsi : </td>
                                            <td><span id="deskripsi" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-success" width="40%">Total Anggaran : </td>
                                            <td><span id="anggaran" class="text-bold text-success"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-primary" width="40%">Total Realisasi : </td>
                                            <td><span id="realisasi" class="text-bold text-primary"></span> (<span id="persen" class="text-bold text-primary"></span>%)</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-danger" width="40%">Sisa Realisasi : </td>
                                            <td><span id="sisa" class="text-bold text-danger"></span></td>
                                        </tr>
                                    </table>
                                    <input type="hidden" id="rab_id">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-info" id="ya_cancel" name="ya_cancel"><i class="fa fa-ban"></i> Ya, Batalkan</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="finish-rab">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title"><i class="fa fa-check-double"></i> RAB sudah dinyatakan Selesai</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <table class="table table-borderless table-striped">
                                        <tr>
                                            <td class="text-right" width="40%">Nama Kegiatan : </td>
                                            <td><span id="yes_nama_kegiatan" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Waktu/Tanggal : </td>
                                            <td><span id="yes_waktu" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Tempat/Lokasi : </td>
                                            <td><span id="yes_tempat" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Deskripsi : </td>
                                            <td><span id="yes_deskripsi" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-success" width="40%">Total Anggaran : </td>
                                            <td><span id="yes_anggaran" class="text-bold text-success"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-primary" width="40%">Total Realisasi : </td>
                                            <td><span id="yes_realisasi" class="text-bold text-primary"></span> (<span id="yes_persen" class="text-bold text-primary"></span>%)</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-danger" width="40%">Sisa Realisasi : </td>
                                            <td><span id="yes_sisa" class="text-bold text-danger"></span></td>
                                        </tr>
                                    </table>
                                    <input type="hidden" id="yes_rab_id">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="ya_finish" name="ya_finish"><i class="fa fa-check-double"></i> Ya, Selesai</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>

<?php
    if(HakAkses(12)->delete == 1){
        ?>
            <div class="modal fade" id="delete-rab">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-danger">
                            <h5 class="modal-title"><i class="fa fa-times"></i> Delete Data RAB</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <table class="table table-borderless table-striped">
                                        <tr>
                                            <td class="text-right" width="40%">Nama Kegiatan : </td>
                                            <td><span id="del_nama_kegiatan" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Waktu/Tanggal : </td>
                                            <td><span id="del_waktu" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Tempat/Lokasi : </td>
                                            <td><span id="del_tempat" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" width="40%">Deskripsi : </td>
                                            <td><span id="del_deskripsi" class="text-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-success" width="40%">Total Anggaran : </td>
                                            <td><span id="del_anggaran" class="text-bold text-success"></span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-primary" width="40%">Total Realisasi : </td>
                                            <td><span id="del_realisasi" class="text-bold text-primary"></span> (<span id="del_persen" class="text-bold text-primary"></span>%)</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-danger" width="40%">Sisa Realisasi : </td>
                                            <td><span id="del_sisa" class="text-bold text-danger"></span></td>
                                        </tr>
                                    </table>
                                    <input type="hidden" id="rab_id2">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="ya_delete" name="ya_delete"><i class="fa fa-times"></i> Ya, Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>
