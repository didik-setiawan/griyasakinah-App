<!-- 

<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-light">
                        Konfirmasi Pembayaran
                    </div>
                    <div class="card-body"> -->
                      
                        <div class="TheData">

                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th>Tanggal</th>
                                        <th>Transaksi</th>
                                        <th>Jumlah</th>
                                        <th><i class="fa fa-cogs"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- transaksi bank -->
                                    <?php foreach($tjl_b as $tb){ ?>
                                        <tr>
                                            <td><?php $date = date_create($tb->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi Tanda Jadi Lokasi</td>
                                            <td>Rp. <?= number_format($tb->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="tjl_b" data-tipe="bank_tjl" data-id="<?= $tb->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="tjl_b" data-tipe="bank_tjl"  data-id="<?= $tb->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="tjl_b" data-tipe="bank_tjl" data-id="<?= $tb->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>   
                                    <?php } ?>
                                    <?php foreach($um_b as $ub){ ?>
                                        <tr>
                                            <td><?php $date = date_create($ub->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi Uang Muka</td>
                                            <td>Rp. <?= number_format($ub->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="um_b" data-tipe="bank_um" data-id="<?= $ub->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="um_b" data-tipe="bank_um"  data-id="<?= $ub->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="um_b" data-tipe="bank_um" data-id="<?= $ub->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>   
                                    <?php } ?>
                                    <?php foreach($kt_b as $kb){ ?>
                                        <tr>
                                            <td><?php $date = date_create($kb->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi Kelebihan Tanah</td>
                                            <td>Rp. <?= number_format($kb->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="kt_b" data-tipe="bank_kt" data-id="<?= $kb->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="kt_b" data-tipe="bank_kt"  data-id="<?= $kb->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="kt_b" data-tipe="bank_kt" data-id="<?= $kb->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>   
                                    <?php } ?>
                                    <?php foreach($pak_b as $pb){ ?>
                                        <tr>
                                            <td><?php $date = date_create($pb->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi PAK</td>
                                            <td>Rp. <?= number_format($pb->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="pak_b" data-tipe="bank_pak" data-id="<?= $pb->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="pak_b" data-tipe="bank_pak"  data-id="<?= $pb->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="pak_b" data-tipe="bank_pak" data-id="<?= $pb->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>       
                                    <?php } ?>
                                    <?php foreach($lain_b as $lb){ ?>
                                        <tr>
                                            <td><?php $date = date_create($lb->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi Lain-lain</td>
                                            <td>Rp. <?= number_format($lb->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="lain_b" data-tipe="bank_lain" data-id="<?= $lb->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="lain_b" data-tipe="bank_lain"  data-id="<?= $lb->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="lain_b" data-tipe="bank_lain" data-id="<?= $lb->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>      
                                    <?php } ?>

                                    <!-- transaksi Inhouse -->
                                    <?php foreach($hk_i as $hi){ ?>
                                        <tr>
                                            <td><?php $date = date_create($hi->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi Harga Kesepakatan</td>
                                            <td>Rp. <?= number_format($hi->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="hk_i" data-tipe="inhouse_hk" data-id="<?= $hi->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="hk_i" data-tipe="inhouse_hk"  data-id="<?= $hi->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="hk_i" data-tipe="inhouse_hk" data-id="<?= $hi->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>       
                                    <?php } ?>

                                    <?php foreach($tjl_i as $ti){ ?>
                                        <tr>
                                            <td><?php $date = date_create($ti->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi Tanda Jadi Lokasi</td>
                                            <td>Rp. <?= number_format($ti->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="tjl_i" data-tipe="inhouse_tjl" data-id="<?= $ti->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="tjl_i" data-tipe="inhouse_tjl"  data-id="<?= $ti->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="tjl_i" data-tipe="inhouse_tjl" data-id="<?= $ti->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>       
                                    <?php } ?>
                                    <?php foreach($um_i as $ui){ ?>
                                        <tr>
                                            <td><?php $date = date_create($ui->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi Uang Muka</td>
                                            <td>Rp. <?= number_format($ui->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="um_i" data-tipe="inhouse_um" data-id="<?= $ui->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="um_i" data-tipe="inhouse_um"  data-id="<?= $ui->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="um_i" data-tipe="inhouse_um" data-id="<?= $ui->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>         
                                    <?php } ?>
                                    <?php foreach($kt_i as $ki){ ?>
                                        <tr>
                                            <td><?php $date = date_create($ki->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi Harga Kesepakatan</td>
                                            <td>Rp. <?= number_format($ki->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="kt_i" data-tipe="inhouse_kt" data-id="<?= $ki->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="kt_i" data-tipe="inhouse_kt"  data-id="<?= $ki->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="kt_i" data-tipe="inhouse_kt" data-id="<?= $ki->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>         
                                    <?php } ?>


                                    <!-- Konfirmasi upah pembangunan -->
                                    <?php foreach($pembangunan as $up){?>
                                        <tr>
                                            <td><?php $date = date_create($up->tgl); echo date_format($date, 'd F Y'); ?></td>
                                            <td>Upah Pembangunan</td>
                                            <td>Rp. <?= number_format($up->jumlah); ?></td>
                                            <td>
                                            <button class="btn btn-xs btn-danger reject" data-type="pembangunan" data-id="<?= $up->id_cicil ?>"><i class="fa fa-times"></i></button>

                                            <button class="btn btn-xs btn-success approve" data-type="pembangunan"  data-id="<?= $up->id_cicil ?>" data-up="<?= $up->upah_id ?>"><i class="fa fa-check"></i></button>

                                            <button class="btn btn-xs btn-info details" data-type="pembangunan" data-id="<?= $up->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>


                                    <!-- Konfirmasi fee Marketing -->
                                    <?php
                                    // var_dump($fee_marketing); die;
                                     foreach($fee_marketing as $fee){ ?>
                                        <tr>
                                            <td><?php $date = date_create($fee->tgl_cicil); echo date_format($date, 'd F Y'); ?></td>
                                            <td>Fee Marketing</td>
                                            <td>Rp. <?= number_format($fee->jumlah) ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="fee_marketing" data-id="<?= $fee->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="fee_marketing"  data-id="<?= $fee->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="fee_marketing" data-id="<?= $fee->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>


                                    <?php foreach($pembebasan as $pemb){ ?>
                                        <tr>
                                            <td><?php $date = date_create($pemb->tanggal); echo date_format($date, 'd F Y'); ?></td>
                                            <td>Pembebasan Lahan</td>
                                            <td>Rp. <?= number_format($pemb->jumlah) ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="pembebasan" data-id="<?= $pemb->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="pembebasan" data-id="<?= $pemb->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="pembebasan" data-id="<?= $pemb->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php foreach($pengeluaran as $pl){ ?>
                                        <tr>
                                            <td><?php $date = date_create( $pl->tanggal); echo date_format($date, 'd F Y'); ?></td>
                                            <td>Pengeluaran Lain</td>
                                            <td>Rp. <?= number_format($pl->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="pengeluaran" data-id="<?= $pl->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="pengeluaran" data-id="<?= $pl->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="pengeluaran" data-id="<?= $pl->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php foreach($rab_material as $rm){ ?>
                                        <tr>
                                            <td><?= $rm->tgl_approve ?></td>
                                            <td>RAB Material</td>
                                            <td>Rp. <?= number_format($rm->total); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="rabMaterial" data-id="<?= $rm->id_material ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="rabMaterial" data-id="<?= $rm->id_material ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="rabMaterial" data-id="<?= $rm->id_material ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                
                                    <?php foreach($rab_upah  as $ru){ ?>
                                        <tr>
                                            <td><?= $ru->tgl_approve ?></td>
                                            <td>RAB Upah</td>
                                            <td>Rp. <?php 
                                                $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $ru->proyek_id AND tbl_kavling.id_tipe = $ru->tipe_id";
                                                $kav = $this->db->query($q)->num_rows();

                                                echo number_format($kav * $ru->harga_kontrak);

                                             ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="rabUpah" data-id="<?= $ru->id_upah ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="rabUpah" data-id="<?= $ru->id_upah ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="rabUpah" data-id="<?= $ru->id_upah ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php foreach($rab_lain as $rl){ ?>
                                        <tr>
                                            <td><?= $rl->tgl_approve ?></td>
                                            <td>RAB Lain-lain</td>
                                            <td>Rp. <?php 
                                                $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $rl->proyek_id AND tbl_kavling.id_tipe = $rl->tipe_id";
                                                $kav = $this->db->query($q)->num_rows();

                                                echo number_format($kav * $rl->harga_lainnya);

                                             ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="rabLain" data-id="<?= $rl->id_lain ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="rabLain" data-id="<?= $rl->id_lain ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="rabLain" data-id="<?= $rl->id_lain ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php foreach($insidentil as $i){ ?>
                                        <tr>
                                            <td><?= $i->tgl_approve ?></td>
                                            <td>Proyek Insidentil</td>
                                            <td>Rp. <?php echo 
                                                    number_format($i->jml_cicil)
                                             ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="insidentil" data-id="<?= $i->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="insidentil" data-id="<?= $i->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="insidentil" data-id="<?= $i->id ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php foreach($material as $mat){ ?>
                                        <tr>
                                            <td><?= $mat->tgl_pengajuan ?></td>
                                            <td>Pengajuan Pembayaran Material</td>
                                            <td>Rp. <?php echo
                                                number_format($mat->jml_pengajuan);
                                             ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="material" data-id="<?= $mat->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="material" data-id="<?= $mat->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="material" data-id="<?= $mat->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php foreach($angsur_b as $ang){ ?>
                                        <tr>
                                            <td><?php $date = date_create($ang->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi Realisasi Bank</td>
                                            <td>Rp. <?= number_format($ang->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="angsuran_b" data-tipe="bank_realisasi" data-id="<?= $ang->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="angsuran_b" data-tipe="bank_realisasi"  data-id="<?= $ang->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="angsuran_b" data-tipe="bank_realisasi" data-id="<?= $ang->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>  
                                    <?php } ?>

                                    <?php foreach($piutang_b as $pb){ ?>
                                        <tr>
                                            <td><?php $date = date_create($pb->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi Piutang Bank</td>
                                            <td>Rp. <?= number_format($pb->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="piutang_b" data-tipe="bank_piutang" data-id="<?= $pb->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="piutang_b" data-tipe="bank_piutang"  data-id="<?= $pb->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="piutang_b" data-tipe="bank_piutang" data-id="<?= $pb->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>     
                                    <?php } ?>

                                    <?php foreach($batal as $btl){ ?>
                                        <tr>
                                            <td><?php $date = date_create($btl->tanggal); echo date_format($date, 'd F Y'); ?></td>
                                            <td>Transaksi Batal</td>
                                            <td>Rp. <?= number_format($btl->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="batal" data-id="<?= $btl->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="batal"  data-id="<?= $btl->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="batal" data-id="<?= $btl->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>    
                                    <?php } ?>

                                    <?php foreach($b_tj as $btj){ ?>
                                        <tr>
                                            <td><?php $date = date_create($btj->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi Tanda Jadi</td>
                                            <td>Rp. <?= number_format($btj->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="b_tj" data-tipe="bank_tj" data-id="<?= $btj->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="b_tj" data-tipe="bank_tj"  data-id="<?= $btj->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="b_tj" data-tipe="bank_tj" data-id="<?= $btj->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>    
                                    <?php } ?>


                                    <?php foreach($i_tj as $itj){ ?>
                                        <tr>
                                            <td><?php $date = date_create($itj->tanggal); echo date_format($date, 'd F Y') ?></td>
                                            <td>Transaksi Tanda Jadi</td>
                                            <td>Rp. <?= number_format($itj->jumlah); ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-danger reject" data-type="i_tj" data-tipe="inhouse_tj" data-id="<?= $itj->id_cicil ?>"><i class="fa fa-times"></i></button>

                                                <button class="btn btn-xs btn-success approve" data-type="i_tj" data-tipe="inhouse_tj"  data-id="<?= $itj->id_cicil ?>"><i class="fa fa-check"></i></button>

                                                <button class="btn btn-xs btn-info details" data-type="i_tj" data-tipe="inhouse_tj" data-id="<?= $itj->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>   
                                    <?php } ?>

                                    <?php foreach($pemasukan as $pem){ 
                                        $date = date_create($pem->tanggal);    
                                        ?>
                                        <tr>
                                            <td><?= date_format($date, 'd F Y') ?></td>
                                            <td>Pemasukan Lain</td>
                                            <td>Rp. <?= number_format($pem->jumlah) ?></td>
                                            <td>

                                                <button class="btn btn-xs btn-danger reject" data-type="pemasukan" data-id="<?= $pem->id_pemasukan ?>"><i class="fa fa-times"></i></button>
                                                <button class="btn btn-xs btn-success approve" data-type="pemasukan" data-id="<?= $pem->id_pemasukan ?>"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-xs btn-info details" data-type="pemasukan" data-id="<?= $pem->id_pemasukan ?>" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-search"></i></button>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php foreach($kas as $k){ 
                                        $date = date_create($k->tanggal);    
                                        ?>
                                        <tr>
                                            <td><?= date_format($date, 'd F Y') ?></td>
                                            <td>Kas Operasional</td>
                                            <td>Rp. <?= number_format($k->jml_cicil) ?></td>
                                            <td>

                                                <button class="btn btn-xs btn-danger reject" data-type="kas" data-id="<?= $k->id_cicil ?>"><i class="fa fa-times"></i></button>
                                                <button class="btn btn-xs btn-success approve" data-type="kas" data-id="<?= $k->id_cicil ?>"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-xs btn-info details" data-type="kas" data-id="<?= $k->id_cicil ?>" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-search"></i></button>

                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>

                        </div>
<!-- 
                    </div>
                </div>
            </div>
        </div>
    </div> -->

 

    <script>
        $('.details').click(function(){
            var id = $(this).data('id');
            var type = $(this).data('type');
            // console.log(id); console.log(type);

            $.ajax({
                url: '<?= site_url('dashboard/show_details'); ?>',
                data: {id:id, type:type},
                type: 'POST',
                success: function(data){
                    $('.listDetail').html(data);
                }
            });
        });


        $('.approve').click(function(){
            var type = $(this).data('type');
            var tipe = $(this).data('tipe');
            var id = $(this).data('id');
            let id_up = $(this).data('up');
            // console.log(type);
            // var link = '';
            if(type == 'tjl_b'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }   
            if(type == 'um_b'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }
            if(type == 'kt_b'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }
            if(type == 'pak_b'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }
            if(type == 'lain_b'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }
            if(type == 'angsuran_b'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }
            if(type == 'piutang_b'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }
            if(type == 'hk_i'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }
            if(type == 'tjl_i'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }
            if(type == 'um_i'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }
            if(type == 'kt_i'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }
            if(type == 'pembangunan'){
                var link = '<?= site_url('accounting/approve_pembangunan_admin/'); ?>';
            }
            if(type == 'fee_marketing') {
                var link = '<?= site_url('accounting/approve_fee_marketing/'); ?>';
            }
            if(type == 'pembebasan'){
                var link = '<?= site_url('accounting/ApprovePembebasanLahan'); ?>';
            }
            if(type == 'pengeluaran'){
                var link = '<?= site_url('accounting/approvePengeluaranLain'); ?>';
            }
            if(type == 'rabMaterial'){
                var link = '<?= site_url('accounting/approveRABMaterial'); ?>';
            }
            if(type == 'rabUpah'){
                var link = '<?= site_url('accounting/approveRABUpah'); ?>';
            }
            if(type == 'rabLain'){
                var link = '<?= site_url('accounting/approveRABLain'); ?>';
            }
            if(type == 'insidentil'){
                var link = '<?= site_url('accounting/approveInsidentil'); ?>';
            }
            if(type == 'material'){
                var link = '<?= site_url('accounting/approveMaterial'); ?>';
            }
            if(type == 'batal'){
                var link = '<?= site_url('accounting/approveBatal'); ?>';
            }
            if(type == 'b_tj'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }
            if(type == 'i_tj'){
                var link = '<?= site_url('pemasukan/approve_pemasukan/'); ?>';
            }
            if(type == 'kas'){
                var link = '<?= site_url('accounting/approveKas'); ?>';
            }
            if(type == 'pemasukan'){
                var link = '<?= site_url('accounting/approve_pemasukan_lain'); ?>';
            }
            $.ajax({
                url: link,
                dataType: 'JSON',
                data: {id:id, id_up:id_up, tipe:tipe},
                type: 'POST',
                success: function(d){
                    Swal.fire(d.msg);
                }
            });

        });


        $('.reject').click(function(){
            var type = $(this).data('type');
            var tipe = $(this).data('tipe');
            var id = $(this).data('id');

            if(type == 'tjl_b'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }   
            if(type == 'um_b'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }
            if(type == 'kt_b'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }
            if(type == 'pak_b'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }
            if(type == 'lain_b'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }
            if(type == 'angsuran_b'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }
            if(type == 'piutang_b'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }
            if(type == 'hk_i'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }
            if(type == 'tjl_i'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }
            if(type == 'um_i'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }
            if(type == 'kt_i'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }
            if(type == 'pembangunan'){
                var link = '<?= site_url('accounting/reject_pembangunan_admin/'); ?>';
            }
            if(type == 'fee_marketing') {
                var link = '<?= site_url('accounting/reject_fee_marketing/'); ?>';
            }
            if(type == 'pembebasan'){
                var link = '<?= site_url('accounting/RejectPembebasanLahan'); ?>';
            }
            if(type == 'pengeluaran'){
                var link = '<?= site_url('accounting/rejectPengeluaranLain'); ?>';
            }
            if(type == 'rabMaterial'){
                var link = '<?= site_url('accounting/rejectRABMaterial'); ?>';
            }
            if(type == 'rabUpah'){
                var link = '<?= site_url('accounting/rejectRABUpah'); ?>';
            }
            if(type == 'rabLain'){
                var link = '<?= site_url('accounting/rejectRABLain'); ?>';
            }
            if(type == 'insidentil'){
                var link = '<?= site_url('accounting/rejectInsidentil'); ?>';
            }
            if(type == 'material'){
                var link = '<?= site_url('accounting/rejectMaterial'); ?>';
            }
            if(type == 'batal'){
                var link = '<?= site_url('accounting/rejectBatal'); ?>';
            }
            if(type == 'b_tj'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }
            if(type == 'i_tj'){
                var link = '<?= site_url('pemasukan/reject_pemasukan/'); ?>';
            }
            if(type == 'kas'){
                var link = '<?= site_url('accounting/rejectKas'); ?>';
            }
            if(type == 'pemasukan'){
                var link = '<?= site_url('accounting/reject_pemasukan_lain'); ?>';
            }
            $.ajax({
                url: link,
                dataType: 'JSON',
                data: {id:id, tipe:tipe},
                type: 'POST',
                success: function(d){
                    Swal.fire(d.msg);
                }
            });
        });

    </script>