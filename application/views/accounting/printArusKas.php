<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Laporan Arus Kas</title>
    <style>

        #thead {
            border-collapse: collapse;
            border: none;
        }
        #thead tr th{
            border-collapse: collapse;
            border: none;
            font-family: sans-serif;
        }
        #thead  {
            border: none;
            
        }

       #Tcontent {
        border-collapse: collapse;
        font-family: sans-serif;
       }

       #HeadT tr th {
        padding: 5px 10px;
        background: #c7c7c7;
       }

       #BodyT tr td {
            padding: 3px 4px;
       }

    </style>
</head>
<body>

    <table border="1" width="100%" id="thead">
        <tr>
            <th><img src="<?= base_url('assets/img/g1.png'); ?>" width="70px"></th>
            <th>
                <b style="font-size: 20px">Laporan Arus Kas</b><br>
                <span>Perumahan <?= $perumahan->nama_perumahan ?><span><br>
                <span>Bulan <?php $date = date_create($date_A); echo date_format($date, 'F Y') ?></span>
            </th>
            <th><img src="<?= base_url('assets/img/') . $this->session->userdata('logo_perumahan'); ?>" width="70px"></th>
        </tr>
    </table>
    

    <table style="margin-top: 30px" id="Tcontent" border="1" width="100%">
        <thead id="HeadT">
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody id="BodyT">
            <?php  $totalAll=0; $i=1; foreach($list as $l){ 
                $totalAll += $l->jumlah;    
            ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?php $date = date_create($l->tanggal); echo date_format($date,'d F Y'); ?></td>
                    <td><?= $l->deskripsi ?></td>
                    <td>Rp. <?= number_format($l->jumlah) ?></td>
                </tr>
            <?php } ?>
                <tr style="background: #FFF566;">
                    <th colspan="3">Total</th>
                    <th>Rp. <?= number_format($totalAll); ?></th>
                </tr>
        </tbody>
    </table>

    <table width="100%" style="text-align: center; margin-top: 20px">
        <tr>
            <td style="text-align: left">
            <span><?= $perumahan->kabupaten .', '. date('d F Y') ?></span>
                <p>Menyetujui</p>
                <br><br><br><br> <br>

                ---------------- <br>
                <span>Direktur</span>
            </td>
            <td style="text-align: right">
                <br>
                <p>Di Buat Oleh</p>
                <br><br><br><br>
                <?= $user->nama ?> <br>
                ---------------- <br>
                <span>Accounting</span>
            </td>
        </tr>
    </table>

</body>
</html>