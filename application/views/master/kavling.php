<style>
    svg a {
            fill: none;
            stroke: black;
            stroke-width: 15px;
            stroke-linejoin: round;
            padding: 2px;
    }

    svg a:not(.container-siteplan):hover {
        fill: black;
    }

</style>
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Management Data Kavling</h1>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <!-- Default box -->
                <div class="card">
                    <div class="card-header">
            
        <div class="row">
            <div class="col-lg-6 col-12">
                <button type="button" class="btn btn-sm btn-success <?php access(); ?>" data-toggle="modal" data-target="#staticBackdrop"><i class="fa fa-plus"></i> Tambah Kavling</button>
            </div>
            <div class="col-lg-3 col-6">
                <div class="form-group">
                    <label>Filter Perumahan</label>
                    <select name="filter_perum" id="filter_perum" class="form-control">
                        <option value="">All</option>
                        <?php foreach($perum as $p){ ?>
                            <?php if($_GET['perum'] == $p['id_perumahan']){ ?>
                                    <option value="<?= $p['id_perumahan'] ?>" selected><?= $p['nama_perumahan'] ?></option>
                            <?php } else { ?>
                                    <option value="<?= $p['id_perumahan'] ?>"><?= $p['nama_perumahan'] ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="form-group">
                    <label>Filter Cluster</label>
                    <select name="filter_cluster" id="filter_cluster" class="form-control">
                        
                        <?php if(isset($_GET['perum'])){ ?>
                            <option value="">All</option>
                            <?php $cluster = $this->db->get_where('tbl_cluster',['id_perum' => $_GET['perum']])->result();
                            foreach($cluster as $c){
                            ?>

                                <?php if($_GET['cluster'] == $c->id_cluster){ ?>
                                    <option value="<?= $c->id_cluster ?>" selected><?= $c->nama_cluster ?></option>
                                <?php } else { ?>
                                    <option value="<?= $c->id_cluster ?>"><?= $c->nama_cluster ?></option>
                                <?php } ?>

                            <?php } ?>

                            <?php } else { ?>
                                <option value="">All</option>
                        <?php } ?>

                    </select>
                </div>
            </div>
        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped" id="kavling-table">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th>Lokasi Kavling</th>
                                    <th>Cluster</th>
                                    <th>Blok</th>
                                    <th>No Rumah</th>
                                    <th>Tipe</th>
                                    <th>LT (m<sup>2</sup>)</th>
                                    <th>LB (m<sup>2</sup>)</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>
                                        <i class="fa fa-cogs"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="body-kavling">
                            <?php $booking = 0; $lunas = 0; $realisasi = 0;?>
                                <?php foreach($kavling as $k){ ?>
                                <tr>
                                    <td><?= $k->nama_perumahan ?></td>
                                    <td><?= $k->nama_cluster ?></td>
                                    <td><?= $k->blok ?></td>
                                    <td><?= $k->no_rumah ?></td>
                                    <td><?= $k->tipe ?></td>
                                    <td><?= $k->lt ?></td>
                                    <td><?= $k->lb ?></td>

                                    <td>Rp. <?= number_format($k->harga); ?></td>
                                    <td>
                                        <?php if($k->status_kavling == 0){ ?>
                                            <!-- <p class="text-danger text-center"><i class="fas fa-times"></i></p> -->
                                            <span class="badge badge-secondary">Available</span>
                                            <?php $booking++ ?>
                                        <?php } else if($k->status_kavling == 1){ ?>
                                            <!-- <p class="text-success text-center"><i class="fas fa-check"></i></p> -->
                                            <span class="badge badge-warning">Booking</span>

                                            <?php $lunas++ ?>
                                        <?php } else if($k->status_kavling == 2){ ?>
                                            <span class="badge badge-danger">Lunas</span>

                                            <?php $realisasi++ ?>
                                        <?php } ?>
                                        
                                    </td>
                                    <td>
                                        <div class="<?php access(); ?>">
                                        <button type="button" data-toggle="tooltip" data-placement="left" title="Hapus" class="btn btn-danger btn-xs del-kavling" data-id="<?= $k->id_kavling ?>"><i class="fa fa-trash"></i></button>
                                        <button type="button" class="btn btn-info btn-xs edit-kavling-act" data-toggle="modal" data-target="#modal1" data-id="<?= $k->id_kavling ?>" data-status="<?= $k->cluster ?>"><i class="fa fa-edit"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                                
                                <?php foreach($kavling2 as $k2){ ?>
                                    <tr>
                                        <td><?= $k2->nama_perumahan ?></td>
                                        <td></td>
                                        <td><?= $k2->blok ?></td>
                                        <td><?= $k2->no_rumah ?></td>
                                        <td><?= $k2->tipe ?></td>
                                        <td><?= $k2->lt ?></td>
                                        <td><?= $k2->lb ?></td>
                                        <td>Rp. <?= number_format($k2->harga); ?></td>
                                        <td>
                                            <?php if($k2->status_kavling == 0){ ?>
                                                <!-- <p class="text-danger text-center"><i class="fas fa-times"></i></p> -->
                                                <span class="badge badge-secondary">Available</span>

                                            <?php } else if($k2->status_kavling == 1){ ?>
                                                <!-- <p class="text-success text-center"><i class="fas fa-check"></i></p> -->
                                                <span class="badge badge-warning">Booking</span>
                                            <?php } else if($k->status_kavling == 2){ ?>
                                                <span class="badge badge-danger">Lunas</span>
                                            <?php } ?>
                                            

                                        </td>
                                        <td>
                                            <div class="<?php access(); ?>">
                                            <button type="button" data-toggle="tooltip" data-placement="left" title="Hapus" class="btn btn-danger btn-xs del-kavling" data-id="<?= $k2->id_kavling ?>"><i class="fa fa-trash"></i></button>

                                            <button type="button" class="btn btn-info btn-xs edit-kavling-act" data-toggle="modal" data-target="#modal1" data-id="<?= $k2->id_kavling ?>" data-status="<?= $k2->cluster ?>"><i class="fa fa-edit"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->



<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Pilih Sitemap</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row p-1 justify-content-center">
            <div class="col-3 rounded m-1 p-1 text-center text-dark" style="background-color: #f6e05e"><?= $lunas ?> Unit Booking</div> 
            <div class="col-3 rounded m-1 p-1 text-light text-center" style="background-color: #718096"><?= $booking ?> Unit Available</div>
            <div class="col-3 rounded m-1 p-1 text-light text-center" style="background-color: #db2528"><?= $realisasi ?> Unit Lunas</div>
        </div>
        <div class="container">
                <svg color="white" style="background-color:white" version="1.1" viewBox="0 0 1877 2000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <a xlink:href="" href="#modalTambah" id="sitemap-1" data-id="sitemap-1" data-toggle="modal" class="sitemap" href="#modalTambah" data-toggle="modal">
                <polygon points="218 2939 57 3635 86 3447 121 3309 108 3305 174 2950"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-2" data-id="sitemap-2" data-toggle="modal" class="sitemap">
                <polygon points="189 3537 171 3618 304 3647 319 3587 323 3566"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-3" data-id="sitemap-3" data-toggle="modal" class="sitemap">
                <polygon points="208 3456 189 3537 323 3566 332 3525 341 3485"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-4" data-id="sitemap-4" data-toggle="modal" class="sitemap">
                <polygon points="228 3372 208 3456 341 3485 347 3464 361 3403"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-5" data-id="sitemap-5" data-toggle="modal" class="sitemap">
                <polygon points="245 3291 228 3372 361 3403 375 3340 379 3321"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-6" data-id="sitemap-6" data-toggle="modal" class="sitemap">
                <polygon points="264 3209 245 3291 379 3321 389 3279 398 3241"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-7" data-id="sitemap-7" data-toggle="modal" class="sitemap">
                <polygon points="284 3127 264 3209 398 3241 403 3219 417 3157"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-8" data-id="sitemap-8" data-toggle="modal" class="sitemap">
                <polygon points="303 3045 284 3127 417 3157 431 3096 435 3075"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-9" data-id="sitemap-9" data-toggle="modal" class="sitemap">
                <polygon points="322 2963 303 3045 435 3075 445 3034 454 2994"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-10" data-id="sitemap-10" data-toggle="modal" class="sitemap">
                <polygon points="474 2912 322 2963 454 2994 460 2973"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-11" data-id="sitemap-11" data-toggle="modal" class="sitemap">
                <polygon points="562 2995 576 2934 474 2912 460 2973"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-12" data-id="sitemap-12" data-toggle="modal" class="sitemap">
                <polygon points="548 3057 562 2995 460 2973 445 3034"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-13" data-id="sitemap-13" data-toggle="modal" class="sitemap">
                <polygon points="534 3119 548 3057 445 3034 431 3096"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-14" data-id="sitemap-14" data-toggle="modal" class="sitemap">
                <polygon points="520 3180 534 3119 431 3096 417 3157"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-15" data-id="sitemap-15" data-toggle="modal" class="sitemap">
                <polygon points="505 3242 520 3180 417 3157 403 3219"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-16" data-id="sitemap-16" data-toggle="modal" class="sitemap">
                <polygon points="490 3303 505 3242 403 3219 389 3279"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-17" data-id="sitemap-17" data-toggle="modal" class="sitemap">
                <polygon points="476 3364 490 3303 389 3279 375 3340"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-18" data-id="sitemap-18" data-toggle="modal" class="sitemap">
                <polygon points="463 3426 476 3364 375 3340 361 3403"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-19" data-id="sitemap-19" data-toggle="modal" class="sitemap">
                <polygon points="448 3487 463 3426 361 3403 347 3464"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-20" data-id="sitemap-20" data-toggle="modal" class="sitemap">
                <polygon points="434 3548 448 3487 347 3464 332 3525"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-21" data-id="sitemap-21" data-toggle="modal" class="sitemap">
                <polygon points="420 3610 434 3548 332 3525 319 3587"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-22" data-id="sitemap-22" data-toggle="modal" class="sitemap">
                <polygon points="304 3647 319 3587 420 3610 406 3672 385 3668 323 3652"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-23" data-id="sitemap-23" data-toggle="modal" class="sitemap">
                <polygon points="201 3625 171 3618 147 3722 178 3727"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-24" data-id="sitemap-24" data-toggle="modal" class="sitemap">
                <polygon points="262 3639 201 3625 178 3727 240 3742"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-25" data-id="sitemap-25" data-toggle="modal" class="sitemap">
                <polygon points="323 3652 262 3639 240 3742 300 3755"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-26" data-id="sitemap-26" data-toggle="modal" class="sitemap">
                <polygon points="385 3668 323 3652 300 3755 362 3769"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-27" data-id="sitemap-27" data-toggle="modal" class="sitemap">
                <polygon points="447 3681 385 3668 362 3769 424 3783"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-28" data-id="sitemap-28" data-toggle="modal" class="sitemap">
                <polygon points="468 3686 447 3681 424 3783 486 3797 508 3694"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-29" data-id="sitemap-29" data-toggle="modal" class="sitemap">
                <polygon points="508 3694 486 3797 546 3811 570 3710"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-30" data-id="sitemap-30" data-toggle="modal" class="sitemap">
                <polygon points="482 3626 468 3686 570 3710 586 3649"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-31" data-id="sitemap-31" data-toggle="modal" class="sitemap">
                <polygon points="496 3564 482 3626 586 3649 599 3587"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-32" data-id="sitemap-32" data-toggle="modal" class="sitemap">
                <polygon points="510 3502 496 3564 599 3587 613 3525"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-33" data-id="sitemap-33" data-toggle="modal" class="sitemap">
                <polygon points="524 3442 510 3502 613 3525 628 3465"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-34" data-id="sitemap-34" data-toggle="modal" class="sitemap">
                <polygon points="539 3379 524 3442 628 3465 642 3404"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-35" data-id="sitemap-35" data-toggle="modal" class="sitemap">
                <polygon points="553 3318 539 3379 642 3404 656 3344"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-36" data-id="sitemap-36" data-toggle="modal" class="sitemap">
                <polygon points="567 3258 553 3318 656 3344 673 3281"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-37" data-id="sitemap-37" data-toggle="modal" class="sitemap">
                <polygon points="580 3196 567 3258 673 3281 686 3220"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-38" data-id="sitemap-38" data-toggle="modal" class="sitemap">
                <polygon points="595 3134 580 3196 686 3220 699 3157"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-39" data-id="sitemap-39" data-toggle="modal" class="sitemap">
                <polygon points="609 3072 595 3134 699 3157 712 3095"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-40" data-id="sitemap-40" data-toggle="modal" class="sitemap">
                <polygon points="623 3012 609 3072 712 3095 726 3034"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-41" data-id="sitemap-41" data-toggle="modal" class="sitemap">
                <polygon points="739 2972 638 2948 623 3012 726 3034"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-42" data-id="sitemap-42" data-toggle="modal" class="sitemap">
                <polygon points="1091 3171 1094 3054 739 2972 651 3389 659 3372 732 3029 752 2986 1078 3067 1088 3065"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-43" data-id="sitemap-43" data-toggle="modal" class="sitemap">
                <polygon points="1148 3343 1146 3438 1220 3453 1245 3414 1251 3342"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-44" data-id="sitemap-44" data-toggle="modal" class="sitemap">
                <polygon points="1252 3279 1251 3342 1148 3343 1148 3279"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-45" data-id="sitemap-45" data-toggle="modal" class="sitemap">
                <polygon points="1252 3217 1252 3279 1148 3279 1147 3216"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-46" data-id="sitemap-46" data-toggle="modal" class="sitemap">
                <polygon points="1252 3154 1252 3217 1147 3216 1146 3154"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-47" data-id="sitemap-47" data-toggle="modal" class="sitemap">
                <polygon points="1252 3091 1252 3154 1146 3154 1147 3065"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-48" data-id="sitemap-48" data-toggle="modal" class="sitemap">
                <polygon points="708 2772 680 2895 740 2910 769 2787"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-49" data-id="sitemap-49" data-toggle="modal" class="sitemap">
                <polygon points="769 2787 740 2910 792 2921 820 2799"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-50" data-id="sitemap-50" data-toggle="modal" class="sitemap">
                <polygon points="820 2799 792 2921 842 2932 872 2809"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-51" data-id="sitemap-51" data-toggle="modal" class="sitemap">
                <polygon points="872 2809 842 2932 894 2945 922 2820"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-52" data-id="sitemap-52" data-toggle="modal" class="sitemap">
                <polygon points="922 2820 894 2945 944 2956 974 2833"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-53" data-id="sitemap-53" data-toggle="modal" class="sitemap">
                <polygon points="974 2833 944 2956 996 2967 1024 2846"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-54" data-id="sitemap-54" data-toggle="modal" class="sitemap">
                <polygon points="1024 2846 996 2967 1047 2980 1075 2857"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-55" data-id="sitemap-55" data-toggle="modal" class="sitemap">
                <polygon points="1075 2857 1047 2980 1099 2991 1127 2868"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-56" data-id="sitemap-56" data-toggle="modal" class="sitemap">
                <polygon points="1127 2868 1099 2991 1149 3004 1178 2881"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-57" data-id="sitemap-57" data-toggle="modal" class="sitemap">
                <polygon points="1178 2881 1149 3004 1201 3015 1230 2892"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-58" data-id="sitemap-58" data-toggle="modal" class="sitemap">
                <polygon points="1251 3026 1268 3031 1279 2904"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-59" data-id="sitemap-59" data-toggle="modal" class="sitemap">
                <polygon points="1279 2904 1251 3026 1201 3015 1230 2892"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-60" data-id="sitemap-60" data-toggle="modal" class="sitemap">
                <polygon points="797 2663 735 2650 708 2772 769 2787"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-61" data-id="sitemap-61" data-toggle="modal" class="sitemap">
                <polygon points="847 2675 797 2663 769 2787 820 2799"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-62" data-id="sitemap-62" data-toggle="modal" class="sitemap">
                <polygon points="899 2687 847 2675 820 2799 872 2809"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-63" data-id="sitemap-63" data-toggle="modal" class="sitemap">
                <polygon points="951 2698 899 2687 872 2809 922 2820"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-64" data-id="sitemap-64" data-toggle="modal" class="sitemap">
                <polygon points="1001 2710 951 2698 922 2820 974 2833"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-65" data-id="sitemap-65" data-toggle="modal" class="sitemap">
                <polygon points="1052 2723 1001 2710 974 2833 1024 2846"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-66" data-id="sitemap-66" data-toggle="modal" class="sitemap">
                <polygon points="1103 2734 1052 2723 1024 2846 1075 2857"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-67" data-id="sitemap-67" data-toggle="modal" class="sitemap">
                <polygon points="1154 2745 1103 2734 1075 2857 1127 2868"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-68" data-id="sitemap-68" data-toggle="modal" class="sitemap">
                <polygon points="1206 2757 1154 2745 1127 2868 1178 2881"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-69" data-id="sitemap-69" data-toggle="modal" class="sitemap">
                <polygon points="1258 2768 1206 2757 1178 2881 1230 2892"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-70" data-id="sitemap-70" data-toggle="modal" class="sitemap">
                <polygon points="1291 2776 1258 2768 1230 2892 1279 2904"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-71" data-id="sitemap-71" data-toggle="modal" class="sitemap">
                <polygon points="777 2465 751 2588 812 2602 839 2479"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-72" data-id="sitemap-72" data-toggle="modal" class="sitemap">
                <polygon points="839 2479 812 2602 863 2614 890 2491"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-73" data-id="sitemap-73" data-toggle="modal" class="sitemap">
                <polygon points="890 2491 863 2614 913 2626 942 2503"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-74" data-id="sitemap-74" data-toggle="modal" class="sitemap">
                <polygon points="942 2503 913 2626 965 2637 992 2515"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-75" data-id="sitemap-75" data-toggle="modal" class="sitemap">
                <polygon points="992 2515 965 2637 1016 2649 1044 2528"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-76" data-id="sitemap-76" data-toggle="modal" class="sitemap">
                <polygon points="1044 2528 1016 2649 1067 2660 1095 2538"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-77" data-id="sitemap-77" data-toggle="modal" class="sitemap">
                <polygon points="1095 2538 1067 2660 1118 2673 1146 2550"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-78" data-id="sitemap-78" data-toggle="modal" class="sitemap">
                <polygon points="1146 2550 1118 2673 1169 2684 1196 2562"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-79" data-id="sitemap-79" data-toggle="modal" class="sitemap">
                <polygon points="1258 2577 1231 2699 1169 2684 1196 2562"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-80" data-id="sitemap-80" data-toggle="modal" class="sitemap">
                <polygon points="867 2357 805 2343 777 2465 839 2479"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-81" data-id="sitemap-81" data-toggle="modal" class="sitemap">
                <polygon points="918 2368 867 2357 839 2479 890 2491"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-82" data-id="sitemap-82" data-toggle="modal" class="sitemap">
                <polygon points="969 2380 918 2368 890 2491 942 2503"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-83" data-id="sitemap-83" data-toggle="modal" class="sitemap">
                <polygon points="1020 2391 969 2380 942 2503 992 2515"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-84" data-id="sitemap-84" data-toggle="modal" class="sitemap">
                <polygon points="1072 2403 1020 2391 992 2515 1044 2528"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-85" data-id="sitemap-85" data-toggle="modal" class="sitemap">
                <polygon points="1122 2415 1072 2403 1044 2528 1095 2538"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-86" data-id="sitemap-86" data-toggle="modal" class="sitemap">
                <polygon points="1174 2427 1122 2415 1095 2538 1146 2550"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-87" data-id="sitemap-87" data-toggle="modal" class="sitemap">
                <polygon points="1225 2437 1174 2427 1146 2550 1196 2562"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-88" data-id="sitemap-88" data-toggle="modal" class="sitemap">
                <polygon points="1286 2452 1258 2577 1196 2562 1225 2437"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-89" data-id="sitemap-89" data-toggle="modal" class="sitemap">
                <polygon points="848 2158 820 2282 882 2295 910 2172"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-90" data-id="sitemap-90" data-toggle="modal" class="sitemap">
                <polygon points="910 2172 882 2295 933 2308 961 2185"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-91" data-id="sitemap-91" data-toggle="modal" class="sitemap">
                <polygon points="961 2185 933 2308 984 2320 1012 2197"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-92" data-id="sitemap-92" data-toggle="modal" class="sitemap">
                <polygon points="1012 2197 984 2320 1034 2330 1062 2207"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-93" data-id="sitemap-93" data-toggle="modal" class="sitemap">
                <polygon points="1062 2207 1034 2330 1087 2342 1114 2220"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-94" data-id="sitemap-94" data-toggle="modal" class="sitemap">
                <polygon points="1114 2220 1087 2342 1137 2355 1165 2230"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-95" data-id="sitemap-95" data-toggle="modal" class="sitemap">
                <polygon points="1165 2230 1137 2355 1188 2366 1218 2244"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-96" data-id="sitemap-96" data-toggle="modal" class="sitemap">
                <polygon points="1218 2244 1188 2366 1239 2377 1268 2254"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-97" data-id="sitemap-97" data-toggle="modal" class="sitemap">
                <polygon points="1268 2254 1239 2377 1291 2388 1319 2265"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-98" data-id="sitemap-98" data-toggle="modal" class="sitemap">
                <polygon points="1319 2265 1291 2388 1342 2401 1370 2276"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-99" data-id="sitemap-99" data-toggle="modal" class="sitemap">
                <polygon points="1370 2276 1342 2401 1394 2413 1421 2291"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-100" data-id="sitemap-100" data-toggle="modal" class="sitemap">
                <polygon points="1421 2291 1394 2413 1436 2422 1445 2294"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-101" data-id="sitemap-101" data-toggle="modal" class="sitemap">
                <polygon points="937 2049 875 2034 848 2158 910 2172"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-102" data-id="sitemap-102" data-toggle="modal" class="sitemap">
                <polygon points="989 2060 937 2049 910 2172 961 2185"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-103" data-id="sitemap-103" data-toggle="modal" class="sitemap">
                <polygon points="1039 2071 989 2060 961 2185 1012 2197"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-104" data-id="sitemap-104" data-toggle="modal" class="sitemap">
                <polygon points="1091 2084 1039 2071 1012 2197 1062 2207"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-105" data-id="sitemap-105" data-toggle="modal" class="sitemap">
                <polygon points="1142 2096 1091 2084 1062 2207 1114 2220"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-106" data-id="sitemap-106" data-toggle="modal" class="sitemap">
                <polygon points="1193 2108 1142 2096 1114 2220 1165 2230"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-107" data-id="sitemap-107" data-toggle="modal" class="sitemap">
                <polygon points="1245 2119 1193 2108 1165 2230 1218 2244"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-108" data-id="sitemap-108" data-toggle="modal" class="sitemap">
                <polygon points="1296 2131 1245 2119 1218 2244 1268 2254"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-109" data-id="sitemap-109" data-toggle="modal" class="sitemap">
                <polygon points="1348 2143 1296 2131 1268 2254 1319 2265"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-110" data-id="sitemap-110" data-toggle="modal" class="sitemap">
                <polygon points="1397 2154 1348 2143 1319 2265 1370 2276"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-111" data-id="sitemap-111" data-toggle="modal" class="sitemap">
                <polygon points="1449 2165 1397 2154 1370 2276 1421 2291"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-112" data-id="sitemap-112" data-toggle="modal" class="sitemap">
                <polygon points="1454 2166 1449 2165 1421 2291 1445 2294"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-113" data-id="sitemap-113" data-toggle="modal" class="sitemap">
                <polygon points="990 1543 961 1667 1022 1680 1051 1557"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-114" data-id="sitemap-114" data-toggle="modal" class="sitemap">
                <polygon points="1051 1557 1022 1680 1074 1692 1104 1570"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-115" data-id="sitemap-115" data-toggle="modal" class="sitemap">
                <polygon points="1104 1570 1074 1692 1125 1704 1154 1581"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-116" data-id="sitemap-116" data-toggle="modal" class="sitemap">
                <polygon points="1154 1581 1125 1704 1176 1716 1205 1593"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-117" data-id="sitemap-117" data-toggle="modal" class="sitemap">
                <polygon points="1205 1593 1176 1716 1228 1728 1255 1604"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-118" data-id="sitemap-118" data-toggle="modal" class="sitemap">
                <polygon points="1255 1604 1228 1728 1279 1739 1307 1616"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-119" data-id="sitemap-119" data-toggle="modal" class="sitemap">
                <polygon points="1307 1616 1279 1739 1331 1750 1357 1629"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-120" data-id="sitemap-120" data-toggle="modal" class="sitemap">
                <polygon points="1357 1629 1331 1750 1381 1763 1409 1641"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-121" data-id="sitemap-121" data-toggle="modal" class="sitemap">
                <polygon points="1409 1641 1381 1763 1432 1774 1459 1652"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-122" data-id="sitemap-122" data-toggle="modal" class="sitemap">
                <polygon points="1459 1652 1432 1774 1483 1787 1512 1663"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-123" data-id="sitemap-123" data-toggle="modal" class="sitemap">
                <polygon points="1078 1436 1018 1422 990 1543 1051 1557"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-124" data-id="sitemap-124" data-toggle="modal" class="sitemap">
                <polygon points="1130 1448 1078 1436 1051 1557 1104 1570"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-125" data-id="sitemap-125" data-toggle="modal" class="sitemap">
                <polygon points="1181 1459 1130 1448 1104 1570 1154 1581"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-126" data-id="sitemap-126" data-toggle="modal" class="sitemap">
                <polygon points="1233 1470 1181 1459 1154 1581 1205 1593"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-127" data-id="sitemap-127" data-toggle="modal" class="sitemap">
                <polygon points="1282 1482 1233 1470 1205 1593 1255 1604"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-128" data-id="sitemap-128" data-toggle="modal" class="sitemap">
                <polygon points="1336 1494 1282 1482 1255 1604 1307 1616"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-129" data-id="sitemap-129" data-toggle="modal" class="sitemap">
                <polygon points="1386 1506 1336 1494 1307 1616 1357 1629"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-130" data-id="sitemap-130" data-toggle="modal" class="sitemap">
                <polygon points="1438 1518 1386 1506 1357 1629 1409 1641"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-131" data-id="sitemap-131" data-toggle="modal" class="sitemap">
                <polygon points="1488 1529 1438 1518 1409 1641 1459 1652"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-132" data-id="sitemap-132" data-toggle="modal" class="sitemap">
                <polygon points="1512 1663 1459 1652 1488 1529 1540 1542"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-133" data-id="sitemap-133" data-toggle="modal" class="sitemap">
                <polygon points="1512 1663 1483 1787 1535 1798 1563 1675"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-134" data-id="sitemap-134" data-toggle="modal" class="sitemap">
                <polygon points="1563 1675 1535 1798 1585 1810 1614 1688"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-135" data-id="sitemap-135" data-toggle="modal" class="sitemap">
                <polygon points="1614 1688 1585 1810 1636 1822 1664 1700"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-136" data-id="sitemap-136" data-toggle="modal" class="sitemap">
                <polygon points="1664 1700 1636 1822 1688 1834 1716 1712"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-137" data-id="sitemap-137" data-toggle="modal" class="sitemap">
                <polygon points="1590 1553 1540 1542 1512 1663 1563 1675"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-138" data-id="sitemap-138" data-toggle="modal" class="sitemap">
                <polygon points="1641 1565 1590 1553 1563 1675 1614 1688"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-139" data-id="sitemap-139" data-toggle="modal" class="sitemap">
                <polygon points="1693 1576 1641 1565 1614 1688 1664 1700"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-140" data-id="sitemap-140" data-toggle="modal" class="sitemap">
                <polygon points="1743 1587 1693 1576 1664 1700 1716 1712"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-141" data-id="sitemap-141" data-toggle="modal" class="sitemap">
                <polygon points="1716 1712 1688 1834 1739 1845 1768 1724"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-142" data-id="sitemap-142" data-toggle="modal" class="sitemap">
                <polygon points="1795 1599 1743 1587 1716 1712 1768 1724"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-143" data-id="sitemap-143" data-toggle="modal" class="sitemap">
                <polygon points="1818 1735 1791 1858 1739 1845 1768 1724"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-144" data-id="sitemap-144" data-toggle="modal" class="sitemap">
                <polygon points="1846 1611 1818 1735 1768 1724 1795 1599"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-145" data-id="sitemap-145" data-toggle="modal" class="sitemap">
                <polygon points="919 1850 891 1973 953 1987 981 1864"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-146" data-id="sitemap-146" data-toggle="modal" class="sitemap">
                <polygon points="981 1864 953 1987 1003 1999 1031 1877"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-147" data-id="sitemap-147" data-toggle="modal" class="sitemap">
                <polygon points="1031 1877 1003 1999 1054 2012 1083 1891"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-148" data-id="sitemap-148" data-toggle="modal" class="sitemap">
                <polygon points="1083 1891 1054 2012 1105 2025 1133 1901"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-149" data-id="sitemap-149" data-toggle="modal" class="sitemap">
                <polygon points="1008 1743 947 1728 919 1850 981 1864"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-150" data-id="sitemap-150" data-toggle="modal" class="sitemap">
                <polygon points="1059 1754 1008 1743 981 1864 1031 1877"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-151" data-id="sitemap-151" data-toggle="modal" class="sitemap">
                <polygon points="1109 1766 1059 1754 1031 1877 1083 1891"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-152" data-id="sitemap-152" data-toggle="modal" class="sitemap">
                <polygon points="1162 1779 1109 1766 1083 1891 1133 1901"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-153" data-id="sitemap-153" data-toggle="modal" class="sitemap">
                <polygon points="1133 1901 1105 2025 1157 2035 1185 1911"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-154" data-id="sitemap-154" data-toggle="modal" class="sitemap">
                <polygon points="1185 1911 1157 2035 1208 2046 1237 1924"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-155" data-id="sitemap-155" data-toggle="modal" class="sitemap">
                <polygon points="1237 1924 1208 2046 1259 2057 1287 1937"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-156" data-id="sitemap-156" data-toggle="modal" class="sitemap">
                <polygon points="1287 1937 1259 2057 1310 2069 1338 1947"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-157" data-id="sitemap-157" data-toggle="modal" class="sitemap">
                <polygon points="1338 1947 1310 2069 1360 2081 1389 1959"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-158" data-id="sitemap-158" data-toggle="modal" class="sitemap">
                <polygon points="1213 1790 1162 1779 1133 1901 1185 1911"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-159" data-id="sitemap-159" data-toggle="modal" class="sitemap">
                <polygon points="1264 1802 1213 1790 1185 1911 1237 1924"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-160" data-id="sitemap-160" data-toggle="modal" class="sitemap">
                <polygon points="1314 1813 1264 1802 1237 1924 1287 1937"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-161" data-id="sitemap-161" data-toggle="modal" class="sitemap">
                <polygon points="1365 1825 1314 1813 1287 1937 1338 1947"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-162" data-id="sitemap-162" data-toggle="modal" class="sitemap">
                <polygon points="1417 1836 1365 1825 1338 1947 1389 1959"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-163" data-id="sitemap-163" data-toggle="modal" class="sitemap">
                <polygon points="1389 1959 1360 2081 1411 2093 1439 1970"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-164" data-id="sitemap-164" data-toggle="modal" class="sitemap">
                <polygon points="1469 1848 1417 1836 1389 1959 1439 1970"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-165" data-id="sitemap-165" data-toggle="modal" class="sitemap">
                <polygon points="1519 1859 1469 1848 1439 1970 1492 1983"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-166" data-id="sitemap-166" data-toggle="modal" class="sitemap">
                <polygon points="1492 1983 1481 2031 1465 2029 1458 2104 1411 2093 1439 1970"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-167" data-id="sitemap-167" data-toggle="modal" class="sitemap">
                <polygon points="1569 1871 1519 1859 1492 1983 1543 1994"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-168" data-id="sitemap-168" data-toggle="modal" class="sitemap">
                <polygon points="1620 1883 1569 1871 1543 1994 1594 2007"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-169" data-id="sitemap-169" data-toggle="modal" class="sitemap">
                <polygon points="1673 1895 1620 1883 1594 2007 1645 2018"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-170" data-id="sitemap-170" data-toggle="modal" class="sitemap">
                <polygon points="1695 2030 1645 2018 1673 1895 1725 1906"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-171" data-id="sitemap-171" data-toggle="modal" class="sitemap">
                <polygon points="1748 2042 1695 2030 1725 1906 1775 1918"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-172" data-id="sitemap-172" data-toggle="modal" class="sitemap">
                <polygon points="1798 1922 1775 1918 1748 2042 1776 2051"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-173" data-id="sitemap-173" data-toggle="modal" class="sitemap">
                <polygon points="616 1760 597 1840 720 1871 732 1820 738 1788"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-174" data-id="sitemap-174" data-toggle="modal" class="sitemap">
                <polygon points="702 1951 709 1921 720 1871 597 1840 579 1921"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-175" data-id="sitemap-175" data-toggle="modal" class="sitemap">
                <polygon points="683 2032 684 2023 697 1972 702 1951 579 1921 560 2004"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-176" data-id="sitemap-176" data-toggle="modal" class="sitemap">
                <polygon points="663 2114 673 2073 683 2032 560 2004 541 2086"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-177" data-id="sitemap-177" data-toggle="modal" class="sitemap">
                <polygon points="646 2196 650 2177 661 2125 663 2114 541 2086 523 2169"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-178" data-id="sitemap-178" data-toggle="modal" class="sitemap">
                <polygon points="627 2279 639 2227 646 2196 523 2169 503 2250"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-179" data-id="sitemap-179" data-toggle="modal" class="sitemap">
                <polygon points="608 2359 615 2331 627 2279 503 2250 485 2332"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-180" data-id="sitemap-180" data-toggle="modal" class="sitemap">
                <polygon points="588 2442 590 2434 602 2382 608 2359 485 2332 465 2414"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-181" data-id="sitemap-181" data-toggle="modal" class="sitemap">
                <polygon points="569 2524 579 2483 588 2442 465 2414 447 2496"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-182" data-id="sitemap-182" data-toggle="modal" class="sitemap">
                <polygon points="555 2587 567 2535 569 2524 447 2496 429 2577 551 2605"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-183" data-id="sitemap-183" data-toggle="modal" class="sitemap">
                <polygon points="551 2605 545 2637 532 2688 410 2660 429 2577"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-184" data-id="sitemap-184" data-toggle="modal" class="sitemap">
                <polygon points="391 2743 372 2825 495 2851 514 2771"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-185" data-id="sitemap-185" data-toggle="modal" class="sitemap">
                <polygon points="532 2688 410 2660 391 2743 514 2771"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-186" data-id="sitemap-186" data-toggle="modal" class="sitemap">
                <polygon points="632 2819 618 2880 495 2851 508 2791"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-187" data-id="sitemap-187" data-toggle="modal" class="sitemap">
                <polygon points="644 2769 632 2819 508 2791 521 2740"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-188" data-id="sitemap-188" data-toggle="modal" class="sitemap">
                <polygon points="655 2718 644 2769 521 2740 532 2688"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-189" data-id="sitemap-189" data-toggle="modal" class="sitemap">
                <polygon points="667 2666 655 2718 532 2688 545 2637"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-190" data-id="sitemap-190" data-toggle="modal" class="sitemap">
                <polygon points="679 2615 667 2666 545 2637 555 2587"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-191" data-id="sitemap-191" data-toggle="modal" class="sitemap">
                <polygon points="691 2562 679 2615 555 2587 567 2535"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-192" data-id="sitemap-192" data-toggle="modal" class="sitemap">
                <polygon points="703 2511 691 2562 567 2535 579 2483"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-193" data-id="sitemap-193" data-toggle="modal" class="sitemap">
                <polygon points="715 2462 703 2511 579 2483 590 2434"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-194" data-id="sitemap-194" data-toggle="modal" class="sitemap">
                <polygon points="727 2409 715 2462 590 2434 602 2382"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-195" data-id="sitemap-195" data-toggle="modal" class="sitemap">
                <polygon points="738 2358 727 2409 602 2382 615 2331"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-196" data-id="sitemap-196" data-toggle="modal" class="sitemap">
                <polygon points="749 2309 738 2358 615 2331 627 2279"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-197" data-id="sitemap-197" data-toggle="modal" class="sitemap">
                <polygon points="762 2257 749 2309 627 2279 639 2227"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-198" data-id="sitemap-198" data-toggle="modal" class="sitemap">
                <polygon points="774 2206 762 2257 639 2227 650 2177"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-199" data-id="sitemap-199" data-toggle="modal" class="sitemap">
                <polygon points="785 2155 774 2206 650 2177 661 2125"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-200" data-id="sitemap-200" data-toggle="modal" class="sitemap">
                <polygon points="797 2103 785 2155 661 2125 673 2073"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-201" data-id="sitemap-201" data-toggle="modal" class="sitemap">
                <polygon points="808 2054 797 2103 673 2073 684 2023"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-202" data-id="sitemap-202" data-toggle="modal" class="sitemap">
                <polygon points="819 2001 808 2054 684 2023 697 1972"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-203" data-id="sitemap-203" data-toggle="modal" class="sitemap">
                <polygon points="832 1951 819 2001 697 1972 709 1921"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-204" data-id="sitemap-204" data-toggle="modal" class="sitemap">
                <polygon points="842 1899 832 1951 709 1921 720 1871"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-205" data-id="sitemap-205" data-toggle="modal" class="sitemap">
                <polygon points="854 1847 842 1899 720 1871 732 1820"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-206" data-id="sitemap-206" data-toggle="modal" class="sitemap">
                <polygon points="709 1349 957 1407 854 1847 732 1820 738 1788 616 1760"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-207" data-id="sitemap-207" data-toggle="modal" class="sitemap">
                <polygon points="305 2700 296 2735 290 2742 297 2698"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-208" data-id="sitemap-208" data-toggle="modal" class="sitemap">
                <polygon points="324 2618 305 2700 297 2698 303 2655 300 2634 195 2614 200 2589"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-209" data-id="sitemap-209" data-toggle="modal" class="sitemap">
                <polygon points="341 2536 324 2618 200 2589 219 2507"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-210" data-id="sitemap-210" data-toggle="modal" class="sitemap">
                <polygon points="360 2454 341 2536 219 2507 237 2425"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-211" data-id="sitemap-211" data-toggle="modal" class="sitemap">
                <polygon points="379 2372 360 2454 237 2425 256 2343"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-212" data-id="sitemap-212" data-toggle="modal" class="sitemap">
                <polygon points="398 2290 379 2372 256 2343 276 2261"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-213" data-id="sitemap-213" data-toggle="modal" class="sitemap">
                <polygon points="417 2210 398 2290 276 2261 293 2180"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-214" data-id="sitemap-214" data-toggle="modal" class="sitemap">
                <polygon points="435 2127 417 2210 293 2180 312 2097"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-215" data-id="sitemap-215" data-toggle="modal" class="sitemap">
                <polygon points="454 2044 435 2127 312 2097 332 2017"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-216" data-id="sitemap-216" data-toggle="modal" class="sitemap">
                <polygon points="350 1933 474 1963 454 2044 332 2017"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-217" data-id="sitemap-217" data-toggle="modal" class="sitemap">
                <polygon points="200 2589 195 2614 69 2592 76 2560"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-218" data-id="sitemap-218" data-toggle="modal" class="sitemap">
                <polygon points="216 2518 200 2589 76 2560 93 2489"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-219" data-id="sitemap-219" data-toggle="modal" class="sitemap">
                <polygon points="232 2447 216 2518 93 2489 109 2417"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-220" data-id="sitemap-220" data-toggle="modal" class="sitemap">
                <polygon points="249 2375 232 2447 109 2417 126 2345"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-221" data-id="sitemap-221" data-toggle="modal" class="sitemap">
                <polygon points="266 2303 249 2375 126 2345 143 2274"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-222" data-id="sitemap-222" data-toggle="modal" class="sitemap">
                <polygon points="282 2231 266 2303 143 2274 159 2203"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-223" data-id="sitemap-223" data-toggle="modal" class="sitemap">
                <polygon points="299 2159 282 2231 159 2203 175 2130"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-224" data-id="sitemap-224" data-toggle="modal" class="sitemap">
                <polygon points="315 2087 299 2159 175 2130 181 2101 185 2102 196 2061"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-225" data-id="sitemap-225" data-toggle="modal" class="sitemap">
                <polygon points="332 2017 315 2087 196 2061 217 1990"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-226" data-id="sitemap-226" data-toggle="modal" class="sitemap">
                <polygon points="347 1943 332 2017 217 1990 236 1917"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-227" data-id="sitemap-227" data-toggle="modal" class="sitemap">
                <polygon points="350 1933 347 1943 236 1917 237 1908"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-228" data-id="sitemap-228" data-toggle="modal" class="sitemap">
                <polygon points="280 1703 253 1827 275 1832 304 1709"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-229" data-id="sitemap-229" data-toggle="modal" class="sitemap">
                <polygon points="348 1849 275 1832 304 1709 377 1725"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-230" data-id="sitemap-230" data-toggle="modal" class="sitemap">
                <polygon points="420 1866 348 1849 377 1725 447 1742"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-231" data-id="sitemap-231" data-toggle="modal" class="sitemap">
                <polygon points="520 1759 493 1881 420 1866 447 1742"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-232" data-id="sitemap-232" data-toggle="modal" class="sitemap">
                <polygon points="498 1624 549 1635 520 1759 468 1747"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-233" data-id="sitemap-233" data-toggle="modal" class="sitemap">
                <polygon points="446 1613 498 1624 468 1747 418 1735"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-234" data-id="sitemap-234" data-toggle="modal" class="sitemap">
                <polygon points="395 1601 446 1613 418 1735 367 1722"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-235" data-id="sitemap-235" data-toggle="modal" class="sitemap">
                <polygon points="344 1590 395 1601 367 1722 316 1712"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-236" data-id="sitemap-236" data-toggle="modal" class="sitemap">
                <polygon points="304 1581 344 1590 316 1712 280 1703"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-237" data-id="sitemap-237" data-toggle="modal" class="sitemap">
                <polygon points="358 1528 317 1519 323 1488 337 1396 386 1405"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-238" data-id="sitemap-238" data-toggle="modal" class="sitemap">
                <polygon points="386 1405 358 1528 409 1539 437 1417"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-239" data-id="sitemap-239" data-toggle="modal" class="sitemap">
                <polygon points="437 1417 409 1539 459 1553 488 1429"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-240" data-id="sitemap-240" data-toggle="modal" class="sitemap">
                <polygon points="511 1564 459 1553 488 1429 539 1440"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-241" data-id="sitemap-241" data-toggle="modal" class="sitemap">
                <polygon points="590 1453 563 1576 511 1564 539 1440"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-242" data-id="sitemap-242" data-toggle="modal" class="sitemap">
                <polygon points="568 1319 618 1330 590 1453 539 1440"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-243" data-id="sitemap-243" data-toggle="modal" class="sitemap">
                <polygon points="515 1307 568 1319 539 1440 488 1429"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-244" data-id="sitemap-244" data-toggle="modal" class="sitemap">
                <polygon points="465 1293 515 1307 488 1429 437 1417"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-245" data-id="sitemap-245" data-toggle="modal" class="sitemap">
                <polygon points="417 1281 465 1293 437 1417 386 1405"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-246" data-id="sitemap-246" data-toggle="modal" class="sitemap">
                <polygon points="362 1269 417 1281 386 1405 337 1396"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-247" data-id="sitemap-247" data-toggle="modal" class="sitemap">
                <polygon points="355 1266 362 1269 340 1378"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-248" data-id="sitemap-248" data-toggle="modal" class="sitemap">
                <polygon points="406 1087 383 1082 364 1205 377 1208"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-249" data-id="sitemap-249" data-toggle="modal" class="sitemap">
                <polygon points="406 1087 377 1208 429 1220 456 1098"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-250" data-id="sitemap-250" data-toggle="modal" class="sitemap">
                <polygon points="456 1098 429 1220 480 1232 508 1110"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-251" data-id="sitemap-251" data-toggle="modal" class="sitemap">
                <polygon points="508 1110 480 1232 531 1245 559 1122"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-252" data-id="sitemap-252" data-toggle="modal" class="sitemap">
                <polygon points="559 1122 531 1245 583 1257 611 1133"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-253" data-id="sitemap-253" data-toggle="modal" class="sitemap">
                <polygon points="662 1146 633 1269 583 1257 611 1133"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-254" data-id="sitemap-254" data-toggle="modal" class="sitemap">
                <polygon points="638 1010 689 1022 662 1146 611 1133"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-255" data-id="sitemap-255" data-toggle="modal" class="sitemap">
                <polygon points="587 998 638 1010 611 1133 559 1122"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-256" data-id="sitemap-256" data-toggle="modal" class="sitemap">
                <polygon points="535 986 587 998 559 1122 508 1110"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-257" data-id="sitemap-257" data-toggle="modal" class="sitemap">
                <polygon points="484 975 535 986 508 1110 456 1098"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-258" data-id="sitemap-258" data-toggle="modal" class="sitemap">
                <polygon points="435 962 484 975 456 1098 406 1087"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-259" data-id="sitemap-259" data-toggle="modal" class="sitemap">
                <polygon points="399 955 435 962 406 1087 383 1082"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-260" data-id="sitemap-260" data-toggle="modal" class="sitemap">
                <polygon points="753 1165 725 1290 776 1300 803 1178"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-261" data-id="sitemap-261" data-toggle="modal" class="sitemap">
                <polygon points="803 1178 776 1300 827 1313 855 1190"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-262" data-id="sitemap-262" data-toggle="modal" class="sitemap">
                <polygon points="855 1190 827 1313 880 1324 907 1202"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-263" data-id="sitemap-263" data-toggle="modal" class="sitemap">
                <polygon points="907 1202 880 1324 930 1337 958 1213"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-264" data-id="sitemap-264" data-toggle="modal" class="sitemap">
                <polygon points="831 1054 781 1043 753 1165 803 1178"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-265" data-id="sitemap-265" data-toggle="modal" class="sitemap">
                <polygon points="884 1066 831 1054 803 1178 855 1190"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-266" data-id="sitemap-266" data-toggle="modal" class="sitemap">
                <polygon points="934 1079 884 1066 855 1190 907 1202"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-267" data-id="sitemap-267" data-toggle="modal" class="sitemap">
                <polygon points="985 1090 934 1079 907 1202 958 1213"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-268" data-id="sitemap-268" data-toggle="modal" class="sitemap">
                <polygon points="958 1213 930 1337 980 1348 1008 1226"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-269" data-id="sitemap-269" data-toggle="modal" class="sitemap">
                <polygon points="1008 1226 980 1348 1032 1360 1060 1237"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-270" data-id="sitemap-270" data-toggle="modal" class="sitemap">
                <polygon points="1083 1372 1032 1360 1060 1237 1111 1249"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-271" data-id="sitemap-271" data-toggle="modal" class="sitemap">
                <polygon points="1036 1101 985 1090 958 1213 1008 1226"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-272" data-id="sitemap-272" data-toggle="modal" class="sitemap">
                <polygon points="1088 1113 1036 1101 1008 1226 1060 1237"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-273" data-id="sitemap-273" data-toggle="modal" class="sitemap">
                <polygon points="1140 1125 1088 1113 1060 1237 1111 1249"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-274" data-id="sitemap-274" data-toggle="modal" class="sitemap">
                <polygon points="1190 1137 1140 1125 1111 1249 1162 1260"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-275" data-id="sitemap-275" data-toggle="modal" class="sitemap">
                <polygon points="1241 1148 1190 1137 1162 1260 1214 1273"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-276" data-id="sitemap-276" data-toggle="modal" class="sitemap">
                <polygon points="1162 1260 1111 1249 1083 1372 1134 1384"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-277" data-id="sitemap-277" data-toggle="modal" class="sitemap">
                <polygon points="1214 1273 1162 1260 1134 1384 1185 1396"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-278" data-id="sitemap-278" data-toggle="modal" class="sitemap">
                <polygon points="1214 1273 1185 1396 1237 1407 1264 1284"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-279" data-id="sitemap-279" data-toggle="modal" class="sitemap">
                <polygon points="1293 1161 1241 1148 1214 1273 1264 1284"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-280" data-id="sitemap-280" data-toggle="modal" class="sitemap">
                <polygon points="1264 1284 1237 1407 1288 1419 1315 1296"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-281" data-id="sitemap-281" data-toggle="modal" class="sitemap">
                <polygon points="1343 1173 1293 1161 1264 1284 1315 1296"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-282" data-id="sitemap-282" data-toggle="modal" class="sitemap">
                <polygon points="1315 1296 1288 1419 1340 1429 1367 1307"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-283" data-id="sitemap-283" data-toggle="modal" class="sitemap">
                <polygon points="1395 1185 1343 1173 1315 1296 1367 1307"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-284" data-id="sitemap-284" data-toggle="modal" class="sitemap">
                <polygon points="1367 1307 1340 1429 1391 1443 1418 1319"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-285" data-id="sitemap-285" data-toggle="modal" class="sitemap">
                <polygon points="1446 1196 1395 1185 1367 1307 1418 1319"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-286" data-id="sitemap-286" data-toggle="modal" class="sitemap">
                <polygon points="1418 1319 1391 1443 1442 1454 1470 1331"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-287" data-id="sitemap-287" data-toggle="modal" class="sitemap">
                <polygon points="1498 1208 1446 1196 1418 1319 1470 1331"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-288" data-id="sitemap-288" data-toggle="modal" class="sitemap">
                <polygon points="1470 1331 1442 1454 1493 1465 1520 1342"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-289" data-id="sitemap-289" data-toggle="modal" class="sitemap">
                <polygon points="1548 1220 1498 1208 1470 1331 1520 1342"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-290" data-id="sitemap-290" data-toggle="modal" class="sitemap">
                <polygon points="1520 1342 1493 1465 1543 1478 1570 1355"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-291" data-id="sitemap-291" data-toggle="modal" class="sitemap">
                <polygon points="1600 1231 1548 1220 1520 1342 1570 1355"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-292" data-id="sitemap-292" data-toggle="modal" class="sitemap">
                <polygon points="1624 1237 1620 1283 1596 1359 1570 1355 1600 1231"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-293" data-id="sitemap-293" data-toggle="modal" class="sitemap">
                <polygon points="1626 1402 1608 1401 1594 1370 1596 1359 1570 1355 1543 1478 1605 1493"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-294" data-id="sitemap-294" data-toggle="modal" class="sitemap">
                <polygon points="1688 1411 1626 1402 1605 1493 1667 1506"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-295" data-id="sitemap-295" data-toggle="modal" class="sitemap">
                <polygon points="1750 1420 1743 1418 1688 1411 1667 1506 1728 1519"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-296" data-id="sitemap-296" data-toggle="modal" class="sitemap">
                <polygon points="1811 1437 1750 1420 1728 1519 1789 1534"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-297" data-id="sitemap-297" data-toggle="modal" class="sitemap">
                <polygon points="1851 1548 1789 1534 1811 1437 1839 1446"/>
                </a>
                <a class="container-siteplan" xlink:href="" href="#modalTambah" id="sitemap-298" data-id="sitemap-298" data-toggle="modal" class="sitemap">
                <polygon points="407 895 383 1082 337 1396 323 1488 261 1788 231 1942 185 2102 129 2094 36 2586 300 2634 303 2655 271 2871 250 2916 218 2939 174 2950 108 3305 121 3309 86 3447 57 3635 25 3777 526 3898 644 3402 659 3372 732 3029 752 2986 1078 3067 1088 3065 1096 3346 1108 3407 1137 3436 1220 3453 1245 3414 1254 3304 1266 3229 1256 3215 1256 3140 1268 3027 1305 2630 1309 2520 1426 2519 1465 2029 1783 2070 1776 2051 1797 1927 1863 1656 1839 1446 1743 1418 1608 1401 1594 1370 1620 1283 1632 1175"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-299" data-id="sitemap-299" data-toggle="modal" class="sitemap">
                <polygon points="835 807 813 910 873 924 897 822"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-300" data-id="sitemap-300" data-toggle="modal" class="sitemap">
                <polygon points="897 822 873 924 935 939 958 837"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-301" data-id="sitemap-301" data-toggle="modal" class="sitemap">
                <polygon points="919 718 859 704 835 807 897 822"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-302" data-id="sitemap-302" data-toggle="modal" class="sitemap">
                <polygon points="982 733 919 718 897 822 958 837"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-303" data-id="sitemap-303" data-toggle="modal" class="sitemap">
                <polygon points="958 837 935 939 996 953 1020 851"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-304" data-id="sitemap-304" data-toggle="modal" class="sitemap">
                <polygon points="1043 748 982 733 958 837 1020 851"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-305" data-id="sitemap-305" data-toggle="modal" class="sitemap">
                <polygon points="1020 851 996 953 1058 966 1080 866"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-306" data-id="sitemap-306" data-toggle="modal" class="sitemap">
                <polygon points="1104 762 1043 748 1020 851 1080 866"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-307" data-id="sitemap-307" data-toggle="modal" class="sitemap">
                <polygon points="1080 866 1058 966 1118 980 1143 880"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-308" data-id="sitemap-308" data-toggle="modal" class="sitemap">
                <polygon points="1166 775 1104 762 1080 866 1143 880"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-309" data-id="sitemap-309" data-toggle="modal" class="sitemap">
                <polygon points="1143 880 1118 980 1182 996 1205 894"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-310" data-id="sitemap-310" data-toggle="modal" class="sitemap">
                <polygon points="1227 791 1166 775 1143 880 1205 894"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-311" data-id="sitemap-311" data-toggle="modal" class="sitemap">
                <polygon points="1205 894 1182 996 1244 1010 1266 907"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-312" data-id="sitemap-312" data-toggle="modal" class="sitemap">
                <polygon points="1288 803 1227 791 1205 894 1266 907"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-313" data-id="sitemap-313" data-toggle="modal" class="sitemap">
                <polygon points="1266 907 1244 1010 1305 1022 1327 921"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-314" data-id="sitemap-314" data-toggle="modal" class="sitemap">
                <polygon points="1351 819 1288 803 1266 907 1327 921"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-315" data-id="sitemap-315" data-toggle="modal" class="sitemap">
                <polygon points="1327 921 1305 1022 1365 1036 1387 934"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-316" data-id="sitemap-316" data-toggle="modal" class="sitemap">
                <polygon points="1411 831 1351 819 1327 921 1387 934"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-317" data-id="sitemap-317" data-toggle="modal" class="sitemap">
                <polygon points="1472 847 1411 831 1387 934 1450 950"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-318" data-id="sitemap-318" data-toggle="modal" class="sitemap">
                <polygon points="1428 1050 1365 1036 1387 934 1450 950"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-319" data-id="sitemap-319" data-toggle="modal" class="sitemap">
                <polygon points="1450 950 1428 1050 1486 1064 1511 964"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-320" data-id="sitemap-320" data-toggle="modal" class="sitemap">
                <polygon points="1534 859 1472 847 1450 950 1511 964"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-321" data-id="sitemap-321" data-toggle="modal" class="sitemap">
                <polygon points="1548 1078 1486 1064 1511 964 1571 978"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-322" data-id="sitemap-322" data-toggle="modal" class="sitemap">
                <polygon points="1595 873 1534 859 1511 964 1571 978"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-323" data-id="sitemap-323" data-toggle="modal" class="sitemap">
                <polygon points="1609 1093 1548 1078 1571 978 1634 992"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-324" data-id="sitemap-324" data-toggle="modal" class="sitemap">
                <polygon points="1656 888 1595 873 1571 978 1634 992"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-325" data-id="sitemap-325" data-toggle="modal" class="sitemap">
                <polygon points="1690 1003 1668 1109 1609 1093 1634 992"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-326" data-id="sitemap-326" data-toggle="modal" class="sitemap">
                <polygon points="1690 1003 1634 992 1656 888 1715 901"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-327" data-id="sitemap-327" data-toggle="modal" class="sitemap">
                <polygon points="460 722 455 827 475 831 498 732"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-328" data-id="sitemap-328" data-toggle="modal" class="sitemap">
                <polygon points="498 732 475 831 535 845 560 744"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-329" data-id="sitemap-329" data-toggle="modal" class="sitemap">
                <polygon points="560 744 621 761 596 861 535 845"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-330" data-id="sitemap-330" data-toggle="modal" class="sitemap">
                <polygon points="621 761 683 773 659 875 596 861"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-331" data-id="sitemap-331" data-toggle="modal" class="sitemap">
                <polygon points="744 785 719 890 659 875 683 773"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-332" data-id="sitemap-332" data-toggle="modal" class="sitemap">
                <polygon points="706 670 769 683 744 785 683 773"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-333" data-id="sitemap-333" data-toggle="modal" class="sitemap">
                <polygon points="644 656 706 670 683 773 621 761"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-334" data-id="sitemap-334" data-toggle="modal" class="sitemap">
                <polygon points="585 643 644 656 621 761 560 744"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-335" data-id="sitemap-335" data-toggle="modal" class="sitemap">
                <polygon points="522 628 585 643 560 744 498 732"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-336" data-id="sitemap-336" data-toggle="modal" class="sitemap">
                <polygon points="470 616 522 628 498 732 460 722"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-337" data-id="sitemap-337" data-toggle="modal" class="sitemap">
                <polygon points="499 449 478 521 484 445"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-338" data-id="sitemap-338" data-toggle="modal" class="sitemap">
                <polygon points="537 567 478 553 478 521 499 449 559 464"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-339" data-id="sitemap-339" data-toggle="modal" class="sitemap">
                <polygon points="596 580 537 567 559 464 620 478"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-340" data-id="sitemap-340" data-toggle="modal" class="sitemap">
                <polygon points="620 478 683 492 657 594 596 580"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-341" data-id="sitemap-341" data-toggle="modal" class="sitemap">
                <polygon points="719 608 657 594 683 492 743 506"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-342" data-id="sitemap-342" data-toggle="modal" class="sitemap">
                <polygon points="804 520 782 624 719 608 743 506"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-343" data-id="sitemap-343" data-toggle="modal" class="sitemap">
                <polygon points="766 404 828 417 804 520 743 506"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-344" data-id="sitemap-344" data-toggle="modal" class="sitemap">
                <polygon points="706 390 766 404 743 506 683 492"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-345" data-id="sitemap-345" data-toggle="modal" class="sitemap">
                <polygon points="644 376 706 390 683 492 620 478"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-346" data-id="sitemap-346" data-toggle="modal" class="sitemap">
                <polygon points="583 362 644 376 620 478 559 464"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-347" data-id="sitemap-347" data-toggle="modal" class="sitemap">
                <polygon points="524 350 583 362 559 464 499 449"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-348" data-id="sitemap-348" data-toggle="modal" class="sitemap">
                <polygon points="490 340 524 350 499 449 484 445"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-349" data-id="sitemap-349" data-toggle="modal" class="sitemap">
                <polygon points="866 256 841 360 492 279 498 262 802 319 817 244"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-350" data-id="sitemap-350" data-toggle="modal" class="sitemap">
                <polygon points="829 136 887 152 866 256 817 244"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-351" data-id="sitemap-351" data-toggle="modal" class="sitemap">
                <polygon points="1182 712 1731 842 1746 761 1231 692 1234 624 1204 613"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-352" data-id="sitemap-352" data-toggle="modal" class="sitemap">
                <polygon points="1204 613 1182 712 1120 699 1142 601"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-353" data-id="sitemap-353" data-toggle="modal" class="sitemap">
                <polygon points="1142 601 1120 699 1058 686 1082 586"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-354" data-id="sitemap-354" data-toggle="modal" class="sitemap">
                <polygon points="1082 586 1058 686 996 672 1021 570"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-355" data-id="sitemap-355" data-toggle="modal" class="sitemap">
                <polygon points="1021 570 996 672 934 659 959 560"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-356" data-id="sitemap-356" data-toggle="modal" class="sitemap">
                <polygon points="959 560 934 659 873 644 897 545"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-357" data-id="sitemap-357" data-toggle="modal" class="sitemap">
                <polygon points="1229 510 1241 514 1234 624 1204 613"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-358" data-id="sitemap-358" data-toggle="modal" class="sitemap">
                <polygon points="1168 497 1229 510 1204 613 1142 601"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-359" data-id="sitemap-359" data-toggle="modal" class="sitemap">
                <polygon points="1105 483 1168 497 1142 601 1082 586"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-360" data-id="sitemap-360" data-toggle="modal" class="sitemap">
                <polygon points="1043 467 1105 483 1082 586 1021 570"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-361" data-id="sitemap-361" data-toggle="modal" class="sitemap">
                <polygon points="983 455 1043 467 1021 570 959 560"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-362" data-id="sitemap-362" data-toggle="modal" class="sitemap">
                <polygon points="920 440 983 455 959 560 897 545"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-363" data-id="sitemap-363" data-toggle="modal" class="sitemap">id="sitemap
                <polygon points="1040 191 979 171 959 279 1021 288"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-364" data-id="sitemap-364" data-toggle="modal" class="sitemap">
                <polygon points="1102 204 1040 191 1021 288 1079 305"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-365" data-id="sitemap-365" data-toggle="modal" class="sitemap">
                <polygon points="995 389 933 380 959 279 1021 288"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-366" data-id="sitemap-366" data-toggle="modal" class="sitemap">
                <polygon points="1057 402 995 389 1021 288 1079 305"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-367" data-id="sitemap-367" data-toggle="modal" class="sitemap">
                <polygon points="1119 419 1057 402 1079 305 1141 321"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-368" data-id="sitemap-368" data-toggle="modal" class="sitemap">
                <polygon points="1164 214 1102 204 1079 305 1141 321"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-369" data-id="sitemap-369" data-toggle="modal" class="sitemap">
                <polygon points="1184 432 1119 419 1141 321 1203 334"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-370" data-id="sitemap-370" data-toggle="modal" class="sitemap">
                <polygon points="1223 230 1164 214 1141 321 1203 334"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-371" data-id="sitemap-371" data-toggle="modal" class="sitemap">
                <polygon points="1245 448 1184 432 1203 334 1255 347"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-372" data-id="sitemap-372" data-toggle="modal" class="sitemap">
                <polygon points="1258 233 1223 230 1203 334 1255 347"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-373" data-id="sitemap-373" data-toggle="modal" class="sitemap">
                <polygon points="910 48 904 96 839 77 846 36"/>
                </a>
                <a xlink:href="" href="#modalTambah" id="sitemap-374" data-id="sitemap-374" data-toggle="modal" class="sitemap">
                <polygon points="1008 67 995 109 1262 174 1264 125"/>
                </a>
                <a class="container-siteplan" xlink:href="" href="#modalTambah" id="sitemap-375" data-id="sitemap-375" data-toggle="modal" class="sitemap">
                <polygon points="846 36 1264 125 1231 692 1746 761 1653 1170 409 878 414 843 452 836 498 262 802 319"/>
                </a>
                </svg>
            </div>
        </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Tambah Data Kavling</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label>Lokasi Perumahan</label>
                <select name="lokasi" id="lokasi" class="form-control">
                    <option value="">--Pilih--</option>
                    <?php foreach($perum as $p){ ?>
                        <option value="<?= $p['id_perumahan'] ?>"><?= $p['nama_perumahan'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" name="status_cluster" id="status_cluster">
            <input type="hidden" name="sitemap_id" id="sitemap-id">
            <div class="form-group">
                <label>Cluster</label>
                <select class="form-control" name="cluster" id="cluster">
                    <option value="">--Pilih--</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tipe</label>
                <!-- <input type="text" name="tipe" id="tipe" class="form-control"> -->
                <select name="tipe" id="tipe" class="form-control">
                    <option value="">--Pilih--</option>
                </select>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Blok</label>
                        <input type="text" name="blok" id="blok" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>No Rumah</label>
                        <input type="text" name="no_rumah" id="no_rumah" class="form-control">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Luas Tanah (m<sup>2</sup>)</label>
                        <input type="text" name="lt" id="lt" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Luas Bangunan (m<sup>2</sup>)</label>
                        <input type="text" name="lb" id="lb" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="text" name="v_harga" id="v_harga" class="form-control">
                <input type="text" hidden name="harga" id="harga" class="form-control">
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-success btn-sm" id="add-kavling"><i class="fa fa-save"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="staticBackdropLabel">Edit Data Kavling</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="id_kavling" id="id_kavling">
            <div class="form-group">
                <label>Lokasi Perumahan</label>
                <select name="lokasi_e" id="lokasi_e" class="form-control">
                    <option value="">--Pilih--</option>
                    <?php foreach($perum as $p){ ?>
                        <option value="<?= $p['id_perumahan'] ?>"><?= $p['nama_perumahan'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" name="status_cluster_e" id="status_cluster_e">
            <div class="form-group">
                <label>Cluster</label>
                <select class="form-control" name="cluster_e" id="cluster_e">
                    <option value="">--Pilih--</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tipe</label>
                <input type="hidden" name="id_tipe" id="id_tipe" class="form-control">
                <select name="tipe_e" id="tipe_e" class="form-control">
                    <option value="">--Pilih--</option>
                </select>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Blok</label>
                        <input type="text" name="blok_e" id="blok_e" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>No Rumah</label>
                        <input type="text" name="no_rumah_e" id="no_rumah_e" class="form-control">
                    </div>
                </div>
            </div>
            

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Luas Tanah (m<sup>2</sup>)</label>
                        <input type="text" name="lt_e" id="lt_e" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Luas Bangunan (m<sup>2</sup>)</label>
                        <input type="text" name="lb_e" id="lb_e" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="text" name="v_harga_e" id="v_harga_e" class="form-control">
                <input type="text" hidden name="harga_e" id="harga_e" class="form-control">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="edit-kavling"><i class="fa fa-edit"></i> Edit Data</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/adminlte3/plugins/jquery/jquery.min.js') ?>"></script>
<script>
        shape = document.getElementsByTagName("svg")[0];
        shape.setAttribute("viewBox", "-933.9775999999999 -86.35999999999997 3892.1472 4147.2"); 

        var mouseStartPosition = {x: 0, y: 0};
        var mousePosition = {x: 0, y: 0};
        var viewboxStartPosition = {x: 0, y: 0};
        var viewboxPosition = {x: 0, y: 0};
        var viewboxSize = {x: 1877, y: 2000};
        var viewboxScale = 1.0;

        var mouseDown = false;

        shape.addEventListener("mousemove", mousemove);
        shape.addEventListener("mousedown", mousedown);
        shape.addEventListener("wheel", wheel);

        function mousedown(e) {
        mouseStartPosition.x = e.pageX;
        mouseStartPosition.y = e.pageY;

        viewboxStartPosition.x = viewboxPosition.x;
        viewboxStartPosition.y = viewboxPosition.y;

        window.addEventListener("mouseup", mouseup);

        mouseDown = true;
        }

        function setviewbox()
        {
        var vp = {x: 0, y: 0};
        var vs = {x: 0, y: 0};
        
        vp.x = viewboxPosition.x;
        vp.y = viewboxPosition.y;
        
        vs.x = viewboxSize.x * viewboxScale;
        vs.y = viewboxSize.y * viewboxScale;

        shape = document.getElementsByTagName("svg")[0];
        shape.setAttribute("viewBox", vp.x + " " + vp.y + " " + vs.x + " " + vs.y);
        
        }

        function mousemove(e)
        {
        mousePosition.x = e.offsetX;
        mousePosition.y = e.offsetY;
        
        if (mouseDown)
        {
            viewboxPosition.x = viewboxStartPosition.x + (mouseStartPosition.x - e.pageX) * viewboxScale;
            viewboxPosition.y = viewboxStartPosition.y + (mouseStartPosition.y - e.pageY) * viewboxScale;

            setviewbox();
        }
        
        var mpos = {x: mousePosition.x * viewboxScale, y: mousePosition.y * viewboxScale};
        var vpos = {x: viewboxPosition.x, y: viewboxPosition.y};
        var cpos = {x: mpos.x + vpos.x, y: mpos.y + vpos.y}
        }

        function mouseup(e) {
        window.removeEventListener("mouseup", mouseup);
        
        mouseDown = false;
        }

        function wheel(e) {
        var scale = (e.deltaY < 0) ? 0.8 : 1.2;
        
            if ((viewboxScale * scale < 8.) && (viewboxScale * scale > 1./256.))
            {  
                var mpos = {x: mousePosition.x * viewboxScale, y: mousePosition.y * viewboxScale};
                var vpos = {x: viewboxPosition.x, y: viewboxPosition.y};
                var cpos = {x: mpos.x + vpos.x, y: mpos.y + vpos.y}

                viewboxPosition.x = (viewboxPosition.x - cpos.x) * scale + cpos.x;
                viewboxPosition.y = (viewboxPosition.y - cpos.y) * scale + cpos.y;
                viewboxScale *= scale;
            
                setviewbox();
        }
        }

</script>

<script>
    $(document).ready(function () {
        $(function () {
            $('[data-toggle="popover"]').popover()
        });
        $('.sitemap').click(function(){
            var id = $(this).data('id');
            $('#sitemap-id').val(id);
        });
    });

</script>
<?php if($kavling){ ?>
    <script>
        <?php foreach($kavling as $item) {?>
            <?php if($item->sitemap_id !== null){ ?>
                $('#<?= $item->sitemap_id?>').attr("href", "#");
                $('#<?= $item->sitemap_id?>').attr("data-toggle", "popover");
                $('#<?= $item->sitemap_id?>').attr("data-trigger", "hover");
                $('#<?= $item->sitemap_id?>').attr("data-placement", "top");
                $('#<?= $item->sitemap_id?>').attr("title", "Cluster <?= $item->nama_cluster ?> Blok <?= $item->blok ?> No <?= $item->no_rumah ?>");
                $('#<?= $item->sitemap_id?>').attr("data-html", true);
                $('#<?= $item->sitemap_id?>').attr("data-content", "Tipe <?= $item->tipe ?> <br> Panjang = <?= $item->lt ?> m<sup>2</sup> <br> Lebar = <?= $item->lb ?> m<sup>2</sup> <br> Harga = Rp. <?= number_format($item->harga) ?>");
                
                <?php if($item->status_kavling == 1){ ?>
                    $('#<?= $item->sitemap_id?>').css("fill", "<?= ($item->status_kavling == 1)? "rgb(247, 202, 24)": "rgb(113, 128, 150)" ?>");
                <?php } else if($item->status_kavling == 2){ ?>
                    $('#<?= $item->sitemap_id?>').css("fill", "<?= ($item->status_kavling == 2)? "rgb(201, 24, 29)" : "rgb(113, 128, 150)" ?>");
                <?php } else if($item->status_kavling == 0){ ?>
                    $('#<?= $item->sitemap_id?>').css("fill", "rgb(113, 128, 150)");
                <?php } ?>
               
                $('#<?= $item->sitemap_id?>').css("white-space", "nowrap");
            <?php } ?>
        <?php } ?>
    </script>
<?php }; ?>