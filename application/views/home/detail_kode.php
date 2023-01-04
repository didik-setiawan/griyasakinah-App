<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-4">
                <div class="card-header bg-dark text-light">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="<?= site_url('home/kode'); ?>" class="btn btn-warning btn-xs text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <div class="text-center">
                                <b class="text-center">Detail Kode <?= $kode->deskripsi_kode ?></b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Sub Kode</button>
                        <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Title Kode</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        
                        <!-- Sub Kode -->
                        <button class="btn btn-sm btn-primary mt-3 mb-3 add-sub"><i class="fa fa-plus"></i> Tambah</button>

                        <table class="table table-bordered" id="table1">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th width="13%">Sub Kode</th>
                                    <th>Deskripsi</th>
                                    <th width="10%"><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($sub_kode as $sk){ ?>
                                <tr>
                                    <td><?= $sk->sub_kode ?></td>
                                    <td><?= $sk->deskripsi_sub_kode ?></td>
                                    <td>
                                        <button class="btn btn-xs btn-success edit-sub" data-id="<?= $sk->id_sub ?>"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-xs btn-danger del-sub" data-id="<?= $sk->id_sub ?>"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <!-- title Kode -->
                        <button class="mt-3 mb-3 btn btn-primary add-title btn-sm"><i class="fa fa-plus"></i> Tambah</button>

                        <table class="table table-bordered" id="table2">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th width="13%">Kode Title</th>
                                    <th>Sub Kode</th>
                                    <th>Deskripsi</th>
                                    <th width="13%"><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($title_kode as $tk){ ?>
                                <tr>
                                    <td><?= $tk->kode_title ?></td>
                                    <td><?= $tk->deskripsi_sub_kode ?></td>
                                    <td><?= $tk->deskripsi ?></td>
                                    <td>
                                        <button class="btn btn-xs btn-success edit-title" data-id="<?= $tk->id_title ?>"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-xs btn-danger delete-title" data-id="<?= $tk->id_title ?>"><i class="fa fa-trash"></i></button>
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
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalSub" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title title1" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="formSub">
      <div class="modal-body">
        <input type="hidden" name="id_kode" id="id_kode" value="<?= $kode->id_kode ?>">
        <input type="hidden" name="id_sub" id="id_sub">
        <div class="form-group">
            <label>Sub Kode</label>
            <input type="text" name="sub" id="sub" class="form-control">
            <small class="text-danger" id="err_sub"></small>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" name="desc" id="desc" class="form-control">
            <small class="text-danger" id="err_desc"></small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalTitle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title title2" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="formTitle">
      <div class="modal-body">
        <input type="hidden" name="id_title" id="id_title">
        <div class="form-group">
            <label>Sub Kode</label>
            <select name="sub_kode" id="sub_kode" class="form-control">
                <option value="">Pilih</option>
                <?php foreach($sub_kode as $s){ ?>
                    <option value="<?= $s->id_sub ?>"><?= $s->deskripsi_sub_kode ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Kode Title</label>
            <input type="text" name="title" id="title" class="form-control">
            <small class="text-danger" id="err_title"></small>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" name="desc" id="desc_title" class="form-control">
            <small class="text-danger" id="err_desc"></small>
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
    $('#table1').dataTable();
    $('#table2').dataTable();

    $('.add-sub').click(function(){
        $('#modalSub').modal('show');
        $('.title1').html('Tambah Sub Kode');
        $('#formSub').attr('action','<?= site_url('accounting/add_sub_kode'); ?>');
        $('#sub').val('');
        $('#desc').val('');
    });

    $('.edit-sub').click(function(){
        $('#modalSub').modal('show');
        $('.title1').html('Edit Sub Kode');
        $('#formSub').attr('action','<?= site_url('accounting/edit_sub_kode'); ?>');
        const id = $(this).data('id');

        $.ajax({
            url: '<?= site_url('accounting/get_sub_kode_id'); ?>',
            data: {id:id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                $('#id_sub').val(id);
                $('#sub').val(d.sub_kode);
                $('#desc').val(d.deskripsi_sub_kode);
            }
        });

    });

    $('.del-sub').click(function(d){
        const id = $(this).data('id');

        Swal.fire({
        title: 'Apakah Anda Yakin',
        text: "Untuk menghapus data ini",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= site_url('accounting/del_sub_kode'); ?>',
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

    $('#formSub').submit(function(e){
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                if(d.type == 'err_validation'){
                    if(d.err_sub == ''){
                        $('#err_sub').html('');
                    } else {
                        $('#err_sub').html(d.err_sub);
                    }

                    if(d.err_desc == ''){
                        $('#err_desc').html('');
                    } else {
                        $('#err_desc').html(d.err_desc);
                    }
                }  else if(d.type == 'result'){
                    if(d.success == true){
                    $('#modalSub').modal('hide');
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




    $('.add-title').click(function(){
        $('#modalTitle').modal('show');
        $('.title2').html('Tambah Title');
        $('#formTitle').attr('action','<?= site_url('accounting/add_title') ?>');
        $('#sub_kode').val('');
        $('#sub_kode').attr('required', true);
        $('#title').val('');
        $('#desc_title').val('');
    });

    $('.edit-title').click(function(){
        $('#modalTitle').modal('show');
        $('.title2').html('Edit Title');
        $('#formTitle').attr('action','<?= site_url('accounting/edit_title') ?>');
        $('#sub_kode').attr('required', true);
        const id = $(this).data('id');

        $.ajax({
            url: '<?= site_url('accounting/get_ajax_title'); ?>',
            data: {id:id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                $('#id_title').val(id);
                $('#title').val(d.kode_title);
                $('#desc_title').val(d.deskripsi);
                $('#sub_kode').val(d.id_sub);
            }
        });
    });

    $('.delete-title').click(function(){
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
                    url: '<?= site_url('accounting/del_title_kode'); ?>',
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


    $('#formTitle').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                if(d.type == 'validation'){
                    if(d.err_title == ''){
                        $('#err_title').html('');
                    } else {
                        $('#err_title').html(d.err_title);
                    }

                    if(d.err_desc == ''){
                        $('#err_desc').html('');
                    } else {
                        $('#err_desc').html(d.err_desc);
                    }
                } else if(d.type == 'result'){
                    if(d.success == true){
                            $('#modalTitle').modal('hide');
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

</script>