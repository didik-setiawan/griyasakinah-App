<div class="row justify-content-end mr-2 mb-2">
    <a href="<?= site_url('accounting/printLaporanBulanan?perum='.$perum.'&date_A='.$date_A.'&date_B='.$date_B.'/') ; ?>" target="_blank" class="btn btn-success <?php only_accounting(); ?>"><i class="fa fa-print"></i> Print</a>
</div>
<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th width="10%">Kode</th>
            <th>Akun</th>
            <th>Kredit</th>
            <th>Debit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($kode as $k){ ?>
        <tr class="bg-secondary">
            <td><?= $k->kode ?></td>
            <td colspan="3"><?= $k->deskripsi_kode ?></td>
        </tr>

        <?php 
            $sub_kode = $this->db->order_by('sub_kode','ASC')->get_where('sub_kode',['id_kode' => $k->id_kode])->result();
            foreach($sub_kode as $sk){
        ?>
            <tr style="background: #c1c1c1">
                <td><?= $k->kode .'.'. $sk->sub_kode ?></td>
                <td colspan="3"><?= $sk->deskripsi_sub_kode ?></td>
            </tr>



            <?php
                $title_kode = $this->db->order_by('kode_title','ASC')->get_where('title_kode',['id_sub' => $sk->id_sub])->result();
                foreach($title_kode as $tk){

                    $q = "SELECT SUM(jumlah) as total_all FROM approved_history WHERE id_perumahan = $perum AND id_title_kode = $tk->id_title AND tanggal BETWEEN '".$date_A."' AND '".$date_B."'";
                    $kredit = $this->db->query($q)->row()->total_all;

            ?>

                <tr>
                    <td><?= $k->kode .'.'. $sk->sub_kode .'.'. $tk->kode_title ?></td>
                    <td><?= $tk->deskripsi ?></td>

                    <?php if($k->kode == 1){ ?>
                        <td></td>
                        <td>Rp. <?= number_format($kredit); ?></td>
                    <?php } else if($k->kode == 2){ ?>
                        <td>Rp. <?= number_format($kredit); ?></td>
                        <td></td>
                    <?php } ?>
                </tr>
            <?php } ?>

        <?php } ?>
        <?php } ?>

        
    <?php foreach($kode as $k){ ?>
        <?php
            $q = "SELECT SUM(jumlah) as total FROM approved_history JOIN 
            title_kode ON approved_history.id_title_kode = title_kode.id_title JOIN
            sub_kode ON title_kode.id_sub = sub_kode.id_sub JOIN
            kode ON sub_kode.id_kode = kode.id_kode
            WHERE approved_history.id_perumahan = $perum AND
           kode.id_kode = $k->id_kode AND tanggal BETWEEN '".$date_A."' AND '".$date_B."'
        ";
            $total_All = $this->db->query($q)->row();
        ?>
        <tr style="background: #F2E879;">
            <th colspan="2">Total <?= $k->deskripsi_kode ?></th>
            <th colspan="2">Rp. <?= number_format($total_All->total) ?></th>
        </tr>
    <?php } ?>






        
        
        

        

    </tbody>
</table>
