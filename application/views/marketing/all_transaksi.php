
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Profil Konsumen</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Transaksi Bank</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Transaksi Inhouse</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="pills-fee-tab" data-toggle="pill" href="#pills-fee" role="tab" aria-controls="pills-fee" aria-selected="false">Fee Marketing</a>
  </li>
</ul>
<hr>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
      <h4>Profil Konsumen</h4>
      <table class="table table-bordered">
          <tr>
              <td>NIK</td>
              <td><?= $konsumen->nik ?></td>
          </tr>
          <tr>
              <td>Nama</td>
              <td><?= $konsumen->nama_konsumen ?></td>
          </tr>
          <tr>
              <td>Jenis Kelamin</td>
              <td><?= $konsumen->jk ?></td>
          </tr>
          <tr>
              <td>Alamat</td>
              <td><?= $konsumen->alamat ?></td>
          </tr>
          <tr>
              <td>Status Menikah</td>
              <td><?= $konsumen->status_menikah ?></td>
          </tr>
          <tr>
              <td>Pekerjaan</td>
              <td><?= $konsumen->pekerjaan ?></td>
          </tr>
          <tr>
              <td>Tempat Kerja</td>
              <td><?= $konsumen->tempat_kerja ?></td>
          </tr>
          <tr>
              <td>Gaji</td>
              <td><?= $konsumen->gaji ?></td>
          </tr>
          <tr>
              <td>No Telp</td>
              <td><?= $konsumen->no_hp ?></td>
          </tr>
          <tr>
              <td>Email</td>
              <td><?= $konsumen->email ?></td>
          </tr>
          <tr>
              <td>Dapat Info</td>
              <td><?= $konsumen->dapat_info ?></td>
          </tr>
          <tr>
              <td>Status Konsumen</td>
              <td>Transaksi di Batalkan</td>
          </tr>
      </table>

    <?php if($konsumen->status_menikah == 'Sudah'){ ?>
        <h4>Data Pasangan Konsumen</h4>
            <table class="table table-bordered">
                <tr>
                    <td>NIK</td>
                    <td><?= $pasangan->nik ?></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td><?= $pasangan->nama ?></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td><?= $pasangan->jk ?></td>
                </tr>
                <tr>
                    <td>No Telp</td>
                    <td><?= $pasangan->no_hp ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?= $pasangan->email ?></td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td><?= $pasangan->pekerjaan ?></td>
                </tr>
                <tr>
                    <td>Tempat Kerja</td>
                    <td><?= $pasangan->tempat_kerja ?></td>
                </tr>
                <tr>
                    <td>Gaji</td>
                    <td>Rp. <?= number_format($pasangan->gaji) ?></td>
                </tr>
            </table>
    <?php } ?>


  </div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
      <h4>Transaksi Bank</h4>
      <?php if(empty($bank)){ ?>
        <p>No data Result</p>
        <?php } else { ?>
      <p><span class="text-danger">*</span> Rumah Pilihan</p>
      <table class="table table-bordered">
          <thead>
              <tr class="text-light bg-dark">
                  <th>Blok</th>
                  <th>Tipe</th>
                  <th>Luas Tanah(m<sup>2</sup>)</th>
                  <th>Luas Bangunan(m<sup>2</sup>)</th>
                  <th>Harga</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td><?= $bank->blok . $bank->no_rumah ?></td>
                  <td><?= $bank->tipe ?></td>
                  <td><?= $bank->lt ?></td>
                  <td><?= $bank->lb ?></td>
                  <td>Rp. <?= number_format($bank->harga) ?></td>
              </tr>
          </tbody>
      </table>

      <p><span class="text-danger">*</span> Pembayaran</p>
      <table class="table table-bordered">
          <thead>
              <tr class="text-light bg-dark">
                  <th>Harga kesepakatan</th>
                  <th>Tanda Jadi</th>
                  <th>Tgl Tanda Jadi</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>Rp. <?= number_format($bank->harga_kesepakatan) ?></td>
                  <td>Rp. <?= number_format($bank->tanda_jadi) ?></td>
                  <td><?= $bank->tgl_tanda_jadi ?></td>
              </tr>
          </tbody>
      </table>

      <p><span class="text-danger">*</span> Tanda Jadi Lokasi</p>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>Tanda Jadi Lokasi</th>
                    <th>Angsuran</th>
                    <th>Cicilan Angsuran</th>
                    <th>Tgl Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($tanda_jadi_lokasi_bank)){ ?>
                    <tr>
                        <td colspan="4" class="text-center">No data result</td>
                    </tr>
                <?php } else { ?>
                <tr>
                    <td>Rp. <?= number_format($tanda_jadi_lokasi_bank->jml_tjl) ?></td>
                    <td><?= $tanda_jadi_lokasi_bank->angsuran ?></td>
                    <td>Rp. <?= number_format($tanda_jadi_lokasi_bank->cicilan_angsuran) ?></td>
                    <td><?= $tanda_jadi_lokasi_bank->tgl_bayar ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
      <p><span class="text-danger">*</span> Uang Muka</p>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>Uang Muka</th>
                    <th>Angsuran</th>
                    <th>Cicilan Angsuran</th>
                    <th>Tgl Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($uang_muka_bank)){ ?>
                    <tr>
                        <td colspan="4" class="text-center">No data result</td>
                    </tr>
                <?php } else { ?>
                <tr>
                    <td>Rp. <?= number_format($uang_muka_bank->jml_um) ?></td>
                    <td><?= $uang_muka_bank->angsuran ?></td>
                    <td>Rp. <?= number_format($uang_muka_bank->cicilan_angsuran) ?></td>
                    <td><?= $uang_muka_bank->tgl_bayar ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

      <p><span class="text-danger">*</span> Kelebihan Tanah</p>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>Kelebihan Tanah</th>
                    <th>Angsuran</th>
                    <th>Cicilan Angsuran</th>
                    <th>Tgl Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($kelebihan_tanah_bank)){ ?>
                    <tr>
                        <td colspan="4" class="text-center">No data result</td>
                    </tr>
                <?php } else { ?>
                <tr>
                    <td>Rp. <?= number_format($kelebihan_tanah_bank->jml_kt) ?></td>
                    <td><?= $kelebihan_tanah_bank->angsuran ?></td>
                    <td>Rp. <?= number_format($kelebihan_tanah_bank->cicilan_angsuran) ?></td>
                    <td><?= $kelebihan_tanah_bank->tgl_bayar ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

      <p><span class="text-danger">*</span> PAK</p>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>PAK</th>
                    <th>Angsuran</th>
                    <th>Cicilan Angsuran</th>
                    <th>Tgl Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($pak)){ ?>
                    <tr>
                        <td colspan="4" class="text-center">No data result</td>
                    </tr>
                <?php } else { ?>
                <tr>
                    <td>Rp. <?= number_format($pak->jml_pak) ?></td>
                    <td><?= $pak->angsuran ?></td>
                    <td>Rp. <?= number_format($pak->cicilan_angsuran) ?></td>
                    <td><?= $pak->tgl_bayar ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

      <p><span class="text-danger">*</span> Lain-Lain</p>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>Lain-Lain</th>
                    <th>Angsuran</th>
                    <th>Cicilan Angsuran</th>
                    <th>Tgl Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($lain_bank)){ ?>
                    <tr>
                        <td colspan="4" class="text-center">No data result</td>
                    </tr>
                <?php } else { ?>
                <tr>
                    <td>Rp. <?= number_format($lain_bank->jml_lain) ?></td>
                    <td><?= $lain_bank->angsuran ?></td>
                    <td>Rp. <?= number_format($lain_bank->cicilan_angsuran) ?></td>
                    <td><?= $lain_bank->tgl_bayar ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
<?php } ?>
  </div>
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
  <h4>Transaksi Inhouse</h4>

    <?php if(empty($inhouse)) {?>
        <p class="text-center">No Data Result</p>
    <?php } else { ?>

      <p><span class="text-danger">*</span> Pembayaran</p>
      <table class="table table-bordered">
          <thead>
              <tr class="text-light bg-dark">
                  <th>Blok</th>
                  <th>Tipe</th>
                  <th>Luas Tanah(m<sup>2</sup>)</th>
                  <th>Luas Bangunan(m<sup>2</sup>)</th>
                  <th>Harga</th>
                  <th>Tanda Jadi</th>
                  <th>Tgl Tanda Jadi</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td><?= $inhouse->blok . $inhouse->no_rumah ?></td>
                  <td><?= $inhouse->tipe ?></td>
                  <td><?= $inhouse->lt ?></td>
                  <td><?= $inhouse->lb ?></td>
                  <td>Rp. <?= number_format($inhouse->harga) ?></td>
                  <td>Rp. <?= number_format($inhouse->tanda_jadi); ?></td>
                  <td><?= $inhouse->tgl_tanda_jadi ?></td>
              </tr>
          </tbody>
      </table>

      <p><span class="text-danger">*</span> Harga Kesepakatan</p>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>Harga Kesepakatan</th>
                    <th>Angsuran</th>
                    <th>Cicilan Angsuran</th>
                    <th>Tgl Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($kesepakatan)){ ?>
                    <tr>
                        <td colspan="4" class="text-center">No data result</td>
                    </tr>
                <?php } else { ?>
                <tr>
                    <td>Rp. <?= number_format($kesepakatan->jml_kesepakatan) ?></td>
                    <td><?= $kesepakatan->angsuran ?></td>
                    <td>Rp. <?= number_format($kesepakatan->cicilan_angsuran) ?></td>
                    <td><?= $kesepakatan->tgl_bayar ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

      <p><span class="text-danger">*</span> Tanda Jadi Lokasi</p>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>Tanda Jadi Lokasi</th>
                    <th>Angsuran</th>
                    <th>Cicilan Angsuran</th>
                    <th>Tgl Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($tanda_jadi_lokasi_inhouse)){ ?>
                    <tr>
                        <td colspan="4" class="text-center">No data result</td>
                    </tr>
                <?php } else { ?>
                <tr>
                    <td>Rp. <?= number_format($tanda_jadi_lokasi_inhouse->jml_tjl) ?></td>
                    <td><?= $tanda_jadi_lokasi_inhouse->angsuran ?></td>
                    <td>Rp. <?= number_format($tanda_jadi_lokasi_inhouse->cicilan_angsuran) ?></td>
                    <td><?= $tanda_jadi_lokasi_inhouse->tgl_bayar ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

      <p><span class="text-danger">*</span> Uang Muka</p>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>Uang Muka</th>
                    <th>Angsuran</th>
                    <th>Cicilan Angsuran</th>
                    <th>Tgl Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($uang_muka_inhouse)){ ?>
                    <tr>
                        <td colspan="4" class="text-center">No data result</td>
                    </tr>
                <?php } else { ?>
                <tr>
                    <td>Rp. <?= number_format($uang_muka_inhouse->jml_um) ?></td>
                    <td><?= $uang_muka_inhouse->angsuran ?></td>
                    <td>Rp. <?= number_format($uang_muka_inhouse->cicilan_angsuran) ?></td>
                    <td><?= $uang_muka_inhouse->tgl_bayar ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

      <p><span class="text-danger">*</span> Kelebihan Tanah</p>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>Kelebihan Tanah</th>
                    <th>Angsuran</th>
                    <th>Cicilan Angsuran</th>
                    <th>Tgl Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($kelebihan_tanah_inhouse)){ ?>
                    <tr>
                        <td colspan="4" class="text-center">No data result</td>
                    </tr>
                <?php } else { ?>
                <tr>
                    <td>Rp. <?= number_format($kelebihan_tanah_inhouse->jml_kt) ?></td>
                    <td><?= $kelebihan_tanah_inhouse->angsuran ?></td>
                    <td>Rp. <?= number_format($kelebihan_tanah_inhouse->cicilan_angsuran) ?></td>
                    <td><?= $kelebihan_tanah_inhouse->tgl_bayar ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
  </div>
  <div class="tab-pane fade" id="pills-fee" role="tabpanel" aria-labelledby="pills-fee-tab">
      <h4>Fee Marketing</h4>
      <?php if($konsumen->status_fee_marketing == 0){ ?>
        <p class="text-danger">No Data Result</p>
    <?php } else { ?>

        <?php
            $cicil = $this->db->get_where('cicil_fee_marketing',['id_marketing' => $konsumen->id_marketing])->result();
            $total = $konsumen->nominal_fee_marketing;
            $terbayar = 0;
            foreach($cicil as $c){
                if($c->status == 2){
                    $terbayar += $c->jumlah;
                }
            }
            $sisa = $total - $terbayar;
            if($sisa == 0){
                $lunas = 'Lunas';
            } else {
                $lunas = 'Belum Lunas';
            }
        ?>


        <div class="row justify-content-center">
            <div class="col-lg-6">

            
      <table class="table table-bordered">
          <tr>
              <td>Nominal</td>
              <td>Rp. <?= number_format($konsumen->nominal_fee_marketing); ?></td>
          </tr>
          
          <tr>
              <td>Status</td>
              <td>
                    <?php if($konsumen->status_fee_marketing == 1){ ?>
                        Menunggu Konfirmasi
                    <?php } else if($konsumen->status_fee_marketing == 2){ ?>
                        Sudah
                    <?php }  ?>
              </td>
          </tr>
          <tr>
            <td>Status Transfer Dana</td>
            <td><?= $lunas ?></td>
          </tr>
          <tr>
            <td>Total Terbayar</td>
            <td>Rp. <?= number_format($terbayar) ?></td>
          </tr>
          <tr>
            <td>Total Sisa</td>
            <td>Rp. <?= number_format($sisa) ?></td>
          </tr>
          <tr>
              <td>Foto Bukti</td>
              <td>
                  <img src="<?= base_url('assets/upload/fee-marketing/' . $konsumen->img_fee_marketing); ?>" width="100%">
              </td>
          </tr>
      </table>
      </div>
        </div>
      <?php } ?>
  </div>
</div>