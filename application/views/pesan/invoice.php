<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Invoice</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <!-- Default box -->
                <div class="card">
                <div class="card-header">
                        <h5>Transaksi Bank</h5>
                    </div>
                    <div class="card-body">
                        <nav>
                            <!-- <button type="button" class="btn btn-sm btn-primary float-right <?php access(); ?>" data-toggle="modal" data-target="#sitemapModal"><i class="fas fa-search"></i> Lihat Sitemap</button> -->
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="nav-tjl-tab" data-toggle="tab" href="#nav-tjl" role="tab" aria-controls="nav-tjl" aria-selected="true">Tanda Jadi Lokasi</a>
                                <a class="nav-link" id="nav-um-tab" data-toggle="tab" href="#nav-um" role="tab" aria-controls="nav-um" aria-selected="false">Uang Muka</a>
                                <a class="nav-link" id="nav-kt-tab" data-toggle="tab" href="#nav-kt" role="tab" aria-controls="nav-kt" aria-selected="false">Kelebihan Tanah</a>
                                <a class="nav-link" id="nav-pb-tab" data-toggle="tab" href="#nav-pb" role="tab" aria-controls="nav-pb" aria-selected="false">Piutang Bank</a>
                                <a class="nav-link" id="nav-pak-tab" data-toggle="tab" href="#nav-pak" role="tab" aria-controls="nav-pak" aria-selected="false">PAK</a>
                                <a class="nav-link" id="nav-lain-tab" data-toggle="tab" href="#nav-lain" role="tab" aria-controls="nav-lain" aria-selected="false">Lain Lain</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active mt-3" id="nav-tjl" role="tabpanel" aria-labelledby="nav-tjl-tab">
                

                                <table class="table table-bordered mt-3" id="tjl">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($tanda_jadi_lokasi as $c){ if($c['cicilan_detail']){ foreach($c['cicilan_detail'] as $d) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $d->tanggal ?></td>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $d->jumlah ?></td>
                                                <?php if($d->status == 1){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 2){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 3){ ?>
                                                    <td>Approved</td>
                                                <?php }else{ ?>
                                                    <td>Ditolak</td>
                                                <?php }?>
                                                <td><a href="<?= site_url('pesan/gen_tjl/'.$d->id_cicil . '/'. $c['no_hp'] ) ?>" class="btn btn-primary btn-sm">Send Invoice</a></td>
                                            </tr>
                                        <?php }}} ?>
                                    </tbody>
                                </table>

                            </div>

                            <div class="tab-pane fade mb-3" id="nav-um" role="tabpanel" aria-labelledby="nav-um-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="um">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                    <?php $i = 1; foreach($uang_muka as $c){ if($c['cicilan_detail']){ foreach($c['cicilan_detail'] as $d) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $d->tanggal ?></td>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $d->jumlah ?></td>
                                                <?php if($d->status == 1){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 2){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 3){ ?>
                                                    <td>Approved</td>
                                                <?php }else{ ?>
                                                    <td>Ditolak</td>
                                                <?php }?>
                                                <td><a href="<?= site_url('pesan/gen_um/'.$d->id_cicil . '/'. $c['no_hp'] ) ?>" class="btn btn-primary btn-sm">Send Invoice</a></td>
                                            </tr>
                                        <?php }}} ?>
                                    </tbody>
                                </table>


                            </div>

                            <div class="tab-pane fade mb-3" id="nav-kt" role="tabpanel" aria-labelledby="nav-kt-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="kt">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($kelebihan_tanah as $c){ if($c['cicilan_detail']){ foreach($c['cicilan_detail'] as $d) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $d->tanggal ?></td>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $d->jumlah ?></td>
                                                <?php if($d->status == 1){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 2){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 3){ ?>
                                                    <td>Approved</td>
                                                <?php }else{ ?>
                                                    <td>Ditolak</td>
                                                <?php }?>
                                                <td><a href="<?= site_url('pesan/gen_kt/'.$d->id_cicil . '/'. $c['no_hp'] ) ?>" class="btn btn-primary btn-sm">Send Invoice</a></td>
                                            </tr>
                                        <?php }}} ?>
                                    </tbody>
                                </table>


                            </div>

                            <div class="tab-pane fade mb-3" id="nav-pb" role="tabpanel" aria-labelledby="nav-pb-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="pb">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($piutang_bank as $c){ if($c['cicilan_detail']){ foreach($c['cicilan_detail'] as $d) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $d->tanggal ?></td>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $d->jumlah ?></td>
                                                <?php if($d->status == 1){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 2){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 3){ ?>
                                                    <td>Approved</td>
                                                <?php }else{ ?>
                                                    <td>Ditolak</td>
                                                <?php }?>
                                                <td><a href="<?= site_url('pesan/gen_piutang/'.$d->id_cicil . '/'. $c['no_hp'] ) ?>" class="btn btn-primary btn-sm">Send Invoice</a></td>
                                            </tr>
                                        <?php }}} ?>
                                    </tbody>
                                </table>


                            </div>

                            <div class="tab-pane fade mb-3" id="nav-pak" role="tabpanel" aria-labelledby="nav-pak-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="pak">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($pak as $c){ if($c['cicilan_detail']){ foreach($c['cicilan_detail'] as $d) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $d->tanggal ?></td>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $d->jumlah ?></td>
                                                <?php if($d->status == 1){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 2){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 3){ ?>
                                                    <td>Approved</td>
                                                <?php }else{ ?>
                                                    <td>Ditolak</td>
                                                <?php }?>
                                                <td><a href="<?= site_url('pesan/gen_pak/'.$d->id_cicil . '/'. $c['no_hp'] ) ?>" class="btn btn-primary btn-sm">Send Invoice</a></td>
                                            </tr>
                                        <?php }}} ?>
                                    </tbody>
                                </table>


                            </div>

                            <div class="tab-pane fade mb-3" id="nav-lain" role="tabpanel" aria-labelledby="nav-lain-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="lain">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($lain_lain as $c){ if($c['cicilan_detail']){ foreach($c['cicilan_detail'] as $d) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $d->tanggal ?></td>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $d->jumlah ?></td>
                                                <?php if($d->status == 1){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 2){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 3){ ?>
                                                    <td>Approved</td>
                                                <?php }else{ ?>
                                                    <td>Ditolak</td>
                                                <?php }?>
                                                <td><a href="<?= site_url('pesan/gen_lain/'.$d->id_cicil . '/'. $c['no_hp'] ) ?>" class="btn btn-primary btn-sm">Send Invoice</a></td>
                                            </tr>
                                        <?php }}} ?>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h5>Transaksi Inhouse</h5>
                    </div>
                    <div class="card-body">
                        <nav>
                            <!-- <button type="button" class="btn btn-sm btn-primary float-right <?php access(); ?>" data-toggle="modal" data-target="#sitemapModal"><i class="fas fa-search"></i> Lihat Sitemap</button> -->
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="nav-tjl-inhouse-tab" data-toggle="tab" href="#nav-tjl-inhouse" role="tab" aria-controls="nav-tjl-inhouse" aria-selected="true">Tanda Jadi Lokasi Inhouse</a>
                                <a class="nav-link" id="nav-um-inhouse-tab" data-toggle="tab" href="#nav-um-inhouse" role="tab" aria-controls="nav-um-inhouse" aria-selected="false">Uang Muka</a>
                                <a class="nav-link" id="nav-kt-inhouse-tab" data-toggle="tab" href="#nav-kt-inhouse" role="tab" aria-controls="nav-kt-inhouse" aria-selected="false">Kelebihan Tanah</a>
                                <a class="nav-link" id="nav-kesepakatan-inhouse-tab" data-toggle="tab" href="#nav-kesepakatan-inhouse" role="tab" aria-controls="nav-kesepakatan-inhouse" aria-selected="false">Harga Kesepakatan</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active mt-3" id="nav-tjl-inhouse" role="tabpanel" aria-labelledby="nav-tjl-inhouse-tab">
                

                                <table class="table table-bordered mt-3" id="tjl-inhouse">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($tanda_jadi_lokasi_inhouse as $c){ if($c['cicilan_detail']){ foreach($c['cicilan_detail'] as $d) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $d->tanggal ?></td>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $d->jumlah ?></td>
                                                <?php if($d->status == 1){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 2){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 3){ ?>
                                                    <td>Approved</td>
                                                <?php }else{ ?>
                                                    <td>Ditolak</td>
                                                <?php }?>
                                                <td><a href="<?= site_url('pesan/gen_inhouse_tjl/'.$d->id_cicil . '/'. $c['no_hp'] ) ?>" class="btn btn-primary btn-sm">Send Invoice</a></td>
                                            </tr>
                                        <?php }}} ?>
                                    </tbody>
                                </table>

                            </div>

                            <div class="tab-pane fade mb-3" id="nav-um-inhouse" role="tabpanel" aria-labelledby="nav-um-inhouse-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="um-inhouse">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($uang_muka_inhouse as $c){ if($c['cicilan_detail']){ foreach($c['cicilan_detail'] as $d) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $d->tanggal ?></td>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $d->jumlah ?></td>
                                                <?php if($d->status == 1){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 2){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 3){ ?>
                                                    <td>Approved</td>
                                                <?php }else{ ?>
                                                    <td>Ditolak</td>
                                                <?php }?>
                                                <td><a href="<?= site_url('pesan/gen_inhouse_um/'.$d->id_cicil . '/'. $c['no_hp'] ) ?>" class="btn btn-primary btn-sm">Send Invoice</a></td>
                                            </tr>
                                        <?php }}} ?>
                                    </tbody>
                                </table>


                            </div>

                            <div class="tab-pane fade mb-3" id="nav-kt-inhouse" role="tabpanel" aria-labelledby="nav-kt-inhouse-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="kt-inhouse">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($kelebihan_tanah_inhouse as $c){ if($c['cicilan_detail']){ foreach($c['cicilan_detail'] as $d) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $d->tanggal ?></td>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $d->jumlah ?></td>
                                                <?php if($d->status == 1){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 2){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 3){ ?>
                                                    <td>Approved</td>
                                                <?php }else{ ?>
                                                    <td>Ditolak</td>
                                                <?php }?>
                                                <td><a href="<?= site_url('pesan/gen_inhouse_kt/'.$d->id_cicil . '/'. $c['no_hp'] ) ?>" class="btn btn-primary btn-sm">Send Invoice</a></td>
                                            </tr>
                                        <?php }}} ?>
                                    </tbody>
                                </table>


                            </div>

                            <div class="tab-pane fade mb-3" id="nav-kesepakatan-inhouse" role="tabpanel" aria-labelledby="nav-kesepakatan-inhouse-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="kesepakatan-inhouse">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Jumlah Dibayar</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($harga_kesepakatan_inhouse as $c){ if($c['cicilan_detail']){ foreach($c['cicilan_detail'] as $d) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $d->tanggal ?></td>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $d->jumlah ?></td>
                                                <?php if($d->status == 1){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 2){ ?>
                                                    <td>Sudah Upload Bukti</td>
                                                <?php }elseif($d->status == 3){ ?>
                                                    <td>Approved</td>
                                                <?php }else{ ?>
                                                    <td>Ditolak</td>
                                                <?php }?>
                                                <td><a href="<?= site_url('pesan/gen_hk/'.$d->id_cicil . '/'. $c['no_hp'] ) ?>" class="btn btn-primary btn-sm">Send Invoice</a></td>
                                            </tr>
                                        <?php }}} ?>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>