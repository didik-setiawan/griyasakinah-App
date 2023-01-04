<?php
$url_cek = cek_url();
?>


<?php
    if ($url_cek == 'users_groups/groups/') {
        ?>
            <script type="text/javascript">
            $(document).on('click', '#edit_group', function() {
                $('#edit_id').val($(this).data('edit_id'))
                $('#edit_nama_group').val($(this).data('edit_nama_group'))
                $('#durasi_awal1').val($(this).data('edit_durasi_awal'))
                $('#durasi_akhir1').val($(this).data('edit_durasi_akhir'))
            })

            $(document).on('click', '#add_group', function() {
                $('#nama_group').removeClass('is-invalid').val('');
            })

            // AWAL ADD GROUP proses form validasi 
            $(document).ready(function() {
                $.validator.setDefaults({
                    submitHandler: function() {
                        // var nama_group = $('#nama_group').val()
                        var postData = new FormData($("#modal_add_group")[0]);

                        $.ajax({
                            type: 'POST',
                            url: '<?= site_url('users_groups/group_proses/') ?>',
                            processData: false,
                            contentType: false,
                            data: postData,
                            dataType: 'json',
                            success: function(result) {
                                if (result.success == true) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Group baru berhasil dibuat...',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(
                                        function() {
                                            window.location =
                                                '<?= site_url('users_groups/groups/') ?>';
                                        }
                                    )
                                } else {
                                    if (result.status == 1) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Nama Group sudah ada, silahkan ganti nama lain',
                                        })
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!',
                                        })
                                    }
                                }
                            }
                        })
                    }
                });
                $('#modal_add_group').validate({
                    rules: {
                        nama_group: {
                            required: true,
                            minlength: 3
                        },
                    },
                    messages: {
                        nama_group: {
                            required: "Wajib diisi",
                            minlength: "min 3 karakter atau lebih"
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
            // AKHIR ADD GROUP proses form validasi 

            // AWAL EDIT GROUP proses form validasi 
            $(document).ready(function() {
                $.validator.setDefaults({
                    submitHandler: function() {
                        var postData = new FormData($("#modal_edit_group")[0]);

                        $.ajax({
                            type: 'POST',
                            url: '<?= site_url('users_groups/group_proses/') ?>',
                            processData: false,
                            contentType: false,
                            data: postData,
                            dataType: 'json',
                            success: function(result) {
                                if (result.success == true) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Group berhasil diupdate...',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(
                                        function() {
                                            window.location =
                                                '<?= site_url('users_groups/groups/') ?>';
                                        }
                                    )
                                } else {
                                    if (result.status == 1) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Nama Group sudah ada, silahkan ganti nama lain',
                                        })
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!',
                                        })
                                    }
                                }
                            }
                        })
                    }
                });
                $('#modal_edit_group').validate({
                    rules: {
                        edit_nama_group: {
                            required: true,
                            minlength: 3
                        },
                        durasi_awal1: {
                            required: true,
                        },
                        durasi_akhir1: {
                            required: true,
                        },
                    },
                    messages: {
                        edit_nama_group: {
                            required: "Wajib diisi",
                            minlength: "min 3 karakter atau lebih"
                        },
                        durasi_awal1: {
                            required: "Wajib diisi",
                        },
                        durasi_akhir1: {
                            required: "Wajib diisi",
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
            // AKHIR EDIT GROUP proses form validasi 

            // delete Group
            $(document).on('click', '#del_group', function() {
                $('#del_id').val($(this).data('del_id'))
                $('#del_nama_group').text($(this).data('del_nama_group'))
            })
            $(document).on('click', '#delete_group', function() {
                var id = $('#del_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('users_groups/group_proses/') ?>',
                    data: {
                        'delete_group': true,
                        'id': id
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Group berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('users_groups/groups/') ?>';
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
            })
            </script>
        <?php
    } elseif ($url_cek == 'users_groups/users/') {
        ?>
            <script type="text/javascript">
            // view profile
            $(document).on('click', '#view_detail', function() {
                $('#view_nama').text($(this).data('view_nama'))
                $('#view_group').text($(this).data('view_group'))
                $('#view_email').text($(this).data('view_email'))
                $('#view_avatar').attr('src', $(this).data('view_avatar'))
                $('#view_status').text($(this).data('view_status'))
            })

            // change group 
            $(document).on('click', '#change_group', function() {
                $('#change_id').val($(this).data('change_id'))
                $('#change_nama').val($(this).data('change_nama'))
                $('#change_group2').val($(this).data('change_group'))
            })

            // edit user
            $(document).on('click', '#edit_user', function() {
                $('#edit_id2').val($(this).data('edit_id'))
                $('#edit_nama').val($(this).data('edit_nama'))
                $('#edit_group').val($(this).data('edit_group'))
                $('#edit_email').val($(this).data('edit_email'))
            })

            $(document).on('click', '#edit_save', function() {
                var user_id = $('#edit_id2').val()
                var username = $('#edit_nama').val()
                var nama_group = $('#edit_group').val()
                var email = $('#edit_email').val()
                var password = $('#edit_password').val()
                var password2 = $('#edit_password2').val()
                var str_pwd = password.length;

                if (username == '') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Kolom Nama kosong..!!!',
                        text: 'Nama lengkap harus diisi dengan benar',
                    })
                } else if (password == '') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Kolom Password kosong..!!!',
                        text: 'Kolom Password wajib diisi',
                    })
                } else if (str_pwd < 8) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Password kurang dari 8 huruf..!!!',
                        text: 'Silahkan ganti password anda dan harus lebih dari 8 huruf',
                    })
                } else if (password != password2) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Kedua password harus sama..',
                        text: 'Kedua kolom password harus sama',
                    })
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '<?= site_url('users_groups/users_proses/') ?>',
                        data: {
                            'edit_user': true,
                            'user_id': user_id,
                            'username': username,
                            'password': password
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result.success == true) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Data User berhasil diupdate...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        window.location = '<?= site_url('users_groups/users/') ?>';
                                    }
                                )
                            } else {
                                if (result.status == 1) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'User tidak dikenal',
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!',
                                    })
                                }
                            }
                        }
                    })
                }
            })

            $(document).on('click', '#change_save', function() {
                var user_id = $('#change_id').val()
                var group_id = $('#ganti_group').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('users_groups/users_proses/') ?>',
                    data: {
                        'change_group': true,
                        'user_id': user_id,
                        'group_id': group_id
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Group berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('users_groups/users/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Group belum dipilih',
                                })
                            } else if (result.status == 2) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Group belum diubah, silahkan pilih Group lain',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                })
                            }
                        }
                    }
                })
            })

            // edit user
            $(document).on('click', '#delete_user', function() {
                $('#del_id').val($(this).data('del_id'))
                $('#del_nama').text($(this).data('del_nama'))
                $('#del_group').text($(this).data('del_group'))
                $('#del_email').text($(this).data('del_email'))
            })

            $(document).on('click', '#delete_save', function() {
                var user_id = $('#del_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('users_groups/users_proses/') ?>',
                    data: {
                        'delete_user': true,
                        'user_id': user_id
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'User akun berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('users_groups/users/') ?>';
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
            })

            $(document).on('click', '#add_user', function() {
                $('#add_nama').removeClass('is-invalid').val('');
                $('#add_email').removeClass('is-invalid').val('');
                $('#add_password').removeClass('is-invalid').val('');
                $('#add_password2').removeClass('is-invalid').val('');
                $('#add_group').removeClass('is-invalid').val('');
            })

            // AWAL ADD USER 
            $(document).ready(function() {
                $.validator.setDefaults({
                    submitHandler: function() {
                        var postData = new FormData($("#modal_add_user")[0]);
                        var password = $('#add_password').val()
                        var password2 = $('#add_password2').val()

                        if (password != password2) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Kedua password harus sama..',
                                text: 'Kedua kolom password harus sama',
                            })
                        } else {
                            $.ajax({
                                type: 'POST',
                                url: '<?= site_url('users_groups/users_proses/') ?>',
                                processData: false,
                                contentType: false,
                                data: postData,
                                dataType: 'json',
                                success: function(result) {
                                    if (result.success == true) {
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'User baru berhasil dibuat...',
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then(
                                            function() {
                                                window.location =
                                                    '<?= site_url('users_groups/users/') ?>';
                                            }
                                        )
                                    } else {
                                        if (result.status == 1) {
                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'error',
                                                title: 'No telp sudah terpakai..!!!',
                                                text: 'Silahkan digunakan no telp yang lain',
                                            })
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'Something went wrong!',
                                            })
                                        }
                                    }
                                }
                            })
                        }
                    }
                });
                $('#modal_add_user').validate({
                    rules: {
                        add_nama: {
                            required: true,
                            minlength: 5
                        },
                        add_email: {
                            required: true,
                            email: false,
                        },
                        add_password: {
                            required: true,
                            minlength: 8
                        },
                        add_password2: {
                            required: true,
                            minlength: 8
                        },
                        add_group: {
                            required: true,
                        },
                    },
                    messages: {
                        add_nama: {
                            required: "Wajib diisi",
                            minlength: "min 5 karakter atau lebih"
                        },
                        add_email: {
                            required: "Wajib diisi",
                            email: "Format email salah, silahkan diperbaiki"
                        },
                        add_password: {
                            required: "Wajib diisi",
                            minlength: "min 8 karakter atau lebih"
                        },
                        add_password2: {
                            required: "Wajib diisi",
                            minlength: "min 8 karakter atau lebih"
                        },
                        add_group: {
                            required: "Wajib dipilih",
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
            // AKHIR  ADD USER
            </script>
        <?php
    } elseif ($url_cek == 'dashboard/' || $url_cek == site_url()) {
        ?>
            <script type="text/javascript">
            $(document).on('click', '#reaload', function() {
                $('#disini').load(location.href + " #disini")
            })



            $( document ).ready(function() {

                var admin = $('.confirm-msg').data('group');

                if(admin == 1){
                    var id = 1;
                    setInterval(() => {
                        $.ajax({
                            url: '<?= site_url('dashboard/get_confirm_superadmin'); ?>',
                            dataType: 'JSON',
                            data: {id:id},
                            type: 'POST',
                            success: function(d){
                                

                                if(d > 0){
                                  
                                        var dataIni = 1;
                                        $.ajax({
                                            url: '<?= site_url('dashboard/show_confirm_superadmin'); ?>',
                                            data: {data:dataIni},
                                            type: 'POST',
                                            success: function(data){
                                                $('.ConfirmTransaksi').html(data);
                                            }
                                        });

                                } else {
                                    $('.ConfirmTransaksi').html('');
                                }

                            }
                        });

                    }, 3000);
                }

            });












            </script>






        <?php
    } elseif ($url_cek == 'profile/') {
        ?>
            <script type="text/javascript">
            $('#gambar').change(function() {
                var i = $(this).prev('label').clone();
                var file = $('#gambar')[0].files[0].name;
                $(this).prev('label').text(file);
            });
            $('#password1').val('')
            $('#password2').val('')

            $(document).ready(function() {
                $('#update_profile').validate({
                    rules: {
                        nama_user: {
                            required: true,
                            minlength: 3
                        },
                        email_user: {
                            required: true,
                            minlength: 3
                        },
                    },
                    messages: {
                        nama_user: {
                            required: "Wajib diisi",
                            minlength: "min 3 karakter atau lebih"
                        },
                        email_user: {
                            required: "Wajib diisi",
                            minlength: "min 3 karakter atau lebih"
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    submitHandler: function(event) {
                        var postData = new FormData($("#update_profile")[0]);
                        $.ajax({
                            type: 'POST',
                            url: '<?= site_url('profile/proses/') ?>',
                            processData: false,
                            contentType: false,
                            data: postData,
                            dataType: 'json',
                            success: function(result) {
                                if (result.success == true) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Profile berhasil di Update...',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(
                                        function() {
                                            window.location = '<?= site_url('profile/') ?>';
                                        }
                                    )
                                } else {
                                    if (result.status == 1) {
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'error',
                                            title: 'Kedua Password harus sama',
                                            text: 'Silahkan ketik ulang Password anda',
                                        })
                                    } else if (result.status == 2) {
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'error',
                                            title: 'Format Gambar salah',
                                            text: 'Pastikan Format Photo Profile anda JPG/PNG',
                                        })
                                    } else if (result.status == 3) {
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'error',
                                            title: 'Format File Gambar bukan JPG/PNG',
                                            html: result.pesan,
                                        })
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!',
                                        })
                                    }
                                }
                            }
                        });
                    }
                });
            });
            </script>
        <?php
    } elseif ($url_cek == 'laporan_keuangan/setup/') {
        ?>
            <script type="text/javascript">
            $(document).on('click', '#tambah_induk', function() {
                $('#nama_induk').val('')
            });

            $(document).on('click', '#tambah_kategori', function() {
                $('#nama_kategori').val('')
                $('#induk_kategori').val(0)
                $('#tipe_transaksi').val(0)
            });


            $(document).on('click', '#edit_induk_transaksi', function() {
                $('#edit_nama_induk').val($(this).data('nama_induk'))
                $('#induk_id').val($(this).data('id_induk'))
            });

            $(document).on('click', '#edit_kategori', function() {
                $('#kategori_id').val($(this).data('id_kat'))
                $('#edit_nama_kategori').val($(this).data('nama_kat'))
                $('#edit_tipe_transaksi').val($(this).data('tipe_kat'))
                $('#edit_induk_kategori').val($(this).data('induk_kat'))
            });

            $(document).on('click', '#del_induk', function() {
                $('#del_nama_induk').text($(this).data('del_nama_induk'))
                $('#del_induk_id').val($(this).data('del_id_induk'))
            })

            $(document).on('click', '#del_kategori', function() {
                var id_kategori = $(this).data('del_id_kat')

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('laporan_keuangan/proses/') ?>',
                    data: {
                        'get_kategori': true,
                        'id_kategori': id_kategori,
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#del_nama_kategori').text(data.nama_katagori)
                        $('#del_induk_transaksi').text(data.nama_induk)
                        $('#del_tipe_transaksi').text(data.nama_tipe)
                        $('#del_kategori_id').val(id_kategori)
                    }
                })

            })

            $(document).on('click', '#add_induk', function() {
                var nama_induk = $('#nama_induk').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('laporan_keuangan/proses/') ?>',
                    data: {
                        'add_induk': true,
                        'nama_induk': nama_induk,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Induk Transaksi berhasil dibuat...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('laporan_keuangan/setup/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nama Induk Transaksi wajib diisi',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Input Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#edit_induk_save', function() {
                var nama_induk = $('#edit_nama_induk').val()
                var induk_id = $('#induk_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('laporan_keuangan/proses/') ?>',
                    data: {
                        'edit_induk': true,
                        'nama_induk': nama_induk,
                        'induk_id': induk_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Induk Transaksi berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('laporan_keuangan/setup/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nama Induk Transaksi wajib diisi',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Input Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#add_kategori', function() {
                var nama_kategori = $('#nama_kategori').val()
                var induk_kategori = $('#induk_kategori').val()
                var tipe_transaksi = $('#tipe_transaksi').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('laporan_keuangan/proses/') ?>',
                    data: {
                        'add_kategori': true,
                        'nama_kategori': nama_kategori,
                        'induk_kategori': induk_kategori,
                        'tipe_transaksi': tipe_transaksi,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Kategori Transaksi berhasil dibuat...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('laporan_keuangan/setup/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nama Kategori Transaksi wajib diisi',
                                })
                            } else if (result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Induk Transaksi wajib dipilih',
                                })
                            } else if (result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tipe Transaksi wajib dipilih',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Input Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#edit_kategori_save', function() {
                var nama_kategori = $('#edit_nama_kategori').val()
                var induk_kategori = $('#edit_induk_kategori').val()
                var tipe_transaksi = $('#edit_tipe_transaksi').val()
                var kategori_id = $('#kategori_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('laporan_keuangan/proses/') ?>',
                    data: {
                        'edit_kategori': true,
                        'nama_kategori': nama_kategori,
                        'induk_kategori': induk_kategori,
                        'tipe_transaksi': tipe_transaksi,
                        'kategori_id': kategori_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Kategori Transaksi berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('laporan_keuangan/setup/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nama Kategori Transaksi wajib diisi',
                                })
                            } else if (result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Induk Transaksi wajib dipilih',
                                })
                            } else if (result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tipe Transaksi wajib dipilih',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Input Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#del_induk_save', function() {
                var induk_id = $('#del_induk_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('laporan_keuangan/proses/') ?>',
                    data: {
                        'del_induk': true,
                        'induk_id': induk_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Induk Transaksi berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('laporan_keuangan/setup/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops Gagal dihapus...',
                                    text: 'Induk Transaksi memiliki data Kategori Transaksi...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#del_kategori_save', function() {
                var kategori_id = $('#del_kategori_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('laporan_keuangan/proses/') ?>',
                    data: {
                        'del_kategori': true,
                        'kategori_id': kategori_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Kategori Transaksi berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('laporan_keuangan/setup/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops Gagal dihapus...',
                                    text: 'Kategori Transaksi memiliki relasi data...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })
            </script>
        <?php
    } elseif ($url_cek == 'rab/new/') {
        ?>
            <script type="text/javascript">
            $(function() {
                $('#tanggal_input').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            })

            $(document).on('click', '#add_kategori', function() {
                $('#nama_kategori').val('');
            });

            $(document).on('click', '#add_detail', function() {
                $('#induk_kategori').val(0);
                $('#add_deskripsi').val('');
                $('#add_quantity').val(0);
                $('#add_satuan').val(0);
                $('#add_nominal').val(0);
                $('#add_total').val(0);
            });

            $(document).on('click', '#item_edit', function() {
                var item_id = $(this).data('item_id')
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'get_item': true,
                        'item_id': item_id,
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#edit_kategori').val(data.parrent);
                        $('#edit_deskripsi').val(data.deskripsi);
                        $('#edit_quantity').val(data.quantity);
                        $('#edit_satuan').val(data.id_satuan);
                        $('#edit_nominal').val(data.nominal);
                        $('#edit_total').val(data.total);
                        $('#edit_id_detail').val(item_id);
                    }
                })
            });

            $(document).on('click', '#item_delete', function() {
                var item_id = $(this).data('item_id')
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'get_item': true,
                        'item_id': item_id,
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#del_kategori').text(data.induk);
                        $('#del_deskripsi').text(data.deskripsi);
                        $('#del_quantity').text(data.quantity2);
                        $('#del_satuan').text(data.satuan);
                        $('#del_nominal').text(data.nominal2);
                        $('#del_total').text(data.total2);
                        $('#del_id_detail').val(item_id);
                    }
                })
            });

            function count_on_modal() {
                var price = $('#add_nominal').val()
                var qty = $('#add_quantity').val()
                total = (price * qty)
                $('#add_total').val(total)
            }

            $(document).on('keyup mouseup', '#add_quantity, #add_nominal', function() {
                count_on_modal()
            })

            function count_edit_modal() {
                var price = $('#edit_nominal').val()
                var qty = $('#edit_quantity').val()
                total = (price * qty)
                $('#edit_total').val(total)
            }

            $(document).on('keyup mouseup', '#edit_quantity, #edit_nominal', function() {
                count_edit_modal()
            })


            $(document).on('click', '#induk_edit', function() {
                $('#edit_nama_kategori').val($(this).data('induk_nama'));
                $('#edit_id_kategori').val($(this).data('induk_id'));
            });

            $(document).on('click', '#induk_delete', function() {
                $('#del_nama_kategori').val($(this).data('induk_nama'));
                $('#del_id_kategori').val($(this).data('induk_id'));
            });

            $(document).on('click', '#add_kategori_save', function() {
                var nama_kategori = $('#nama_kategori').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'add_kategori': true,
                        'nama_kategori': nama_kategori,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Kategori RAB berhasil dibuat...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/new/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Form wajib diisi...',
                                    text: 'Form Kategori tidak boleh kosong...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#edit_kategori_save', function() {
                var nama_kategori = $('#edit_nama_kategori').val()
                var id_kategori = $('#edit_id_kategori').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'edit_kategori': true,
                        'nama_kategori': nama_kategori,
                        'id_kategori': id_kategori,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Kategori RAB berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/new/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Form wajib diisi...',
                                    text: 'Form Kategori tidak boleh kosong...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#delete_kategori', function() {
                var nama_kategori = $('#del_nama_kategori').val()
                var id_kategori = $('#del_id_kategori').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'del_kategori': true,
                        'nama_kategori': nama_kategori,
                        'id_kategori': id_kategori,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Kategori RAB berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/new/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Kategori tidak bisa dihapus...',
                                    text: 'Kategori sedang digunakan untuk menyusun anggaran...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#add_detail_save', function() {
                var induk_kategori = $('#induk_kategori').val()
                var deskripsi = $('#add_deskripsi').val()
                var quantity = $('#add_quantity').val()
                var satuan = $('#add_satuan').val()
                var nominal = $('#add_nominal').val()
                var total = $('#add_total').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'add_item': true,
                        'induk_kategori': induk_kategori,
                        'deskripsi': deskripsi,
                        'quantity': quantity,
                        'satuan': satuan,
                        'nominal': nominal,
                        'total': total,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Detail RAB berhasil dibuat...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/new/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kategori Induk belum dipilih...',
                                })
                            } else if (result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Deskripsi wajib diisi...',
                                })
                            } else if (result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Quantity wajib diisi dan tidak boleh 0 (Nol)...',
                                })
                            } else if (result.status == 4) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Satuan belum dipilih...',
                                })
                            } else if (result.status == 5) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nominal wajib diisi dan tidak boleh 0 (Nol)...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#edit_detail', function() {
                var induk_kategori = $('#edit_kategori').val()
                var deskripsi = $('#edit_deskripsi').val()
                var quantity = $('#edit_quantity').val()
                var satuan = $('#edit_satuan').val()
                var nominal = $('#edit_nominal').val()
                var total = $('#edit_total').val()
                var id_detail = $('#edit_id_detail').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'edit_item': true,
                        'induk_kategori': induk_kategori,
                        'deskripsi': deskripsi,
                        'quantity': quantity,
                        'satuan': satuan,
                        'nominal': nominal,
                        'total': total,
                        'id_detail': id_detail,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Detail RAB berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/new/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kategori Induk belum dipilih...',
                                })
                            } else if (result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Deskripsi wajib diisi...',
                                })
                            } else if (result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Quantity wajib diisi dan tidak boleh 0 (Nol)...',
                                })
                            } else if (result.status == 4) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Satuan belum dipilih...',
                                })
                            } else if (result.status == 5) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nominal wajib diisi dan tidak boleh 0 (Nol)...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#del_detail', function() {
                var id_detail = $('#del_id_detail').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'del_item': true,
                        'id_detail': id_detail,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Detail RAB berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/new/') ?>';
                                }
                            )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal diproses',
                            })
                        }
                    }
                })
            })

            $(document).on('click', '#simpan_rab', function() {
                var nama_kegiatan = $('#nama_kegiatan').val()
                var tanggal = $('#tanggal_input').val()
                var tempat_lokasi = $('#tempat_lokasi').val()
                var deskripsi_kegiatan = $('#deskripsi_kegiatan').val()
                var id_rab = $('#id_rab').val()

                if (nama_kegiatan == '') {
                    $('#view_nama_kegiatan').text('Empty')
                } else {
                    $('#view_nama_kegiatan').text(nama_kegiatan)
                }
                if (tempat_lokasi == '') {
                    $('#view_tempat').text('Empty')
                } else {
                    $('#view_tempat').text(tempat_lokasi)
                }
                if (deskripsi_kegiatan == '') {
                    $('#view_deskripsi').text('Empty')
                } else {
                    $('#view_deskripsi').text(deskripsi_kegiatan)
                }
                $('#view_tanggal').text(tanggal)
            })

            $(document).on('click', '#ya_proses', function() {
                var nama_kegiatan = $('#nama_kegiatan').val()
                var tanggal = $('#tanggal_input').val()
                var tempat_lokasi = $('#tempat_lokasi').val()
                var deskripsi_kegiatan = $('#deskripsi_kegiatan').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'save_rab': true,
                        'nama_kegiatan': nama_kegiatan,
                        'tanggal': tanggal,
                        'tempat_lokasi': tempat_lokasi,
                        'deskripsi_kegiatan': deskripsi_kegiatan,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'RAB berhasil dibuat...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/list/') ?>';
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nama Kegiatan wajib diisi...',
                                })
                            } else if (result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Tempat/Lokasi wajib diisi...',
                                })
                            } else if (result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Deskripsi wajib diisi...',
                                })
                            } else if (result.status == 4) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Detail Anggaran belum ada...!!!',
                                    text: 'Detail Anggaran RAB Belum dibuat, silahkan dibuat dahulu...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...1',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#ya_reset', function() {

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'reset_rab': true,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Data RAB berhasil direset...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/new/') ?>';
                                }
                            )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal diproses',
                            })
                        }
                    }
                })
            })
            </script>
        <?php
    } elseif ($url_cek == 'rab/detail/') {
        ?>
            <script type="text/javascript">
            $(function() {
                $('#tanggal_input').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            })

            $(document).on('click', '#add_kategori', function() {
                $('#nama_kategori').val('');
            });

            $(document).on('click', '#add_detail', function() {
                $('#induk_kategori').val(0);
                $('#add_deskripsi').val('');
                $('#add_quantity').val(0);
                $('#add_satuan').val(0);
                $('#add_nominal').val(0);
                $('#add_total').val(0);
            });

            $(document).on('click', '#item_edit', function() {
                var item_id = $(this).data('item_id')
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'get_item': true,
                        'item_id': item_id,
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#edit_kategori').val(data.parrent);
                        $('#edit_deskripsi').val(data.deskripsi);
                        $('#edit_quantity').val(data.quantity);
                        $('#edit_satuan').val(data.id_satuan);
                        $('#edit_nominal').val(data.nominal);
                        $('#edit_total').val(data.total);
                        $('#edit_id_detail').val(item_id);
                    }
                })
            });

            $(document).on('click', '#item_delete', function() {
                var item_id = $(this).data('item_id')
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'get_item': true,
                        'item_id': item_id,
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#del_kategori').text(data.induk);
                        $('#del_deskripsi').text(data.deskripsi);
                        $('#del_quantity').text(data.quantity2);
                        $('#del_satuan').text(data.satuan);
                        $('#del_nominal').text(data.nominal2);
                        $('#del_total').text(data.total2);
                        $('#del_id_detail').val(item_id);
                    }
                })
            });

            $(document).on('click', '#item_finish', function() {
                var item_id = $(this).data('item_id')
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'get_item': true,
                        'item_id': item_id,
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#finish_kategori').text(data.induk);
                        $('#finish_deskripsi').text(data.deskripsi);
                        $('#finish_quantity').text(data.quantity2);
                        $('#finish_satuan').text(data.satuan);
                        $('#finish_nominal').text(data.nominal2);
                        $('#finish_total').text(data.total2);
                        $('#finish_id_detail').val(item_id);
                    }
                })
            });

            function count_on_modal() {
                var price = $('#add_nominal').val()
                var qty = $('#add_quantity').val()
                total = (price * qty)
                $('#add_total').val(total)
            }

            $(document).on('keyup mouseup', '#add_quantity, #add_nominal', function() {
                count_on_modal()
            })

            function count_edit_modal() {
                var price = $('#edit_nominal').val()
                var qty = $('#edit_quantity').val()
                total = (price * qty)
                $('#edit_total').val(total)
            }

            $(document).on('keyup mouseup', '#edit_quantity, #edit_nominal', function() {
                count_edit_modal()
            })


            $(document).on('click', '#induk_edit', function() {
                $('#edit_nama_kategori').val($(this).data('induk_nama'));
                $('#edit_id_kategori').val($(this).data('induk_id'));
            });

            $(document).on('click', '#induk_delete', function() {
                $('#del_nama_kategori').val($(this).data('induk_nama'));
                $('#del_id_kategori').val($(this).data('induk_id'));
            });

            $(document).on('click', '#add_kategori_save', function() {
                var nama_kategori = $('#nama_kategori').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'add_kategori': true,
                        'nama_kategori': nama_kategori,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Kategori RAB berhasil dibuat...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/detail/') ?>' + id_rab;
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Form wajib diisi...',
                                    text: 'Form Kategori tidak boleh kosong...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#edit_kategori_save', function() {
                var nama_kategori = $('#edit_nama_kategori').val()
                var id_kategori = $('#edit_id_kategori').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'edit_kategori': true,
                        'nama_kategori': nama_kategori,
                        'id_kategori': id_kategori,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Kategori RAB berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/detail/') ?>' + id_rab;
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Form wajib diisi...',
                                    text: 'Form Kategori tidak boleh kosong...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#delete_kategori', function() {
                var nama_kategori = $('#del_nama_kategori').val()
                var id_kategori = $('#del_id_kategori').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'del_kategori': true,
                        'nama_kategori': nama_kategori,
                        'id_kategori': id_kategori,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Kategori RAB berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/detail/') ?>' + id_rab;
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Kategori tidak bisa dihapus...',
                                    text: 'Kategori sedang digunakan untuk menyusun anggaran...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#add_detail_save', function() {
                var induk_kategori = $('#induk_kategori').val()
                var deskripsi = $('#add_deskripsi').val()
                var quantity = $('#add_quantity').val()
                var satuan = $('#add_satuan').val()
                var nominal = $('#add_nominal').val()
                var total = $('#add_total').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'add_item': true,
                        'induk_kategori': induk_kategori,
                        'deskripsi': deskripsi,
                        'quantity': quantity,
                        'satuan': satuan,
                        'nominal': nominal,
                        'total': total,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Detail RAB berhasil dibuat...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/detail/') ?>' + id_rab;
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kategori Induk belum dipilih...',
                                })
                            } else if (result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Deskripsi wajib diisi...',
                                })
                            } else if (result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Quantity wajib diisi dan tidak boleh 0 (Nol)...',
                                })
                            } else if (result.status == 4) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Satuan belum dipilih...',
                                })
                            } else if (result.status == 5) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nominal wajib diisi dan tidak boleh 0 (Nol)...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#edit_detail', function() {
                var induk_kategori = $('#edit_kategori').val()
                var deskripsi = $('#edit_deskripsi').val()
                var quantity = $('#edit_quantity').val()
                var satuan = $('#edit_satuan').val()
                var nominal = $('#edit_nominal').val()
                var total = $('#edit_total').val()
                var id_detail = $('#edit_id_detail').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'edit_item': true,
                        'induk_kategori': induk_kategori,
                        'deskripsi': deskripsi,
                        'quantity': quantity,
                        'satuan': satuan,
                        'nominal': nominal,
                        'total': total,
                        'id_detail': id_detail,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Detail RAB berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/detail/') ?>' + id_rab;
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kategori Induk belum dipilih...',
                                })
                            } else if (result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Deskripsi wajib diisi...',
                                })
                            } else if (result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Quantity wajib diisi dan tidak boleh 0 (Nol)...',
                                })
                            } else if (result.status == 4) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Satuan belum dipilih...',
                                })
                            } else if (result.status == 5) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nominal wajib diisi dan tidak boleh 0 (Nol)...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#del_detail', function() {
                var id_detail = $('#del_id_detail').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'del_item': true,
                        'id_detail': id_detail,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Detail RAB berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/detail/') ?>' + id_rab;
                                }
                            )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal diproses',
                            })
                        }
                    }
                })
            })

            $(document).on('click', '#finish_detail', function() {
                var id_detail = $('#finish_id_detail').val()
                var id_rab = $('#id_rab').val()

                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'finish_detail': true,
                        'id_detail': id_detail,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Selamat, Anggaran sudah terpenuhi...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/detail/') ?>' + id_rab;
                                }
                            )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal diproses',
                            })
                        }
                    }
                })
            })

            $(document).on('click', '#update_rab', function() {
                var nama_kegiatan = $('#nama_kegiatan').val()
                var tanggal = $('#tanggal_input2').val()
                var tempat_lokasi = $('#tempat_lokasi').val()
                var deskripsi_kegiatan = $('#deskripsi_kegiatan').val()
                var total_anggaran = $('#total_anggaran').val()

                $('#view_nama_kegiatan').text(nama_kegiatan);
                $('#view_tanggal').text(tanggal);
                $('#view_tempat').text(tempat_lokasi);
                $('#view_deskripsi').text(deskripsi_kegiatan);
                $('#view_anggaran').text(total_anggaran);
            });

            $(document).on('click', '#ya_proses', function() {
                var nama_kegiatan = $('#nama_kegiatan').val()
                var tanggal = $('#tanggal_input').val()
                var tempat_lokasi = $('#tempat_lokasi').val()
                var deskripsi_kegiatan = $('#deskripsi_kegiatan').val()
                var id_rab = $('#id_rab').val()


                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('rab/proses/') ?>',
                    data: {
                        'update_rab': true,
                        'nama_kegiatan': nama_kegiatan,
                        'tanggal': tanggal,
                        'tempat_lokasi': tempat_lokasi,
                        'deskripsi_kegiatan': deskripsi_kegiatan,
                        'id_rab': id_rab,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'RAB berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location = '<?= site_url('rab/detail/') ?>' + id_rab;
                                }
                            )
                        } else {
                            if (result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nama Kegiatan wajib diisi...',
                                })
                            } else if (result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Tempat/Lokasi wajib diisi...',
                                })
                            } else if (result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Deskripsi wajib diisi...',
                                })
                            } else if (result.status == 4) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Detail Anggaran belum ada...!!!',
                                    text: 'Detail Anggaran RAB Belum dibuat, silahkan dibuat dahulu...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })
            </script>
        <?php
    } elseif ($url_cek == 'laporan_keuangan/laba_rugi/') {
        ?>
            <script type="text/javascript">
            date = new Date();
            tahun = date.getFullYear();
            $('#p_tahun').text(tahun);

            $('#periode_tahun').select2({
                placeholder: "Pilih Tahun",
                allowClear: true
            })

            $('#periode_tahun').change(function() { //button filter event click
                var tahun2 = $('#periode_tahun').val()
                if (tahun2 == '') {
                    $('#p_tahun').text(tahun);
                } else {
                    $('#p_tahun').text(tahun2);
                }
                $('#load_data').load('<?= site_url('laporan_keuangan/data_labarugi/') ?>' + tahun2)
            });

            // cetak_laporan
            $(document).on('click', '#cetak_laporan', function() {
                var periode = $('#periode_tahun').val();
                window.open('<?= site_url('cetak/laba_rugi/') ?>' + periode + '?pdf=0', '_blank', 'width=900,height=800');
            })

            // download pdf laporan
            $(document).on('click', '#download_laporan', function() {
                var periode = $('#periode_tahun').val();
                window.open('<?= site_url('cetak/laba_rugi/') ?>' + periode + '?pdf=1', '_blank');
            })
            </script>
            <?php
            } elseif ($url_cek == 'laporan_keuangan/neraca/') {
            ?>
            <script type="text/javascript">
            $('#periode_tahun').select2({
                placeholder: "Pilih Tahun",
                allowClear: true
            })

            $('#periode_bulan').select2({
                placeholder: "Pilih Bulan",
                allowClear: true
            })
            </script>
        <?php
    } elseif ($url_cek == 'dokumentasi/') {
        ?>
            <script>
                $(document).ready(function() {
                    $.ajax({
                        type: 'POST',
                        url: '<?= apiKEYUrl() ?>',
                        data: {
                            'apiDokumen'    : true,
                            'apiKey'        : '<?=apiKey()?>',
                            'apiKEYProfile' : '<?=apiKEYProfile()?>',
                            'apiValidDate'  : '<?=apiValidDate()?>',
                            'apiUrl'        : '<?=site_url()?>',
                        },
                        dataType: 'json',
                        success: function (data) {
                            $('#apiDokumentasi').html(data.data);
                            if(data.idS == 1){
                                $('#statusKey').text(data.status).addClass('badge-primary');
                            }else{
                                $('#statusKey').text(data.status).addClass('badge-danger');
                            }
                        },
                        complete: function(){
                            var fewSeconds = 3;
                            setTimeout(function(){
                            }, fewSeconds*1000);
                        },
                        error: function (jqXHR, exception) {
                            getErrorMessage(jqXHR, exception);
                        },

                    });

                })

                // This function is used to get error message for all ajax calls
                function getErrorMessage(jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    $('#apiDokumentasi').html(msg);
                }

            </script>
        <?php
    } elseif ($url_cek == 'setup/') {
        ?>
            <script>
                $('#gambar').change(function() {
                    var i = $(this).prev('label').clone();
                    var file = $('#gambar')[0].files[0].name;
                    $(this).prev('label').text(file);
                });

                $("#update_profile").submit(function(e) {
                    e.preventDefault();    
                    $('#sniped').show();
                    var btn = $('#upload_img');
                    btn.prop('disabled', true);
                    var formData = new FormData(this);
                    $.ajax({
                        url         : '<?=site_url('setup/proses/')?>',
                        type        : 'POST',
                        data        : formData,
                        cache       : false,
                        contentType : false,
                        processData : false,
                        dataType    : 'json',
                        success: function (data) {
                            if(data.success == true){
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Profile Lembaga berhasil diperbaharui...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        location.reload()
                                    }
                                )
                            }else{
                                // var status = parseInt(result.status);
                                if(data.status == 1){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Profile Lembaga berhasil diperbaharui...',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(
                                        function() {
                                            location.reload()
                                        }
                                    )
                                }else if(data.status == 2){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'File Error.!!!',
                                        html: data.msg,
                                    })
                                }else{
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'Error.!!!',
                                        text: 'gagal diproses',
                                    })
                                }
                            }
                        },
                        complete: function(){
                            var fewSeconds = 3;
                            setTimeout(function(){
                                $('#sniped').hide();
                                btn.prop('disabled', false);
                            }, fewSeconds*1000);
                        }
                    });
                });

            </script>


