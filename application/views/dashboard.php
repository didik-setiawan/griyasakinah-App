<?php $role = $this->session->userdata('group_id'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard <?= $perumahan['nama_perumahan'] ?></h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<?php if($role == 1){ ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h3 class="card-title">Konfirmasi Super Admin</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body ConfirmTransaksi" style="display: block;">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>



<!-- <div class="ConfirmTransaksi">
    
</div> -->



<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
           

            <!-- <div class="col-sm-12">
                <div class="card card-widget widget-user">
                    <div class="widget-user-header bg-secondary">
                        <?php
                        // $tanggal = date('Y-m-d');
                        $date = date_create(date('Y-m-d'));
                        $tanggal = date_format($date, "j F Y");

                        $saldo = $this->ajax_saldo_model->getSaldoInOut();
                        $sa = $this->ajax_saldo_model->getSaldoAwal();
                        ?>

                        <h3 class="widget-user-username">Laporan Keuangan</h3>
                        <h5 class="widget-user-desc">Kondisi terakhir - <?= $tanggal ?></h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="<?= site_url('uploads/img/profit.jpg') ?>"
                            alt="Laporan Keuangan">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header"><?= rupiah($sa->saldo_awal) ?></h5>
                                    <span class="description-text">Saldo Awal</span>
                                </div>
                            </div>
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header text-blue"><?= rupiah($saldo->pemasukan) ?></h5>
                                    <span class="description-text text-blue">Pemasukkan</span>
                                </div>
                            </div>
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header text-red"><?= rupiah($saldo->pengeluaran) ?></h5>
                                    <span class="description-text text-red">Pengeluaran</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="description-block">
                                    <h5 class="description-header"><?= rupiah($sa->saldo_awal + $saldo->saldo_akhir) ?>
                                    </h5>
                                    <span class="description-text">Saldo Akhir</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->


            <?php
                $date = date_create(date('Y-m-d'));
                $tanggal = date_format($date, 'd F Y');
                $tanggal2 = date_format($date, 'F Y');
                $month = date('m');
                $year = date('Y');
                // $keuangan1 = $this->master_model->get_laporan_keuangan1();
                $kode = $this->db->get('kode')->result();
                $id_perumahan = $this->session->userdata('id_perumahan');
                $proyek = $this->master_model->get_proyek_dashboard();
                // var_dump($proyek);
            ?>

           <?php if($role == 3 || $role == 1 || $role == 2){ ?>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5><b>Laporan Keuangan</b></h5>
                        <h6>Kondisi Terakhir : <?= $tanggal; ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <?php foreach($kode as $k){ 
                                $q = "SELECT SUM(jumlah) as total FROM approved_history JOIN 
                                     title_kode ON approved_history.id_title_kode = title_kode.id_title JOIN
                                     sub_kode ON title_kode.id_sub = sub_kode.id_sub JOIN
                                     kode ON sub_kode.id_kode = kode.id_kode
                                     WHERE approved_history.id_perumahan = $id_perumahan AND
                                    kode.id_kode = $k->id_kode
                                 ";
                                $jml = $this->db->query($q)->row();
                            ?>
                                <div class="col-6">
                                    <h5 class="text-dark"><b><?= $k->deskripsi_kode ?></b></h5>
                                    <p>Rp. <?= number_format($jml->total) ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-success">
                        <h5><b>Laporan Keuangan</b></h5>
                        <h6>Per <?= $tanggal2 ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                                <?php foreach($kode as $k){ 
                                    $q = "SELECT SUM(jumlah) as total FROM approved_history JOIN 
                                        title_kode ON approved_history.id_title_kode = title_kode.id_title JOIN
                                        sub_kode ON title_kode.id_sub = sub_kode.id_sub JOIN
                                        kode ON sub_kode.id_kode = kode.id_kode
                                        WHERE approved_history.id_perumahan = $id_perumahan AND
                                        kode.id_kode = $k->id_kode AND
                                        month(approved_history.tanggal) = '$month' AND 
                                        year(approved_history.tanggal) = '$year'                                
                                        ";
                                    $tot = $this->db->query($q)->row();
                                ?>
                                <div class="col-6">
                                    <h5 class="text-dark"><b><?= $k->deskripsi_kode ?></b></h5>
                                    <p>Rp. <?= number_format($tot->total) ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
           

            <?php 
                $q1 = "SELECT 
                    tbl_marketing.status ,
                    tbl_marketing.status as status_marketing ,
                    tbl_transaksi_bank.status ,
                    tbl_transaksi_bank.status as status_bank ,
                    tbl_kavling.id_perum 
                    FROM tbl_marketing , tbl_transaksi_bank, tbl_kavling
                    WHERE tbl_marketing.id_marketing = tbl_transaksi_bank.id_konsumen AND
                    tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND
                    tbl_kavling.id_perum = $id_perumahan AND
                    tbl_marketing.status != 0
                ";
                $q11 = "SELECT 
                    tbl_marketing.status ,
                    tbl_marketing.status as status_marketing ,
                    tbl_transaksi_bank.status ,
                    tbl_transaksi_bank.status as status_bank ,
                    tbl_kavling.id_perum 
                    FROM tbl_marketing , tbl_transaksi_bank, tbl_kavling
                    WHERE tbl_marketing.id_marketing = tbl_transaksi_bank.id_konsumen AND
                    tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling AND
                    tbl_kavling.id_perum = $id_perumahan AND
                    tbl_marketing.status = 8
                ";

                $q2 = "SELECT 
                    tbl_marketing.status ,
                    tbl_marketing.status as status_marketing ,
                    tbl_transaksi_inhouse.status ,
                    tbl_transaksi_inhouse.status as status_inhouse ,
                    tbl_kavling.id_perum 
                    FROM tbl_marketing , tbl_transaksi_inhouse, tbl_kavling
                    WHERE tbl_marketing.id_marketing = tbl_transaksi_inhouse.id_konsumen AND
                    tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND
                    tbl_kavling.id_perum = $id_perumahan AND
                    tbl_marketing.status != 0
                ";
                $q22 = "SELECT 
                    tbl_marketing.status ,
                    tbl_marketing.status as status_marketing ,
                    tbl_transaksi_inhouse.status ,
                    tbl_transaksi_inhouse.status as status_inhouse ,
                    tbl_kavling.id_perum 
                    FROM tbl_marketing , tbl_transaksi_inhouse, tbl_kavling
                    WHERE tbl_marketing.id_marketing = tbl_transaksi_inhouse.id_konsumen AND
                    tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling AND
                    tbl_kavling.id_perum = $id_perumahan AND
                    tbl_marketing.status = 8
                ";
                $jml_kavling = $this->db->where(['status_kavling' => 0, 'id_perum' => $id_perumahan])->get('tbl_kavling')->num_rows();

                $transkasi_inhouse = $this->db->query($q2)->num_rows();
                $transaksi_bank = $this->db->query($q1)->num_rows();
                $transaksi_bank_r = $this->db->query($q11)->num_rows();
                $transaksi_inhouse_r = $this->db->query($q22)->num_rows();

                $jml_konsumen = $transaksi_bank + $transkasi_inhouse;
                $jml_realisasi = $transaksi_bank_r + $transaksi_inhouse_r;
                
            ?>

            <?php if($role == 4 || $role == 1 || $role == 2){ ?>
            <div class="col-lg-4">
                <div class="card bg-danger text-light">
                    <div class="card-body text-center">
                        <h5><i class="fas fa-users"></i> Jumlah Konsumen</h5>
                        <p class="mt-4"><?= $jml_konsumen ?> Konsumen</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card bg-success text-light">
                    <div class="card-body text-center">
                        <h5><i class="fas fa-user-check"></i> Konsumen Realisasi</h5>
                        <p class="mt-4"><?= $jml_realisasi ?> Konsumen</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card bg-info text-light">
                    <div class="card-body text-center">
                        <h5><i class="fas fa-home"></i> Kavling Tersedia</h5>
                        <p class="mt-4"><?= $jml_kavling ?> Kavling</p>
                    </div>
                </div>
            </div>
            <?php } ?>


            <?php $material = $this->logistik->get_rekap_material()->result(); ?>
            <?php if($role == 5 || $role == 1 || $role == 2){ ?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-secondary text-light">
                        <b style="font-size: 20px">Stok Material</b>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-info text-light">
                                    <th>Nama Material</th>
                                    <th class="text-right">Sisa Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($material as $m){ 
                                    $q_masuk_ulang = "SELECT SUM(stok) as st FROM logistik_stok WHERE type = 1 AND stok_id = $m->id_stok";
                                    $masukUlang = $this->db->query($q_masuk_ulang)->row()->st;
                                    $stok = $masukUlang + $m->stok_logistik;
                                ?>
                                <tr>
                                    <td><b><?= $m->nama_material ?></b><br> <small class="text-danger"><?= $m->kategori_produk ?></small></td>
                                    <td class="text-right">
                                        <?php if($stok == 0){ ?>
                                            <span class="badge badge-danger">Kosong</span>
                                        <?php } else { ?>
                                            <span class="badge badge-primary"><?= $stok .' '. $m->nama_satuan ?></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php } ?>

            
            <?php if($role == 6 || $role == 1 || $role == 2){ ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <b style="font-size: 20px">Progres Proyek</b>
                    </div>
                    <div class="card-body">

                <?php if($proyek){ ?>
                        <?php foreach($proyek as $pr){
                            $kavling_proyek = $this->master_model->get_kavling_progres_proyek_dashboard($pr->id_proyek);    
                        ?>
                        <table class="table table-bordered mb-3">
                            <tr class="bg-dark">
                                <th colspan="3"><?= $pr->nama_proyek ?></th>
                            </tr>
                            <tr class="bg-info">
                                <th>#</th>
                                <th>Kavling</th>
                                <th>Progres</th>
                            </tr>
                            <?php $i=1; foreach($kavling_proyek as $kp){ 
                                $progres = $this->master_model->get_progres_kavling($kp->id_kavling);  
                               
                            ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $kp->blok . $kp->no_rumah ?></td>
                                <td>

                                    <?php 
                                        if($progres){
                                        $persentase = $progres->progres;
                                    ?>
                                        <span class="small text-bold">Progress : <?= $persentase ?>%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: <?= $persentase ?>%">
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <span class="small text-bold">Progress : 0%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 0%">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    


                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                        <?php } ?>

                <?php } else { ?>
                    <p class="text-center">No data result</p>
                <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
          



























            <!-- <div class="col-sm-6">
                <div class="card card-widget widget-user-2">
                    <div class="widget-user-header bg-gradient-success">
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="<?= site_url('uploads/img/image_po.jpg') ?>"
                                alt="Inventaris - Stok Terbanyak">
                        </div>
                        <h3 class="widget-user-username">BAHAN BANGUNAN</h3>
                        <h5 class="widget-user-desc">Stok Terbanyak</h5>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <?php
                            $stok = $this->inventaris_model->topStok();
                            if ($stok->num_rows() > 0) {
                                foreach ($stok->result() as $key => $row) {
                                    if ($row->total_stok == 0) {
                                        $status = 'danger';
                                    } else {
                                        $status = 'primary';
                                    }
                            ?>
                            <li class="nav-item">
                                <a href="<?= site_url('inventaris/laporan/') ?>" class="nav-link">
                                    <?= $row->nama_produk ?> <span
                                        class="float-right badge bg-<?= $status ?>"><?= $row->total_stok ?>
                                        <?= $row->nama_satuan ?></span>
                                </a>
                            </li>
                            <?php
                                }
                            } else {
                                ?>
                            <li class="nav-item">
                                <span class="nav-link">
                                    tidak ada data...
                                </span>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card card-widget widget-user-2">
                    <div class="widget-user-header bg-gradient-success">
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="<?= site_url('uploads/img/image_cart.jpg') ?>"
                                alt="RAB 3 Bulan Kedepan">
                        </div>
                        <h3 class="widget-user-username">PROGRESS PROYEK</h3>
                        <h5 class="widget-user-desc">3 Bulan Kedepan</h5>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <?php
                            // $id = NULL, $status = NULL, $lembaga = NULL, $limit = NULL
                            $rab = $this->rab_model->getRAB(NULL, 1, NULL, 1);
                            if ($rab->num_rows() > 0) {
                                foreach ($rab->result() as $key => $row) {
                                    $realisasi = 0;
                                    $real = $this->rab_model->getDetailRAB(NULL, 5, NULL, idLembaga(), NULL, $row->id);
                                    foreach ($real->result() as $key => $value) {
                                        $realisasi += $value->total;
                                    }
                                    $target = $row->total_anggaran;
                                    if ($target > 0) {
                                        $persentasi = round($realisasi / $target * 100, 2);
                                    } else {
                                        $persentasi = 0;
                                    }

                            ?>
                            <li class="nav-item">
                                <a href="<?= site_url('rab/list/') ?>" class="nav-link">
                                    <?= $row->judul_rab ?>
                                    <div class="progress-group float-right">
                                        <span class="small text-bold">Progress : <?= $persentasi ?>%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: <?= $persentasi ?>%">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php
                                }
                            } else {
                                ?>
                            <li class="nav-item">
                                <span class="nav-link">
                                    tidak ada data...
                                </span>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>
<!-- /.content -->

<div class="confirm-msg"  value="" data-group="<?= $this->session->userdata('group_id'); ?>"></div>


   <!-- Modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    
        <div class="listDetail">
            <div class="text-center">

            <div class="spinner-border text-danger" role="status">
                <span class="sr-only">Loading...</span>
            </div>

            </div>
        </div>

      </div>
    </div>
  </div>
</div>