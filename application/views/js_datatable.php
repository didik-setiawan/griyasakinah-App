<?php 
// ini ditampilkan sesuai kebutuhan page masing masing untuk MODAL BOOTSTRAP
  $url_cek = cek_url();
?>

<?php
if($url_cek == 'inventaris/daftar_barang/'){
    ?>
        <script type="text/javascript">
            $("#produk_list2").DataTable({
                "responsive": false,
                "autoWidth": false,
                "lengthChange": true,
                "lengthMenu": [50, 100],
                "order": [
                    [1, 'asc']
                ],
                "columnDefs": [{
                    "targets": -1,
                    "orderable": false,
                }],
            });

            var table;
            $(document).ready(function() {
                //datatables
                table = $('#produk_list').DataTable({ 
                    "responsive"    : false,
                    "autoWidth"     : true,
                    "lengthChange"  : true,
                    "lengthMenu"    : [10,20,50, 100],

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?=site_url('inventaris/ajax_produk/')?>",
                        "type": "POST",
                        "data": function ( data ) {
                            data.kategori_produk = $('#kategori_produk').val();
                            data.id_lembaga = $('#id_lembaga').val();
                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        { 
                            "targets": [ -1, 3, 4 ], //first column / numbering column
                            "orderable": false, //set not orderable
                        },
                        { 
                            "targets": [ -1, 0, 2, 3 ], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                        { 
                            "targets": [ 4 ], //first column / numbering column
                            "className": 'text-right', //set not orderable
                        },
                    ],

                });

                $('#kategori_produk').change(function(){ //button reset event click
                    table.ajax.reload(null, false);  //just reload table
                });

            });


            $(document).on('click', '#view_history', function() {
                var produk_id = $(this).data('detail_id');
                window.location='<?=site_url('produk/history/')?>' + produk_id;
            })

            $(document).on('click', '#tambah_produk', function() {
                $('#nama_produk').val('');
                $('#kode_barang').val('');
                $('#kategori_produk2').val(0);
                $('#unit_produk').val(0);
                $('#estimasi_harga').val(0);
            })

            $(document).on('click', '#set_edit', function() {
                var id_produk = $(this).data('id_produk')
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('inventaris/proses/')?>',
                    data    : {
                        'get_produk'      : true, 
                        'id_produk'    : id_produk,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#edit_id_produk').val(data.id_produk);
                        $('#edit_nama_produk').val(data.nama_produk);
                        $('#edit_kode_produk').val(data.kode_produk);
                        $('#edit_kategori_produk').val(data.kategori);
                        $('#edit_unit_produk').val(data.unit);
                        $('#edit_harga').val(data.harga);
                    }
                })
            });

            $(document).on('click', '#set_delete', function() {
                var id_produk = $(this).data('id_produk')
                var stok_akhir = $(this).data('stok_akhir')
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('inventaris/proses/')?>',
                    data    : {
                        'get_produk'    : true, 
                        'id_produk'     : id_produk,
                        'stok_akhir'    : stok_akhir,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#delete_id_produk').val(data.id_produk);
                        $('#del_nama_barang').text(data.nama_produk);
                        $('#del_kode_barang').text(data.kode_produk);
                        $('#del_kategori').text(data.nama_kategori);
                        $('#del_unit').text(data.nama_unit);
                        $('#del_unit2').text(data.nama_unit);
                        $('#del_harga').text(data.harga_rp);
                        $('#del_stok').text(data.stok_akhir);
                        $('#del_stok2').val(data.stok);
                    }
                })
            });

            $(document).on('click', '#add_produk_save', function() {
                var nama_produk         = $('#nama_produk').val()
                var kode_barang         = $('#kode_barang').val()
                var kategori_produk     = $('#kategori_produk2').val()
                var unit_produk         = $('#unit_produk').val()
                var estimasi_harga      = $('#estimasi_harga').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'add_produk'        : true, 
                        'nama_produk'       : nama_produk,
                        'kode_barang'       : kode_barang,
                        'kategori_produk'   : kategori_produk,
                        'unit_produk'       : unit_produk,
                        'estimasi_harga'    : estimasi_harga,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Produk berhasil diinput...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#add-produk').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nama Produk wajib diisi...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kode barang wajib diisi dan tidak boleh sama',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kategori Produk belum dipilih',
                                })
                            }else if(result.status == 4){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Unit Produk belum dipilih',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#edit_produk_save', function() {
                var nama_produk         = $('#edit_nama_produk').val()
                var kode_barang         = $('#edit_kode_produk').val()
                var kategori_produk     = $('#edit_kategori_produk').val()
                var unit_produk         = $('#edit_unit_produk').val()
                var estimasi_harga      = $('#edit_harga').val()
                var id_produk           = $('#edit_id_produk').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'edit_produk'       : true, 
                        'nama_produk'       : nama_produk,
                        'kode_barang'       : kode_barang,
                        'kategori_produk'   : kategori_produk,
                        'unit_produk'       : unit_produk,
                        'estimasi_harga'    : estimasi_harga,
                        'id_produk'         : id_produk,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Produk berhasil diinput...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#edit-item').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nama Produk wajib diisi...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kode barang wajib diisi dan tidak boleh sama',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kategori Produk belum dipilih',
                                })
                            }else if(result.status == 4){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Unit Produk belum dipilih',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#delete_produk_save', function() {
                var id_produk   = $('#delete_id_produk').val()
                var stok        = $('#del_stok2').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'del_produk'   : true, 
                        'id_produk'     : id_produk,
                        'stok'          : stok,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Produk berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#delete-item').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Stok Masih tersedia, data tidak bisa dihapus...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal dihapus',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#add_kategori_save', function() {
                var nama_kategori   = $('#nama_kategori').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'add_kategori'  : true, 
                        'nama_kategori' : nama_kategori,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Kategori Produk berhasil dibuat...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location='<?=site_url('inventaris/daftar_barang/')?>';
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nama Kategori tidak boleh kosong...',
                                })
                            }else{
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

            $(document).on('click', '#add_unit_save', function() {
                var nama_unit   = $('#nama_unit').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'add_unit'  : true, 
                        'nama_unit' : nama_unit,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Unit Produk berhasil dibuat...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location='<?=site_url('inventaris/daftar_barang/')?>';
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nama Unit tidak boleh kosong...',
                                })
                            }else{
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

            // cetak_laporan
            $(document).on('click', '#cetak_laporan', function() {
                var kategori = $('#kategori_produk').val();
                window.open('<?=site_url('cetak/daftarbarang/')?>' + kategori + '?pdf=0', '_blank', 'width=900,height=800');
            })

            // download pdf laporan
            $(document).on('click', '#download_laporan', function() {
                var kategori = $('#kategori_produk').val();
                window.open('<?=site_url('cetak/daftarbarang/')?>' + kategori + '?pdf=1', '_blank');
            })



        </script>
    
    <?php
}elseif($url_cek == 'inventaris/kategori_list/'){
    ?>
        <script>
            $(function() {
                $("#list_kategori").DataTable({
                    "responsive": false,
                    "autoWidth": false,
                    "lengthChange": true,
                    "lengthMenu": [50, 100],
                    "order": [
                        [0, 'asc']
                    ],
                    "columnDefs": [{
                        "targets": -1,
                        "orderable": false,
                    }],
                });

            });

            $(document).on('click', '#edit_kategori', function() {
                $('#id_kat').val($(this).data('id_kategori'));
                $('#nama_kategori').val($(this).data('nama_kategori'));
            })

            $(document).on('click', '#kategori_save', function() {
                var nama_kategori   = $('#nama_kategori').val()
                var id_kategori     = $('#id_kat').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'edit_kategori'  : true, 
                        'nama_kategori' : nama_kategori,
                        'id_kategori' : id_kategori,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Kategori Produk berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location='<?=site_url('inventaris/kategori_list/')?>';
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nama Kategori tidak boleh kosong...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nama Kategori belum diubah',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#delete_kategori', function() {
                var id_kategori     = $(this).data('id_kategori')

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'del_kategori'  : true, 
                        'id_kategori' : id_kategori,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Kategori Produk berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location='<?=site_url('inventaris/kategori_list/')?>';
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Kategori tidak bisa dihapus!!!',
                                    text: 'Kategori sudah terpakai...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal Hapus',
                                })
                            }
                        }
                    }
                })
            })

        </script>
    <?php
}elseif($url_cek == 'inventaris/unit_list/'){
    ?>
        <script>
            $(function() {
                $("#list_unit").DataTable({
                    "responsive": false,
                    "autoWidth": false,
                    "lengthChange": true,
                    "lengthMenu": [50, 100],
                    "order": [
                        [0, 'asc']
                    ],
                    "columnDefs": [{
                        "targets": -1,
                        "orderable": false,
                    }],
                });
            });

            $(document).on('click', '#edit_unit', function() {
                $('#id_unit').val($(this).data('id_unit'));
                $('#nama_unit').val($(this).data('nama_unit'));
            })

            $(document).on('click', '#unit_save', function() {
                var nama_unit   = $('#nama_unit').val()
                var id_unit     = $('#id_unit').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'edit_unit' : true, 
                        'nama_unit' : nama_unit,
                        'id_unit'   : id_unit,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Unit Produk berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location='<?=site_url('inventaris/unit_list/')?>';
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nama Unit tidak boleh kosong...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nama Unit belum diubah',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#delete_unit', function() {
                var id_unit     = $(this).data('id_unit')

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'del_unit'  : true, 
                        'id_unit'   : id_unit,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Unit Produk berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location='<?=site_url('inventaris/unit_list/')?>';
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Unit tidak bisa dihapus!!!',
                                    text: 'Unit sudah terpakai...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal Hapus',
                                })
                            }
                        }
                    }
                })
            })

        </script>
    <?php
}elseif($url_cek == 'inventaris/stok/'){
    ?>
        <script>
            arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            arrbulan2 = ["01","02","03","04","05","06","07","08","09","10","11","12"];
            date = new Date();
            tanggal = date.getDate();
            bulan = date.getMonth();
            tahun = date.getFullYear();
            var periode_bulan = tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal + ' - ' + tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal;
            var bulan_ini = arrbulan[bulan] +' '+ tahun;
            $('#periode_laporan').text(bulan_ini);

            $(function() {

                $('#hari_ini').daterangepicker({
                    locale: {
                    format: 'YYYY-MM-DD'
                    }
                })

                $('#tanggal_stok_in').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#tanggal_stok_out').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#tanggal_edit').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

            });

            var table;
            $(document).ready(function() {
                table = $('#history_stok').DataTable({ 
                    "responsive"    : false,
                    "autoWidth"     : false,
                    "lengthChange"  : true,
                    "lengthMenu"    : [10,20,50, 100],

                    "processing"    : true, //Feature control the processing indicator.
                    "serverSide"    : true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url"   : "<?=site_url('inventaris/ajax_stok/')?>",
                        "type"  : "POST",
                        "data"  : function ( data ) {
                            data.periode = $('#hari_ini').val();
                            data.id_lembaga = $('#id_lembaga').val();
                            data.tipe_stok = $('#tipe_stok').val();
                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        { 
                            "targets": [ -1, 0, 2, 3 ], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                        { 
                            "targets": [ -1, 2 ], //first column / numbering column
                            "orderable": false, //set not orderable
                        },

                    ],

                });

                $('#hari_ini').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                    var periodenya = $('#hari_ini').val();
                    if(periodenya == periode_bulan){
                        $('#periode_laporan').text(bulan_ini);
                    }else{
                        $('#periode_laporan').text(periodenya);
                    }
                });

                $('#tipe_stok').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                });

            });

            $(document).on('click', '#barang_masuk', function() {
                $('#tanggal_stok_in').val('<?=date('Y-m-d')?>');
                $('#nama_barang_in').val(null).trigger('change');
                $('#quantity_in').val(0);
                $('#keterangan_in').val('');
            });

            $(document).on('click', '#barang_keluar', function() {
                $('#tanggal_stok_out').val('<?=date('Y-m-d')?>');
                $('#nama_barang_out').val(null).trigger('change');
                $('#quantity_out').val(0);
                $('#keterangan_out').val('');

            });

            $(document).on('click', '#add_pemasukkan', function() {
                var tanggal         = $('#tanggal_stok_in').val()
                var nama_barang     = $('#nama_barang_in').val()
                var quantity        = $('#quantity_in').val()
                var keterangan      = $('#keterangan_in').val()
                var tipe            = $('#tipe_pemasukkan').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'add_stok'      : true, 
                        'tanggal'       : tanggal,
                        'nama_barang'   : nama_barang,
                        'quantity'      : quantity,
                        'keterangan'    : keterangan,
                        'tipe'          : tipe,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Barang Masuk berhasil diinput...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#stok_in').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Barang belum dipilih...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Quantity Wajib diisi dan tidak boleh 0 (nol)',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Keterangan Wajib diisi',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#add_pengeluaran', function() {
                var tanggal         = $('#tanggal_stok_out').val()
                var nama_barang     = $('#nama_barang_out').val()
                var quantity        = $('#quantity_out').val()
                var keterangan      = $('#keterangan_out').val()
                var tipe            = $('#tipe_pengeluaran').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'add_stok'          : true, 
                        'tanggal'           : tanggal,
                        'nama_barang'       : nama_barang,
                        'quantity'          : quantity,
                        'keterangan'        : keterangan,
                        'tipe'              : tipe,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Barang Masuk berhasil diinput...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#stok_out').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Barang belum dipilih...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Quantity Wajib diisi dan tidak boleh 0 (nol)',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Keterangan Wajib diisi',
                                })
                            }else if(result.status == 4){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Stok Kosong...',
                                    text: 'Maaf stok barang kosong...',
                                })
                            }else if(result.status == 5){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Stok Kurang...',
                                    text: 'Maaf stok barang tidak mencukupi...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#set_edit', function() {
                var id_stok = $(this).data('id_stok')
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('inventaris/proses/')?>',
                    data    : {
                        'get_stok'  : true, 
                        'id_stok'   : id_stok,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#tanggal_edit').val(data.tanggal);
                        $('#nama_barang_edit').val(data.produk).trigger('change');
                        $('#quantity_edit').val(data.quantity);
                        $('#quantity_old').val(data.quantity);
                        $('#keterangan_edit').val(data.keterangan);
                        $('#tipe_stok_edit').val(data.stok_tipe);
                        $('#id_stok_edit').val(data.id_stok);
                        if(data.stok_tipe == 1){
                            $('#text_tipe').text('Barang Masuk');
                            $('#class_tipe').removeClass('bg-gradient-danger').addClass('bg-gradient-primary');
                        }else{
                            $('#text_tipe').text('Barang Keluar');
                            $('#class_tipe').removeClass('bg-gradient-primary').addClass('bg-gradient-danger');
                        }
                    }
                })
            });

            $(document).on('click', '#set_delete', function() {
                var id_stok = $(this).data('id_stok')
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('inventaris/proses/')?>',
                    data    : {
                        'get_stok'  : true, 
                        'id_stok'   : id_stok,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#del_tanggal').text(data.tanggal);
                        $('#del_kode_barang').text(data.kode_produk);
                        $('#del_nama_barang').text(data.nama_produk);
                        $('#del_kategori').text(data.nama_kategori);
                        $('#del_satuan').text(data.nama_unit);
                        $('#del_quantity').text(data.quantity);
                        $('#del_keterangan').text(data.keterangan);
                        $('#tipe_stok_edit').text(data.stok_tipe);
                        $('#del_id').val(data.id_stok);
                        if(data.stok_tipe == 1){
                            $('#del_status').text('Barang Masuk');
                            $('#del_status2').removeClass('bg-gradient-danger').addClass('bg-gradient-primary');
                        }else{
                            $('#del_status').text('Barang Keluar');
                            $('#del_status2').removeClass('bg-gradient-primary').addClass('bg-gradient-danger');
                        }
                    }
                })
            });


            $(document).on('click', '#edit_data', function() {
                var tanggal         = $('#tanggal_edit').val()
                var nama_barang     = $('#nama_barang_edit').val()
                var quantity        = $('#quantity_edit').val()
                var keterangan      = $('#keterangan_edit').val()
                var tipe            = $('#tipe_stok_edit').val()
                var quantity_old    = $('#quantity_old').val()
                var id_stok         = $('#id_stok_edit').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'edit_stok'     : true, 
                        'tanggal'       : tanggal,
                        'nama_barang'   : nama_barang,
                        'quantity'      : quantity,
                        'quantity_old'  : quantity_old,
                        'keterangan'    : keterangan,
                        'tipe'          : tipe,
                        'id_stok'       : id_stok,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Barang berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#edit-item').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Barang belum dipilih...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Quantity Wajib diisi dan tidak boleh 0 (nol)',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Keterangan Wajib diisi',
                                })
                            }else if(result.status == 4){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Stok Kosong...',
                                    text: 'Maaf stok barang kosong...',
                                })
                            }else if(result.status == 5){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Stok Kurang...',
                                    text: 'Maaf stok barang tidak mencukupi...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#yes_delete', function() {
                var del_id  = $('#del_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('inventaris/proses/')?>',
                    data: {
                        'del_stok'  : true, 
                        'del_id'    : del_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Keluar Masuk Barang berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#delete-item').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Data Gagal diproses',
                            })
                        }
                    }
                })
            })

            // cetak_laporan
            $(document).on('click', '#cetak_laporan', function() {
                var periode = $('#hari_ini').val();
                var tipe = $('#tipe_stok').val();
                window.open('<?=site_url('cetak/in_out/?periode=')?>' + periode + '&tipe=' + tipe+ '&pdf=0', '_blank', 'width=900,height=800');
            })

            // download pdf laporan
            $(document).on('click', '#download_laporan', function() {
                var periode = $('#hari_ini').val();
                var tipe = $('#tipe_stok').val();
                window.open('<?=site_url('cetak/in_out/?periode=')?>' + periode + '&tipe=' + tipe+ '&pdf=1', '_blank');
            })
            
        </script>
    <?php
}elseif($url_cek == 'inventaris/laporan/'){
    ?>
        <script>
            arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            arrbulan2 = ["01","02","03","04","05","06","07","08","09","10","11","12"];
            date = new Date();
            tanggal = date.getDate();
            bulan = date.getMonth();
            tahun = date.getFullYear();
            var periode_bulan = tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal + ' - ' + tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal;
            var bulan_ini = arrbulan[bulan] +' '+ tahun;
            $('#periode_laporan').text(bulan_ini);

            $(function() {
                $('#hari_ini').daterangepicker({
                    locale: {
                    format: 'YYYY-MM-DD'
                    }
                })
            });

            var table;
            $(document).ready(function() {
                table = $('#laporan_bulanan').DataTable({ 
                    "responsive"    : false,
                    "autoWidth"     : false,
                    "lengthChange"  : true,
                    "lengthMenu"    : [10,20,50, 100],

                    "processing"    : true, //Feature control the processing indicator.
                    "serverSide"    : true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url"   : "<?=site_url('inventaris/ajax_laporan/')?>",
                        "type"  : "POST",
                        "data"  : function ( data ) {
                            data.periode = $('#hari_ini').val();
                            data.id_lembaga = $('#id_lembaga').val();
                            data.kategori_produk = $('#kategori_produk').val();
                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        { 
                            "targets": [ -1, 0, 3, 4 ], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                        { 
                            "targets": [ -1, 3, 4 ], //first column / numbering column
                            "orderable": false, //set not orderable
                        },

                    ],

                });

                $('#hari_ini').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                    var periodenya = $('#hari_ini').val();
                    if(periodenya == periode_bulan){
                        $('#periode_laporan').text(bulan_ini);
                    }else{
                        $('#periode_laporan').text(periodenya);
                    }
                });

                $('#kategori_produk').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                });

            });

            // cetak_laporan
            $(document).on('click', '#cetak_laporan', function() {
                var periode = $('#hari_ini').val();
                var tipe = $('#kategori_produk').val();
                window.open('<?=site_url('cetak/laporan_barang/?periode=')?>' + periode + '&tipe=' + tipe+ '&pdf=0', '_blank', 'width=900,height=800');
            })

            // download pdf laporan
            $(document).on('click', '#download_laporan', function() {
                var periode = $('#hari_ini').val();
                var tipe = $('#kategori_produk').val();
                window.open('<?=site_url('cetak/laporan_barang/?periode=')?>' + periode + '&tipe=' + tipe+ '&pdf=1', '_blank');
            })


        </script>
    <?php
}elseif($url_cek == 'laporan_keuangan/bulanan/'){
    ?>
        <script>
            arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            arrbulan2 = ["01","02","03","04","05","06","07","08","09","10","11","12"];
            date = new Date();
            tanggal = date.getDate();
            bulan = date.getMonth();
            tahun = date.getFullYear();
            var periode_bulan = tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal + ' - ' + tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal;
            var bulan_ini = arrbulan[bulan] +' '+ tahun;
            $('#periode_laporan').text(bulan_ini);

            //Date range picker
            $('#hari_ini').daterangepicker({
                locale: {
                format: 'YYYY-MM-DD'
                }
            })
            $('#tanggal_input').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            $('#tanggal_input2').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            $('#tanggal_input3').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            $('#tanggal_input4').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#tipeTransaksi').select2({
                placeholder: "Tipe Transaksi",
                allowClear: true
            })

            $('#kategoriTransaksi').select2({
                placeholder: "Pilih tipe Transaksi dulu",
                allowClear: true
            })

            var table;
            $(document).ready(function() {
                table = $('#view_laporan_keuangan').DataTable({ 
                    "responsive"    : false,
                    "autoWidth"     : true,
                    "lengthChange"  : false,
                    "ordering"      : false,
                    "lengthMenu"    : [[-1], ["All"]],

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url"   : "<?=site_url('laporan_keuangan/bulanan_ajax/')?>",
                        "type"  : "POST",
                        "data"  : function ( data ) {
                            data.periode = $('#hari_ini').val();
                            data.id_lembaga = $('#id_lembaga').val();
                            data.kategori_transaksi = $('#kategoriTransaksi').val();
                            data.tipe = $('#tipeTransaksi').val()

                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        { 
                            "targets": [ -1, 0, 2 ], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                        { 
                            "targets": [ 3, 4 ], //first column / numbering column
                            "className": 'text-right', //set not orderable
                        },
                    ],

                });

            });

            var tableA;
            $(document).ready(function() {
                tableA = $('#info_saldo').DataTable({ 
                    'paging'      : false,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : false,
                    'info'        : false,
                    'autoWidth'   : false,

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?=site_url('laporan_keuangan/saldo_ajax/')?>",
                        "type": "POST",
                        "data": function ( data ) {
                            data.periode = $('#hari_ini').val();
                            data.id_lembaga = $('#id_lembaga').val();
                            data.kategori_transaksi = $('#kategoriTransaksi').val();
                            data.tipe = $('#tipeTransaksi').val()
                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        { 
                            "targets": [ 0, 1, 2, 3 ], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                    ],

                });

            });

            $('#tipeTransaksi').change(function(){ //button filter event click
                var tipe = $('#tipeTransaksi').val()
                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('laporan_keuangan/proses/')?>',
                    data: {
                            'changeTipe'    : true, 
                            'tipe'          : tipe,
                        },
                    dataType: 'json',
                    success: function(data) {
                        if(data == null){
                            $('#kategoriTransaksi').empty();
                        }else{
                            var html = '';
                            var i;
                            for(i=0; i<data.length; i++){
                                html += '<option value='+data[i].id+'>'+data[i].nama_kategori+'</option>';
                            }
                            $('#kategoriTransaksi').html(html);
                        }
                    }
                })
                table.ajax.reload(null, false);  //just reload table
                tableA.ajax.reload(null, false);  //just reload table
            });

            $('#kategoriTransaksi').change(function(){ //button filter event click
                table.ajax.reload(null, false);  //just reload table
                tableA.ajax.reload(null, false);  //just reload table
            });


            $('#hari_ini').change(function(){ //button filter event click
                table.ajax.reload(null, false);  //just reload table
                tableA.ajax.reload(null, false);  //just reload table
                var periodenya = $('#hari_ini').val();
                if(periodenya == periode_bulan){
                    $('#periode_laporan').text(bulan_ini);
                }else{
                    $('#periode_laporan').text(periodenya);
                }
            });

            $(document).on('click', '#pemasukan', function() {
                $('#tanggal_input').val('<?=date('Y-m-d')?>');
                $('#kategori_pemasukan').val(0);
                $('#jumlah_pemasukkan').val('');
                $('#judul_pemasukkan').val('');
            });

            $(document).on('click', '#pengeluaran', function() {
                $('#tanggal_input2').val('<?=date('Y-m-d')?>');
                $('#kategori_pengeluaran').val(0);
                $('#jumlah_pengeluaran').val('');
                $('#judul_pengeluaran').val('');

            });

            $(document).on('click', '#add_pemasukkan', function() {
                var tanggal             = $('#tanggal_input').val()
                var kategori_pemasukan  = $('#kategori_pemasukan').val()
                var jumlah_pemasukkan   = $('#jumlah_pemasukkan').val()
                var judul_pemasukkan    = $('#judul_pemasukkan').val()
                var tipe_kas            = $('#tipe_kas').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('laporan_keuangan/proses/')?>',
                    data: {
                            'add_pemasukan'           : true, 
                            'tanggal'               : tanggal,
                            'kategori_pemasukan'    : kategori_pemasukan,
                            'jumlah_pemasukkan'     : jumlah_pemasukkan,
                            'judul_pemasukkan'      : judul_pemasukkan,
                            'tipe_kas'              : tipe_kas,
                        },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Pemasukan berhasil diinput...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#form-pemasukan').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                    tableA.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kategori belum dipilih...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jumlah Wajib diisi dan tidak boleh 0 (nol)',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Keterangan Wajib diisi',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#edit_pemasukkan', function() {
                var tanggal             = $('#tanggal_input3').val()
                var kategori_pemasukan  = $('#edit_kategori_pemasukan').val()
                var jumlah_pemasukkan   = $('#edit_jumlah_pemasukkan').val()
                var judul_pemasukkan    = $('#edit_judul_pemasukkan').val()
                var pemasukkan_id            = $('#edit_pemasukan_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('laporan_keuangan/proses/')?>',
                    data: {
                        'edit_pemasukan'        : true, 
                        'tanggal'               : tanggal,
                        'kategori_pemasukan'    : kategori_pemasukan,
                        'jumlah_pemasukkan'     : jumlah_pemasukkan,
                        'judul_pemasukkan'      : judul_pemasukkan,
                        'pemasukkan_id'         : pemasukkan_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Edit Data Pemasukan berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#edit-pemasukan').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                    tableA.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kategori belum dipilih...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jumlah Wajib diisi dan tidak boleh 0 (nol)',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Keterangan Wajib diisi',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Edit Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#add_pengeluaran', function() {
                var tanggal                 = $('#tanggal_input2').val()
                var kategori_pengeluaran    = $('#kategori_pengeluaran').val()
                var jumlah_pengeluaran      = $('#jumlah_pengeluaran').val()
                var judul_pengeluaran       = $('#judul_pengeluaran').val()
                var tipe_kas                = $('#tipe_kas2').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('laporan_keuangan/proses/')?>',
                    data: {
                        'add_pengeluaran'         : true, 
                        'tanggal'               : tanggal,
                        'kategori_pengeluaran'  : kategori_pengeluaran,
                        'jumlah_pengeluaran'    : jumlah_pengeluaran,
                        'judul_pengeluaran'     : judul_pengeluaran,
                        'tipe_kas'              : tipe_kas,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Pengeluaran berhasil diinput...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#form-pengeluaran').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                    tableA.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kategori belum dipilih...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jumlah Wajib diisi dan tidak boleh 0 (nol)',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Keterangan Wajib diisi',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#edit_pengeluaran', function() {
                var tanggal                 = $('#tanggal_input4').val()
                var kategori_pengeluaran    = $('#edit_kategori_pengeluaran').val()
                var jumlah_pengeluaran      = $('#edit_jumlah_pengeluaran').val()
                var judul_pengeluaran       = $('#edit_judul_pengeluaran').val()
                var pengeluaran_id          = $('#edit_pengeluaran_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('laporan_keuangan/proses/')?>',
                    data: {
                        'edit_pengeluaran'      : true, 
                        'tanggal'               : tanggal,
                        'kategori_pengeluaran'  : kategori_pengeluaran,
                        'jumlah_pengeluaran'    : jumlah_pengeluaran,
                        'judul_pengeluaran'     : judul_pengeluaran,
                        'pengeluaran_id'        : pengeluaran_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Edit Data Pengeluaran berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#edit-pengeluaran').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                    tableA.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kategori belum dipilih...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jumlah Wajib diisi dan tidak boleh 0 (nol)',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Keterangan Wajib diisi',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Edit Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#delete_transaksi', function() {
                var id_laporan  = $('#hapus_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('laporan_keuangan/proses/')?>',
                    data: {
                        'delete_laporan'    : true, 
                        'id_laporan'        : id_laporan,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Laporan Keuangan berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#delete-item').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                    tableA.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Delete Data Gagal diproses',
                            })
                        }
                    }
                })
            })

            $(document).on('click', '#set_edit_pemasukan', function() {
                var laporan_id = $(this).data('laporan_id')
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('laporan_keuangan/proses/')?>',
                    data    : {
                        'get_data'      : true, 
                        'laporan_id'    : laporan_id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#tanggal_input3').val(data.tanggal);
                        $('#edit_kategori_pemasukan').val(data.kategori);
                        $('#edit_jumlah_pemasukkan').val(data.nominal);
                        $('#edit_judul_pemasukkan').val(data.keterangan);
                        $('#edit_pemasukan_id').val(data.id_laporan);
                    }
                })
            });

            $(document).on('click', '#set_edit_pengeluaran', function() {
                var laporan_id = $(this).data('laporan_id')
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('laporan_keuangan/proses/')?>',
                    data    : {
                        'get_data'      : true, 
                        'laporan_id'    : laporan_id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#tanggal_input4').val(data.tanggal);
                        $('#edit_kategori_pengeluaran').val(data.kategori);
                        $('#edit_jumlah_pengeluaran').val(data.nominal);
                        $('#edit_judul_pengeluaran').val(data.keterangan);
                        $('#edit_pengeluaran_id').val(data.id_laporan);
                    }
                })
            });

            $(document).on('click', '#set_delete', function() {
                var laporan_id = $(this).data('laporan_id')
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('laporan_keuangan/proses/')?>',
                    data    : {
                        'get_data'      : true, 
                        'laporan_id'    : laporan_id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#hapus_tanggal').text(data.tanggal);
                        $('#hapus_kategori_transaksi').text(data.nama_kategori);
                        $('#hapus_nominal_transaksi').text(data.nominal_rp);
                        $('#hapus_keterangan_transaksi').text(data.keterangan);
                        $('#hapus_id').val(data.id_laporan);
                        if(data.tipe_id == 1){
                                $("#hapus_tipe_transaksi").text(data.tipe);
                                $("#bgr_hapus").addClass("bg-gradient-blue");
                            }else{
                                $("#hapus_tipe_transaksi").text(data.tipe);
                                $("#bgr_hapus").addClass("bg-gradient-red");
                            }

                    }
                })
            });

            // cetak_laporan
            $(document).on('click', '#cetak_laporan', function() {
                var periode = $('#hari_ini').val();
                window.open('<?=site_url('cetak/plkb/?periode=')?>' + periode + '&pdf=0', '_blank', 'width=900,height=800');
            })

            // download pdf laporan
            $(document).on('click', '#download_laporan', function() {
                var periode = $('#hari_ini').val();
                window.open('<?=site_url('cetak/plkb/?periode=')?>' + periode + '&pdf=1', '_blank');
            })

        </script>
    <?php
}elseif($url_cek == 'laporan_keuangan/tahunan/'){
    ?>
        <script>
            date = new Date();
            tahun = date.getFullYear();
            $('#periode_laporan').text(tahun);

            $('#tahun_laporan').select2({
                placeholder: "Pilih Tahun Laporan",
                allowClear: true
            })

            var tableA;
            $(document).ready(function() {
                tableA = $('#info_saldo').DataTable({ 
                    'paging'      : false,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : false,
                    'info'        : false,
                    'autoWidth'   : false,

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?=site_url('laporan_keuangan/saldo2_ajax/')?>",
                        "type": "POST",
                        "data": function ( data ) {
                            data.periode = $('#tahun_laporan').val();
                            data.id_lembaga = $('#id_lembaga').val();
                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        { 
                            "targets": [ 0, 1, 2, 3 ], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                    ],

                });

            });

            $('#tahun_laporan').change(function(){ //button filter event click
                var tahun2 = $('#tahun_laporan').val()
                if(tahun2 == ''){
                    $('#periode_laporan').text(tahun);
                }else{
                    $('#periode_laporan').text(tahun2);
                }
                tableA.ajax.reload(null, false);  //just reload table
                $('#load_laporan').load('<?=site_url('laporan_keuangan/laporan_tahunan/')?>' + tahun2)
            });

            // cetak_laporan
            $(document).on('click', '#cetak_laporan', function() {
                var periode = $('#tahun_laporan').val();
                window.open('<?=site_url('cetak/plkt/')?>' + periode + '?pdf=0', '_blank', 'width=900,height=800');
            })

            // download pdf laporan
            $(document).on('click', '#download_laporan', function() {
                var periode = $('#tahun_laporan').val();
                window.open('<?=site_url('cetak/plkt/')?>' + periode + '?pdf=1', '_blank');
            })

        </script>
    <?php
}elseif($url_cek == 'laporan_keuangan/setup/'){
    ?>
        <script>
            $(function() {
                $("#laporan_bulanan").DataTable({
                    "responsive": false,
                    "autoWidth": false,
                    "lengthChange": true,
                    "lengthMenu": [50, 100],
                    "order": [
                        [0, 'asc']
                    ],
                });
            });
        </script>
    <?php
}elseif($url_cek == 'rab/list/'){
    ?>
        <script>
            arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            arrbulan2 = ["01","02","03","04","05","06","07","08","09","10","11","12"];
            date = new Date();
            tanggal = date.getDate();
            bulan = date.getMonth();
            tahun = date.getFullYear();
            var periode_bulan = tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal + ' - ' + tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal;
            var bulan_ini = arrbulan[bulan] +' '+ tahun;
            $('#periode_laporan').text(bulan_ini);

            $(function() {
                $('#hari_ini').daterangepicker({
                    locale: {
                    format: 'YYYY-MM-DD'
                    }
                })

                $('#status_rab').select2({
                    placeholder: "Pilih Status",
                    allowClear: true
                })

            });

            var table;
            $(document).ready(function() {
                table = $('#daftar_rab').DataTable({ 
                    "responsive"    : false,
                    "autoWidth"     : false,
                    "lengthChange"  : true,
                    "lengthMenu"    : [10,20,50, 100],

                    "processing"    : true, //Feature control the processing indicator.
                    "serverSide"    : true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url"   : "<?=site_url('rab/ajax_list/')?>",
                        "type"  : "POST",
                        "data"  : function ( data ) {
                            data.periode = $('#hari_ini').val();
                            data.id_lembaga = $('#id_lembaga').val();
                            data.status_rab = $('#status_rab').val();
                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        { 
                            "targets": [ -1, 0, 3, 4 ], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                        { 
                            "targets": [ 2 ], //first column / numbering column
                            "className": 'text-right', //set not orderable
                        },
                        { 
                            "targets": [ -1, 3 ], //first column / numbering column
                            "orderable": false, //set not orderable
                        },

                    ],

                });

                $('#hari_ini').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                    var periodenya = $('#hari_ini').val();
                    if(periodenya == periode_bulan){
                        $('#periode_laporan').text(bulan_ini);
                    }else{
                        $('#periode_laporan').text(periodenya);
                    }
                });

                $('#status_rab').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                });


            });

            $(document).on('click', '#open_detail', function() {
                var id_detail = $(this).data('id_detail');
                window.location='<?=site_url('rab/detail/')?>' + id_detail;
            });

            $(document).on('click', '#cancel_rab', function() {
                var id_detail = $(this).data('id_detail');
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('rab/proses/')?>',
                    data    : {
                        'get_rab'   : true, 
                        'id_detail' : id_detail,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#nama_kegiatan').text(data.rab.judul_rab);
                        $('#waktu').text(data.rab.waktu);
                        $('#tempat').text(data.rab.lokasi);
                        $('#deskripsi').text(data.rab.keterangan);
                        $('#anggaran').text(data.anggaran);
                        $('#realisasi').text(data.realisasi);
                        $('#persen').text(data.persentasi);
                        $('#sisa').text(data.sisa);
                        $('#rab_id').val(id_detail);
                    }
                })
            });

            $(document).on('click', '#delete_rab', function() {
                var id_detail = $(this).data('id_detail');
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('rab/proses/')?>',
                    data    : {
                        'get_rab'   : true, 
                        'id_detail' : id_detail,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#del_nama_kegiatan').text(data.rab.judul_rab);
                        $('#del_waktu').text(data.rab.waktu);
                        $('#del_tempat').text(data.rab.lokasi);
                        $('#del_deskripsi').text(data.rab.keterangan);
                        $('#del_anggaran').text(data.anggaran);
                        $('#del_realisasi').text(data.realisasi);
                        $('#del_persen').text(data.persentasi);
                        $('#del_sisa').text(data.sisa);
                        $('#rab_id2').val(id_detail);
                    }
                })
            });

            $(document).on('click', '#finish_rab', function() {
                var id_detail = $(this).data('id_detail');
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('rab/proses/')?>',
                    data    : {
                        'get_rab'   : true, 
                        'id_detail' : id_detail,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#yes_nama_kegiatan').text(data.rab.judul_rab);
                        $('#yes_waktu').text(data.rab.waktu);
                        $('#yes_tempat').text(data.rab.lokasi);
                        $('#yes_deskripsi').text(data.rab.keterangan);
                        $('#yes_anggaran').text(data.anggaran);
                        $('#yes_realisasi').text(data.realisasi);
                        $('#yes_persen').text(data.persentasi);
                        $('#yes_sisa').text(data.sisa);
                        $('#yes_rab_id').val(id_detail);
                    }
                })
            });

            $(document).on('click', '#ya_cancel', function() {
                var rab_id  = $('#rab_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('rab/proses/')?>',
                    data: {
                        'cancel_rab'    : true, 
                        'rab_id'        : rab_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'RAB telah dibatalkan...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#cancel-rab').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
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

            $(document).on('click', '#ya_delete', function() {
                var rab_id      = $('#rab_id2').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('rab/proses/')?>',
                    data: {
                        'del_rab'   : true, 
                        'rab_id'    : rab_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'RAB berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#delete-rab').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
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

            $(document).on('click', '#ya_finish', function() {
                var rab_id      = $('#yes_rab_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('rab/proses/')?>',
                    data: {
                        'finish_rab'   : true, 
                        'rab_id'    : rab_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'RAB sudah selesai...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#finish-rab').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
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

            // cetak_laporan
            $(document).on('click', '#cetak_laporan', function() {
                var id = $(this).data('id_cetak');
                window.open('<?=site_url('cetak/rab_detail/')?>' + id + '?pdf=0', '_blank', 'width=900,height=800');
            })

            // download pdf laporan
            $(document).on('click', '#download_laporan', function() {
                var id = $(this).data('id_download');
                window.open('<?=site_url('cetak/rab_detail/')?>' + id + '?pdf=1', '_blank');
            })

        </script>
    <?php
}elseif($url_cek == 'rab/detail/'){
    ?>
        <script>
            // cetak_laporan
            $(document).on('click', '#cetak_laporan', function() {
                var id = $('#id_detail').val();
                window.open('<?=site_url('cetak/rab_detail/')?>' + id + '?pdf=0', '_blank', 'width=900,height=800');
            })

            // download pdf laporan
            $(document).on('click', '#download_laporan', function() {
                var id = $('#id_detail').val();
                window.open('<?=site_url('cetak/rab_detail/')?>' + id + '?pdf=1', '_blank');
            })

        </script>
    <?php
}elseif($url_cek == 'proyek/ajukan_proyek/'){
    ?>
        <script type="text/javascript">

            arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            arrbulan2 = ["01","02","03","04","05","06","07","08","09","10","11","12"];
            date = new Date();
            tanggal = date.getDate();
            bulan = date.getMonth();
            tahun = date.getFullYear();
            var periode_bulan = tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal + ' - ' + tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal;
            var bulan_ini = arrbulan[bulan] +' '+ tahun;
            $('#periode_laporan').text(bulan_ini);

            $(function() {

                $('#hari_ini').daterangepicker({
                    locale: {
                    format: 'YYYY-MM-DD'
                    }
                })

                $('#tgl_pengajuan').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#edit_tgl_pengajuan').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

            });
 
            var table;
            $(document).ready(function() {
                table = $('#table_list').DataTable({ 
                    "responsive"    : false,
                    "autoWidth"     : false,
                    "lengthChange"  : true,
                    "lengthMenu"    : [10,20,50, 100],
                    "processing"    : true, //Feature control the processing indicator.
                    "serverSide"    : true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url"   : "<?=site_url('proyek/ajax_list/')?>",
                        "type"  : "POST",
                        "data"  : function ( data ) {
                            data.periode = $('#hari_ini').val();
                            // data.status_rab = $('#status_rab').val();
                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        { 
                            "targets": [ 1,0,4,5 ], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                    ],

                });

                $('#hari_ini').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                    var periodenya = $('#hari_ini').val();
                    if(periodenya == periode_bulan){
                        $('#periode_laporan').text(bulan_ini);
                    }else{
                        $('#periode_laporan').text(periodenya);
                    }
                });
            });

            $(document).on('click', '#set_kav', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '<?= site_url('proyek/view_all_kavling'); ?>',
                    data: {id:id},
                    method: 'POST',
                    success: function(d){
                        $('#detail-kavling').html(d);
                    }
                });
                
            });

                $('#id_cluster').change(function(){
                    var id=$(this).val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_tipe');?>",
                            method : "POST",
                            data : {id: id},
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                
                                var html = '<option value="">-Pilih-</option>';
                                var i;
                                
                                for(i=0; i<data.length; i++){
                                    html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                                }
                                $('#id_tipe').html(html);
                                
                            }
                        });
                    return false;
                });

                $('#id_tipe').change(function(){ 
                    var id=$(this).val();
                    if(id == 0 ){
                        $('.tambahTipe').prop('disabled', true);
                    }else{
                        $('.tambahTipe').prop('disabled', false);
                    }
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_kavling');?>",
                            method : "POST",
                            data : {
                                id:id,
                            },
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                var html = '<option value="">-pilih-</option>';
                                var k;
                                
                                for(k=0; k<data.length; k++){
                                    html += '<option value='+data[k].id_kavling+'>'+data[k].blok+data[k].no_rumah +'</option>';
                                }

                                $('.kavling').html(html);
                            }
                        });
                    return false;
                });

            
            var x = 0;
            $('.tambahTipe').click(function() { //on add input button click
                x++;
                $('.tipe0').prop('disabled', true);
                $('.tipe').eq(-1).prop('disabled', true);
                
                    $('#containerTipe').append('' + '<div>' +
                        '<hr>' +
                        '<div class="form-group col-sm-12">' +
                            '<label>Pilih Cluster</label>' +
                            '<select class="form-control cluster'+x+' cluster" name="id_cluster[]" required>' +
                            '</select>' +
                        '</div>' +
                        '<div class="form-group col-sm-12">' +
                            '<label>Pilih Tipe</label>' +
                            '<select class="form-control tipe'+x+' tipe" name="id_tipe[]" required>' +
                            '</select>' +
                        '</div>' +
                        '<div class="form-group col-sm-12">' +
                            '<label>Pilih Kavling</label>' +
                            '<select class="form-control kavling'+x+'" name="kavling_id[]" multiple="multiple" required>' +
                            '</select>' +
                        '</div>'+
                        '<div class="form-group col-sm-12">'+
                            '<button class="btn btn-danger btn-sm hapusTipe col-12"><i class="fa fa-trash"></i> Hapus</button>'+
                        '</div>'+
                        '</div>'
                    );
                    // $('.tambahTipe').prop('disabled', true);
                    // var selected = $("select[name='id_cluster[]'] option").filter(':selected').map(function(){return $(this).val();}).get();
                    var selected = $("select[name='id_tipe[]'] option").filter(':selected').map(function(){return $(this).val();}).get();
                    var optionLength = 0;

                    $('.kavling'+x+',.tipe'+x+',.cluster'+x+'').select2({
                        placeholder: "-Pilih-",
                        allowClear: true
                    })

                            $.ajax({
                                url : "<?php echo site_url('proyek/get_cluster_ajax');?>",
                                method : "POST",
                                async : true,
                                dataType : 'json',
                                success: function(data){ 
                                    var html = '<option value="0">-pilih-</option>';
                                    var i;
                                    var status = true;
                                    optionLength = data.length;
                                   
                                    for(i=0; i<data.length; i++){
                                        html += '<option value='+data[i].id_cluster+'>'+data[i].nama_cluster+'</option>';
                                        status = true;
                                    }
                                    $('.cluster'+ x +'').html(html);
                                }
                            });

                            $('.cluster'+x+'').change(function(){ 
                                var id=$(this).val();
                                // if(id == 0 ){
                                //     $('.tambahTipe').prop('disabled', true);
                                // }else{
                                //     if((optionLength-1) !== selected.length){
                                //         $('.tambahTipe').prop('disabled', false);
                                //     }
                                // }
                                $.ajax({
                                    url : "<?php echo site_url('proyek/get_tipe');?>",
                                    method : "POST",
                                    async : true,
                                    data : {id: id},
                                    dataType : 'json',
                                    success: function(data){ 
                                        var html = '<option value="0">-pilih-</option>';
                                        var i;
                                        var status = true;
                                        // optionLength = data.length;
                                        // if((data.length-1) == selected.length){
                                        //     $('.tambahTipe').prop('disabled', true);
                                        // }else{
                                        //     $('.tambahTipe').prop('disabled', false);
                                        // }
                                        for(i=0; i<data.length; i++){
                                            $.each(selected, function( index, value ) {
                                                if(data[i].id_tipe == value){
                                                    status = false;
                                                }
                                            });
                                            if(status === true){
                                                    html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                                            }else{
                                                    html += '<option value='+data[i].id_tipe+' disabled>'+data[i].tipe+'</option>';
                                            }
                                            status = true;
                                        }
                                        $('.tipe'+ x +'').html(html);
                                    }
                                });
                            });

                            $('.tipe'+x+'').change(function(){ 
                                var id=$(this).val();
                                if(id == 0 ){
                                    $('.tambahTipe').prop('disabled', true);
                                }else{
                                    if((optionLength-1) !== selected.length){
                                        $('.tambahTipe').prop('disabled', false);
                                    }
                                }
                                    $.ajax({
                                        url : "<?php echo site_url('proyek/get_kavling');?>",
                                        method : "POST",
                                        data : {id: id},
                                        async : true,
                                        dataType : 'json',
                                        success: function(data){ 
                                            var html = '';
                                            var i;
                                            
                                            for(i=0; i<data.length; i++){
                                                html += '<option value='+data[i].id_kavling+'>'+data[i].blok+ data[i].no_rumah+'</option>';
                                            }

                                            $('.kavling'+x+'').html(html);
                                        }
                                    });
                            });

                            
                            $('#containerTipe').on("click", ".hapusTipe", function(e) { //user click on remove text
                                var selecteds = $("select[name='id_tipe[]'] option").filter(':selected').map(function(){return $(this).val();}).get();
                                if(selecteds.length == 1){
                                    $('.tipe0').prop('disabled', false);
                                }else{
                                    $('.tipe0').prop('disabled', true);
                                }
                                $( ".tipe" ).last().prop('disabled', false);
                                $('.tambahTipe').prop('disabled', false);
                                e.preventDefault();
                                $(this).parent('div').parent('div').remove();
                            })
            });
            
            $(document).on('click', '#tambah_pengajuan', function() {
                $('#kavling_id').val();
                $('#nama_proyek').val('');
                $('#tgl_pengajuan').val('<?=date('Y-m-d')?>');
            });

            $(document).on('click', '#save', function() {
                var kavling_id              = $("select[name='kavling_id[]'] option").filter(':selected').map(function(){return $(this).val();}).get();
                var nama_proyek             = $('#nama_proyek').val();
                var tgl_pengajuan           = $('#tgl_pengajuan').val();
              
                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('proyek/proses/')?>',
                    data: {
                        'add_pengajuan'         : true, 
                        'kavling_id'            : kavling_id,
                        'nama_proyek'           : nama_proyek,
                        'tgl_pengajuan'         : tgl_pengajuan,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Pengajuan berhasil diinput...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    location.reload();
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Rab wajib diisi...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#approve', function() {
                var id = $(this).data('id');
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('proyek/proses/')?>',
                    data    : {
                        'get_approve'   : true, 
                        'id' : id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#id').val(id);
                    }
                })
            });

            $(document).on('click', '#approve_save', function() {
                var id      = $('#id').val();
                // var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('proyek/proses/')?>',
                    data: {
                        'approve_pengajuan'   : true, 
                        'id'                  : id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil di Approve...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#approve-item').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
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

            $(document).on('click', '#tolak_save', function() {
                var id      = $('#id').val();
                // var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('proyek/proses/')?>',
                    data: {
                        'tolak_pengajuan'   : true, 
                        'id'                  : id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil di Tolak...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#tolak-item').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
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

            $(document).on('click', '#set_edit', function() {
                var id = $(this).data('id');
                var proyek_id = $(this).data('proyek_id')

                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('Proyek/proses/')?>',
                    data    : {
                        'get_pengajuan'      : true, 
                        'id'        : id,
                        'proyek_id'     : proyek_id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#edit_id').val(data.id);
                        $('#edit_tgl_pengajuan').val(data.tgl_pengajuan);
                        $('#edit_nama_proyek').val(data.nama_proyek);
                        $('#edit_kavling_id').val(data.kavling_id);
                        $('#edit_proyek_id').val(data.proyek_id);
                    }
                })
            });

            $('#edit_save').on('click', function(){
                var tgl_pengajuan = $('#edit_tgl_pengajuan').val();
                var nama_proyek = $('#edit_nama_proyek').val();
                var kavling_id = $('#edit_kavling_id').val();
                var id = $('#edit_id').val();

                $.ajax({
                    url:'<?= site_url('proyek/proses/'); ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        'edit_pengajuan'         : true, 
                        'id'                     : id,
                        'tgl_pengajuan'          : tgl_pengajuan,
                        'nama_proyek'            : nama_proyek,
                        'kavling_id'             : kavling_id,
                    },
                    success: function(result){
                        if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Calon Konsumen berhasil edit...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        $('#edit-pengajuan').modal('hide')
                                        table.ajax.reload(null, false);  //just reload table
                                    }
                                )
                        } else {
                            if(result.status == 1) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Tgl Pengajuan wajib diisi...',
                                    })
                                }else if(result.status == 2){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Nama Proyek wajib diisi',
                                    })
                                }else if(result.status == 3){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Kavling wajib di isi',
                                    })
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Data Gagal diproses',
                                    })
                                }
                        }
                    }
                });
            });

            $(document).on('click', '#set_delete', function() {
                var id = $(this).data('id')
                // var proyek_id = $(this).data('proyek_id')
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('Proyek/proses/')?>',
                    data    : {
                        'get_pengajuan'    : true, 
                        'id'     : id,
                        // 'proyek_id'     : proyek_id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#delete_id').val(data.id);
                        // $('#proyek_id').val(data.proyek_id);
                    }
                })
            });

            $(document).on('click', '#del_data', function() {
                var id   = $('#delete_id').val()
                // var proyek_id   = $('#proyek_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('Proyek/proses/')?>',
                    data: {
                        'del_pengajuan'   : true, 
                        'id'     : id,
                        // 'proyek_id'     : proyek_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Pengajuan berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#del-pengajuan').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Stok Masih tersedia, data tidak bisa dihapus...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal dihapus',
                                })
                            }
                        }
                    }
                })
            });



           $(document).on('click','.btn-end',function(){
                let id = $(this).data('id');
                
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Untuk mengakhiri proyek ini",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                    }).then((result) => {
                    if (result.value) {

                        let link = '<?= site_url('proyek/ended_proyek/'); ?>';
                        $.ajax({
                            url: link,
                            data: {id:id},
                            dataType: 'JSON',
                            type: 'POST',
                            success: function(d){
                                if(d.success == true){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: d.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    table.ajax.reload(null, false);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: d.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    table.ajax.reload(null, false);
                                }
                            }
                        });

                    }
                })

            });


            $(document).on('click','.btn-print',function(){
                let id = $(this).data('id');
                let link = '<?= site_url('proyek/print_proyek/'); ?>' + id;
                window.open(link);
            });


        </script>
    <?php
}elseif($url_cek == 'proyek/detail_rab/'){
    ?>
        <script type="text/javascript">

            $('#tabel_material').dataTable();
            $('#list_upah').dataTable();
            $('#list_lainnya').dataTable();

            //tambah Drop
            $('#id_kategori').on('change', function(){
                var id = $(this).val();
                $.ajax({
                    url: '<?= site_url('master/get_mat'); ?>',
                    dataType: 'JSON',
                    data: {id:id},
                    type: 'POST',
                    success: function(data){
                            var html = '<option value="">-pilih-</option>';
                            var i;
                            for(i=0; i<data.length; i++){
                                html += '<option value='+data[i].id+'>'+data[i].nama_material+'</option>';
                            }
                            $('#id_material').html(html); 
                    }
                });
            });

            $('#id_material').on('change', function(){
                var id = $('#id_material').val();
                if(id == ""){
                    $('#sat_material').val();
                }else{
                    $.ajax({
                        url: '<?= site_url('master/get_sat'); ?>',
                        dataType: 'JSON',
                        data: {id:id},
                        type: 'POST',
                        success: function(d){
                            console.log(d);
                            $('#sat_material').val(d.nama_satuan);
                        }
                    });
                }
            });

            //Edit Drop
            $('#id_kategori_e').on('change', function(){
                var id = $(this).val();
                $.ajax({
                    url: '<?= site_url('master/get_mat'); ?>',
                    dataType: 'JSON',
                    data: {id:id},
                    type: 'POST',
                    success: function(data){
                            var html = '<option value="">-pilih-</option>';
                            var i;
                            for(i=0; i<data.length; i++){
                                html += '<option value='+data[i].id+'>'+data[i].nama_material+'</option>';
                            }
                            $('#id_material_e').html(html); 
                    }
                });
            });

            $('#id_material_e').on('change', function(){
                var id = $('#id_material_e').val();
                if(id == ""){
                    $('#sat_material_e').val();
                }else{
                    $.ajax({
                        url: '<?= site_url('master/get_sat'); ?>',
                        dataType: 'JSON',
                        data: {id:id},
                        type: 'POST',
                        success: function(d){
                            console.log(d);
                            $('#sat_material_e').val(d.nama_satuan);
                        }
                    });
                }
            });

            //Drop Material Cluster,Tipe,Kavling
            $('#id_cluster').change(function(){
                    var id=$(this).val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_tipe_id_rab');?>",
                            method : "POST",
                            data : {id: id},
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                
                                var html = '<option value="">-Pilih-</option>';
                                var i;
                                
                                for(i=0; i<data.length; i++){
                                    html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                                }
                                $('#id_kavling_mat').html(html);
                                
                            }
                        });
                    return false;
                });

                $('#id_kavling_mat').change(function(){ 
                    var id=$(this).val();
                    let id_pro = $('.proyek_id_mat').val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_kavling_id_rab');?>",
                            method : "POST",
                            data : {
                                id:id,
                                id_pro:id_pro
                            },
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                var html = '<option value="">-pilih-</option>';
                              
                                var k;
                                
                                for(k=0; k<data.length; k++){
                                    html += '<option value='+data[k].id_kavling+' selected>'+data[k].blok+data[k].no_rumah+'</option>';
                                }

                                $('#blok_mat').html(html);
                            }
                        });
                    return false;
            });

            $('#edit_id_cluster').change(function(){
                    var id=$(this).val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_tipe_id_rab');?>",
                            method : "POST",
                            data : {id: id},
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                
                                var html = '<option value="">-Pilih-</option>';
                                var i;
                                
                                for(i=0; i<data.length; i++){
                                    html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                                }
                                $('#edit_id_kavling_mat').html(html);
                                
                            }
                        });
                    return false;
                });

                $('#edit_id_kavling_mat').change(function(){ 
                    var id=$(this).val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_kavling_id_rab');?>",
                            method : "POST",
                            data : {
                                id:id,
                            },
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                var html = '<option value="">-pilih-</option>';
                                var k;
                                
                                for(k=0; k<data.length; k++){
                                    html += '<option value='+data[k].id_kavling+'>'+data[k].blok+'</option>';
                                }

                                $('#edit_blok_mat').html(html);
                            }
                        });
                    return false;
            });

             //Drop Upah Cluster,Tipe,Kavling
             $('#id_cluster_upah').change(function(){
                    var id=$(this).val();
                    let id_pro = $('.proyek_id_upah').val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_tipe_id_rab');?>",
                            method : "POST",
                            data : {id: id, id_pro:id_pro},
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                
                                var html = '<option value="">-Pilih-</option>';
                                var i;
                                
                                for(i=0; i<data.length; i++){
                                    html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                                }
                                $('#id_kavling_upah').html(html);
                                
                            }
                        });
                    return false;
                });

                $('#id_kavling_upah').change(function(){ 
                    var id=$(this).val();
                    let id_pro= $('.proyek_id_upah').val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_kavling_id_rab');?>",
                            method : "POST",
                            data : {
                                id:id,
                                id_pro: id_pro
                            },
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                var html;
                                var k;
                                
                                for(k=0; k<data.length; k++){
                                    html += '<option value='+data[k].id_kavling+' selected>'+data[k].blok+data[k].no_rumah+'</option>';
                                }

                                $('#blok_upah').html(html);
                            }
                        });
                    return false;
            });

            $('#edit_id_cluster_upah').change(function(){
                    var id=$(this).val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_tipe_id_rab');?>",
                            method : "POST",
                            data : {id: id},
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                
                                var html = '<option value="">-Pilih-</option>';
                                var i;
                                
                                for(i=0; i<data.length; i++){
                                    html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                                }
                                $('#edit_id_kavling_upah').html(html);
                                
                            }
                        });
                    return false;
                });

                $('#edit_id_kavling_upah').change(function(){ 
                    var id=$(this).val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_kavling_id_rab');?>",
                            method : "POST",
                            data : {
                                id:id,
                            },
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                var html ;
                                var k;
                                
                                for(k=0; k<data.length; k++){
                                    html += '<option value='+data[k].id_kavling+' selected>'+data[k].blok+data[k].no_rumah+'</option>';
                                }

                                $('#edit_blok_upah').html(html);
                            }
                        });
                    return false;
            });

            //Drop Upah Cluster,Tipe,Kavling
            $('#id_cluster_lain').change(function(){
                    var id=$(this).val();
                    let id_pro = $('.proyek_id').val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_tipe_id_rab');?>",
                            method : "POST",
                            data : {id: id, id_pro:id_pro},
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                
                                var html = '<option value="">-Pilih-</option>';
                                var i;
                                
                                for(i=0; i<data.length; i++){
                                    html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                                }
                                $('#id_kavling_lain').html(html);
                                
                            }
                        });
                    return false;
                });

                $('#id_kavling_lain').change(function(){ 
                    var id=$(this).val();
                    let id_pro = $('.proyek_id_lain').val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_kavling_id_rab');?>",
                            method : "POST",
                            data : {
                                id:id,
                                id_pro:id_pro
                            },
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                var html ;
                                var k;
                                
                                for(k=0; k<data.length; k++){
                                    html += '<option value='+data[k].id_kavling+' selected>'+data[k].blok+data[k].no_rumah+'</option>';
                                }

                                $('#blok_lain').html(html);
                            }
                        });
                    return false;
            });

            $('#edit_id_cluster_lain').change(function(){
                    var id=$(this).val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_tipe_id_rab');?>",
                            method : "POST",
                            data : {id: id},
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                
                                var html = '<option value="">-Pilih-</option>';
                                var i;
                                
                                for(i=0; i<data.length; i++){
                                    html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                                }
                                $('#edit_id_kavling_lainnya').html(html);
                                
                            }
                        });
                    return false;
                });

                $('#edit_id_kavling_lainnya').change(function(){ 
                    var id=$(this).val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_kavling_id_rab');?>",
                            method : "POST",
                            data : {
                                id:id,
                            },
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                var html = '<option value="">-pilih-</option>';
                                var k;
                                
                                for(k=0; k<data.length; k++){
                                    html += '<option value='+data[k].id_kavling+'>'+data[k].blok+'</option>';
                                }

                                $('#edit_blok_lain').html(html);
                            }
                        });
                    return false;
            });

            $(document).on('click', '#add_save', function() {
                var id_tipe     = $('#id_kavling_mat').val()
                var id_kategori     = $('#id_kategori').val()
                var id_material     = $('#id_material').val()
                var id_proyek     = $('#proyek_id').val()
                var add_quantity   = $('#add_quantity').val()
                var add_harga         = $('#add_hargaA').val()
                var add_total        = $('#add_totalA').val();
                var kavling = $('#blok_mat').val();
                

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('proyek/proses/')?>',
                    data: {
                        'add_RABmaterial'  : true,
                        'id_tipe'    : id_tipe, 
                        'id_kategori'   : id_kategori,
                        'id_material'   : id_material, 
                        'id_proyek'     : id_proyek, 
                        'add_quantity'  : add_quantity,
                        'add_harga'     : add_harga,
                        'add_total'     : add_total,
                        'kavling' : kavling
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'RAB Material berhasil dibuat...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    location.reload();
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tipe tidak boleh kosong...',
                                })
                            }if(result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jenis Material tidak boleh kosong...',
                                })
                            }if(result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Quantity tidak boleh kosong...',
                                })
                            }if(result.status == 4) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Harga tidak boleh kosong...',
                                })
                            }if(result.status == 6) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kavling tidak boleh kosong...',
                                })
                            }else{
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

            $(document).on('click', '#set_edit', function() {
                var id = $(this).data('id');
                let id_pro = $('.proyek_id_mat_e').val();
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('Proyek/get_rab_material/')?>',
                    data    : {
                        'get_RabMaterial'      : true, 
                        'id'                   : id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        console.log(data);
                     
                        $('#edit_id_cluster').val(data.id_cluster);
                        $('#edit_id').val(data.proyek_material_id);
                        $('#edit_id_kavling_mat').val(data.id_tipe);
                        $('#edit_blok_mat').val(data.id_kavling);

                        $('#edit_id_proyek').val(data.proyek_id);

                        $('#id_material_e').val(data.material_id);
                        $('#id_kategori_e').val(data.kategori_id);
                        $('#sat_material_e').val(data.nama_satuan);

                        $('#edit_add_quantity').val(data.quantity);
                        $('#edit_add_harga').val(data.harga);
                        $('#edit_add_total').val(data.total);

                        $('#edit_add_hargaA').val(data.harga);
                        $('#edit_add_totalA').val(data.total);

                        var kategori_id = data.kategori_id;
                        var material_id = data.material_id;
                        var id = data.id_cluster;
                        var id_kavling = data.id_kavling;
                        var id_tipe = data.id_tipe;

                            $.ajax({
                                url: '<?= site_url('proyek/get_tipe_id_rab'); ?>',
                                dataType: 'JSON',
                                data: {id:id},
                                type: 'POST',
                                success: function(d){
                                        var html = '<option value="">-pilih-</option>';
                                        var i;
                                        for(i=0; i<d.length; i++){
                                        if(d[i].id_tipe == id_tipe){
                                                html += '<option value='+d[i].id_tipe+' selected>'+d[i].tipe+'</option>';
                                            } else {
                                                html += '<option value='+d[i].id_tipe+'>'+d[i].tipe+'</option>';   
                                            }
                                        }
                                        $('#edit_id_kavling_mat').html(html); 
                                }
                            });

                            $.ajax({
                                url: '<?= site_url('proyek/get_kavling_id_rab'); ?>',
                                dataType: 'JSON',
                                data: {id:id_tipe, id_pro:id_pro},
                                type: 'POST',
                                success: function(d){
                                        var html ;
                                        var i;
                                        for(i=0; i<d.length; i++){
                                            html += '<option value='+d[i].id_kavling+' selected>'+d[i].blok+d[i].no_rumah+'</option>';
                                        // if(d[i].id_kavling == id_kavling){
                                        //         html += '<option value='+d[i].id_kavling+' selected>'+d[i].blok+'</option>';
                                        //     } else {
                                        //         html += '<option value='+d[i].id_kavling+'>'+d[i].blok+'</option>';   
                                        //     }
                                        }
                                        $('#edit_blok_mat').html(html); 
                                }
                            });


                            $.ajax({
                                url: '<?= site_url('master/get_mat'); ?>',
                                dataType: 'JSON',
                                data: {kategori_id:kategori_id},
                                type: 'POST',
                                success: function(d){
                                        var html = '<option value="">-pilih-</option>';
                                        var i;
                                        for(i=0; i<d.length; i++){
                                        if(d[i].id == material_id){
                                                html += '<option value='+d[i].id+' selected>'+d[i].nama_material+'</option>';
                                            } else {
                                                html += '<option value='+d[i].id+'>'+d[i].nama_material+'</option>';   
                                            }
                                        }
                                        $('#id_material_e').html(html); 
                                }
                            });

                            var id = $('#id_material_e').val();
                            if(id == ""){
                                $('#sat_material_e').val();
                            }else{
                                $.ajax({
                                    url: '<?= site_url('master/get_sat'); ?>',
                                    dataType: 'JSON',
                                    data: {id:id},
                                    type: 'POST',
                                    success: function(d){
                                        console.log(d);
                                        $('#sat_material_e').val(d.nama_satuan);
                                    }
                                });
                            }
                    }
                })
            });

            $(document).on('click', '#set_edit_upah', function() {
                var id = $(this).data('id');
                let id_pro = $('.proyek_id_up_e').val();
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('Proyek/proses/')?>',
                    data    : {
                        'get_RabUpah'      : true, 
                        'id'                   : id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#edit_id_upah').val(data.id);
                        $('#edit_proyek_id_upah').val(data.proyek_id);
                        $('#edit_id_cluster_upah').val(data.id_cluster);
                        $('#edit_id_kavling_upah').val(data.id_tipe);
                        $('#edit_blok_upah').val(data.kavling_id);
                      
                        $('#edit_harga_kontrak').val(data.harga_kontrak);
                        $('#edit_harga_kontrakA').val(data.harga_kontrak);
                        $('#ket_edit_upah').val(data.ket);

                        var id = data.id_cluster;
                        var id_kavling = data.kavling_id;
                        var id_tipe = data.id_tipe;

                            $.ajax({
                                url: '<?= site_url('proyek/get_tipe_id_rab'); ?>',
                                dataType: 'JSON',
                                data: {id:id},
                                type: 'POST',
                                success: function(d){
                                        var html = '<option value="">-pilih-</option>';
                                        var i;
                                        for(i=0; i<d.length; i++){
                                        if(d[i].id_tipe == id_tipe){
                                                html += '<option value='+d[i].id_tipe+' selected>'+d[i].tipe+'</option>';
                                            } else {
                                                html += '<option value='+d[i].id_tipe+'>'+d[i].tipe+'</option>';   
                                            }
                                        }
                                        $('#edit_id_kavling_upah').html(html); 
                                }
                            });

                            $.ajax({
                                url: '<?= site_url('proyek/get_kavling_id_rab'); ?>',
                                dataType: 'JSON',
                                data: {id:id_tipe, id_pro:id_pro},
                                type: 'POST',
                                success: function(d){
                                        var html ;
                                        var i;
                                        for(i=0; i<d.length; i++){
                                     
                                                html += '<option value='+d[i].id_kavling+' selected>'+d[i].blok+d[i].no_rumah+'</option>';
                                            
                                        }
                                        $('#edit_blok_upah').html(html); 
                                }
                            });
                    }
                })
            });

            $(document).on('click', '#set_edit_lainnya', function() {
                var id = $(this).data('id');
                let id_pro = $('.proyek_id_la_e').val();
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('Proyek/proses/')?>',
                    data    : {
                        'get_RabLainnya'      : true, 
                        'id'                   : id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#edit_id_lainnya').val(data.id);
                        $('#edit_id_cluster_lain').val(data.id_cluster);
                        $('#edit_proyek_id_lainnya').val(data.proyek_id);
                        $('#edit_id_kavling_lainnya').val(data.id_tipe);
                        $('#edit_blok_lainnya').val(data.kavling_id);
                        $('#edit_listrik').val(data.keterangan);
                        $('#edit_lainnya').val(data.harga_lainnya);
                        $('#edit_lainnyaA').val(data.harga_lainnya);

                        var id = data.id_cluster;
                        var id_kavling = data.kavling_id;
                        var id_tipe = data.id_tipe;

                            $.ajax({
                                url: '<?= site_url('proyek/get_tipe_id_rab'); ?>',
                                dataType: 'JSON',
                                data: {id:id},
                                type: 'POST',
                                success: function(d){
                                        var html = '<option value="">-pilih-</option>';
                                        var i;
                                        for(i=0; i<d.length; i++){
                                        if(d[i].id_tipe == id_tipe){
                                                html += '<option value='+d[i].id_tipe+' selected>'+d[i].tipe+'</option>';
                                            } else {
                                                html += '<option value='+d[i].id_tipe+'>'+d[i].tipe+'</option>';   
                                            }
                                        }
                                        $('#edit_id_kavling_lainnya').html(html); 
                                }
                            });

                            $.ajax({
                                url: '<?= site_url('proyek/get_kavling_id_rab'); ?>',
                                dataType: 'JSON',
                                data: {id:id_tipe, id_pro: id_pro},
                                type: 'POST',
                                success: function(d){
                                        var html;
                                        var i;
                                        for(i=0; i<d.length; i++){
                                    
                                                html += '<option value='+d[i].id_kavling+' selected>'+d[i].blok+d[i].no_rumah+'</option>';
                                            
                                        }
                                        $('#edit_blok_lainnya').html(html); 
                                }
                            });

                    }
                })
            });

            $('#edit_save').on('click', function(){
                var id              = $('#edit_id').val();
                var proyek_id       = $('#edit_id_proyek').val();
                var material_id     = $('#id_material_e').val();
                var id_kategori     = $('#id_kategori_e').val();
                var id_tipe         = $('#edit_id_kavling_mat').val();
                var quantity        = $('#edit_add_quantity').val();
                var harga           = $('#edit_add_hargaA').val();
                var total           = $('#edit_add_totalA').val();

                $.ajax({
                    url:'<?= site_url('Proyek/proses/'); ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        'edit_RABmaterial'  : true,
                        'id': id,
                        'proyek_id':  proyek_id,
                        'material_id': material_id,
                        'id_kategori': id_kategori,
                        'id_tipe': id_tipe,
                        'quantity': quantity,
                        'harga': harga,
                        'total': total
                    },
                    success: function(result){
                        console.log(result);
                        if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data berhasil edit...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        location.reload();
                                    }
                                )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kavling tidak boleh kosong...',
                                })
                            }if(result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jenis Material tidak boleh kosong...',
                                })
                            }if(result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Quantity tidak boleh kosong...',
                                })
                            }if(result.status == 4) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Harga tidak boleh kosong...',
                                })
                            }
                            else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Input Gagal diproses',
                                })
                            }
                        }
                    }
                });

            });

            $('#edit_upah_save').on('click', function(){
                var id              = $('#edit_id_upah').val();
                var proyek_id       = $('#edit_proyek_id_upah').val();
                // var kavling_id      = $('#edit_blok_upah').val();
                var tipe = $('#edit_id_kavling_upah').val();
                var harga_kontrak   = $('#edit_harga_kontrakA').val();
                var keterangan   = $('#ket_edit_upah').val();

                $.ajax({
                    url:'<?= site_url('Proyek/proses/'); ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        'edit_RABupah'  : true,
                        'id': id,
                        'proyek_id':  proyek_id,
                        'harga_kontrak': harga_kontrak,
                        'tipe' : tipe,
                        'keterangan' : keterangan
                    },
                    success: function(result){
                        if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data berhasil edit...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        location.reload();
                                    }
                                )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kavling tidak boleh kosong...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Input Gagal diproses',
                                })
                            }
                        }
                    }
                });

            });

            $('#edit_lainnya_save').on('click', function(){
                var id              = $('#edit_id_lainnya').val();
                var proyek_id       = $('#edit_proyek_id_lainnya').val();
                // var kavling_id      = $('#edit_blok_lainnya').val();
                var tipe = $('#edit_id_kavling_lainnya').val();
                var keterangan         = $('#edit_listrik').val();
                var harga_lainnya         = $('#edit_lainnyaA').val();

                $.ajax({
                    url:'<?= site_url('Proyek/proses/'); ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        'edit_RABlainnya'  : true,
                        'id': id,
                        'proyek_id':  proyek_id,
                        'tipe': tipe,
                        'keterangan': keterangan,
                        'harga_lainnya': harga_lainnya,
                    },
                    success: function(result){
                        if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data berhasil edit...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        location.reload();
                                    }
                                )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kavling tidak boleh kosong...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Input Gagal diproses',
                                })
                            }
                        }
                    }
                });

            });

            $('.del-RABMaterial').on('click', function(){
                var id = $(this).data('id');
                
                $.ajax({
                    url: '<?= site_url('proyek/proses'); ?>',
                    data: {
                        'del_RABmaterial'  : true,
                        id:id
                    },
                    method: 'POST',
                    dataType: 'JSON',
                    success: function(result){
                        if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data berhasil hapus...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        location.reload();
                                    }
                                )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal diproses',
                            });
                            
                        }
                    }
                });
            });

            $('.del-RABUpah').on('click', function(){
                var id = $(this).data('id');
                
                $.ajax({
                    url: '<?= site_url('proyek/proses'); ?>',
                    data: {
                        'del_RABupah'  : true,
                        id:id
                    },
                    method: 'POST',
                    dataType: 'JSON',
                    success: function(result){
                        if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data berhasil hapus...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        location.reload();
                                    }
                                )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal diproses',
                            });
                            
                        }
                    }
                });

            });

            $('.del-RABLainnya').on('click', function(){
                var id = $(this).data('id');
                
                $.ajax({
                    url: '<?= site_url('proyek/proses'); ?>',
                    data: {
                        'del_RABlainnya'  : true,
                        id:id
                    },
                    method: 'POST',
                    dataType: 'JSON',
                    success: function(result){
                        if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data berhasil hapus...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        location.reload();
                                    }
                                )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal diproses',
                            });
                            
                        }
                    }
                });

            });

            $(document).on('click', '#add_upah_save', function() {
                var tipe_id     = $('#id_kavling_upah').val()
                var proyek_id      = $('#proyek_id').val()
                var harga_kontrak  = $('#harga_kontrakA').val()
                var keterangan = $('#ket').val();

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('proyek/proses/')?>',
                    data: {
                        'add_upah'  : true,
                        'tipe_id'   : tipe_id, 
                        'proyek_id'     : proyek_id, 
                        'harga_kontrak'     : harga_kontrak,
                        'keterangan' : keterangan
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Upah Kerja berhasil dibuat...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    // location.reload();
                                    $('#add-upah').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Material tidak boleh kosong...',
                                })
                            }if(result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Harga Kontrak tidak boleh kosong...',
                                })
                            }else{
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

            $(document).on('click', '#add_lainnya_save', function() {
                // var id_kavling_lain     = $('#blok_lain').val()
                var tipe = $('#id_kavling_lain').val();
                var proyek_id       = $('#proyek_id').val()
                var keterangan         = $('#listrik').val()
                var harga_lainnya         = $('#lainnyaA').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('proyek/proses/')?>',
                    data: {
                        'add_lainnya'       : true,
                        'tipe': tipe,
                        'proyek_id'         : proyek_id, 
                        'keterangan'           : keterangan,
                        'harga_lainnya'           : harga_lainnya,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Lainnya berhasil dibuat...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    // location.reload();
                                    $('#add-lainnya').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kavling tidak boleh kosong...',
                                })
                            }if(result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Listrik tidak boleh kosong...',
                                })
                            }if(result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Almini tidak boleh kosong...',
                                })
                            }if(result.status == 4) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Lainnya tidak boleh kosong...',
                                })
                            }else{
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

            $(document).on('click', '#detail-material', function() {

                $.ajax({
                    url: '<?= site_url('proyek/material_list'); ?>',
                    method: 'POST',
                    success: function(d){
                        $('#material_list').html(d);
                    }
                });
                
            });

            $(document).on('click', '.del-LisMat', function() {
                var id = $(this).data('id');
                
                $.ajax({
                    url: '<?= site_url('proyek/proses'); ?>',
                    data: {
                        'del_list_material'  : true,
                        id:id
                    },
                    method: 'POST',
                    dataType: 'JSON',
                    success: function(result){
                        if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data berhasil hapus...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        location.reload();
                                    }
                                )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal diproses',
                            });
                            
                        }
                    }
                });

            });
            
        </script>
    <?php
}elseif($url_cek == 'proyek/rab/'){
    ?>
        <script type="text/javascript">

            arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            arrbulan2 = ["01","02","03","04","05","06","07","08","09","10","11","12"];
            date = new Date();
            tanggal = date.getDate();
            bulan = date.getMonth();
            tahun = date.getFullYear();
            var periode_bulan = tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal + ' - ' + tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal;
            var bulan_ini = arrbulan[bulan] +' '+ tahun;
            $('#periode_laporan').text(bulan_ini);

            $(function() {

                $('#hari_ini').daterangepicker({
                    locale: {
                    format: 'YYYY-MM-DD'
                    }
                })

                $('#tgl_pengajuan').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#edit_tgl_pengajuan').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

            });

            var table;
            $(document).ready(function() {
                table = $('#table_list').DataTable({ 
                    "responsive"    : false,
                    "autoWidth"     : false,
                    "lengthChange"  : true,
                    "lengthMenu"    : [10,20,50, 100],

                    "processing"    : true, //Feature control the processing indicator.
                    "serverSide"    : true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url"   : "<?=site_url('proyek/ajax_Rab/')?>",
                        "type"  : "POST",
                        "data"  : function ( data ) {
                            data.periode = $('#hari_ini').val();
                            // data.status_rab = $('#status_rab').val();
                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        { 
                            "targets": [ 1,0,3,4,5], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                    ],

                });

                $('#hari_ini').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                    var periodenya = $('#hari_ini').val();
                    if(periodenya == periode_bulan){
                        $('#periode_laporan').text(bulan_ini);
                    }else{
                        $('#periode_laporan').text(periodenya);
                    }
                });

                // $('#status_rab').change(function(){ //button filter event click
                //     table.ajax.reload(null, false);  //just reload table
                // });


            });

            $(document).on('click', '#set_kav', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '<?= site_url('proyek/view_all_kavling'); ?>',
                    data: {id:id},
                    method: 'POST',
                    success: function(d){
                        $('#detail-kavling').html(d);
                    }
                });
                
            });

            $(document).on('click', '#open_detail', function() {
                var id = $(this).data('id');
                window.location='<?=site_url('proyek/detail_rab/')?>' + id;
            });

            $(document).on('click', '#detail-rab', function() {
                var id = $(this).data('id');

                const html = '<div class="text-center"><div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div></div>';

                $('#detail-rabView').html(html);

                $.ajax({
                    // url: '<?= site_url('proyek/view_all_rab'); ?>',
                    url: '<?= site_url('proyek/ajax_detail_rab') ?>',
                    data: {id:id},
                    method: 'POST',
                    success: function(d){
                        $('#detail-rabView').html(d);
                    }
                });
                
            });

            $(document).on('click', '#approveRab', function() {
                var id = $(this).data('id');
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('proyek/proses/')?>',
                    data    : {
                        'get_approve'   : true, 
                        'id' : id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#id').val(id);
                    }
                })
            });

            $(document).on('click', '#approve_save', function() {
                var id      = $('#id').val();
                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('proyek/proses/')?>',
                    data: {
                        'approve_rab'   : true, 
                        'id'                  : id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil di Approve...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#approve-item').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
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

            $(document).on('click', '#tolak_save', function() {
                var id      = $('#id').val();
                // var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('proyek/proses/')?>',
                    data: {
                        'tolak_rab'   : true, 
                        'id'                  : id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil di Tolak...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#tolak-item').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
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

            // cetak_rab
            $(document).on('click', '#cetak_rab', function() {
                var id = $(this).data('id');
                window.open('<?=site_url('cetak/rab/')?>' + id + '?pdf=0', '_blank', 'width=900,height=800');
            })
        </script>
    <?php
}elseif($url_cek == 'proyek/pengajuan_material/'){
    ?>
        <script type="text/javascript">
            $('#tablePengajuan').dataTable();
            $('#id_supplier').on('change', function(){
                var id = $('#id_supplier').val();
                if(id == ""){
                    $('#nama').val();
                    $('#alamat').val();
                }else{
                    $.ajax({
                        url: '<?= site_url('proyek/get_supplier'); ?>',
                        dataType: 'JSON',
                        data: {id:id},
                        type: 'POST',
                        success: function(d){
                            console.log(d);
                            $('#nama').val(d.nama);
                            $('#alamat').val(d.alamat);
                        }
                    });
                }
            });

            arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            arrbulan2 = ["01","02","03","04","05","06","07","08","09","10","11","12"];
            date = new Date();
            tanggal = date.getDate();
            bulan = date.getMonth();
            tahun = date.getFullYear();
            var periode_bulan = tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal + ' - ' + tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal;
            var bulan_ini = arrbulan[bulan] +' '+ tahun;
            $('#periode_laporan').text(bulan_ini);

            $(function() {

                $('#hari_ini').daterangepicker({
                    locale: {
                    format: 'YYYY-MM-DD'
                    }
                })

                $('#tgl_pengajuan').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#tanggal_stok_out').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#edit_tgl_pengajuan').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

            });

        var save_method; 
        var table;

        jQuery(document).ready(function() {

            load_material_all();
            load_cart();

            table = $('#table_list').DataTable({ 
                "responsive"    : false,
                "autoWidth"     : false,
                "lengthChange"  : true,
                "lengthMenu"    : [10,20,50, 100],

                "processing"    : true, //Feature control the processing indicator.
                "serverSide"    : true, //Feature control DataTables' server-side processing mode.
                "order"         : [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url"   : "<?=site_url('proyek/ajax_pengajuan/')?>",
                    "type"  : "POST",
                    "data"  : function ( data ) {
                        data.periode = $('#hari_ini').val();
                        // data.id_lembaga = $('#id_lembaga').val();
                        // data.tipe_stok = $('#tipe_stok').val();
                    }
                },
                "columnDefs": [
                        { 
                            "targets": [ 5 ], //first column / numbering column
                            "className": 'text-right', //set not orderable
                        },
                        { 
                            "targets": [ 1,4,6,7], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                    ],
            });
            

                $('#hari_ini').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                    var periodenya = $('#hari_ini').val();
                    if(periodenya == periode_bulan){
                        $('#periode_laporan').text(bulan_ini);
                    }else{
                        $('#periode_laporan').text(periodenya);
                    }
                });
        });

            $(document).on('click', '#save', function() {
                var id                      = $('#id').val()
                var id_supplier             = $('#id_supplier').val()
                var harga_realA             = $('#harga_realA').val()
              
                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('proyek/proses/')?>',
                    data: {
                        'add_pengajuan_material'         : true, 
                        'id'                    : id,
                        'id_supplier'           : id_supplier,
                        'harga_realA'           : harga_realA,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Suplier berhasil diinput...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    location.reload();
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Supplier wajib diisi...',
                                })
                            }
                            if(result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Harga Real wajib diisi...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '.set_edit', function() {
                var id = $(this).data('id');

                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('Logistik/proses/')?>',
                    data    : {
                        'get_pengajuan'      : true, 
                        'id'        : id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        console.log(data)
                        $('#id').val(data.id);
                    }
                })
            });

            $(document).on('click', '.detail', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '<?= site_url('proyek/detail_pengajuan'); ?>',
                    data: {id:id},
                    method: 'POST',
                    success: function(d){
                        $('#detail-pengajuan').html(d);
                    }
                });
                
            });

            $(document).on('click', '#del-sup', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '<?= site_url('proyek/delete_pengajuan'); ?>',
                    method: 'POST',
                    data: {id:id},
                    dataType: 'JSON',
                    success: function(result){
                        if(result.success == true) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Data Detail Pengajuan berhasil di hapus',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(
                                        function() {
                                            $('#staticBackdrop').modal('hide')
                                            setInterval('location.reload()', 500);
                                        }
                                    )
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                });
                                
                            }
                    }
                });
                
            });

            $('.add-nota').click(function(){
                $('#modalNota').modal('show');

            });


           $(document).on('change','#by_proyek', function(){
            let id_proyek = $(this).val();
            $.ajax({
                    url: '<?= site_url('proyek/load_material_All') ?>',
                    type: 'POST',
                    data: {id_proyek: id_proyek},
                    success: function(d){
                        $('#materialAllLoad').html(d);
                    }
                });
           });

           $(document).on('click','.select-to-nota', function(){
                let id = $(this).data('id');

                $.ajax({
                    url: '<?= site_url('proyek/selectMaterialToNota') ?>',
                    data: {id_logistik: id},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(d){

                        console.log(d);
                        if(d.success == true){
                            load_material_all();
                            load_cart();
                        } else {
                            Swal.fire(d.msg);
                            load_material_all();
                            load_cart();
                        }
                    }
                });
           });

           $(document).on('click','.reject-cart', function(){
            let id = $(this).data('id');

            $.ajax({
                url: '<?= site_url('proyek/remove_cart') ?>',
                type: 'POST',
                data: {id: id},
                dataType: 'JSON',
                success: function(d){
                    if(d.success == true){
                        load_material_all()
                        load_cart();
                    } else {
                        Swal.fire(d.msg);
                    }
                }
            });

           });

            function load_material_all(){
                $.ajax({
                    url: '<?= site_url('proyek/load_material_All') ?>',
                    type: 'POST',
                    success: function(d){
                        $('#materialAllLoad').html(d);
                    }
                });
            }

            function load_cart(){
                $.ajax({
                    url: '<?= site_url('proyek/load_cart_nota') ?>',
                    type: 'POST',
                    success: function(d){
                        $('#loadListMaterialNota').html(d);
                    }
                });
            }

            let success = $('.msg_success').data('msg');
            let error = $('.msg_error').data('msg');

            if(success){
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: success,
                });
            }
            if(error){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error,
                });
            }


            $(document).on('click','.addSupplier', function(){
                $('#addSupplier').modal('show');
                let id = $(this).data('id');
                $.ajax({
                    url: '<?= site_url('proyek/showAjukanSupllier') ?>',
                    data: {id:id},
                    type: 'POST',
                    success: function(d){
                        $('.showSupplier').html(d);
                    }
                });
            });

            $(document).on('click','.addNota', function(){
                let id = $(this).data('id');
                $('#id_pengajuan_nota').val(id);
                $('#addNota').modal('show');
            });

            $(document).on('click','.detail-pengajuan', function(){
                let id = $(this).data('id');
                $('#modalDetail').modal('show');

                $.ajax({
                    url: '<?= site_url('proyek/getDetailsPengajuan'); ?>',
                    data: {id: id},
                    type: 'POST',
                    success: function(d){
                        $('.showDetails').html(d);
                    }
                });

            });

            

        </script>
    <?php
}elseif($url_cek == 'proyek/pekerjaan_insidentil/'){
    ?>
        <script type="text/javascript">

            arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            arrbulan2 = ["01","02","03","04","05","06","07","08","09","10","11","12"];
            date = new Date();
            tanggal = date.getDate();
            bulan = date.getMonth();
            tahun = date.getFullYear();
            var periode_bulan = tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal + ' - ' + tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal;
            var bulan_ini = arrbulan[bulan] +' '+ tahun;
            $('#periode_laporan').text(bulan_ini);

            $(function() {

                $('#hari_ini').daterangepicker({
                    locale: {
                    format: 'YYYY-MM-DD'
                    }
                })

                $('#tgl_pengajuan').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#tanggal_stok_out').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#edit_tgl_pengajuan').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

            });

        var save_method; 
        var table;

        jQuery(document).ready(function() {

            table = $('#table_list').DataTable({ 
                "responsive"    : false,
                    "autoWidth"     : false,
                    "lengthChange"  : true,
                    "lengthMenu"    : [10,20,50, 100],

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        { 
                            "targets": [ 0,1,3,5 ], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                    ],
            });
            

                $('#hari_ini').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                    var periodenya = $('#hari_ini').val();
                    if(periodenya == periode_bulan){
                        $('#periode_laporan').text(bulan_ini);
                    }else{
                        $('#periode_laporan').text(periodenya);
                    }
                });
        });

            $(document).on('click', '#save', function() {
                var id_proyek               = $('#id_proyek').val()
                var tanggal_insidentil      = $('#tanggal_insidentil').val()
                var keterangan              = $('#keterangan').val()
                var nilaiA                  = $('#nilaiA').val()
              
                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('proyek/proses/')?>',
                    data: {
                        'add_insidentil'                : true, 
                        'id_proyek'                     : id_proyek,
                        'keterangan'                    : keterangan,
                        'tanggal_insidentil'            : tanggal_insidentil,
                        'nilaiA'                        : nilaiA,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Insidentil berhasil diinput...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    location.reload();
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Proyek wajib diisi...',
                                })
                            }
                            if(result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Keterangan wajib diisi...',
                                })
                            }
                            if(result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nilai wajib diisi...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#set_edit', function() {
                var id = $(this).data('id');

                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('proyek/proses/')?>',
                    data    : {
                        'get_insidentil'      : true, 
                        'id'        : id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        console.log(data)
                        $('#id').val(data.id);
                        $('#tanggal_insidentil_e').val(data.tanggal_insidentil);
                        $('#id_proyek_e').val(data.proyek_id);
                        $('#keterangan_e').val(data.keterangan);
                        $('#nilai_e').val(data.nilai);
                        $('#nilaiA_e').val(data.nilai);
                    }
                })
            });

            $(document).on('click', '#edit_save', function() {
                var id_proyek               = $('#id_proyek_e').val()
                var tanggal_insidentil      = $('#tanggal_insidentil_e').val()
                var keterangan              = $('#keterangan_e').val()
                var nilaiA                  = $('#nilaiA_e').val()
                var id                      = $('#id').val();

                $.ajax({
                    url: '<?= site_url('proyek/proses'); ?>',
                    method: 'POST',
                    data: {
                        'edit_insidentil'               : true, 
                        'id_proyek'                     : id_proyek,
                        'keterangan'                    : keterangan,
                        'tanggal_insidentil'            : tanggal_insidentil,
                        'nilaiA'                        : nilaiA,
                        'id'                            : id
                    },
                    dataType: 'JSON',
                    success: function(result){
                        if(result.success == true) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Data Insidentil barhasil di edit',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(
                                        function() {
                                            $('#edit-pengajuan').modal('hide')
                                            setInterval('location.reload()', 500);
                                        }
                                    )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Proyek wajib diisi...',
                                })
                            }
                            if(result.status == 2) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Keterangan wajib diisi...',
                                })
                            }
                            if(result.status == 3) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nilai wajib diisi...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                        }
                    }
                });

            });

            $(document).on('click', '.del', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '<?= site_url('proyek/del_insidentil'); ?>',
                    method: 'POST',
                    data: {id:id},
                    dataType: 'JSON',
                    success: function(result){
                        if(result.success == true) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Data Insidentil berhasil di hapus',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(
                                        function() {
                                            // $('#staticBackdrop').modal('hide')
                                            setInterval('location.reload()', 500);
                                        }
                                    )
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal diproses',
                                });
                                
                            }
                    }
                });
                
            });

            $(document).on('click','.approve', function(){
                let id = $(this).data('id');
                $.ajax({
                    url: '<?= site_url('proyek/setStatusInsidentil') ?>',
                    data: {id: id, status: 'approve'},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(d){
                        if(d.success == true){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: d.msg,
                                });
                                setInterval(() => {
                                    location.reload();
                                }, 1500);
                        } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: d.msg,
                                });
                        }
                    }
                });
            });

            $(document).on('click','.reject', function(){
                let id = $(this).data('id');
                $.ajax({
                    url: '<?= site_url('proyek/setStatusInsidentil') ?>',
                    data: {id: id, status: 'reject'},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(d){
                        if(d.success == true){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: d.msg,
                                });
                                setInterval(() => {
                                    location.reload();
                                }, 1500);
                        } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: d.msg,
                                });
                        }
                    }
                });
            });

            

        </script>
    <?php
}elseif($url_cek == 'logistik/ajukan_material/'){
    ?>
        <script type="text/javascript">

            $(document).ready(function(){

                load_list_item();

                $('#id_proyek').change(function(){ 
                    var id=$(this).val();
                        
                        $.ajax({
                            url : "<?php echo site_url('logistik/get_Tipe_id');?>",
                            method : "POST",
                            data : {id: id},
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                console.log(data)
                                var html = ' <option value="">-pilih-</option>';
                                var i;
                              
                                for(i=0; i<data.length; i++){
                                    html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                                }
                                
                                $('#id_tipe').html(html);
                            }
                        });
                    return false;
                });

                $('#id_tipe').change(function(){ 
                    var id=$(this).val();
                    var id_pro=$('#id_proyek').val();
                   
                        $.ajax({
                                url : "<?php echo site_url('logistik/get_Kavling_id');?>",
                                method : "POST",
                                data : {id: id, id_pro:id_pro},
                                async : true,
                                dataType : 'json',
                                success: function(data){ 
                                    console.log('total',data.length)
                                    var kav = '';
                                    var html = '<option value="">-pilih-</option>';
                                    var total = 0;
                                    var i;
                                    
                                    for(i=0; i<data.length; i++){
                                        kav += '<option value='+data[i].id_kavling+' selected>'+data[i].blok+data[i].no_rumah+'</option>';
                                        html += '<option value='+data[i].id_kavling+'>'+data[i].blok+data[i].no_rumah+'</option>';
                                        id_p = data[i].proyek_id;
                                    }
                                    $('#total').val(data.length);
                                    $('#kavling').html(kav);
                                    $('#id_kavling').html(html);
                                    var id_p = $('#id_proyek_material').val(id_p);
                                }
                        });

                        $.ajax({
                            url: '<?= site_url('logistik/getJenisMaterialTipe'); ?>',
                            dataType: 'JSON',
                            data: {
                                id_tipe: id,
                                id_pro: id_pro
                            },
                            type: 'POST',
                            success: function(d){
                                console.log(d);

                                let html = '<option value="">-pilih-</option>';
                                let i;
                                for(i=0; i<d.length; i++){
                                    html += '<option value='+d[i].id+'>'+d[i].kategori_produk+'</option>';
                                }
                                $('.jenis').html(html);

                            }
                        });
                       

                    return false;
                });

                $('#id_kavling').change(function(){ 
                    var id=$(this).val();
                    var id_pro=$('#id_proyek_material').val();
                 
                    $.ajax({
                        url : "<?php echo site_url('logistik/get_Jenismaterial_id');?>",
                        method : "POST",
                        data : {id: id,id_pro:id_pro},
                        async : true,
                        dataType : 'json',
                        success: function(data){ 
                            console.log(data)
                            var html = ' <option value="">-pilih-</option>';
                            var i;
                            
                            for(i=0; i<data.length; i++){
                                html += '<option value='+data[i].kategori_id+'>'+data[i].kategori_produk+'</option>';
                                
                                id_p = data[i].proyek_id;
                            }
                            
                            var jenis = $('.jenis').html(html);

                            var id_p = $('#id_proyek_material').val(id_p);
                        }
                    });
                    return false;
                });

                $('#kategori_id').change(function(){ 
                    var id=$(this).val();
                    var id_pro=$('#id_proyek_material').val();
                    let id_tipe = $('#id_tipe').val();
                   
                        $.ajax({
                            url : "<?php echo site_url('logistik/get_material_id');?>",
                            method : "POST",
                            data : {
                                id:id,
                                id_pro:id_pro,
                                id_tipe:id_tipe
                            },
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                                var kat = '<option value="">-pilih-</option>';
                                var i;
                                
                                for(i=0; i<data.length; i++){
                                    kat += '<option value='+data[i].id_material+'>'+data[i].nama_material+'</option>';
                                    id_proyek = data[i].id;
                                }
                                
                                $('.material').html(kat);
                                // $('#id').val(id_proyek);
                            }
                        });
                    return false;
                });

                $('#material').change(function(){ 
                    var id=$(this).val();
                    var id_pro=$('#id_proyek_material').val();

                        $.ajax({
                            url : "<?php echo site_url('logistik/get_quantity_id');?>",
                            method : "POST",
                            data : {
                                id:id,
                                id_pro:id_pro
                            },
                            async : true,
                            dataType : 'json',
                            success: function(data){ 
                              
                                $('#id').val(data.id_pro_mat);

                                let qty_rab = data.quantity;
                                let jml_out = data.jml_out;

                                $("#jumlah").attr("max", data.quantity).val();
                                $('#satuan').val(data.nama_satuan);

                                $.ajax({
                                    url: '<?= site_url('logistik/get_total_pengajuan') ?>',
                                    data: {
                                        id_material: id,
                                        id_proyek: data.id_pro_mat
                                    },
                                    method: 'POST',
                                    dataType: 'JSON',
                                    success: function(d){
                                        
                                        let stok_qty = qty_rab - jml_out - d.total_pengajuan;
                                        
                                        $('#jumlah').val(stok_qty);
                                        $('#showMaxPengajuan').html('Max pengajuan : ' + stok_qty);
                                        $('#max_out').val(stok_qty);

                                    }
                                });


                                
                            }
                        });
                    return false;
                });
                
            });

            arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            arrbulan2 = ["01","02","03","04","05","06","07","08","09","10","11","12"];
            date = new Date();
            tanggal = date.getDate();
            bulan = date.getMonth();
            tahun = date.getFullYear();
            var periode_bulan = tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal + ' - ' + tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal;
            var bulan_ini = arrbulan[bulan] +' '+ tahun;
            $('#periode_laporan').text(bulan_ini);

            $(function() {

                $('#hari_ini').daterangepicker({
                    locale: {
                    format: 'YYYY-MM-DD'
                    }
                })

                $('#tgl_pengajuan').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#tanggal_stok_out').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#edit_tgl_pengajuan').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

            });

        var save_method; 
        var table;

        jQuery(document).ready(function() {

            table = $('#table_list').DataTable({ 
                "responsive"    : false,
                "autoWidth"     : false,
                "lengthChange"  : true,
                "lengthMenu"    : [10,20,50, 100],

                "processing"    : true, //Feature control the processing indicator.
                "serverSide"    : true, //Feature control DataTables' server-side processing mode.
                "order"         : [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url"   : "<?=site_url('logistik/ajax_ajukan/')?>",
                    "type"  : "POST",
                    "data"  : function ( data ) {
                        data.periode = $('#hari_ini').val();
                        // data.id_lembaga = $('#id_lembaga').val();
                        // data.tipe_stok = $('#tipe_stok').val();
                    }
                },
                "columnDefs": [
                        { 
                            "targets": [ 5 ], //first column / numbering column
                            "className": 'text-right', //set not orderable
                        },
                        { 
                            "targets": [ 1,4,6,7], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                    ],
            });
            

                $('#hari_ini').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                    var periodenya = $('#hari_ini').val();
                    if(periodenya == periode_bulan){
                        $('#periode_laporan').text(bulan_ini);
                    }else{
                        $('#periode_laporan').text(periodenya);
                    }
                });
        });

            $(document).on('click', '#approve', function() {
                var id = $(this).data('id');
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('logistik/proses/')?>',
                    data    : {
                        'get_approve'   : true, 
                        'id' : id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#id').val(id);
                    }
                })
            });

            $(document).on('click', '#approve_save', function() {
                var id      = $('#id').val();
                // var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('logistik/proses/')?>',
                    data: {
                        'approve_pengajuan'   : true, 
                        'id'                  : id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil di Approve...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#approve-item').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else if(result.err == true){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Jumlah melebihi sisa stok',
                            })
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

            $(document).on('click', '#tolak_save', function() {
                var id      = $('#id').val();
                // var id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('logistik/proses/')?>',
                    data: {
                        'tolak_pengajuan'   : true, 
                        'id'                  : id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil di Tolak...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#tolak-item').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
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

            $(document).on('click', '#save', function() {
                var proyek_id               = $('#id').val()
                var kategori_id             = $('#kategori_id').val()
                var material_id             = $('#material').val()
                var tgl_pengajuan           = $('#tgl_pengajuan').val()
                var jml_pengajuan           = $('#jumlah').val()
                var max_out                 = $('#max_out').val();
                let proyek = $('#id_proyek').val();
                let tipe = $('#id_tipe').val();

                    $.ajax({
                        type: 'POST',
                        url: '<?=site_url('logistik/proses/')?>',
                        data: {
                            'add_pengajuan'         : true, 
                            'proyek_id'             : proyek_id,
                            'kategori_id'           : kategori_id,
                            'material_id'           : material_id,
                            'tgl_pengajuan'         : tgl_pengajuan,
                            'jml_pengajuan'         : jml_pengajuan,
                            'max_out'               : max_out,
                            'proyek' : proyek,
                            'tipe' : tipe
                        },
                        dataType: 'json',
                        success: function(d) {
                            if(d.success == true){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: d.msg,
                                });
                                setInterval(() => {
                                    location.reload();
                                }, 1500);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: d.msg,
                                });
                            }
                        }
                    });
            })

            $(document).on('click', '#set_edit', function() {
                var id = $(this).data('id');

                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('Logistik/proses/')?>',
                    data    : {
                        'get_pengajuan'      : true, 
                        'id'        : id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        console.log(data)
                        $('#edit_id').val(data.id);
                        $('#edit_tgl_pengajuan').val(data.tgl_pengajuan);
                        $('#edit_id_proyek').val(data.id_proyek);
                       

                        var id= $('#edit_proyek_material_id').val(data.material_id);
                        $.ajax({
                            url : "<?php echo site_url('logistik/get_material_id');?>",
                            method : "POST",
                            data : {id: id},
                            async : true,
                            dataType : 'json',
                            success: function(d){ 

                                var html = '';
                                var i;
                                
                                for(i=0; i<d.length; i++){
                                    html += '<option value='+d[i].id+'>'+d[i].nama_material+'</option>';
                                }

                                $('.edit_proyek').html(html);
                            }
                        });
                    return false;

                    }
                })
            });

            $(document).on('click', '#edit_produk_save', function() {
                var id                          = $('#edit_id').val()
                var tgl_pengajuan               = $('#edit_tgl_pengajuan').val()
                var proyek_material_id          = $('#edit_proyek_material_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('Logistik/proses/')?>',
                    data: {
                        'edit_pengajuan'            : true, 
                        'id'                        : id,
                        'tgl_pengajuan'             : tgl_pengajuan,
                        'proyek_material_id'        : proyek_material_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Pengajuan berhasil diEdit...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    location.reload();  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Material wajib diisi...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#set_delete', function() {
                var id = $(this).data('id')
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('Logistik/proses/')?>',
                    data    : {
                        'get_pengajuan'    : true, 
                        'id'     : id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#delete_id').val(data.id);
                    }
                })
            });

            $(document).on('click', '#del_data', function() {
                var id   = $('#delete_id').val()
                var proyek_material_id   = $('#material_id').val()

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('Logistik/proses/')?>',
                    data: {
                        'del_pengajuan'   : true, 
                        'id'     : id,
                        'proyek_material_id'     : proyek_material_id,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Pengajuan berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#delete-item').modal('hide')
                                    table.ajax.reload(null, false);  //just reload table
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Stok Masih tersedia, data tidak bisa dihapus...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal dihapus',
                                })
                            }
                        }
                    }
                })
            })



            $('#toAddItem').click(function(){
            
                let jenis_material = $('#kategori_id').val();
                let material = $('#material').val();
                let pengajuan = $('#jumlah').val();
                let max_out = $('#max_out').val();
                let satuan = $('#satuan').val();
                let proyek_id = $('#id').val();

                if(jenis_material == ''){
                    Swal.fire('Harap pilih jenis material');
                } else if(material == ''){
                    Swal.fire('Harap pilih material');
                } else if(pengajuan == ''){
                    Swal.fire('Jumlah pengajuan harap di isi');
                } else {
                    $.ajax({
                        url: '<?= site_url('logistik/add_list_pengajuan_material') ?>',
                        data: {
                            jenis_material: jenis_material,
                            material: material,
                            pengajuan: pengajuan,
                            satuan: satuan,
                            max_out: max_out,
                            proyek_id: proyek_id
                        },
                        type: 'POST',
                        dataType: 'JSON',
                        success: function(d){
                            load_list_item();
                            if(d.success == true){
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: d.msg,
                                });
                            }
                        }
                    });
                }

            });

            $(document).on('click','.trashItem', function(){
                let id = $(this).data('id');
                $.ajax({
                    url: '<?= site_url('logistik/del_items') ?>',
                    data: {id: id},
                    type: 'POST',
                    success: function(d){
                        load_list_item();
                    }
                });
            });

            function load_list_item(){
                $.ajax({
                    url: '<?= site_url('logistik/load_list_item') ?>',
                    type: 'POST',
                    success: function(d){
                        $('#loadList').html(d);
                    }
                });
            }

            $(document).on('click','.detail', function(){
                $('#detailPengajuan').modal('show');
                let id = $(this).data('id');
                $.ajax({
                    url: '<?= site_url('logistik/detailPengajuanMaterial') ?>',
                    data: {id: id},
                    type: 'POST',
                    success: function(d){
                        $('.loadDetailPengajuan').html(d);
                    }
                });
            });

            $(document).on('click', '.check', function(){
                let id = $(this).data('id');
                let status = 2;
                $.ajax({
                    url: '<?= site_url('logistik/setStatusPengajuan') ?>',
                    data: {id: id, status: status},
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
                            }, 1500);
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

            $(document).on('click','.reject', function(){
                let id = $(this).data('id');
                let status = 0;
                let con = confirm('Apakah anda yakin membatalkan pengajuan ini?');
                if(con){
                    $.ajax({
                        url: '<?= site_url('logistik/setStatusPengajuan') ?>',
                        data: {id: id, status: status},
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
                                }, 1500);
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
            });

            $('#tablePengajuan').dataTable();


            $('#addfrom').click(function(){
                $('#addFromOther').modal('show'); 
            });

            $('#filter').change(function(){
                let perum = $(this).val();
                $.ajax({
                    url: '<?= site_url('logistik/getMaterialGudangbyFilter'); ?>',
                    data: {perum: perum},
                    type: 'POST',
                    success: function(d){
                        $('#bodyAddFrom').html(d);
                    }
                });
            });

            $(document).on('click','.addFromGudang', function(){
                let id_stok = $(this).data('id');
                let material = $(this).data('material');
                let kategori = $(this).data('kategori');
                let qty = $(this).data('qty');
                let proyek = $(this).data('proyek');
                let satuan = $(this).data('satuan');

                $('#basic-addon2').html(satuan);
                $('#qty').val(qty);
                $('#stok_id').val(id_stok);
                $('#proyek_id').val(proyek);
                $('#kategori_show').val(kategori);
                $('#satuan_show').val(satuan);
                $('#material_show').val(material);
                $('#max_material').val(qty);

                $('#jmlFromGudang').modal('show');
            });


            $('#formFromGudang').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(d){
                        if(d.success == true){
                            $('#addFromOther').modal('hide');
                            $('#jmlFromGudang').modal('hide');
                            load_list_item(); 
                        } else {
                            Swal.fire(d.msg);
                        }
                    }
                });
            });
        </script>
    <?php
}elseif($url_cek == 'logistik/kategori_material/'){
    ?>
        <script>
            $(function() {
                $("#list_material").DataTable({
                    "responsive": false,
                    "autoWidth": false,
                    "lengthChange": true,
                    "lengthMenu": [50, 100],
                    "order": [
                        [0, 'asc']
                    ],
                    "columnDefs": [{
                        "targets": -1,
                        "orderable": false,
                    }],
                });

            });

            $(document).on('click', '#edit_kategori', function() {
                $('#id_kategori_material').val($(this).data('id_kategori_material'));
                $('#nama_material').val($(this).data('nama_material'));
            })

            $(document).on('click', '#kategori_save', function() {
                var nama_material   = $('#nama_material').val();
                var id_kategori_material     = $('#id_kategori_material').val();

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('Logistik/proses/')?>',
                    data: {
                        'edit_kategori'  : true, 
                        'nama_material' : nama_material,
                        'id_kategori_material' : id_kategori_material,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Kategori Material berhasil diupdate...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location='<?=site_url('logistik/kategori_material/')?>';
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Form Nama Kategori tidak boleh kosong...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nama Kategori belum diubah',
                                })
                            }
                        }
                    }
                })
            })

            $(document).on('click', '#delete_kategori', function() {
                var id_kategori_material     = $(this).data('id_kategori_material')

                $.ajax({
                    type: 'POST',
                    url: '<?=site_url('Logistik/proses/')?>',
                    data: {
                        'delete_kategori'  : true, 
                        'id_kategori_material' : id_kategori_material,
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Kategori Material berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location='<?=site_url('logistik/kategori_material/')?>';
                                }
                            )
                        } else {
                            if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Kategori tidak bisa dihapus!!!',
                                    text: 'Kategori sudah terpakai...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal Hapus',
                                })
                            }
                        }
                    }
                })
            })

            function delete_kategori(id_kategori_material)
            {
                if(confirm('Are you sure delete this data?'))
                {
                    // ajax delete data to database
                    $.ajax({
                        url : "<?php echo site_url('logistik/delete_kategori')?>/"+id_kategori_material,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data)
                        {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Kategori Material berhasil dihapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    window.location='<?=site_url('logistik/kategori_material/')?>';
                                }
                            )
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error deleting data');
                        }
                    });
            
                }
            }

        </script>
    <?php
}elseif($url_cek == 'logistik/material_masuk/'){
    ?>
        <script type="text/javascript">

            $('#tableMasuk').dataTable();


            arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            arrbulan2 = ["01","02","03","04","05","06","07","08","09","10","11","12"];
            date = new Date();
            tanggal = date.getDate();
            bulan = date.getMonth();
            tahun = date.getFullYear();
            var periode_bulan = tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal + ' - ' + tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal;
            var bulan_ini = arrbulan[bulan] +' '+ tahun;
            $('#periode_laporan').text(bulan_ini);

            $(function() {

                $('#hari_ini').daterangepicker({
                    locale: {
                    format: 'YYYY-MM-DD'
                    }
                })

                $('#tgl_masuk').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#tanggal_stok_out').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#tanggal_edit').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoclose: true,
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

            });

            $(document).on('click', '#material_masuk', function() {
                var id = $(this).data('id');
                var proyek_id = $('#proyek_material_id').val();
                var quantity = $('#quantity').val();

                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('logistik/proses/')?>',
                    data    : {
                        'get_id_logistik'      : true, 
                        'id'        : id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#id').val(data.id);
                        $('#proyek_material_id').val(data.proyek_material_id);
                        $('#quantity').val(data.quantity);
                    }
                })
            });

            $(document).on('click','.add-image', function(){
                let id = $(this).data('id');
                let proyek = $(this).data('proyek');
                let qty = $(this).data('qty');

                $('#proyek_material_id').val(proyek);
                $('#id').val(id);
                $('#quantity').val(qty);

                $('#approve-item').modal('show');
            });

            $(document).on('click', '.details', function() {
                $('#detail_material').modal('show');
                var id = $(this).data('id');
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('logistik/get_detail_masuk/')?>',
                    data    : {id:id},
                    success: function(data) {
                        $('#detail_tabel').html(data);
                    }
                })
            });

        jQuery(document).ready(function() {
            //datatables
            table = $('#table_list').DataTable({ 
                "responsive"    : false,
                // "searching": false,
                "autoWidth"     : false,
                "lengthChange"  : true,
                "lengthMenu"    : [10,20,50, 100],

                "processing"    : true, //Feature control the processing indicator.
                "serverSide"    : true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url"   : "<?=site_url('logistik/ajax_masuk/')?>",
                    "type"  : "POST",
                    "data"  : function ( data ) {
                        data.periode = $('#hari_ini').val();
                        data.id_lembaga = $('#id_lembaga').val();
                        // data.tipe_stok = $('#tipe_stok').val();
                    }
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                    { 
                        "targets": [ 5 ], //first column / numbering column
                        "className": 'text-right', //set not orderable
                    },
                    { 
                        "targets": [ 1,4,6,7], //first column / numbering column
                        "className": 'text-center', //set not orderable
                    },

                ],
        
            });
            

                $('#hari_ini').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                    var periodenya = $('#hari_ini').val();
                    if(periodenya == periode_bulan){
                        $('#periode_laporan').text(bulan_ini);
                    }else{
                        $('#periode_laporan').text(periodenya);
                    }
                });
        });

        </script>
    <?php
}elseif($url_cek == 'logistik/material_keluar/'){
    ?>
    <script type="text/javascript">

        arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        arrbulan2 = ["01","02","03","04","05","06","07","08","09","10","11","12"];
        date = new Date();
        tanggal = date.getDate();
        bulan = date.getMonth();
        tahun = date.getFullYear();
        var periode_bulan = tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal + ' - ' + tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal;
        var bulan_ini = arrbulan[bulan] +' '+ tahun;
        $('#periode_laporan').text(bulan_ini);

        $(function() {

            $('#hari_ini').daterangepicker({
                locale: {
                format: 'YYYY-MM-DD'
                }
            })

            $('#tgl_masuk').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#tanggal_stok_out').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#tanggal_edit').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

        });

        $(document).on('click', '#set', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '<?= site_url('proyek/view_all_kavling'); ?>',
                    data: {id:id},
                    method: 'POST',
                    success: function(d){
                        $('#detail-kav').html(d);
                    }
                });
                
            });

        var table;
            $(document).ready(function() {
                table = $('#table_list').DataTable({ 
                    "responsive"    : false,
                    "autoWidth"     : false,
                    "lengthChange"  : true,
                    "lengthMenu"    : [10,20,50, 100],

                    "processing"    : true, //Feature control the processing indicator.
                    "serverSide"    : true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url"   : "<?=site_url('proyek/ajax_keluar/')?>",
                        "type"  : "POST",
                        "data"  : function ( data ) {
                            data.periode = $('#hari_ini').val();
                            // data.status_rab = $('#status_rab').val();
                        }
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        { 
                            "targets": [ 1,0,3,4,5], //first column / numbering column
                            "className": 'text-center', //set not orderable
                        },
                    ],

                });

                $('#hari_ini').change(function(){ //button filter event click
                    table.ajax.reload(null, false);  //just reload table
                    var periodenya = $('#hari_ini').val();
                    if(periodenya == periode_bulan){
                        $('#periode_laporan').text(bulan_ini);
                    }else{
                        $('#periode_laporan').text(periodenya);
                    }
                });

            });

            $('#id_tipe').change(function(){ 
                    var id=$(this).val();
                        $.ajax({
                            url : "<?php echo site_url('proyek/get_tipe');?>",
                            method : "POST",
                            data : {id: id},
                            async : true,
                            dataType : 'json',
                            success: function(data){ 

                                var html = '';
                                var i;
                                
                                for(i=0; i<data.length; i++){
                                    html += '<option value='+data[i].id_kavling+'>'+data[i].blok+'</option>';
                                }

                                $('.kavling').html(html);
                            }
                        });
                    return false;
            });

            $(document).on('click', '#detail_keluar', function() {
                var id = $(this).data('id');
                window.location='<?=site_url('logistik/detail_keluar/')?>' + id;
            });


            $(document).on('click', '#detail-rab', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '<?= site_url('proyek/view_rab_keluar'); ?>',
                    data: {id:id},
                    method: 'POST',
                    success: function(d){
                        $('#detail-rabView').html(d);
                    }
                });
                
            });

            $(document).on('click', '#keluarkan', function() {
                var id = $(this).data('id');
                console.log(id);
                $.ajax({
                    type    : 'POST',
                    url     : '<?=site_url('logistik/proses/')?>',
                    data    : {
                        'get_keluar'   : true, 
                        'id' : id,
                    },
                    dataType    : 'json',
                    success: function(data) {
                        $('#id').val(id);
                    }
                })
            });

            // cetak_laporan
            $(document).on('click', '#cetak_laporan', function() {
                var id = $(this).data('id');
                window.open('<?=site_url('cetak/material_keluar/')?>' + id + '?pdf=0', '_blank', 'width=900,height=800');
            })

    </script>
    <?php
}elseif($url_cek == 'logistik/rekap_stok_material/'){
    ?>
        <script type="text/javascript">
        arrbulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        arrbulan2 = ["01","02","03","04","05","06","07","08","09","10","11","12"];
        date = new Date();
        tanggal = date.getDate();
        bulan = date.getMonth();
        tahun = date.getFullYear();
        var periode_bulan = tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal + ' - ' + tahun +'-'+ arrbulan2[bulan] +'-'+ tanggal;
        var bulan_ini = arrbulan[bulan] +' '+ tahun;
        $('#periode_laporan').text(bulan_ini);

        $(function() {

            $('#hari_ini').daterangepicker({
                locale: {
                format: 'YYYY-MM-DD'
                }
            })

            $('#tgl_pengajuan').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#tanggal_stok_out').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#edit_tgl_pengajuan').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoclose: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

        });

            $('#table_list').DataTable();
            
        $('#id_kategori').change(function(){
            var id = $(this).val();
            // console.log(id);
            if(id == ''){
                window.location.href = '<?= site_url('logistik/rekap_stok_material'); ?>';
            } else {
                window.location.href = '<?= site_url('logistik/rekap_stok_material?jenis='); ?>' + id;
            }
        });


        $('#id_material').change(function(){

            var id = $(this).val();

            if(id == ''){
                window.location.href = '<?= site_url('logistik/rekap_stok_material?material='); ?>';
            } else {
                window.location.href = '<?= site_url('logistik/rekap_stok_material?material='); ?>' + id;
            }

        });

        </script>
    <?php
}elseif($url_cek == 'logistik/detail_keluar/'){
    ?>
    <script type="text/javascript">

$('#tgl_pengajuan').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    autoclose: true,
    locale: {
        format: 'YYYY-MM-DD'
    }
});

