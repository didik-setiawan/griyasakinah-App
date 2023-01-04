<div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <td><?= $detail->nama_proyek ?></td>
                </tr>
                <tr>
                    <th>Tipe</th>
                    <td><?= $detail->tipe ?></td>
                </tr>
                <tr>
                    <th>Blok</th>
                    <td><?= $detail->blok . $detail->no_rumah ?></td>
                </tr>
                <tr>
                    <th>Cluster</th>
                    <td><?= $detail->nama_cluster ?></td>
                </tr>
                <tr>
                    <th>Harga Kontrak per Blok</th>
                    <td>Rp. <?= number_format($detail->harga_kontrak); ?></td>
                </tr>
            </thead>
        </table>
    </div>
    <div class="col-lg-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <td><?= $detail->tanggal ?></td>
                </tr>
                <tr>
                    <th>Progres Pembangunan</th>
                    <td><?= $detail->progres ?>%</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>Rp. <?= number_format($detail->total) ?></td>
                </tr>
                
                <tr>
                    <th colspan="2">
                        <img src="<?= base_url('assets/upload/progres/') . $detail->foto; ?>" alt="foto-progres" width="100%">
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>