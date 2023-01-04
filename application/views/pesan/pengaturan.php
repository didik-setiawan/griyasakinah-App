<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Pengaturan</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>


<section class="content">
    <div class="container-fluid">

      <div class="row">
            <div class="col-6 offset-md-3">
            <!-- Default box -->
                <div class="card">
                  <div class="card-header">
                        Info Device
                  </div>
                  <div class="card-body">
                        <?php if($device_info !== false) { ?>
                              <div class="row">
                                    <div class="col-3">Name</div>
                                    <div class="col-9">: <?=$device_info['name']?></div>
                              </div>
                              <div class="row">
                                    <div class="col-3">Nomor HP</div>
                                    <div class="col-9">: <?=$device_info['sender']?></div>
                              </div>
                              <div class="row">
                                    <div class="col-3">Kuota</div>
                                    <div class="col-9">: <?=$device_info['quota']?></div>
                              </div>
                              <div class="row">
                                    <div class="col-3">Expired</div>
                                    <div class="col-9">: <?=$device_info['expired_date']?></div>
                              </div>
                        <?php }else { ?>
                              Token Invalid
                        <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      
      <div class="row">
            <div class="col-6 offset-md-3">
            <!-- Default box -->
                <div class="card">
                  <div class="card-header">
                        Pengaturan Device
                  </div>
                  <div class="card-body">
                     <div class="form-group">
                           <label>Token</label>
                           <input type="text"  name="token" placeholder="Masukkan Interval" id="token" value="<?= $pengaturan[0]->token ?>" class="form-control">
                     </div>
                  </div>
                  <div class="card-footer">
                     <button type="button" class="btn btn-primary btn-sm" id="edit_token" name="edit_token"><i class="fa fa-save"></i> Simpan </button>
                  </div>
               </div>
            </div>
         </div>


        <div class="row">
            <div class="col-6 offset-md-3">
            <!-- Default box -->
                <div class="card">
                  <div class="card-header">
                        Pengaturan Pesan Tagihan Otomatis
                  </div>
                  <div class="card-body">
                     <div class="form-group">
                           <label>Template pesan</label>
                           <textarea min="0" name="template_pesan" placeholder="Masukkan Interval" id="template_pesan" class="form-control"><?= $pengaturan[0]->template_pesan ?></textarea>
                           <small><b>Keterangan</b></small><br>
                           <small><i><b> {nama} :</b> Nama yang ditagih , </i></small>
                           <small><i><b> {jenis_tagihan} :</b> Jenis Transaksi Tagihan ,</i></small>
                           <small><i><b> {total_angsuran} :</b> Total Angsuran ,</i></small>
                           <small><i><b> {total_sudah_bayar} :</b> Total Yang Sudah Dibayar ,</i></small>
                           <small><i><b> {total_belum_bayar} :</b> Total Yang Belum Dibayar ,</i></small>
                           <small><i><b> {jatuh_tempo} :</b> Tanggal Jatuh Tempo ,</i></small>
                     </div>
                     <div class="form-group">
                           <label>Interval Penagihan 1</label>
                           <input type="number" min="0" name="interval_1" placeholder="Masukkan Interval" id="interval_1" value="<?= $pengaturan[0]->interval_1 ?>" class="form-control">
                     </div>
                     <div class="form-group">
                           <label>Interval Penagihan 2</label>
                           <input type="number" min="0" name="interval_2" placeholder="Masukkan Interval" id="interval_2" value="<?= $pengaturan[0]->interval_2 ?>" class="form-control">
                     </div>
                     <div class="form-group">
                           <label>Interval Penagihan 3</label>
                           <input type="number" min="0" name="interval_3" placeholder="Masukkan Interval" id="interval_3" value="<?= $pengaturan[0]->interval_3 ?>" class="form-control">
                     </div>
                     <div class="form-group">
                           <label>Jam</label>
                           <input type="time" name="jam" placeholder="Masukkan Interval" id="jam" value="<?= $pengaturan[0]->jam ?>" required class="form-control">
                     </div>
                  </div>
                  <div class="card-footer">
                     <button type="button" class="btn btn-primary btn-sm" id="edit_pengaturan" name="edit_pengaturan"><i class="fa fa-save"></i> Simpan </button>
                  </div>
               </div>
            </div>
         </div>

   </div>
</section>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="staticBackdropLabel">Scan QR</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="scan_html">

      </div>
    </div>
  </div>
</div>
