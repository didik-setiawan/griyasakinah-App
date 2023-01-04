<style>
div.polaroid {
  width: 100%;
  background-color: white;
  box-shadow: 0 4px 8px0 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  margin-bottom: 25px;
}

div.container {
  text-align: center;
  padding: 10px 20px;
}
</style>


<div class="polaroid">
  <img src="<?= base_url('assets/upload/logistik/') . $masuk->dokumentasi; ?>" style="width:100%">
  <div class="container">
  <p><?= date('d F Y', strtotime($masuk->tgl_masuk))?></p>
  </div>
</div>
