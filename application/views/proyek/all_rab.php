
<table class="table table-bordered " id="tabel_material">
    <thead>
        <tr class="text-light bg-dark">
            <th class="text-center">Tipe</th>
            <th class="text-center">Blok</th>
            <th class="text-center">Material</th>
            <th class="text-center">Upah</th>
            <th class="text-center">Lainnya</th>
            <th class="text-center">Total</th>
        </tr>
    </thead>

    <tbody>
       
       <?php foreach($kav as $k){
        ?>
            <?php
                $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $id_pro AND tbl_kavling.id_tipe = $k->id_tipe";
                $jmlblok = $this->db->query($q)->num_rows();
            ?>
        <tr>
            <td><?= $k->tipe ?></td>
            <td>
                <?php
                    $q = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $id_pro AND tbl_kavling.id_tipe = $k->id_tipe";
                    $blok = $this->db->query($q)->result();
                    foreach($blok as $b){
                ?>
                    <ul>
                        <li><?= $b->blok . $b->no_rumah ?></li>
                    </ul>
                <?php } ?>
            </td>
            <td>
                <?php 
                    $q = "SELECT * FROM 
                        tbl_proyek_material,
                        master_material,
                        master_produk_unit
                        WHERE
                        tbl_proyek_material.material_id = master_material.id AND
                        master_material.unit_id = master_produk_unit.id AND
                        tbl_proyek_material.tipe_id = $k->id_tipe AND
                        tbl_proyek_material.proyek_id = $id_pro
                    ";
                    $material = $this->db->query($q)->result();
                    foreach($material as $m){
                    
                ?>
                
                <p><strong><?= $m->nama_material ?></strong> (<?= $m->quantity .' '. $m->nama_satuan ?>)</p>
                <p style="margin-top:-20px">Rp. <?= number_format($m->total); ?></p>
                
                <?php } ?>
            </td>
            <td>
                <?php 
                    $upah1 = $this->db->get_where('tbl_proyek_upah',['proyek_id' => $id_pro, 'tipe_id' => $k->id_tipe])->result();
                ?>
                
                <?php if(isset($upah1)){
                    $totRealUpah = 0;
                    foreach($upah1 as $lp){
                    $totalUpah = $lp->harga_kontrak * $jmlblok;    
                ?>
                    <strong>Ket : (<?= $lp->ket; ?>)</strong><br>
                    <p>Rp. <?= number_format($totalUpah) ?> <br>
                        <small>(Rp. <?= number_format($lp->harga_kontrak) ?> / Blok)</small>
                    </p>
                     <br>
                    <?php $totRealUpah += $totalUpah; } ?>
                <?php } else { ?>
                    <strong>Rp. 0</strong>
                    <p>(Rp. 0 / Blok)</p>
                <?php } ?>



               



            </td>
            <td>
                <?php
                    $lain = $this->db->get_where('tbl_proyek_lainnya',['proyek_id' => $id_pro, 'tipe_id' => $k->id_tipe])->result();
                    foreach($lain as $l){
                ?>
                <strong><?= $l->keterangan ?></strong>
                <p>Rp. <?= number_format($l->harga_lainnya) ?></p>
                <?php } ?>
            </td>
            <td>
                <?php
                    $totMat = "SELECT SUM(total) as total FROM tbl_proyek_material WHERE proyek_id = $id_pro AND tipe_id = $k->id_tipe";
                    $totLain = "SELECT SUM(harga_lainnya) as total FROM tbl_proyek_lainnya WHERE proyek_id = $id_pro AND tipe_id = $k->id_tipe";

                    $tM = $this->db->query($totMat)->row()->total;
                    $tL = $this->db->query($totLain)->row()->total;
                    
                    

                    if(isset($totRealUpah)){
                        $totAll = $tM + $tL + $totRealUpah;
                        echo 'Rp. ' . number_format($totAll);  
                    } else {
                        echo 'Rp. 0';
                    }
                          
                ?>    
            </td>
        </tr>
        
            
        
        
        
       
        <?php } ?>     
        
    </tbody>

                        <?php
                          
                            $jmlMaterial = "SELECT SUM(total) as total FROM tbl_proyek_material WHERE proyek_id = $id_pro";

                            $jumlahTotalLain = 0;
                            $tod=0;


                            foreach ($lainnya as $LainnyaTotal) {
                                $jumlahTotalLain += $LainnyaTotal->harga_lainnya;
                            }

                            
                            $totjmlMaterial = $this->db->query($jmlMaterial)->row()->total;
                            foreach ($upah2 as $jU) {
                                $qKav = "SELECT * FROM master_proyek_kavling JOIN tbl_kavling ON master_proyek_kavling.kavling_id = tbl_kavling.id_kavling WHERE master_proyek_kavling.proyek_id = $id_pro AND tbl_kavling.id_tipe = $jU->tipe_id";
                                $totKav = $this->db->query($qKav)->num_rows();
                                $jmTot = $totKav * $jU->harga_kontrak;
                                $tod += $jmTot;
                            }


                            $q1 = "SELECT SUM(total) as total FROM tbl_proyek_material WHERE proyek_id = $id_pro";
                            $q2 = "SELECT SUM(harga_lainnya) as total FROM tbl_proyek_lainnya WHERE proyek_id = $id_pro";
                            $tM1 = $this->db->query($q1)->row()->total;
                            $tL2 = $this->db->query($q2)->row()->total;
        
                            
                            $totaForAll = $tM1+$tL2+$tod;
                        ?>
                
                                <tfoot>
                                    <tr class="text-light bg-dark">
                                        <th colspan="2" class="text-right">Jumlah Total :</th>
                                        <th class="text-right">Rp. <?=rupiah2($totjmlMaterial)?></th>
                                        <th class="text-right">Rp. <?=rupiah2($tod)?></th>
                                        <th class="text-right">Rp. <?=rupiah2($jumlahTotalLain)?></th>
                                        <th class="text-right">Rp. <?=rupiah2($totaForAll)?></th>
                                    </tr>
                                </tfoot>

</table>