var table;
$(document).ready(function() {
    table = $('#tabel_material').DataTable({ 
        "responsive"    : false,
        "autoWidth"     : false,
        "lengthChange"  : true,
        "lengthMenu"    : [10,20,50, 100],

        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [4], //first column / numbering column
                "className": 'text-center', //set not orderable
            },
        ],

    });



});

$(document).on('click', '#add_save', function() {
    var id_proyek       = $('#id_proyek').val()
    var id_keluar       = $('#id_keluar').val()
    var id_logistik     = $('#id_logistik').val()
    var id_stok         = $('#id_stok').val()
    var id_max          = $('#id_max').val()
    var quantity        = $('#add_quantity').val()
    var tgl_pengajuan   = $('#tgl_pengajuan').val()
    let kavling         = $('#kavling').val()
    
    console.log(kavling);

    $.ajax({
        type: 'POST',
        url: '<?=site_url('logistik/proses/')?>',
        data: {
            'add_keluar'  : true,
            'id_proyek': id_proyek,
            'id_keluar': id_keluar,
            'id_logistik': id_logistik,
            'id_stok': id_stok,
            'id_max': id_max,
            'quantity': quantity,
            'tgl_pengajuan': tgl_pengajuan,
            'kavling': kavling
        },
        dataType: 'json',
        success: function(result) {
            if(result.success == true) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Data Material Keluar berhasil diinput...',
                    showConfirmButton: false,
                    timer: 1500
                }).then(
                    function() {
                        location.reload();
                    }
                )
            } else {
                if(result.status == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Inputan Quantity Melebihi Stok/Max Material...',
                    })
                }
                else if(result.status == 2){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Harap pilih kavling',
                    })
                }
                else if(result.status == 3){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Harap isi quantity',
                    })
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Data Gagal diproses',
                    })
                }
            }
        }
    })
})

