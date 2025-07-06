<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendemail extends CI_Controller
{
	function __Construct(){
			
			parent:: __Construct();
			
				$this->load->helper(array('form','url'));
				$this->load->library(array('session','email'));
		}
		public function mail()
		{
			//echo "reached";
			//exit();
			//$this->load->library('email'); 
	        $config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html'; // Append This Line
			$this->email->initialize($config);
			
			
			$senderid=$this->input->post('name');
			$sendername=$this->input->post('email');
			$sendermes=$this->input->post('message');
			

			
			$this->email->from($senderid);
			$this->email->to('saroj@ecopackservices.com');
			$this->email->subject('Email Query from Website');
            $a=$this->email->message($sendermes);
			
			if($this->email->send()){
				//print_r($a);
				//exit();
				//$this->session->set_flashdata('success','Email Send! We Will be in Touch Shortly');
                $this->session->set_userdata('send', '123');
				redirect('Contact');
				
			}
			else{

                $this->session->set_userdata('notsend', '123');
                redirect('Contact');
				//echo $this->email->print_debugger();
			}
		}
}
?>