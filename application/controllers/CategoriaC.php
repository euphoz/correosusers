<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CategoriaC extends CI_Controller {

    function __construct() {
        parent::__construct();  
            $this->load->helper('date');
            $this->load->model('CategoriasM');
            if (!$this->session->userdata("login")) {
            redirect(base_url());
        }
    }

 public function index(){

        $data['cat'] = $this->CategoriasM->lista();
        $this->load->view('redactar', $data);
     }
 
    }