$(document).on('click', '#set_edit', function() {
    var id = $(this).data('id')
    $.ajax({
        type    : 'POST',
        url     : '<?=site_url('logistik/proses/')?>',
        data    : {
            'get_Mat_keluar'    : true, 
            'id'            : id,
        },
        dataType    : 'json',
        success: function(data) {
            console.log(data)
            $('#id_logistik').val(data.id);
            $('#id_proyek').val(data.id_proyek);
            $('#id_keluar').val(data.id_keluar);
            $('#id_stok').val(data.id_stok);
            $('#id_max').val(data.id_max);
            $('#tipe').val(data.tipe);
            $('#id_tipe').val(data.id_tipe);
            $('#nama_material').val(data.nama_material);
            $('#quantity').val(data.quantity);
            $('#max').val(data.max);

            var id_tipe = data.id_tipe;
            let id_pro = data.id_pro;

                $.ajax({
                    url: '<?= site_url('logistik/get_kavling_id_kel'); ?>',
                    dataType: 'JSON',
                    data: {id:id_tipe, id_pro:id_pro},
                    type: 'POST',
                    success: function(d){
                            var html  = '<option value="">--Pilih--</option>';
                            var i;
                            for(i=0; i<d.length; i++){
                                html += '<option value='+d[i].id_kavling+'>'+d[i].blok+d[i].no_rumah+'</option>';
                            }
                            $('#kavling').html(html); 
                    }
                });

        }
    })
});
</script>
    <?php
}elseif($url_cek == 'database/customerxxxx/'){
    ?>
        <script>
            $(function() {
                $("#users_list").DataTable({
                    "responsive": false,
                    "autoWidth": true,
                    "lengthChange": true,
                    "lengthMenu": [30, 50, 100],
                    "order": [
                        [0, 'desc']
                    ],

                });


                $("#example1").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "lengthMenu": [30, 50, 100],
                    "columnDefs": [{
                        "targets": -1,
                        "orderable": false,
                    }],
                    "order": [
                        [1, 'asc']
                    ]
                });

                $("#history_stok").DataTable({
                    "responsive": false,
                    "autoWidth": false,
                    "lengthMenu": [30, 50, 100],
                    "columnDefs": [{
                        "targets": -1,
                        "orderable": false,
                    }],
                    "order": [
                        [0, 'desc']
                    ]

                });
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": false,
                    "lengthMenu": [100],
                    "order": [
                        [0, 'desc']
                    ],

                });
            });
        </script>

