<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
// 	public function index()
// 	{
//         if($this->session->userdata('user_id') != '')
//         {
//             if($this->session->userdata('user_id') == '1')
//             {
//                 $month=date('m');
//                 $year=date('Y');
//                 redirect(base_url('dashboard?')."m=".$month."&y=".$year, 'refresh');
//             }
//             else
//                 redirect(base_url('dashboard'), 'refresh');
//         }
            
// 	    if(isset($_POST['login_email']) && isset($_POST['login_password']))
//         {
            
//             $this->load->model('mdl_login');
//             $record=$this->mdl_login->checklogin($this->input->post('login_email'),$this->input->post('login_password'));
//             if($record){
//             	$this->session->set_userdata('user_id', $record['0']['user_id']);
//             	$this->session->set_userdata('full_name', $record['0']['user_name']);
//                 if($this->session->userdata('user_id') == '1')
//                 {
//                     $month=date('m');
//                     $year=date('Y');
//                     redirect(base_url('dashboard?')."m=".$month."&y=".$year, 'refresh');
//                 }
//                 else
//                     redirect(base_url('dashboard'), 'refresh');
//             }
//             else{
//                 $response["error"]="Invalid User Name Or password";
//                 $this->load->view('login',$response);
//             }
//         }
//         /*else if(isset($_SESSION['active_user_id']))
//         {
//             redirect('dashboard');
//         }*/
//         else
//         {
//             $this->load->view('login');
//         }

// 	}

public function index()
	{ 
        $this->load->model('Mdl_setting');
        if($this->session->userdata('user_id')!= '')
        {
            if($this->session->userdata('user_id') == '1')
            {
                $month=date('m');
                $year=date('Y');
                redirect(base_url('dashboard?')."m=".$month."&y=".$year, 'refresh');
            }
            else
                redirect(base_url('dashboard'), 'refresh');
        }
            
	    if(isset($_POST['login_email']) && isset($_POST['login_password']))
        {
            $this->load->model('mdl_login');
            $record=$this->mdl_login->checklogin($this->input->post('login_email'),$this->input->post('login_password'));
            $Checkblock=$this->mdl_login->checkBlock($this->input->post('login_email'),$this->input->post('login_password'));
            if($record){
                if($Checkblock==0){
            	$this->session->set_userdata('user_id', $record['0']['user_id']);
            	$this->session->set_userdata('full_name', $record['0']['user_name']);
                if($this->session->userdata('user_id') == '1')
                {
                    $month=date('m');
                    $year=date('Y');
                    redirect(base_url('dashboard?')."m=".$month."&y=".$year, 'refresh');
                }
                else
                {
                    redirect(base_url('dashboard'), 'refresh');
                }}
                else
                {
                    $response["error"]="Credentials Blocked ! Contact Adminstrator.";
                    $this->load->view('login',$response);
                }
            }
            else
            {
                $response["error"]="Invalid User Name Or password";
                $this->load->view('login',$response);
            }
        }
        /*else if(isset($_SESSION['active_user_id']))
        {
            redirect('dashboard');
        }*/
        else
        {
            $this->load->view('login');
        }

	}
}
