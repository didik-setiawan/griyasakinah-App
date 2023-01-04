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
    </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="card-title">Buat RAB</h3>
                            </div>
                            <div class="col-sm-6">
                                <h3 class="card-title float-right text-yellow">Periode : <span class="text-bold" id="periode_laporan"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body style="display: block;">
                        <div class="row">
                            <div class="form-group col-sm-9">
                                
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
                            </div>
                            <div class="form-group col-sm-4">
                            </div>

                            <div class="col-sm-12 table-responsive">
                                <table class="table table-bordered table-striped table-hover text-nowrap" id="table_list">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th class="text-center">Tgl Pengajuan</th>
                                            <th class="text-center">Nama Proyek</th>
                                            <th class="text-center">Kavling</th>
                                            <th class="text-center">status</th>
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
</section>


<div class="modal fade" id="detailKavling" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="detailKavlingLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h5 class="modal-title text-light" id="detailKavlingLabel">Detail Kavling</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detail-kavling">
          <input type="text" id="id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php

if(HakAkses(7)->create == 1){
?>
    <div class="modal fade" id="add-pengajuan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="add-pengajuanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-dark text-light">
            <h5 class="modal-title" id="add-pengajuanLabel">Ajukan Proyek</h5>
            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="form-group col-sm-12">
            <label for="tgl_pengajuan">Tanggal : </label>
            <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" name="tgl_pengajuan" value="<?=date('Y-m-d')?>" class="form-control pull-right" id="tgl_pengajuan" required>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Nama Proyek</label>
                    <input type="text" name="nama_proyek" id="nama_proyek" class="form-control" required>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label>Pilih Kavling</label>
                <select class="form-control" id="kavling_id" name="kavling_id" required>
                    <option value="0">---Tipe - blok---</option>
                    <?php
                        foreach ($kavling as $key => $kav) {
                            echo '<option value="'.$kav->id_kavling.'">'.$kav->tipe.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$kav->blok.'</span></option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-sm" id="save" name="save"><i class="fa fa-save"></i> Simpan</button>
        </div>
        </div>
    </div>
    </div>
<?php
}if(HakAkses(7)->update == 1){
    ?>
        <div class="modal fade" id="approve-item">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-info">
                        <h4 class="modal-title"> Approve Pengajuan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <p>Apakah Anda Yakin Ingin Mengapprove Data?</p>
                    <input type="hidden" name="id" id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info float-right" id="approve_save"><i class="fa fa-save"></i> Approve</button>
                    </div>
                </div>
            </div>
        </div>


    <div class="modal fade" id="edit-pengajuan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="edit-pengajuanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h5 class="modal-title" id="edit-pengajuanLabel">Edit Ajukan Proyek</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="form-group col-sm-12">
                <label for="tgl_pengajuan">Tanggal : </label>
                <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" name="edit_tgl_pengajuan" class="form-control pull-right" id="edit_tgl_pengajuan">
                        <input type="hidden" name="edit_id" id="edit_id">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Nama Proyek</label>
                        <input type="text" name="edit_nama_proyek" id="edit_nama_proyek" class="form-control">
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label>Pilih Kavling</label>
                    <select class="form-control" id="edit_kavling_id" name="edit_kavling_id">
                        <option value="0">---Tipe - blok---</option>
                        <?php
                            foreach ($kavling as $key => $kav) {
                                echo '<option value="'.$kav->id_kavling.'">'.$kav->tipe.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$kav->blok.'</span></option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="edit_save" name="edit_save"><i class="fa fa-save"></i> Simpan</button>
            </div>
            </div>
        </div>
    </div>
<?php
}if(HakAkses(7)->delete == 1){ ?>

    <div class="modal fade" id="del-pengajuan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-danger">
                        <h4 class="modal-title"><i class="fa fa-times"></i> Hapus Pengajuan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <p>Apakah Anda Yakin Ingin Menghapus Data?</p>
                    <input hidden name="delete_id" id="delete_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger float-right" name="del_data" id="del_data"><i class="fa fa-times"></i> Hapus</button>
                    </div>
                </div>
            </div>
        </div>

<?php } ?>