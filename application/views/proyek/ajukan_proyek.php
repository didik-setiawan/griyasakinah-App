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
        <!-- <div class="col-sm-6">
        <h1>Daftar Pengajuan Proyek</h1>
        </div> -->
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
                                <h3 class="card-title">Pengajuan Proyek</h3>
                                <!-- <?= $this->session->userdata('group_id'); ?> -->
                            </div>
                            <div class="col-sm-6">
                                <h3 class="card-title float-right text-yellow">Periode : <span class="text-bold" id="periode_laporan"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: block;">
                        <div class="row">
                            <div class="form-group col-sm-9">
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm" id="tambah_pengajuan" data-target="#add-pengajuan" data-toggle="modal"><i class="fa fa-plus"></i> Pengajuan Proyek</button>
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
                    <input type="text" name="nama_proyek" autocomplete="off" id="nama_proyek" class="form-control" required placeholder="...">
                </div>
            </div>
            <div id="containerTipe">
                <hr>
                <div class="form-group col-sm-12">
                    <label>Pilih Cluster</label>
                    <select class="form-control cluster0 cluster" id="id_cluster" name="id_cluster[]"  required>
                    <option value="0">-pilih-</option>
                    <?php foreach($cluster as $row):?>
                    <option value="<?php echo $row->id_cluster;?>"><?php echo $row->nama_cluster;?></option>
                    <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group col-sm-12">
                    <label>Pilih Tipe</label>
                    <select class="form-control tipe0 tipe" id="id_tipe" name="id_tipe[]"  required>
                    <option value="0">-pilih-</option>
                    </select>
                </div>
                <div class="form-group col-sm-12">
                    <label>Pilih Kavling</label>
                    <select class="form-control kavling kavling_id" id="kavling_id" name="kavling_id[]" multiple="multiple" required>
                    </select>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <button class="btn btn-success btn-sm tambahTipe col-12" disabled><i class="fa fa-plus"></i> Tipe</button>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-sm" id="save" name="save"><i class="fa fa-save"></i> Simpan</button>
        </div>
        </div>
    </div>
    </div>


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
                    <input type="hidden" name="id" id="id_toApprove">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info float-right" id="approve_save"><i class="fa fa-save"></i> Approve</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="tolak-item">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-warning">
                        <h4 class="modal-title"> Tolak Pengajuan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <p>Apakah Anda Yakin Ingin Menolak Pengajuan?</p>
                    <input type="hidden" name="id" id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-warning float-right" id="tolak_save"><i class="fa fa-save"></i> Tolak</button>
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
                        <input type="hidden" name="edit_proyek_id" id="edit_proyek_id">
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
                    <select class="form-control kavling" id="edit_kavling_id" name="edit_kavling_id[]" multiple="multiple" required>
                        <?php
                            foreach ($list as $key => $kav) {
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
                    <!-- <input hidden name="proyek_id[]" id="proyek_id"> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger float-right" name="del_data" id="del_data"><i class="fa fa-times"></i> Hapus</button>
                    </div>
                </div>
            </div>
        </div>
