<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-4">
                <div class="card-body">
                    <h4>Management User Group</h4>

                    <a href="<?= site_url('home'); ?>" class="mt-3 mb-3 btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
                    <button class="btn btn-sm btn-success add-group mt-3 mb-3"><i class="fa fa-plus"></i> Tambah</button>

                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th>Nama Group</th>
                                <th width="20%">Status</th>
                                <th width="13%"><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($group as $g){ ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $g->group_name ?></td>
                                <td class="text-center">

                                <?php if($g->id == 1){ ?>
                                    <div class="form-check">
                                        <input class="form-check-input setStatus" data-id="<?= $g->id ?>" type="checkbox" value="2" checked disabled>
                                        <label class="form-check-label">
                                            Aktif
                                        </label>
                                    </div>
                                <?php } else { ?>

                                    <?php if($g->status == 1){ ?>
                                        <div class="form-check">
                                            <input class="form-check-input setStatus" data-id="<?= $g->id ?>" type="checkbox" value="2" checked>
                                            <label class="form-check-label">
                                                Aktif
                                            </label>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-check">
                                            <input class="form-check-input setStatus" data-id="<?= $g->id ?>" type="checkbox" value="1">
                                            <label class="form-check-label">
                                                Nonaktif
                                            </label>
                                        </div>
                                    <?php } ?>

                                <?php } ?>

                                

                                </td>
                                <td>
                                    <button class="btn btn-xs btn-primary btn-edit" data-id="<?= $g->id ?>"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-xs btn-danger btn-delete" data-id="<?= $g->id ?>"><i class="fa fa-trash"></i></button>
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="formGroup">
      <div class="modal-body">
        
        <input type="hidden" name="id_group" id="id_group">
        <div class="form-group">
            <label>Nama Group</label>
            <input type="text" name="group_name" id="group_name" class="form-control">
            <small class="text-danger" id="err_group"></small>
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
    $('#dataTable').dataTable();

    $('.add-group').click(function(){
        $('#exampleModal').modal('show');
        $('.modal-title').html('Tambah Group');
        $('#formGroup').attr('action','<?= site_url('users_groups/add_group'); ?>');
        $('#group_name').val('');
    });


    $('.btn-edit').click(function(){
        $('#exampleModal').modal('show');
        $('.modal-title').html('Edit Group');
        $('#formGroup').attr('action','<?= site_url('users_groups/edit_group'); ?>');
        const id = $(this).data('id');

        $.ajax({
            url: '<?= site_url('users_groups/get_group_ajax'); ?>',
            data: {id:id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                $('#id_group').val(id);
                $('#group_name').val(d.group_name);
            }
        });

    });

    $('#formGroup').submit(function(e){
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                if(d.type == 'validation'){
                    if(d.err_group == ''){
                        $('#err_group').html('');
                    } else {
                        $('#err_group').html(d.err_group);
                    }
                } else if(d.type == 'result'){
                    if(d.success == true){
                        $('#exampleModal').modal('hide');
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


    $('.setStatus').click(function(){

        const id = $(this).data('id');
        const val = $(this).val();
        
        $.ajax({
            url: '<?= site_url('users_groups/set_status_group'); ?>',
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


        $('.btn-delete').click(function(){
            const id = $(this).data('id');

            Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Untuk menghapus data ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    
                    $.ajax({
                        url: '<?= site_url('users_groups/delete_group'); ?>',
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

</script>