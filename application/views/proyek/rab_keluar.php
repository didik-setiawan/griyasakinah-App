<script text="javascript">
    $('#tabel_material').dataTable();
    $('#tabel_belanja').dataTable();
    $('#list_kavling').dataTable();

    $(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
        $("#check-all").click(function(){ // Ketika user men-cek checkbox all
        if($(this).is(":checked"))// Jika checkbox all diceklis
            $(".check-item").prop("checked", true); // ceklis semua checkbox siswa dengan class "check-item"
        else // Jika checkbox all tidak diceklis
            $(".check-item").prop("checked", false); // un-ceklis semua checkbox siswa dengan class "check-item"
        });

        $("#check-all-btl").click(function(){ // Ketika user men-cek checkbox all
        if($(this).is(":checked"))// Jika checkbox all diceklis
            $(".check-belanja").prop("checked", true); // ceklis semua checkbox siswa dengan class "check-item"
        else // Jika checkbox all tidak diceklis
            $(".check-belanja").prop("checked", false); // un-ceklis semua checkbox siswa dengan class "check-item"
        });
        
        $("#btn-edit").click(function(){ // Ketika user mengklik tombol delete
        var confirm = window.confirm("Apakah Anda Yakin Ingin Mengeluarkan Material ini?"); // Buat sebuah alert konfirmasi
        if(confirm) // Jika user mengklik tombol "Ok"
            $("#form-edit").submit(); // Submit form
        });
        $("#btn-batal").click(function(){ // Ketika user mengklik tombol delete
        var confirm_belanja = window.confirm("Apakah Anda Yakin Ingin Belanja Material ini?"); // Buat sebuah alert konfirmasi
        if(confirm_belanja)
            $("#form-belanja").submit();
        });
    });
</script>

<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Material Keluar</a>
    </li>

    <li class="nav-item" role="presentation">
        <a class="nav-link " id="pills-belanja-tab" data-toggle="pill" href="#pills-belanja" role="tab" aria-controls="pills-belanja" aria-selected="false">Belanja Bahan</a>
    </li>

    <li class="nav-item" role="presentation">
        <a class="nav-link " id="pills-rekap-tab" data-toggle="pill" href="#pills-rekap" role="tab" aria-controls="pills-rekap" aria-selected="false">Kavling</a>
    </li>
</ul>
<hr>

<div class="tab-content" id="pills-tabContent">

    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <form method="post" action="<?= site_url('logistik/submit_keluar/'); ?>" id="form-edit">
        <table class="table table-bordered table-striped" id="tabel_material">
            <thead>
                <tr class="text-light bg-dark">
                    <th>
                    <input id="check-all" type="checkbox">
                    &nbsp;
                    &nbsp;
                        <button class="btn btn-primary btn-xs" id="btn-edit">
                            <i class="fa fa-paper-plane" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Keluarkan Material"></i>
                            Keluarkan
                        </button>    
                    </th>
                    <th class="text-center">Nama Material</th>
                    <th class="text-center">Banyaknya</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Harga Satuan</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i = 1; 
            foreach ($detail as $key => $row){
            ?>
                <tr>
                    <?php if($row->keluar == 1) {
                        $warna = 'primary';
                        $a = 'Success';
                        $keluarkan = '
                        <input type="checkbox" disabled>
                        ';
                    }else{
                        $warna = 'danger';
                        $a = '-';
                        $keluarkan = '
                        <input class="check-item" type="checkbox" name="id[]" value="'.$row->id.'">
                        ';
                    }
                    ?>
                    <td><?= $keluarkan ?></td>
                    <td>
                    <span class="text-bold"><?= $row->nama_material?></span><br>
                    <span class="small text-danger"><?= $row->kategori_produk ?></span><br>
                    </td>
                    <td class="text-center"><?= $row->quantity ?>  <?= $row->nama_satuan ?></td>
                    <td class="text-center"><span class="badge badge-<?=$warna?> text-uppercase"><?=$a?></span>
                    </td>
                    <td class="text-right">Rp. <?= rupiah2($row->harga) ?></td>
                    <td class="text-right">Rp. <?= rupiah2($row->total) ?></td>
                </tr>
            <?php 
            }
            ?>
            </tbody>

            <?php
                $jumlahTotal = 0;
                
            foreach ($detail as $key => $row) {
                $jumlahTotal += $row->total;
            }
            ?>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right">Jumlah Total :</th>
                        <th class="text-right">Rp. <?=rupiah2($jumlahTotal)?></th>
                    </tr>
                </tfoot>
        </table>
        </form>
    </div>

    <div class="tab-pane fade" id="pills-belanja" role="tabpanel" aria-labelledby="pills-belanja-tab">
        <form method="post" action="<?= site_url('logistik/submit_belanja/'); ?>" id="form-belanja">
        <table class="table table-bordered table-striped" id="tabel_belanja">
            <thead>
                <tr class="text-light bg-dark">
                    <th>
                    <input id="check-all-btl" type="checkbox">
                    &nbsp;
                    &nbsp;
                        <button class="btn btn-success btn-xs" id="btn-batal">
                            <i class="fa fa-shopping-cart" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Batalkan Material"></i>
                            Belanja
                        </button>    
                    </th>
                    <th class="text-center">Nama Material</th>
                    <th class="text-center">Banyaknya</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Harga Satuan</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i = 1; 
            foreach ($detail as $key => $row){
            ?>
                <tr>
                    <?php if($row->belanja == 1) {
                        $war = 'success';
                        $b = 'Success';
                        $belanja = '
                        <input type="checkbox" disabled>
                        ';
                    }else{
                        $war = 'danger';
                        $b = '-';
                        $belanja = '
                        <input class="check-belanja" type="checkbox" name="id_bel[]" value="'.$row->id.'">
                        ';
                        
                    }
                    ?>
                    <td><?= $belanja ?></td>
                    <td>
                    <span class="text-bold"><?= $row->nama_material?></span><br>
                    <span class="small text-danger"><?= $row->kategori_produk ?></span><br>
                    </td>
                    <td class="text-center"><?= $row->quantity ?>  <?= $row->nama_satuan ?></td>
                    <td class="text-center">
                    <span class="badge badge-<?=$war?> text-uppercase"><?=$b?></span>
                    </td>
                    <td class="text-right">Rp. <?= rupiah2($row->harga) ?></td>
                    <td class="text-right">Rp. <?= rupiah2($row->total) ?></td>
                </tr>
            <?php 
            }
            ?>
            </tbody>

            <?php
                $jumlahTotal = 0;
                
            foreach ($detail as $key => $row) {
                $jumlahTotal += $row->total;
            }
            ?>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right">Jumlah Total :</th>
                        <th class="text-right">Rp. <?=rupiah2($jumlahTotal)?></th>
                    </tr>
                </tfoot>
        </table>
        </form>
    </div>

    <div class="tab-pane fade " id="pills-rekap" role="tabpanel" aria-labelledby="pills-rekap-tab">
        <table class="table table-bordered table-striped" id="list_kavling">
            <thead>
                <tr class="text-light bg-dark">
                    <th class="text-center">Tipe</th>
                    <th class="text-center">Blok</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1; 
                foreach ($kavling as $key => $as){
                ?>
                    <tr>
                        <td>
                        <span class="text-bold"><?= $as->tipe?></span><br>
                        </td>
                        <td>
                            <?php 
                            foreach ($tipe as $key => $oi){ 
                                if($as->tipe == $oi->tipe){
                            ?>
                            <?= $oi->blok ?><br>
                            <?php
                                    }else{
                                        $oi->blok;
                                    } 
                                }
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>