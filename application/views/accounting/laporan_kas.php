<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Laporan Arus Kas</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <button class="btn btn-sm btn-primary show-modal"><i class="fas fa-calendar-week"></i> Pilih Tanggal</button>

                        <div class="showLaporan mt-3">
                            <div class="alert alert-secondary text-center" role="alert">
                                <b>Harap Pilih Tanggal</b>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Filter Tanggal</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= site_url('accounting/showLaporanKas'); ?>" method="post" id="formKalendar">
      <div class="modal-body">
        
        <div class="form-group">
            <label>Tanggal Awal</label>
            <input type="date" name="date_A" id="date_A" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="date" name="date_B" id="date_B" class="form-control" required>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Go <i class="fa fa-arrow-right"></i> </button>
      </div>
      </form>
    </div>
  </div>
</div>