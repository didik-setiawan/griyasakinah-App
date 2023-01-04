<!-- Content Header (Page header) -->
<!-- <img src="<?= base_url() ?>assets/img/siteplan/Screenshot_4.png" alt="Workplace" usemap="#Screenshot_4.png" > -->
<map name="Screenshot_4.png" id="Screenshot_4.png">
	<area shape="poly" coords="264,446,366,450,365,489,261,484,264,446" href="computer.htm" alt=""  />
	<area shape="poly" coords="268,402,372,404,366,450,264,446,268,402" href="computer.htm"alt=""  />
	<area shape="poly" coords="272,359,377,363,372,404,268,402,272,359" href="computer.htm" alt=""  />
	<area shape="poly" coords="277,316,378,323,377,363,272,359,277,316" href="computer.htm" alt=""  />
	<area shape="poly" coords="280,274,382,280,378,323,277,316,280,274" href="computer.htm" alt=""  />
	<area shape="poly" coords="165,440,264,446,261,484,159,482,165,440" href="computer.htm" alt=""  />
	<area shape="poly" coords="163,400,268,402,264,446,165,440,163,400" nohref alt=""  />
	<area shape="poly" coords="168,358,272,359,268,402,163,400,168,358" nohref alt=""  />
	<area shape="poly" coords="173,310,277,316,272,359,168,358,173,310" nohref alt=""  />
	<area shape="poly" coords="178,270,280,274,277,316,173,310,178,270" nohref alt=""  />
	<area shape="poly" coords="183,228,285,234,280,274,178,270,183,228" nohref alt=""  />
	<area shape="poly" coords="285,234,388,237,382,280,280,274,285,234" nohref alt=""  />
	<area shape="poly" coords="287,187,390,197,388,237,285,234,287,187" nohref alt=""  />
	<area shape="poly" coords="184,186,287,187,285,234,183,228,184,186" nohref alt=""  />
	<area shape="poly" coords="290,146,396,157,390,197,287,187,290,146" nohref alt=""  />
	<area shape="poly"  onmouseover="this.focus();" href="#" onmouseout="this.blur();" data-toggle="modal" id="edit_user" data-target="#add-map"  style='background-color:pink;' coords="188,138,290,146,287,187,184,186,183,185,185,183,185,183,188,138"  alt=""  />
</map>
<script>
function ok() {
  data-toggle="modal" id="edit_user" data-target="#edit-user" 
}
</script>


<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Data Perumahan</h1>
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
                        <table class="table table-striped table-hover text-nowrap" id="users_list">
                            <thead>
                                <tr class="bg-gradient-dark">
                                    <th class="text-center">#</th>
                                    <th>Nama</th>
                                  
                                    <th class="text-center">
                                        <i class="fa fa-cogs" data-toggle="tooltip" data-placement="left" title="Action"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($list as $key => $row) {
                                    
            
                                        ?>
                                            <tr>
                                                <td class="text-center"><?=$row->id_perumahan?></td>
                                                <td>
                                                    <span data-toggle="modal" id="view_detail" data-target="#view-detail" 
                                                        
                                                        <button class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="View Detail">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </span>
                                                    &nbsp;<?=$row->nama_perumahan?>
                                                </td>
                                                
                                             
                                              
                                                <td class="text-center">
                                                    <button class="btn btn-primary btn-sm" data-toggle="modal" id="edit_user" data-target="#edit-user" 
                                                        data-edit_id="<?=$row->id_perumahan?>" 
                                                        data-edit_nama="<?=$row->nama_perumahan?>" 
                                                        
                                                     
                                                    ><i class="fa fa-user-edit"></i></button>

                                                    <button class="btn btn-danger btn-sm" data-toggle="modal" id="delete_user" data-target="#delete-user" 
                                                        data-del_id="<?=$row->id_perumahan?>" 
                                                        data-del_nama="<?=$row->nama_perumahan?>" 
                                                        
                                                      
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
                        <td>Email</td>
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
                            <input type="email" id="add_email" name="add_email" class="form-control" placeholder="Enter email">
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

<div class="modal fade" id="add-map">
    <div class="modal-dialog">
        <form id="modal_add_user" role="form" method="POST">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h4 class="modal-title"><i class="fa fa-user-plus"></i> Info Data Kavling</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <input type="text" id="add_nama"  name="add_nama" class="form-control" placeholder="Blok Kavling" autofocus>
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="text" id="add_email" name="add_email" class="form-control" placeholder="Spesifikasi">
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="text" id="add_password" name="add_password" class="form-control" placeholder="Luas">
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="text" id="add_password2" name="add_password2" class="form-control" placeholder="Keterangan">
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
                    <button type="submit" class="btn btn-primary" id="add_users" name="add_users"><i class="fa fa-user-plus"></i> Tambah Kavling</button>
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
                        <label>Email :</label>
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
                            <td class="text-right">Email</td>
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