<?php }elseif($url_cek == 'marketing/data_konsumen/'){ ?>


    <script>
        //dataTable
        $('#calon_konsumen').DataTable();

    //Add data
        $(document).on('click', '#add_calon_konsumen', function(){
            var nama = $('#nama').val();
            var no_hp = $('#no_hp').val();
            var pekerjaan = $('#pekerjaan').val();
            var jk = $('#jk').val();
            var info = $('#info').val();
            
            $.ajax({
                url:'<?= site_url('marketing/add_calon_konsumen'); ?>',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'nama':  nama,
                    'no_hp': no_hp,
                    'pekerjaan': pekerjaan,
                    'jk': jk,
                    'info': info
                },
                success: function(result){
                    if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Calon Konsumen berhasil diinput...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            )
                    } else {
                        if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nama wajib diisi...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No Hp wajib diisi',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Pekerjaan wajib di isi',
                                })
                            }else if(result.status == 4){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jenis kelamin belum dipilih',
                                })
                            }else if(result.status == 5){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Info belum dipilih',
                                })
                            }else if(result.status == 6){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No Telpon sudah terdaftar',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                    }
                }
            });

        });

        $('#edit_calon_konsumen').on('click', function(){
            var nama = $('#nama_edit').val();
            var no_hp = $('#no_hp_edit').val();
            var pekerjaan = $('#pekerjaan_edit').val();
            var jk = $('#jk_edit').val();
            var info = $('#info_edit').val();
            var id = $('#id_calon').val();

            $.ajax({
                url:'<?= site_url('marketing/edit_calon_konsumen'); ?>',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'id': id,
                    'nama':  nama,
                    'no_hp': no_hp,
                    'pekerjaan': pekerjaan,
                    'jk': jk,
                    'info': info
                },
                success: function(result){
                    if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Calon Konsumen berhasil edit...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            )
                    } else {
                        if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nama wajib diisi...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No Hp wajib diisi',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Pekerjaan wajib di isi',
                                })
                            }else if(result.status == 4){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jenis kelamin belum dipilih',
                                })
                            }else if(result.status == 5){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Info belum dipilih',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                    }
                }
            });

        });

        // $('.del-calon-konsumen').on('click', function(){
        $(document).on('click', '.del-calon-konsumen', function(){
            var id = $(this).data('id');
            
            $.ajax({
                url: '<?= site_url('marketing/del_calon_konsumen'); ?>',
                data: {id:id},
                method: 'POST',
                dataType: 'JSON',
                success: function(result){
                    if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Calon Konsumen berhasil hapus...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            )
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal diproses',
                        });
                        
                    }
                }
            });

        });

        // $('.edit-calon-konsumen').on('click', function(){
        $(document).on('click', '.edit-calon-konsumen', function(){
            var id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('marketing/get_data_calon_id'); ?>',
                method: 'POST',
                data: {id:id},
                dataType: 'JSON',
                success: function(data){
                    $('#id_calon').val(data.id_marketing);
                    $('#nama_edit').val(data.nama_konsumen);
                    $('#no_hp_edit').val(data.no_hp);
                    $('#pekerjaan_edit').val(data.pekerjaan);
                    $('#jk_edit').val(data.jk);
                    $('#info_edit').val(data.dapat_info);
                    
                }
            });
        });
    </script>


<?php }elseif($url_cek == 'master/kavling/'){ ?>

    <script>

        $('#kavling-table').dataTable();

        $('#lokasi').on('change', function(){
            var lokasi = $(this).val();
            // var status = $(this).data('status');
            // console.log(status);

            if(lokasi == ''){
                $('#cluster').html('<option value="">--Pilih--</option>');
                $('#tipe').html('<option value="">--Pilih--</option>');
            } else {

                $.ajax({
                    url: '<?= site_url('master/get_perum_id_ajax'); ?>',
                    dataType: 'JSON',
                    data: {id:lokasi},
                    type: 'POST',
                    success: function(d){
                        var status = d.cluster;
                        $('#status_cluster').val(status);
                        if(status == 0){
                            $('#cluster').attr('disabled', true);

                            $.ajax({
                                url: '<?= site_url('master/get_tipe_ajax'); ?>',
                                dataType: 'JSON',
                                data: {
                                    id_perum:lokasi,
                                    id_cluster:0
                                },
                                type: 'POST',
                                success: function(data){
                                    
                                    var html = '<option value="">--Pilih--</option>';
                                    var i;
                                    for(i=0; i<data.length; i++){
                                        html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                                    }
                                    $('#tipe').html(html); 
                                }
                            });


                        } else if(status == 1){
                            $('#cluster').removeAttr('disabled');
                        }
                    }
                });
            }

            $.ajax({
                url: '<?= site_url('master/get_cluster_by_perum'); ?>',
                dataType: 'JSON',
                data: {lokasi:lokasi},
                type: 'POST',
                success: function(data){
                    // console.log(d);

                        var html = '<option value="">--Pilih--</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value='+data[i].id_cluster+'>'+data[i].nama_cluster+'</option>';
                        }
                        $('#cluster').html(html); 

                }
            });
        });


        $('#cluster').change(function(){
            var perum = $('#lokasi').val();
            var cluster = $(this).val();
            
                $.ajax({
                    url: '<?= site_url('master/get_tipe_ajax'); ?>',
                    dataType: 'JSON',
                    data: {
                        id_perum:perum,
                        id_cluster:cluster
                    },
                    type: 'POST',
                    success: function(data){
                        
                        var html = '<option value="">--Pilih--</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                        }
                        $('#tipe').html(html); 
                    }
                });
        });


         $('#lokasi_e').on('change', function(){
            var lokasi = $(this).val();

            if(lokasi == ''){
                $('#cluster_e').html('<option value="">--Pilih--</option>');
                $('#tipe_e').html('<option value="">--Pilih--</option>');
            } else {

                $.ajax({
                    url: '<?= site_url('master/get_perum_id_ajax'); ?>',
                    dataType: 'JSON',
                    data: {id:lokasi},
                    type: 'POST',
                    success: function(d){
                        var status = d.cluster;
                        $('#status_cluster_e').val(status);
                        if(status == 0){
                            $('#cluster_e').attr('disabled', true);

                            $.ajax({
                                url: '<?= site_url('master/get_tipe_ajax'); ?>',
                                dataType: 'JSON',
                                data: {
                                    id_perum:lokasi,
                                    id_cluster:0
                                },
                                type: 'POST',
                                success: function(data){
                                    
                                    var html = '<option value="">--Pilih--</option>';
                                    var i;
                                    for(i=0; i<data.length; i++){
                                        html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                                    }
                                    $('#tipe_e').html(html); 
                                }
                            });

                        } else if(status == 1){
                            $('#cluster_e').removeAttr('disabled');
                        }
                    }
                });
            }

            $.ajax({
                url: '<?= site_url('master/get_cluster_by_perum'); ?>',
                dataType: 'JSON',
                data: {lokasi:lokasi},
                type: 'POST',
                success: function(data){
                    // console.log(d);

                        var html = '<option value="">--Pilih--</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value='+data[i].id_cluster+'>'+data[i].nama_cluster+'</option>';
                        }
                        $('#cluster_e').html(html); 

                }
            });
        });


        $('#cluster_e').change(function(){
            var perum = $('#lokasi_e').val();
            var cluster = $(this).val();
            
                $.ajax({
                    url: '<?= site_url('master/get_tipe_ajax'); ?>',
                    dataType: 'JSON',
                    data: {
                        id_perum:perum,
                        id_cluster:cluster
                    },
                    type: 'POST',
                    success: function(data){
                        
                        var html = '<option value="">--Pilih--</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';
                        }
                        $('#tipe_e').html(html); 
                    }
                });
        });

        $('#add-kavling').on('click', function(){
            var lokasi = $('#lokasi').val();
            var tipe = $('#tipe').val();
            var blok = $('#blok').val();
            var lt = $('#lt').val();
            var lb = $('#lb').val();
            var harga = $('#harga').val();
            var cluster = $('#cluster').val();
            var status_perum = $('#status_cluster').val();
            var no_rumah = $('#no_rumah').val();
            var sitemap_id = $('#sitemap-id').val();
            console.log(sitemap_id);
            
            $.ajax({
                url: '<?= site_url('master/add_kavling'); ?>',
                method: 'POST',
                data: {
                    'lokasi' : lokasi,
                    'tipe' : tipe,
                    'blok' : blok,
                    'harga' : harga,
                    'cluster' : cluster,
                    'lt' : lt,
                    'lb' : lb,
                    'status_perum' : status_perum,
                    'no_rumah' : no_rumah,
                    'sitemap_id' : sitemap_id
                },
                dataType: 'JSON',
                success: function(result){
                    if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data kavling baru barhasil di tambahkan',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        $('#staticBackdrop').modal('hide')
                                        setInterval('location.reload()', 500);
                                    }
                                )
                    } else {
                        if(result.status == 1) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Harap pilih lokasi...',
                                    })
                                }else if(result.status == 2){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Tipe wajib diisi',
                                    })
                                }else if(result.status == 3){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Blok wajib di isi',
                                    })
                                }else if(result.status == 4){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Cluster harap di isi',
                                    })
                                }else if(result.status == 6){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Harga wajib di isi',
                                    })
                                }

                                else if(result.status == 5){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Luas tanah wajib diisi',
                                    })
                                }

                                else if(result.status == 7){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Luas Bangunan wajib di isi',
                                    })
                                }

                                else if(result.status == 8){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'No Rumah wajib diisi',
                                    })
                                }

                                else if(result.status == 10){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'No rumah sudah ada',
                                    })
                                }

                                else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Data Gagal diproses',
                                    })
                                }
                    }
                }
            });

        });


        $('#edit-kavling').on('click', function(){
            var lokasi = $('#lokasi_e').val();
            var tipe = $('#tipe_e').val();
            var blok = $('#blok_e').val();
            var lt = $('#lt_e').val();
            var lb = $('#lb_e').val();
            var harga = $('#harga_e').val();
            var id = $('#id_kavling').val();
            var cluster = $('#cluster_e').val();
            var status_perum = $('#status_cluster_e').val();
            var no_rumah = $('#no_rumah_e').val();
            


            $.ajax({
                url: '<?= site_url('master/edit_kavling'); ?>',
                method: 'POST',
                data: {
                    'lokasi' : lokasi,
                    'tipe' : tipe,
                    'blok' : blok,
                    'lt' : lt,
                    'lb' : lb,
                    'harga' : harga,
                    'id' : id,
                    'cluster' : cluster,
                    'status_perum': status_perum,
                    'no_rumah' : no_rumah
                },
                dataType: 'JSON',
                success: function(result){
                    if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data kavling barhasil di edit',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        $('#staticBackdrop').modal('hide')
                                        setInterval('location.reload()', 500);
                                    }
                                )
                    } else {
                        
                        if(result.status == 1) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Harap pilih lokasi...',
                                    })
                                }else if(result.status == 2){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Tipe wajib diisi',
                                    })
                                }else if(result.status == 3){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Blok wajib di isi',
                                    })
                                }else if(result.status == 4){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Cluster harap di isi',
                                    })
                                }else if(result.status == 6){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Harga wajib di isi',
                                    })
                                }

                                else if(result.status == 5){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Luas tanah wajib diisi',
                                    })
                                }

                                else if(result.status == 7){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Luas Bangunan wajib di isi',
                                    })
                                }

                                else if(result.status == 8){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'No rumah wajib diisi',
                                    })
                                }

                                else if(result.status == 10){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'No rumah sudah ada',
                                    })
                                }

                                else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Data Gagal diproses',
                                    })
                                }
                    }
                }
            });

        });


        // $('.del-kavling').on('click', function(){
            $(document).on('click','.del-kavling', function(){
            var id = $(this).data('id');

            $.ajax({
                url: '<?= site_url('master/delete_kavling'); ?>',
                method: 'POST',
                data: {id:id},
                dataType: 'JSON',
                success: function(result){
                    if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data kavling berhasil di hapus',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        $('#staticBackdrop').modal('hide')
                                        setInterval('location.reload()', 500);
                                    }
                                )
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal diproses',
                            });
                            
                        }
                }
            });
            
        });

        // $('.edit-kavling-act').on('click', function(){
            $(document).on('click','.edit-kavling-act', function(){
            var id = $(this).data('id');
            var status = $(this).data('status');

         
                $.ajax({
                    url: '<?= site_url('master/get_kavling_id'); ?>',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {id:id},
                    success: function(data){
                        $('#lokasi_e').val(data.id_perum);
                        $('#id_tipe').val(data.id_tipe);
                        $('#blok_e').val(data.blok);
                        $('#lt_e').val(data.lt);
                        $('#lb_e').val(data.lb);
                        $('#harga_e').val(data.harga);
                        $('#v_harga_e').val(data.harga);
                        $('#id_kavling').val(data.id_kavling);
                        $('#status_cluster_e').val(data.cluster);
                        $('#no_rumah_e').val(data.no_rumah);

                        if(status == 0){

                            $('#cluster_e').html('<option value="">--Pilih--</option>');
                            $('#cluster_e').attr('disabled', true);
                            var lokasi = data.id_perum;
                            var tipe = $('#id_tipe').val();

                            $.ajax({
                                url: '<?= site_url('master/get_tipe_ajax'); ?>',
                                dataType: 'JSON',
                                data: {
                                    id_perum:lokasi,
                                    id_cluster:0
                                },
                                type: 'POST',
                                success: function(data){
                                    // console.log(d);

                                        var html = '<option value="">--Pilih--</option>';
                                        var i;
                                        for(i=0; i<data.length; i++){
                                            if(data[i].id_tipe == tipe){
                                                html += '<option value='+data[i].id_tipe+' selected>'+data[i].tipe+'</option>';
                                            } else {
                                                html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';   
                                            }
                                            
                                        }
                                        $('#tipe_e').html(html); 
                                }
                            });
                            

                        } else if(status == 1){

                            var lokasi = data.id_perum;
                            var cluster = data.id_cluster;
                            var tipe = $('#id_tipe').val();

                            $('#cluster_e').removeAttr('disabled');

                            $.ajax({
                                url: '<?= site_url('master/get_cluster_by_perum'); ?>',
                                dataType: 'JSON',
                                data: {lokasi:lokasi},
                                type: 'POST',
                                success: function(data){
                                    // console.log(d);

                                        var html = '<option value="">--Pilih--</option>';
                                        var i;
                                        for(i=0; i<data.length; i++){
                                            if(data[i].id_cluster == cluster){
                                                html += '<option value='+data[i].id_cluster+' selected>'+data[i].nama_cluster+'</option>';
                                            } else {
                                                html += '<option value='+data[i].id_cluster+'>'+data[i].nama_cluster+'</option>';   
                                            }
                                            
                                        }
                                        $('#cluster_e').html(html); 
                                }
                            });

                            $.ajax({
                                url: '<?= site_url('master/get_tipe_ajax'); ?>',
                                dataType: 'JSON',
                                data: {
                                    id_perum:lokasi,
                                    id_cluster:cluster
                                },
                                type: 'POST',
                                success: function(data){
                                    // console.log(d);

                                        var html = '<option value="">--Pilih--</option>';
                                        var i;
                                        for(i=0; i<data.length; i++){
                                            if(data[i].id_tipe == tipe){
                                                html += '<option value='+data[i].id_tipe+' selected>'+data[i].tipe+'</option>';
                                            } else {
                                                html += '<option value='+data[i].id_tipe+'>'+data[i].tipe+'</option>';   
                                            }
                                            
                                        }
                                        $('#tipe_e').html(html); 
                                }
                            });

                        }


                    }
                });
        });



        $('#filter_perum').change(function(){
            var id_perum = $(this).val();
            // console.log(id_perum);
            if(id_perum == ''){
                window.location.href = '<?= site_url('master/kavling'); ?>';
            } else {
                window.location.href = '<?= site_url('master/kavling?perum='); ?>' + id_perum;
            }
        });


        $('#filter_cluster').change(function(){
            console.log('ok');
            var id_cluster = $(this).val();
            var id_perum = $('#filter_perum').val();

            if(id_cluster == ''){
                window.location.href = '<?= site_url('master/kavling?perum='); ?>' + id_perum;
            } else {
                window.location.href = '<?= site_url('master/kavling?perum='); ?>' + id_perum + '&cluster=' + id_cluster;
            }

        });

    </script>

<?php }elseif($url_cek == 'master/material/'){ ?>
    <script>

        var table;
        jQuery(document).ready(function() {
            table = $('#material-table').DataTable({ 
                "responsive"    : false,
                "autoWidth"     : false,
                "lengthChange"  : true,
                "lengthMenu"    : [10,20,50,100],

                "processing"    : true, //Feature control the processing indicator.

            });
        });

    $('#add-material').on('click', function(){
        var kategori_id = $('#kategori_id').val();
        var unit_id = $('#unit_id').val();
        var nama_material = $('#nama_material').val();
        
        $.ajax({
            url: '<?= site_url('master/add_material'); ?>',
            method: 'POST',
            data: {
                'kategori_id' : kategori_id,
                'unit_id' : unit_id,
                'nama_material' : nama_material
            },
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data material baru barhasil di tambahkan',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                } else {
                    if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jenis Material Wajib dipilih...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nama Material wajib diisi',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Satuan Unit wajib di isi',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                }
            }
        });

    });


    $('#edit-material').on('click', function(){
        var kategori_id = $('#kategori_id_edit').val();
        var unit_id = $('#unit_id_edit').val();
        var nama_material = $('#nama_material_edit').val();
        var id = $('#id').val();


        $.ajax({
            url: '<?= site_url('master/edit_material'); ?>',
            method: 'POST',
            data: {
                'kategori_id' : kategori_id,
                'unit_id' : unit_id,
                'nama_material' : nama_material,
                'id' : id
            },
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data material barhasil di edit',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                } else {
                    if(result.status == 1) {
                    Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Jenis Material Wajib dipilih...',
                        })
                    }else if(result.status == 2){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Nama Material wajib diisi',
                        })
                    }else if(result.status == 3){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Satuan Unit wajib di isi',
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Data Gagal diproses',
                        })
                    }
                }
            }
        });

    });


    $('.del-material').on('click', function(){
        var id = $(this).data('id');

        $.ajax({
            url: '<?= site_url('master/delete_material'); ?>',
            method: 'POST',
            data: {id:id},
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data material berhasil di hapus',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal diproses',
                        });
                        
                    }
            }
        });
        
    });

    $('.edit-material-act').on('click', function(){
        var id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('master/get_material_id'); ?>',
            method: 'POST',
            dataType: 'JSON',
            data: {id:id},
            success: function(data){
                $('#kategori_id_edit').val(data.kategori_id);
                $('#unit_id_edit').val(data.unit_id);
                $('#nama_material_edit').val(data.nama_material);
                $('#id').val(data.id);
            }
        });
    });

    </script>
<?php }elseif($url_cek == 'master/jenis_material/'){ ?>
    <script>

        var table;
        jQuery(document).ready(function() {
            table = $('#material-table').DataTable({ 
                "responsive"    : false,
                "autoWidth"     : false,
                "lengthChange"  : true,
                "lengthMenu"    : [10,20,50,100],

                "processing"    : true, //Feature control the processing indicator.

            });
        });

    $('#add-material').on('click', function(){
        var kategori_produk = $('#kategori_produk').val();
        
        $.ajax({
            url: '<?= site_url('master/add_jenis_material'); ?>',
            method: 'POST',
            data: {
                'kategori_produk' : kategori_produk,
            },
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Jenis Material baru barhasil di tambahkan',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                } else {
                    if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jenis Material Wajib dipilih...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                }
            }
        });

    });


    $('#edit-material').on('click', function(){
        var kategori_produk = $('#kategori_produk_edit').val();
        var id = $('#id').val();


        $.ajax({
            url: '<?= site_url('master/edit_jenis_material'); ?>',
            method: 'POST',
            data: {
                'kategori_produk' : kategori_produk,
                'id' : id
            },
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data material barhasil di edit',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                } else {
                    if(result.status == 1) {
                    Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Jenis Material Wajib dipilih...',
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Data Gagal diproses',
                        })
                    }
                }
            }
        });

    });


    $('.del-material').on('click', function(){
        var id = $(this).data('id');

        $.ajax({
            url: '<?= site_url('master/delete_jenis_material'); ?>',
            method: 'POST',
            data: {id:id},
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Jenis material berhasil di hapus',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal diproses',
                        });
                        
                    }
            }
        });
        
    });

    $('.edit-material-act').on('click', function(){
        var id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('master/get_jenis_material_id'); ?>',
            method: 'POST',
            dataType: 'JSON',
            data: {id:id},
            success: function(data){
                $('#kategori_produk_edit').val(data.kategori_produk);
                $('#id').val(data.id);
            }
        });
    });

    </script>

<?php }elseif($url_cek == 'master/supplier/'){ ?>
    <script>
        var table;
        jQuery(document).ready(function() {
            table = $('#sup-table').DataTable({ 
                "responsive"    : false,
                "autoWidth"     : false,
                "lengthChange"  : true,
                "lengthMenu"    : [10,20,50,100],

                "processing"    : true, //Feature control the processing indicator.

            });
        });
    

    $('#add-sup').on('click', function(){
        var nama                    = $('#nama').val()
        var alamat                  = $('#alamat').val()
        var nama_toko               = $('#nama_toko').val()
        var no_tlp                  = $('#no_tlp').val()
        let no_rek = $('#no_rek').val();
        let atas_nama = $('#atas_nama').val();
        let nama_bank = $('#nama_bank').val();
        
        $.ajax({
            url: '<?= site_url('master/add_supplier'); ?>',
            method: 'POST',
            data: {
                'nama'                  : nama,
                'alamat'                : alamat,
                'nama_toko'             : nama_toko,
                'no_tlp'                : no_tlp,
                'no_rek' : no_rek,
                'atas_nama' : atas_nama,
                'nama_bank' : nama_bank
            },
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Suplier barhasil di tambahkan',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                } else {
                    if(result.status == 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Nama wajib diisi...',
                        })
                    }
                    if(result.status == 2) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Alamat wajib diisi...',
                        })
                    }if(result.status == 3) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Nama Toko wajib diisi...',
                        })
                    }if(result.status == 4) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'No Telpon wajib diisi...',
                        })
                    }if(result.status == 5) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'No Rekening wajib diisi...',
                        })
                    }if(result.status == 6) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Atas Nama wajib diisi...',
                        })
                    }if(result.status == 7) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Nama Bank wajib diisi...',
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Data Gagal diproses',
                        })
                    }
                }
            }
        });

    });


    $('#edit-sup').on('click', function(){
        var nama                    = $('#nama_e').val()
        var alamat                  = $('#alamat_e').val()
        var nama_toko               = $('#nama_toko_e').val()
        var no_tlp                  = $('#no_tlp_e').val()
        var id                      = $('#id_e').val();
        let no_rek = $('#no_rek_e').val();
        let atas_nama = $('#atas_nama_e').val();
        let nama_bank = $('#nama_bank_e').val();

        $.ajax({
            url: '<?= site_url('master/edit_supplier'); ?>',
            method: 'POST',
            data: {
                'nama'                  : nama,
                'alamat'                : alamat,
                'nama_toko'             : nama_toko,
                'no_tlp'                : no_tlp,
                'id'                    : id,
                'no_rek' : no_rek,
                'nama_bank' : nama_bank,
                'atas_nama' : atas_nama
            },
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Supplier barhasil di edit',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                } else {
                    if(result.status == 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Nama wajib diisi...',
                        })
                    }
                    if(result.status == 2) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Alamat wajib diisi...',
                        })
                    }if(result.status == 3) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Nama Toko wajib diisi...',
                        })
                    }if(result.status == 4) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'No Telpon wajib diisi...',
                        })
                    }if(result.status == 5) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'No Rekening wajib diisi...',
                        })
                    }if(result.status == 6) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Atas Nama wajib diisi...',
                        })
                    }if(result.status == 7) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Nama Bank wajib diisi...',
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Data Gagal diproses',
                        })
                    }
                }
            }
        });

    });


    $('.del-sup').on('click', function(){
        var id = $(this).data('id');

        $.ajax({
            url: '<?= site_url('master/delete_supplier'); ?>',
            method: 'POST',
            data: {id:id},
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Supplier berhasil di hapus',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal diproses',
                        });
                        
                    }
            }
        });
        
    });

    $('.edit-sub-act').on('click', function(){
        var id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('master/get_supplier_id'); ?>',
            method: 'POST',
            dataType: 'JSON',
            data: {id:id},
            success: function(data){
                $('#id_e').val(data.id_supplier);
                $('#nama_e').val(data.nama)
                $('#alamat_e').val(data.alamat)
                $('#nama_toko_e').val(data.nama_toko)
                $('#no_tlp_e').val(data.no_tlp)
                $('#nama_bank_e').val(data.nama_bank)
                $('#atas_nama_e').val(data.atas_nama)
                $('#no_rek_e').val(data.no_rek)
            }
        });
    });

    </script>
<?php }elseif($url_cek == 'master/unit/'){ ?>
    <script>
        var table;
        jQuery(document).ready(function() {
            table = $('#unit-table').DataTable({ 
                "responsive"    : false,
                "autoWidth"     : false,
                "lengthChange"  : true,
                "lengthMenu"    : [10,20,50,100],

                "processing"    : true, //Feature control the processing indicator.

            });
        });
    

    $('#add-unit').on('click', function(){
        var nama_satuan = $('#nama_satuan').val();
        
        $.ajax({
            url: '<?= site_url('master/add_unit'); ?>',
            method: 'POST',
            data: {
                'nama_satuan' : nama_satuan,
            },
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data unit baru barhasil di tambahkan',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                } else {
                    if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jenis unit Wajib dipilih...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                }
            }
        });

    });


    $('#edit-unit').on('click', function(){
        var nama_satuan = $('#nama_satuan_edit').val();
        var id = $('#id').val();


        $.ajax({
            url: '<?= site_url('master/edit_unit'); ?>',
            method: 'POST',
            data: {
                'nama_satuan' : nama_satuan,
                'id' : id
            },
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data unit barhasil di edit',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                } else {
                    if(result.status == 1) {
                    Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'unit Wajib dipilih...',
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Data Gagal diproses',
                        })
                    }
                }
            }
        });

    });


    $('.del-unit').on('click', function(){
        var id = $(this).data('id');

        $.ajax({
            url: '<?= site_url('master/delete_unit'); ?>',
            method: 'POST',
            data: {id:id},
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data unit berhasil di hapus',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal diproses',
                        });
                        
                    }
            }
        });
        
    });

    $('.edit-unit-act').on('click', function(){
        var id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('master/get_unit_id'); ?>',
            method: 'POST',
            dataType: 'JSON',
            data: {id:id},
            success: function(data){
                $('#nama_satuan_edit').val(data.nama_satuan);
                $('#id').val(data.id);
            }
        });
    });

    </script>
