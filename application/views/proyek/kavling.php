<script text="javascript">
    $('#list_kav').dataTable();
</script>

<table class="table table-bordered table-striped" id="list_kav">
    <thead>
        <tr class="text-light bg-dark">
            <th class="text-center">Cluster</th>
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
            <td><span class="text-bold"><?= $as->nama_cluster?></span></td>
                <td>
                <span class="text-bold"><?= $as->tipe?></span><br>
                </td>
                <td>
                    <?php 
                    foreach ($tipe as $key => $oi){ 
                        if($as->id_tipe == $oi->id_tipe){
                    ?>
                    <?= $oi->blok ?><?= $oi->no_rumah ?><br>
                    <?php
                            }else{
                                $oi->blok;
                                $oi->no_rumah;
                            } 
                        }
                    ?>
                </td>

            </tr>
        <?php 
        }
        ?>
    </tbody>
</table>