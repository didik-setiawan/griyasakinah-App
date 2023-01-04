<table class="table table-bordered">
    <thead>
        <tr>
            <th>Perumahan</th>
            <td><?= $data->nama_perumahan ?></td>
        </tr>
        <tr>
            <th>Nama Penjual</th>
            <td><?= $data->nama_penjual ?></td>
        </tr>
        <tr>
            <th>No Surat</th>
            <td><?= $data->no_surat ?></td>
        </tr>
        <tr>
            <th>Jenis Surat</th>
            <td><?= $data->jenis_surat ?></td>
        </tr>
        <tr>
            <th>Tanggal Pengalihan</th>
            <td><?php
                $date = date_create($data->tgl_pengalihan);
                echo date_format($date, 'd M Y');
            ?></td>
        </tr>
    </thead>
</table>