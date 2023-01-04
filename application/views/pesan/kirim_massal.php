<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Kirim Massal</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <!-- Default box -->
                <div class="card">
                  <form action="<?= site_url('pesan/send_message') ?>" enctype="multipart/form-data" method="post" id="form-kirim">
                     <div class="card-body">
                        
                        <div class="form-group">
                              <label>Pesan</label>
                              <textarea  name="pesan" placeholder="Masukkan Pesan" id="pesan" class="form-control"> </textarea>
                        </div>
                        <div class="form-group">
                              <label>Media</label>
                              <input type="file" name="foto" placeholder="Masukkan foto" id="foto" class="form-control">
                        </div>
                        <div class="form-group">
                              <label>Tanggal Pengiriman</label>
                              <input type="date" name="tanggal" placeholder="Masukkan Tanggal" id="tanggal" class="form-control">
                        </div>
                        <div class="form-group">
                              <label>Waktu Pengiriman</label>
                              <input type="time" name="jam" placeholder="Masukkan Jam" id="jam" class="form-control">
                        </div>
                        <div class="form-group">
                              <label>Kontak <br> <small><i>*Kosongkan bila ingin mengirim ke semua kontak</i></small></label>
                              <select class="form-control js-example-basic-multiple" name="no_hp[]" id="no_hp" multiple="multiple" style="width: 100%">   
                                 <?php foreach($calon_konsumen as $item) {?>
                                    <option value="<?= $item->no_hp?>"><?= $item->no_hp?> ( <?= $item->nama_konsumen ?> )</option>
                                 <?php } ?>
                           </select>
                        </div>
                     </div>
                     <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm" id="kirim" name="kirim"> Kirim </button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
   </div>
</section>