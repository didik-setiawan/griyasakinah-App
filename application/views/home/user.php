<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-4">
                <div class="card-body">
                    <h4>Management User</h4>
                    <a href="<?= site_url('home'); ?>" class="mb-3 mt-3 btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
                    <button class="mt-3 mb-3 btn btn-sm btn-success add-user"><i class="fa fa-plus"></i> Tambah</button>

                    <table class="table table-bordered" id="tableUser">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th>Nama</th>
                                <th>No Telp</th>
                                <th>Group</th>
                                <th>Access</th>
                                <th>Status</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($user as $u){ ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $u->nama ?></td>
                                <td><?= $u->email ?></td>
                                <td><button class="btn btn-xs btn-success btn-group"
                                    <?php if($u->group_id == 1){ ?>
                                        disabled
                                    <?php } ?> 
                                data-group="<?= $u->group_id ?>"
                                data-id="<?= $u->id ?>"
                                data-nama="<?= $u->nama ?>"
                                ><i class="fas fa-users"></i></button> <?= $u->nama_group ?></td>
                                <td><button class="btn btn-xs btn-info btn-access" data-id="<?= $u->id ?>" 
                                    <?php if($u->group_id == 1){ ?>
                                        disabled
                                    <?php } ?>
                                >View Access</button></td>
                                <td>

                                <?php if($u->group_id == 1){ ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled checked>
                                        <label class="form-check-label">
                                            Aktif
                                        </label>
                                    </div>
                                <?php } else { ?>

                                    <?php if($u->status == 1){ ?>

                                    <div class="form-check">
                                        <input class="form-check-input check-status" data-id="<?= $u->id ?>" type="checkbox" value="2" checked>
                                        <label class="form-check-label">
                                            Aktif
                                        </label>
                                    </div>
                                    <?php } else { ?>
                                    <div class="form-check">
                                        <input class="form-check-input check-status" data-id="<?= $u->id ?>" type="checkbox" value="1">
                                        <label class="form-check-label">
                                            Nonaktif
                                        </label>
                                    </div>
                                    <?php } ?>

                                <?php } ?>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-primary btn-edit" data-id="<?= $u->id ?>"
                                    <?php if($u->group_id == 1){ ?>
                                        disabled
                                    <?php } ?> 
                                    >
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-xs btn-danger btn-delete" data-id="<?= $u->id ?>"
                                    <?php if($u->group_id == 1){ ?>
                                        disabled
                                    <?php } ?> 
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title titleUser" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" id="formUser" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_user" id="id_user">
        <div class="form-group">
            <label>Nama User</label>
            <input type="text" name="user" id="user" class="form-control">
            <small class="text-danger" id="err_user"></small>
        </div>
        <div class="form-group">
            <label>No Telp</label>
            <input type="text" name="telp" id="telp" class="form-control">
            <small class="text-danger" id="err_telp"></small>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="pass1" id="pass1" class="form-control">
            <small class="text-danger" id="err_pass1"></small>
        </div>
        <div class="form-group">
            <label>Re-type Password</label>
            <input type="password" name="pass2" id="pass2" class="form-control">
            <small class="text-danger" id="err_pass2"></small>
        </div>
        <div class="form-group">
            <label>Group</label>
            <select name="group" id="group" class="form-control" required>
                <option value="">--Pilih--</option>
                <?php foreach($group as $gr){ ?>
                    <option value="<?= $gr->id ?>"><?= $gr->group_name ?></option>
                <?php } ?>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- modal access -->
<div class="modal fade" id="modalAccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Akses Perumahan</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('users_groups/access_perum') ?>" method="post" id="formAccess">
      <div class="modal-body">
        <input type="hidden" name="id_user" id="id_user2">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>List Akses</th>
                    <th>Akses saat ini</th>
                </tr>
            </thead>
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
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm saveAccess">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal edit group-->
<div class="modal fade" id="modalGroup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Edit Group</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('users_groups/change_group'); ?>" id="formGroup" method="post">
      <div class="modal-body">
                            
        <input type="hidden" name="id_user" id="id_user3">

        <div class="form-group">
            <label>Nama User</label>
            <input type="text" name="user" id="user2" disabled class="form-control">
        </div>

        <div class="form-group">
            <label>Group</label>
            <select name="group" required id="group2" class="form-control">
                <option value="">--Pilih--</option>
                <?php foreach($group as $g){ ?>
                    <option value="<?= $g->id ?>"><?= $g->group_name ?></option>
                <?php } ?>
            </select>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script>
    $('#tableUser').dataTable();
    $('.add-user').click(function(){
        $('#modalUser').modal('show');
        $('.titleUser').html('Tambah User');
        $('#formUser').attr('action','<?= site_url('users_groups/add_user'); ?>');

        $('#user').val('');
        $('#telp').val('');
        $('#pass1').val('');
        $('#pass2').val('');
        $('#group').val('');

        $('#group').removeAttr('disabled');
        $('#group').attr('required', true);
    });


    $('.btn-edit').click(function(){
        const id = $(this).data('id');
        $('#modalUser').modal('show');
        $('.titleUser').html('Edit User');
        $('#formUser').attr('action','<?= site_url('users_groups/edit_user'); ?>');

        $('#group').attr('disabled', true);
        $('#group').removeAttr('required');

        $.ajax({
            url: '<?= site_url('users_groups/get_ajax_user'); ?>',
            data: {id:id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                $('#id_user').val(id);
                $('#user').val(d.nama);
                $('#telp').val(d.email);
                $('#group').val(d.group_id);
            }
        });

    });

    $('.btn-delete').click(function(){
        const id = $(this).data('id');


        Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Untuk menghapus data user ini",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= site_url('users_groups/delete_user') ?>',
                    data: {id:id},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(d){

                        if(d.success == true){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: d.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setInterval(() => {
                                    location.reload();
                                }, 1600);
                        } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: d.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                        }

                    }
                });
            }
        })


        
    });


    $('#formUser').submit(function(e){
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){

                if(d.type == 'validation'){

                    if(d.err_user == ''){
                        $('#err_user').html('');
                    } else {
                        $('#err_user').html(d.err_user);
                    }

                    if(d.err_telp == ''){
                        $('#err_telp').html('');
                    } else {
                        $('#err_telp').html(d.err_telp);
                    }
                    
                    if(d.err_pass1 == ''){
                        $('#err_pass1').html('');
                    } else {
                        $('#err_pass1').html(d.err_pass1);
                    }

                    if(d.err_pass2 == ''){
                        $('#err_pass2').html('');
                    } else {
                        $('#err_pass2').html(d.err_pass2);
                    }

                } else if(d.type == 'result'){

                    if(d.success == true){
                        $('#modalUser').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setInterval(() => {
                            location.reload();
                        }, 1600);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                }

            }   
        });

    });


    $('.btn-access').click(function(){
        const id = $(this).data('id');
        $('.saveAccess').attr('disabled', true);
        $('#modalAccess').modal('show');
        $.ajax({
            url: '<?= site_url('users_groups/get_access'); ?>',
            data: {id:id},
            type: 'POST',
            success: function(d){
                $('#id_user2').val(id);
                $('#showAccess').html(d);
            }
        });
    });


    $('.check-perum').change(function(){
        if($(this).prop('checked')){
            $('.saveAccess').removeAttr('disabled');
        } else {    
            $('.saveAccess').attr('disabled', true);
        }
    });
    

    $('#formAccess').submit(function(e){
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){

                if(d.success == true){
                    $('#modalAccess').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setInterval(() => {
                            location.reload();
                        }, 1600);
                } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                }

            }
        });

    });


    $('.btn-group').click(function(){
        const nama = $(this).data('nama');
        const id = $(this).data('id');
        const group = $(this).data('group');
        $('#user2').val(nama);
        $('#group2').val(group);
        $('#id_user3').val(id);
        $('#modalGroup').modal('show');
    });


    $('#formGroup').submit(function(e){
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                if(d.success == true){
                        $('#modalGroup').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setInterval(() => {
                            location.reload();
                        }, 1600);
                } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                }
            }
        });

    });

    $('.check-status').click(function(){

        const id = $(this).data('id');
        const val = $(this).val();

        $.ajax({
            url: '<?= site_url('users_groups/set_status_user'); ?>',
            data: {
                id:id,
                val:val
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                if(d.success == true){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setInterval(() => {
                            location.reload();
                        }, 1600);
                } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                }
            }
        });
    });

</script>