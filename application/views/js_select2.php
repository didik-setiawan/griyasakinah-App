<?php
// ini ditampilkan sesuai kebutuhan page masing masing untuk MODAL BOOTSTRAP
$url_cek = cek_url();
?>
<script>
    $(function() {

        <?php
            if ($url_cek == 'inventaris/daftar_barang/') {
                ?>
                    $('#kategori_produk').select2({
                        placeholder: "Kategori Barang",
                        allowClear: true
                    })
                <?php
            } elseif ($url_cek == 'inventaris/laporan/') {
                ?>
                    $('#kategori_produk').select2({
                        placeholder: "Kategori Barang",
                        allowClear: true
                    })
                <?php
            } elseif ($url_cek == 'inventaris/stok/') {
                ?>
                    $('#tipe_stok').select2({
                        placeholder: "tampilkan by Status",
                        allowClear: true
                    })
                    $('#nama_barang_in').select2({
                        placeholder: "Pilih barang",
                        allowClear: true
                    })
                    $('#nama_barang_out').select2({
                        placeholder: "Pilih barang",
                        allowClear: true
                    })
                    $('#nama_barang_edit').select2({
                        placeholder: "Pilih barang",
                        allowClear: true
                    })
                <?php
            } elseif ($url_cek == 'laporan_keuangan/setup/') {
                ?>
                    $('#kategori_transaksi').select2({
                        placeholder: "Kategori Transaksi",
                        allowClear: true
                    })
                <?php
            }elseif ($url_cek == 'logistik/ajukan_material/') {
                ?>

                    function count_on_modal() {
                        var quantity = $('#jumlah').val()
                        var kavling = $('#total').val()

                        total = (quantity * kavling)

                        $('#total_quantity').val(total)                      
                    }

                    $(document).on('keyup mouseup', '#jumlah, #total_quantity', function() {
                        count_on_modal()
                    })


                    $('#id_proyek,#id_tipe,#kavling,#id_kavling,#material,#kategori_id').select2({
                        allowClear: true,
                        placeholder: "-Pilih-",
                    })

                    $("#harga").inputmask({
                        // prefix : 'Rp ',
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                        autoGroup: true,
                        digits: 0
                    });
                  
                <?php
            }elseif ($url_cek == 'logistik/material_masuk/') {
                ?>
                    $('#item_material_in').select2({
                        placeholder: "Item Material",
                        allowClear: true
                    })
                    $('#edit_id_kategori_material,#edit_id_kavling').select2({
                        placeholder: "Pilih",
                        allowClear: true
                    })
                <?php
            }elseif ($url_cek == 'logistik/material_keluar/') {
                ?>
                     $('#item_material_in').select2({
                        placeholder: "Item Material",
                        allowClear: true
                    })
                    $('#edit_id_kategori_material,#edit_id_kavling').select2({
                        placeholder: "Pilih",
                        allowClear: true
                    })
                <?php
            }elseif ($url_cek == 'logistik/rekap_stok_material/') {
                ?>
                     $('#id_material,#id_kategori').select2({
                        placeholder: "-Pilih-",
                        allowClear: true
                    })
                <?php

            }elseif ($url_cek == 'logistik/detail_keluar/') {
                ?>
                    // $('#kavling').select2({
                    //     allowClear: true,
                    // })
                
                <?php   

            }elseif ($url_cek == 'proyek/ajukan_proyek/') {
                ?>

                    $(document).ready(function() {
                        $('#id_tipe,#kavling_id,#id_cluster').select2({
                        placeholder: "-Pilih-",
                        allowClear: true
                        });
                    });

                    $("#total").inputmask({
                        // prefix : 'Rp ',
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                        autoGroup: true,
                        digits: 0
                    });
                  
                <?php
            }elseif ($url_cek == 'proyek/detail_rab/') {
                ?>
                    $('#unit_id,#id_kategori,#id_cluster,#id_cluster_upah,#id_cluster_lain,#id_material,#id_kavling_lain,#id_kavling_mat, #edit_blok_upah, #blok_lain, #edit_blok_lainnya').select2({
                        allowClear: true,
                        placeholder: "-Pilih-",
                    })

                    $('#blok_mat,#blok_upah,#blok_lain, #edit_blok_mat').select2({
                        allowClear: true,
                        placeholder: "-Pilih-",
                    })

                    function count_on_modal() {
                        var price = $('#add_harga').val()
                        var qty = $('#add_quantity').val()

                       $('#add_hargaA').val(price)

                       var harga = $('#add_hargaA').val()

                        total = (harga* qty)

                        $('#add_total').val(total)

                        $('#add_totalA').val(total)
                        
                    }

                    $(document).on('keyup mouseup', '#add_quantity, #add_harga, #add_hargaA,#add_totalA', function() {
                        count_on_modal()
                    })


                    function count_on() {
                        var price = $('#edit_add_harga').val()
                        var qty = $('#edit_add_quantity').val()

                       $('#edit_add_hargaA').val(price)

                       var harga = $('#edit_add_hargaA').val()

                        total = (harga* qty)

                        $('#edit_add_total').val(total)

                        $('#edit_add_totalA').val(total)

                        var hargakontrak = $('#harga_kontrak').val()
                        $('#harga_kontrakA').val(hargakontrak)

                        var edithargakontrak = $('#edit_harga_kontrak').val()
                        $('#edit_harga_kontrakA').val(edithargakontrak)

                        var hargaLainnya = $('#lainnya').val()
                        $('#lainnyaA').val(hargaLainnya)

                        var edithargaLainnya = $('#edit_lainnya').val()
                        $('#edit_lainnyaA').val(edithargaLainnya)
                        
                    }

                    $(document).on('keyup mouseup', '#lainnya,#lainnyaA,#edit_lainnya,#edit_lainnyaA,#edit_add_quantity, #edit_add_harga, #edit_add_hargaA,#edit_add_total,#edit_add_totalA,#harga_kontrak,#harga_kontrakA,#edit_harga_kontrak,#edit_harga_kontrakA', function() {
                        count_on()
                    })

                    $("#lainnya,#edit_lainnya,#add_harga,#edit_add_harga,#add_total,#edit_add_total,#harga_kontrak,#edit_harga_kontrak").inputmask({
                        // prefix : 'Rp ',
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                        autoGroup: true,
                        digits: 0
                    });

                    $("#lainnyaA,#edit_lainnyaA,#add_hargaA,#edit_add_hargaA,#add_totalA,#edit_add_totalA,#harga_kontrakA,#edit_harga_kontrakA").inputmask({
                        // prefix : 'Rp ',
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                    });
                  
                <?php
            }elseif ($url_cek == 'proyek/pengajuan_material/') {
                ?>

                    function count_on_modal() {
                        var price = $('#harga_real').val()

                       $('#harga_realA').val(price)
                    }

                    $(document).on('keyup mouseup','#harga_real', '#harga_realA', function() {
                        count_on_modal()
                    })

                    $(".harga-rill").inputmask({
                        // prefix : 'Rp ',
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                        autoGroup: true,
                        digits: 0
                    });

                    

                    $("#harga_realA").inputmask({
                        // prefix : 'Rp ',
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                    });
                  
                    

                <?php
            }elseif ($url_cek == 'proyek/pekerjaan_insidentil/') {
                ?>

                    function count_on_modal() {
                        var price = $('#nilai').val()
                       $('#nilaiA').val(price)
                    }

                    $(document).on('keyup mouseup','#nilai', '#nilaiA', function() {
                        count_on_modal()
                    })

                    function count_on() {
                       var price_e = $('#nilai_e').val()
                        $('#nilaiA_e').val(price_e)
                    }

                    $(document).on('keyup mouseup','#nilai_e','#nilaiA_e', function() {
                        count_on()
                    })

                    $(document).ready(function() {
                        $('#id_proyek').select2({
                        placeholder: "Pilih Proyek",
                        allowClear: true
                        });
                    });

                    $("#nilai,#nilai_e").inputmask({
                        // prefix : 'Rp ',
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                        autoGroup: true,
                        digits: 0
                    });

                    $("#nilaiA,#nilaiA_e").inputmask({
                        // prefix : 'Rp ',
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                    });
                  
                <?php
            }elseif ($url_cek == 'master/material/') {
                ?>
                    $('#unit_id,#kategori_id').select2({
                        allowClear: true
                    });
                <?php
            }elseif ($url_cek == 'master/material_max/') {
                ?>
                    $('#id_tipe').select2({
                        allowClear: true
                    });
                <?php
            }elseif ($url_cek == 'master/tipe/') {
                ?>
                    $('#id_kategori,#id_material,#cluster,#lokasi,#cluster_e').select2({
                        allowClear: true
                    });
                <?php
            }elseif ($url_cek == 'master/kavling/') {
                ?>

                    $(document).on('keyup mouseup', '#v_harga, #v_harga_e', function(){
                        
                        let harga = $('#v_harga').val();
                        $('#harga').val(harga);

                        let harga_e = $('#v_harga_e').val();
                        $('#harga_e').val(harga_e);
                    });


                    $("#v_harga, #v_harga_e").inputmask({
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                        autoGroup: true,
                        digits: 0
                    });

                    $('#harga, #harga_e').inputmask({
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                    });

                <?php
            }elseif ($url_cek == 'other/pembebasan_lahan/') {
                
                ?>

                    $(document).on('keyup mouseup', '#v_total, #v_cicil', function(){
                        
                        let total = $('#v_total').val();
                        $('#total').val(total);

                        let cicil = $('#v_cicil').val();
                        $('#cicil_jml').val(cicil);

                    });

                    $("#v_total, #v_cicil").inputmask({
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                        autoGroup: true,
                        digits: 0
                    });
                    $('#total, #cicil_jml').inputmask({
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                    });

                <?php

            }elseif ($url_cek == 'other/pengeluaran_lain/') {
                ?>

                    $(document).on('keyup mouseup', '#v_jml', function(){
                        
                        let jml = $('#v_jml').val();
                        $('#jml').val(jml);

                    });

                    $("#v_jml").inputmask({
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                        autoGroup: true,
                        digits: 0
                    });
                    $('#jml').inputmask({
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                    });

                <?php
            }elseif ($url_cek == 'proyek/detail_progres/') {
                ?>

                    $(document).on('keyup mouseup', '#v_jumlah', function(){
                        
                        let jml = $('#v_jumlah').val();
                        $('#jumlah').val(jml);

                    });

                    $("#v_jumlah").inputmask({
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                        autoGroup: true,
                        digits: 0
                    });
                    $('#jumlah').inputmask({
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                    });

                <?php
            }elseif ($url_cek == 'marketing/transaksi_bank/') {
                ?>

                    $(document).on('keypress mouseup', '#v_gaji, #v_gaji_p, #v_hk, #v_tanda_jadi, #v_tanda_jadi_lokasi, #v_um, #v_kelebihan_tanah, #v_pak, #v_angsuran, #v_piutang, #v_lain, #v_gaji_edit, #v_gaji_pe, #v_hk_edit, #v_tj_edit, #v_tjl_edit, #v_um_edit, #v_kt_edit, #v_pak_edit, #v_angsuran_edit, #v_piutang_edit, #v_lain_edit', function(){

                        let gaji = $('#v_gaji').val();
                        $('#gaji').val(gaji);

                        let gaji_p = $('#v_gaji_p').val();
                        $('#gaji_p').val(gaji_p);

                        let hk = $('#v_hk').val();
                        $('#harga_kesepakatan').val(hk);

                        let tanda_jadi = $('#v_tanda_jadi').val();
                        $('#tanda_jadi').val(tanda_jadi);

                        let tjl = $('#v_tanda_jadi_lokasi').val();
                        $('#tanda_jadi_lokasi').val(tjl);

                        let um = $('#v_um').val();
                        $('#uang_muka').val(um);

                        let kt = $('#v_kelebihan_tanah').val();
                        $('#kelebihan_tanah').val(kt);

                        let pak = $('#v_pak').val();
                        $('#pak').val(pak);

                        let R_bank = $('#v_angsuran').val();
                        $('#angsuran').val(R_bank);

                        let piutang = $('#v_piutang').val();
                        $('#piutang').val(piutang);

                        let lain = $('#v_lain').val();
                        $('#lain').val(lain);

                        let e_gaji = $('#v_gaji_edit').val();
                        $('#gaji_edit').val(e_gaji);

                        let e_gaji_p = $('#v_gaji_pe').val();
                        $('#gaji_pe').val(e_gaji_p);

                        let e_hk = $('#v_hk_edit').val();
                        $('#hk_edit').val(e_hk);

                        let e_tj = $('#v_tj_edit').val();
                        $('#tj_edit').val(e_tj);

                        let e_tjl = $('#v_tjl_edit').val();
                        $('#tjl_edit').val(e_tjl);

                        let e_um = $('#v_um_edit').val();
                        $('#um_edit').val(e_um);

                        let e_kt = $('#v_kt_edit').val();
                        $('#kt_edit').val(e_kt);

                        let e_pak = $('#v_pak_edit').val();
                        $('#pak_edit').val(e_pak);

                        let e_realisasi = $('#v_angsuran_edit').val();
                        $('#angsuran_edit').val(e_realisasi);

                        let e_cicil = $('#v_piutang_edit').val();
                        $('#piutang_edit').val(e_cicil);

                        let e_lain = $('#v_lain_edit').val();
                        $('#lain_edit').val(e_lain);
                    });

                    $("#v_gaji, #v_gaji_p, #harga_A, #v_hk, #v_tanda_jadi, #v_cicil_angsur_tj, #v_tanda_jadi_lokasi, #v_um, #v_cicil_um, #v_kelebihan_tanah, #v_pak, #v_cicil_angsur_pak, #v_cicil_angsur_kt, #v_angsuran, #v_cicil_A, #v_piutang, #v_cicil_P, #v_lain, #v_cicil_angsur_lain, #v_gaji_edit, #v_gaji_pe, #v_harga_edit, #v_hk_edit, #v_tj_edit, #v_tjl_edit, #v_angsuran_tjl_edit, #v_um_edit, #v_angsuran_um_edit, #v_kt_edit, #v_angsuran_kt_edit, #v_pak_edit, #v_angsuran_pak_edit, #v_cicil_AE, #v_angsuran_edit, #v_piutang_edit, #v_cicil_PE, #v_lain_edit, #v_angsuran_lain_edit").inputmask({
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                        autoGroup: true,
                        digits: 0
                    });
                    $('#gaji, #gaji_p, #harga_kesepakatan, #tanda_jadi, #tanda_jadi_lokasi, #cicil_angsur_tj, #uang_muka, #cicil_angsur_um, #kelebihan_tanah, #pak, #cicil_angsur_pak, #cicil_angsur_kt, #angsuran, #cicil_A, #cicil_P, #piutang, #lain, #cicil_angsur_lain, #gaji_edit, #gaji_pe, #hk_edit, #tj_edit, #tjl_edit, #angsuran_tjl_edit, #um_edit, #angsuran_um_edit, #kt_edit, #angsuran_kt_edit, #pak_edit, #angsuran_pak_edit, #cicil_AE, #angsuran_edit, #piutang_edit, #cicil_PE, #lain_edit, #angsuran_lain_edit').inputmask({
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                    });

                <?php
            }elseif ($url_cek == 'marketing/transaksi_inhouse/') {


                ?>

                    $(document).on('keypress mouseup', '#v_gaji_p, #v_gaji, #v_tanda_jadi, #v_hk, #v_tjl, #v_um, #v_kt, #v_gaji_edit, #v_gaji_pe, #v_harga_edit, #v_tj_edit, #v_tjl_edit, #v_um_edit, #v_kt_edit, #v_hk_edit', function(){

                        let gaji = $('#v_gaji').val();
                        $('#gaji').val(gaji);
                        
                        let gaji_p = $('#v_gaji_p').val();
                        $('#gaji_p').val(gaji_p);

                        let tj = $('#v_tanda_jadi').val();
                        $('#tanda_jadi').val(tj);

                        let hk = $('#v_hk').val();
                        $('#hk').val(hk);

                        let tjl = $('#v_tjl').val();
                        $('#tjl').val(tjl);

                        let um = $('#v_um').val();
                        $('#um').val(um);

                        let kt = $('#v_kt').val();
                        $('#kt').val(kt);

                        let gaji_e = $('#v_gaji_edit').val();
                        $('#gaji_edit').val(gaji_e);

                        let gaji_pe = $('#v_gaji_pe').val();
                        $('#gaji_pe').val(gaji_pe);

                        let harga_e = $('#v_harga_edit').val();
                        $('#harga_edit').val(harga_e);

                        let tj_e = $('#v_tj_edit').val();
                        $('#tj_edit').val(tj_e);

                        let tjl_e = $('#v_tjl_edit').val();
                        $('#tjl_edit').val(tjl_e);

                        let um_e = $('#v_um_edit').val();
                        $('#um_edit').val(um_e);

                        let kt_e = $('#v_kt_edit').val();
                        $('#kt_edit').val(kt_e);

                        let hk_e = $('#v_hk_edit').val();
                        $('#hk_edit').val(hk_e);
                    });

                    $("#v_gaji_p, #v_gaji, #v_harga, #v_tanda_jadi, #v_hk, #v_cicil_angsur_hk, #v_tjl, #v_cicil_angsur_tjl, #v_um, #v_cicil_angsur_um, #v_kt, #v_cicil_angsur_kt, #v_gaji_edit, #v_gaji_pe, #v_harga_edit, #v_tj_edit, #v_tjl_edit, #v_angsuran_tjl_edit, #v_um_edit, #v_angsuran_um_edit, #v_kt_edit, #v_angsuran_kt_edit, #v_hk_edit, #v_angsuran_hk_edit").inputmask({
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                        autoGroup: true,
                        digits: 0
                    });

                    $('#gaji_p, #gaji, #harga, #tanda_jadi, #hk, #cicil_angsur_hk, #tjl, #cicil_angsur_tjl, #um, #cicil_angsur_um, #kt, #cicil_angsur_kt, #gaji_edit, #gaji_pe, #harga_edit, #tj_edit, #tjl_edit, #angsuran_tjl_edit, #um_edit, #angsuran_um_edit, #kt_edit, #angsuran_kt_edit, #hk_edit, #angsuran_hk_edit').inputmask({
                        radixPoint: ',',
                        groupSeparator: ".",
                        alias: "numeric",
                    });

                <?php
            }elseif ($url_cek == 'accounting/pemasukan_lain/') {
                ?>
                    $('#tableLain').dataTable();
                    $(document).on('keyup mouseup', '#v_jumlah', function(){

                        let jml = $('#v_jumlah').val();
                        $('#jml').val(jml);
                        let realjml = $('#jml').cleanVal();
                        $('#jml').val(realjml);
                    });

                    $('#v_jumlah').mask("#.##0", {reverse: true});
                    $('#jml').mask("#.##0", {reverse: true});
            
                    
                    

                    
                   
                <?php 
            }elseif ($url_cek == 'accounting/fee_marketing/') { 
                ?>

                
                    
                

                <?php
            } 
                ?>
    });
</script>