<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

     function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $data['title']="About";
        $this->load->model('Mdl_setting');
    }

    public function index()
    {
        $data['newc']='about';

        $this->load->view('head',$data);
        $this->load->view('about');
        $this->load->view('foot');
    }
}