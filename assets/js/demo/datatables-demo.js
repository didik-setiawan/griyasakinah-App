// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable();

  //GET UPDATE
  $('#dataTable').on('click','.item_edit',function(){
    var id=$(this).attr('data');
    $.ajax({
        type : "GET",
        url  : "<?php echo base_url('barang/get_barang')?>",
        dataType : "JSON",
        data : {id:id},
        success: function(data){
            $.each(data,function(barang_kode, barang_nama, barang_harga){
                $('#UserUpdate').modal('show');
                $('[name="kobar_edit"]').val(data.barang_kode);
                $('[name="nabar_edit"]').val(data.barang_nama);
                $('[name="harga_edit"]').val(data.barang_harga);
            });
        }
    });
    return false;
  });

  $('.view_data').click(function(){
    var id = $(this).attr("id");
    $.ajax({
      url: 'view.php',	// set url -> ini file yang menyimpan query tampil detail data siswa
      method: 'post',		// method -> metodenya pakai post. Tahu kan post? gak tahu? browsing aja :)
      data: {id:id},		// nah ini datanya -> {id:id} = berarti menyimpan data post id yang nilainya dari = var id = $(this).attr("id");
      success:function(data){		// kode dibawah ini jalan kalau sukses
        $('#data_siswa').html(data);	// mengisi konten dari -> <div class="modal-body" id="data_siswa">
        $('#myModal').modal("show");	// menampilkan dialog modal nya
      }
    });
  });

});
