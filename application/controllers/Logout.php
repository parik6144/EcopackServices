<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        // Load session library
        $this->load->library('session');
    }

    public function index()
    {
        // Destroy the session
        $this->session->sess_destroy();
        
        // Redirect to the specified URL after logout
        redirect('https://ecopackservices.com/welcome', 'refresh');
    }
}
?>
