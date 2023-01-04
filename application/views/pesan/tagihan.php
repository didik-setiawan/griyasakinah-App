<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Tagihan</h1>
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
                                            <th>Jatuh Tempo</th>
                                            <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                <th>Penagihan 1 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                <th>Penagihan 2 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                <th>Penagihan 3 </th>
                                            <?php } ?>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Total Angsuran</th>
                                            <th>Jumlah Terbayar</th>
                                            <th>Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($tanda_jadi_lokasi as $c){ ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $c['jatuh_tempo'] ?></td>
                                                <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_1 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_2 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_3 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $c['total_angsuran'] ?></td>
                                                <td><?= $c['jumlah_terbayar'] ?></td>
                                                <td><?= $c['tagihan'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>

                            <div class="tab-pane fade mb-3" id="nav-um" role="tabpanel" aria-labelledby="nav-um-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="um">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Jatuh Tempo</th>
                                            <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                <th>Penagihan 1 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                <th>Penagihan 2 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                <th>Penagihan 3 </th>
                                            <?php } ?>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Total Angsuran</th>
                                            <th>Jumlah Terbayar</th>
                                            <th>Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($uang_muka as $c){ ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $c['jatuh_tempo'] ?></td>
                                                <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_1 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_2 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_3 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $c['total_angsuran'] ?></td>
                                                <td><?= $c['jumlah_terbayar'] ?></td>
                                                <td><?= $c['tagihan'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>


                            </div>

                            <div class="tab-pane fade mb-3" id="nav-kt" role="tabpanel" aria-labelledby="nav-kt-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="kt">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Jatuh Tempo</th>
                                            <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                <th>Penagihan 1 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                <th>Penagihan 2 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                <th>Penagihan 3 </th>
                                            <?php } ?>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Total Angsuran</th>
                                            <th>Jumlah Terbayar</th>
                                            <th>Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($kelebihan_tanah as $c){ ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $c['jatuh_tempo'] ?></td>
                                                <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_1 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_2 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_3 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $c['total_angsuran'] ?></td>
                                                <td><?= $c['jumlah_terbayar'] ?></td>
                                                <td><?= $c['tagihan'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>


                            </div>

                            <div class="tab-pane fade mb-3" id="nav-pb" role="tabpanel" aria-labelledby="nav-pb-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="pb">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Jatuh Tempo</th>
                                            <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                <th>Penagihan 1 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                <th>Penagihan 2 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                <th>Penagihan 3 </th>
                                            <?php } ?>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Total Angsuran</th>
                                            <th>Jumlah Terbayar</th>
                                            <th>Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($piutang_bank as $c){ ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $c['jatuh_tempo'] ?></td>
                                                <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_1 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_2 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_3 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $c['total_angsuran'] ?></td>
                                                <td><?= $c['jumlah_terbayar'] ?></td>
                                                <td><?= $c['tagihan'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>


                            </div>

                            <div class="tab-pane fade mb-3" id="nav-pak" role="tabpanel" aria-labelledby="nav-pak-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="pak">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Jatuh Tempo</th>
                                            <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                <th>Penagihan 1 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                <th>Penagihan 2 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                <th>Penagihan 3 </th>
                                            <?php } ?>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Total Angsuran</th>
                                            <th>Jumlah Terbayar</th>
                                            <th>Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($pak as $c){ ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $c['jatuh_tempo'] ?></td>
                                                <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_1 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_2 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_3 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $c['total_angsuran'] ?></td>
                                                <td><?= $c['jumlah_terbayar'] ?></td>
                                                <td><?= $c['tagihan'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>


                            </div>

                            <div class="tab-pane fade mb-3" id="nav-lain" role="tabpanel" aria-labelledby="nav-lain-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="lain">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Jatuh Tempo</th>
                                            <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                <th>Penagihan 1 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                <th>Penagihan 2 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                <th>Penagihan 3 </th>
                                            <?php } ?>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Total Angsuran</th>
                                            <th>Jumlah Terbayar</th>
                                            <th>Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($lain_lain as $c){ ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $c['jatuh_tempo'] ?></td>
                                                <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_1 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_2 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_3 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $c['total_angsuran'] ?></td>
                                                <td><?= $c['jumlah_terbayar'] ?></td>
                                                <td><?= $c['tagihan'] ?></td>
                                            </tr>
                                        <?php } ?>
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
                                            <th>Jatuh Tempo</th>
                                            <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                <th>Penagihan 1 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                <th>Penagihan 2 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                <th>Penagihan 3 </th>
                                            <?php } ?>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Total Angsuran</th>
                                            <th>Jumlah Terbayar</th>
                                            <th>Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($tanda_jadi_lokasi_inhouse as $c){ ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $c['jatuh_tempo'] ?></td>
                                                <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_1 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_2 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_3 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $c['total_angsuran'] ?></td>
                                                <td><?= $c['jumlah_terbayar'] ?></td>
                                                <td><?= $c['tagihan'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>

                            <div class="tab-pane fade mb-3" id="nav-um-inhouse" role="tabpanel" aria-labelledby="nav-um-inhouse-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="um-inhouse">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Jatuh Tempo</th>
                                            <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                <th>Penagihan 1 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                <th>Penagihan 2 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                <th>Penagihan 3 </th>
                                            <?php } ?>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Total Angsuran</th>
                                            <th>Jumlah Terbayar</th>
                                            <th>Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($uang_muka_inhouse as $c){ ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $c['jatuh_tempo'] ?></td>
                                                <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_1 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_2 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_3 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $c['total_angsuran'] ?></td>
                                                <td><?= $c['jumlah_terbayar'] ?></td>
                                                <td><?= $c['tagihan'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>


                            </div>

                            <div class="tab-pane fade mb-3" id="nav-kt-inhouse" role="tabpanel" aria-labelledby="nav-kt-inhouse-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="kt-inhouse">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Jatuh Tempo</th>
                                            <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                <th>Penagihan 1 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                <th>Penagihan 2 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                <th>Penagihan 3 </th>
                                            <?php } ?>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Total Angsuran</th>
                                            <th>Jumlah Terbayar</th>
                                            <th>Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($kelebihan_tanah_inhouse as $c){ ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $c['jatuh_tempo'] ?></td>
                                                <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_1 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_2 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_3 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $c['total_angsuran'] ?></td>
                                                <td><?= $c['jumlah_terbayar'] ?></td>
                                                <td><?= $c['tagihan'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>


                            </div>

                            <div class="tab-pane fade mb-3" id="nav-kesepakatan-inhouse" role="tabpanel" aria-labelledby="nav-kesepakatan-inhouse-tab">
                                            <br>
                                <table class="table table-bordered mt-3" id="kesepakatan-inhouse">
                                    <thead>
                                        <tr class="bg-dark text-light">
                                            <th>#</th>
                                            <th>Jatuh Tempo</th>
                                            <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                <th>Penagihan 1 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                <th>Penagihan 2 </th>
                                            <?php } ?>
                                            <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                <th>Penagihan 3 </th>
                                            <?php } ?>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Total Angsuran</th>
                                            <th>Jumlah Terbayar</th>
                                            <th>Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-add-transaksi-bank">
                                        <?php $i = 1; foreach($harga_kesepakatan_inhouse as $c){ ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $c['jatuh_tempo'] ?></td>
                                                <?php if($pengaturan->interval_1 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_1 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_2 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_2 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <?php if($pengaturan->interval_3 != 0 ){ ?>
                                                    <td> <?= date('Y-m-d', strtotime("-$pengaturan->interval_3 day", strtotime($c['jatuh_tempo']))); ?></td>
                                                <?php } ?>
                                                <td><?= $c['konsumen'] ?></td>
                                                <td><?= $c['no_hp'] ?></td>
                                                <td><?= $c['total_angsuran'] ?></td>
                                                <td><?= $c['jumlah_terbayar'] ?></td>
                                                <td><?= $c['tagihan'] ?></td>
                                            </tr>
                                        <?php } ?>
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