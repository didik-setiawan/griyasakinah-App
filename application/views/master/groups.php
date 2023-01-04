<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Groups</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <?php
                            if(HakAkses(15)->create == 1){
                                echo '<button class="btn bg-gradient-primary btn-sm" data-toggle="modal" data-target="#add-group" id="add_group"><i class="fa fa-users"></i> ADD</button>';
                            }
                        ?>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-hover text-nowrap" id="example2">
                            <thead>
                                <tr class="bg-gradient-dark">
                                    <th class="text-center">#</th>
                                    <th>Nama Group</th>
                                    <th class="text-center">User</th>
                                    <th class="text-center">Durasi</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">
                                        <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    foreach ($list as $key => $row) {
                                        $group = $this->master_model->select_users_all(NULL, $row->id)->result();
                                        $cound_group = count($group);
                                        if(HakAkses(15)->update == 1){
                                            if(userId() != 1 && $row->id == 1){
                                                $status = 'disabled';
                                            }else{
                                                $status = NULL;
                                            }
                                        }else{
                                            $status = 'disabled';
                                        }
                                        if(HakAkses(15)->delete == 1){
                                            if(userId() != 1 && $row->id == 1){
                                                $statusD = 'disabled';
                                            }else{
                                                $statusD = NULL;
                                            }
                                        }else{
                                            $statusD = 'disabled';
                                        }
                                        ?>
                                            <tr>
                                                <td class="text-center"><?=$row->id?></td>
                                                <td><?=$row->group_name?></td>
                                                <td class="text-center"><?=$cound_group?> User</td>
                                                <td class="text-center"><?=$row->durasi_awal.' - '.$row->durasi_akhir?></td>
                                                <td class="text-center">
                                                    <button onclick="location.href='<?=site_url('users_groups/role_group/'.$row->id)?>'" class="btn btn-primary btn-sm" <?=$status?>><i class="fa fa-tasks"></i> Role</button>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="group_status" id="group_status" <?=$row->status == 1 ? 'checked' : NULL?> data-bootstrap-switch data-status_id="<?=$row->id?>" data-status_nama="<?=$row->group_name?>" data-off-color="secondary" data-on-color="success" <?=$status?>>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit-group" 
                                                        id="edit_group"
                                                        data-edit_id="<?=$row->id?>"
                                                        data-edit_nama_group="<?=$row->group_name?>"
                                                        data-edit_durasi_awal="<?=$row->durasi_awal?>"
                                                        data-edit_durasi_akhir="<?=$row->durasi_akhir?>"
                                                        <?=$status?>
                                                        ><i class="fa fa-pencil-alt"></i></button>
                                                        
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#del-group" 
                                                        id="del_group"
                                                        data-del_id="<?=$row->id?>"
                                                        data-del_nama_group="<?=$row->group_name?>"
                                                        <?=$statusD?>
                                                    ><i class="fa fa-times"></i></button>

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
</section>
<!-- /.content -->

<?php
if(HakAkses(15)->create == 1){
?>
<div class="modal fade" id="add-group">
    <form id="modal_add_group" role="form" method="POST">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h4 class="modal-title"><i class="fa fa-user-plus"></i> Add Group</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_group">Nama Group</label>
                        <input type="text" name="nama_group" id="nama_group" class="form-control" autofocus>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="add_save" id="add_save"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php } ?>

<?php
if(HakAkses(15)->update== 1){
?>
<div class="modal fade" id="edit-group">
    <form id="modal_edit_group" role="form" method="POST">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-success">
                    <h4 class="modal-title"><i class="fa fa-users"></i> Edit Group</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="edit_nama_group">Nama Group</label>
                            <input type="text" name="edit_nama_group" id="edit_nama_group" class="form-control">
                            <input type="hidden" id="edit_id" name="edit_id">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="durasi_awal">Durasi Awal</label>
                            <div class="input-group date" id="durasi_awal" data-target-input="nearest">
                                <input type="text" id="durasi_awal1" name="durasi_awal1" class="form-control datetimepicker-input" data-target="#durasi_awal">
                                <div class="input-group-append" data-target="#durasi_awal" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="durasi_akhir">Durasi Akhir</label>
                            <div class="input-group date" id="durasi_akhir" data-target-input="nearest">
                                <input type="text" id="durasi_akhir1" name="durasi_akhir1" class="form-control datetimepicker-input" data-target="#durasi_akhir">
                                <div class="input-group-append" data-target="#durasi_akhir" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="edit_group"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php } ?>

<?php
if(HakAkses(15)->delete == 1){
?>
<div class="modal fade" id="del-group">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger">
                <h4 class="modal-title"><i class="fa fa-times"></i> Delete Group</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body h5">
                <div class="form-group text-center">
                    <span>Nama Group : </span>
                    <span id="del_nama_group" class="text-bold"></span>
                    <input type="hidden" id="del_id">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="delete_group"><i class="fa fa-times"></i> Delete</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>
