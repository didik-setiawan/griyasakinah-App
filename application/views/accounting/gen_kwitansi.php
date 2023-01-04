
<?php
  $perum = $this->db->get_where('tbl_perumahan',['id_perumahan' => $data->id_perum])->row();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design Kwitansi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Marck+Script&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Murecho:wght@600&display=swap" rel="stylesheet">


    <style>
        .content {
            border-top: 10px solid #160066;
            border-bottom: 10px solid #160066;
            border-left: 1px solid #160066;
            border-right: 1px solid #160066;
            padding: 20px;
            
        }
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .nama-perum {
            font-family: Cursive;
            font-size: 15px;
            color: #160066;
        }

        .isi-kwitansi {
            font-size: 11px;
            font-family: sans-serif;
        }

        .kwitansi {
            font-family: 'Murecho', sans-serif;
            font-size: 20px;
        }

        .isi {
            padding: 1px;
            font-family: sans-serif;
            font-size: 12px;
        }

        .nominal {
            border: 1px solid #666666;
            padding: 3px 10px 3px 10px;
            border-radius: 3px;
        }
        .nominal-area {
            font-size: 13px;
        }


    </style>

</head>
<body>

    <div class="content">
        <table width="100%">
            <tr>
                <td class="text-center" width="7%">
                    <img src="<?= base_url('assets/img/g1.png'); ?>" width="40px" alt="logo">
                </td>
                <td width="30%" class="text-center"><b class="nama-perum">Perumahan <?= $perum->nama_perumahan ?></b> <br> <small style="font-family: sans-serif; font-size: 10px;"><?= $perum->alamat_perumahan ?></small></td>
                <td class="text-center"><b class="kwitansi">Kwitansi</b></td>
                <td width="30%" class="text-right">
                    <span class="no-kwitansi"><b class="isi-kwitansi">No: <?= $data->id_marketing; echo "/"; ?><?= date('m'); echo "/";?><?= date('Y'); ?></b></span>
                </td>
                <td class="text-center" width="7%">
                    <img src="<?= base_url('assets/img/') . $perum->logo; ?>" width="40px" alt="">
                </td>
            </tr>
        </table>

        <table style="margin-top: 10px;" width="100%">
            <tr>
                <td width="20%" class="isi">Telah Terima Dari</td>
                <td class="isi">: <?= $data->nama_konsumen ?></td>
            </tr>
            <tr>
                <td class="isi">Jumlah Uang</td>
                <td class="isi">:</td>
            </tr>
            <tr>
                <td class="isi">Untuk Pembayaran</td>
                <td class="isi">: <?= $tipe ?></td>
            </tr>
            <tr>
                <td class="isi">Tipe Rumah</td>
                <td class="isi">: LB <?= $data->lb ?>, LT <?= $data->lt ?>, Blok <?= $data->blok.$data->no_rumah ?></td>
            </tr>
        </table>

        <table width="100%">
            <tr class="isi">
                <td width="60%"><i class="nominal-area">Terbilang Rp.</i>  <b class="nominal nominal-area"> 

                        <?php
                            echo number_format($data->jumlah);
                        ?>

                </b> </td>
                <td width="30%" class="text-center"><?= $perum->kabupaten ?> , <?php date_default_timezone_set('Asia/Jakarta'); echo date('d F Y'); ?><br>Penerima
                    <br><br><br><br><br> 
                    <?= $this->session->userdata('nama'); ?>
                </td>
            </tr>
        </table>
        
        
    </div>
    <hr>

</body>
</html>