<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Users</h1>
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
                            if(HakAkses(14)->create == 1){
                                echo '<button class="btn bg-gradient-primary btn-sm" data-toggle="modal" id="add_user" data-target="#add-user"><i class="fa fa-user-plus"></i> ADD</button>';
                            }
                        ?>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-hover text-nowrap" id="userTable">
                            <thead>
                                <tr class="bg-gradient-dark">
                                    <th class="text-center">#</th>
                                    <th>Nama</th>
                                    <th>No Telp</th>
                                    <th>Group</th>
                                    <th>Access</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">
                                        <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($list as $key => $row) {
                                        if(HakAkses(14)->update == 1){
                                            if(userId() == 1 || groupId() == 1){
                                                if($row->id == 1 || !empty($row->sales_id)){
                                                    $statusU = 'disabled';
                                                }else{
                                                    $statusU = NULL;
                                                }
                                                if($row->id == 1 || $row->group_id == 1){
                                                    $statusU1 = 'disabled';
                                                }else{
                                                    $statusU1 = NULL;
                                                }
                                            }else{
                                                $statusU = NULL;
                                                $statusU1 = NULL;
                                            }
                                        }else{
                                            $statusU = 'disabled';
                                            $statusU1 = 'disabled';
                                        }
                                        if(HakAkses(14)->delete == 1){
                                            if(userId() == 1){
                                                $statusD = NULL;
                                            }else{
                                                if($row->group_id == 1){
                                                    $statusD = 'disabled';
                                                }else{
                                                    $statusD = NULL;
                                                }
                                            }
                                        }else{
                                            $statusD = 'disabled';
                                        }
            
                                        ?>
                                            <tr>
                                                <td class="text-center"><?=$row->id?></td>
                                                <td>
                                                    <span data-toggle="modal" id="view_detail" data-target="#view-detail" 
                                                        <?php
                                                            if(!empty($row->avatar)){
                                                                $gambar = base_url('uploads/img/').$row->avatar;
                                                            }else{
                                                                $gambar = base_url('assets/img/avatar.png');
                                                            }
                                                            if($row->status == 1){
                                                                $status = 'active';
                                                            }else{
                                                                $status = 'disable';
                                                            }
                                                        ?>
                                                        data-view_nama="<?=$row->nama?>" 
                                                        data-view_group="<?=$row->nama_group?>" 
                                                        data-view_email="<?=$row->email?>"
                                                        data-view_avatar="<?=$gambar?>"
                                                        data-view_status="<?=$status?>"
                                                        >
                                                        <button class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="View Detail">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </span>
                                                    &nbsp;<?=$row->nama?>
                                                </td>
                                                <td><?=$row->email?></td>
                                                
                                                <td>
                                                    <span data-toggle="modal" id="change_group" data-target="#change-group" 
                                                        data-change_id="<?=$row->id?>" 
                                                        data-change_nama="<?=$row->nama?>" 
                                                        data-change_group="<?=$row->nama_group?>" 
                                                        >
                                                        <button class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Change Groups" <?=$statusU?>>
                                                            <i class="fa fa-users"></i>
                                                        </button>
                                                    </span>
                                                    &nbsp;<?=$row->nama_group?> 
                                                </td>

                                                <!-- Akses -->
                                                <td>
                                                    <button class="btn btn-sm btn-info viewAccessPerum" data-id="<?= $row->id ?>" data-toggle="modal" data-target="#viewAccess">View Access</button>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox" name="users_status" id="users_status" <?=$row->status == 1 ? 'checked' : NULL?> 
                                                        data-bootstrap-switch data-off-color="secondary" 
                                                        data-on-color="success" 
                                                        data-status_id="<?=$row->id?>" 
                                                        data-status_nama="<?=$row->nama?>" 
                                                        data-status_nya="<?=$row->status?>"
                                                        <?=$statusU1?>
                                                    >
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-primary btn-sm" data-toggle="modal" id="edit_user" data-target="#edit-user" 
                                                        data-edit_id="<?=$row->id?>" 
                                                        data-edit_nama="<?=$row->nama?>" 
                                                        data-edit_group="<?=$row->nama_group?>" 
                                                        data-edit_email="<?=$row->email?>" 
                                                        <?=$statusU1?>
                                                    ><i class="fa fa-user-edit"></i></button>

                                                    <button class="btn btn-danger btn-sm" data-toggle="modal" id="delete_user" data-target="#delete-user" 
                                                        data-del_id="<?=$row->id?>" 
                                                        data-del_nama="<?=$row->nama?>" 
                                                        data-del_group="<?=$row->nama_group?>" 
                                                        data-del_email="<?=$row->email?>" 
                                                        <?=$statusD?>
                                                    ><i class="fa fa-user-times"></i></button>
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



<div class="modal fade" id="view-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info">
                <h4 class="modal-title"><i class="fa fa-user"></i> User Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-condensed table-striped">
                    <tr>
                        <td>Nama</td>
                        <td class="text-bold">: <span id="view_nama"></span></td>
                    </tr>
                    <tr>
                        <td>Group</td>
                        <td>: <span id="view_group"></span></td>
                    </tr>
                    <tr>
                        <td>No Telp</td>
                        <td>: <span id="view_email"></span></td>
                    </tr>
                    <tr>
                        <td colspan="2">Avatar :</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <img src="" id="view_avatar" class="shadow img-thumbnail img-rounded" style="width: 250px; height: 250px;" >
                        </td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>: <span class="badge badge-warning" id="view_status"></span></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="change-group">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h4 class="modal-title"><i class="fa fa-users"></i> Change Group</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Nama :</label>
                        <input type="text"id="change_nama" class="form-control" readonly>
                        <input type="hidden" id="change_id">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Group saat ini:</label>
                        <input type="text"id="change_group2" class="form-control" readonly>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Ganti Group :</label>
                        <select name="ganti_group" id="ganti_group" class="form-control">
                                <option value="0"> - Silahkan pilih - </option>
                            <?php
                                foreach ($group_list as $key => $grow) {
                                    if(groupId2() == 1){
                                        echo '<option value="'.$grow->id.'"> '.$grow->group_name.'</option>';
                                    }else{
                                        if($grow->id > 2) {
                                            echo '<option value="'.$grow->id.'"> '.$grow->group_name.'</option>';
                                        }
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="change_save"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-user">
    <div class="modal-dialog">
        <form id="modal_add_user" role="form" method="POST">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h4 class="modal-title"><i class="fa fa-user-plus"></i> Add User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <input type="text" id="add_nama"  name="add_nama" class="form-control" placeholder="Nama Lengkap" autofocus>
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="number" id="add_email" name="add_email" class="form-control" placeholder="No Telp">
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="password" id="add_password" name="add_password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="password" id="add_password2" name="add_password2" class="form-control" placeholder="re-type Password">
                        </div>
                        <div class="form-group col-sm-12">
                            <select id="add_group" name="add_group" class="form-control">
                                    <option value=""> - Silahkan pilih - </option>
                                <?php
                                    foreach ($group_list as $key => $grow) {
                                        echo '<option value="'.$grow->id.'"> '.$grow->group_name.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="add_users" name="add_users"><i class="fa fa-user-plus"></i> Add User</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-success">
                <h4 class="modal-title"><i class="fa fa-users"></i> Edit Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Nama :</label>
                        <input type="text" id="edit_nama" class="form-control" autofocus>
                        <input type="hidden" id="edit_id2">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>No Telp :</label>
                        <input type="email" id="edit_email" class="form-control" readonly>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Password :</label>
                        <input type="password" id="edit_password" class="form-control" placeholder="Password">
                        <small class="font-italic text-success">* minimal 8 huruf</small>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Re-type Password :</label>
                        <input type="password" id="edit_password2" class="form-control" placeholder="re-type Password">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Group :</label>
                        <input type="text" id="edit_group" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="edit_save"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger">
                <h4 class="modal-title"><i class="fa fa-user-times"></i> Delete Account</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-condensed table-striped">
                        <tr>
                            <td class="text-right">Nama</td>
                            <td>: <span id="del_nama" class="text-bold"></span></td>
                        </tr>
                        <tr>
                            <td class="text-right">No Telp</td>
                            <td>: <span id="del_email" class="text-bold"></span></td>
                        </tr>
                        <tr>
                            <td class="text-right">Group</td>
                            <td>: <span id="del_group" class="text-bold"></span></td>
                        </tr>
                    </table>
                    <input type="hidden" id="del_id">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="delete_save"><i class="fa fa-times"></i> Delete</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="viewAccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Akses Perumahan</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?= site_url('users_groups/access_perum'); ?>" method="post">
      <div class="modal-body">
            <input type="hidden" name="id_user" id="id_user">
            
               <table class="table table-bordered">
                   <thead>
                       <tr>
                           <th>Edit Akses</th>
                           <th>Akses Saat Ini</th>
                       </tr>
                       <tbody>
                           <tr>
                               <td>

                               <?php foreach($perum as $p){ ?>
                                    <div class="form-check">
                                        <input class="form-check-input check-perum" type="checkbox" id="inlineCheckbox<?= $p->id_perumahan; ?>" value="<?= $p->id_perumahan ?>" name="access_perum[]">
                                        <label class="form-check-label" for="inlineCheckbox<?= $p->id_perumahan; ?>"><?= $p->nama_perumahan ?></label>
                                    </div>
                                <?php } ?>

                               </td>

                               <td>
                                    <ul id="showAccess">

                                    </ul>
                               </td>

                           </tr>
                       </tbody>
                   </thead>
               </table>

                
            

      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="msg-scs" data-msg="<?=  $this->session->flashdata('scs'); ?>"></div>
<div class="msg-err" data-msg="<?=  $this->session->flashdata('err'); ?>"></div>