<?php }elseif($url_cek == 'master/tipe/'){ ?>

    <script>


    $('#tipe-table').dataTable();

    $('#id_kategori').on('change', function(){
        var id = $(this).val();
        $.ajax({
            url: '<?= site_url('master/get_mat'); ?>',
            dataType: 'JSON',
            data: {id:id},
            type: 'POST',
            success: function(data){
                    var html = '<option value="">-pilih-</option>';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id+'>'+data[i].nama_material+'</option>';
                    }
                    $('#id_material').html(html); 
            }
        });
    });

    $('#id_material').on('change', function(){
        var id = $('#id_material').val();
        if(id == ""){
            $('#unit_id').val();
        }else{
            $.ajax({
                url: '<?= site_url('master/get_sat'); ?>',
                dataType: 'JSON',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    console.log(d);
                    $('#unit_id').val(d.nama_satuan);
                }
            });
        }
    });

    $('#lokasi').on('change', function(){
        var lokasi = $(this).val();
        // var status = $(this).data('status');
        // console.log(status);

        $.ajax({
            url: '<?= site_url('master/get_perum_id_ajax'); ?>',
            dataType: 'JSON',
            data: {id:lokasi},
            type: 'POST',
            success: function(d){
                var status = d.cluster;
                $('#status_cluster').val(status);
                if(status == 0){
                    $('#cluster').attr('disabled', true);
                } else if(status == 1){
                    $('#cluster').removeAttr('disabled');
                }
            }
        });

        $.ajax({
            url: '<?= site_url('master/get_cluster_by_perum'); ?>',
            dataType: 'JSON',
            data: {lokasi:lokasi},
            type: 'POST',
            success: function(data){
                // console.log(d);

                    var html = '<option value="">--Pilih--</option>';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id_cluster+'>'+data[i].nama_cluster+'</option>';
                    }
                    $('#cluster').html(html); 

            }
        });



    });

    $('#lokasi_e').on('change', function(){
        var lokasi = $(this).val();
        $.ajax({
            url: '<?= site_url('master/get_perum_id_ajax'); ?>',
            dataType: 'JSON',
            data: {id:lokasi},
            type: 'POST',
            success: function(d){
                var status = d.cluster;
                $('#status_cluster_e').val(status);
                if(status == 0){
                    $('#cluster_e').attr('disabled', true);
                } else if(status == 1){
                    $('#cluster_e').removeAttr('disabled');
                }
            }
        });

        $.ajax({
            url: '<?= site_url('master/get_cluster_by_perum'); ?>',
            dataType: 'JSON',
            data: {lokasi:lokasi},
            type: 'POST',
            success: function(data){
                // console.log(d);

                    var html = '<option value="">--Pilih--</option>';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option value='+data[i].id_cluster+'>'+data[i].nama_cluster+'</option>';
                    }
                    $('#cluster_e').html(html); 

            }
        });
    });

    $('#add-tipe').on('click', function(){
        var lokasi = $('#lokasi').val();
        var tipe = $('#tipe').val();
        var cluster = $('#cluster').val();
        $.ajax({
            url: '<?= site_url('master/add_tipe'); ?>',
            method: 'POST',
            data: {
                'lokasi' : lokasi,
                'tipe' : tipe,
                'cluster' : cluster
            },
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data tipe barhasil di tambahkan',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                } else {
                    if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Harap pilih Perumahan...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tipe wajib diisi',
                                })
                            }
                            else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                }
            }
        });

    });


    $('#edit-tipe').on('click', function(){
        var lokasi = $('#lokasi_e').val();
        var tipe = $('#tipe_e').val();
        var id = $('#id_tipe').val();
        var cluster = $('#cluster_e').val();

        var id_kategori = $('#id_kategori').val();
        var id_material = $('#id_material').val();
        var max = $('#max').val();
        
        $.ajax({
            url: '<?= site_url('master/edit_tipe'); ?>',
            method: 'POST',
            data: {
                'lokasi' : lokasi,
                'tipe' : tipe,
                'id' : id,
                'cluster' : cluster,

                'id_kategori' : id_kategori,
                'id_material' : id_material,
                'max' : max,
            },
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data tipe barhasil di edit dan Data Material Max Berhasil Ditambahkan',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                } else {
                    
                    if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Harap pilih Perumahan...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tipe wajib diisi',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cluster harap di isi',
                                })
                            
                            }else if(result.status == 5){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jenis Material harap di isi',
                                })
                            
                            }

                            else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                }
            }
        });

    });


    $('.del-tipe').on('click', function(){
        var id = $(this).data('id');

        $.ajax({
            url: '<?= site_url('master/delete_tipe'); ?>',
            method: 'POST',
            data: {id:id},
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Tipe dan Material Max berhasil di hapus',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal diproses',
                        });
                        
                    }
            }
        });
        
    });

    $('.edit-tipe-act').on('click', function(){
        var id = $(this).data('id');
        var status = $(this).data('status');
            $.ajax({
                url: '<?= site_url('master/get_tipe_id'); ?>',
                method: 'POST',
                dataType: 'JSON',
                data: {id:id},
                success: function(data){
                    $('#lokasi_e').val(data.id_perum);
                    $('#tipe_e').val(data.tipe);
                    $('#id_tipe').val(data.id_tipe);
                    $('#status_cluster_e').val(data.cluster);

                        var lokasi = data.id_perum;
                        var cluster = data.id_cluster;

                        $('#cluster_e').removeAttr('disabled');

                        $.ajax({
                            url: '<?= site_url('master/get_cluster_by_perum'); ?>',
                            dataType: 'JSON',
                            data: {lokasi:lokasi},
                            type: 'POST',
                            success: function(data){
                                // console.log(d);

                                    var html = '<option value="">--Pilih--</option>';
                                    var i;
                                    for(i=0; i<data.length; i++){
                                        if(data[i].id_cluster == cluster){
                                            html += '<option value='+data[i].id_cluster+' selected>'+data[i].nama_cluster+'</option>';
                                        } else {
                                            html += '<option value='+data[i].id_cluster+'>'+data[i].nama_cluster+'</option>';   
                                        }
                                        
                                    }
                                    $('#cluster_e').html(html); 

                            }
                        });
                    }

            });

        

    });

    $(document).on('click', '#open_detail', function() {
            var id = $(this).data('id');
            window.location='<?=site_url('master/view_max/')?>' + id;
    });


    </script>
<?php }elseif($url_cek == 'master/view_max/'){ ?>
    <script>
        var table;
        jQuery(document).ready(function() {
            table = $('#max-table').DataTable({ 
                "responsive"    : false,
                "autoWidth"     : false,
                "lengthChange"  : true,
                "lengthMenu"    : [10,20,50,100],

                "processing"    : true, //Feature control the processing indicator.

            });
        });

        $('#id_kategori_e').on('change', function(){
            var id = $(this).val();
            $.ajax({
                url: '<?= site_url('master/get_mat'); ?>',
                dataType: 'JSON',
                data: {id:id},
                type: 'POST',
                success: function(data){
                        var html = '<option value="">-pilih-</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value='+data[i].id+'>'+data[i].nama_material+'</option>';
                        }
                        $('#id_material_e').html(html); 
                }
            });
        });

        $('#id_material_e').on('change', function(){
            var id = $('#id_material_e').val();
            if(id == ""){
                $('#unit_id_e').val();
            }else{
                $.ajax({
                    url: '<?= site_url('master/get_sat'); ?>',
                    dataType: 'JSON',
                    data: {id:id},
                    type: 'POST',
                    success: function(d){
                        console.log(d);
                        $('#unit_id_e').val(d.nama_satuan);
                    }
                });
            }
        });

        $('.set_edit_max').on('click', function(){
            var id_max = $(this).data('id_max');

            $.ajax({
                url: '<?= site_url('master/get_materialMax_id'); ?>',
                method: 'POST',
                dataType: 'JSON',
                data: {id_max:id_max},
                success: function(data){

                    $('#id_kategori_e').val(data.kategori_id);
                    $('#id_material_e').val(data.material_id);
                    $('#max_e').val(data.max);
                    $('#id_max').val(data.id_max);
                    $('#id_tipe').val(data.id_tipe);

                            var kategori_id = data.kategori_id;
                            var material_id = data.material_id;

                            $.ajax({
                                url: '<?= site_url('master/get_mat'); ?>',
                                dataType: 'JSON',
                                data: {kategori_id:kategori_id},
                                type: 'POST',
                                success: function(d){
                                    console.log(d);
                                        var html = '<option value="">-pilih-</option>';
                                        var i;
                                        for(i=0; i<d.length; i++){
                                        if(d[i].id == material_id){
                                                html += '<option value='+d[i].id+' selected>'+d[i].nama_material+'</option>';
                                            } else {
                                                html += '<option value='+d[i].id+'>'+d[i].nama_material+'</option>';   
                                            }
                                        }
                                        $('#id_material_e').html(html); 
                                }
                            });

                            var id = $('#id_material_e').val();
                            if(id == ""){
                                $('#unit_id_e').val();
                            }else{
                                $.ajax({
                                    url: '<?= site_url('master/get_sat'); ?>',
                                    dataType: 'JSON',
                                    data: {id:id},
                                    type: 'POST',
                                    success: function(d){
                                        console.log(d);
                                        $('#unit_id_e').val(d.nama_satuan);
                                    }
                                });
                            }
                }
            });
        });
    

        $('#edit-max').on('click', function(){
            var id_tipe = $('#id_tipe').val();
            var max = $('#max_e').val();
            var id_max = $('#id_max').val();
            var id_kategori = $('#id_kategori_e').val();
            var id_material = $('#id_material_e').val();


            $.ajax({
                url: '<?= site_url('master/edit_materialMax'); ?>',
                method: 'POST',
                data: {
                    'id_tipe' : id_tipe,
                    'max' : max,
                    'id_max' : id_max,
                    'id_kategori' : id_kategori,
                    'id_material' : id_material,
                },
                dataType: 'JSON',
                success: function(result){
                    if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data Material Max barhasil di edit',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        $('#staticBackdrop').modal('hide')
                                        setInterval('location.reload()', 500);
                                    }
                                )
                    } else {
                        if(result.status == 1) {
                        Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Jenis Material Wajib dipilih...',
                            })
                        }if(result.status == 2) {
                        Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Max Wajib dipilih...',
                            })
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Data Gagal diproses',
                            })
                        }
                    }
                }
            });

        });


    $('.del-max').on('click', function(){
        var id_max = $(this).data('id_max');

        $.ajax({
            url: '<?= site_url('master/delete_materialMax'); ?>',
            method: 'POST',
            data: {id_max:id_max},
            dataType: 'JSON',
            success: function(result){
                if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data Material Max berhasil di hapus',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal diproses',
                        });
                        
                    }
            }
        });
        
    });

    </script>
<?php }elseif($url_cek == 'marketing/transaksi_bank/'){ ?>
    <script>
        $('#list_add-tf_bnk').dataTable();

        // $('.add-btn-tf-bank').on('click', function(){
        $(document).on('click','.add-btn-tf-bank', function(){
            var id_konsumen = $(this).data('id');
            $('#id_konsumen').val(id_konsumen);
        });

        $('#status_menikah').on('change', function(){
            var status = $(this).val();
            if(status == ''){
                $('.formPasangan').addClass('d-none');
            } else if(status == 'Belum'){
                $('.formPasangan').addClass('d-none');
            } else if(status == 'Sudah'){
                $('.formPasangan').removeClass('d-none');
            }
        });


        $('#cluster').on('change', function(){
            var id = $(this).val();

            $.ajax({
                url: '<?= site_url('marketing/get_kavling_by_cluster'); ?>',
                dataType: 'JSON',
                data: {cluster:id},
                type: 'POST',
                success: function(data){
                        var html = '<option value=>--Pilih--</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value='+data[i].id_kavling+'>'+data[i].blok + data[i].no_rumah+'</option>';
                        }
                        $('#blok').html(html);
                }
            });

        });

        $('#blok').change(function(){
            var id_blok = $('#blok').val();
            var cluster = $('#cluster').val();
                // if(cluster == ''){
                //                 $('#type').val('');
                //                 $('#luas').val('');
                //                 $('#harga').val('');
                //                 $('#harga_kesepakatan').val('');
                // } else {
                $.ajax({
                    url: '<?= site_url('marketing/get_blok_id'); ?>',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {id:id_blok},
                    success: function(d){
                        $('#type').val(d.tipe);
                        $('#lb').val(d.lb);
                        $('#lt').val(d.lt);
                        $('#harga').val(d.harga);
                        $('#harga_A').val(d.harga);
                        $('#harga_kesepakatan').val(d.harga);
                    }
                });
            // }   
        });

        $('#v_tanda_jadi_lokasi').on('keyup', function(){
            var tanda_jadi_lokasi = $('#tanda_jadi_lokasi').val();
            var angsur = $('#angsur_tj').val();
            var cicilan_angsur = tanda_jadi_lokasi / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(tanda_jadi_lokasi == ''){
                $('#cicil_angsur_tj').val('');
                $('#v_cicil_angsur_tj').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_tj').val('');
                $('#v_cicil_angsur_tj').val('');
            } else {
                $('#cicil_angsur_tj').val(real);
                $('#v_cicil_angsur_tj').val(real);
            }
        });

        $('#angsur_tj').on('keyup', function(){
            var tanda_jadi_lokasi = $('#tanda_jadi_lokasi').val();
            var angsur = $('#angsur_tj').val();
            var cicilan_angsur = tanda_jadi_lokasi / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(tanda_jadi_lokasi == ''){
                $('#cicil_angsur_tj').val('');
                $('#v_cicil_angsur_tj').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_tj').val('');
                $('#v_cicil_angsur_tj').val('');
            } else {
                $('#cicil_angsur_tj').val(real);
                $('#v_cicil_angsur_tj').val(real);
            }
        });

        $('#v_um').on('keyup', function(){
            var uang_muka = $('#uang_muka').val();
            var angsur = $('#angsur_um').val();
            var cicilan_angsur = uang_muka / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(uang_muka == ''){
                $('#cicil_angsur_um').val('');
                $('#v_cicil_um').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_um').val('');
                $('#v_cicil_um').val('');
            } else {
                $('#cicil_angsur_um').val(real);
                $('#v_cicil_um').val(real);
            }
        });

        $('#angsur_um').on('keyup', function(){
            var uang_muka = $('#uang_muka').val();
            var angsur = $('#angsur_um').val();
            var cicilan_angsur = uang_muka / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(uang_muka == ''){
                $('#cicil_angsur_um').val('');
                $('#v_cicil_um').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_um').val('');
                $('#v_cicil_um').val('');
            } else {
                $('#cicil_angsur_um').val(real);
                $('#v_cicil_um').val(real);
            }
        });

        $('#v_kelebihan_tanah').on('keyup', function(){
            var kelebihan_tanah = $('#kelebihan_tanah').val();
            var angsur = $('#angsur_kt').val();
            var cicilan_angsur = kelebihan_tanah / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }


            if(kelebihan_tanah == ''){
                $('#cicil_angsur_kt').val('');
                $('#v_cicil_angsur_kt').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_kt').val('');
                $('#v_cicil_angsur_kt').val('');
            } else {
                $('#cicil_angsur_kt').val(real);
                $('#v_cicil_angsur_kt').val(real);
            }
        });

        $('#angsur_kt').on('keyup', function(){
            var kelebihan_tanah = $('#kelebihan_tanah').val();
            var angsur = $('#angsur_kt').val();
            var cicilan_angsur = kelebihan_tanah / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(kelebihan_tanah == ''){
                $('#cicil_angsur_kt').val('');
                $('#v_cicil_angsur_kt').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_kt').val('');
                $('#v_cicil_angsur_kt').val('');
            } else {
                $('#cicil_angsur_kt').val(real);
                $('#v_cicil_angsur_kt').val(real);
            }
        });

        $('#v_pak').on('keyup', function(){
            var pak = $('#pak').val();
            var angsur = $('#angsur_pak').val();
            var cicilan_angsur = pak / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(pak == ''){
                $('#cicil_angsur_pak').val('');
                $('#v_cicil_angsur_pak').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_pak').val('');
                $('#v_cicil_angsur_pak').val('');
            } else {
                $('#cicil_angsur_pak').val(real);
                $('#v_cicil_angsur_pak').val(real);
            }
        });

        $('#angsur_pak').on('keyup', function(){
            var pak = $('#pak').val();
            var angsur = $('#angsur_pak').val();
            var cicilan_angsur = pak / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(pak == ''){
                $('#cicil_angsur_pak').val('');
                $('#v_cicil_angsur_pak').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_pak').val('');
                $('#v_cicil_angsur_pak').val('');
            } else {
                $('#cicil_angsur_pak').val(real);
                $('#v_cicil_angsur_pak').val(real);
            }
        });

        $('#v_lain').on('keyup', function(){
            var lain = $('#lain').val();
            var angsur = $('#angsur_lain').val();
            var cicilan_angsur = lain / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(lain == ''){
                $('#cicil_angsur_lain').val('');
                $('#v_cicil_angsur_lain').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_lain').val('');
                $('#v_cicil_angsur_lain').val('');
            } else {
                $('#cicil_angsur_lain').val(real);
                $('#v_cicil_angsur_lain').val(real);
            }
        });

        $('#angsur_lain').on('keyup', function(){
            var lain = $('#lain').val();
            var angsur = $('#angsur_lain').val();
            var cicilan_angsur = lain / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(lain == ''){
                $('#cicil_angsur_lain').val('');
                $('#v_cicil_angsur_lain').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_lain').val('');
                $('#v_cicil_angsur_lain').val('');
            } else {
                $('#cicil_angsur_lain').val(real);
                $('#v_cicil_angsur_lain').val(real);
            }
        });

        $('#v_angsuran').on('keyup', function(){
            var angsuran = $('#angsuran').val();
            var angsur = $('#angsur_A').val();
            var cicilan_angsur = angsuran / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(angsuran == ''){
                $('#cicil_A').val('');
                $('#v_cicil_A').val('');
            } else if(angsur == ''){
                $('#cicil_A').val('');
                $('#v_cicil_A').val('');
            } else {
                $('#cicil_A').val(real);
                $('#v_cicil_A').val(real);
            }
        });

        $('#angsur_A').on('keyup', function(){
            var angsuran = $('#angsuran').val();
            var angsur = $('#angsur_A').val();
            var cicilan_angsur = angsuran / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(angsuran == ''){
                $('#cicil_A').val('');
                $('#v_cicil_A').val('');
            } else if(angsur == ''){
                $('#cicil_A').val('');
                $('#v_cicil_A').val('');
            } else {
                $('#cicil_A').val(real);
                $('#v_cicil_A').val(real);
            }
        });

        $('#v_piutang').on('keyup', function(){
            var piutang = $('#piutang').val();
            var angsur = $('#angsur_P').val();
            var cicilan_angsur = piutang / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(piutang == ''){
                $('#cicil_P').val('');
                $('#v_cicil_P').val('');
            } else if(angsur == ''){
                $('#cicil_P').val('');
                $('#v_cicil_P').val('');
            } else {
                $('#cicil_P').val(real);
                $('#v_cicil_P').val(real);
            }
        });

        $('#angsur_P').on('keyup', function(){
            var piutang = $('#piutang').val();
            var angsur = $('#angsur_P').val();
            var cicilan_angsur = piutang / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(piutang == ''){
                $('#cicil_P').val('');
                $('#v_cicil_P').val('');
            } else if(angsur == ''){
                $('#cicil_P').val('');
                $('#v_cicil_P').val('');
            } else {
                $('#cicil_P').val(real);
                $('#v_cicil_P').val(real);
            }
        });

        $('#id_rumah').click(function(){

        });

        $('#add-transaksi-bank').on('click', function(){
            $('#add-transaksi-bank').addClass('disabled');
            var nik = $('#nik').val();
            var tempat_kerja = $('#tempat_kerja').val();
            var gaji = $('#gaji').val();
            var email = $('#email').val();
            var alamat = $('#alamat').val();
            var status_menikah = $('#status_menikah').val();

            var rumah = $('#blok').val();
            var harga_kesepakatan = $('#harga_kesepakatan').val();
            var tanda_jadi = $('#tanda_jadi').val();
            var tgl_tanda_jadi = $('#tgl_tanda_jadi').val();

            var status_perum = $('#status_perum').val();
            var cluster = $('#cluster').val();

            var tanda_jadi_lokasi = $('#tanda_jadi_lokasi').val();
            var angsur_tj = $('#angsur_tj').val();
            var cicil_angsur_tj = $('#cicil_angsur_tj').val();
            var tempo_tj = $('#tempo_tj').val();

            var uang_muka = $('#uang_muka').val();
            var angsur_um = $('#angsur_um').val();
            var cicil_angsur_um = $('#cicil_angsur_um').val();
            var tempo_um = $('#tempo_um').val();
            
            var kelebihan_tanah = $('#kelebihan_tanah').val();
            var angsur_kt = $('#angsur_kt').val();
            var cicil_angsur_kt = $('#cicil_angsur_kt').val();
            var tempo_kt = $('#tempo_kt').val();

            var pak = $('#pak').val();
            var angsur_pak = $('#angsur_pak').val();
            var cicil_angsur_pak = $('#cicil_angsur_pak').val();
            var tempo_pak = $('#tempo_pak').val();

            var lain = $('#lain').val();
            var angsur_lain = $('#angsur_lain').val();
            var cicil_angsur_lain = $('#cicil_angsur_lain').val();
            var tempo_lain = $('#tempo_lain').val();

            var id_konsumen = $('#id_konsumen').val();

            var nik_p = $('#nik_p').val();
            var nama_p = $('#nama_p').val();
            var nohp_p = $('#no_hp_p').val();
            var email_p = $('#email_p').val();
            var jk_p = $('#jk_p').val();
            var pekerjaan_p = $('#pekerjaan_p').val();
            var tk_p = $('#tmp_kerja_p').val();
            var gaji_p = $('#gaji_p').val();


            var piutang_bank = $('#piutang').val();
            var angsur_piutang = $('#angsur_P').val();
            var cicil_piutang = $('#cicil_P').val();
            var tempo_piutang = $('#tempo_P').val();

            var angsur_bank = $('#angsuran').val();
            var angsur_angsuran = $('#angsur_A').val();
            var cicil_angsuran = $('#cicil_A').val();
            var tempo_angsuran = $('#tempo_A').val();

            console.log(nik_p);

            $.ajax({
                url: '<?= site_url('marketing/add_transaksi_bank'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {
                    piutang_bank: piutang_bank,
                    angsur_piutang: angsur_piutang,
                    cicil_piutang: cicil_piutang,
                    tempo_piutang: tempo_piutang,

                    angsur_bank: angsur_bank,
                    agsur_angsuran: angsur_angsuran,
                    cicil_angsuran: cicil_angsuran,
                    tempo_angsuran: tempo_angsuran,

                    nik_p : nik_p,
                    nama_p : nama_p,
                    nohp_p : nohp_p,
                    email_p : email_p,
                    jk_p : jk_p,
                    pekerjaan_p : pekerjaan_p,
                    tk_p : tk_p,
                    gaji_p : gaji_p,

                    nik : nik,
                    tempat_kerja : tempat_kerja,
                    gaji : gaji,
                    email : email,
                    alamat : alamat,
                    status_menikah : status_menikah,

                    rumah :rumah,
                    harga_kesepakatan :harga_kesepakatan,
                    tanda_jadi : tanda_jadi,
                    tgl_tanda_jadi : tgl_tanda_jadi,

                    tanda_jadi_lokasi : tanda_jadi_lokasi,
                    angsur_tj : angsur_tj,
                    cicil_angsur_tj : cicil_angsur_tj,
                    tempo_tj : tempo_tj,

                    uang_muka : uang_muka,
                    angsur_um : angsur_um,
                    cicil_angsur_um : cicil_angsur_um,
                    tempo_um : tempo_um,
                    
                    kelebihan_tanah : kelebihan_tanah,
                    angsur_kt : angsur_kt,
                    cicil_angsur_kt : cicil_angsur_kt,
                    tempo_kt : tempo_kt,

                    pak : pak,
                    angsur_pak : angsur_pak,
                    cicil_angsur_pak : cicil_angsur_pak,
                    tempo_pak : tempo_pak,

                    lain : lain,
                    angsur_lain : angsur_lain,
                    cicil_angsur_lain : cicil_angsur_lain,
                    tempo_lain : tempo_lain,

                    id_konsumen : id_konsumen,

                    status_perum: status_perum,
                    cluster: cluster,

                    
                },
                success : function(result){
                    if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Transaksi Bank Berhasil',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            )
                    } else {
                        if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'NIK wajib diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');
                            }
                        
                        else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Alamat wajib diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Harap pilih status menikah...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 4){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Harap pilih blok rumah...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 5){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Harga kesepakatan harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 6){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanda Jadi harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 7){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Tanda Jadi harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 8){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Tanda Jadi Lokasi harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 9){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran Tanda Jadi Lokasi harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 10){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran uang muka harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 11){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran uang muka harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 12){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran kelebihan tanah harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 13){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran kelebihan tanah harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 14){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran PAK harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 15){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran PAK harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 16){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Lain-Lain harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 17){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran Lain-Lain harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 18){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tempat Kerja harap di isi',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 19){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gaji harap di isi',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 20){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Email harap di isi',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 21){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'NIK sudah terdaftar',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 22){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Email sudah terdaftar',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 30){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'NIK Pasangan harap di isi',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 31){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nama Pasangan harap di isi',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 32){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No Telp Pasangan harap di isi',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 33){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Email Pasangan harap di isi',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 34){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jenis Kelamin Pasangan harap di isi',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 35){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Pekerjaan Pasangan harap di isi',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 36){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tempat Kerja Pasangan harap di isi',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 37){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gaji Pasangan harap di isi',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 38){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'NIK Pasangan sudah terdaftar',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 39){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Email Pasangan sudah terdaftar',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 40){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No Telp Pasangan sudah terdaftar',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 91){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Piutang Bank harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 92){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tempo Piutang Bank harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 93){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Bank harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 94){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tempo Angsuran Bank harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Transaksi Bank Gagal',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');
                        }
                    
                    }
                }
            });
        });

        $('#list_tf_bank').dataTable();
        $(document).on('click','.view-tf-bank', function(){
            var konsumen = $(this).data('konsumen');
            $.ajax({
                url: '<?= site_url('marketing/view_detail_tf_bank'); ?>',
                method: 'POST',
                data: {id_konsumen:konsumen},
                success: function(d){
                    $('#tf-bnk').html(d);
                }
            });
        });

        // $('.btn-edit-konsumen').on('click', function(){
        $(document).on('click', '.btn-edit-konsumen', function(){
            var id = $(this).data('id');


            $('#nik_edit').val('');
            $('#nama_edit').val('');
            $('#jk_edit').val('');
            $('#no_hp_edit').val('');
            $('#pekerjaan_edit').val('');
            $('#alamat_edit').val('');
            $('#email_edit').val('');
            $('#status_menikah_edit').val('');
            $('#tempat_kerja_edit').val('');
            $('#v_gaji_edit').val('');
            $('#gaji_edit').val('');
            $('#info_edit').val('');

            $('#nik_pe').val('');
            $('#nama_pe').val('');
            $('#no_hp_pe').val('');
            $('#email_pe').val('');
            $('#jk_pe').val('');
            $('#pekerjaan_pe').val('');
            $('#tmp_kerja_pe').val('');
            $('#v_gaji_pe').val('');
            $('#gaji_pe').val('');
            
            $('#cluster_edit').val('');
            $('#blok_edit').val('');
            $('#type_edit').val('');
            $('#lt_edit').val('');
            $('#lb_edit').val('');
            $('#v_harga_edit').val('');
            $('#harga_edit').val('');

            $('#v_hk_edit').val('');
            $('#hk_edit').val('');
            $('#v_tj_edit').val('');
            $('#tj_edit').val('');
            $('#tgl_tj_edit').val('');
            
            $('#v_tjl_edit').val('');
            $('#tjl_edit').val('');
            $('#angsur_tjl_edit').val('');
            $('#v_angsuran_tjl_edit').val('');
            $('#angsuran_tjl_edit').val('');
            $('#bayar_tjl_edit').val('');

            $('#v_um_edit').val('');
            $('#um_edit').val('');
            $('#angsur_um_edit').val('');
            $('#v_angsuran_um_edit').val('');
            $('#angsuran_um_edit').val('');
            $('#bayar_um_edit').val('');

            $('#v_kt_edit').val('');
            $('#kt_edit').val('');
            $('#angsur_kt_edit').val('');
            $('#v_angsuran_kt_edit').val('');
            $('#angsuran_kt_edit').val('');
            $('#bayar_kt_edit').val('');

            $('#v_pak_edit').val('');
            $('#pak_edit').val('');
            $('#angsur_pak_edit').val('');
            $('#v_angsuran_pak_edit').val('');
            $('#angsuran_pak_edit').val('');
            $('#bayar_pak_edit').val('');

            $('#v_angsuran_edit').val('');
            $('#angsuran_edit').val('');
            $('#angsur_AE').val('');
            $('#v_cicil_AE').val('');
            $('#cicil_AE').val('');
            $('#tempo_AE').val('');

            $('#v_piutang_edit').val('');
            $('#piutang_edit').val('');
            $('#angsur_PE').val('');
            $('#v_cicil_PE').val('');
            $('#cicil_PE').val('');
            $('#tempo_PE').val('');

            $('#v_lain_edit').val('');
            $('#lain_edit').val('');
            $('#angsur_lain_edit').val('');
            $('#v_angsuran_lain_edit').val('');
            $('#angsuran_lain_edit').val('');
            $('#bayar_lain_edit').val('');

            $.ajax({
                url: '<?= site_url('marketing/get_status_menikah'); ?>',
                data: {id:id},
                dataType: 'JSON',
                type: 'POST',
                success: function(d){
                    if(d > 0){
                        $('.formPasanganEdit').removeClass('d-none');
                    } else {
                        $('.formPasanganEdit').addClass('d-none');
                    }
                }
            });


                        $.ajax({
                            url: '<?= site_url('marketing/get_pasangan'); ?>',
                            dataType: 'JSON',
                            data: {id:id},
                            type: 'POST',
                            success: function(d){
                                $('#nik_pe').val(d.nik);
                                $('#nama_pe').val(d.nama);
                                $('#no_hp_pe').val(d.no_hp);
                                $('#email_pe').val(d.email);
                                $('#jk_pe').val(d.jk);
                                $('#pekerjaan_pe').val(d.pekerjaan);
                                $('#tmp_kerja_pe').val(d.tempat_kerja);
                                $('#gaji_pe').val(d.gaji);
                                $('#v_gaji_pe').val(d.gaji);
                            }
                        });


            $('#status_menikah_edit').on('change', function(){
                var status = $(this).val();
                    if(status == ''){
                        $('.formPasanganEdit').addClass('d-none');
                    } else if(status == 'Belum'){
                        $('.formPasanganEdit').addClass('d-none');
                    } else if(status == 'Sudah'){
                        $('.formPasanganEdit').removeClass('d-none');
                    }
            });


            // console.log(id);
            $.ajax({
                url: '<?= site_url('marketing/get_bank_join_all'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(d){
                    // console.log(d);
                    $('#id_konsumen_edit').val(d.id_marketing);
                    $('#nik_edit').val(d.nik);
                    $('#nama_edit').val(d.nama_konsumen);
                    $('#jk_edit').val(d.jk);
                    $('#no_hp_edit').val(d.no_hp);
                    $('#pekerjaan_edit').val(d.pekerjaan);
                    $('#alamat_edit').val(d.alamat);
                    $('#email_edit').val(d.email);
                    $('#status_menikah_edit').val(d.status_menikah);
                    $('#tempat_kerja_edit').val(d.tempat_kerja);
                    $('#gaji_edit').val(d.gaji);
                    $('#v_gaji_edit').val(d.gaji);
                    $('#info_edit').val(d.dapat_info);
                    
                    $('#blok_edit').val(d.blok + d.no_rumah);
                    $('#type_edit').val(d.tipe);
                    $('#lt_edit').val(d.lt);
                    $('#lb_edit').val(d.lb);
                    $('#cluster_edit').val(d.nama_cluster);
                    $('#harga_edit').val(d.harga);
                    $('#v_harga_edit').val(d.harga);
                    
                    $('#hk_edit').val(d.harga_kesepakatan);
                    $('#v_hk_edit').val(d.harga_kesepakatan);
                    $('#tj_edit').val(d.tanda_jadi);
                    $('#v_tj_edit').val(d.tanda_jadi);
                    $('#tgl_tj_edit').val(d.tgl_tanda_jadi);

                }
            });

            $.ajax({
                url: '<?= site_url('marketing/get_tjl'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(tjl){
                    $('#tjl_edit').val(tjl.jml_tjl);
                    $('#v_tjl_edit').val(tjl.jml_tjl);
                    $('#angsur_tjl_edit').val(tjl.angsuran);
                    $('#angsuran_tjl_edit').val(tjl.cicilan_angsuran);
                    $('#v_angsuran_tjl_edit').val(tjl.cicilan_angsuran);
                    $('#bayar_tjl_edit').val(tjl.tgl_bayar);
                }
            });

            $.ajax({
                url: '<?= site_url('marketing/get_um'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(um){
                    $('#um_edit').val(um.jml_um);
                    $('#v_um_edit').val(um.jml_um);
                    $('#angsur_um_edit').val(um.angsuran);
                    $('#angsuran_um_edit').val(um.cicilan_angsuran);
                    $('#v_angsuran_um_edit').val(um.cicilan_angsuran);
                    $('#bayar_um_edit').val(um.tgl_bayar);
                }
            });

            $.ajax({
                url: '<?= site_url('marketing/get_kt'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(kt){
                    $('#kt_edit').val(kt.jml_kt);
                    $('#v_kt_edit').val(kt.jml_kt);
                    $('#angsur_kt_edit').val(kt.angsuran);
                    $('#angsuran_kt_edit').val(kt.cicilan_angsuran);
                    $('#v_angsuran_kt_edit').val(kt.cicilan_angsuran);
                    $('#bayar_kt_edit').val(kt.tgl_bayar);
                }
            });

            $.ajax({
                url: '<?= site_url('marketing/get_pak'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(pak){
                    $('#pak_edit').val(pak.jml_pak);
                    $('#v_pak_edit').val(pak.jml_pak);
                    $('#angsur_pak_edit').val(pak.angsuran);
                    $('#angsuran_pak_edit').val(pak.cicilan_angsuran);
                    $('#v_angsuran_pak_edit').val(pak.cicilan_angsuran);
                    $('#bayar_pak_edit').val(pak.tgl_bayar);
                }
            });

            $.ajax({
                url: '<?= site_url('marketing/get_lain'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(lain){
                    $('#lain_edit').val(lain.jml_lain);
                    $('#v_lain_edit').val(lain.jml_lain);
                    $('#angsur_lain_edit').val(lain.angsuran);
                    $('#angsuran_lain_edit').val(lain.cicilan_angsuran);
                    $('#v_angsuran_lain_edit').val(lain.cicilan_angsuran);
                    $('#bayar_lain_edit').val(lain.tgl_bayar);
                }
            });

            $.ajax({
                url: '<?= site_url('marketing/get_angsuran'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(lain){
                    $('#angsuran_edit').val(lain.jml_angsur);
                    $('#v_angsuran_edit').val(lain.jml_angsur);
                    $('#angsur_AE').val(lain.angsuran);
                    $('#cicil_AE').val(lain.cicilan_angsuran);
                    $('#v_cicil_AE').val(lain.cicilan_angsuran);
                    $('#tempo_AE').val(lain.tgl_bayar);
                }
            });
            $.ajax({
                url: '<?= site_url('marketing/get_piutang'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(lain){
                    $('#piutang_edit').val(lain.jml_piutang);
                    $('#v_piutang_edit').val(lain.jml_piutang);
                    $('#angsur_PE').val(lain.angsuran);
                    $('#cicil_PE').val(lain.cicilan_angsuran);
                    $('#v_cicil_PE').val(lain.cicilan_angsuran);
                    $('#tempo_PE').val(lain.tgl_bayar);
                }
            });

        });


        $('#v_tjl_edit').on('keyup', function(){
            var tjl_edit = $('#tjl_edit').val();
            var angsur = $('#angsur_tjl_edit').val();
            var cicilan_angsur = tjl_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(tjl_edit == ''){
                $('#angsuran_tjl_edit').val('');
                $('#v_angsuran_tjl_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_tjl_edit').val('');
                $('#v_angsuran_tjl_edit').val('');
            } else {
                $('#angsuran_tjl_edit').val(real);
                $('#v_angsuran_tjl_edit').val(real);
            }
        });
        $('#angsur_tjl_edit').on('keyup', function(){
            var tjl_edit = $('#tjl_edit').val();
            var angsur = $('#angsur_tjl_edit').val();
            var cicilan_angsur = tjl_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(tjl_edit == ''){
                $('#angsuran_tjl_edit').val('');
                $('#v_angsuran_tjl_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_tjl_edit').val('');
                $('#v_angsuran_tjl_edit').val('');
            } else {
                $('#angsuran_tjl_edit').val(real);
                $('#v_angsuran_tjl_edit').val(real);
            }
        });

        $('#v_um_edit').on('keyup', function(){
            var um_edit = $('#um_edit').val();
            var angsur = $('#angsur_um_edit').val();
            var cicilan_angsur = um_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(um_edit == ''){
                $('#angsuran_um_edit').val('');
                $('#v_angsuran_um_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_um_edit').val('');
                $('#v_angsuran_um_edit').val('');
            } else {
                $('#angsuran_um_edit').val(real);
                $('#v_angsuran_um_edit').val(real);
            }
        });
        $('#angsur_um_edit').on('keyup', function(){
            var um_edit = $('#um_edit').val();
            var angsur = $('#angsur_um_edit').val();
            var cicilan_angsur = um_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(um_edit == ''){
                $('#angsuran_um_edit').val('');
                $('#v_angsuran_um_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_um_edit').val('');
                $('#v_angsuran_um_edit').val('');
            } else {
                $('#angsuran_um_edit').val(real);
                $('#v_angsuran_um_edit').val(real);
            }
        });

        $('#v_kt_edit').on('keyup', function(){
            var kt_edit = $('#kt_edit').val();
            var angsur = $('#angsur_kt_edit').val();
            var cicilan_angsur = kt_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(kt_edit == ''){
                $('#angsuran_kt_edit').val('');
                $('#v_angsuran_kt_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_kt_edit').val('');
                $('#v_angsuran_kt_edit').val('');
            } else {
                $('#angsuran_kt_edit').val(real);
                $('#v_angsuran_kt_edit').val(real);
            }
        });
        $('#angsur_kt_edit').on('keyup', function(){
            var kt_edit = $('#kt_edit').val();
            var angsur = $('#angsur_kt_edit').val();
            var cicilan_angsur = kt_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(kt_edit == ''){
                $('#angsuran_kt_edit').val('');
                $('#v_angsuran_kt_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_kt_edit').val('');
                $('#v_angsuran_kt_edit').val('');
            } else {
                $('#angsuran_kt_edit').val(real);
                $('#v_angsuran_kt_edit').val(real);
            }
        });

        $('#v_pak_edit').on('keyup', function(){
            var pak_edit = $('#pak_edit').val();
            var angsur = $('#angsur_pak_edit').val();
            var cicilan_angsur = pak_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(pak_edit == ''){
                $('#angsuran_pak_edit').val('');
                $('#v_angsuran_pak_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_pak_edit').val('');
                $('#v_angsuran_pak_edit').val('');
            } else {
                $('#angsuran_pak_edit').val(real);
                $('#v_angsuran_pak_edit').val(real);
            }
        });
        $('#angsur_pak_edit').on('keyup', function(){
            var pak_edit = $('#pak_edit').val();
            var angsur = $('#angsur_pak_edit').val();
            var cicilan_angsur = pak_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(pak_edit == ''){
                $('#angsuran_pak_edit').val('');
                $('#v_angsuran_pak_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_pak_edit').val('');
                $('#v_angsuran_pak_edit').val('');
            } else {
                $('#angsuran_pak_edit').val(real);
                $('#v_angsuran_pak_edit').val(real);
            }
        });

        $('#v_lain_edit').on('keyup', function(){
            var lain_edit = $('#lain_edit').val();
            var angsur = $('#angsur_lain_edit').val();
            var cicilan_angsur = lain_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(lain_edit == ''){
                $('#angsuran_lain_edit').val('');
                $('#v_angsuran_lain_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_lain_edit').val('');
                $('#v_angsuran_lain_edit').val('');
            } else {
                $('#angsuran_lain_edit').val(real);
                $('#v_angsuran_lain_edit').val(real);
            }
        });
        $('#angsur_lain_edit').on('keyup', function(){
            var lain_edit = $('#lain_edit').val();
            var angsur = $('#angsur_lain_edit').val();
            var cicilan_angsur = lain_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(lain_edit == ''){
                $('#angsuran_lain_edit').val('');
                $('#v_angsuran_lain_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_lain_edit').val('');
                $('#v_angsuran_lain_edit').val('');
            } else {
                $('#angsuran_lain_edit').val(real);
                $('#v_angsuran_lain_edit').val(real);
            }
        });

        $('#v_angsuran_edit').on('keyup', function(){
            var angsuran = $('#angsuran_edit').val();
            var angsur = $('#angsur_AE').val();
            var cicilan_angsur = angsuran / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(angsuran == ''){
                $('#cicil_AE').val('');
                $('#v_cicil_AE').val('');
            } else if(angsur == ''){
                $('#cicil_AE').val('');
                $('#v_cicil_AE').val('');
            } else {
                $('#cicil_AE').val(real);
                $('#v_cicil_AE').val(real);
            }
        });
        $('#angsur_AE').on('keyup', function(){
            var angsuran = $('#angsuran_edit').val();
            var angsur = $('#angsur_AE').val();
            var cicilan_angsur = angsuran / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(angsuran == ''){
                $('#cicil_AE').val('');
                $('#v_cicil_AE').val('');
            } else if(angsur == ''){
                $('#cicil_AE').val('');
                $('#v_cicil_AE').val('');
            } else {
                $('#cicil_AE').val(real);
                $('#v_cicil_AE').val(real);
            }
        });

        $('#v_piutang_edit').on('keyup', function(){
            var piutang = $('#piutang_edit').val();
            var angsur = $('#angsur_PE').val();
            var cicilan_angsur = piutang / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(piutang == ''){
                $('#cicil_PE').val('');
                $('#v_cicil_PE').val('');
            } else if(angsur == ''){
                $('#cicil_PE').val('');
                $('#v_cicil_PE').val('');
            } else {
                $('#cicil_PE').val(real);
                $('#v_cicil_PE').val(real);
            }
        });
        $('#angsur_PE').on('keyup', function(){
            var piutang = $('#piutang_edit').val();
            var angsur = $('#angsur_PE').val();
            var cicilan_angsur = piutang / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(piutang == ''){
                $('#cicil_PE').val('');
                $('#v_cicil_PE').val('');
            } else if(angsur == ''){
                $('#cicil_PE').val('');
                $('#v_cicil_PE').val('');
            } else {
                $('#cicil_PE').val(real);
                $('#v_cicil_PE').val(real);
            }
        });

        $('.btn-save-edit').on('click', function(){
            $('.btn-save-edit').addClass('disabled');
            //Data Konsumen
            var id_konsumen = $('#id_konsumen_edit').val();
            var nik = $('#nik_edit').val();
            var nama = $('#nama_edit').val();
            var jk = $('#jk_edit').val();
            var no_hp = $('#no_hp_edit').val();
            var pekerjaan = $('#pekerjaan_edit').val();
            var alamat = $('#alamat_edit').val();
            var email = $('#email_edit').val();
            var status_menikah = $('#status_menikah_edit').val();
            var tempat_kerja = $('#tempat_kerja_edit').val();
            var gaji = $('#gaji_edit').val();
            var info = $('#info_edit').val();
            
            //data bank
            var harga_kesepakatan = $('#hk_edit').val();
            var tanda_jadi = $('#tj_edit').val();
            var tgl_tanda_jadi = $('#tgl_tj_edit').val();
            
            //tanda jadi lokasi
            var tjl = $('#tjl_edit').val();
            var tjl_angsur = $('#angsur_tjl_edit').val();
            var tjl_angsuran = $('#angsuran_tjl_edit').val();
            var tjl_tgl_bayar = $('#bayar_tjl_edit').val();
            
            //uang muka
            var um = $('#um_edit').val();
            var um_angsur = $('#angsur_um_edit').val();
            var um_angsuran = $('#angsuran_um_edit').val();
            var um_tgl_bayar = $('#bayar_um_edit').val();
            
            //kelebihan tanah
            var kt = $('#kt_edit').val();
            var kt_angsur = $('#angsur_kt_edit').val();
            var kt_angsuran = $('#angsuran_kt_edit').val();
            var kt_tgl_bayar = $('#bayar_kt_edit').val();
            
            //PAK
            var pak = $('#pak_edit').val();
            var pak_angsur = $('#angsur_pak_edit').val();
            var pak_angsuran = $('#angsuran_pak_edit').val();
            var pak_tgl_bayar = $('#bayar_pak_edit').val();
            
            //lain-lain
            var lain = $('#lain_edit').val();
            var lain_angsur = $('#angsur_lain_edit').val();
            var lain_angsuran = $('#angsuran_lain_edit').val();
            var lain_tgl_bayar = $('#bayar_lain_edit').val();

            //data pasangan
            var nik_pe = $('#nik_pe').val();
            var nama_pe = $('#nama_pe').val();
            var nohp_pe = $('#no_hp_pe').val();
            var email_pe = $('#email_pe').val();
            var jk_pe = $('#jk_pe').val();
            var pekerjaan_pe = $('#pekerjaan_pe').val();
            var tk_pe = $('#tmp_kerja_pe').val();
            var gaji_pe = $('#gaji_pe').val();


            var piutang_bank = $('#piutang_edit').val();
            var angsur_piutang = $('#angsur_PE').val();
            var cicil_piutang = $('#cicil_PE').val();
            var tempo_piutang = $('#tempo_PE').val();

            var angsur_bank = $('#angsuran_edit').val();
            var angsur_angsuran = $('#angsur_AE').val();
            var cicil_angsuran = $('#cicil_AE').val();
            var tempo_angsuran = $('#tempo_AE').val();

            $.ajax({
                url: '<?= site_url('marketing/edit_transaksi_bank'); ?>',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    piutang_bank: piutang_bank,
                    angsur_piutang: angsur_piutang,
                    cicil_piutang: cicil_piutang,
                    tempo_piutang: tempo_piutang,

                    angsur_bank: angsur_bank,
                    agsur_angsuran: angsur_angsuran,
                    cicil_angsuran: cicil_angsuran,
                    tempo_angsuran: tempo_angsuran,

                    //data pasangan
                    nik_pe : nik_pe,
                    nama_pe : nama_pe,
                    nohp_pe : nohp_pe,
                    email_pe : email_pe,
                    jk_pe : jk_pe,
                    pekerjaan_pe : pekerjaan_pe,
                    tk_pe : tk_pe,
                    gaji_pe : gaji_pe,

                    //data konsumen
                    id_konsumen:id_konsumen,
                    nik:nik,
                    nama:nama,
                    jk:jk,
                    no_hp:no_hp,
                    pekerjaan:pekerjaan,
                    alamat:alamat,
                    email:email,
                    status_menikah:status_menikah,
                    tempat_kerja:tempat_kerja,
                    gaji:gaji,
                    info:info,

                    //data bank
                    harga_kesepakatan:harga_kesepakatan,
                    tanda_jadi:tanda_jadi,
                    tgl_tanda_jadi:tgl_tanda_jadi,

                    //tanda jadi lokasi
                    tjl:tjl,
                    tjl_angsur:tjl_angsur,
                    tjl_angsuran:tjl_angsuran,
                    tjl_tgl_bayar:tjl_tgl_bayar,

                    //uang muka
                    um:um,
                    um_angsur:um_angsur,
                    um_angsuran:um_angsuran,
                    um_tgl_bayar:um_tgl_bayar,

                    //Kelebihan tanah
                    kt:kt,
                    kt_angsur:kt_angsur,
                    kt_angsuran:kt_angsuran,
                    kt_tgl_bayar:kt_tgl_bayar,

                    //PAK 
                    pak:pak,
                    pak_angsur:pak_angsur,
                    pak_angsuran:pak_angsuran,
                    pak_tgl_bayar:pak_tgl_bayar,
                    
                    //lain-lain 
                    lain:lain,
                    lain_angsur:lain_angsur,
                    lain_angsuran:lain_angsuran,
                    lain_tgl_bayar:lain_tgl_bayar,

                },
                success: function(result){
                    console.log(result);
                    if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data konsumen berhasil di edit',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#modal-edit').modal('hide')
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            )
                    } else {


                        if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'NIK wajib di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');
                        }
                        else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nama harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jenis Kelamin harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 4){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No hp harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 5){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Pekerjaan harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 6){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Alamat harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 7){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Email harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 8){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Status menikah harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 9){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tempat kerja harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 10){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gaji harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 11){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Info harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 12){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Harga kesepakatan harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 13){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanda jadi harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 14){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal tanda jadi harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 15){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Tanda Jadi Lokasi harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 16){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran Tanda Jadi Lokasi harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 17){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Uang Muka harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 18){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran Uang Muka harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 19){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Kelebihan Tanah harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 20){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran Kelebihan Tanah harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 21){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran PAK harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 22){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran PAK harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 23){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Lain-lain harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 24){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran Lain-lain harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        } 
                        else if(result.status == 25){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Kesalahan update data konsumen, harap coba kembali',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 30){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'NIK Pasangan harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 31){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nama Pasangan harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 32){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No Telp Pasangan harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 33){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Email Pasangan harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 34){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jenis Kelamin Pasangan harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 35){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Pekerjaan Pasangan harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 36){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tempat Kerja Pasangan harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 37){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gaji Pasangan harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 91){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Piutang Bank harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 92){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tempo Piutang Bank harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 93){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Bank harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else if(result.status == 94){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tempo Angsuran Bank harap diisi...',
                                });
                                $('#add-transaksi-bank').removeClass('disabled');

                        }
                        else {
                            Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Update Gagal',
                                });
                                $('.btn-save-edit').removeClass('disabled');
                        }


                    }

                }
            });

        });


    </script>
