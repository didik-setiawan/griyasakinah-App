<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Rekap Konsumen</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a href="<?= site_url('marketing/konsumen'); ?>" class="btn btn-sm btn-primary mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th class="text-left">Dapat informasi</th>
                                    <th class="text-right">Jumlah konsumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($info as $f){ 
                                    $id_perum = $this->session->userdata('id_perumahan');
                                    $bank = $this->db->select('*')->from('tbl_marketing')->join('tbl_transaksi_bank','tbl_marketing.id_marketing = tbl_transaksi_bank.id_konsumen')->join('tbl_kavling','tbl_transaksi_bank.id_rumah = tbl_kavling.id_kavling')->where('tbl_kavling.id_perum', $id_perum)->where('tbl_marketing.status !=', 0)->where('tbl_marketing.dapat_info', $f)->get()->num_rows();

                                    $inhouse = $this->db->select('*')->from('tbl_marketing')->join('tbl_transaksi_inhouse','tbl_marketing.id_marketing = tbl_transaksi_inhouse.id_konsumen')->join('tbl_kavling','tbl_transaksi_inhouse.id_rumah = tbl_kavling.id_kavling')->where('tbl_kavling.id_perum', $id_perum)->where('tbl_marketing.status !=', 0)->where('tbl_marketing.dapat_info', $f)->get()->num_rows();

                                    $total = $bank + $inhouse;
                                ?>
                                <tr>
                                    <td><?= $f ?></td>
                                    <td class="text-right"><?= $total ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>