<?php } elseif ($url_cek == 'accounting/bank/') { ?>

    <script>
    var msg = $('.message').data('msg');
    if(msg){
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            text: msg,
            showConfirmButton: false,
            timer: 1500
            });
    }

        $('#transaksi-bank-table').dataTable();


   
            $(document).on('click', '.tjl', function(){
                    var id = $(this).data('id');
                    $('.titleTjl').html('Tanda Jadi Lokasi');

                    $.ajax({
                        url: '<?= site_url('accounting/get_tjl'); ?>',
                        method: 'POST',
                        data:{id:id},
                        success: function(d){
                            $('.dataTjl').html(d);
                        }
                });
            });
        
        $(document).on('click', '.um', function(){
            var id = $(this).data('id');
            $('.umtitle').html('Uang Muka');
          
                $.ajax({
                    url: '<?= site_url('accounting/get_um'); ?>',
                    method: 'POST',
                    data:{id:id},
                    success: function(d){
                        $('.dataUm').html(d);
                    }
                });           
        });

        $(document).on('click', '.kt', function(){
            var id = $(this).data('id');
            $('.kttitle').html('Kelebihan Tanah');
            
                $.ajax({
                    url: '<?= site_url('accounting/get_kt'); ?>',
                    method: 'POST',
                    data:{id:id},
                    success: function(d){
                        $('.dataKt').html(d);
                    }
                });
        });
       
        $(document).on('click', '.pak', function(){
            var id = $(this).data('id');
            $('.paktitle').html('PAK');
           
                $.ajax({
                    url: '<?= site_url('accounting/get_pak'); ?>',
                    method: 'POST',
                    data:{id:id},
                    success: function(d){
                        $('.dataPak').html(d);
                    }
                });
        });
        
        $(document).on('click','.lain', function(){
            var id = $(this).data('id');
            $('.laintitle').html('Lain-Lain');
            
                $.ajax({
                    url: '<?= site_url('accounting/get_lain'); ?>',
                    method: 'POST',
                    data:{id:id},
                    success: function(d){
                        $('.dataLain').html(d);
                    }
                });
        });
       
        $(document).on('click','.angsuran',function(){
            var id = $(this).data('id');
                $.ajax({
                    url: '<?= site_url('accounting/get_angsuran'); ?>',
                    data: {id:id},
                    type: 'POST',
                    success: function(d){
                        $('.dataAngsuranBank').html(d);
                    }
                });
        });

        $(document).on('click','.piutang',function(){
            var id = $(this).data('id');
               
                    $.ajax({
                        url: '<?= site_url('accounting/get_piutang'); ?>',
                        data: {id:id},
                        type: 'POST',
                        success: function(d){
                            $('.dataPiutang').html(d);
                        }
                    });
        });


        $(document).on('click','.tj',function(){
            var id = $(this).data('id');
               
                    $.ajax({
                        url: '<?= site_url('accounting/get_tj'); ?>',
                        data: {id:id},
                        type: 'POST',
                        success: function(d){
                            $('.dataTJ').html(d);
                        }
                    });
        });



        $('#submit').submit(function(e){
            e.preventDefault();

            $.ajax({
             url: $(this).attr('action'),
             type:"post",
             data:new FormData(this),
             processData:false,
             contentType:false,
             cache:false,
             async:false,
              success: function(d){
                Swal.fire(d);
                // console.log(d);
                $('#modalTF').modal('hide');
                $('#um').modal('hide');
                $('#kt').modal('hide');
                $('#pak').modal('hide');
                $('#lain').modal('hide');
                $('#angsuran_bank').modal('hide');
                $('#piutang_bank').modal('hide');
                $('#tanda_jadi').modal('hide');
                $('#staticBackdrop').modal('hide');

                $('#id_pembayaran').val('');
                $('#type').val('');
           }
         });

        });


        $('#kode').on('change', function(){
            const id_kode = $(this).val();
            $.ajax({
                url: '<?= site_url('accounting/get_sub_kode'); ?>',
                dataType: 'JSON',
                data: {id_kode:id_kode},
                type: 'POST',
                success: function(d){
                    
                    let html = '<option value="">--Pilih--</option>';
                    let i ;
                    for(i=0; i<d.length; i++){
                        html += '<option value='+ d[i].id_sub +'>('+ d[i].sub_kode + '). '+ d[i].deskripsi_sub_kode +'</option>';
                    }
                    $('#sub_kode').html(html);
                }
            });
        });


        $('#sub_kode').change(function(){
            const id_sub = $(this).val();
            $.ajax({
                url: '<?= site_url('accounting/get_title_kode'); ?>',
                data: {id:id_sub},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    console.log(d);
                    let html = '<option value="">--Pilih--</option>';
                    let i ;
                    for(i=0; i<d.length; i++){
                        html += '<option value='+ d[i].id_title +'>('+ d[i].kode_title + '). '+ d[i].deskripsi +'</option>';
                    }
                    $('#title_kode').html(html);
                }
            });
        });

        $(document).on('click','.toCode', function(){
            let id = $(this).data('id');
            let type = $(this).data('type');

            $('#type').val(type);
            $('#id_pembayaran').val(id);
            $('#modalTF').modal('show');
        });

        $(document).on('click','.toBayar', function(){
            let id = $(this).data('id');
            let tipe = $(this).data('type');
            let sisa = $(this).data('sisa');

            $('#id_add_pembayaran').val(id);
            $('#tipe').val(tipe);
            $('#max_bayar').val(sisa);
            $('#jml_bayar').val(sisa);
            
            $('#modalCicil').modal('show');

            $.ajax({
                url: '<?= site_url('pemasukan/load_history'); ?>',
                data: {id: id, tipe: tipe},
                type: 'POST',
                success: function(d){
                    $('#loadHistory').html(d);
                }
            });

            $.ajax({
                url: '<?= site_url('pemasukan/show_sisa_pembayaran') ?>',
                data: {id: id, tipe: tipe, sisa: sisa},
                type: 'POST',
                success: function(data){
                   $('#loadSisa').html(data);
                }
            });


            if(sisa == 0){
                $('#toSave').attr('disabled', true);
                $('#tanggal_bayar').attr('disabled', true);
                $('#jml_bayar').attr('disabled', true);
            } else if(sisa < 0){
                $('#toSave').attr('disabled', true);
                $('#tanggal_bayar').attr('disabled', true);
                $('#jml_bayar').attr('disabled', true);
            } else {
                $('#toSave').removeAttr('disabled');
                $('#tanggal_bayar').removeAttr('disabled');
                $('#jml_bayar').removeAttr('disabled');
            }

        });

        $('#formPemasukan').submit(function(e){
            e.preventDefault();

            $("#jml_bayar").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
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
                        $('#modalCicil').modal('hide');
                        closeModal();
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


        $("#jml_bayar").inputmask({
            radixPoint: ',',
            groupSeparator: ".",
            alias: "numeric",
            autoGroup: true,
            digits: 0
        });

        $(document).on('keyup mouseup','#jml_bayar', function() {
            $("#jml_bayar").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });
        })

        $(document).on('click','.addBukti', function(){
            $('#modalBukti').modal('show');
            let id = $(this).data('id');
            let tipe = $(this).data('tipe');
            $('#id_cicil').val(id);
            $('#tipe_cicil').val(tipe);
            $('#transfer').attr('required', true);
            $('#nota').attr('required', true);

            $('#formAddBukti').attr('action','<?= site_url('pemasukan/add_bukti'); ?>');
            $('.titleBukti').html('Tambah Bukti');
        });

        $('#formAddBukti').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function(d){
                    $('#modalBukti').modal('hide');
                    $('#modalCicil').modal('hide');
                    if(d.success == true){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#modalCicil').modal('hide');
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

        $(document).on('click','.approve', function(){
            let id = $(this).data('id');
            let tipe = $(this).data('tipe');

            $.ajax({
                url: '<?= site_url('pemasukan/approve_pemasukan'); ?>',
                data: {id: id, tipe: tipe},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    $('#modalCicil').modal('hide');
                }
            });

        });
        $(document).on('click','.reject', function(){
            let id = $(this).data('id');
            let tipe = $(this).data('tipe');

            $.ajax({
                url: '<?= site_url('pemasukan/reject_pemasukan'); ?>',
                data: {id: id, tipe: tipe},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    $('#modalCicil').modal('hide');
                }
            });

        });

        $('#f_cluster').change(function(){
            let cluster = $(this).val();
            
            let url = '<?= site_url('accounting/bank?cluster=') ?>'+cluster;
            window.location.href = url;

        });

        function closeModal(){
            $('#staticBackdrop').modal('hide');
            $('#um').modal('hide');
            $('#kt').modal('hide');
            $('#pak').modal('hide');
            $('#lain').modal('hide');
            $('#angsuran_bank').modal('hide');
            $('#piutang_bank').modal('hide');
            $('#tanda_jadi').modal('hide');
        }

    </script>