<?php }elseif($url_cek == 'marketing/transaksi_inhouse/'){ ?>
    <script>
        $('#transaksi_bank').dataTable();
        $('#list-inhouse').dataTable();

        $('#status_menikah').on('change', function(){
            var status = $(this).val();
            if(status == ''){
                $('.formPasangan').addClass('d-none');
            } else if(status == 'Belum'){
                $('.formPasangan').addClass('d-none');
            } else if(status == 'Sudah'){
                $('.formPasangan').removeClass('d-none');
            }
        });

        $('#status_menikah_edit').on('change', function(){
            var status = $(this).val();
            if(status == ''){
                $('.formPasanganEdit').addClass('d-none');
            } else if(status == 'Belum'){
                $('.formPasanganEdit').addClass('d-none');
            } else if(status == 'Sudah'){
                $('.formPasanganEdit').removeClass('d-none');
            }
        });

        $('#cluster').on('change', function(){
            var id = $(this).val();

            $.ajax({
                url: '<?= site_url('marketing/get_kavling_by_cluster'); ?>',
                dataType: 'JSON',
                data: {cluster:id},
                type: 'POST',
                success: function(data){
                        var html = '<option>--Pilih--</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value='+data[i].id_kavling+'>'+data[i].blok + data[i].no_rumah+'</option>';
                        }
                        $('#id_rumah').html(html);
                }
            });

        });

        $(document).on('click', '.modal-inhouse',function(){
            var id_konsumen = $('.modal-inhouse').data('id');
            $('#id_konsumen').val(id_konsumen);
            $.ajax({
                url: '<?= site_url('marketing/get_rumah'); ?>',
                method: 'POST',
                data: {id_konsumen:id_konsumen},
                dataType: 'JSON',
                success: function(d){
                    $('#id_rumah').val(d.id_kavling);
                    $('#blok').val(d.blok);
                    $('#tipe').val(d.tipe);
                    $('#luas').val(d.luas);
                    $('#harga').val(d.harga);
                }
            });
        });

        $('#v_hk').on('keyup', function(){
            var hk = $('#hk').val();
            var angsur = $('#angsur_hk').val();
            var cicilan_angsur = hk / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(hk == ''){
                $('#cicil_angsur_hk').val('');
                $('#v_cicil_angsur_hk').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_hk').val('');
                $('#v_cicil_angsur_hk').val('');
            } else {
                $('#cicil_angsur_hk').val(real);
                $('#v_cicil_angsur_hk').val(real);
            }
        });
        $('#angsur_hk').on('keyup', function(){
            var hk = $('#hk').val();
            var angsur = $('#angsur_hk').val();
            var cicilan_angsur = hk / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(hk == ''){
                $('#cicil_angsur_hk').val('');
                $('#v_cicil_angsur_hk').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_hk').val('');
                $('#v_cicil_angsur_hk').val('');
            } else {
                $('#cicil_angsur_hk').val(real);
                $('#v_cicil_angsur_hk').val(real);
            }
        });

        $('#v_tjl').on('keyup', function(){
            var tjl = $('#tjl').val();
            var angsur = $('#angsur_tjl').val();
            var cicilan_angsur = tjl / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(tjl == ''){
                $('#cicil_angsur_tjl').val('');
                $('#v_cicil_angsur_tjl').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_tjl').val('');
                $('#v_cicil_angsur_tjl').val('');
            } else {
                $('#cicil_angsur_tjl').val(real);
                $('#v_cicil_angsur_tjl').val(real);
            }
        });
        $('#angsur_tjl').on('keyup', function(){
            var tjl = $('#tjl').val();
            var angsur = $('#angsur_tjl').val();
            var cicilan_angsur = tjl / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(tjl == ''){
                $('#cicil_angsur_tjl').val('');
                $('#v_cicil_angsur_tjl').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_tjl').val('');
                $('#v_cicil_angsur_tjl').val('');
            } else {
                $('#cicil_angsur_tjl').val(real);
                $('#v_cicil_angsur_tjl').val(real);
            }
        });

        $('#v_um').on('keyup', function(){
            var um = $('#um').val();
            var angsur = $('#angsur_um').val();
            var cicilan_angsur = um / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(um == ''){
                $('#cicil_angsur_um').val('');
                $('#v_cicil_angsur_um').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_um').val('');
                $('#v_cicil_angsur_um').val('');
            } else {
                $('#cicil_angsur_um').val(real);
                $('#v_cicil_angsur_um').val(real);
            }
        });
        $('#angsur_um').on('keyup', function(){
            var um = $('#um').val();
            var angsur = $('#angsur_um').val();
            var cicilan_angsur = um / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(um == ''){
                $('#cicil_angsur_um').val('');
                $('#v_cicil_angsur_um').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_um').val('');
                $('#v_cicil_angsur_um').val('');
            } else {
                $('#cicil_angsur_um').val(real);
                $('#v_cicil_angsur_um').val(real);
            }
        });

        $('#v_kt').on('keyup', function(){
            var kt = $('#kt').val();
            var angsur = $('#angsur_kt').val();
            var cicilan_angsur = kt / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(kt == ''){
                $('#cicil_angsur_kt').val('');
                $('#v_cicil_angsur_kt').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_kt').val('');
                $('#v_cicil_angsur_kt').val('');
            } else {
                $('#cicil_angsur_kt').val(real);
                $('#v_cicil_angsur_kt').val(real);
            }
        });
        $('#angsur_kt').on('keyup', function(){
            var kt = $('#kt').val();
            var angsur = $('#angsur_kt').val();
            var cicilan_angsur = kt / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(kt == ''){
                $('#cicil_angsur_kt').val('');
                $('#v_cicil_angsur_kt').val('');
            } else if(angsur == ''){
                $('#cicil_angsur_kt').val('');
                $('#v_cicil_angsur_kt').val('');
            } else {
                $('#v_cicil_angsur_kt').val(real);
                $('#cicil_angsur_kt').val(real);
            }
        });

        $('#id_rumah').on('change', function(){
            var id_blok = $(this).val();
            if(id_blok == ''){
                        $('#tipe').val('');
                        $('#lt').val('');
                        $('#lb').val('');
                        $('#harga').val('');
        } else {
                $.ajax({
                    url: '<?= site_url('marketing/get_blok_id'); ?>',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {id:id_blok},
                    success: function(d){
                        $('#tipe').val(d.tipe);
                        $('#lt').val(d.lt);
                        $('#lb').val(d.lb);
                        $('#harga').val(d.harga);
                        $('#harga_A').val(d.harga);
                    }
                });
            }
        });

        $('#save-transaksi-inhouse').on('click', function(){
            $('#save-transaksi-inhouse').addClass('disabled');
            var id_konsumen = $('#id_konsumen').val();
            var id_rumah = $('#id_rumah').val();
            var tanda_jadi = $('#tanda_jadi').val();
            var tanggal_tanda_jadi = $('#tanggal_tanda_jadi').val();

            var harga_kesepakatan = $('#hk').val();
            var angsur_hk = $('#angsur_hk').val();
            var cicil_angsur_hk = $('#cicil_angsur_hk').val();
            var tgl_bayar_hk = $('#tgl_bayar_hk').val();

            var tjl = $('#tjl').val();
            var angsur_tjl = $('#angsur_tjl').val();
            var cicil_angsur_tjl = $('#cicil_angsur_tjl').val();
            var tgl_bayar_tjl = $('#tgl_bayar_tjl').val();

            var um = $('#um').val();
            var angsur_um = $('#angsur_um').val();
            var cicil_angsur_um = $('#cicil_angsur_um').val();
            var tgl_bayar_um = $('#tgl_bayar_um').val();

            var kt = $('#kt').val();
            var angsur_kt = $('#angsur_kt').val();
            var cicil_angsur_kt = $('#cicil_angsur_kt').val();
            var tgl_bayar_kt = $('#tgl_bayar_kt').val();

            var nik = $('#nik').val();
            var tempat_kerja = $('#tempat_kerja').val();
            var gaji = $('#gaji').val();
            var email = $('#email').val();
            var alamat = $('#alamat').val();
            var status_menikah = $('#status_menikah').val();

            var nik_p = $('#nik_p').val();
            var nama_p = $('#nama_p').val();
            var nohp_p = $('#no_hp_p').val();
            var email_p = $('#email_p').val();
            var jk_p = $('#jk_p').val();
            var pekerjaan_p = $('#pekerjaan_p').val();
            var tk_p = $('#tmp_kerja_p').val();
            var gaji_p = $('#gaji_p').val();


            $.ajax({
                url: '<?= site_url('marketing/add_transaksi_inhouse'); ?>',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    nik_p : nik_p,
                    nama_p : nama_p,
                    nohp_p : nohp_p,
                    email_p : email_p,
                    jk_p : jk_p,
                    pekerjaan_p : pekerjaan_p,
                    tk_p : tk_p,
                    gaji_p : gaji_p,

                    nik:nik,
                    tempat_kerja:tempat_kerja,
                    gaji:gaji,
                    email:email,
                    alamat:alamat,
                    status_menikah:status_menikah,

                    id_rumah:id_rumah,
                    tanda_jadi:tanda_jadi,
                    tanggal_tanda_jadi:tanggal_tanda_jadi,
                    id_konsumen:id_konsumen,

                    harga_kesepakatan:harga_kesepakatan,
                    angsur_hk:angsur_hk,
                    cicil_angsur_hk:cicil_angsur_hk,
                    tgl_bayar_hk:tgl_bayar_hk,

                    tjl:tjl,
                    angsur_tjl:angsur_tjl,
                    cicil_angsur_tjl:cicil_angsur_tjl,
                    tgl_bayar_tjl:tgl_bayar_tjl,

                    um:um,
                    angsur_um:angsur_um,
                    cicil_angsur_um:cicil_angsur_um,
                    tgl_bayar_um:tgl_bayar_um,

                    kt:kt,
                    angsur_kt:angsur_kt,
                    cicil_angsur_kt:cicil_angsur_kt,
                    tgl_bayar_kt:tgl_bayar_kt
                },
                success: function(result){
                    if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Transaksi Inhouse Berhasil',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            )
                    } else {
                    if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanda Jadi wajib di isi...',
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');
                            }
                            else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Tanda Jadi wajib diisi',
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal bayar harga kesepakatan harap diisi',
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 4){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan angsuran harga kesepakatan harap diisi',
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 5){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal bayar tanda jadi lokasi harap diisi',
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 6){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan angsuran tanda jadi lokasi harap diisi',
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 7){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal bayar uang muka harap diisi',
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 8){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan angsuran uang muka harap diisi',
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 9){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal bayar kelebihan tanah harap diisi',
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 10){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan angsuran kelebihan tanah harap diisi',
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 11){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal memasukkan data'
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 100){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'NIK Harap di isi'
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 101){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Alamat Harap di isi'
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 102){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Status Menikah Harap di isi'
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 103){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Harap pilih blok'
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 104){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tempat Kerja harap di isi'
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 105){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gaji harap di isi'
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 106){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Email harap di isi'
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 107){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'NIK sudah terdaftar'
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 108){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Email sudah terdaftar'
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 30){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'NIK Pasangan harap di isi',
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 31){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Nama Pasangan harap di isi',
                                    });
                                    $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 32){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'No Telp Pasangan harap di isi',
                                    });
                                    $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 33){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Email Pasangan harap di isi',
                                    });
                                    $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 34){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Jenis Kelamin Pasangan harap di isi',
                                    });
                                    $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 35){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Pekerjaan Pasangan harap di isi',
                                    });
                                    $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 36){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Tempat Kerja Pasangan harap di isi',
                                    });
                                    $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 37){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Gaji Pasangan harap di isi',
                                    });
                                    $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 38){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'NIK Pasangan sudah terdaftar',
                                    });
                                    $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 39){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Email Pasangan sudah terdaftar',
                                    });
                                    $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else if(result.status == 40){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'No Telp Pasangan sudah terdaftar',
                                    });
                                    $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Transaksi Inhouse gagal diproses',
                                });
                                $('#save-transaksi-inhouse').removeClass('disabled');

                            }
                    }
                }
            });
        });


        $(document).on('click','.viewdetailinhouse', function(){
            var id_konsumen = $(this).data('konsumen');
            $.ajax({
                url: '<?= site_url('marketing/view_detail_inhouse'); ?>',
                method: 'post',
                data:{id_konsumen:id_konsumen},
                success: function(d){
                    $('#detailTransaksiInhouse').html(d);
                }
            });
        });

        $(document).on('click', '.btn-edit-konsumen', function(){
            var id = $(this).data('konsumen');


            $('#nik_edit').val('');
            $('#nama_edit').val('');
            $('#jk_edit').val('');
            $('#no_hp_edit').val('');
            $('#pekerjaan_edit').val('');
            $('#alamat_edit').val('');
            $('#email_edit').val('');
            $('#status_menikah_edit').val('');
            $('#tempat_kerja_edit').val('');
            $('#v_gaji_edit').val('');
            $('#gaji_edit').val('');
            $('#info_edit').val('');

            $('#nik_pe').val('');
            $('#nama_pe').val('');
            $('#no_hp_pe').val('');
            $('#email_pe').val('');
            $('#jk_pe').val('');
            $('#pekerjaan_pe').val('');
            $('#tmp_kerja_pe').val('');
            $('#v_gaji_pe').val('');
            $('#gaji_pe').val('');
            
            $('#cluster_edit').val('');
            $('#blok_edit').val('');
            $('#type_edit').val('');
            $('#lt_edit').val('');
            $('#lb_edit').val('');
            $('#v_harga_edit').val('');
            $('#harga_edit').val('');
            
            $('#v_tj_edit').val('');
            $('#tj_edit').val('');
            $('#tgl_tj_edit').val('');
            
            $('#v_tjl_edit').val('');
            $('#tjl_edit').val('');
            $('#angsur_tjl_edit').val('');
            $('#v_angsuran_tjl_edit').val('');
            $('#angsuran_tjl_edit').val('');
            $('#bayar_tjl_edit').val('');

            $('#v_um_edit').val('');
            $('#um_edit').val('');
            $('#angsur_um_edit').val('');
            $('#v_angsuran_um_edit').val('');
            $('#angsuran_um_edit').val('');
            $('#bayar_um_edit').val('');

            $('#v_kt_edit').val('');
            $('#kt_edit').val('');
            $('#angsur_kt_edit').val('');
            $('#v_angsuran_kt_edit').val('');
            $('#angsuran_kt_edit').val('');
            $('#bayar_kt_edit').val('');

            $('#v_hk_edit').val('');
            $('#hk_edit').val('');
            $('#angsur_hk_edit').val('');
            $('#v_angsuran_hk_edit').val('');
            $('#angsuran_hk_edit').val('');
            $('#bayar_hk_edit').val('');


            $.ajax({
                url: '<?= site_url('marketing/get_status_menikah'); ?>',
                data: {id:id},
                dataType: 'JSON',
                type: 'POST',
                success: function(d){
                    if(d > 0){
                        $('.formPasanganEdit').removeClass('d-none');
                    } else {
                        $('.formPasanganEdit').addClass('d-none');
                    }
                }
            });
    
                        $.ajax({
                            url: '<?= site_url('marketing/get_pasangan'); ?>',
                            dataType: 'JSON',
                            data: {id:id},
                            type: 'POST',
                            success: function(d){
                                $('#nik_pe').val(d.nik);
                                $('#nama_pe').val(d.nama);
                                $('#no_hp_pe').val(d.no_hp);
                                $('#email_pe').val(d.email);
                                $('#jk_pe').val(d.jk);
                                $('#pekerjaan_pe').val(d.pekerjaan);
                                $('#tmp_kerja_pe').val(d.tempat_kerja);
                                $('#gaji_pe').val(d.gaji);
                                $('#v_gaji_pe').val(d.gaji);
                            }
                        });

            $.ajax({
                url: '<?= site_url('marketing/get_inhouse_join_all'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(d){
                    // console.log(d);
                    $('#id_konsumen_edit').val(d.id_marketing);
                    $('#nik_edit').val(d.nik);
                    $('#nama_edit').val(d.nama_konsumen);
                    $('#jk_edit').val(d.jk);
                    $('#no_hp_edit').val(d.no_hp);
                    $('#pekerjaan_edit').val(d.pekerjaan);
                    $('#alamat_edit').val(d.alamat);
                    $('#email_edit').val(d.email);
                    $('#status_menikah_edit').val(d.status_menikah);
                    $('#tempat_kerja_edit').val(d.tempat_kerja);
                    $('#gaji_edit').val(d.gaji);
                    $('#v_gaji_edit').val(d.gaji);
                    $('#info_edit').val(d.dapat_info);
                    
                    $('#blok_edit').val(d.blok + d.no_rumah);
                    $('#cluster_edit').val(d.nama_cluster);
                    $('#type_edit').val(d.tipe);
                    $('#lt_edit').val(d.lt);
                    $('#lb_edit').val(d.lb);
                    $('#harga_edit').val(d.harga);
                    $('#v_harga_edit').val(d.harga);
                    
                    $('#hk_edit').val(d.harga_kesepakatan);
                    $('#tj_edit').val(d.tanda_jadi);
                    $('#v_tj_edit').val(d.tanda_jadi);
                    $('#tgl_tj_edit').val(d.tgl_tanda_jadi);

                }
            });


            $.ajax({
                url: '<?= site_url('marketing/get_tjl_inhouse'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(tjl){
                    $('#tjl_edit').val(tjl.jml_tjl);
                    $('#v_tjl_edit').val(tjl.jml_tjl);
                    $('#angsur_tjl_edit').val(tjl.angsuran);
                    $('#angsuran_tjl_edit').val(tjl.cicilan_angsuran);
                    $('#v_angsuran_tjl_edit').val(tjl.cicilan_angsuran);
                    $('#bayar_tjl_edit').val(tjl.tgl_bayar);
                }
            });

            $.ajax({
                url: '<?= site_url('marketing/get_um_inhouse'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(um){
                    $('#um_edit').val(um.jml_um);
                    $('#v_um_edit').val(um.jml_um);
                    $('#angsur_um_edit').val(um.angsuran);
                    $('#angsuran_um_edit').val(um.cicilan_angsuran);
                    $('#v_angsuran_um_edit').val(um.cicilan_angsuran);
                    $('#bayar_um_edit').val(um.tgl_bayar);
                }
            });

            $.ajax({
                url: '<?= site_url('marketing/get_kt_inhouse'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(kt){
                    $('#kt_edit').val(kt.jml_kt);
                    $('#v_kt_edit').val(kt.jml_kt);
                    $('#angsur_kt_edit').val(kt.angsuran);
                    $('#angsuran_kt_edit').val(kt.cicilan_angsuran);
                    $('#v_angsuran_kt_edit').val(kt.cicilan_angsuran);
                    $('#bayar_kt_edit').val(kt.tgl_bayar);
                }
            });

            $.ajax({
                url: '<?= site_url('marketing/get_hk_inhouse'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {id:id},
                success: function(hk){
                    $('#hk_edit').val(hk.jml_kesepakatan);
                    $('#v_hk_edit').val(hk.jml_kesepakatan);
                    $('#angsur_hk_edit').val(hk.angsuran);
                    $('#angsuran_hk_edit').val(hk.cicilan_angsuran);
                    $('#v_angsuran_hk_edit').val(hk.cicilan_angsuran);
                    $('#bayar_hk_edit').val(hk.tgl_bayar);
                }
            });


        });

        $('#v_tjl_edit').on('keyup', function(){
            var tjl_edit = $('#tjl_edit').val();
            var angsur = $('#angsur_tjl_edit').val();
            var cicilan_angsur = tjl_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(tjl_edit == ''){
                $('#angsuran_tjl_edit').val('');
                $('#v_angsuran_tjl_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_tjl_edit').val('');
                $('#v_angsuran_tjl_edit').val('');
            } else {
                $('#angsuran_tjl_edit').val(real);
                $('#v_angsuran_tjl_edit').val(real);
            }
        });
        $('#angsur_tjl_edit').on('keyup', function(){
            var tjl_edit = $('#tjl_edit').val();
            var angsur = $('#angsur_tjl_edit').val();
            var cicilan_angsur = tjl_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(tjl_edit == ''){
                $('#angsuran_tjl_edit').val('');
                $('#v_angsuran_tjl_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_tjl_edit').val('');
                $('#v_angsuran_tjl_edit').val('');
            } else {
                $('#angsuran_tjl_edit').val(real);
                $('#v_angsuran_tjl_edit').val(real);
            }
        });

        $('#v_um_edit').on('keyup', function(){
            var um_edit = $('#um_edit').val();
            var angsur = $('#angsur_um_edit').val();
            var cicilan_angsur = um_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(um_edit == ''){
                $('#angsuran_um_edit').val('');
                $('#v_angsuran_um_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_um_edit').val('');
                $('#v_angsuran_um_edit').val('');
            } else {
                $('#angsuran_um_edit').val(real);
                $('#v_angsuran_um_edit').val(real);
            }
        });
        $('#angsur_um_edit').on('keyup', function(){
            var um_edit = $('#um_edit').val();
            var angsur = $('#angsur_um_edit').val();
            var cicilan_angsur = um_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(um_edit == ''){
                $('#angsuran_um_edit').val('');
                $('#v_angsuran_um_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_um_edit').val('');
                $('#v_angsuran_um_edit').val('');
            } else {
                $('#angsuran_um_edit').val(real);
                $('#v_angsuran_um_edit').val(real);
            }
        });



        $('#v_kt_edit').on('keyup', function(){
            var kt_edit = $('#kt_edit').val();
            var angsur = $('#angsur_kt_edit').val();
            var cicilan_angsur = kt_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(kt_edit == ''){
                $('#angsuran_kt_edit').val('');
                $('#v_angsuran_kt_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_kt_edit').val('');
                $('#v_angsuran_kt_edit').val('');
            } else {
                $('#angsuran_kt_edit').val(real);
                $('#v_angsuran_kt_edit').val(real);
            }
        });
        $('#angsur_kt_edit').on('keyup', function(){
            var kt_edit = $('#kt_edit').val();
            var angsur = $('#angsur_kt_edit').val();
            var cicilan_angsur = kt_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(kt_edit == ''){
                $('#angsuran_kt_edit').val('');
                $('#v_angsuran_kt_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_kt_edit').val('');
                $('#v_angsuran_kt_edit').val('');
            } else {
                $('#angsuran_kt_edit').val(real);
                $('#v_angsuran_kt_edit').val(real);
            }
        });



        $('#v_hk_edit').on('keyup', function(){
            var hk_edit = $('#hk_edit').val();
            var angsur = $('#angsur_hk_edit').val();
            var cicilan_angsur = hk_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(hk_edit == ''){
                $('#angsuran_hk_edit').val('');
                $('#v_angsuran_hk_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_hk_edit').val('');
                $('#v_angsuran_hk_edit').val('');
            } else {
                $('#angsuran_hk_edit').val(real);
                $('#v_angsuran_hk_edit').val(real);
            }
        });
        $('#angsur_hk_edit').on('keyup', function(){
            var hk_edit = $('#hk_edit').val();
            var angsur = $('#angsur_hk_edit').val();
            var cicilan_angsur = hk_edit / angsur;

            if(Number.isInteger(cicilan_angsur)){
                var real = cicilan_angsur;
            } else {
                var real = Math.round(cicilan_angsur);
            }

            if(hk_edit == ''){
                $('#angsuran_hk_edit').val('');
                $('#v_angsuran_hk_edit').val('');
            } else if(angsur == ''){
                $('#angsuran_hk_edit').val('');
                $('#v_angsuran_hk_edit').val('');
            } else {
                $('#angsuran_hk_edit').val(real);
                $('#v_angsuran_hk_edit').val(real);
            }
        });


        $('.btn-save-edit').on('click', function(){

            //Data Konsumen
            var id_konsumen = $('#id_konsumen_edit').val();
            var nik = $('#nik_edit').val();
            var nama = $('#nama_edit').val();
            var jk = $('#jk_edit').val();
            var no_hp = $('#no_hp_edit').val();
            var pekerjaan = $('#pekerjaan_edit').val();
            var alamat = $('#alamat_edit').val();
            var email = $('#email_edit').val();
            var status_menikah = $('#status_menikah_edit').val();
            var tempat_kerja = $('#tempat_kerja_edit').val();
            var gaji = $('#gaji_edit').val();
            var info = $('#info_edit').val();

            //data inhouse
            var tanda_jadi = $('#tj_edit').val();
            var tgl_tanda_jadi = $('#tgl_tj_edit').val();

            //tanda jadi lokasi
            var tjl = $('#tjl_edit').val();
            var tjl_angsur = $('#angsur_tjl_edit').val();
            var tjl_angsuran = $('#angsuran_tjl_edit').val();
            var tjl_tgl_bayar = $('#bayar_tjl_edit').val();
            
            //uang muka
            var um = $('#um_edit').val();
            var um_angsur = $('#angsur_um_edit').val();
            var um_angsuran = $('#angsuran_um_edit').val();
            var um_tgl_bayar = $('#bayar_um_edit').val();
            
            //kelebihan tanah
            var kt = $('#kt_edit').val();
            var kt_angsur = $('#angsur_kt_edit').val();
            var kt_angsuran = $('#angsuran_kt_edit').val();
            var kt_tgl_bayar = $('#bayar_kt_edit').val();

            //harga kesepakatan
            var hk = $('#hk_edit').val();
            var hk_angsur = $('#angsur_hk_edit').val();
            var hk_angsuran = $('#angsuran_hk_edit').val();
            var hk_tgl_bayar = $('#bayar_hk_edit').val();

            //data pasangan
            var nik_p = $('#nik_pe').val();
            var nama_p = $('#nama_pe').val();
            var nohp_p = $('#no_hp_pe').val();
            var email_p = $('#email_pe').val();
            var jk_p = $('#jk_pe').val();
            var pekerjaan_p = $('#pekerjaan_pe').val();
            var tk_p = $('#tmp_kerja_pe').val();
            var gaji_p = $('#gaji_pe').val();


            $.ajax({
                url: '<?= site_url('marketing/edit_inhouse'); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {
                    //data pasangan
                    nik_p : nik_p,
                    nama_p : nama_p,
                    nohp_p : nohp_p,
                    email_p : email_p,
                    jk_p : jk_p,
                    pekerjaan_p : pekerjaan_p,
                    tk_p : tk_p,
                    gaji_p : gaji_p,

                    //data konsumen
                    id_konsumen:id_konsumen,
                    nik:nik,
                    nama:nama,
                    jk:jk,
                    no_hp:no_hp,
                    pekerjaan:pekerjaan,
                    alamat:alamat,
                    email:email,
                    status_menikah:status_menikah,
                    tempat_kerja:tempat_kerja,
                    gaji:gaji,
                    info:info,

                    //data inhouse
                    tanda_jadi:tanda_jadi,
                    tgl_tanda_jadi:tgl_tanda_jadi,

                    //tanda jadi lokasi
                    tjl:tjl,
                    tjl_angsur:tjl_angsur,
                    tjl_angsuran:tjl_angsuran,
                    tjl_tgl_bayar:tjl_tgl_bayar,

                    //uang muka
                    um:um,
                    um_angsur:um_angsur,
                    um_angsuran:um_angsuran,
                    um_tgl_bayar:um_tgl_bayar,

                    //Kelebihan tanah
                    kt:kt,
                    kt_angsur:kt_angsur,
                    kt_angsuran:kt_angsuran,
                    kt_tgl_bayar:kt_tgl_bayar,

                    //Harga kesepakatan
                    hk:hk,
                    hk_angsur:hk_angsur,
                    hk_angsuran:hk_angsuran,
                    hk_tgl_bayar:hk_tgl_bayar,

                },
                success: function(result){


                    if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data konsumen berhasil di edit',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#modal-edit').modal('hide')
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            )
                    } else {

                        if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'NIK wajib di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');
                        }
                        else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nama harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jenis Kelamin harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 4){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No hp harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 5){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Pekerjaan harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 6){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Alamat harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 7){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Email harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 8){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Status menikah harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 9){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tempat kerja harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 10){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gaji harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 11){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Info harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }

                        else if(result.status == 12){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanda jadi harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 13){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal tanda jadi harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 15){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Tanda Jadi Lokasi harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 16){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran Tanda Jadi Lokasi harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 17){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Uang Muka harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 18){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran Uang Muka harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 19){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Kelebihan Tanah harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 20){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran Kelebihan Tanah harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 21){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Cicilan Angsuran Harga Kesepakatan harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 22){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Tanggal Pembayaran Harga Kesepakatan harap diisi...',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                        }
                        else if(result.status == 30){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'NIK Pasangan harap di isi',
                                });
                                $('.btn-save-edit').removeClass('disabled');

                            }
                            else if(result.status == 31){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Nama Pasangan harap di isi',
                                    });
                                    $('.btn-save-edit').removeClass('disabled');

                            }
                            else if(result.status == 32){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'No Telp Pasangan harap di isi',
                                    });
                                    $('.btn-save-edit').removeClass('disabled');

                            }
                            else if(result.status == 33){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Email Pasangan harap di isi',
                                    });
                                    $('.btn-save-edit').removeClass('disabled');

                            }
                            else if(result.status == 34){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Jenis Kelamin Pasangan harap di isi',
                                    });
                                    $('.btn-save-edit').removeClass('disabled');

                            }
                            else if(result.status == 35){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Pekerjaan Pasangan harap di isi',
                                    });
                                    $('.btn-save-edit').removeClass('disabled');

                            }
                            else if(result.status == 36){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Tempat Kerja Pasangan harap di isi',
                                    });
                                    $('.btn-save-edit').removeClass('disabled');

                            }
                            else if(result.status == 37){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Gaji Pasangan harap di isi',
                                    });
                                    $('.btn-save-edit').removeClass('disabled');

                            }
                         else {
                            Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Update Gagal',
                                });
                                $('.btn-save-edit').removeClass('disabled');
                        }

                    }


                }
            });

        });

    </script>

