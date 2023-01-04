<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-4">
                <div class="card-body">
                    <h4>Management Perumahan</h4>
                    <a href="<?= site_url('home'); ?>" class="btn btn-sm btn-warning mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>
                    <button class="btn btn-sm btn-success btn-add mb-3"><i class="fa fa-plus"></i> Tambah</button>


                    <table class="table table-bordered mt-3" id="tablePerum">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th>Nama Perumahan</th>
                                <th>Kota</th>
                                <th>Alamat</th>
                                <th>Cluster</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($perum as $p){ ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $p->nama_perumahan ?></td>
                                <td><?= $p->kabupaten ?></td>
                                <td><?= $p->alamat_perumahan ?></td>
                                <td>
                                    <?php if($p->cluster == 0){
                                        echo "Tidak Ada";
                                    } else if($p->cluster == 1) {
                                        echo "Ada";
                                    }    
                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-primary btn-edit" data-id="<?= $p->id_perumahan ?>"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-xs btn-danger btn-delete" data-id="<?= $p->id_perumahan ?>"><i class="fa fa-trash"></i></button>
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
      <form action="" enctype="multipart/form-data" method="post" id="formPerum">
      <div class="modal-body">
        <input type="hidden" name="id_perum" id="id_perum">
        <div class="form-group">
            <label>Nama Perumahan</label>
            <input type="text" name="nama" id="nama" class="form-control">
            <small class="text-danger" id="err_nama"></small>
        </div>
        <div class="form-group">
            <label>Kota</label>
            <input type="text" name="kota" id="kota" class="form-control">
            <small class="text-danger" id="err_kota"></small>
        </div>
        <div class="form-group">
            <label>Alamat Perumahan</label>
            <input type="text" name="alamat" id="alamat" class="form-control">
            <small class="text-danger" id="err_alamat"></small>
        </div>
        <div class="form-group">
            <label>Cluster Perumahan</label>
            <select name="cluster" id="cluster" class="form-control">
                <option value="">--Pilih--</option>
                <option value="0">Tidak Ada</option>
                <option value="1">Ada</option>
            </select>
        </div>
        <div class="form-group">
            <label>Logo Perumahan</label>
            <input type="file" name="logo" id="logo" class="form-control">
        </div>


        <div class="show-logo">
            <div class="form-group">
                <label>Logo Perumahan</label>
                <img src="" width="100%" id="logo-perum" alt="logo">
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" id="submitModal">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script>
    $('#tablePerum').dataTable();

    $('.btn-add').click(function(){
        $('#exampleModal').modal('show');
        $('#formPerum').attr('action','<?= site_url('master/add_perum'); ?>');
        $('.modal-title').html('Tambah Perumahan');
        $('#nama').val('');
        $('#kota').val('');
        $('#alamat').val('');
        $('#cluster').val('');
        $('#logo').val('');

        $('#cluster').attr('required', true);
        $('#logo').attr('required', true);
        $('.show-logo').addClass('d-none');
    });

    $('.btn-edit').click(function(){
        const id = $(this).data('id');
        $('#exampleModal').modal('show');
        $('#formPerum').attr('action','<?= site_url('master/edit_perum'); ?>');
        $('.modal-title').html('Edit Perumahan');
        $('#cluster').attr('required', true);
        $('.show-logo').removeClass('d-none');

        $.ajax({
            url: '<?= site_url('master/get_perum_ajax'); ?>',
            data: {id:id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                $('#id_perum').val(id);
                $('#nama').val(d.nama_perumahan);
                $('#kota').val(d.kabupaten);
                $('#alamat').val(d.alamat_perumahan);
                $('#cluster').val(d.cluster);
                $('#logo-perum').attr('src','<?= base_url('assets/img/'); ?>' + d.logo);
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
                    url: '<?= site_url('master/del_perum'); ?>',
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

    $('#formPerum').submit(function(e){
        e.preventDefault();

        $('#submitModal').attr('disabled', true);
        $('#submitModal').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Save');

        $.ajax({
            url: $(this).attr('action'),
            data: new FormData(this),
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(d){


                $('#submitModal').removeAttr('disabled');
                $('#submitModal').html('Save');

                if(d.type == 'validation'){
                    if(d.err_nama == ''){
                        $('#err_nama').html('');
                    } else {
                        $('#err_nama').html(d.err_nama);
                    }

                    if(d.err_kota == ''){
                        $('#err_kota').html('');
                    } else {
                        $('#err_kota').html(d.err_kota);
                    }

                    if(d.err_alamat == ''){
                        $('#err_alamat').html('');
                    } else {
                        $('#err_alamat').html(d.err_alamat);
                    }
                } else if(d.type == 'result'){

                    $('#err_nama').html('');
                    $('#err_kota').html('');
                    $('#err_alamat').html('');

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
                    } else if(d.success == false){
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