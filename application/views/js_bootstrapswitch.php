<?php 
  // ini ditampilkan sesuai kebutuhan page masing masing untuk MODAL BOOTSTRAP
  $url_cek = cek_url();
?>

<script>
    <?php
        if($url_cek == 'users_groups/groups/'){
            ?>
                $(function () {
                    $("input[data-bootstrap-switch]").each(function(){
                        $(this).bootstrapSwitch('state', $(this).prop('checked'));
                    });
                });

                $("input[data-bootstrap-switch]").on('switchChange.bootstrapSwitch', function() {
                    var id = $(this).data('status_id')
                    var nama = $(this).data('status_nama')

                    $.ajax({
                        type: 'POST',
                        url: '<?=site_url('users_groups/group_proses/')?>',
                        data: {
                                'update_status': true, 
                                'id': id
                            },
                        dataType: 'json',
                        success: function(result) {
                            if(result.success == true) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Update status '+ nama +' berhasil...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        window.location='<?=site_url('users_groups/groups/')?>';
                                    }
                                )
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                })
                            }
                        }
                    })
                });
            <?php
        }elseif($url_cek == 'users_groups/users/'){
            ?>
                $(function () {
                    $("input[data-bootstrap-switch]").each(function(){
                        $(this).bootstrapSwitch('state', $(this).prop('checked'));
                    });
                });

                $("input[data-bootstrap-switch]").on('switchChange.bootstrapSwitch', function() {
                    var user_id = $(this).data('status_id')
                    var status = $(this).data('status_nya')
                    var nama = $(this).data('status_nama')

                    $.ajax({
                        type: 'POST',
                        url: '<?=site_url('users_groups/users_proses/')?>',
                        data: {
                                'update_status': true, 
                                'user_id': user_id,
                                'status': status
                            },
                        dataType: 'json',
                        success: function(result) {
                            if(result.success == true) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    html: 'Status <b>'+ nama +'</b> berhasil berhasil diupdate...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        window.location='<?=site_url('users_groups/users/')?>';
                                    }
                                )
                            } else {
                                if(result.status == 1) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'User tidak dikenal!',
                                    }).then(
                                    function() {
                                        window.location='<?=site_url('users_groups/users/')?>';
                                    }
                                )
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!',
                                    })
                                }
                            }
                        }
                    })
                });
            <?php
        }elseif($url_cek == 'users_groups/modules/'){
            ?>
                $(function () {
                    $("input[data-bootstrap-switch]").each(function(){
                        $(this).bootstrapSwitch('state', $(this).prop('checked'));
                    });
                });

            <?php
        }elseif($url_cek == 'database/sales/'){
            ?>
                $(function () {
                    $("input[data-bootstrap-switch]").each(function(){
                        $(this).bootstrapSwitch('state', $(this).prop('checked'));
                    });
                });

                $("input[data-bootstrap-switch]").on('switchChange.bootstrapSwitch', function() {
                    var id = $(this).data('status_id')
                    var nama = $(this).data('status_nama')

                    $.ajax({
                        type: 'POST',
                        url: '<?=site_url('database/sales_proses/')?>',
                        data: {
                                'update_status': true, 
                                'id': id,
                            },
                        dataType: 'json',
                        success: function(result) {
                            if(result.success == true) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    html: 'Status <b>'+ nama +'</b> berhasil berhasil diupdate...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        window.location='<?=site_url('database/sales/')?>';
                                    }
                                )
                            } else {
                                if(result.status == 1) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'User tidak dikenal!',
                                    })
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!',
                                    })
                                }
                            }
                        }
                    })
                });

            <?php
        }elseif($url_cek == 'database/customer/' || $url_cek == 'users_groups/role_group/'){
            ?>
                $(function () {
                    $("input[data-bootstrap-switch]").each(function(){
                        $(this).bootstrapSwitch('state', $(this).prop('checked'));
                    });
                });
            <?php
        }elseif($url_cek == 'database/salesaasssxxxxx/'){
            ?>

            <?php
        }

    ?>

</script>
