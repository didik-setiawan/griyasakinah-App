<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #heading1 {
            font-size: 20px;
        }

        table {
            border-collapse: collapse;
        }

    </style>
    <title>Laporan Material Keluar</title>
</head>
<body>
    
    <center>
        <span><b id="heading1">Laporan Material Keluar</b></span> <br>
        <span id="heading2">Perumahan <?= $perum->nama_perumahan ?></span>
    </center>

        <hr>
        <br>
        <span>Kavling <?= $perum->blok . $perum->no_rumah ?></span>
       
        <table width="100%" border="1">
            <tr>
                <th>Nama Material</th>
                <th>Satuan</th>
                <th>Jumlah Keluar</th>
            </tr>

            <?php foreach($jenis_material as $jm){
                $id_jenis = $jm->id;
                $material = $this->logistik->getMaterialKeluar($id_pro, $id_kavling, $id_jenis)->result();
            ?>
            <tr>
                <td><b><?= $jm->kategori_produk ?></b></td>
                <td></td>
                <td></td>
            </tr>

                <?php foreach($material as $m){ 
                    $jml_out = $this->logistik->getMaterialKeluar($id_pro, $id_kavling, $id_jenis)->row()->keluar;
                ?>
                <tr>
                    <td><?= $m->nama_material ?></td>
                    <td><?= $m->nama_satuan ?></td>
                    <td><?= $jml_out ?></td>
                </tr>
                <?php } ?>

            <?php } ?>
        </table>

                    <br><br>

        <table width="100%">
            <tr>
                <td>
                    <b>Diperiksa oleh</b> <br><br><br><br>
                    .......................
                </td>
                <td style="text-align: right">
                    <b>Dibuat oleh</b> <br> <br><br><br><br>
                    .......................
                </td>
            </tr>
        </table>

<script>
    window.print();
</script>
</body>
</html>