<?php }elseif($url_cek == 'marketing/konsumen/'){ ?>

    <script>

    $('#table-konsumen').dataTable();

        $(document).on('click', '.btn-batal-transaksi-bank', function(){
        var id_konsumen = $(this).data('id');
        
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "membatalkan transaksi ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((d) => {
                if (d.value) {
                    $.ajax({
                        url: '<?= site_url('marketing/batal_transaksi_bank'); ?>',
                        method: 'POST',
                        dataType: 'JSON',
                        data: {id:id_konsumen},
                        success: function(result){
                            // console.log(result);
                            if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Pembatalan Transaksi Berhasil',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        setTimeout(() => {
                                            location.reload();
                                        }, 500);
                                    }
                                )
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Pembatalan Transaksi Gagal',
                                });
                            }

                        }
                    });
                }
            })

        });

        $(document).on('click','.btn-batal-transaksi-inhouse', function(){
        var id_konsumen = $(this).data('id');
        
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "membatalkan transaksi ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((d) => {
                if (d.value) {
                    $.ajax({
                        url: '<?= site_url('marketing/batal_transaksi_inhouse'); ?>',
                        method: 'POST',
                        dataType: 'JSON',
                        data: {id:id_konsumen},
                        success: function(result){
                            // console.log(result);
                            if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Pembatalan Transaksi Berhasil',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        setTimeout(() => {
                                            location.reload();
                                        }, 500);
                                    }
                                )
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Pembatalan Transaksi Gagal',
                                });
                            }

                        }
                    });
                }
            })
        });

        $(document).on('click','.ajukan-feemarketing', function(){
            var id  = $(this).data('id');
            $('#id_konsumen').val(id);
        });

        $(document).on('click', '.detail-fee-marketing', function(){
            var id_konsumen = $(this).data('id');
            
            $.ajax({
                url: '<?= site_url('marketing/detail_fee_marketing'); ?>',
                data: {id:id_konsumen},
                method: 'POST',
                success: function(d){
                    $('#detail-fee-marketing').html(d);
                }
            });

        });

        $(document).on('click', '.acc-fee-marketing', function(){
            var id = $(this).data('id');
            
            $.ajax({
                url: '<?= site_url('marketing/acc_fee_marketing'); ?>',
                data: {id:id},
                dataType: 'JSON',
                method: 'POST',
                success: function(result){

                            if(result.success == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Konfirmasi Berhasil',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(
                                    function() {
                                        setTimeout(() => {
                                            location.reload();
                                        }, 500);
                                    }
                                )
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Konfirmasi Gagal',
                                });
                            }
                }
            });

        });


        $(document).on('click', '.add-bukti-spr', function(){
            var id = $(this).data('id');
            $('#id_konsumen_spr').val(id);
        });

        $(document).on('click', '.bukti-spr', function(){
            var id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('marketing/get_bukti_spr'); ?>',
                datatype: 'JSON',
                type: 'POST',
                data: {id:id},
                success: function(d){
                    $('.bukti-spr-show').html(d);
                }
            });
        });


        $(document).on('click', '.add-sertifikat', function(){
            const id = $(this).data('id');
            $('#id_konsumen_sertifikat').val(id);
            $('#addSertifikat').modal('show');
        });

        $(document).on('click','.view-sertifikat', function(){
            const id = $(this).data('id');
            $('#viewSertifikat').modal('show');
            
            $.ajax({
                url: '<?= site_url('marketing/show_sertifikat') ?>',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    $('.showSertifikat').html(d);
                }
            });
        });

    </script>
<?php }elseif($url_cek == 'marketing/transaksi_batal/'){ ?>
    <script>
        $(document).on('click', '.detail-pembatalan',function(){
            var id = $(this).data('id');

            $.ajax({
                url: '<?= site_url('marketing/view_all_transaksi_konsumen'); ?>',
                data: {id:id},
                method: 'POST',
                success: function(d){
                    $('#detail-pembatalan').html(d);
                }
            });
            
        });

        $('#table-batal-transaksi').dataTable();

        $(document).on('click', '.add-bukti-spkb',function(){
            var id = $(this).data('id');
            $('#id_konsumen_spkb').val(id);
        });

        $(document).on('click', '.bukti-spkb', function(){
            var id  = $(this).data('id');
            $.ajax({
                url: '<?= site_url('marketing/get_bukti_spkb'); ?>',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    $('.bukti-spkb-show').html(d);
                }
            });
        });

        var scs = $('.true').data('pesan');
        if(scs){
            Swal.fire(
                'Berhasil',
                scs,
                'success'
            );
        }
        var err = $('.false').data('pesan');
        if(err){
            Swal.fire(
                'Gagal',
                err,
                'error'
            )
        }

        $(document).on('click','.to-accounting', function(){
            $('#btnSubmit').html('Go');
            $('#theFormPengembalian').attr('action','<?= site_url('marketing/pembatalan_to_accounting'); ?>');
            $('#theFormPengembalian').removeAttr('target');


            var id = $(this).data('id');
            $('#id_cetak_spkb').val(id);

            var status_tf = $(this).data('tf');
            if(status_tf == 1){
                $('.tf-bank').removeClass('d-none');
                $('.tf-inhouse').addClass('d-none');
            } else if(status_tf == 2){
                $('.tf-inhouse').removeClass('d-none');
                $('.tf-bank').addClass('d-none');
            }

            $.ajax({
                url: '<?= site_url('marketing/cek_pembayaran_spkb'); ?>',
                dataType: 'JSON',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    // console.log(d);
                   if(d.type == 'bank'){
                        $('#tjl_b').removeClass('d-none');
                        $('#tj_b').removeClass('d-none');
                        $('#um_b').removeClass('d-none');
                        $('#kt_b').removeClass('d-none');
                        $('#pak_b').removeClass('d-none');
                        $('#lain_b').removeClass('d-none');
                        $('#angsur_b').removeClass('d-none');
                        $('#piutang_b').removeClass('d-none');

                        if(d.tjl == 0){
                            $('#tjl_b').addClass('d-none');
                            $('#ck_tjl_b').val("0");
                        }
                        if(d.tj == 0){
                            $('#tj_b').addClass('d-none');
                            $('#ck_tj_b').val("0");
                        }
                        if(d.um == 0){
                            $('#um_b').addClass('d-none');
                            $('#ck_um_b').val("0");
                        }
                        if(d.kt == 0){
                            $('#kt_b').addClass('d-none');
                            $('#ck_kt_b').val("0");
                        }
                        if(d.pak == 0){
                            $('#pak_b').addClass('d-none');
                            $('#ck_pak_b').val("0");
                        }
                        if(d.lain == 0){
                            $('#lain_b').addClass('d-none');
                            $('#ck_lain_b').val("0");
                        }
                        if(d.angsur == 0){
                            $('#angsur_b').addClass('d-none');
                            $('#ck_angsur_b').val("0");
                        }
                        if(d.piutang == 0){
                            $('#piutang_b').addClass('d-none');
                            $('#ck_piutang_b').val("0");
                        }

                   } else if(d.type == 'inhouse'){
                        $('#hk_i').removeClass('d-none');
                        $('#um_i').removeClass('d-none');
                        $('#kt_i').removeClass('d-none');
                        $('#tjl_i').removeClass('d-none');
                        $('#tj_i').removeClass('d-none');

                        if(d.hk == 0){
                            $('#hk_i').addClass('d-none');
                            $('#ck_hk_i').val("0");
                        }
                        if(d.kt == 0){
                            $('#kt_i').addClass('d-none');
                            $('#ck_kt_i').val("0");
                        }
                        if(d.tjl == 0){
                            $('#tjl_i').addClass('d-none');
                            $('#ck_tjl_i').val("0");
                        }
                        if(d.um == 0){
                            $('#um_i').addClass('d-none');
                            $('#ck_um_i').val("0");
                        }
                        if(d.tj == 0){
                            $('#tj_i').addClass('d-none');
                            $('#ck_tj_i').val("0");
                        }

                   }
                }
            });


        });

        $(document).on('click', '.cetak-spkb', function(){
            $('#btnSubmit').html('<i class="fa fa-print"></i> Cetak');
            $('#theFormPengembalian').attr('action','<?= site_url('marketing/gen_spkb'); ?>');
            $('#theFormPengembalian').attr('target','_blank');

            var id = $(this).data('id');
            $('#id_cetak_spkb').val(id);

            var status_tf = $(this).data('tf');

            if(status_tf == 1){
                $('.tf-bank').removeClass('d-none');
                $('.tf-inhouse').addClass('d-none');
            } else if(status_tf == 2){
                $('.tf-inhouse').removeClass('d-none');
                $('.tf-bank').addClass('d-none');
            }

            $.ajax({
                url: '<?= site_url('marketing/cek_pembayaran_spkb'); ?>',
                dataType: 'JSON',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    // console.log(d);
                   if(d.type == 'bank'){
                        $('#tjl_b').removeClass('d-none');
                        $('#tj_b').removeClass('d-none');
                        $('#um_b').removeClass('d-none');
                        $('#kt_b').removeClass('d-none');
                        $('#pak_b').removeClass('d-none');
                        $('#lain_b').removeClass('d-none');
                        $('#angsur_b').removeClass('d-none');
                        $('#piutang_b').removeClass('d-none');

                        if(d.tjl == 0){
                            $('#tjl_b').addClass('d-none');
                            $('#ck_tjl_b').val("0");
                        }
                        if(d.tj == 0){
                            $('#tj_b').addClass('d-none');
                            $('#ck_tj_b').val("0");
                        }
                        if(d.um == 0){
                            $('#um_b').addClass('d-none');
                            $('#ck_um_b').val("0");
                        }
                        if(d.kt == 0){
                            $('#kt_b').addClass('d-none');
                            $('#ck_kt_b').val("0");
                        }
                        if(d.pak == 0){
                            $('#pak_b').addClass('d-none');
                            $('#ck_pak_b').val("0");
                        }
                        if(d.lain == 0){
                            $('#lain_b').addClass('d-none');
                            $('#ck_lain_b').val("0");
                        }
                        if(d.angsur == 0){
                            $('#angsur_b').addClass('d-none');
                            $('#ck_angsur_b').val("0");
                        }
                        if(d.piutang == 0){
                            $('#piutang_b').addClass('d-none');
                            $('#ck_piutang_b').val("0");
                        }

                   } else if(d.type == 'inhouse'){
                        $('#hk_i').removeClass('d-none');
                        $('#um_i').removeClass('d-none');
                        $('#kt_i').removeClass('d-none');
                        $('#tjl_i').removeClass('d-none');
                        $('#tj_i').removeClass('d-none');

                        if(d.hk == 0){
                            $('#hk_i').addClass('d-none');
                            $('#ck_hk_i').val("0");
                        }
                        if(d.kt == 0){
                            $('#kt_i').addClass('d-none');
                            $('#ck_kt_i').val("0");
                        }
                        if(d.tjl == 0){
                            $('#tjl_i').addClass('d-none');
                            $('#ck_tjl_i').val("0");
                        }
                        if(d.um == 0){
                            $('#um_i').addClass('d-none');
                            $('#ck_um_i').val("0");
                        }
                        if(d.tj == 0){
                            $('#tj_i').addClass('d-none');
                            $('#ck_tj_i').val("0");
                        }

                   }
                }
            });


        });

    </script>

<?php }elseif($url_cek == 'kpr/konsumen/'){ ?>

    <script>

    $('#kpr-konsumen').dataTable();

    $('.rejec-konsumen').on('click', function(d){
        d.preventDefault();
        var href = $(this).attr('href');
        // console.log(href);

        Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Untuk reject konsumen ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'YES!'
        }).then((result) => {
        if (result.value) {
            window.location.href = href;
        }
        })

    });

    var scs = $('.scs').data('flashdata');
    if(scs){
        Swal.fire(
        'Success',
        scs,
        'success'
        )
    }
    var err = $('.err').data('flashdata');
    if(err){
        Swal.fire(
        'Error',
        err,
        'error'
        )
    }


    $('.fee-marketing').on('click', function(){
        var id = $(this).data('id');
        
        $.ajax({
            url: '<?= site_url('kpr/get_fee_marketing'); ?>',
            data: {id:id},
            method: 'POST',
            success: function(d){
                $('.modal-body').html(d);
            }
        });

    });


    </script>


<?php }elseif($url_cek == 'accounting/fee_marketing/'){ ?>

    <script type="text/javascript">

        $('#table-fee-marketing').dataTable();

        $('.fee-marketing').on('click', function(){
            var id = $(this).data('id');

            $.ajax({
                url: '<?= site_url('accounting/get_fee_marketing'); ?>',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    $('#content-fee-marketing').html(d);
                }
            });

        });

        $(document).on('click','.toCode', function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            $('#kodeModal').modal('show');
            $('#formCodeFee').attr('action', link);
        });

        $(document).on('click','.repeatFee', function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            $('#kodeModal').modal('show');
            $('#formCodeFee').attr('action', link);
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


       $(document).on('click', '.approve-pembayaran', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/approve_fee_marketing/'); ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
       });

       $(document).on('click', '.tolak-pembayaran', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/reject_fee_marketing/'); ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
       });


       $(document).on('click','.cicilFee', function(){
        let id = $(this).data('id');
        $('#id_marketing').val(id);
        $('#modalCicil').modal('show');
            $.ajax({
                url: '<?= site_url('accounting/showSisaFeeMarketing') ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    



                    $('#jml').val(d.sisa);
                    $('#max_jml').val(d.sisa);
                    $('#max_edit').val(d.sisa);
                    $('#showTerbayar').html('Rp' + d.terbayar);
                    $('#showSisa').html('Rp'+d.sisa1);


                    if(d.lunas == true){
                        $('#tanggal').attr('disabled', true);
                        $('#jml').attr('disabled', true);
                        $('#toSave').attr('disabled', true);
                    } else {
                        $('#tanggal').removeAttr('disabled');
                        $('#jml').removeAttr('disabled');
                        $('#toSave').removeAttr('disabled');
                    }
                }
            });

            $.ajax({
                url: '<?= site_url('accounting/showHistoryCicilFee'); ?>',
                data: {id: id},
                type: 'POST',
                success: function(d){
                    $('#showHistoryFeeMarketing').html(d);
                }
            });

            

       });


    $('#formCicilFee').submit(function(e){
        $('#jml').inputmask({
            radixPoint: ',',
            groupSeparator: ".",
            alias: "numeric"
        });

        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data:$(this).serialize(),
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
                            }, 1500);
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

    $(document).on('click','.edit-pengajuan', function(){
        let id = $(this).data('id');
        let jml = $(this).data('jml');
        let date = $(this).data('date');

        $('#modalEdit').modal('show');
        $('#id_edit').val(id);
        $('#date').val(date);
        $('#jml_edit').val(jml);
    });

    $('#formEditCicilFee').submit(function(e){

        $("#jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
        });

        e.preventDefault();
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
                            setInterval(() => {
                                location.reload();
                            }, 1500);
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

    $(document).on('click','.delete-pengajuan', function(){
        console.log('ok');
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/deleteCicilFee'); ?>',
            data: {id: id},
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
                            }, 1500);
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

    $(document).on('click','.add-bukti', function(){
        let id = $(this).data('id');
        $('#id_bukti').val(id);
        $('#modalBukti').modal('show');
    });

    $('#formBukti').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: new FormData(this),
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
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
                            }, 1500);
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

    $(document).on('keyup mouseup','#jml, #jml_edit', function() {
            $("#jml, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });
        });
        $("#jml, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });

    $(document).on('click','.apprv', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/approve_fee_marketing/'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });
    $(document).on('click','.rejc', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/reject_fee_marketing/'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });


    </script>

<?php }elseif($url_cek == 'master/perumahan/'){ ?>
    <script type="text/javascript">
        
        $('#table-perum').dataTable();

        var err = $('.err_msg').data('msg');
        var scs = $('.scs_msg').data('msg');

        if(err){
            Swal.fire({
            icon: 'error',
            text: err,
            });
        }

        if(scs){
            Swal.fire({
                icon: 'success',
                text: scs,
            });
        }

        $('.del-perum').click(function(e){
            e.preventDefault();

            var href = $(this).attr('href');
            
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Untuk reject konsumen ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'YES!'
            }).then((result) => {
            if (result.value) {
                window.location.href = href;
            }
            })


        });

        $('.add-perum').click(function(){
            $('.modal-title').html('Add Perumahan');
            $('form').attr('action','<?= site_url('master/add_perum'); ?>');
            $('#perum').val('');
            $('#lokasi').val('');
            $('#cluster').val('');
            $('#alamat').val('');
            $('#logo').attr('required','required');
            $('.logo').addClass('d-none');
        });

        $('.edit-perum').click(function(){
            $('.modal-title').html('Edit Perumahan');
            $('form').attr('action','<?= site_url('master/edit_perum'); ?>');
            
            var id = $(this).data('id');

            $.ajax({
                url: '<?= site_url('master/get_perum_ajax'); ?>',
                dataType: 'JSON',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    $('#perum').val(d.nama_perumahan);
                    $('#lokasi').val(d.kabupaten);
                    $('#cluster').val(d.cluster);
                    $('#id_perum').val(d.id_perumahan);
                    $('#alamat').val(d.alamat_perumahan);
                    $('#logo').removeAttr('required');
                    $('.logo').removeClass('d-none');
                    $('.img-logo').attr('src', '<?= base_url(); ?>assets/img/' + d.logo);

                }
            });

        });




    </script>

<?php } elseif($url_cek == 'other/pembebasan_lahan/'){ ?>

    <script>
        $('#pemTable').dataTable();

        var scs = $('.scs-message').data('msg');
        var err = $('.err-message').data('msg');

        if(scs){
            Swal.fire({
                icon: 'success',
                text: scs,
                showConfirmButton: false,
                timer: 1500
            });
        }

        if(err){
            Swal.fire({
                icon: 'error',
                text: err,
                showConfirmButton: false,
                timer: 1500
            });
        }

        // $('.delete-data').click(function(d){
        $(document).on('click', '.delete-data', function(){

            d.preventDefault();
            var link = $(this).attr('href');
            var id = $(this).data('id');
            var href = link + '/' + id; 

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Untuk menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YES!'
                }).then((result) => {
                if (result.value) {
                    window.location.href = href;
                }
            })

        });


        $('.add-data').click(function(){
            $('.modal-title').html('Tambah Data');
            $('form').attr('action','<?= site_url('other/add_pembebasan'); ?>');
            $('#nama').val('');
            $('#total').val('');
            $('#v_total').val('');
            $('#tgl').val('');
            $('#surat').val('');
            $('#no_surat').val('');
            $('#perum').val('');
        });

        // $('.edit-data').click(function(){
        $(document).on('click','.edit-data', function(){
            $('.modal-title').html('Edit Data');
            $('form').attr('action','<?= site_url('other/edit_pembebasan'); ?>');

            var id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('other/get_pembebasan_ajax'); ?>',
                data: {id:id},
                dataType: 'JSON',
                type: 'POST',
                success: function(d){
                    $('#nama').val(d.nama_penjual);
                    $('#total').val(d.total_pembelian);
                    $('#v_total').val(d.total_pembelian);
                    $('#tgl').val(d.tgl_pengalihan);
                    $('#surat').val(d.jenis_surat);
                    $('#no_surat').val(d.no_surat);
                    $('#id_p').val(d.id_pembebasan);
                    $('#perum').val(d.id_perumahan);
                }
            });
        });

        // $('.add-cicil').click(function(){
        $(document).on('click','.add-cicil', function(){
            var id = $(this).data('id');
            $('#id_cicil').val(id);
            $('#cicil_jml').val('');

            $.ajax({
                url: '<?= site_url('other/get_kurang_cicil'); ?>',
                dataType: 'JSON',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    $('#cicil_jml').attr('placeholder', d);
                    $('#v_cicil').attr('placeholder', d);
                }
            });
        });

        // $('.viewHistory').click(function(){
        $(document).on('click', '.viewHistory', function(){
            var id = $(this).data('id');
            // console.log(id);
            $.ajax({
                url: '<?= site_url('other/view_history'); ?>',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    $('.history').html(d);
                }
            });
        });


    </script>

<?php } elseif($url_cek == 'other/pengeluaran_lain/'){ ?>

    <script>
        $('#pengTable').dataTable();

        $('.add-data').click(function(){
            $('.modal-title').html('Tambah Data');
            $('form').attr('action','<?= site_url('other/add_pengeluaran'); ?>');
            $('#tgl').val('');
            $('#jml').val('');
            $('#v_jml').val('');
            $('#ket').val('');
        });

        // $('.edit-data').on('click', function(){
        $(document).on('click', '.edit-data', function(){
            $('.modal-title').html('Edit Data');
            $('form').attr('action','<?= site_url('other/edit_pengeluaran'); ?>');

            var id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('other/get_pengeluaran_ajax'); ?>',
                dataType: 'JSON',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    $('#tgl').val(d.tgl_pengeluaran);
                    $('#jml').val(d.jml_pengeluaran);
                    $('#v_jml').val(d.jml_pengeluaran);
                    $('#ket').val(d.keterangan);
                    $('#id_p').val(d.id_pengeluaran);
                }
            });
        });

        // $('.delete-data').click(function(e){
        $(document).on('click', '.delete-data', function(){
            e.preventDefault();
            var href = $(this).attr('href');
            var id = $(this).data('id');
            var link = href + '/' + id;

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Untuk menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YES!'
                }).then((result) => {
                if (result.value) {
                    window.location.href = link;
                }
            });
        });

        var scs = $('.scs-message').data('msg');
        var err = $('.err-message').data('msg');

        if(scs){
            Swal.fire({
                icon: 'success',
                text: scs,
                showConfirmButton: false,
                timer: 1500
            });
        }

        if(err){
            Swal.fire({
                icon: 'error',
                text: err,
                showConfirmButton: false,
                timer: 1500
            });
        }

    </script>

<?php }elseif($url_cek == 'users_groups/users/'){ ?>

    <script>

        $('.viewAccessPerum').click(function(){
            var id = $(this).data('id');
            $('#id_user').val(id);

            $('.check-perum').prop('checked', false);

            var check = $('.check-perum').val();
            $.ajax({
                url: '<?= site_url('users_groups/get_access'); ?>',
                dataType: 'JSON',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    $('#showAccess').html(d);

                }
            });
        });



        var scs = $('.msg-scs').data('msg');
        var err = $('.msg-err').data('msg');

        if(scs){
            Swal.fire({
                icon: 'success',
                text: scs,
                showConfirmButton: false,
                timer: 1500
            });
        } else if(err){
            Swal.fire({
                icon: 'error',
                text: err,
                showConfirmButton: false,
                timer: 1500
            });
        }

    </script>





