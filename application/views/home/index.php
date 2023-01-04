<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-12 mb-4">
            <div class="text-center">
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal" style="width: 80%; height: 50px;"><i class="fa fa-arrow-right"></i> Lanjut Masuk ke Dashboard</button>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 mt-3">
            <div class="card" style="height: 145px;">
                <div class="card-body bg-danger">
                    <h5 class="text-center"> <i class="fas fa-code"></i> Management Kode</h5 >
                </div>
                <div class="card-footer text-center">
                    <a href="<?= site_url('home/kode'); ?>" class="btn btn-xs btn-outline-danger" style="width: 100%"><i class="fa fa-arrow-right"></i> Go</a>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6 mt-3">
            <div class="card" style="height: 145px;">
                <div class="card-body bg-primary">
                    <h5 class="text-center"> <i class="fas fa-home"></i> Management Perumahan</h5 >
                </div>
                <div class="card-footer text-center">
                    <a href="<?= site_url('home/perumahan'); ?>" class="btn btn-xs btn-outline-primary" style="width: 100%"><i class="fa fa-arrow-right"></i> Go</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 mt-3">
            <div class="card" style="height: 145px;">
                <div class="card-body bg-warning">
                    <h5 class="text-center"> <i class="fas fa-user"></i> Management User</h5 >
                </div>
                <div class="card-footer text-center">
                    <a href="<?= site_url('home/user'); ?>" class="btn btn-xs btn-outline-warning" style="width: 100%"><i class="fa fa-arrow-right"></i> Go</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 mt-3">
            <div class="card" style="height: 145px;">
                <div class="card-body bg-secondary">
                    <h5 class="text-center"> <i class="fas fa-users"></i> Management Group User</h5 >
                </div>
                <div class="card-footer text-center">
                    <a href="<?= site_url('home/group'); ?>" class="btn btn-xs btn-outline-secondary" style="width: 100%"><i class="fa fa-arrow-right"></i> Go</a>
                </div>
            </div>
        </div>

    </div>

    

</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Perumahan</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <?php foreach($perum as $p){ ?>
            <div class="col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body bg-primary text-light text-center">
                        <h5><i class="fas fa-home"></i> <?= $p->nama_perumahan ?></h5>
                        <p>Lokasi : <?= $p->kabupaten ?></p>
                    </div>
                    <div class="card-footer text-center">
                        <form action="<?= site_url('dashboard/masuk_perumahan'); ?>" method="post">
                        <input type="hidden" name="id_perumahan" id="id_perumahan" value="<?= $p->id_perumahan ?>">
                        <button type="submit" class="btn btn-sm btn-outline-dark"><i class="fa fa-arrow-right"></i> Go</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
