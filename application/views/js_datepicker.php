<?php 
  // ini ditampilkan sesuai kebutuhan page masing masing untuk MODAL BOOTSTRAP
  $url_cek = cek_url();

if($url_cek == 'laporan_keuangan/bulanan/'){
    ?>
    <?php
}elseif($url_cek == 'inventaris/kategori_list/'){
    ?>
    <?php
}elseif($url_cek == 'database/customerxxxx/'){
    ?>
    <?php
}elseif($url_cek == 'dashboard/'){
    ?>
        <script>
            $(function () {
                //Date range picker
                $('#reservation').daterangepicker({
                    locale: {
                    format: 'YYYY-MM-DD'
                    }
                })
                $('#hari_ini').daterangepicker({
                    locale: {
                    format: 'YYYY-MM-DD'
                    }
                })

                //Date range picker with time picker
                $('#reservationtime').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 30,
                    locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                    }
                })

                $('#calendar').datetimepicker({
                    format: 'L',
                    inline: true
                })

                //Date range as a button
                $('#daterange-btn').daterangepicker(
                    {
                    ranges   : {
                        'Today'       : [moment(), moment()],
                        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate  : moment()
                    },
                    function (start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                    }
                )

                //Timepicker
                $('#timepicker').datetimepicker({
                    format: 'LT'
                })

                $('#durasi_awal').datetimepicker({
                    use24hours: true,
                    format: 'HH:mm'
                });

                $('#durasi_akhir').datetimepicker({
                    use24hours: true,
                    format: 'HH:mm'
                });

                //Date picker
                $('#datepicker').datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd'
                });

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


            })
        </script>
    <?php
}
?>

