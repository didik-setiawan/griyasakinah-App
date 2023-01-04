<div class="row justify-content-end mb-2">
    <a href="<?= site_url('accounting/printArusKas?date_A='.$date_A.'&date_B='.$date_B.'&perum='.$id_perum.'/'); ?>" target="_blank" class="btn btn-success mr-2  <?php only_accounting(); ?>"> <i class="fa fa-print"></i> Print</a>
</div>
<table class="table table-bordered">
    <thead>
        <tr class="bg-dark text-light">
            <th>#</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php $totalAll=0; $i=1; foreach($list as $l){ 
            $totalAll += $l->jumlah;
        ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?php $date = date_create($l->tanggal); echo date_format($date,'d F Y'); ?></td>
            <td><?= $l->deskripsi ?></td>
            <td>Rp. <?= number_format($l->jumlah) ?></td>
        </tr>
        <?php } ?>
        <tr class="bg-warning">
            <th colspan="3">Total</th>
            <th>Rp. <?= number_format($totalAll); ?></th>
        </tr>
    </tbody>
</table>