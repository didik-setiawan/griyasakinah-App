<?php
    foreach ($list as $key => $row) {
        $group = $this->master_model->select_users_all(NULL, $row->id)->result();
        $cound_group = count($group);
        ?>
            <tr>
                <td class="text-center"><?=$row->id?></td>
                <td class="text-center"><?=$row->group_name?></td>
                <td class="text-center"><?=$cound_group?> User</td>
                <td class="text-center"><a href="<?=site_url('users_groups/role_group/'.$row->id)?>" class="btn btn-primary btn-sm"><i class="fa fa-tasks"></i> Role</a></td>
                <td class="text-center">
                    <input type="checkbox" name="group_status" id="group_status" <?=$row->status == 1 ? 'checked' : NULL?> data-bootstrap-switch data-status_id="<?=$row->id?>" data-status_nama="<?=$row->group_name?>" data-off-color="secondary" data-on-color="success">
                </td>
                <td class="text-center">
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit-group" 
                        id="edit_group"
                        data-edit_id="<?=$row->id?>"
                        data-edit_nama_group="<?=$row->group_name?>"
                        data-edit_durasi_awal="<?=$row->durasi_awal?>"
                        data-edit_durasi_akhir="<?=$row->durasi_akhir?>"
                        ><i class="fa fa-pencil-alt"></i></button>
                        
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#del-group" 
                        id="del_group"
                        data-del_id="<?=$row->id?>"
                        data-del_nama_group="<?=$row->group_name?>"
                    ><i class="fa fa-times"></i></button>

                </td>
            </tr>
        <?php
    }

?>