<?php } elseif ($url_cek == 'accounting/inhouse/') { ?>

    <script>


    var msg = $('.message').data('msg');
    if(msg){
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            text: msg,
            showConfirmButton: false,
            timer: 1500
            });
    }

        $('#transaksi-inhouse-table').dataTable();

        $(document).on('click', '.hk', function(){
            var id = $(this).data('id');
            $('.hktitle').html('Harga Kesepakatan');
            
                     $.ajax({
                        url: '<?= site_url('accounting/get_hk_inhouse'); ?>',
                        method: 'POST',
                        data:{id:id},
                        success: function(d){
                            $('.datahk').html(d);
                        }
                    });
        });
       
        $(document).on('click', '.tjl', function(){
            var id = $(this).data('id');
            $('.tjltitle').html('Tanda Jadi Lokasi');
            
                $.ajax({
                    url: '<?= site_url('accounting/get_tjl_inhouse'); ?>',
                    method: 'POST',
                    data:{id:id},
                    success: function(d){
                        $('.datatjl').html(d);
                    }
                });    
        });
       
        $(document).on('click','.um' ,function(){
            var id = $(this).data('id');
            $('.umtitle').html('Uang Muka');
            
                    $.ajax({
                        url: '<?= site_url('accounting/get_um_inhouse'); ?>',
                        method: 'POST',
                        data:{id:id},
                        success: function(d){
                            $('.dataum').html(d);
                        }
                    });
        });
       
        $(document).on('click', '.kt', function(){
            var id = $(this).data('id');
            $('.kttitle').html('Kelebihan Tanah');
                        $.ajax({
                            url: '<?= site_url('accounting/get_kt_inhouse'); ?>',
                            method: 'POST',
                            data:{id:id},
                            success: function(d){
                                $('.datakt').html(d);
                            }
                        });
                  
        });
        
        $(document).on('click', '.tj',function(){
            var id = $(this).data('id');
           
                        $.ajax({
                            url: '<?= site_url('accounting/get_tj_inhouse'); ?>',
                            method: 'POST',
                            data:{id:id},
                            success: function(d){
                                $('.dataTj').html(d);
                            }
                        });
                  
        });

        $('#submit').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type:"post",
                data:new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                    success: function(d){
                        Swal.fire(d);
                        // console.log(d);
                        $('#modalTF').modal('hide');
                        $('#id_pembayaran').val('');
                        $('#type').val('');
                        $('#bukti').val('');
                        $('#db').val('');
                    }
            });

        });


        $('#kode').on('change', function(){
            const id_kode = $(this).val();
            $.ajax({
                url: '<?= site_url('accounting/get_sub_kode'); ?>',
                dataType: 'JSON',
                data: {id_kode:id_kode},
                type: 'POST',
                success: function(d){
                    
                    let html = '<option value="">--Pilih--</option>';
                    let i ;
                    for(i=0; i<d.length; i++){
                        html += '<option value='+ d[i].id_sub +'>('+ d[i].sub_kode + '). '+ d[i].deskripsi_sub_kode +'</option>';
                    }
                    $('#sub_kode').html(html);
                }
            });
        });


        $('#sub_kode').change(function(){
            const id_sub = $(this).val();
            $.ajax({
                url: '<?= site_url('accounting/get_title_kode'); ?>',
                data: {id:id_sub},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    console.log(d);
                    let html = '<option value="">--Pilih--</option>';
                    let i ;
                    for(i=0; i<d.length; i++){
                        html += '<option value='+ d[i].id_title +'>('+ d[i].kode_title + '). '+ d[i].deskripsi +'</option>';
                    }
                    $('#title_kode').html(html);
                }
            });
        });


        $(document).on('click','.toCode', function(){
            let id = $(this).data('id');
            let type = $(this).data('type');

            $('#type').val(type);
            $('#id_pembayaran').val(id);
            $('#modalTF').modal('show');
        });

        $(document).on('click','.toBayar', function(){
            let id = $(this).data('id');
            let tipe = $(this).data('type');
            let sisa = $(this).data('sisa');

            $('#id_add_pembayaran').val(id);
            $('#tipe').val(tipe);
            $('#max_bayar').val(sisa);
            $('#jml_bayar').val(sisa);
            
            $('#modalCicil').modal('show');

            $.ajax({
                url: '<?= site_url('pemasukan/load_history'); ?>',
                data: {id: id, tipe: tipe},
                type: 'POST',
                success: function(d){
                    $('#loadHistory').html(d);
                }
            });

            if(sisa == 0){
                $('#toSave').attr('disabled', true);
                $('#tanggal_bayar').attr('disabled', true);
                $('#jml_bayar').attr('disabled', true);
            } else if(sisa < 0){
                $('#toSave').attr('disabled', true);
                $('#tanggal_bayar').attr('disabled', true);
                $('#jml_bayar').attr('disabled', true);
            } else {
                $('#toSave').removeAttr('disabled');
                $('#tanggal_bayar').removeAttr('disabled');
                $('#jml_bayar').removeAttr('disabled');
            }

        });

        $('#formPemasukan').submit(function(e){
            e.preventDefault();

            $("#jml_bayar").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
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
                        $('#modalCicil').modal('hide');
                        closeModal();
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


        $("#jml_bayar").inputmask({
            radixPoint: ',',
            groupSeparator: ".",
            alias: "numeric",
            autoGroup: true,
            digits: 0
        });

        $(document).on('keyup mouseup','#jml_bayar', function() {
            $("#jml_bayar").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });
        })

        $(document).on('click','.addBukti', function(){
            $('#modalBukti').modal('show');
            let id = $(this).data('id');
            let tipe = $(this).data('tipe');
            $('#id_cicil').val(id);
            $('#tipe_cicil').val(tipe);
            $('#transfer').attr('required', true);
            $('#nota').attr('required', true);

            $('#formAddBukti').attr('action','<?= site_url('pemasukan/add_bukti'); ?>');
            $('.titleBukti').html('Tambah Bukti');
        });

        $('#formAddBukti').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function(d){
                    $('#modalBukti').modal('hide');
                    $('#modalCicil').modal('hide');
                    if(d.success == true){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#modalCicil').modal('hide');
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

        $(document).on('click','.approve', function(){
            let id = $(this).data('id');
            let tipe = $(this).data('tipe');

            $.ajax({
                url: '<?= site_url('pemasukan/approve_pemasukan'); ?>',
                data: {id: id, tipe: tipe},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    $('#modalCicil').modal('hide');
                }
            });

        });
        $(document).on('click','.reject', function(){
            let id = $(this).data('id');
            let tipe = $(this).data('tipe');

            $.ajax({
                url: '<?= site_url('pemasukan/reject_pemasukan'); ?>',
                data: {id: id, tipe: tipe},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    $('#modalCicil').modal('hide');
                }
            });

        });

        $('#f_cluster').change(function(){
            let cluster = $(this).val();
            
            let url = '<?= site_url('accounting/inhouse?cluster=') ?>'+cluster;
            window.location.href = url;

        });


        function closeModal(){
            $('#hk').modal('hide');
            $('#um').modal('hide');
            $('#kt').modal('hide');
            $('#tjl').modal('hide');
            $('#tj').modal('hide');
        }

    </script>


