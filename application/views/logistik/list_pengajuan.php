<?php $i=1; foreach($this->cart->contents() as $item){ 
    $proyek_id = $item['options']['proyek_id'];
    $list = $this->logistik->get_material_with_cart($item['id']);   
    $harga = $this->db->where('id', $proyek_id)->get('tbl_proyek_material')->row()->harga; 
    $proyek = $this->db->get_where('master_proyek',['id' => $proyek_id])->row();

    $rab_material = $this->db->get_where('tbl_proyek_material',['id' => $proyek_id])->row();
    $proyek = $this->db->get_where('master_proyek',['id' => $rab_material->proyek_id])->row();

    if($item['options']['type'] == 1){
        //material ambil dari RAB

        $row_harga = 'Rp. '.number_format($harga * $item['qty']).' <br>
                        <small class="text-primary">Rp. '. number_format($harga) .'</small>';
        $source = 'RAB';

    } else if($item['options']['type'] == 2){
        //material ambil dari stok logistik/gudang
        $row_harga = '-';
        $source = 'Stok Gudang';
        
    }


?>
<tr>
    <td><?= $i++; ?></td>
    <td><b><?= $list->nama_material ?></b> <br>
        <small class="text-danger"><?= $list->kategori_produk ?></small>
    </td>
    <td class="text-center"><?= $item['qty'] .' '. $list->nama_satuan ?></td>
    <td class="text-center"><?= $row_harga ?></td>
    <td  class="text-center"><b><?= $source ?></b> <br> <small class="text-success">Proyek <?= $proyek->nama_proyek ?></small></td>
    <td>
        <button class="btn btn-sm btn-danger trashItem" data-id="<?= $item['rowid']; ?>" type="button"><i class="fa fa-times"></i></button>
    </td>
</tr>
<?php } ?>