<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-4">
                <div class="card-body">
                    <h4>Management Kode</h4>
                    <a href="<?= site_url('home'); ?>" class="mb-3 btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i>Kembali</a>
                    <button class="btn btn-sm mb-3 btn-success add-code"><i class="fa fa-plus"></i> Tambah Kode</button>
                    
                    <table class="table table-bordered" id="tableKode">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th width="7%">Kode</th>
                                <th>Deskripsi Kode</th>
                                <th width="13%"><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($kode as $k){ ?>
                            <tr>
                                <td><?= $k->kode ?></td>
                                <td><?= $k->deskripsi_kode ?></td>
                                <td>
                                    <button class="btn btn-xs edit-code btn-primary" data-id="<?= $k->id_kode ?>"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-xs btn-danger delete-code" data-id="<?= $k->id_kode ?>"><i class="fa fa-trash"></i></button>
                                    <a href="<?= site_url('home/detail_kode/') . $k->id_kode; ?>" class="btn btn-xs btn-dark"><i class="fas fa-search"></i></a>
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


<!-- Modal code-->
<div class="modal fade" id="modalCode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title codeTitle" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="formKode">
      <div class="modal-body">
        <input type="hidden" name="id" id="id_kode" class="form-control">
        <div class="form-group">
            <label>Kode</label>
            <input type="text" name="kode" id="kode" class="form-control">
            <small class="text-danger" id="err_kode"></small>
        </div>
        <div class="form-group">
            <label>Deskripsi Kode</label>
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











<script>
    $('#tableKode').dataTable();
                                
    $('.add-code').click(function(){
        $('#modalCode').modal('show');
        $('.codeTitle').html('Tambah Kode');
        $('#formKode').attr('action','<?= site_url('accounting/add_kode'); ?>');
        $('#kode').val('');
        $('#desc').val('');
    });

    $('.edit-code').click(function(){
        $('#modalCode').modal('show');
        $('.codeTitle').html('Edit Kode');
        $('#formKode').attr('action','<?= site_url('accounting/edit_kode'); ?>');
        const id = $(this).data('id');

        $.ajax({
            url: '<?= site_url('accounting/get_kode_id') ?>',
            data: {id:id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                $('#kode').val(d.kode);
                $('#desc').val(d.deskripsi_kode);
                $('#id_kode').val(id);
            }
        });

        
    });

    $('.delete-code').click(function(){
        const id = $(this).data('id');


        Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Untuk menghapus data ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= site_url('accounting/del_kode'); ?>',
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

    $('#formKode').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                if(d.type == 'err_validation'){
                    if(d.err_kode == ''){
                        $('#err_kode').html('');
                    } else {
                        $('#err_kode').html(d.err_kode);
                    }

                    if(d.err_desc == ''){
                        $('#err_desc').html('');
                    } else {
                        $('#err_desc').html(d.err_desc);
                    }
                } else if(d.type == 'result'){
                    $('#err_kode').html('');
                    $('#err_desc').html('');

                    if(d.success == true){
                        $('#exampleModal').modal('show');
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