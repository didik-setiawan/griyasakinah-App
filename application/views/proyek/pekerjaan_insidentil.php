
<?php
    $group = $this->session->userdata('group_id');
    if($group == 1){
        $act = '';
    } else if($group == 2){
        $act = 'd-none';
    } else if($group == 6){
        $act = '';
    } else {
        $act = 'd-none';
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
                                <h3 class="card-title">Pekerjaan Insidentil</h3>
                            </div>
                            <div class="col-sm-6">
                                <h3 class="card-title float-right text-yellow">Periode : <span class="text-bold" id="periode_laporan"></span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body style="display: block;">
                        <div class="row">
                            <div class="form-group col-sm-9">
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm  <?= $act ?>" id="tambah_pengajuan" data-target="#add-pengajuan" data-toggle="modal"><i class="fa fa-plus"></i> Pekerjaan Insidentil</button>
                                </div>
                            </div>
     
                            <div class="form-group col-sm-3">
                                <!-- <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="hari_ini">
                                </div> -->
                            </div>
                            <div class="form-group col-sm-4">
                            </div>

                            <div class="col-sm-12 table-responsive">
                                <table class="table table-bordered table-striped table-hover text-nowrap" id="table_list">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th class="text-center">Tgl Pekerjaan</th>
                                            <th class="text-center">Nama Proyek</th>
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Status Transfer Dana</th>
                                            <th class="text-center">
                                                <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1; 
                                        foreach ($insidental as $key => $row){
                                            $cicil = $this->db->get_where('cicil_insidentil',['id_insidentil' => $row->id])->result();
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $i++; ?></td>
                                                <td>
                                                <span class="text-uppercase"><?= date('d F Y', strtotime($row->tanggal_insidentil))?></span><br>
                                                <span class="small text-danger"><?= date('h:i:s A', strtotime($row->created_at))?></span><br>
                                                </td>
                                                <td><?= $row->nama_proyek ?></td>
                                                <td>
                                                <?= $row->keterangan ?>
                                                </td>
                                                <td class="text-right">Rp. <?= rupiah2($row->nilai) ?></td>
                                                <td>
                                                    <?php if($row->status == 0){ ?>
                                                        <span class="badge badge-pill badge-danger">Di Tolak Super Admin</span>
                                                    <?php } else if($row->status == 1){ ?>
                                                        <span class="badge badge-pill badge-warning">Menunggu Super Admin</span>
                                                    <?php } else if($row->status == 2){ ?>
                                                        <span class="badge badge-pill badge-success">Approved Super Admin</span>
                                                    <?php } else if($row->status == 3){ ?>
                                                        <span class="badge badge-pill badge-primary">Approved Accounting</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if(isset($cicil)){
                                                        $tercicil = 0;
                                                        foreach($cicil as $c){
                                                            if($c->status == 2){
                                                                $tercicil += $c->jml_pengajuan;
                                                            }
                                                        }
                                                        $sisa = $row->nilai - $tercicil;
                                                        if($sisa == 0){
                                                            $lunas = 'Lunas';
                                                        } else {
                                                            $lunas = 'Belum Lunas';
                                                        }
                                                    ?>
                                                        <span class="badge badge-secondary"><?= $lunas ?></span> <br>
                                                        <small class="text-success">(Terbayar: Rp. <?= number_format($tercicil) ?>)</small> <br>
                                                        <small class="text-danger">(Sisa: Rp. <?= number_format($sisa); ?>)</small>
                                                    <?php } else { ?>
                                                        -
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center">
                                                    

                                                    <?php if($group == 1){ ?>
                                                        <?php if($row->status == 1){ ?>
                                                            <button class="btn btn-xs btn-success approve" data-id="<?= $row->id ?>"><i class="fa fa-check"></i></button>
                                                            <button class="btn btn-xs btn-danger reject" data-id="<?= $row->id ?>"><i class="fa fa-times"></i></button>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php if($row->status == 0){ ?>
                                                            <button type="button" id="set_edit" class="btn btn-xs btn-secondary <?= $act ?>" data-id="<?= $row->id ?>" data-toggle="modal" data-target="#edit-pengajuan">
                                                            <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>

                                                            <button type="button" class="btn btn-xs btn-danger del <?= $act ?>" data-id="<?= $row->id ?>"><i class="fa fa-trash"></i></button>
                                                        <?php } ?>
                                                    <?php } ?>

                                                </td>
                                            </tr>
                                        <?php 
                                        }
                                        ?>
                                        </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

    <div class="modal fade" id="add-pengajuan">
        <div class="modal-dialog modal-md">
            <form role="form" method="POST">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-light">
                        <h5 class="modal-title"><i class="fa fa-plus-square"></i> Data Pengajuan Insidentil</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="tanggal_insidentil">Tanggal : </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="tanggal_insidentil" value="<?=date('Y-m-d')?>" class="form-control pull-right" id="tanggal_insidentil" required>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Pilih Proyek</label>
                                <select class="form-control" id="id_proyek" name="id_proyek" required>
                                    <option value="">-pilih-</option>
                                    <?php
                                        foreach ($proyek as $key => $kav) {
                                            echo '<option value="'.$kav->id.'">'.$kav->nama_proyek.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-sm-12">
                            <label>Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" placeholder="keterangan" required></textarea>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="harga_real">Nilai</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                    </div>
                                    <input type="text" name="nilai" autocomplete="off" id="nilai" class="form-control">
                                    <input type="text" name="nilaiA" id="nilaiA" class="form-control" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save" name="save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="edit-pengajuan">
        <div class="modal-dialog modal-md">
            <form role="form" method="POST">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-light">
                        <h5 class="modal-title"><i class="fa fa-plus-square"></i> Data Pengajuan Insidentil</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group col-sm-12">
                                <label for="tanggal_insidentil">Tanggal : </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="tanggal_insidentil_e" class="form-control pull-right" id="tanggal_insidentil_e" required>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Pilih Proyek</label>
                                <select class="form-control" id="id_proyek_e" name="id_proyek_e" required>
                                    <option value="">-pilih-</option>
                                    <?php
                                        foreach ($proyek as $key => $kav) {
                                            echo '<option value="'.$kav->id.'">'.$kav->nama_proyek.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-sm-12">
                            <label>Keterangan</label>
                            <textarea class="form-control" id="keterangan_e" name="keterangan_e" placeholder="keterangan" required></textarea>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="harga_real">Nilai</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                    </div>
                                    <input type="text" name="nilai_e" autocomplete="off" id="nilai_e" class="form-control">
                                    <input type="text" name="nilaiA_e" id="nilaiA_e" class="form-control" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="edit_save" name="edit_save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>