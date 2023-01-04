<?php foreach($item as $i){ ?>

    <tr>
        <td><?php $date = date_create($i['options']['tanggal']); echo date_format($date, 'd F Y') ?></td>
        <td><?= $i['options']['nama_proyek'] ?></td>
        <td><b><?= $i['name'] ?></b> <br>
            <small class="text-danger"><?= $i['options']['kategori_material'] ?></small>
        </td>
        <td><?= $i['qty'] .' '. $i['options']['satuan_material'] ?></td>
        <td><b>Rp. <?= number_format($i['subtotal']); ?></b> <br>
            <small class="text-danger">(Rp. <?= number_format($i['price']) ?>)</small>
        </td>
        <td>
      
            <button class="btn btn-sm btn-danger reject-cart" data-id="<?= $i['rowid']; ?>"><i class="fa fa-times"></i></button>
            
        </td>
    </tr>
 
<?php } ?>