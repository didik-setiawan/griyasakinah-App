<?php
        // $id = userId();
        // $path = 'dashboard/';
        // // jika path kosong maka akan error
        // // $path = cek_url();
        // $data = checkUserLogin($id, $path);
        // echo 'Nama User : '.$data->NAMA.' MODUL: '.$data->JUDUL_MODUL.' URL : '.$data->URL_MODUL;
?>

<form action="" method="post">
<div class="card card-secondary col-4 container">
    <div class="card-header">
        <h3 class="card-title">Bootstrap Switch</h3>
    </div>
    <div class="card-body">
        <div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-focused bootstrap-switch-animate bootstrap-switch-on" style="width: 86px;">
            <div class="bootstrap-switch-container" style="width: 126px; margin-left: 0px;">
                <span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 42px;">ON</span>
                <span class="bootstrap-switch-label" style="width: 42px;">&nbsp;</span>
                <span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 42px;">OFF</span>
                <input type="checkbox" name="my-checkbox" checked="" data-bootstrap-switch="">
            </div>
        </div>
        <div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-on bootstrap-switch-focused" style="width: 86px;">
            <div class="bootstrap-switch-container" style="width: 126px; margin-left: 0px;">
                <span class="bootstrap-switch-handle-on bootstrap-switch-success" style="width: 42px;">ON</span>
                <span class="bootstrap-switch-label" style="width: 42px;">&nbsp;</span>
                <span class="bootstrap-switch-handle-off bootstrap-switch-danger" style="width: 42px;">OFF</span>
                <input type="checkbox" name="my-checkbox" checked="" data-bootstrap-switch="" data-off-color="danger" data-on-color="success">
            </div>
        </div>
    </div>
    <button name="kirim">kirim</button>
</div>

</form>

<?php
print_r($this->input->post());
?>