<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .theTable {
            border-collapse: collapse;
        }

        .tBorderthead, th{
            border: 1px solid #999;
            padding: 8px 20px;  
            background: #4a4a4a;
            color: #ffffff;
            font-family: sans-serif;
        }

        .tbodytr td {
            border: 1px solid #999;
            padding: 8px 20px;
            font-family: sans-serif;
            background: #828282;
            color: #ffffff;
        }

        .tbodytr1 td {
            border: 1px solid #999;
            padding: 8px 20px;
            font-family: sans-serif;
            background: #d9d7d7;
            color: #303030;
        }

        .tbodytr2 td {
            border: 1px solid #999;
            padding: 8px 20px;
            font-family: sans-serif;
        }

        

    </style>
    <title>Laporan Bulanan</title>
    
</head>
<body>
    
    <table width="100%" style="text-align: center; margin-bottom: 30px;">
        <tr>
            <td><img src="<?= base_url('assets/img/g1.png'); ?>" width="70px"></td>
            <td>
                <b style="font-size: 20px">Laporan Keuangan Bulanan</b><br>
                <span>Perumahan <?= $perumahan->nama_perumahan ?><span><br>
                <span>Bulan <?php $date = date_create($date_A); echo date_format($date, 'F Y') ?></span>
            </td>
            <td><img src="<?= base_url('assets/img/') . $this->session->userdata('logo_perumahan'); ?>" width="70px"></td>
        </tr>
    </table>


    <table class="theTable" style="margin-bottom: 30px" width="100%" border="1">
        <thead>
            <tr class="tBorderthead">
                <th width="14%">Kode</th>
                <th>Akun</th>
                <th>Kredit</th>
                <th>Debit</th>
            </tr>
        </thead>
        <tbody>
            
        <?php foreach($kode as $k){ ?>
            <tr class="tbodytr">
                <td><?= $k->kode ?></td>
                <td colspan="3"><?= $k->deskripsi_kode ?></td>
            </tr>


            <?php 
                $sub_kode = $this->db->order_by('sub_kode','ASC')->get_where('sub_kode',['id_kode' => $k->id_kode])->result();
                foreach($sub_kode as $sk){
            ?>
                <tr class="tbodytr1">
                    <td><?= $k->kode .'.'. $sk->sub_kode ?></td>
                    <td colspan="3"><?= $sk->deskripsi_sub_kode ?></td>
                </tr>


                <?php
                $title_kode = $this->db->order_by('kode_title','ASC')->get_where('title_kode',['id_sub' => $sk->id_sub])->result();
                foreach($title_kode as $tk){

                    $q = "SELECT SUM(jumlah) as total_all FROM approved_history WHERE id_perumahan = $perum AND id_title_kode = $tk->id_title AND tanggal BETWEEN '".$date_A."' AND '".$date_B."'";
                    $kredit = $this->db->query($q)->row()->total_all;
                ?>

                    <tr class="tbodytr2">
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

    <table width="100%">
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
                <?= $user->nama ?>
                <br>
                ---------------- <br>
                <span>Accounting</span>
            </td>
        </tr>
    </table>

</body>
</html>