<?php } elseif ($url_cek == 'kpr/rek_bank/') { ?>
    <script>

        $('#table-Rekening').dataTable();

        var msgtrue = $('.msg-true').data('pesan');
        var msgfalse = $('.msg-false').data('pesan');

        if(msgtrue){
            Swal.fire({
                icon: 'success',
                title: msgtrue,
                showConfirmButton: false,
                timer: 1500
            });
        }
        if(msgfalse){
            Swal.fire({
                icon: 'error',
                title: msgfalse,
                showConfirmButton: false,
                timer: 1500
            });
        }

        $('.del-rekening').on('click', function(e){
            e.preventDefault();
            var link = $(this).attr('href');
            // console.log(link);

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Untuk menghapus data ini secara permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YES'
                }).then((result) => {
                if (result.value) {
                    window.location.href = link;
                }
            })

        });


        $('.add-rekening').on('click', function(){
            $('.modal-title').html('Tambah Rekening Bank');
            $('#aksi').attr('action', '<?= site_url('kpr/add_rek_bank'); ?>');
            $('#bank').val('');
            $('#pemilik').val('');
            $('#no_rek').val('');
        });
        
        
        $('.edit-rekening').on('click', function(){
            $('.modal-title').html('Edit Rekening Bank');
            $('#aksi').attr('action', '<?= site_url('kpr/edit_rek_bank'); ?>');
        
            var id = $(this).data('id');

            $.ajax({
                url: '<?= site_url('kpr/get_rek_bank_ajax'); ?>',
                data: {id:id},
                dataType: 'JSON',
                type: 'POST',
                success: function(d){
                    $('#bank').val(d.nama_bank);
                    $('#pemilik').val(d.nama_pemilik);
                    $('#no_rek').val(d.no_rekening);
                    $('#id_rekening').val(d.id_rekening);
                }
            });

        });


    </script>

