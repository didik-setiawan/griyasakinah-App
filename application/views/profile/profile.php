
<?php
    $user_avatar = $this->fungsi->user_login()->avatar;
    $username = $this->fungsi->user_login()->nama;
    $userStatus = $this->fungsi->user_login()->status;
    if($userStatus == 1){
        $statusUser = '<button class="btn btn-success btn-xs">active</button>'; 
    }else{
        $statusUser = '<button class="btn btn-danger btn-xs">disabled</button>';
    }
    if(!empty($user_avatar)){
    $user_avatar = base_url('uploads/img/').$user_avatar;
    } else {
    $user_avatar = base_url('assets/img/avatar.png');
    }
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card card-widget widget-user">
                    <div class="widget-user-header text-white"
                        style="background: url('<?=base_url('assets/adminlte3/dist/img/photo1.png')?>') center center;">
                        <h3 class="widget-user-username text-right text-uppercase"><?=$this->fungsi->user_login()->nama?></h3>
                        <h5 class="widget-user-desc text-right"><?=$this->fungsi->user_login()->nama_group?></h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="<?=$user_avatar?>" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header text-uppercase">Group User</h5>
                                    <span><?=$this->fungsi->user_login()->nama_group?></span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header text-uppercase">Status</h5>
                                    <?=$statusUser?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header text-uppercase">Last Login</h5>
                                    <?php
                                        $last_login = $this->master_model->cekHistory(userId(), idLembaga())->row();
                                    ?>
                                    <span class="description-text"><?=$last_login->last_login?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- <form enctype="multipart/form-data" id="update_profile" role="form" method="POST"> -->
                            <div class="row">
                                <div class="col-sm-4 form-group">Nama :</div>
                                <div class="col-sm-8 form-group">
                                    <input type="text" name="nama_user" value="<?=$this->fungsi->user_login()->nama?>" class="form-control" disabled>
                                </div>
                                <div class="col-sm-4 form-group">No Telp :</div>
                                <div class="col-sm-8 form-group">
                                    <input type="text" name="email_user" value="<?=$this->fungsi->user_login()->email?>" class="form-control" readonly>
                                </div>
                               

                                <div class="col-sm-12 text-center mt-3">
                                    <button class="btn btn-success edit-nama" data-name="<?=$this->fungsi->user_login()->nama?>"><i class="fa fa-user-edit"></i> Edit Nama</button>

                                    <button class="btn btn-primary edit-password"><i class="fa fa-key"></i> Edit Password</button>


                                    <button class="btn btn-dark edit-foto"><i class="fas fa-image"></i> Edit Foto</button>
                                </div>
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
</section>
<!-- /.content -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title titleModal" id="exampleModalLabel">Edit Akun</h5>
      </div>
      <form action="<?= site_url('profile/to_edit') ?>" enctype="multipart/form-data" method="post" id="form-edit">
      <div class="modal-body">

        <input type="hidden" name="id_user" id="id_user_edit" value="<?=$this->fungsi->user_login()->id?>">
        <input type="hidden" name="type" id="type_edit">


        <div class="form-group form-nama">
            <label>Nama</label>
            <input type="text" class="form-control" id="nama_edit" name="nama" value="<?=$this->fungsi->user_login()->nama?>">
            <small class="text-danger" id="err_nama"></small>
        </div>

        <div class="form-group form-new-pass">
            <label>Password Baru</label>
            <input type="password" name="new_pass" id="new_pass_edit" class="form-control">
            <small class="text-danger" id="err_pass"></small>
        </div>

        <div class="form-group form-retype-pass">
            <label>Re-type Password</label>
            <input type="password" name="re_pass" id="re_pass_edit" class="form-control">
            <small class="text-danger" id="err_re"></small>
        </div>


        <div class="form-group form-photo">
            <label>Upload Foto</label>
            <input type="file" name="img" id="img" class="form-control">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" id="to-save">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script>
function myFunction() {
  var x = document.getElementById("myInput");

  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }

}
</script>