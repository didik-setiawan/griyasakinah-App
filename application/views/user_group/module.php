<?php 
checkUserLogin();
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Modules</h1>
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
                        <h3 class="card-title">Silahkan pilih MODUL yang dibutuhkan</h3>
                        <?php
                            if(HakAkses(16)->create == 1){
                                echo '<button class="btn bg-gradient-primary shadow float-right" type="submit">Simpan</button>';
                            }
                            if(HakAkses(16)->update == 1){
                                $status = NULL;
                            }else{
                                $status = 'disabled';
                            }
                        ?>
                        <input type="hidden" name="proses">
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <?php
                                // [7 data] $id $level $tipe $parent $aktif $url  $order 
                                $menu = $this->master_model->menu_modul(NULL, 1, NULL, NULL, NULL, NULL, NULL)->result(); 
                                foreach ($menu as $key => $row) {
                                    ?>
                                        <div class="col-sm-12">
                                            <div class="card card-info collapsed-card">
                                                <?php
                                                    if($row->parent == 0){
                                                        ?>
                                                            <div class="card-header">
                                                                <span class="text text-uppercase p-2"><?=$row->title?></span>
                                                                <div class="d-block float-right">
                                                                    <input type="checkbox" name="modul<?=$row->id?>" id="modul<?=$row->id?>" <?=$row->aktif == 1 ? 'checked' : NULL ?> data-bootstrap-switch data-off-color="white" data-on-color="dark" <?=$status?>>
                                                                </div>
                                                            </div>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <div class="card-header" data-card-widget="collapse">
                                                                <div class="card-tools float-left">
                                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                                                                </div>
                                                                <span class="text text-uppercase p-2"><?=$row->title?></span>
                                                                <div class="d-block float-right">
                                                                    <input type="checkbox" name="modul<?=$row->id?>" id="modul<?=$row->id?>" <?=$row->aktif == 1 ? 'checked' : NULL ?> data-bootstrap-switch data-off-color="white" data-on-color="dark" <?=$status?>>
                                                                </div>
                                                            </div>
                                                        <?php
                                                    }
                                                    if($row->parent == 999){
                                                        echo '<div class="card-body" style="display: none;">';
                                                    }
                                                    $menu2 = $this->master_model->menu_modul(NULL, NULL, NULL, $row->id, NULL, NULL, 1); //$id = null, $level = NULL, $tipe = NULL, $parent = NULL, $aktif = NULL
                                                    if($menu2->num_rows() > 0){
                                                        foreach ($menu2->result() as $key => $parent) {
                                                            ?>
                                                                <div class="form-group bg-gradient-light p-3">
                                                                    <div class="icheck-dark d-inline p-1">
                                                                        <input type="checkbox" <?=$parent->aktif == 1 ? 'checked' : NULL ?> id="modul<?=$parent->id?>" name="modul<?=$parent->id?>" <?=$status?>>
                                                                        <label for="modul<?=$parent->id?>" class="text-uppercase"><?=$parent->title?></label>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                        }
                                                    }
                                                    if($row->parent == 999){
                                                        echo '</div>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>

                        </div>
                    </div>
                    <div class="card-footer">
                        <?php
                            if(HakAkses(16)->create == 1){
                                echo '<button class="btn bg-gradient-primary shadow float-right" type="submit">Simpan</button>';
                            }
                        ?>

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