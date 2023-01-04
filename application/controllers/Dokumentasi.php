<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokumentasi extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model(masterModel());
        $this->load->library('fungsi');
        $this->load->library('form_validation');
    }

    public function index(){
        $this->template->load('template', 'setup/dokumentasi');
    }

}