<?php } elseif($url_cek == 'proyek/progres/'){ ?>
    
    <script>
        $('#tableProgres').dataTable();

        $(document).on('click','.detail-progres',function(){
            let blok = $(this).data('blok');
            let upah = $(this).data('upah');
            
            window.location.href = '<?= site_url('proyek/detail_progres/'); ?>' + upah + '/' + blok;

        });

        $('#filter-Proyek').on('change', function(){
            let id = $(this).val();
            let link = '<?= site_url('proyek/progres?filter='); ?>' + id;
            window.location.href = link;
        });

    </script>

<?php } elseif($url_cek == 'proyek/detail_progres/'){ ?>

    <script>

        $('#tableDetailProgres').dataTable();


    $(document).on('click','.img-progres',function(){
        let name_file = $(this).data('img');
        $('#modelImageProgres').modal('show');
        $('#foto-progres').attr('src','<?= base_url('assets/upload/progres/'); ?>' + name_file);
    });

    // $('.btn-delete').click(function(e){
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        let url = $(this).attr('href');
        
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                url: url,
                dataType: 'JSON',
                type: 'POST',
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

    $('#add-data').click(function(){
        let id = $(this).data('id');
        let blok = $(this).data('blok');

        $('#formPersentase').attr('action','<?= site_url('proyek/add_progres'); ?>');
        $('.modal-title').html('Tambah Progres Pembangunan');
        $('#id_upah').val(id);
        $('#id_blok').val(blok);
        $('#persentase').val('');
        $('#jumlah').val('');
        $('#v_jumlah').val('');
        $('#foto').val('');
        $('#foto').attr('required','required');
        $('.foto-progres-edit').addClass('d-none');

    });

    // $('.btn-edit').click(function(){
    $(document).on('click', '.btn-edit', function(){
        let id = $(this).data('id');
        $('#exampleModal').modal('show');
        $('#formPersentase').attr('action','<?= site_url('proyek/edit_progres'); ?>');
        $('.modal-title').html('Edit Progres Pembangunan');
        $('#foto').val('');
        $('#id_progres').val(id);
        $('#foto').removeAttr('required');
        $('.foto-progres-edit').removeClass('d-none');

        $.ajax({
            url:'<?= site_url('proyek/get_progres_id_ajax'); ?>',
            dataType: 'JSON',
            type: 'POST',
            data: {id:id},
            success: function(d){
                $('#persentase').val(d.progres);
                $('#jumlah').val(d.total);
                $('#v_jumlah').val(d.total);
                $('#bukti-progres').attr('src','<?= base_url('assets/upload/progres/'); ?>'+d.foto);
            }
        });

    });

    $('#formPersentase').submit(function(e){
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            dataType: 'JSON',
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(d){
                console.log(d);
                if(d.type == 'form_validation'){
                    if(d.persentase_err == ''){
                        $('#persent_err').html('');
                    } else {
                        $('#persent_err').html(d.persentase_err);
                    }

                    if(d.persentase_err2 == ''){
                        $('#persent_err2').html('');
                    } else {
                        $('#persent_err2').html(d.persentase_err2);
                    }

                    if(d.jumlah_err == ''){
                        $('#jml_err').html('');
                    } else {
                        $('#jml_err').html(d.jumlah_err);
                    }
                }

                if(d.type == 'foto_err'){
                    if(d.msg == ''){
                        $('#img_err').html('');
                    } else {
                        $('#img_err').html(d.msg);
                    }
                }

                if(d.type == 'result'){
                    if(d.success == true){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#exampleModal').modal('hide');
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
                        $('#exampleModal').modal('hide');
                    }
                }

                if(d.type == 'err2'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#exampleModal').modal('hide');
                }
            }
        });

    });


    $('.addMandor').click(function(){
        $('#addMandor').modal('show');
        $('.mandorTitle').html('Tambah Data Mandor');
        $('#formMandor').attr('action','<?= site_url('proyek/addMandor') ?>');
    });


    $('#formMandor').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                $('#addMandor').modal('hide');
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
                        }, 1500);
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

    $('.showMandor').click(function(){
        $('#showMandor').modal('show');
        let upah = $(this).data('proyek');
        let blok = $(this).data('blok');
        $.ajax({
            url: '<?= site_url('proyek/showDataMandor') ?>',
            data: {upah: upah, blok: blok},
            type: 'POST',
            success: function(d){
                $('.showMandorModal').html(d);
            }
        });
    });

    $(document).on('click','.editDataMandor', function(){
        let id = $(this).data('id');
        let mandor = $(this).data('mandor');
        $('#addMandor').modal('show');
        $('#mandor').val(mandor);
        $('#id_mandor').val(id);
        $('#formMandor').attr('action','<?= site_url('proyek/editDataMandor') ?>');
    });


    $(document).on('click','.deleteDataMandor', function(){
        let id = $(this).data('id');
        let con = confirm('Apakah anda yakin untuk menghapus data ini');
        if(con){
            $.ajax({
                url: '<?= site_url('proyek/deleteDataMandor'); ?>',
                data: {id: id},
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
                        }, 1500);
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
    });

    </script>


<?php } elseif($url_cek == 'accounting/pembangunan/'){ ?>

    <script>

        $('#tablePembangunan').dataTable();
        $('.detail').click(function(){
            $('#exampleModal').modal('show');

            let id = $(this).data('id');

            $.ajax({
                url: '<?= site_url('accounting/detail_pembangunan'); ?>',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    $('.detail-show').html(d);
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



        $('.approve').click(function(){
            $('#formCode').modal('show');
            let id = $(this).data('id');
            let id_up = $(this).data('up');
            $('#id').val(id);
            $('#id_up').val(id_up);
        });


        $('.repeat').click(function(){
            $('#formCode').modal('show');
            let id = $(this).data('id');
            let id_up = $(this).data('up');
            $('#id').val(id);
            $('#id_up').val(id_up);
        });


        $('.tolak').click(function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/tolak_pembangunan'); ?>',
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
        });



        $('#formCodeSubmit').submit(function(e){
            e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    type: 'POST',
                    dataType:'JSON',
                    success: function(d){
                        $('#formCode').modal('hide');
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


        $(document).on('click','.approve-pembayaran', function(){
            let id_progres = $(this).data('id');
            let id_upah = $(this).data('up');

            $.ajax({
                url: '<?= site_url('accounting/approve_pembangunan_admin/'); ?>',
                data: {id: id_progres, id_up: id_upah},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });

        $(document).on('click','.tolak-pembayaran', function(){
            let id_progres = $(this).data('id');
            let id_upah = $(this).data('up');

            $.ajax({
                url: '<?= site_url('accounting/reject_pembangunan_admin/'); ?>',
                data: {id: id_progres, id_up: id_upah},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });

        $(document).on('click','.addCicil', function(){
            let id = $(this).data('id');
            $('#id_progres').val(id);
            $('#modalCicil').modal('show');

            $.ajax({
                url: '<?= site_url('accounting/showSisaProgres') ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){

                    $('#jml').val(d.sisa);
                    $('#max_jml').val(d.sisa);
                    $('#max_edit').val(d.sisa);
                    $('#showTerbayar').html('Rp' + d.terbayar);
                    $('#showSisa').html('Rp'+d.sisa1);


                    if(d.lunas == true){
                        $('#tanggal').attr('disabled', true);
                        $('#jml').attr('disabled', true);
                        $('#toSave').attr('disabled', true);
                    } else {
                        $('#tanggal').removeAttr('disabled');
                        $('#jml').removeAttr('disabled');
                        $('#toSave').removeAttr('disabled');
                    }
                }
            });

            $.ajax({
                url: '<?= site_url('accounting/showHistoryCicilProgres'); ?>',
                data: {id: id},
                type: 'POST',
                success: function(d){
                    $('#showHistory').html(d);
                }
            });
        });
        
        $('#formCicilFee').submit(function(e){
            $("#jml").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });
            e.preventDefault();
            $.ajax({
            url: $(this).attr('action'),
            data:$(this).serialize(),
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
                            }, 1500);
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

        $(document).on('click','.edit-pengajuan', function(){
            let id = $(this).data('id');
            let jml = $(this).data('jml');
            let date = $(this).data('date');

            $('#modalEdit').modal('show');
            $('#id_edit').val(id);
            $('#date').val(date);
            $('#jml_edit').val(jml);
        });

        $('#formEditCicilFee').submit(function(e){
            $("#jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });

            e.preventDefault();
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
                                setInterval(() => {
                                    location.reload();
                                }, 1500);
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

        $(document).on('click','.delete-pengajuan', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/deleteCicilProgres'); ?>',
                data: {id: id},
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
                                }, 1500);
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

        $(document).on('click','.add-bukti', function(){
            let id = $(this).data('id');
            $('#id_bukti').val(id);
            $('#modalBukti').modal('show');
        });

        $('#formBukti').submit(function(e){
            e.preventDefault();

            $.ajax({
            url: $(this).attr('action'),
            data: new FormData(this),
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
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
                            }, 1500);
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

        $(document).on('keyup mouseup','#jml, #jml_edit', function() {
            $("#jml, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });
        });
        $("#jml, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });


    $(document).on('click','.apprv', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/approve_pembangunan_admin/'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });
    $(document).on('click','.rejc', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/reject_pembangunan_admin/'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });


    $('#filter').change(function(){
        let fil = $(this).val();
        if(fil == ''){
            window.location.href = '<?= site_url('accounting/pembangunan') ?>';
        } else {
            window.location.href = '<?= site_url('accounting/pembangunan?filter=') ?>' + fil;
        }
    });

    </script>
<?php } elseif($url_cek == 'accounting/kode/'){ ?>
    <script>
    $('#tableKode').dataTable();

    $('.add-kode').click(function(){
        $('.modal-title').html('Tambah Kode');
        $('#form-kode').attr('action','<?=site_url('accounting/add_kode')?>');
        $('#id_kode').val('');
        $('#kode').val('');
        $('#desc').val('');
    });

    $('.edit-kode').click(function(){
        let id = $(this).data('id');
        $('#exampleModal').modal('show');
        $('.modal-title').html('Edit Kode');
        $('#form-kode').attr('action','<?=site_url('accounting/edit_kode')?>');
        $('#id_kode').val(id);

        $.ajax({
            url: '<?= site_url('accounting/get_kode_id'); ?>',
            dataType: 'JSON',
            data: {id:id},
            type: 'POST',
            success: function(d){
                $('#kode').val(d.kode);
                $('#desc').val(d.deskripsi_kode);
            }
        });

    });

    $('.del-kode').click(function(e){
        e.preventDefault();


        Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Menghapus kode ini dan sub kode di dalamnya",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'YES!!!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                url: $(this).attr('href'),
                dataType: 'JSON',
                type: 'POST',
                success: function(d){
                    if(d.success == true){
                        Swal.fire({
                            icon: 'success',
                            title: d.msg,
                            showConfirmButton: false,
                            timer: 1200
                        });
                        setInterval(() => {
                            $('#exampleModal').modal('hide');
                            location.reload();
                        }, 1400);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
                });
            }
        })

        
    });

    $('#form-kode').submit(function(e){
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            dataType: 'JSON',
            data: $(this).serialize(),
            type: 'POST',
            success: function(d){
                // console.log(d);
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
                    if(d.success == true){
                        Swal.fire({
                            icon: 'success',
                            title: d.msg,
                            showConfirmButton: false,
                            timer: 1200
                        });
                        setInterval(() => {
                            $('#exampleModal').modal('hide');
                            location.reload();
                        }, 1400);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            }
        });

    });
    
    </script>
<?php } elseif($url_cek == 'accounting/sub_kode/'){ ?>
    <script>
        $('#tableSub').dataTable();

        $('.add-sub').click(function(){
            $('#exampleModal').modal('show');
            $('.modal-title').html('Tambah Sub Kode');
            $('#formSub').attr('action','<?= site_url('accounting/add_sub_kode'); ?>');
            $('#sub').val('');
            $('#desc').val('');
        });

        $('.edit-sub').click(function(){
            let id = $(this).data('id');
            $('#exampleModal').modal('show');
            $('.modal-title').html('Edit Sub Kode');
            $('#formSub').attr('action','<?= site_url('accounting/edit_sub_kode'); ?>');
            $('#id_sub').val(id);

            $.ajax({
                url: '<?= site_url('accounting/get_sub_kode_id'); ?>',
                dataType: 'JSON',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    $('#sub').val(d.sub_kode);
                    $('#desc').val(d.deskripsi_sub_kode);
                }
            });
        });

        $('.del-sub').click(function(){
            let id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Menghapus kode ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
                }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '<?= site_url('accounting/del_sub_kode') ?>',
                        data: {id:id},
                        type: 'POST',
                        dataType: 'JSON',
                        success: function(d){
                            if(d.success == true){
                                Swal.fire({
                                    icon: 'success',
                                    title: d.msg,
                                    showConfirmButton: false,
                                    timer: 1200
                                });
                                setInterval(() => {
                                    location.reload();
                                }, 1400);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: d.msg,
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
                    // console.log(d);
                    if(d.type == 'err_validation'){

                        if(d.err_sub == ''){
                            $('#sub_err').html('');
                        } else {
                            $('#sub_err').html(d.err_sub);
                        } 
                        if(d.err_desc == ''){
                            $('#desc_err').html('');
                        } else {
                            $('#desc_err').html(d.err_desc);
                        }

                    } else if(d.type == 'result'){

                        if(d.success == true){
                            Swal.fire({
                                icon: 'success',
                                title: d.msg,
                                showConfirmButton: false,
                                timer: 1200
                            });
                            setInterval(() => {
                                $('#exampleModal').modal('hide');
                                location.reload();
                            }, 1400);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: d.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }

                    }
                }
            });
        });

    </script>
<?php } elseif($url_cek == 'accounting/laporan/'){ ?>

    <script>
        $(document).ready(function(){

            $('#formFilterDate').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    type: 'POST',
                    success: function(d){
                        $('.content-laporan').html(d);
                        $('#exampleModal').modal('hide');
                    }
                });
            });

        });
    </script>
<?php } elseif($url_cek == 'accounting/pembebasan_lahan/'){ ?>


    <script>
        $(document).ready(function(){
            $('#idTable').dataTable();

            $('.check').click(function(){
                const id = $(this).data('id');
                $('#modalKode').modal('show');
                $('#id_cicil').val(id);
            });

            $('.repeat').click(function(){
                const id = $(this).data('id');
                $('#modalKode').modal('show');
                $('#id_cicil').val(id);
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
                    let html = '<option value="">--Pilih--</option>';
                    let i ;
                    for(i=0; i<d.length; i++){
                        html += '<option value='+ d[i].id_title +'>('+ d[i].kode_title + '). '+ d[i].deskripsi +'</option>';
                    }
                    $('#title_kode').html(html);
                }
            });
        });



        $('#formKode').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    if(d.success == true){
                        $('#modalKode').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setInterval(() => {
                            location.reload();
                        }, 1500);
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

        $('.details').click(function(){
            const id = $(this).data('id');
            $('#exampleModal').modal('show');
            $.ajax({
                url: '<?= site_url('accounting/get_detail_pembebasan_lahan'); ?>',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    $('.showDetails').html(d);
                }
            });
        });


        });

        $(document).on('click', '.approve', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/ApprovePembebasanLahan'); ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });

        $(document).on('click', '.reject', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/RejectPembebasanLahan'); ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });

        $(document).on('click','.tolak', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/tolakPembebasanLahan') ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });


        $(document).on('click','.addCicil', function(){
            let id = $(this).data('id');
            $('#id_data').val(id);
            $('#modalCicil').modal('show');

            $.ajax({
                url: '<?= site_url('accounting/showSisaPembebasan') ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){

                    $('#jml').val(d.sisa);
                    $('#max_jml').val(d.sisa);
                    $('#max_edit').val(d.sisa);
                    $('#showTerbayar').html('Rp' + d.terbayar);
                    $('#showSisa').html('Rp'+d.sisa1);


                    if(d.lunas == true){
                        $('#tanggal').attr('disabled', true);
                        $('#jml').attr('disabled', true);
                        $('#toSave').attr('disabled', true);
                    } else {
                        $('#tanggal').removeAttr('disabled');
                        $('#jml').removeAttr('disabled');
                        $('#toSave').removeAttr('disabled');
                    }
                }
            });

            $.ajax({
                url: '<?= site_url('accounting/showHistoryCicilPembebasan'); ?>',
                data: {id: id},
                type: 'POST',
                success: function(d){
                    $('#showHistory').html(d);
                }
            });

            

        });


    $('#formCicilFee').submit(function(e){
        $("#jml").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });

        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data:$(this).serialize(),
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
                            }, 1500);
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


    $(document).on('click','.edit-pengajuan', function(){
        let id = $(this).data('id');
        let jml = $(this).data('jml');
        let date = $(this).data('date');

        $('#modalEdit').modal('show');
        $('#id_edit').val(id);
        $('#date').val(date);
        $('#jml_edit').val(jml);
    });

    $('#formEditCicilFee').submit(function(e){

        $("#jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });

        e.preventDefault();
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
                            setInterval(() => {
                                location.reload();
                            }, 1500);
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

    $(document).on('click','.delete-pengajuan', function(){
        console.log('ok');
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/deleteCicilPembebasan'); ?>',
            data: {id: id},
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
                            }, 1500);
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

    $(document).on('click','.add-bukti', function(){
        let id = $(this).data('id');
        $('#id_bukti').val(id);
        $('#modalBukti').modal('show');
    });

    $('#formBukti').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: new FormData(this),
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
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
                            }, 1500);
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


    $(document).on('keyup mouseup','#jml, #jml_edit', function() {
            $("#jml, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });
        });
        $("#jml, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });


    $(document).on('click','.apprv', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/ApprovePembebasanLahan'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });
    $(document).on('click','.rejc', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/RejectPembebasanLahan'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });

    </script>

<?php } elseif($url_cek == 'accounting/pengeluaran_lain/'){ ?>

    <script>

        $('#tablePengeluaran').dataTable();

        $('.check').click(function(){
            $('#exampleModal').modal('show');
            const id = $(this).data('id');
            $('#id_pengeluaran').val(id);
        });
        
        $('.repeat').click(function(){
            $('#exampleModal').modal('show');
            const id = $(this).data('id');
            $('#id_pengeluaran').val(id);
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
                    let html = '<option value="">--Pilih--</option>';
                    let i ;
                    for(i=0; i<d.length; i++){
                        html += '<option value='+ d[i].id_title +'>('+ d[i].kode_title + '). '+ d[i].deskripsi +'</option>';
                    }
                    $('#title_kode').html(html);
                }
            });
        });


        $('#formKode').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
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
                        }, 1500);
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

        $(document).on('click', '.approve', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/approvePengeluaranLain'); ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });

        $(document).on('click', '.reject', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/rejectPengeluaranLain'); ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });

        $(document).on('click','.addCicil', function(){
            let id = $(this).data('id');
            $('#id_add').val(id);
            $('#modalCicil').modal('show');

            $.ajax({
                url: '<?= site_url('accounting/showSisaPengeluaran') ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){

                    $('#jml').val(d.sisa);
                    $('#max_jml').val(d.sisa);
                    $('#max_edit').val(d.sisa);
                    $('#showTerbayar').html('Rp' + d.terbayar);
                    $('#showSisa').html('Rp'+d.sisa1);


                    if(d.lunas == true){
                        $('#tanggal').attr('disabled', true);
                        $('#jml').attr('disabled', true);
                        $('#toSave').attr('disabled', true);
                    } else {
                        $('#tanggal').removeAttr('disabled');
                        $('#jml').removeAttr('disabled');
                        $('#toSave').removeAttr('disabled');
                    }
                }
                });

                $.ajax({
                    url: '<?= site_url('accounting/showHistoryCicilPengeluaran'); ?>',
                    data: {id: id},
                    type: 'POST',
                    success: function(d){
                        $('#showHistoryFeeMarketing').html(d);
                    }
                });

            

        });

        $('#formCicilFee').submit(function(e){
            e.preventDefault();
            $("#jml").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });

            $.ajax({
            url: $(this).attr('action'),
            data:$(this).serialize(),
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
                            }, 1500);
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

        $(document).on('click','.edit-pengajuan', function(){
            let id = $(this).data('id');
            let jml = $(this).data('jml');
            let date = $(this).data('date');

            $('#modalEdit').modal('show');
            $('#id_edit').val(id);
            $('#date').val(date);
            $('#jml_edit').val(jml);
        });

        $('#formEditCicilFee').submit(function(e){

            $("#jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });

            e.preventDefault();
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
                                setInterval(() => {
                                    location.reload();
                                }, 1500);
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

        $(document).on('click','.delete-pengajuan', function(){
            console.log('ok');
            let id = $(this).data('id');

            $.ajax({
            url: '<?= site_url('accounting/deleteCicilpengeluaran'); ?>',
            data: {id: id},
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
                            }, 1500);
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

        $(document).on('click','.add-bukti', function(){
            let id = $(this).data('id');
            $('#id_bukti').val(id);
            $('#modalBukti').modal('show');
        });

        $('#formBukti').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                dataType: 'JSON',
                contentType: false,
                processData: false,
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
                                }, 1500);
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


        $(document).on('keyup mouseup','#jml, #jml_edit', function() {
            $("#jml, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });
        });
        $("#jml, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });


    $(document).on('click','.apprv', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/approvePengeluaranLain'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });
    $(document).on('click','.rejc', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/rejectPengeluaranLain'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });

    </script>
<?php } elseif($url_cek == 'accounting/rab/'){ ?>

    <script>
        $('#RABMaterial').dataTable();
        $('#tableUpah').dataTable();
        $('#tableLain').dataTable();

        $('.detail').click(function(){
            $('#exampleModal').modal('show');
            const id = $(this).data('id');
            const type = $(this).data('type');

            $.ajax({
                url: '<?= site_url('accounting/detail_rab'); ?>',
                data: {id:id, type:type},
                type: 'POST',
                success: function(d){
                    $('.detailRAB').html(d);
                }
            });
        });

        $('.check').click(function(){
            $('#modalKode').modal('show');

            const id = $(this).data('id');
            const type = $(this).data('type');

            $('#id').val(id);
            $('#type').val(type);
        });

        $('.repeat').click(function(){
            $('#modalKode').modal('show');

            const id = $(this).data('id');
            const type = $(this).data('type');

            $('#id').val(id);
            $('#type').val(type);
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
                    let html = '<option value="">--Pilih--</option>';
                    let i ;
                    for(i=0; i<d.length; i++){
                        html += '<option value='+ d[i].id_title +'>('+ d[i].kode_title + '). '+ d[i].deskripsi +'</option>';
                    }
                    $('#title_kode').html(html);
                }
            });
        });

        $('#formKode').submit(function(e){
            e.preventDefault();

            let type = $('#type').val();

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    if(d.success == true){
                        $('#modalKode').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setInterval(() => {
                            location.reload();
                        }, 1500);
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
<?php } elseif($url_cek == 'accounting/insidentil/'){ ?>

    <script>
        $('#tabelIns').dataTable();

       $('.check').click(function(){
            $('#modalKode').modal('show');
            const id = $(this).data('id');
            $('#id').val(id);
       });

       $('.repeat').click(function(){
            $('#modalKode').modal('show');
            const id = $(this).data('id');
            $('#id').val(id);
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
                    let html = '<option value="">--Pilih--</option>';
                    let i ;
                    for(i=0; i<d.length; i++){
                        html += '<option value='+ d[i].id_title +'>('+ d[i].kode_title + '). '+ d[i].deskripsi +'</option>';
                    }
                    $('#title_kode').html(html);
                }
            });
        });

        $('#formKode').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    if(d.success == true){
                        $('#modalKode').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setInterval(() => {
                            location.reload();
                        }, 1500);
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
            $.ajax({
                url: '<?= site_url('accounting/approveInsidentil'); ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });


        $(document).on('click','.reject', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/rejectInsidentil'); ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });

        $(document).on('click','.addPengajuan', function(){
                let id = $(this).data('id');
                $('#id_pengajuan').val(id);
                $('#modalCicil').modal('show');

            $.ajax({
                url: '<?= site_url('accounting/showSisaInsidentil'); ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    console.log(d);
                    $('#pengajuan').val(d.sisa);
                    $('#max_pengajuan').val(d.sisa);
                    $('#max_edit').val(d.sisa);
                    $('#sisaTerbayar').html('Rp. ' + d.sisa1);
                    $('#totalTerbayar').html('Rp. ' + d.terbayar);
                

                    if(d.lunas == true){
                        $('#toSave').attr('disabled', true);
                        $('#pengajuan').attr('disabled', true);
                        $('#date').attr('disabled', true);
                    } else {
                        $('#toSave').removeAttr('disabled');
                        $('#pengajuan').removeAttr('disabled');
                        $('#date').removeAttr('disabled');
                    }

                }
            });

            $.ajax({
                url: '<?= site_url('accounting/showHistoryInsidentil'); ?>',
                data: {id: id},
                type: 'POST',
                success: function(d){
                    $('#showHistoryInsidentil').html(d);
                }
            });

        });

        $('#formInsidentil').submit(function(e){
            $("#pengajuan").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });

            e.preventDefault();
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
                        setInterval(() => {
                            location.reload();
                        }, 1500);
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

        $(document).on('click','.editPengajuan', function(){
            let id = $(this).data('id');
            let date = $(this).data('date');
            let jml = $(this).data('jml');

            $('#modalEdit').modal('show');
            $('#id_edit').val(id);
            $('#tgl_edit').val(date);
            $('#jml_edit').val(jml);
        });

        $(document).on('click','.deletePengajuan', function(){
            let id = $(this).data('id');
            let conf = confirm('Apakah anda yakin untuk menghapus data ini?');
            if(conf){
                $.ajax({
                    url: '<?= site_url('accounting/deleteCicilInsidentil') ?>',
                    data: {id: id},
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
                        }, 1500);
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
        });

        let err = $('.errmsg').data('msg');
        let scs = $('.scsmsg').data('msg');
        if(err){
            Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: err,
                            showConfirmButton: false,
                            timer: 1500
                        });
        }
        if(scs){
            Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: scs,
                            showConfirmButton: false,
                            timer: 1500
                        });
        }
        

        $(document).on('click','.addBukti', function(){
            $('#modalBukti').modal('show');
            let id = $(this).data('id');
            $('#id_cicil').val(id);
        });

        $('#formBukti').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                dataType: 'JSON',
                contentType: false,
                proccesData: false,
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
                        }, 1500);
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

        $('#formEdit').submit(function(){
            $("#jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });
        });

        $(document).on('keyup mouseup','#pengajuan, #jml_edit', function() {
            $("#pengajuan, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });
        });
        $("#pengajuan, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });

    $(document).on('click','.apprv', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/approveInsidentil'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });
    $(document).on('click','.rejc', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/rejectInsidentil'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });


    </script>

<?php } elseif($url_cek == 'accounting/pengajuan_material/'){ ?>
    <script>

        $('#pegajuanTable').dataTable();

        $('.check').click(function(){
            $('#modalKode').modal('show');
            const id = $(this).data('id');
            $('#id').val(id);
        });
        
        $('.repeat').click(function(){
            $('#modalKode').modal('show');
            const id = $(this).data('id');
            $('#id').val(id);
        });

        $('.detail').click(function(){
            const id = $(this).data('id');
            $('#exampleModal').modal('show');
            $.ajax({
                url: '<?= site_url('accounting/getDetailPengajuanMaterial'); ?>',
                data: {id:id},
                type: 'POST',
                success: function(d){
                    $('.detailshow').html(d);
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
                    let html = '<option value="">--Pilih--</option>';
                    let i ;
                    for(i=0; i<d.length; i++){
                        html += '<option value='+ d[i].id_title +'>('+ d[i].kode_title + '). '+ d[i].deskripsi +'</option>';
                    }
                    $('#title_kode').html(html);
                }
            });
        });

        $('#postKode').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                dataType: 'JSON',
                processData:false,
                contentType:false,
                success: function(d){
                    if(d.success == true){
                        $('#modalKode').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setInterval(() => {
                            location.reload();
                        }, 1500);
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
            
            $.ajax({
                url: '<?= site_url('accounting/approveMaterial'); ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });

        });

        $(document).on('click', '.reject', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/rejectMaterial'); ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });

        $(document).on('click','.mcm', function(){
            let id = $(this).data('id');
           
            $('#modalMCM').modal('show');
            $('#id_logistik').val(id);

            $.ajax({
                url: '<?= site_url('accounting/showSupp') ?>',
                data: {id: id},
                type: 'POST',
                success: function(d){
                    $('#showSupp').html(d);
                }
            });

            $.ajax({
                url: '<?= site_url('accounting/showSisaPembayaran'); ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                   

                    $('#jml_pengajuan').val(d.sisa);
                    $('#jml_max').val(d.sisa);
                    $('#repeat_max').val(d.sisa);

                    $('#total_terbayar').html('Rp. ' + d.sisa1);
                    $('#sisaPembayaran').html('Rp. ' + d.sisa3);

                    if(d.lunas == true){
                        $('#tgl').attr('disabled', true);
                        $('#jml_pengajuan').attr('disabled' , true);
                        $('#toSavePembayaran').attr('disabled', true);
                    } else {
                        $('#tgl').removeAttr('disabled');
                        $('#jml_pengajuan').removeAttr('disabled');
                        $('#toSavePembayaran').removeAttr('disabled');
                    }

                }
            });

            $.ajax({
                url: '<?= site_url('accounting/showHistoryPembayaran') ?>',
                data: {id: id},
                type: 'POST',
                success: function(d){
                    $('#bodyHistory').html(d);
                }
            });

        });

        $('#formMCM').submit(function(e){
            
            $("#jml_pengajuan").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });

            $('#modalMCM').modal('hide');
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                dataType: 'JSON',
                processData:false,
                contentType:false,
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
                        }, 1500);
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

        $(document).on('click','.addBuktiPembayaran', function(){
            $('#addBuktiPembayaran').modal('show');
            let id = $(this).data('id');
            $('#id_cicil').val(id);
        });


        $('#formAddBuktiPengajuan').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                dataType: 'JSON',
                contentType : false,
                processData: false,
                success: function(d){
                    $('#addBuktiPembayaran').modal('hide');
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
                        }, 1500);
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

        $(document).on('click','.repeatPengajuan', function(){
            let id = $(this).data('id');
            let tgl = $(this).data('tgl');
            let jml = $(this).data('jml');

            $('#id_repeat').val(id);
            $('#tgl_repeat').val(tgl);
            $('#jml_repeat').val(jml);

            $('#repeat').modal('show');
        });

        $('#formRepeat').submit(function(e){

            $("#jml_repeat").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });

            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    $('#repeat').modal('hide');
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
                        }, 1500);
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

        $(document).on('click','.deletePengajuan', function(){
            let id = $(this).data('id');
            let conf = confirm('Apakah anda yakin untuk menghapus data ini?');
            if(conf){
                console.log(id);
                $.ajax({
                    url: '<?= site_url('accounting/deleteHistoryCicil') ?>',
                    data: {id: id},
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
                            }, 1500);
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
        });

        $(document).on('keyup mouseup','#jml_repeat, #jml_pengajuan', function() {
            $("#jml_repeat, #jml_pengajuan").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });
        });
        $("#jml_repeat, #jml_pengajuan").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });

    $(document).on('click','.apprv', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/approveMaterial'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });
    $(document).on('click','.rejc', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/rejectMaterial'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });


    $('#filter').change(function(){
        let fil = $(this).val();
        if(fil == ''){
            window.location.href = '<?= site_url('accounting/pengajuan_material') ?>';
        } else {
            window.location.href = '<?= site_url('accounting/pengajuan_material?filter=') ?>' + fil;
        }
    });


    </script>
<?php } elseif($url_cek == 'accounting/laporan_kas/'){ ?>
    <script>

        $('.show-modal').click(function(){
            $('#exampleModal').modal('show');
        });

            $('#formKalendar').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    type: 'POST',
                    success: function(d){
                        $('#exampleModal').modal('hide');
                        $('.showLaporan').html(d);
                    }
                }); 
            });

    </script>
<?php } elseif($url_cek == 'accounting/pembatalan_transaksi/'){ ?>
    <script>

        $('#theTable').dataTable();

        $(document).on('click', '.check', function(){
            $('#modalKode').modal('show');
            const id = $(this).data('id');
            $('#id').val(id);
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
                    let html = '<option value="">--Pilih--</option>';
                    let i ;
                    for(i=0; i<d.length; i++){
                        html += '<option value='+ d[i].id_title +'>('+ d[i].kode_title + '). '+ d[i].deskripsi +'</option>';
                    }
                    $('#title_kode').html(html);
                }
            });
        });

        $('#postKode').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    if(d.success == true){
                        $('#modalKode').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: d.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setInterval(() => {
                            location.reload();
                        }, 1500);
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

        $(document).on('click', '.times', function(){
            const id = $(this).data('id');

            $.ajax({
                url: '<?= site_url('accounting/tolak_pembatalan') ?>',
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
                        }, 1500);
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


        $(document).on('click','.tolak-pembayaran', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/rejectBatal'); ?>',
                data: {id:id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });
        $(document).on('click','.approve-pembayaran', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/approveBatal'); ?>',
                data: {id:id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });

        $(document).on('click','.addCicil', function(){
            $('#modalCicil').modal('show');
            let id = $(this).data('id');
            $('#id_pembatalan').val(id);

            $.ajax({
                url: '<?= site_url('accounting/showSisaPembatalan') ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){

                    $('#jml').val(d.sisa);
                    $('#jml_max').val(d.sisa);
                    $('#max_edit').val(d.sisa);
                    $('#showTerbayar').html('Rp.' + d.terbayar);
                    $('#showSisaPembayaran').html('Rp.' + d.sisa1);

                    if(d.lunas == true){
                        $('#tgl').attr('disabled', true);
                        $('#jml').attr('disabled', true);
                        $('#toSave').attr('disabled', true);
                    } else {
                        $('#tgl').removeAttr('disabled');
                        $('#jml').removeAttr('disabled');
                        $('#toSave').removeAttr('disabled');
                    }
                }
            });

            $.ajax({
                url: '<?= site_url('accounting/showHistoryPembatalan') ?>',
                data: {id: id},
                type: 'POST',
                success: function(d){
                    $('#toShowHistoryPembatalan').html(d);
                }
            });

        });

        $('#formPengajuan').submit(function(e){
            $("#jml").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
            });
            e.preventDefault();
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
                        setInterval(() => {
                            location.reload();
                        }, 1500);
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

        $(document).on('click','.edit-pengajuan', function(){
            let id = $(this).data('id');
            let jml = $(this).data('jml');
            let date = $(this).data('date');

            $('#modalEdit').modal('show');
            $('#id_edit').val(id);
            $('#date').val(date);
            $('#jml_edit').val(jml);
        });

        $('#formEditCicilFee').submit(function(e){
            $("#jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
            });
            e.preventDefault();
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
                                setInterval(() => {
                                    location.reload();
                                }, 1500);
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

        $(document).on('click','.delete-pengajuan', function(){
            console.log('ok');
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/deleteCicilPembatalan'); ?>',
                data: {id: id},
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
                                }, 1500);
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

        $(document).on('click','.add-bukti', function(){
            let id = $(this).data('id');
            $('#id_bukti').val(id);
            $('#modalBukti').modal('show');
        });

        $('#formBukti').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                dataType: 'JSON',
                contentType: false,
                processData: false,
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
                                }, 1500);
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

        $(document).on('keyup mouseup','#jml, #jml_edit', function() {
            $("#jml, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });
        });
        $("#jml, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });



    $(document).on('click','.apprv', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/approveBatal'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });

    $(document).on('click','.rejc', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/rejectBatal'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });


    </script>
<?php } elseif($url_cek == 'profile/'){ ?>
    <script>
        $('.edit-nama').click(function(){
            const nama = $(this).data('name');
            $('#nama_edit').val(nama);

            $('#exampleModal').modal('show');
            $('.form-nama').removeClass('d-none');
            $('.form-new-pass').addClass('d-none');
            $('.form-retype-pass').addClass('d-none');
            $('.form-photo').addClass('d-none');
            const type = 'edit-nama';
            $('#type_edit').val(type);
            $('#img').removeAttr('required');

            $('#err_nama').html('');
            $('#err_pass').html('');
            $('#err_re').html('');
        });

        $('.edit-password').click(function(){
            $('#exampleModal').modal('show');
            $('.form-nama').addClass('d-none');
            $('.form-new-pass').removeClass('d-none');
            $('.form-retype-pass').removeClass('d-none');
            $('.form-photo').addClass('d-none');
            const type = 'edit-password';
            $('#type_edit').val(type);
            $('#img').removeAttr('required');

            $('#err_nama').html('');
            $('#err_pass').html('');
            $('#err_re').html('');
        });

        $('.edit-foto').click(function(){
            $('#exampleModal').modal('show');
            $('.form-nama').addClass('d-none');
            $('.form-new-pass').addClass('d-none');
            $('.form-retype-pass').addClass('d-none');
            $('.form-photo').removeClass('d-none');
            const type = 'edit-photo';
            $('#type_edit').val(type);
            $('#img').attr('required', true);

            $('#err_nama').html('');
            $('#err_pass').html('');
            $('#err_re').html('');
        });

        $('#form-edit').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                method: 'POST',
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function(d){
                    if(d.type == 'validation'){
                        if(d.err_nama == ''){
                            $('#err_nama').html('');
                        } else {
                            $('#err_nama').html(d.err_nama);
                        }

                        if(d.err_new == ''){
                            $('#err_pass').html('');
                        } else {
                            $('#err_pass').html(d.err_new);
                        }

                        if(d.err_re == ''){
                            $('#err_re').html('');
                        } else {
                            $('#err_re').html(d.err_re);
                        }

                    } else if(d.type == 'result'){

                        if(d.success == true){
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: d.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setInterval(() => {
                                window.location.reload();
                            }, 1500);
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
<?php } elseif($url_cek == 'master/mandor/'){ ?>

    <script>
        $('#tableMandor').dataTable();

        $('.add-mandor').click(function(){
            $('#formAddMandor').attr('action','<?= site_url('master/add_mandor'); ?>');
            $('#exampleModal').modal('show');
            $('.title').html('Tambah data mandor');
            $('#err_mandor').html('');
            $('#err_telp').html('');
            $('#err_rek').html('');
            $('#err_bank').html('');
            $('#err_name').html('');

            $('#mandor').val('');
            $('#telp').val('');
            $('#rekening').val('');
            $('#bank').val('');
            $('#atas_nama').val('');
        });

        $(document).on('click','.edit', function(){
            let id = $(this).data('id');
            let mandor = $(this).data('mandor');
            let telp = $(this).data('telp');
            let rekening = $(this).data('rekening');
            let bank = $(this).data('bank');
            let nama = $(this).data('nama');

            $('#exampleModal').modal('show');
            $('.title').html('Edit data mandor');
            $('#formAddMandor').attr('action','<?= site_url('master/edit_mandor'); ?>');

            $('#err_mandor').html('');
            $('#err_telp').html('');
            $('#err_rek').html('');
            $('#err_bank').html('');
            $('#err_name').html('');

            $('#mandor').val(mandor);
            $('#telp').val(telp);
            $('#rekening').val(rekening);
            $('#bank').val(bank);
            $('#atas_nama').val(nama);
            $('#id_mandor').val(id);
        });

        $('#formAddMandor').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    if(d.type == 'validation'){
                        if(d.err_mandor == ''){
                            $('#err_mandor').html('');
                        } else {
                            $('#err_mandor').html(d.err_mandor);
                        }

                        if(d.err_telp == ''){
                            $('#err_telp').html('');
                        } else {
                            $('#err_telp').html(d.err_telp);
                        }

                        if(d.err_rekening == ''){
                            $('#err_rek').html('');
                        } else {
                            $('#err_rek').html(d.err_rekening);
                        }

                        if(d.err_bank == ''){
                            $('#err_bank').html('');
                        } else {
                            $('#err_bank').html(d.err_bank);
                        }

                        if(d.err_name == ''){
                            $('#err_name').html('');
                        } else {
                            $('#err_name').html(d.err_name);
                        }
                    } else if(d.type == 'result') {
                        $('#exampleModal').modal('hide');
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
                            }, 1500);
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

        $(document).on('click','.delete', function(){
            let id = $(this).data('id');
            let con = confirm('Apakah anda yakin untuk menghapus data ini?');
            if(con){
                $.ajax({
                    url: '<?= site_url('master/delete_mandor') ?>',
                    data: {id: id},
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
                            }, 1500);
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
        });
    </script>
<?php } elseif($url_cek == 'accounting/kas_operasional/'){ ?>

    <script>

        $('#tableKas').dataTable();

        $('.addKas').click(function(){
            $('#exampleModal').modal('show');
            $('#formKas').attr('action','<?= site_url('accounting/add_kas') ?>');
            $('#exampleModalLabel1').html('Tambah Kas Operasional');
            $('#tgl').val('');
            $('#ket').val('');
            $('#jml').val('');
        });

        $(document).on('click','.edit', function(){
            let id = $(this).data('id');
            let ket = $(this).data('ket');
            let jml = $(this).data('jml');
            let tgl = $(this).data('tgl');

            $('#exampleModal').modal('show');
            $('#formKas').attr('action','<?= site_url('accounting/edit_kas') ?>');
            $('#exampleModalLabel1').html('Edit Kas Operasional');
            $('#tgl').val(tgl);
            $('#ket').val(ket);
            $('#jml').val(jml);
            $('#id_kas').val(id);
        });

        $('#formKas').submit(function(e){
            e.preventDefault();
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
                            setInterval(() => {
                                location.reload();
                            }, 1500);
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
            $.ajax({
                url: '<?= site_url('accounting/set_status_kas') ?>',
                data: {id: id, type: 'approve'},
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
                            }, 1500);
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

        $(document).on('click','.reject', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/set_status_kas') ?>',
                data: {id: id, type: 'reject'},
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
                            }, 1500);
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
                    let html = '<option value="">--Pilih--</option>';
                    let i ;
                    for(i=0; i<d.length; i++){
                        html += '<option value='+ d[i].id_title +'>('+ d[i].kode_title + '). '+ d[i].deskripsi +'</option>';
                    }
                    $('#title_kode').html(html);
                }
            });
        });

        $(document).on('click','.delete', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/delete_kas') ?>',
                type: 'POST',
                data: {id: id},
                dataType:' JSON',
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
                            }, 1500);
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

        $(document).on('click','.addcicil', function(){
            let id = $(this).data('id');
            $('#modalAddPengajuan').modal('show');

            $.ajax({
                url: '<?= site_url('accounting/getSisaCicilKas') ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    if(d.lunas == true){
                        $('#date').attr('disabled', true);
                        $('#toSubmit').attr('disabled', true);
                        $('#dana').attr('disabled', true);
                    } else {
                        $('#date').removeAttr('disabled');
                        $('#toSubmit').removeAttr('disabled');
                        $('#dana').removeAttr('disabled');
                    }

                    $('#dana').val(d.sisa_pembayaran);
                    $('#max_dana').val(d.sisa_pembayaran);
                    $('#max_edit').val(d.sisa_pembayaran);
                    $('#id_dana_kas').val(id);
                    $('#totalterbayarKas').html(d.total_terbayar);
                    $('#sisaPembayaranKas').html(d.sisa);
                }
            });

            $.ajax({
                url: '<?= site_url('accounting/showHistoryKas'); ?>',
                data: {id: id},
                type: 'POST',
                success: function(d){
                    $('#tableHistory').html(d);
                }
            });

        });

        $('#formCicil').submit(function(e){
            $("#dana").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    $('#modalAddPengajuan').modal('hide');
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
                            }, 1500);
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

        $(document).on('click','.bukti', function(){
            $('#addBukti').modal('show');
            let id = $(this).data('id');
            $('#id_cicil').val(id);
        });

        $('#formBukti').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function(d){
                    $('#addBukti').modal('hide');
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
                            }, 1500);
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

        $(document).on('click','.edit-cicil', function(){
            let id = $(this).data('id');
            let tgl = $(this).data('tgl');
            let jml = $(this).data('jml');
            $('#modalEditCicil').modal('show');
            $('#id_cicil_edit').val(id);
            $('#date_edit').val(tgl);
            $('#jml_edit').val(jml);

        });

        $('#formEditPengajuanDana').submit(function(e){
            $("#jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric"
            });
            e.preventDefault();
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
                            setInterval(() => {
                                location.reload();
                            }, 1500);
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

        $(document).on('click','.delete-cicil', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/deleteCicilKas') ?>',
                data: {id: id},
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
                            }, 1500);
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


        $(document).on('keyup mouseup','#jml', function() {
            $("#dana, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });
        });
        $("#dana, #jml_edit").inputmask({
                radixPoint: ',',
                groupSeparator: ".",
                alias: "numeric",
                autoGroup: true,
                digits: 0
            });

    $(document).on('click','.apprv', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/approveKas'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });
    $(document).on('click','.rejc', function(){
        let id = $(this).data('id');
        $.ajax({
            url: '<?= site_url('accounting/rejectKas'); ?>',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                Swal.fire(d.msg);
                setInterval(() => {
                    location.reload();
                }, 1500);
            }
        });
    });

    </script>
<?php } elseif($url_cek == 'accounting/pemasukan_lain/'){ ?>

    <script>
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
                    let html = '<option value="">--Pilih--</option>';
                    let i ;
                    for(i=0; i<d.length; i++){
                        html += '<option value='+ d[i].id_title +'>('+ d[i].kode_title + '). '+ d[i].deskripsi +'</option>';
                    }
                    $('#title_kode').html(html);
                }
            });
        });


        $('.btnAdd').click(function(){
            $('#modalAdd').modal('show');
            $('.titleAdd').html('Tambah Pemasukan');
            $('#bukti').attr('required', true);
            $('#jml').val('');
            $('#ket').val('');
            $('#v_jumlah').val('');
            $('.showBukti').addClass('d-none');
            $('#formAdd').attr('action','<?= site_url('accounting/add_pemasukan_lain') ?>');
        });

        $('#formAdd').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
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
                            }, 1500);
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


        $(document).on('click','.details', function(){
            let id = $(this).data('id');
            $('#modalDetails').modal('show');
            $.ajax({
                url: '<?= site_url('accounting/detail_pemasukan_lain'); ?>',
                data: {id: id},
                type: 'POST',
                success: function(d){
                    $('.showDetail').html(d);
                }
            });
        });

        $(document).on('click','.approve', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/approve_pemasukan_lain') ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });

        $(document).on('click','.reject', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/reject_pemasukan_lain') ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    Swal.fire(d.msg);
                    setInterval(() => {
                        location.reload();
                    }, 1500);
                }
            });
        });

        $(document).on('click','.delete', function(){
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/delete_pemasukan_lain') ?>',
                data: {id: id},
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
                            }, 1500);
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

        $(document).on('click','.edit', function(){

            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('accounting/get_pemasukan_id') ?>',
                data: {id: id},
                type: 'POST',
                dataType: 'JSON',
                success: function(d){
                    $('#id_pemasukan').val(id);
                    $('#ket').val(d.keterangan);
                    $('#jml').val(d.jumlah);
                    $('#v_jumlah').val(d.jumlah);
                    $('#imgBukti').attr('src','<?= base_url('assets/bukti_pembayaran/') ?>'+d.bukti);
                }
            });
            $('.showBukti').removeClass('d-none');
            
            $('#modalAdd').modal('show');
            $('.titleAdd').html('Edit Pemasukan');
            $('#bukti').removeAttr('required');
            $('#formAdd').attr('action','<?= site_url('accounting/edit_pemasukan_lain') ?>');
        });

    </script>

<?php } elseif($url_cek == 'pesan/kirim_massal/'){ ?>
    <script>
        // $(document).on('click', '#kirim', function(){
        //     var pesan = $('#pesan').val();
        //     var no_hp = $('#no_hp').val();
        //     var tanggal = $('#tanggal').val();
        //     var jam = $('#jam').val();
        //     console.log(no_hp)
        //     $.ajax({
        //         url:'<?= site_url('pesan/send_message'); ?>',
        //         type: 'POST',
        //         dataType: 'JSON',
        //         data: {
        //             'pesan':  pesan,
        //             'no_hp': no_hp,
        //             'tanggal': tanggal,
        //             'jam': jam,
        //         },
        //         success: function(result){
                    
        //         }
        //     });
        // })

        $('#form-kirim').submit(function(e){
            console.log('asdasd')
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                data: new FormData(this),
                method: 'POST',
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function(result){
                    if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Pesan Berhasil DIkirim...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                    } else {
                        if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Nomor HP wajib diisi...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Api Key wajib diisi',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Interval Tagihan wajib di isi',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                    }
                }
            });

        });
    </script>
<?php } elseif($url_cek == 'pesan/pengaturan/'){ ?>
    <script>
        $(document).on('click', '#edit_pengaturan', function(){
            var template_pesan = $('#template_pesan').val();
            var interval_1 = $('#interval_1').val();
            var interval_2 = $('#interval_2').val();
            var interval_3 = $('#interval_3').val();
            var jam = $('#jam').val();

            $.ajax({
                url:'<?= site_url('pesan/edit_pengaturan'); ?>',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'template_pesan': template_pesan,
                    'interval_1': interval_1,
                    'interval_2': interval_2,
                    'interval_3': interval_3,
                    'jam': jam,
                },
                success: function(result){
                    if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Pengaturan berhasil edit...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                    } else {
                        if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Template Pesan wajib diisi...',
                                })
                            }else if(result.status == 2){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Interval 1 wajib diisi',
                                })
                            }else if(result.status == 3){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Jam wajib diisi',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                    }
                }
            });

        });

        $(document).on('click', '#edit_token', function(){
            var token = $('#token').val();

            $.ajax({
                url:'<?= site_url('pesan/edit_token'); ?>',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'token': token,
                },
                success: function(result){
                    if(result.success == true) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Token berhasil edit...',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(
                                function() {
                                    $('#staticBackdrop').modal('hide')
                                    setInterval('location.reload()', 500);
                                }
                            )
                    } else {
                        if(result.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Token wajib diisi...',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data Gagal diproses',
                                })
                            }
                    }
                }
            });

        });
    </script>
<?php } elseif($url_cek == 'pesan/tagihan/'){ ?>
    <script>
        $('#tjl').dataTable();
        $('#um').dataTable();
        $('#kt').dataTable();
        $('#tjl-inhouse').dataTable();
        $('#um-inhouse').dataTable();
        $('#kt-inhouse').dataTable();
        $('#kesepakatan-inhouse').dataTable();
        $('#pb').dataTable();
        $('#pak').dataTable();
        $('#lain').dataTable();
    </script>
<?php } elseif($url_cek == 'pesan/invoice/'){ ?>
<?php } ?>