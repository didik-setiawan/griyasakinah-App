<?php
if(HakAkses(15)->update != 1){
    redirect('dashboard/');
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
            <h1>Pilih Module untuk Group <b><?=$detail->group_name?></b></h1>
            <a href="<?=site_url('users_groups/groups/')?>" class="btn bg-gradient-warning shadow-sm btn-sm"><i class="fa fa-undo-alt"></i> kembali</a>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <form action="<?=site_url('users_groups/modules_save/')?>" method="post">
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <button class="btn bg-gradient-primary shadow float-right">Simpan</button>
                        <input type="hidden" name="role_group">
                        <input type="hidden" name="group_id" value="<?=$detail->id?>">
                        <span class="h4 text-warning">Groups : <?=$detail->group_name?></span><br>
                        Silahkan pilih MODUL yang dibutuhkan 
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <?php
                                // [7 data] $id $level $tipe $parent $aktif $url  $order 
                                $menu = $this->master_model->menu_modul(NULL, 1, NULL, NULL, NULL, NULL, NULL)->result(); 
                                foreach ($menu as $key => $row) {
                                    if($row->aktif == 1){
                                        $group_modul = $this->master_model->groupModul($detail->id, $row->id);
                                        if($group_modul->num_rows() > 0){
                                            $checked = 'checked';
                                            if($group_modul->row()->crud_create == 1){
                                                $input1 = 'checked';
                                            }else{
                                                $input1 = NULL;
                                            }
                                            if($group_modul->row()->crud_update == 1){
                                                $edit1 = 'checked';
                                            }else{
                                                $edit1 = NULL;
                                            }
                                            if($group_modul->row()->crud_delete == 1){
                                                $delete1 = 'checked';
                                            }else{
                                                $delete1 = NULL;
                                            }
                                        }else{
                                            $checked = NULL;
                                            $input1 = NULL;
                                            $edit1 = NULL;
                                            $delete1 = NULL;
                                        }
                                        ?>
                                            <div class="col-sm-12">
                                                <div class="card card-info collapsed-card">
                                                        <div class="card-header" data-card-widget="collapse">
                                                            <div class="card-tools float-left">
                                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                                                            </div>
                                                            <span class="text text-uppercase p-2"><?=$row->title?></span>
                                                            <div class="d-block float-right">
                                                                <input type="checkbox" name="modul<?=$row->id?>" id="modul<?=$row->id?>" <?=$checked?> data-bootstrap-switch data-off-color="white" data-on-color="dark">
                                                            </div>
                                                        </div>
                                                    <?php
                                                        if($row->aktif == 1){
                                                            echo '<div class="card-body" style="display: none;">';
                                                        }
                                                        $menu2 = $this->master_model->menu_modul(NULL, NULL, NULL, $row->id, NULL, NULL, 1); //$id = null, $level = NULL, $tipe = NULL, $parent = NULL, $aktif = NULL
                                                        if($menu2->num_rows() > 0){
                                                            foreach ($menu2->result() as $key => $parent) {
                                                                if($parent->aktif == 1){
                                                                    $group_modul2 = $this->master_model->groupModul($detail->id, $parent->id);
                                                                    if($group_modul2->num_rows() > 0){
                                                                        $checked2 = 'checked';
                                                                        if($group_modul2->row()->crud_create == 1){
                                                                            $input = 'checked';
                                                                        }else{
                                                                            $input = NULL;
                                                                        }
                                                                        if($group_modul2->row()->crud_update == 1){
                                                                            $edit = 'checked';
                                                                        }else{
                                                                            $edit = NULL;
                                                                        }
                                                                        if($group_modul2->row()->crud_delete == 1){
                                                                            $delete = 'checked';
                                                                        }else{
                                                                            $delete = NULL;
                                                                        }
                                                                    }else{
                                                                        $checked2 = NULL;
                                                                        $input = NULL;
                                                                        $edit = NULL;
                                                                        $delete = NULL;
                                                                    }
                            
                                                                    ?>
                                                                        <div class="form-group bg-gradient-light p-3">
                                                                            <div class="icheck-dark d-inline p-1">
                                                                                <input type="checkbox"  <?=$checked2?> id="modul<?=$parent->id?>" name="modul<?=$parent->id?>">
                                                                                <label for="modul<?=$parent->id?>" class="text-uppercase"><?=$parent->title?></label>
                                                                            </div>
                                                                            <div class="float-right">
                                                                                <div class="icheck-dark d-inline p-1">
                                                                                    <input type="checkbox" <?=$input?> id="input<?=$parent->id?>" name="input<?=$parent->id?>">
                                                                                    <label for="input<?=$parent->id?>">Input</label>
                                                                                </div>
                                                                                <div class="icheck-dark d-inline p-1">
                                                                                    <input type="checkbox" <?=$edit?> id="edit<?=$parent->id?>" name="edit<?=$parent->id?>">
                                                                                    <label for="edit<?=$parent->id?>">Edit</label>
                                                                                </div>
                                                                                <div class="icheck-dark d-inline p-1">
                                                                                    <input type="checkbox" <?=$delete?> id="delete<?=$parent->id?>" name="delete<?=$parent->id?>">
                                                                                    <label for="delete<?=$parent->id?>">Delete</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }else{
                                                            ?>
                                                                <div class="form-group bg-gradient-light p-3">
                                                                    <div class="float-right">
                                                                        <div class="icheck-dark d-inline p-1">
                                                                            <input type="checkbox" <?=$input1?> id="input<?=$row->id?>" name="input<?=$row->id?>">
                                                                            <label for="input<?=$row->id?>">Input</label>
                                                                        </div>
                                                                        <div class="icheck-dark d-inline p-1">
                                                                            <input type="checkbox" <?=$edit1?> id="edit<?=$row->id?>" name="edit<?=$row->id?>">
                                                                            <label for="edit<?=$row->id?>">Edit</label>
                                                                        </div>
                                                                        <div class="icheck-dark d-inline p-1">
                                                                            <input type="checkbox" <?=$delete1?> id="delete<?=$row->id?>" name="delete<?=$row->id?>">
                                                                            <label for="delete<?=$row->id?>">Delete</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php

                                                        }
                                                        if($row->aktif == 1){
                                                            echo '</div>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                }
                            ?>

                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn bg-gradient-primary shadow float-right" type="submit">Simpan</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <br>
        <br>
        <br>
    </div>
</section>
<!-- /.content -->