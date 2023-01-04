<div style="text-align: center">
    <h3>Pengeluaran Lain-lain</h3>
</div>
<p>Tanggal : <?= $from ?> - <?= $to ?></p>
<table border="1" cellpadding="7">
    <thead>
        <tr>
            <th>#</th>
            <th>Tgl Pengeluaran</th>
            <th>Keterangan</th>
            <th>Jumlah Pengeluaran</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; foreach($data as $d){ ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $d->tgl_pengeluaran ?></td>
                <td><?= $d->keterangan ?></td>
                <td>Rp. <?= number_format($d->jml_pengeluaran) ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tr>
        <th colspan="3">Total</th>
        <th>Rp. <?= number_format($total); ?></th>
    </tr>
</table>