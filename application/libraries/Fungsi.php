<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Fungsi {

    protected $ci;

    function __construct(){
        $this->ci =& get_instance();
        $this->ci->load->model('master_model');
    }

    function user_login() {
        $user_id = userId();
        $user_data = $this->ci->master_model->selectUsers($user_id)->row();
        return $user_data;
    }

    function group_login() {
        $group_id = groupId();
        $user_data = $this->ci->master_model->select_group($group_id)->row();
        return $user_data;
    }

    function pdfGenerator($html, $filename, $paper, $orientation) {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper($paper, $orientation);
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream($filename, array('Attachment' => 0));
    }

    // function pdfGenerator($html, $filename, $paper, $orientation) {
    //     // instantiate and use the dompdf class
    //     $dompdf = new Dompdf\Dompdf();
    //     $dompdf->loadHtml($html);
    //     // (Optional) Setup the paper size and orientation
    //     $dompdf->setPaper($paper, $orientation);
    //     // Render the HTML as PDF
    //     $dompdf->render();
    //     // Output the generated PDF to Browser
    //     $dompdf->stream($filename, array('Attachment' => 0));
    // }



}