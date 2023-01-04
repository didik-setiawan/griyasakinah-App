<?php
// ini ditampilkan sesuai kebutuhan page masing masing untuk MODAL BOOTSTRAP
$url_cek = cek_url();
?>

<?php
if ($url_cek == 'users_groups/modules/') {
?>
<script type="text/javascript">
$(function() {
    <?php
            if ($this->session->has_userdata('modul_update')) {
            ?>
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: '<?= $this->session->flashdata('modul_update'); ?>',
        showConfirmButton: false,
        timer: 1500
    })
    <?php
            }
            if ($this->session->has_userdata('modul_gagal')) {
            ?>
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: '<?= $this->session->flashdata('modul_gagal'); ?>',
        showConfirmButton: false,
        timer: 1500
    })
    <?php
            }
            ?>

});
</script>
<?php
}
?>

<?php
if ($url_cek == 'users_groups/role_group/') {
?>
<script type="text/javascript">
$(function() {
    <?php
            if ($this->session->has_userdata('modul_update')) {
            ?>
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: '<?= $this->session->flashdata('modul_update'); ?>',
        showConfirmButton: false,
        timer: 1500
    })
    <?php
            }
            if ($this->session->has_userdata('modul_gagal')) {
            ?>
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: '<?= $this->session->flashdata('modul_gagal'); ?>',
        showConfirmButton: false,
        timer: 1500
    })
    <?php
            }
            ?>

});
</script>
<?php
}
?>