<?php } elseif ($url_cek == 'kpr/berkas_konsumen/') { ?>

    <script>
        $('#berkas-konsumen').dataTable();

        $('.add-berkas').on('click', function(){
            var id = $(this).data('id');
            $('#id_konsumen').val(id);
        });

        $('.view-berkas').on('click', function(){
            var id = $(this).data('id');
            var ket = $(this).data('keterangan');

            $.ajax({
                url: '<?= site_url('kpr/view_berkas'); ?>',
                data: {id:id , keterangan:ket},
                type: 'POST',
                success: function(d){
                    $('#modal-berkas').html(d);
                }
            });
        });


        var msgtrue = $('.msg-true').data('pesan');
        var msgfalse = $('.msg-false').data('pesan');

        if(msgtrue){
            Swal.fire({
                icon: 'success',
                title: msgtrue,
                showConfirmButton: false,
                timer: 1500
            });
        }
        if(msgfalse){
            Swal.fire({
                icon: 'error',
                title: msgfalse,
                showConfirmButton: false,
                timer: 1500
            });
        }
    </script>

<?php } elseif ($url_cek == 'master/cluster/') { ?>

    <script>
        $('#clusterTable').dataTable();

        $('.add-cluster').on('click', function(){
            $('.modal-title').html('Tambah Cluster');
            $('form').attr('action','<?= site_url('master/add_cluster'); ?>');
            $('#perum').val('');
            $('#cluster').val('');
        });


        $('.edit-cluster').on('click', function(){
            var id = $(this).data('id');
            $('.modal-title').html('Edit Cluster');
            $('form').attr('action','<?= site_url('master/edit_cluster/'); ?>' + id);

            $.ajax({
                url: '<?= site_url('master/get_cluster_ajax'); ?>',
                data: {id:id},
                dataType: 'JSON',
                type: 'POST',
                success: function(d){
                   $('#perum').val(d.id_perum);
                   $('#cluster').val(d.nama_cluster)
                }
            });


        });

        $('.del-cluster').on('click', function(e){
            e.preventDefault();
            var link = $(this).attr('href');
           
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "menghapus cluster juga menghapus kavling di dalamnya",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YES'
                }).then((result) => {
                if (result.value) {
                    window.location.href = link;
                }
            });


        });


        var msgtrue = $('.msg-scs').data('pesan');
        var msgfalse = $('.msg-err').data('pesan');


        if(msgtrue){
            Swal.fire({
                icon: 'success',
                title: msgtrue,
                showConfirmButton: false,
                timer: 1500
            });
        }

        if(msgfalse){
            Swal.fire({
                icon: 'error',
                title: msgfalse,
                showConfirmButton: false,
                timer: 1500
            });
        }

    </script>

<?php }?>